<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ConsultationPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // ساخت permission
        Permission::firstOrCreate(
            ['name' => 'manage_consultations', 'guard_name' => 'web'],
            ['fa_name' => 'مدیریت درخواست‌های مشاوره']
        );

        // اضافه کردن به نقش‌های admin و support (در صورت وجود)
        foreach (['admin', 'support'] as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->givePermissionTo('manage_consultations');
            }
        }
    }
}
