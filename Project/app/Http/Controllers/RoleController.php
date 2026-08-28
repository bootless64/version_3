<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\LoggingService;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }
    public function manageRoles()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $rolePermissions = $roles->mapWithKeys(
                fn($role) => [
                    $role->id => $role->permissions->pluck('name')->toArray(),
                ],
            )
            ->toArray();

        return view('dashboard.manage-roles', compact('roles', 'permissions', 'rolePermissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|regex:/^[a-zA-Z ]+$/|unique:roles,name,',
            'permissions' => 'sometimes|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);

        if (!empty($validated['permissions'])){
            $role->syncPermissions($validated['permissions']);
        }

        $this->logger->logRoleCreated($validated['name'], $validated['permissions'] ?? [], auth()->id());

        return back()->with('success', 'نقش جدید با موفقیت اضافه شد.');
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|regex:/^[a-zA-Z ]+$/|unique:roles,name,' . $role->id,
            'permissions' => 'sometimes|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $oldPermissions = $role->permissions->pluck('name')->toArray();
        $oldName = $role->name;

        $role->name = $validated['name'];
        $role->save();

        $role->syncPermissions($validated['permissions'] ?? []);

        $this->logger->logRolePermissionsUpdated($role->name, $oldPermissions, $validated['permissions'] ?? [], auth()->id());

        return back()->with('success', 'تغییرات نقش با موفقیت ذخیره شد.');
    }

    public function destroy(Role $role)
    {
        $users = User::role($role)->get();

        foreach ($users as $user) {
            $user->removeRole($role);
            $user->assignRole('user');
        }

        $this->logger->logRoleDeleted($role->name, auth()->id());

        $role->delete();

        return back()->with('success', 'نقش مورد نظر حذف شد.');
    }

}
