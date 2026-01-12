<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\OpenSiteController;
use App\Http\Controllers\User\UserArticleController;
use App\Livewire\User\ArticleDetail;
use App\Http\Controllers\User\ArticlePreviewController;


Route::middleware(['auth'])
    ->prefix('articles')
    ->name('articles.')
    ->group(function () {
        Route::get('/', [OpenSiteController::class, 'index'])
            ->name('index');
    });

    Route::get('/article/{id}/preview', [ArticlePreviewController::class, 'show'])
    ->name('user.article.preview');

    Route::get('/article-list', [UserArticleController::class, 'index'])
        ->name('article.list');
    Route::get('/article/{slug}', ArticleDetail::class)->name('article.detail');

