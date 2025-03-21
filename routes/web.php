<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LikeController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', [PostController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


use App\Http\Controllers\ConnectionController;

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/connections/{user}', [ConnectionController::class, 'sendConnectionRequest'])->name('connections.send');
    Route::post('/connections/{user}/accept', [ConnectionController::class, 'acceptConnectionRequest'])->name('connections.accept');
    Route::post('/connections/{user}/reject', [ConnectionController::class, 'rejectConnectionRequest'])->name('connections.reject');
    Route::get('/connections', [ConnectionController::class, 'getConnections'])->name('connections.index');

    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.myPosts');
    Route::resource('posts', PostController::class)->middleware('auth');

    Route::get('/posts/create/line', [PostController::class, 'createLine'])->name('posts.createLine');
    Route::post('/posts/store/line', [PostController::class, 'storeLine'])->name('posts.storeLine');

    Route::get('/posts/create/code', [PostController::class, 'createCode'])->name('posts.createCode');
    Route::post('/posts/store/code', [PostController::class, 'storeCode'])->name('posts.storeCode');

    Route::get('/posts/create/image', [PostController::class, 'createImage'])->name('posts.createImage');
    Route::post('/posts/store/image', [PostController::class, 'storeImage'])->name('posts.storeImage');

    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like')->middleware('auth');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Connections routes

Route::middleware(['auth'])->group(function () {
    Route::get('/connections', [ConnectionController::class, 'index'])->name('connections.index');
    Route::post('/connections/send/{user}', [ConnectionController::class, 'sendRequest'])->name('connections.send');
    Route::post('/connections/accept/{user}', [ConnectionController::class, 'acceptRequest'])->name('connections.accept');
    Route::post('/connections/reject/{user}', [ConnectionController::class, 'rejectRequest'])->name('connections.reject');
});

// Notification routes
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount']);
    Route::get('/notifications/latest', [NotificationController::class, 'getLatest']);
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});


// Messaging routes
Route::middleware('auth')->group(function () {

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/users', [MessageController::class, 'getUsers']);
    Route::get('/messages/conversation/{user}', [MessageController::class, 'getConversation']);
    Route::post('/messages/send/{user}', [MessageController::class, 'sendMessage']);
    Route::get('/messages/unread-count', [MessageController::class, 'getUnreadCount']);

});


require __DIR__ . '/auth.php';
