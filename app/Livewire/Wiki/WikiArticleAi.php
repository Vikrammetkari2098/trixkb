<?php

namespace App\Livewire\Wiki;

use Livewire\Component;
use App\Models\Wiki;
use OpenAI\Laravel\Facades\OpenAI;
use Barryvdh\DomPDF\Facade\Pdf; // import PDF

class WikiArticleAi extends Component
{
    public $wikiId;
    public $article;
    public $aiResponse;
    public $userInput = '';
    public $loading = false;
    public $conversation = [];

    public function mount($wikiId)
    {
        $this->wikiId = $wikiId;
        $this->article = Wiki::find($wikiId);
    }

    public function generateAiResponse()
    {
        if (!$this->article) {
            $this->aiResponse = "Article not found.";
            return;
        }

        $this->loading = true;
        $this->aiResponse = null;

        $prompt = "You are an AI assistant for a Knowledge Base website.
        Based on this article titled '{$this->article->name}',
        content: \"{$this->article->description}\"
        Please summarize the content in 3 sentences and suggest 3 related topics.";

        try {
            $result = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful AI assistant for Wiki articles.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            $this->aiResponse = $result->choices[0]->message->content ?? 'No response found.';
        } catch (\Throwable $e) {
            $this->aiResponse = "⚠️ Error generating AI suggestions: " . $e->getMessage();
        }

        $this->loading = false;
    }

    public function askAi()
    {
        if (!$this->article) {
            $this->aiResponse = "Article not found.";
            return;
        }

        if (!$this->userInput) {
            $this->aiResponse = "Please type a question first.";
            return;
        }

        $this->loading = true;

        $messages = [
            ['role' => 'system', 'content' => 'You are a helpful AI assistant for Wiki articles.'],
            ['role' => 'user', 'content' => "Article title: {$this->article->name}\nContent: {$this->article->description}"],
            ['role' => 'user', 'content' => $this->userInput],
        ];

        try {
            $result = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => $messages,
            ]);

            $this->aiResponse = $result->choices[0]->message->content ?? 'No response found.';
            $this->conversation[] = [
                'question' => $this->userInput,
                'answer' => $this->aiResponse
            ];
        } catch (\Throwable $e) {
            $this->aiResponse = "⚠️ Error generating AI response: " . $e->getMessage();
        }

        $this->loading = false;
        $this->userInput = '';
    }

    // New method to download PDF
    public function downloadPdf()
    {
        if (!$this->aiResponse) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'No AI response to save!']);
            return;
        }

        $pdf = Pdf::loadView('pdf.wiki_ai', [
            'article' => $this->article,
            'aiResponse' => $this->aiResponse
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, $this->article->name . '_AI_Response.pdf');
    }

    public function closeModal()
    {
        $this->dispatch('close-ai-modal');
    }

    public function render()
    {
        return view('livewire.wiki.wiki-article-ai', [
            'conversation' => $this->conversation,
        ]);
    }
}
