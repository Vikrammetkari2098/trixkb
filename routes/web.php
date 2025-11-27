<?php
use App\Http\Controllers\FeedbackManagerController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DecisionTreeController;
use App\Http\Controllers\ApiDocsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Auth\ForgotPasswordForm;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\KnowledgePulseController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\DriveController;
use App\Http\Controllers\SettingsController;

Route::get('/reset-password', [ResetPasswordController::class, 'index'])->name('password.reset');
Route::get('/forgot-password', ForgotPasswordForm::class)->name('password.request');



Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/login', function () {
    return view('signin');
})->name('login');
Route::middleware(['auth'])->group(function () {
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'show'])->name('dashboard');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/docs', [DocumentController::class, 'show'])->name('docs');
    Route::get('/decision-tree', [DecisionTreeController::class, 'index'])->name('decision.tree');
    Route::get('/api-docs', [ApiDocsController::class, 'index'])->name('api.docs');
    Route::get('/feedback', [FeedbackManagerController::class, 'index'])->name('feedback.manager');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/knowledge-pulse', [KnowledgePulseController::class, 'index'])->name('knowledge.pulse');
    Route::get('/widget', [WidgetController::class, 'index'])->name('widget');
    Route::get('/drive', [DriveController::class, 'index'])->name('drive');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

});


















Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile');
});



















Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');
});

Route::get('/forgot-password', function () {
    return view('forgot-password');
})->name('password.request');
