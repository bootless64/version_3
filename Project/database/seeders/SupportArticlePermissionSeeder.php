<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SupportArticlePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permission = Permission::where('name', 'manage_articles')->where('guard_name', 'web')->first();

        if (! $permission) {
            return;
        }

        $support = Role::where('name', 'support')->first();

        if ($support) {
            $support->givePermissionTo($permission);
        }
    }
}
