<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::with('kamar','user')->latest()->get();
        
        return view('pengaduan.index',compact('pengaduans'));
    }

    public function create()
    {
        $kamarAktif = auth()->user()
            ->kontrak()
            ->where('status', 'aktif')
            ->latest()
            ->with('kamar')
            ->first();

        return view('pengaduan.create', compact('kamarAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'diskripsi' => 'required|string',
        ]);

        $kamarAktif = auth()->user()
            ->kontrak()
            ->where('status', 'aktif')
            ->latest()
            ->first();

        if (! $kamarAktif) {
            return back()
                ->withInput()
                ->withErrors(['kamar' => 'Anda belum memiliki kamar aktif untuk membuat pengaduan.']);
        }

        Pengaduan::create([
            'user_id' => auth()->id(),
            'kamar_id' => $kamarAktif->kamar_id,
            'judul' => $request->judul,
            'diskripsi' => $request->diskripsi,
        ]);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Aduan berhasil ditambahkan');
    }

}
