<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamar;
use Illuminate\Support\Facades\DB;

class KamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Kamar::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $kamars = [
            [
                'no_kamar' => 'A01',
                'tipe' => 'standar',
                'harga_per_bulan' => 750000,
                'fasilitas' => 'Kasur, Lemari, Meja Belajar',
                'status' => 'diisi',
                'deskripsi' => 'Kamar nyaman untuk satu orang.',
                'foto' => null,
            ],
            [
                'no_kamar' => 'A02',
                'tipe' => 'standar',
                'harga_per_bulan' => 750000,
                'fasilitas' => 'Kasur, Lemari, Meja Belajar',
                'status' => 'diisi',
                'deskripsi' => 'Dekat dengan dapur bersama.',
                'foto' => null,
            ],
            [
                'no_kamar' => 'A03',
                'tipe' => 'standar',
                'harga_per_bulan' => 800000,
                'fasilitas' => 'Kasur, Lemari, WiFi',
                'status' => 'tersedia',
                'deskripsi' => 'Memiliki ventilasi yang baik.',
                'foto' => null,
            ],
            [
                'no_kamar' => 'B01',
                'tipe' => 'deluxe',
                'harga_per_bulan' => 1000000,
                'fasilitas' => 'Kasur, Lemari, AC, WiFi',
                'status' => 'diisi',
                'deskripsi' => 'Kamar dengan fasilitas AC.',
                'foto' => null,
            ],
            [
                'no_kamar' => 'B02',
                'tipe' => 'deluxe',
                'harga_per_bulan' => 1000000,
                'fasilitas' => 'Kasur, Lemari, AC, WiFi',
                'status' => 'diisi',
                'deskripsi' => 'Dekat area parkir.',
                'foto' => null,
            ],
            [
                'no_kamar' => 'B03',
                'tipe' => 'deluxe',
                'harga_per_bulan' => 1050000,
                'fasilitas' => 'Kasur, Lemari, AC, TV',
                'status' => 'tersedia',
                'deskripsi' => 'Pemandangan halaman depan.',
                'foto' => null,
            ],
            [
                'no_kamar' => 'C01',
                'tipe' => 'vip',
                'harga_per_bulan' => 1500000,
                'fasilitas' => 'Kasur, Lemari, AC, TV, Kamar Mandi Dalam',
                'status' => 'diisi',
                'deskripsi' => 'Kamar VIP lantai 2.',
                'foto' => null,
            ],
            [
                'no_kamar' => 'C02',
                'tipe' => 'vip',
                'harga_per_bulan' => 1500000,
                'fasilitas' => 'Kasur, Lemari, AC, TV, Kamar Mandi Dalam',
                'status' => 'diisi',
                'deskripsi' => 'Kamar VIP dengan balkon.',
                'foto' => null,
            ],
            [
                'no_kamar' => 'C03',
                'tipe' => 'vip',
                'harga_per_bulan' => 1600000,
                'fasilitas' => 'Kasur, Lemari, AC, TV, Kamar Mandi Dalam',
                'status' => 'maintenance',
                'deskripsi' => 'Sedang dalam proses perbaikan.',
                'foto' => null,
            ],
            [
                'no_kamar' => 'C04',
                'tipe' => 'vip',
                'harga_per_bulan' => 1600000,
                'fasilitas' => 'Kasur, Lemari, AC, TV, Kamar Mandi Dalam',
                'status' => 'tersedia',
                'deskripsi' => 'Kamar paling luas.',
                'foto' => null,
            ],
        ];

        foreach ($kamars as $kamar) {
            Kamar::create($kamar);
        }
    }
}
