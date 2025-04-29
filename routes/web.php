<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Hash;

// Route::inertia('/', 'Home')->name('home');
// echo bcrypt('admin123');
Route::middleware('guest')->group(function () {
    Route::inertia('/', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/item-category', [CategoryController::class, 'itemCategory'])->name('category.item');
    Route::get('/brands', [CategoryController::class, 'showBrands'])->name('category.brands');
    Route::get('/suppliers', [CategoryController::class, 'showSupplier'])->name('category.supplier');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/item-assignment', [TransactionController::class, 'itemAssignment'])->name('items.assignment');
    Route::get('/item-return', [TransactionController::class, 'itemReturn'])->name('items.return');
    Route::get('/item-transfer', [TransactionController::class, 'itemTransfer'])->name('items.transfer');
    Route::get('/item-disposal', [TransactionController::class, 'itemDisposal'])->name('items.disposal');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change.password');
    Route::post('/update-profile', [ProfileController::class, 'updateProfile'])->name('update.profile');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
