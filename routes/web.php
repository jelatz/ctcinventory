<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\Transaction\TransactionController;

// Route::inertia('/', 'Home')->name('home');

Route::middleware('guest')->group(function () {
    Route::inertia('/', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/item-assignment', [TransactionController::class, 'itemAssignment'])->name('items.assignment');
    Route::get('/item-return', [TransactionController::class, 'itemReturn'])->name('items.return');
    Route::get('/item-transfer', [TransactionController::class, 'itemTransfer'])->name('items.transfer');
    Route::get('/item-disposal', [TransactionController::class, 'itemDisposal'])->name('items.disposal');

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});
