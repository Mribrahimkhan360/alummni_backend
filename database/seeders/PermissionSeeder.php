<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'alumni-list',
            'alumni-create',
            'alumni-edit',
            'alumni-delete',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete',
            'job-list',
            'job-create',
            'job-edit',
            'job-delete',
            'payment-list',
            'payment-create',
            'payment-edit',
            'payment-delete',
            'payment-approve',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'sanctum']);
        }

        $this->command->info('Permissions seeded successfully.');
    }
}
