<?php

namespace App\Services;

use App\Repositories\RoleRepository;

class RoleService
{

    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAllRoles()
    {
        return $this->roleRepository->getAllRoles() ?? false;
    }


    public function createRole(array $data)
    {
        return $this->roleRepository->createRole($data);
    }
}
