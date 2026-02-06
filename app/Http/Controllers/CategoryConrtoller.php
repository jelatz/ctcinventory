<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryConrtoller extends Controller
{
    public function index()
    {
        return inertia('Categories');
    }
}
