<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/profile', App\Http\Controllers\ProfileController::class)->middleware('auth:web')->names('profile')->only([
    'index',
    'edit',
    'destroy'
]);
