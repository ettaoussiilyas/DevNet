<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/profile', function () {
//    return view('profile');
//})->middleware(['auth', 'verified'])->name('profile');

Route::middleware(['auth'])->group(function () {

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


    Route::get('/profile/{user?}', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/{user}/connect', [ProfileController::class, 'connect'])->name('profile.connect');
});

require __DIR__.'/auth.php';
