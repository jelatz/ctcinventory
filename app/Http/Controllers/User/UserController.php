<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return Inertia::render('Users/Index', [
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:users,email',
            'profile_picture' => 'nullable|image|max:2048',
            'username' => 'required|string|max:255|unique:users,username',
            'is_active' => 'boolean',
            'real_name' => 'required|string|max:255',
        ]);

        $password = bin2hex(random_bytes(8)); // 16 characters long alphanumeric string
        $data['password'] = $password;
        // Store original password temporarily to show or email to user if needed

        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $data['is_active'] ?? false;

        // Create user logic here
        // ...

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
}
