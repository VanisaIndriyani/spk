<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['username' => 'admin'],
            [
                'full_name' => 'Admin Desa',
                'role' => 'admin',
                'password' => bcrypt('admin123'),
            ]
        );

        User::query()->updateOrCreate(
            ['username' => 'kades'],
            [
                'full_name' => 'Kepala Desa',
                'role' => 'kepala_desa',
                'password' => bcrypt('kades123'),
            ]
        );
    }
}
