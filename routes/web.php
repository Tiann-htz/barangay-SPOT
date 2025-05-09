<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// About page route
Route::get('/about', function () {
    return view('about');
})->name('about');

// Admin routes
Route::get('/admin/login', [AuthenticatedSessionController::class, 'adminLoginForm'])
    ->name('admin.login.form');
Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])
    ->name('admin.login');

// Admin protected routes
Route::middleware(['auth', 'can:admin-access'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Announcement routes
    Route::post('/admin/announcements', [AdminController::class, 'storeAnnouncement'])
        ->name('admin.announcements.store');
    Route::get('/admin/announcements/{announcement}/edit', [AdminController::class, 'editAnnouncement'])
        ->name('admin.announcements.edit');
    Route::put('/admin/announcements/{announcement}', [AdminController::class, 'updateAnnouncement'])
        ->name('admin.announcements.update');
    Route::delete('/admin/announcements/{announcement}', [AdminController::class, 'destroyAnnouncement'])
        ->name('admin.announcements.destroy');
});

// User routes
Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Trending posts route
Route::get('/trending', [PostController::class, 'trending'])
    ->middleware(['auth', 'verified'])
    ->name('trending');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Post routes
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
    
    // Comment routes
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

   // Chat routes
   Route::post('/chat/messages', [ChatMessageController::class, 'store'])->name('chat.messages.store');
   Route::get('/chat/messages/{chatMessage}/edit', [ChatMessageController::class, 'edit'])->name('chat.messages.edit');
   Route::put('/chat/messages/{chatMessage}', [ChatMessageController::class, 'update'])->name('chat.messages.update');
   Route::delete('/chat/messages/{chatMessage}', [ChatMessageController::class, 'destroy'])->name('chat.messages.destroy');


});

require __DIR__.'/auth.php';