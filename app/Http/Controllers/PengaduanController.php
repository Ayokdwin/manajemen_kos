<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
class PengaduanController extends Controller
{
    public function index()
    {
        $search = request('search');

        $pengaduans = Pengaduan::with(['kamar', 'user'])
            ->when(auth()->user()->role !== 'admin', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('judul', 'like', "%{$search}%")
                        ->orWhere('diskripsi', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('kamar', function ($kamarQuery) use ($search) {
                            $kamarQuery->where('no_kamar', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->get();
        
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
    public function delete($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->delete();
        return redirect()->route('pengaduan.index')->with('success','Pengaduan berhasi dihapus');
    }
    public function show($id){
        $pengaduan = Pengaduan::with(['kamar','user'])->findOrFail($id);
        return view('pengaduan.show',compact('pengaduan'));
    }
    public function update($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status = 'selesai';
        $pengaduan->save();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil ditandai sebagai selesai.');
    }

}
