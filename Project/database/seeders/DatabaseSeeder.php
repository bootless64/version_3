<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DelegatePermissionSeeder extends Seeder
{
    public function run()
    {
        // پیدا کردن نقش delegate
        $delegateRole = Role::where('name', 'delegate')->first();

        if ($delegateRole) {
            // پیدا کردن permission manage_support_tickets
            $permission = Permission::where('name', 'manage_support_tickets')->first();

            if ($permission) {
                // اختصاص permission به نقش delegate
                $delegateRole->givePermissionTo($permission);
                $this->command->info('Permission manage_support_tickets assigned to delegate role successfully.');
            } else {
                $this->command->error('Permission manage_support_tickets not found!');
            }
        } else {
            $this->command->error('Role delegate not found!');
        }
    }
}