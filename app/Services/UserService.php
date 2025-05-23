<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'string|required',
            'password' => 'string|required',
        ]);
        $user = $this->userRepository->findByUsername($validated['username']);
        // if ($user && Hash::check($validated['password'], $user->password)) {
        if (Auth::login($user)) {
            return true;
        }
        // }
        return false;
    }
}
