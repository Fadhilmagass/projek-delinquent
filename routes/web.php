<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Forum\CategoryController;
use App\Http\Controllers\ForumController; // Mengganti CategoryController

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Article Routes
    Route::resource('articles', ArticleController::class);
});

// Forum Routes
Route::prefix('forum')->name('forum.')->group(function () {
    // Halaman utama forum (misal: highlight, statistik, dsb)
    Route::get('/', [ForumController::class, 'index'])->name('index');

    // Daftar kategori forum (kalau mau dipisah dari index)
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    // Lihat semua thread dalam kategori tertentu
    Route::get('/categories/{category:slug}', [ThreadController::class, 'index'])->name('categories.show');

    // Buat thread (autentikasi wajib)
    Route::middleware('auth')->group(function () {
        Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');
        Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
        Route::get('/threads/{thread:slug}/edit', [ThreadController::class, 'edit'])->name('threads.edit');
        Route::patch('/threads/{thread:slug}', [ThreadController::class, 'update'])->name('threads.update');
        Route::delete('/threads/{thread:slug}', [ThreadController::class, 'destroy'])->name('threads.destroy');
    });
});

// Rute untuk lihat satu thread (di luar prefix agar URL-nya lebih clean)
Route::get('/threads/{thread:slug}', [ThreadController::class, 'show'])->name('threads.show');

// Public User Profile Route
Route::get('/users/{user:slug}', [ProfileController::class, 'show'])->name('users.show');

// User Follows/Following Routes
Route::get('/users/{user:slug}/followers', [ProfileController::class, 'followers'])->name('users.followers');
Route::get('/users/{user:slug}/following', [ProfileController::class, 'following'])->name('users.following');

require __DIR__ . '/auth.php';
