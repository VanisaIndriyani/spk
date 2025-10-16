<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('username','admin')->exists()) {
            User::create([
                'username' => 'admin',
                'full_name' => 'Admin Desa',
                'role' => 'admin',
                'password' => 'admin123',
            ]);
        }
        if (!User::where('username','kades')->exists()) {
            User::create([
                'username' => 'kades',
                'full_name' => 'Kepala Desa',
                'role' => 'kepala_desa',
                'password' => 'kades123',
            ]);
        }
    }
}