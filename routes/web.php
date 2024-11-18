<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', [UserController::class, 'homeHandler'])->middleware('auth')->name('home');
Route::get('/chat/{username}', [UserController::class, 'renderMessage'])->middleware('auth')->name('chat');
Route::post('/chat/{username}', [UserController::class, 'sendMessage'])->middleware('auth')->name('chat.send');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [UserController::class, 'loginHandler'])->name('login.handler');

Route::get('/register', function () {
    return view('register');
})->name('register.index');

Route::post('/register', [UserController::class, 'registerHandler'])->name('register.handler');

Route::get('/logout', [UserController::class, 'logoutHandler'])->name('logout');
