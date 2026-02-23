<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home');
})->name('home');

// App Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Rooms Index
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');

});

// System information
Route::get('/version', [SystemController::class, 'version']);
Route::get('/info', [SystemController::class, 'info']);

// Privacy Policy
Route::get('/privacy-policy', [AboutController::class, 'privacyPolicy'])->name('privacy-policy');

require __DIR__.'/settings.php';
