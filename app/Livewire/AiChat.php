<?php

namespace App\Livewire;

use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;
use TallStackUi\Traits\Interactions;

class AiChat extends Component
{
    use Interactions;

    public array $messages = [];
    public string $input = '';

    protected $rules = [
        'input' => 'required|string|max:5000',
    ];

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function sendMessage()
    {
        $this->validate();

        $this->messages[] = [
            'sender' => 'user',
            'text' => $this->input
        ];

        $userText = $this->input;
        $this->reset('input');

        try {
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful AI assistant.'],
                    ...collect($this->messages)->map(fn ($msg) => [
                        'role' => $msg['sender'] === 'user' ? 'user' : 'assistant',
                        'content' => $msg['text']
                    ])->values()->toArray(),
                ],
            ]);

            $aiReply = $response->choices[0]->message->content ?? 'No response';

            $this->messages[] = [
                'sender' => 'ai',
                'text' => $aiReply,
            ];

        } catch (\Exception $e) {
            $this->toast()->error('AI Error', $e->getMessage())->send();
        }
    }
    public function render()
    {
        return view('livewire.ai-chat');
    }
}
