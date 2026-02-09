<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\HTTP\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryConrtoller;

Route::get('/', [AuthController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::get('/', 'index')->name('users.index');
    Route::put('/{user}', 'update')->name('users.update');
    Route::get('/export/excel', 'export')->name('users.export');
});

Route::controller(EmployeeController::class)->prefix('employees')->group(function () {
    Route::get('/', 'index')->name('employees.index');
    Route::put('/{employee}', 'update')->name('employees.update');
    Route::get('/export/excel', 'export')->name('employees.export');
});

Route::controller(AssetController::class)->prefix('assets')->group(function () {
    Route::get('/', 'index')->name('assets.index');
    Route::put('/{asset}', 'update')->name('assets.update');
    Route::get('/export/excel', 'export')->name('assets.export');
});

Route::controller(CategoryConrtoller::class)->prefix('categories')->group(function () {
    Route::get('/', 'index')->name('categories.index');
    Route::put('/{category}', 'update')->name('categories.update');
    Route::get('/export/excel', 'export')->name('categories.export');
});

Route::controller(AssignmentController::class)->prefix('assignments')->group(function () {
    Route::get('/', 'index')->name('assignments.index');
});

Route::controller(ReportController::class)->prefix('reports')->group(function () {
    Route::get('/', 'index')->name('reports.index');
});
