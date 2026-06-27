<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
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
        $admin->assignRole('Super Admin');

        $student = User::updateOrCreate(
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
        $student->assignRole('Student');

        $alumni = User::updateOrCreate(
            ['email' => 'alumni@example.com'],
            [
                'name' => 'Alumni User',
                'student_id' => 'ALU001',
                'passing_year' => 2018,
                'department' => 'Electrical Engineering',
                'gender' => 'female',
                'password' => Hash::make('password'),
            ]
        );
        $alumni->assignRole('Alumni');

        $this->command->info('Users created with roles successfully.');
    }
}
