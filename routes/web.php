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
    Route::post('/seminar/{id}/generate-ai', [SeminarController::class, 'generateAiModul'])->name('seminar.generate_ai');
    Route::get('/seminar/{id}/live-notulen', [SeminarController::class, 'liveNotulenPage'])->name('seminar.live');
    Route::post('/seminar/{id}/process-audio', [SeminarController::class, 'processAudio'])->name('seminar.process_audio');
});

Route::get('/cek-model', function () {
    $apiKey = env('GEMINI_API_KEY');
    $response = Illuminate\Support\Facades\Http::get('https://generativelanguage.googleapis.com/v1beta/models?key=' . $apiKey);
    return $response->json();
});

require __DIR__.'/auth.php';
