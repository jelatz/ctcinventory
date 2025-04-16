<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'string|required',
            'password' => 'string|required',
        ]);
        $user = $this->authRepository->findByUsername($validated['username']);
        if ($user && Hash::check($validated['password'], $user->password)) {
            Auth::login($user);
            return true;
        }
        return false;
    }
}
