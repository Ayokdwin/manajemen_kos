<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\DB;


class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Pengaduan::truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $pengaduans = [

            [
                'user_id' => 2,
                'kamar_id' => 1,
                'judul' => 'Lampu kamar mati',
                'diskripsi' => 'Lampu utama di kamar tidak dapat menyala sejak tadi malam.',
                'status' => 'pending',
            ],

            [
                'user_id' => 3,
                'kamar_id' => 2,
                'judul' => 'Keran bocor',
                'diskripsi' => 'Keran kamar mandi terus menetes dan menyebabkan lantai basah.',
                'status' => 'diproses',
            ],

            [
                'user_id' => 4,
                'kamar_id' => 4,
                'judul' => 'AC tidak dingin',
                'diskripsi' => 'AC menyala tetapi tidak mengeluarkan udara dingin.',
                'status' => 'selesai',
            ],

            [
                'user_id' => 5,
                'kamar_id' => 5,
                'judul' => 'WiFi lambat',
                'diskripsi' => 'Kecepatan internet menurun terutama pada malam hari.',
                'status' => 'pending',
            ],

            [
                'user_id' => 6,
                'kamar_id' => 7,
                'judul' => 'Kunci pintu rusak',
                'diskripsi' => 'Kunci sulit diputar dan terkadang macet.',
                'status' => 'diproses',
            ],

            [
                'user_id' => 7,
                'kamar_id' => 8,
                'judul' => 'Kipas angin berisik',
                'diskripsi' => 'Kipas mengeluarkan suara cukup keras saat digunakan.',
                'status' => 'pending',
            ],

            [
                'user_id' => 8,
                'kamar_id' => 3,
                'judul' => 'Stop kontak longgar',
                'diskripsi' => 'Stop kontak tidak dapat digunakan dengan baik.',
                'status' => 'selesai',
            ],

            [
                'user_id' => 9,
                'kamar_id' => 6,
                'judul' => 'Pintu kamar sulit ditutup',
                'diskripsi' => 'Harus didorong cukup kuat agar pintu bisa terkunci.',
                'status' => 'diproses',
            ],

            [
                'user_id' => 10,
                'kamar_id' => 10,
                'judul' => 'Air kamar mandi kecil',
                'diskripsi' => 'Debit air sangat kecil pada pagi hari.',
                'status' => 'pending',
            ],

            [
                'user_id' => 2,
                'kamar_id' => 9,
                'judul' => 'Cat dinding mengelupas',
                'diskripsi' => 'Bagian dinding dekat jendela mulai mengelupas.',
                'status' => 'selesai',
            ],

        ];

        foreach ($pengaduans as $pengaduan) {
            Pengaduan::create($pengaduan);
        }
    }
}
