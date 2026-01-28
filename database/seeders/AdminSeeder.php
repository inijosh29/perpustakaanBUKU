<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'perpus@gmail.com'],
            [
                'name' => 'adminperpus',
                'password' => Hash::make('Password123'),
                'role' => 'admin',
            ]
        );
    }
}
