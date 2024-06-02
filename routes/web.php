<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Resourceful route for chirps
Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

// Route for storing comments
Route::middleware('auth')->post('/chirps/{chirp}/comments', [CommentController::class, 'store'])
    ->name('comments.store');

// Route for deleting comments
Route::middleware('auth')->delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->name('comments.destroy');

// Route for showing individual chirps
Route::get('/chirps/{chirp}', [ChirpController::class, 'show'])
    ->name('chirps.show');

// Route for uploading images in chirps
Route::post('/chirps/upload', [ChirpController::class, 'upload'])
    ->name('chirps.upload');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
