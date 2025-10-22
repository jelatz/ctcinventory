<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $userService;

    public function __contstruct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return Inertia::render('Roles/Index');
    }

    public function changePassword(Request $request)
    {
        dd($request->all());
    }

    public function updateProfile(Request $request)
    {
        dd($request->all());
    }
}
