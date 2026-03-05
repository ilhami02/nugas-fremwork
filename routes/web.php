<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\RatingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// =========================================================
// ini kusus atmint hehe
// =========================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Halaman Utama Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Manajemen Seminar (Create, Store, Edit, Update, Destroy)
    // Perhatikan: kita tetap menggunakan SeminarController untuk CRUD-nya
    Route::resource('seminar', AdminController::class)->except(['index', 'show']);

    // Fitur Live Notulen & AI Agent
    Route::post('/seminar/{id}/generate-ai', [AdminController::class, 'generateAiModulDummy'])->name('seminar.generate_ai');
    Route::get('/seminar/{id}/live-notulen', [AdminController::class, 'liveNotulenPage'])->name('seminar.live');
    Route::post('/seminar/{id}/process-audio', [AdminController::class, 'processAudio'])->name('seminar.process_audio');
});

// =========================================================
// ini rute untuk user biasa woi
// =========================================================
Route::middleware('auth')->group(function () {
    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/seminar/{id}/diskusi', [DiscussionController::class, 'store'])->name('diskusi.store');
    Route::post('/seminar/{id}/rating', [RatingController::class, 'store'])->name('rating.store');

    // Seminar (User HANYA bisa melihat daftar dan detail)
    Route::resource('seminar', SeminarController::class)->only(['index', 'show']);

    // Fitur Bookmark / Koleksi (Semua user bisa menyimpan koleksi)
    Route::post('/seminar/{id}/bookmark', [SeminarController::class, 'toggleBookmark'])->name('seminar.bookmark');
    Route::get('/koleksi-saya', [SeminarController::class, 'myBookmarks'])->name('seminar.bookmarks');
    });
    


Route::get('/cek-model', function () {
    $apiKey = env('GEMINI_API_KEY');
    $response = Illuminate\Support\Facades\Http::get('https://generativelanguage.googleapis.com/v1beta/models?key=' . $apiKey);
    return $response->json();
});

require __DIR__.'/auth.php';