<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('posts/findbyuser', [App\Http\Controllers\Api\PostsController::class, 'findByUser'])->name('api.posts.findbyuser');

    Route::apiResource('posts', App\Http\Controllers\Api\PostsController::class)->names('api.posts');
});


Route::apiResource('profile', App\Http\Controllers\Api\ProfileController::class)->names('api.profile');
