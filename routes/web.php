<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeminarController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('seminar', SeminarController::class);
    Route::post('/seminar/{id}/bookmark', [SeminarController::class, 'toggleBookmark'])->name('seminar.bookmark');
    Route::get('/koleksi-saya', [SeminarController::class, 'myBookmarks'])->name('seminar.bookmarks');
});

require __DIR__.'/auth.php';
