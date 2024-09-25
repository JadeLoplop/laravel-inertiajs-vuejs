<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return inertia('app');
})->name('app');

Route::resource('posts', PostController::class)->only(['index', 'show', 'destroy']);
Route::resource('users', UserController::class)->only(['index', 'destroy']);
