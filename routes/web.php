<?php
use App\Http\Controllers\DirectoryController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Auth\ForgotPasswordForm;
use App\Http\Controllers\ResetPasswordController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WikiController;
use App\Http\Controllers\NewDashboardController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\MinistryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TestDashboardController;
use App\Http\Controllers\DocumentController;

Route::get('/reset-password', [ResetPasswordController::class, 'index'])->name('password.reset');
Route::get('/forgot-password', ForgotPasswordForm::class)->name('password.request');

Route::middleware(['auth'])->group(function () {
    Route::get('/newdashboard', [NewDashboardController::class, 'show'])->name('newdashboard');
});
Route::middleware(['auth'])->prefix('meetings')->group(function () {
    Route::get('/', [MeetingController::class, 'show'])->name('meetings');
});
Route::middleware(['auth'])->prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'show'])->name('tasks');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/organisation/matrix', [OrganisationController::class, 'indexContentCreator'])
        ->name('users.matrix');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/users/{team:slug}/{user:slug}/tickets', [UserController::class, 'getTickets'])
        ->name('users.tickets');
});Route::middleware(['auth'])->group(function () {
    Route::get('/users/{team:slug}/{user:slug}/tickets', [UserController::class, 'getTickets'])
    ->name('users.tickets');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/users/{team:slug}/{user:slug}/chatbot',
        [ChatbotController::class, 'showUserChatbot']
    )->name('users.chatbot');

    Route::get('/users/{team:slug}/chatbots/{chatbot:slug}',
        [ChatbotController::class, 'showChatbot']
    )->name('chatbot.show');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/users/{team:slug}/{user:slug}/notaPKP',
        [UserController::class, 'notaPKP']
    )->name('users.notaPKP');
});

Route::middleware(['auth'])->group(function () {
    // Directory Upload
    Route::get('/users/{team:slug}/{user:slug}/upload',
        [UserController::class, 'getUpload']
    )->name('users.directoryUpload');

    // Chatbot Upload
    Route::get('/users/{team:slug}/{user:slug}/chatbotUpload',
        [UserController::class, 'getUploadChatbot']
    )->name('users.chatbotUpload');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users/{team:slug}/{user:slug}/reportings',
        [ReportsController::class, 'show']
    )->name('reports.reportings');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('{team:slug}/settings/ministry')->group(function () {
        Route::get('', [MinistryController::class, 'index'])->name('ministry.index');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('{team:slug}/settings/department')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('department.index');
    });
});
Route::middleware(['auth'])->group(function () {
    Route::prefix('{team:slug}/settings/segment')->group(function () {
        Route::get('/', [SegmentController::class, 'index'])->name('segment.index');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/spaces', [SpaceController::class, 'show'])->name('spaces.index');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/users/{team}/{user}/wikies', [WikiController::class, 'show'])
        ->name('users.wikies');
    Route::get('/users/{team:slug}/{user:slug}/directory', [DirectoryController::class, 'show'])
        ->name('users.directory');
});
Route::middleware(['auth'])->prefix('wikis')->group(function () {
    Route::get('/show', [WikiController::class, 'show'])->name('wikis.show');
});

Route::middleware(['auth'])->prefix('teams')->group(function () {
    Route::get('/', [TeamController::class, 'show'])->name('teams');
});
Route::middleware(['auth'])->prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'show'])->name('roles');
});

Route::middleware(['auth'])->prefix('members')->group(function () {
    Route::get('/', [MemberController::class, 'show'])->name('members');
});
Route::middleware(['auth'])->prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/index/{id}', [ProjectController::class, 'index'])->name('project.index');
});







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
