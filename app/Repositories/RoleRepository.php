<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository
{
    /**
     * Create a new class instance.
     */

    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function getAllRoles()
    {
        return $this->role->all();
    }

    public function createRole(array $data): Role
    {
        return $this->role->create($data);
    }

    public function deleteRole($roleId): bool
    {
        $role = $this->role->find($roleId);
        if ($role) {
            return $role->delete();
        }
        return false;
    }
}
