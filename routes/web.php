<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home');
})->name('home');

// App Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::view('dashboard', 'app.dashboard')->name('dashboard');

});

// System information
Route::get('/version', [SystemController::class, 'version']);
Route::get('/info', [SystemController::class, 'info']);

// Privacy Policy
Route::get('/privacy-policy', [AboutController::class, 'privacyPolicy'])->name('privacy-policy');

require __DIR__.'/settings.php';
