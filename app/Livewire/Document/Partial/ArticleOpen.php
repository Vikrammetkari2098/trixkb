<?php

namespace App\Livewire\Document\Partial;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use TallStackUi\Traits\Interactions;

use App\Models\Article;
use App\Models\ArticleVersion;

class ArticleOpen extends Component
{
    use Interactions, WithFileUploads;

    /* ---------------- Properties ---------------- */
    public $articleId;
    public $title;
    public $content = [];
    public $status = 'draft'; // default
    public $editorImage;

    /* ---------------- Validation ---------------- */
    protected $rules = [
        'title' => 'required|string|max:255',
    ];

    /* ---------------------------------
     | Load article + current version
     |---------------------------------*/
    #[On('openArticle')]
    public function loadArticleData(int $id): void
    {
        $article = Article::with('currentVersion')->find($id);
        if (!$article) return;

        $this->articleId = $article->id;
        $this->title     = $article->title;
        $this->content   = $article->currentVersion?->content ?? [];
        $this->status    = $article->currentVersion?->status ?? 'draft';

        $this->dispatch('article-loaded', [
            'title'   => $this->title,
            'content' => $this->content,
        ]);
    }

    /* ---------------------------------
     | Save article + content + versioning
     |---------------------------------*/
    public function save(array $editorData = null, string $status = null): void
    {
        $this->validate();

        try {
            DB::transaction(function () use ($editorData, $status) {

                $article = Article::findOrFail($this->articleId);
                $current = $article->currentVersion;

                // Normalize incoming values
                $newStatus  = $status ?? $current?->status ?? 'draft';
                $newContent = empty($editorData) ? null : $editorData;

                $oldStatus  = $current?->status ?? 'draft';
                $oldContent = $current?->content;

                // Detect real changes (NULL SAFE)
                $statusChanged  = $oldStatus !== $newStatus;
                $contentChanged = json_encode($oldContent) !== json_encode($newContent);

                /**
                 * CASE 1: First ever save
                 * draft + null content → create 1.0 ONCE
                 */
                if (!$current) {
                    $version = ArticleVersion::create([
                        'article_id' => $article->id,
                        'editor_id'  => auth()->id(),
                        'version'    => '1.0',
                        'content'    => null,
                        'status'     => 'draft',
                        'views'      => 0,
                        'likes'      => 0,
                        'is_current' => true,
                    ]);

                    $article->update(['current_version_id' => $version->id]);
                    return;
                }

                /**
                 * CASE 2: No meaningful change → do nothing
                 */
                if (!$statusChanged && !$contentChanged) {
                    return;
                }

                /**
                 * CASE 3: Status or content changed → new version
                 */
                $newVersion = $this->getNextVersion($current->version);
                // Mark previous version inactive
                $current->update(['is_current' => false]);
                DB::enableQueryLog();
                // Create new version
                $version = ArticleVersion::create([
                    'article_id' => $article->id,
                    'editor_id'  => auth()->id(),
                    'version'    => $newVersion,
                    'content'    => $newContent,
                    'status'     => $newStatus
                ]);
                $query = DB::getQueryLog();
                $lastQuery = end($query);

                $sql = $lastQuery['query'];

                foreach ($lastQuery['bindings'] as $binding) {
                    $binding = is_numeric($binding) ? $binding : "'".addslashes($binding)."'";
                    $sql = preg_replace('/\?/', $binding, $sql, 1);
                }

                $query = DB::getQueryLog();
                echo $sql;exit;
                echo  $version->id;exit;

                $article->update([
                    'current_version_id' => $version->id,
                ]);
            });

            $this->toast()->success('Success', 'Article saved successfully')->send();

        } catch (\Throwable $e) {
            $this->toast()->error('Error', $e->getMessage())->send();
        }
    }


    /**
     * Generate next version number, e.g., '1.0' -> '1.1'
     */
   private function getNextVersion(string $currentVersion): string
    {
        return number_format(((float) $currentVersion) + 0.1, 1, '.', '');
    }




    /* ---------------------------------
     | EditorJS image upload
     |---------------------------------*/
    public function updatedEditorImage(): void
    {
        $this->validate([
            'editorImage' => 'image|max:10240', // 10MB
        ]);
    }

    public function saveEditorImage(): ?string
    {
        if (!$this->editorImage) return null;

        $path = $this->editorImage->store('articles', 'public');

        return asset('storage/' . $path);
    }

    /* ---------------------------------
     | Render
     |---------------------------------*/
    public function render()
    {
        return view('livewire.document.partial.article-open', [
            'statuses' => ['draft', 'in_review', 'published', 'archived'],
        ]);
    }
}
