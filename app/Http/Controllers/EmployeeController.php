<?php

namespace App\HTTP\Controllers;

class EmployeeController extends Controller
{
    public function index()
    {
        return inertia('Users/Employees');
    }
}
