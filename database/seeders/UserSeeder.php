<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Platform Admin',
            'email' => 'admin@belidongbos.com',
            'role' => 'platform',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
    }
}
