<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up()
    {
        $permission = Permission::firstOrCreate([
            'name' => 'manage_settings',
            'fa_name' => 'مدیریت تنظیمات',
            'guard_name' => 'web',
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permission);
        }

        $supportRole = Role::where('name', 'support')->first();
        if ($supportRole) {
            $supportRole->givePermissionTo($permission);
        }
    }

    public function down()
    {
        $permission = Permission::where('name', 'manage_settings')->first();
        if ($permission) {
            $permission->delete();
        }
    }
};