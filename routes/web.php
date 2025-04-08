<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\UserController;

// Route::inertia('/', 'Home')->name('home');

Route::middleware('guest')->group(function () {
    Route::inertia('/', 'Login')->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('login.post');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});
