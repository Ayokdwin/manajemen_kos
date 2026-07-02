<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Kamar;
use App\Models\Kontrak;
use App\Models\Tagihan;
use App\Models\Pengaduan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('dashboard.admin', [
                'totalKamar'        => Kamar::count(),
                'kamarTersedia'     => Kamar::where('status', 'tersedia')->count(),
                'kamarTerisi'       => Kamar::where('status', 'diisi')->count(),
                'totalPenyewa'      => User::where('role', 'user')->count(),
                'kontrakAktif'      => Kontrak::where('status', 'aktif')->count(),
                'tagihanBelumBayar' => Tagihan::where('status', 'belum_bayar')->count(),
                'tagihanMenunggu'   => Tagihan::where('status', 'menunggu')->count(),
                'totalPemasukan'    => Tagihan::where('status', 'lunas')->sum('jumlah_tagihan'),

                'pengaduanPending'  => Pengaduan::where('status', 'pending')->count(),
                'pengaduanDiproses' => Pengaduan::where('status', 'diproses')->count(),

                'tagihanTerbaru' => Tagihan::with(['kontrak.user', 'kontrak.kamar'])
                    ->whereIn('status', ['belum_bayar', 'menunggu'])
                    ->latest()
                    ->take(5)
                    ->get(),

                'pengaduanTerbaru' => Pengaduan::with(['user', 'kamar'])
                    ->whereIn('status', ['pending', 'diproses'])
                    ->latest()
                    ->take(5)
                    ->get(),
            ]);
        }

            $kontrakAktif = Kontrak::with(['kamar'])
                ->where('user_id', $user->id)
                ->where('status', 'aktif')
                ->first();

            $tagihanAktif = $kontrakAktif
                ? Tagihan::with('pembayaran')
                    ->where('kontrak_id', $kontrakAktif->id)
                    ->whereIn('status', ['belum_bayar', 'menunggu'])
                    ->latest()
                    ->first()
                : null;

            $riwayatTagihan = $kontrakAktif
                ? Tagihan::with('pembayaran')
                    ->where('kontrak_id', $kontrakAktif->id)
                    ->latest()
                    ->take(5)
                    ->get()
                : collect();

            $pengaduan = Pengaduan::with('kamar')
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.user', compact(
                'kontrakAktif',
                'tagihanAktif',
                'riwayatTagihan',
                'pengaduan',
            ));
    }
}
