<?php


namespace App\Repositories;

use App\Models\User;

class ProfileRepository
{
    public function getUserProfile($userId)
    {
        return User::find($userId);
    }

    public function updateUserProfile($userId, $data)
    {
        $user = User::find($userId);
        $user->update($data);
        return $user;
    }
}
