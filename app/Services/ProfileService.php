<?php

namespace App\Services;

use App\Repositories\ProfileRepository;

class ProfileService
{
    protected $profileRepository;

    public function __construct($profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }
}
