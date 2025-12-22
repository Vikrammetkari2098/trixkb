<?php

namespace App\Livewire\Document\Partial;

use Livewire\Component;
use App\Models\Article;
use App\Models\ArticleVersion;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Str;

class ArticleOpen extends Component
{
    use Interactions;

    public ?int $articleId = null;
    public string $title = '';
    public array $content = [];

    protected $rules = [
        'title' => 'required|string|max:255',
    ];

    /* ---------------------------------
     | Load article + version content
     |---------------------------------*/
    #[On('openArticle')]
    public function loadArticleData(int $id): void
    {
        $article = Article::with('currentVersion')->find($id);

        if (! $article) {
            return;
        }

        $this->articleId = $article->id;
        $this->title     = $article->title;
        $this->content   = $article->currentVersion?->content ?? [];

        // Send data to EditorJS
        $this->dispatch('article-loaded', [
            'title'   => $this->title,
            'content' => $this->content,
        ]);
    }

    /* ---------------------------------
     | Save article (NEW VERSION)
     |---------------------------------*/
    public function save(array $editorData): void
    {
        $this->validate();

        try {
            DB::transaction(function () use ($editorData) {

                $article = Article::findOrFail($this->articleId);

                // 1️⃣ Update article meta (NO content here)
                $article->update([
                    'title' => $this->title,
                    'slug'  => Str::slug($this->title),
                ]);

                // 2️⃣ Create new version with content
                $version = ArticleVersion::create([
                    'article_id'   => $article->id,
                    'editor_id'    => auth()->id(),
                    'content'      => $editorData, // ✅ CORRECT
                    'status'       => $article->status,
                    'is_featured'  => $article->is_featured ?? false,
                    'views'        => 0,
                    'likes'        => 0,
                    'published_at' => now(),
                ]);

                // 3️⃣ Point article to latest version
                $article->update([
                    'current_version_id' => $version->id,
                ]);
            });

            $this->dispatch('refresh-articles-list');

            $this->toast()
                ->success('Success', 'Article updated successfully')
                ->send();

        } catch (\Throwable $e) {
            $this->toast()
                ->error('Error', $e->getMessage())
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.document.partial.article-open');
    }
}
