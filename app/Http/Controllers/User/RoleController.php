<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        return Inertia::render('Roles/Index', [
            'roles' => $this->roleService->getAllRoles(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'roleDescription' => 'nullable|string|max:500',
        ]);

        $this->roleService->createRole([
            'name' => $request->role,
            'description' => $request->roleDescription,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function update(Request $request, $roleId)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'roleDescription' => 'nullable|string|max:500',
        ]);

        $this->roleService->updateRole($roleId, [
            'name' => $request->role,
            'description' => $request->roleDescription,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($roleId)
    {
        $this->roleService->deleteRole($roleId);

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
