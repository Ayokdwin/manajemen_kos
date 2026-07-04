<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@kos.com',
            'password' => Hash::make('password'),
            'no_hp' => '081111111111',
            'role' => 'admin',
        ]);

        $users = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'no_hp' => '081234567801',
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@gmail.com',
                'no_hp' => '081234567802',
            ],
            [
                'name' => 'Rina Putri',
                'email' => 'rina@gmail.com',
                'no_hp' => '081234567803',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@gmail.com',
                'no_hp' => '081234567804',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@gmail.com',
                'no_hp' => '081234567805',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@gmail.com',
                'no_hp' => '081234567806',
            ],
            [
                'name' => 'Rizky Ramadhan',
                'email' => 'rizky@gmail.com',
                'no_hp' => '081234567807',
            ],
            [
                'name' => 'Putri Amelia',
                'email' => 'putri@gmail.com',
                'no_hp' => '081234567808',
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajar@gmail.com',
                'no_hp' => '081234567809',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password'),
                'no_hp' => $user['no_hp'],
                'role' => 'user',
            ]);
        }
    }
}
