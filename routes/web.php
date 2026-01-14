<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('Home');
});

Route::get('/', function () {
    return Inertia::render('Home');
});
