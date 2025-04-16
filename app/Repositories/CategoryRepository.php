<?php


namespace App\Repositories;

use App\Models\User;

class CategoryRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function findByUsername($username)
    {
        return User::where('username', $username)->first();
    }
}
