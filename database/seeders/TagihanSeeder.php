<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tagihan;
use Illuminate\Support\Facades\DB;


class TagihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Tagihan::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $tagihans = [

            [
                'kontrak_id' => 1,
                'bulan' => 7,
                'tahun' => 2026,
                'jumlah_tagihan' => 750000,
                'tanggal_jatuh_tempo' => '2026-07-10',
                'status' => 'lunas',
            ],

            [
                'kontrak_id' => 2,
                'bulan' => 7,
                'tahun' => 2026,
                'jumlah_tagihan' => 750000,
                'tanggal_jatuh_tempo' => '2026-07-10',
                'status' => 'lunas',
            ],

            [
                'kontrak_id' => 3,
                'bulan' => 7,
                'tahun' => 2026,
                'jumlah_tagihan' => 1000000,
                'tanggal_jatuh_tempo' => '2026-07-10',
                'status' => 'menunggu',
            ],

            [
                'kontrak_id' => 4,
                'bulan' => 7,
                'tahun' => 2026,
                'jumlah_tagihan' => 1000000,
                'tanggal_jatuh_tempo' => '2026-07-10',
                'status' => 'belum_bayar',
            ],

            [
                'kontrak_id' => 5,
                'bulan' => 7,
                'tahun' => 2026,
                'jumlah_tagihan' => 1500000,
                'tanggal_jatuh_tempo' => '2026-07-10',
                'status' => 'belum_bayar',
            ],

            [
                'kontrak_id' => 6,
                'bulan' => 7,
                'tahun' => 2026,
                'jumlah_tagihan' => 1500000,
                'tanggal_jatuh_tempo' => '2026-07-10',
                'status' => 'menunggu',
            ],

            [
                'kontrak_id' => 7,
                'bulan' => 12,
                'tahun' => 2025,
                'jumlah_tagihan' => 800000,
                'tanggal_jatuh_tempo' => '2025-12-10',
                'status' => 'lunas',
            ],

            [
                'kontrak_id' => 8,
                'bulan' => 8,
                'tahun' => 2026,
                'jumlah_tagihan' => 1050000,
                'tanggal_jatuh_tempo' => '2026-08-10',
                'status' => 'belum_bayar',
            ],

            [
                'kontrak_id' => 9,
                'bulan' => 8,
                'tahun' => 2026,
                'jumlah_tagihan' => 1600000,
                'tanggal_jatuh_tempo' => '2026-08-10',
                'status' => 'menunggu',
            ],

            [
                'kontrak_id' => 10,
                'bulan' => 12,
                'tahun' => 2024,
                'jumlah_tagihan' => 1600000,
                'tanggal_jatuh_tempo' => '2024-12-10',
                'status' => 'lunas',
            ],

        ];

        foreach ($tagihans as $tagihan) {
            Tagihan::create($tagihan);
        }
    }
}
