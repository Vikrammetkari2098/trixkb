<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Article;
use App\Models\ArticleVersion;
use App\Models\ArticleComment;
use App\Models\ArticleLike;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions;

class ArticleDetail extends Component
{    
    use Interactions;

    public $article; 
    public $articleContent = []; 
    public $comments;
    public $newComment;
    public $replyText = [];
    public $showReplyForm = null;
    public $commentCount = 0;
    
    public $likeCount = 0;
    public $hasLiked = false;

    public $showAllComments = false;

    
    public $editingCommentId = null;
    public $editingCommentText = '';

    public function mount($slug)
    {
        $this->article = Article::with(['author', 'currentVersion'])
            ->where('slug', $slug)
            ->firstOrFail();

        if ($this->article->currentVersion) {
            $this->article->version_id = $this->article->currentVersion->id;
            
            $rawContent = $this->article->currentVersion->content;
            $this->articleContent = is_string($rawContent) ? json_decode($rawContent, true) : $rawContent;

            $this->likeCount = ArticleLike::where('article_id', $this->article->id)->count();
        }

        if (Auth::check()) {
            $this->hasLiked = ArticleLike::where('article_id', $this->article->id)
                ->where('user_id', Auth::id())
                ->exists();
        }

        $this->loadComments();
    }

    public function toggleLike()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        $articleId = $this->article->id;

        if ($this->hasLiked) {
            // UnLike Logic
            ArticleLike::where('article_id', $articleId)
                ->where('user_id', $userId)
                ->delete();
            
            $this->hasLiked = false;
        } else {
            // Like Logic
            ArticleLike::create([
                'article_id' => $articleId,
                'user_id' => $userId,
                'ip_address' => request()->ip(),
                'created_at' => now()
            ]);

            $this->hasLiked = true;
        }

        $this->likeCount = ArticleLike::where('article_id', $articleId)->count();
    }

    public function loadComments()
    {
        $query = ArticleComment::with(['user', 'replies'])
            ->where('article_id', $this->article->id)
            ->whereNull('parent_id')
            ->latest();

        $this->commentCount = ArticleComment::where('article_id', $this->article->id)
            ->whereNull('parent_id')
            ->count();

        if (!$this->showAllComments) {
            $query->take(3);
        }

        $this->comments = $query->get();
    }

    public function toggleCommentsView()
    {
        $this->showAllComments = !$this->showAllComments;
        $this->loadComments();
    }

    public function postComment($parentId = null)
    {
        $text = $parentId ? ($this->replyText[$parentId] ?? '') : $this->newComment;
        if (empty(trim($text)) || !Auth::check()) return;

        ArticleComment::create([
            'article_id'  => $this->article->id,
            'user_id'     => Auth::id(),
            'parent_id'   => $parentId,
            'comment'     => trim($text),
            'is_approved' => 1,
            'created_at'  => now(),
        ]);

        $this->reset(['newComment', 'showReplyForm', 'replyText']);
        
        if (!$parentId) {
            $this->showAllComments = true;
        }
         $this->toast()
            ->success('Success', 'Comment posted successfully')
            ->send();

        $this->loadComments();
    }

    public function toggleReplyForm($commentId)
    {
        $this->showReplyForm = ($this->showReplyForm === $commentId) ? null : $commentId;
    }

    

    public function editComment($commentId)
    {
        $comment = ArticleComment::find($commentId);
        if (!$comment || $comment->user_id !== Auth::id()) return;

        $this->editingCommentId = $commentId;
        $this->editingCommentText = $comment->comment;
    }

    public function cancelEdit()
    {
        $this->editingCommentId = null;
        $this->editingCommentText = '';
    }

    public function updateComment()
    {
        $comment = ArticleComment::find($this->editingCommentId);
        if (!$comment || $comment->user_id !== Auth::id()) return;

        $this->validate(['editingCommentText' => 'required|string']);

        $comment->update(['comment' => $this->editingCommentText]);

        $this->cancelEdit();
        $this->loadComments();
        $this->toast()
            ->success('Updated', 'Comment updated successfully')
            ->send();
    }

    public function deleteComment($commentId)
    {
        $comment = ArticleComment::find($commentId);
        if (!$comment || $comment->user_id !== Auth::id()) return;

        $comment->replies()->delete(); 
        $comment->delete();

        $this->loadComments();
    }

    // ---------------------------------

    public function shareArticle()
    {
        $this->dispatch('copy-to-clipboard', url: url()->current());
    }

    public function render()
    {
        return view('livewire.user.article-detail')->layout('layouts.user-layout');
    }
}