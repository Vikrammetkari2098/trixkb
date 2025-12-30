<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticlePreviewController extends Controller
{
    public function show(int $id)
    {
        $article = Article::with('currentVersion')->findOrFail($id);

        return view('user.article-preview', [
            'article' => $article,
            'content' => $article->currentVersion?->content ?? [],
        ]);
    }
}
