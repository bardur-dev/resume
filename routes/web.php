<?php


use App\Http\Controllers\AdminPromptController;
use App\Http\Controllers\AdminResumeController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\ResumeController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;



Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('experience.create');
    })->name('dashboard');

    Route::get('/experience/create', [ExperienceController::class, 'create'])->name('experience.create');
    Route::post('/experience/store', [ExperienceController::class, 'store'])->name('experience.store');
    Route::post('/resume/generate', [ExperienceController::class, 'generateResume'])->name('resume.generate');
    Route::delete('/experience/clear', [ExperienceController::class, 'clear'])->name('experience.clear');
    Route::post('/upload-avatar', [ExperienceController::class, 'updateAvatar'])->name('upload.avatar');
    Route::get('/my-resumes', [ResumeController::class, 'index'])
        ->name('user.resumes.index');
    Route::get('/my-resumes/{resume}/edit', [ResumeController::class, 'edit'])
        ->name('user.resumes.edit');
    Route::put('/my-resumes/{resume}', [ResumeController::class, 'update'])
        ->name('user.resumes.update');

    Route::prefix('admin')->group(function () {
        Route::get('/resumes', [AdminResumeController::class, 'index'])
            ->name('admin.resumes.index');

        Route::get('/resumes/{resume}/download', [AdminResumeController::class, 'download'])
            ->name('admin.resumes.download');

        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('admin.users.index');

        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])
            ->name('admin.users.edit');

        Route::put('/users/{user}', [AdminUserController::class, 'update'])
            ->name('admin.users.update');
        Route::get('/prompts', [AdminPromptController::class, 'edit'])
            ->name('admin.prompts.edit')
            ->middleware('can:edit-prompt'); // Защита политикой

        Route::put('/prompts', [AdminPromptController::class, 'update'])
            ->name('admin.prompts.update')
            ->middleware('can:edit-prompt');
    });

});


require __DIR__.'/auth.php';
