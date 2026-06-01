<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Ngafein',
                'password' => Hash::make('pass123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'mahasiswa@gmail.com'],
            [
                'name' => 'Mahasiswa Ngafein',
                'password' => Hash::make('pass123'),
                'role' => 'mahasiswa',
            ]
        );
    }
}
