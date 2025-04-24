<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // cek apakah user sudah ada
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'), // ganti jika ingin lebih aman
                'role' => 'admin',
                'departemen_id' => null,
                'email_verified_at' => now(),
            ]
        );
    }
}
