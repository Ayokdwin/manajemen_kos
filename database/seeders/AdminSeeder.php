<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Kos',
            'email'    => 'admin@kos.com',
            'password' => Hash::make('12345678'),
            'role'     => 'admin',
            'no_hp'    => '081234567890',
        ]);
    }
}
