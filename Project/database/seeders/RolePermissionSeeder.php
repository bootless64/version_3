<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //نقش‌های پیش‌فرض
        $defaultRoles = ['admin', 'user', 'support'];
        foreach ($defaultRoles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        //پرمیشن‌های پایه
        $defaultPermissions = [
            ['name' => 'manage_users', 'fa_name' => 'مدیریت کاربران'],
            ['name' => 'manage_roles', 'fa_name' => 'مدیریت نقش‌ها'],
            ['name' => 'manage_projects', 'fa_name' => 'مدیریت پروژه‌ها'],
            ['name' => 'manage_news', 'fa_name' => 'مدیریت خبرها'],
            ['name' => 'manage_articles', 'fa_name' => 'مدیریت مقاله‌ها'],
            ['name' => 'manage_sliders', 'fa_name' => 'مدیریت اسلایدرها'],
            ['name' => 'manage_comments', 'fa_name' => 'مدیریت کامنت‌ها'],
            ['name' => 'manage_tickets', 'fa_name' => 'مدیریت تیکت‌ها'],
            ['name' => 'manage_logs', 'fa_name' => 'مدیریت لاگ‌های سیستم'],
            ['name' => 'manage_support_tickets', 'fa_name' => 'مدیریت تیکت‌های پشتیبانی'],
            ['name' => 'submit_news', 'fa_name' => 'ثبت خبر'],
            ['name' => 'submit_article', 'fa_name' => 'ثبت مقاله'],
        ];

        foreach ($defaultPermissions as $permName) {
            Permission::firstOrCreate(['name' => $permName['name'], 'fa_name'=> $permName['fa_name'], 'guard_name' => 'web']);
        }

        $defaultPermissionsNames = array_column($defaultPermissions, 'name');

        //دسترسی های مدیر
        $admin = Role::findByName('admin');
        $admin->syncPermissions($defaultPermissionsNames);

        //دسترسی های پشتیبان
        $support = Role::findByName('support');
        $support->syncPermissions(['manage_comments', 'manage_support_tickets']);

        //دسترسی های کاربر
        //..

    }

}
