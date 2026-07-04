<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;


class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Pembayaran::truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $pembayarans = [

            [
                'tagihan_id' => 1,
                'tgl_bayar' => '2026-07-05',
                'metode' => 'transfer',
                'bukti_bayar' => '',
                'status_varifikasi' => 'disetujui',
            ],

            [
                'tagihan_id' => 2,
                'tgl_bayar' => '2026-07-06',
                'metode' => 'tunai',
                'bukti_bayar' => '',
                'status_varifikasi' => 'disetujui',
            ],

            [
                'tagihan_id' => 3,
                'tgl_bayar' => '2026-07-08',
                'metode' => 'transfer',
                'bukti_bayar' => '',
                'status_varifikasi' => 'pending',
            ],

            [
                'tagihan_id' => 4,
                'tgl_bayar' => '2026-07-09',
                'metode' => 'transfer',
                'bukti_bayar' => '',
                'status_varifikasi' => 'ditolak',
            ],

            [
                'tagihan_id' => 5,
                'tgl_bayar' => '2026-07-09',
                'metode' => 'tunai',
                'bukti_bayar' => '',
                'status_varifikasi' => 'ditolak',
            ],

            [
                'tagihan_id' => 6,
                'tgl_bayar' => '2026-07-07',
                'metode' => 'transfer',
                'bukti_bayar' => '',
                'status_varifikasi' => 'pending',
            ],

            [
                'tagihan_id' => 7,
                'tgl_bayar' => '2025-12-05',
                'metode' => 'transfer',
                'bukti_bayar' => '',
                'status_varifikasi' => 'disetujui',
            ],

            [
                'tagihan_id' => 8,
                'tgl_bayar' => '2026-08-05',
                'metode' => 'transfer',
                'bukti_bayar' => '',
                'status_varifikasi' => 'ditolak',
            ],

            [
                'tagihan_id' => 9,
                'tgl_bayar' => '2026-08-06',
                'metode' => 'transfer',
                'bukti_bayar' => '',
                'status_varifikasi' => 'pending',
            ],

            [
                'tagihan_id' => 10,
                'tgl_bayar' => '2024-12-05',
                'metode' => 'tunai',
                'bukti_bayar' => '',
                'status_varifikasi' => 'disetujui',
            ],

        ];

        foreach ($pembayarans as $pembayaran) {
            Pembayaran::create($pembayaran);
        }
    }
}
