<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SupportExtraPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $support = Role::where('name', 'support')->first();

        if (! $support) {
            return;
        }

        $support->givePermissionTo([
            'manage_users',
            'manage_projects',
            'manage_news',
        ]);
    }
}
