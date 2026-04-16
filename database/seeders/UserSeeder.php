<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(3)->sequence(
            [
                'role' => 'USER',
                'email' => 'user@example.com',
                'password' => 'password'
            ],
            [
                'role' => 'ADMIN',
                'email' => 'admin@example.com',
                'password' => 'password'
            ],
            [
                'role' => 'SUPERADMIN',
                'email' => 'superadmin@example.com',
                'password' => 'password'
            ],
        )->create();
    }
}
