<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $now = now();

        DB::table('users')->insert([
            [
                'name' => 'Andi',
                'email' => 'andi@example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password'),
                'no_hp' => '081234567890',
                'role' => 'user',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Sari',
                'email' => 'sari@example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password'),
                'no_hp' => '081298765432',
                'role' => 'admin',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('kamars')->insert([
            [
                'no_kamar' => '101',
                'tipe' => 'standar',
                'harga_per_bulan' => 1500000,
                'fasilitas' => 'Kasur, lemari, meja belajar, kipas angin, kamar mandi dalam',
                'status' => 'diisi',
                'deskripsi' => 'Kamar standar lantai 1 dengan akses mudah ke area umum.',
                'foto' => 'kamar-101.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'no_kamar' => '102',
                'tipe' => 'deluxe',
                'harga_per_bulan' => 2000000,
                'fasilitas' => 'Kasur, AC, lemari, meja kerja, kamar mandi dalam, balkon kecil',
                'status' => 'tersedia',
                'deskripsi' => 'Kamar deluxe yang nyaman untuk penyewa jangka panjang.',
                'foto' => 'kamar-102.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'no_kamar' => '201',
                'tipe' => 'vip',
                'harga_per_bulan' => 2750000,
                'fasilitas' => 'Kasur premium, AC, lemari besar, meja kerja, pantry mini, kamar mandi dalam',
                'status' => 'maintenance',
                'deskripsi' => 'Kamar VIP lantai 2 dengan ruang lebih luas.',
                'foto' => 'kamar-201.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('kontraks')->insert([
            [
                'user_id' => 1,
                'kamar_id' => 1,
                'tanggal_masuk' => '2026-01-01',
                'tanggal_selesai' => '2026-09-30',
                'deposit' => 1500000,
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'kamar_id' => 2,
                'tanggal_masuk' => '2026-02-01',
                'tanggal_selesai' => '2026-12-31',
                'deposit' => 2000000,
                'status' => 'selesai',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('tagihans')->insert([
            [
                'kontrak_id' => 1,
                'bulan' => 6,
                'tahun' => 2026,
                'jumlah_tagihan' => 1500000,
                'tanggal_jatuh_tempo' => '2026-06-10',
                'status' => 'lunas',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kontrak_id' => 1,
                'bulan' => 7,
                'tahun' => 2026,
                'jumlah_tagihan' => 1500000,
                'tanggal_jatuh_tempo' => '2026-07-10',
                'status' => 'menunggu',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kontrak_id' => 2,
                'bulan' => 5,
                'tahun' => 2026,
                'jumlah_tagihan' => 2000000,
                'tanggal_jatuh_tempo' => '2026-05-10',
                'status' => 'belum_bayar',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('pembayarans')->insert([
            [
                'tagihan_id' => 1,
                'tgl_bayar' => '2026-06-09',
                'metode' => 'transfer',
                'bukti_bayar' => 'bukti-bayar-001.jpg',
                'status_varifikasi' => 'disetujui',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tagihan_id' => 2,
                'tgl_bayar' => '2026-07-08',
                'metode' => 'tunai',
                'bukti_bayar' => 'bukti-bayar-002.jpg',
                'status_varifikasi' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('pengaduans')->insert([
            [
                'user_id' => 1,
                'kamar_id' => 1,
                'judul' => 'Kran air bocor',
                'diskripsi' => 'Kran kamar mandi bocor dan perlu pengecekan.',
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'kamar_id' => 1,
                'judul' => 'Lampu kamar redup',
                'diskripsi' => 'Lampu utama kamar sering redup saat malam hari.',
                'status' => 'selesai',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
