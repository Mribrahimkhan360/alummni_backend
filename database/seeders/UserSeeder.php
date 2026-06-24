<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'student_id' => 'ADMIN001',
                'passing_year' => 2020,
                'department' => 'Administration',
                'gender' => 'male',
                'password' => Hash::make('password'),
            ]
        );

        // Student User
        User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student',
                'student_id' => 'STU001',
                'passing_year' => 2024,
                'department' => 'Computer Science',
                'gender' => 'male',
                'password' => Hash::make('password'),
            ]
        );

        $this->command->info('Admin and Student users created successfully.');
    }
}