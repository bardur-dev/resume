<?php


use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ProfileController;

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


});

require __DIR__.'/auth.php';
