<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kontrak;
use Illuminate\Support\Facades\DB;


class KontrakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Kontrak::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $kontraks = [

            [
                'user_id' => 2,
                'kamar_id' => 1,
                'tanggal_masuk' => '2026-01-01',
                'tanggal_selesai' => '2026-12-31',
                'deposit' => 500000,
                'approval_status' => 'approved',
                'status' => 'aktif',
            ],

            [
                'user_id' => 3,
                'kamar_id' => 2,
                'tanggal_masuk' => '2026-02-01',
                'tanggal_selesai' => '2027-01-31',
                'deposit' => 500000,
                'approval_status' => 'approved',
                'status' => 'aktif',
            ],

            [
                'user_id' => 4,
                'kamar_id' => 4,
                'tanggal_masuk' => '2026-03-01',
                'tanggal_selesai' => '2027-02-28',
                'deposit' => 700000,
                'approval_status' => 'approved',
                'status' => 'aktif',
            ],

            [
                'user_id' => 5,
                'kamar_id' => 5,
                'tanggal_masuk' => '2026-04-01',
                'tanggal_selesai' => '2027-03-31',
                'deposit' => 700000,
                'approval_status' => 'approved',
                'status' => 'aktif',
            ],

            [
                'user_id' => 6,
                'kamar_id' => 7,
                'tanggal_masuk' => '2026-05-01',
                'tanggal_selesai' => '2027-04-30',
                'deposit' => 1000000,
                'approval_status' => 'approved',
                'status' => 'aktif',
            ],

            [
                'user_id' => 7,
                'kamar_id' => 8,
                'tanggal_masuk' => '2026-06-01',
                'tanggal_selesai' => '2027-05-31',
                'deposit' => 1000000,
                'approval_status' => 'approved',
                'status' => 'aktif',
            ],

            [
                'user_id' => 8,
                'kamar_id' => 3,
                'tanggal_masuk' => '2025-01-01',
                'tanggal_selesai' => '2025-12-31',
                'deposit' => 500000,
                'approval_status' => 'approved',
                'status' => 'selesai',
            ],

            [
                'user_id' => 9,
                'kamar_id' => 6,
                'tanggal_masuk' => '2026-08-01',
                'tanggal_selesai' => '2027-07-31',
                'deposit' => 700000,
                'approval_status' => 'pending',
                'status' => 'aktif',
            ],

            [
                'user_id' => 10,
                'kamar_id' => 10,
                'tanggal_masuk' => '2026-08-10',
                'tanggal_selesai' => '2027-08-09',
                'deposit' => 1000000,
                'approval_status' => 'rejected',
                'status' => 'aktif',
            ],

            [
                'user_id' => 2,
                'kamar_id' => 9,
                'tanggal_masuk' => '2024-01-01',
                'tanggal_selesai' => '2024-12-31',
                'deposit' => 1000000,
                'approval_status' => 'approved',
                'status' => 'selesai',
            ],

        ];

        foreach ($kontraks as $kontrak) {
            Kontrak::create($kontrak);
        }
    }
}
