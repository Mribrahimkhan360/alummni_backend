<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return response()->json(Role::with('permissions')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        $role = Role::create([
            'name' => $request->name
        ]);

        return response()->json($role, 201);
    }

    public function show(Role $role)
    {
        return response()->json(
            $role->load('permissions')
        );
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id
        ]);

        $role->update([
            'name' => $request->name
        ]);

        return response()->json($role);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'message' => 'Role deleted successfully'
        ]);
    }

    public function assignPermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'required|array'
        ]);

        $role->syncPermissions(
            $request->permissions
        );

        return response()->json([
            'message' => 'Permissions assigned successfully'
        ]);
    }

    public function assignRoleToUser(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required'
        ]);

        $user->syncRoles([
            $request->role
        ]);

        return response()->json([
            'message' => 'Role assigned successfully'
        ]);
    }
}
