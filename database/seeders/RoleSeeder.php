<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $superAdmin = Role::create(['name' => 'Super Admin', 'guard_name' => 'sanctum']);
        $admin = Role::create(['name' => 'Admin', 'guard_name' => 'sanctum']);
        $alumni = Role::create(['name' => 'Alumni', 'guard_name' => 'sanctum']);
        $student = Role::create(['name' => 'Student', 'guard_name' => 'sanctum']);

        $superAdmin->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'role-list', 'role-create',
            'permission-list', 'permission-create',
            'alumni-list', 'alumni-create', 'alumni-edit', 'alumni-delete',
            'event-list', 'event-create', 'event-edit', 'event-delete',
            'job-list', 'job-create', 'job-edit', 'job-delete',
        ]);

        $alumni->givePermissionTo([
            'user-list',
            'alumni-list',
            'event-list', 'event-create',
            'job-list', 'job-create',
        ]);

        $student->givePermissionTo([
            'alumni-list',
            'event-list',
            'job-list',
        ]);

        $this->command->info('Roles and permissions assigned successfully.');
    }
}
