<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use Illuminate\Support\Facades\Auth;

class KamarController extends Controller
{
    public function index()
    {
        $semuaKamar = Kamar::latest()->get();

        $kamarTersedia = Kamar::where('status', 'tersedia')->get();

        $kamarSaya = Kamar::whereHas('kontrak', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('status', 'aktif');
        })->get();

        return view('kamar.index', compact(
            'semuaKamar',
            'kamarTersedia',
            'kamarSaya'
        ));
    }

    public function create()
    {
        return view('kamar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kamar'        => 'required|string|max:255|unique:kamars,no_kamar',
            'tipe'            => 'required|in:standar,deluxe,vip',
            'harga_per_bulan' => 'required|numeric|min:0',
            'fasilitas'       => 'required|string',
            'status'          => 'required|in:tersedia,diisi,maintenance',
            'deskripsi'       => 'nullable|string',
            'foto'            => 'nullable|image|max:2048',
        ]);

        $foto = $request->file('foto');

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFile = time().'_'.$foto->getClientOriginalName();
            $foto->move(
                storage_path('app/public/kamar'),
                $namaFile
            );
            $validated['foto'] = 'kamar/'.$namaFile;
        }

        Kamar::create($validated);

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function show(Kamar $kamar)
    {
        return view('kamar.show', compact('kamar'));
    }

    public function edit(Kamar $kamar)
    {
        return view('kamar.edit', compact('kamar'));
    }

    public function update(Request $request, $id)
    {
        $kamar = Kamar::findOrFail($id);

        $validated = $request->validate([
            'no_kamar'        => 'required|string|max:255|unique:kamars,no_kamar,' . $kamar->id,
            'tipe'            => 'required|in:standar,deluxe,vip',
            'harga_per_bulan' => 'required|numeric|min:0',
            'fasilitas'       => 'required|string',
            'status'          => 'required|in:tersedia,diisi,maintenance',
            'deskripsi'       => 'nullable|string',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {

            if ($kamar->foto) {
                $path = storage_path('app/public/' . $kamar->foto);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $foto = $request->file('foto');
            $namaFile = time() . '_' . $foto->getClientOriginalName();
            $foto->move(
                storage_path('app/public/kamar'),
                $namaFile
            );

            $validated['foto'] = 'kamar/' . $namaFile;
        }

        $kamar->update($validated);

        return redirect()
            ->route('kamar.index')
            ->with('success', 'Data kamar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);

        if ($kamar->kontrak()->exists()) {
            return back()->with(
                'error',
                'Kamar tidak dapat dihapus karena sudah memiliki riwayat kontrak.'
            );
        }

        if ($kamar->foto) {
            $path = storage_path('app/public/' . $kamar->foto);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $kamar->delete();

        return redirect()
            ->route('kamar.index')
            ->with('success', 'Data kamar berhasil dihapus.');
    }
}
