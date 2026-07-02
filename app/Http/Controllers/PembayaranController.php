<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::with(['tagihan.kontrak.user', 'tagihan.kontrak.kamar'])
            ->when(auth()->user()->role !== 'admin', function ($query) {
                $query->whereHas('tagihan.kontrak', function ($kontrakQuery) {
                    $kontrakQuery->where('user_id', auth()->id());
                });
            })
            ->latest()
            ->get();
        return view('pembayaran.index', compact('pembayaran'));
    }
    public function show($id)
    {
        $pembayaran = Pembayaran::with(['tagihan.kontrak.user', 'tagihan.kontrak.kamar'])
            ->findOrFail($id);

        // Check if the authenticated user is not an admin and does not own the pembayaran
        if (auth()->user()->role !== 'admin' && $pembayaran->tagihan->kontrak->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('pembayaran.show', compact('pembayaran'));
    }
    public function payment($id)
    {
        $tagihan = Tagihan::with(['kontrak.user', 'kontrak.kamar', 'pembayaran'])
            ->findOrFail($id);

        if (auth()->user()->role !== 'admin' && $tagihan->kontrak->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('pembayaran.payment', compact('tagihan'));

    }

    public function store(Request $request, $id)
    {
        $tagihan = Tagihan::with('kontrak')->findOrFail($id);

        if (auth()->user()->role !== 'admin' && $tagihan->kontrak->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'metode' => 'required|in:transfer,tunai',
            'tgl_bayar' => 'required|date',
            'bukti_bayar' => 'required_if:metode,transfer|nullable|image|max:2048',
        ]);

        $pembayaran = Pembayaran::firstOrNew([
            'tagihan_id' => $tagihan->id,
        ]);

        $existingBukti = $pembayaran->exists ? $pembayaran->bukti_bayar : null;
        $payload = [
            'tagihan_id' => $tagihan->id,
            'tgl_bayar' => $validated['tgl_bayar'],
            'metode' => $validated['metode'],
            'status_varifikasi' => 'pending',
        ];

        $buktiBayar = $request->file('bukti_bayar');

        if ($validated['metode'] === 'transfer') {
            $sourcePath = $buktiBayar?->getPathname();

            if (! $buktiBayar || ! $buktiBayar->isValid() || ! $sourcePath || ! is_file($sourcePath)) {
                return back()
                    ->withErrors(['bukti_bayar' => 'Bukti bayar gagal diupload. Silakan pilih ulang file gambar yang valid.'])
                    ->withInput();
            }

            $extension = $buktiBayar->extension() ?: $buktiBayar->getClientOriginalExtension() ?: 'jpg';
            $payload['bukti_bayar'] = 'pembayaran/' . Str::uuid() . '.' . $extension;

            Storage::disk('public')->put(
                $payload['bukti_bayar'],
                file_get_contents($sourcePath)
            );
        } elseif (! $pembayaran->exists) {
            $payload['bukti_bayar'] = 'tunai';
        }

        $pembayaran->fill($payload);
        $pembayaran->save();

        if ($existingBukti && isset($payload['bukti_bayar']) && $existingBukti !== $payload['bukti_bayar']) {
            Storage::disk('public')->delete($existingBukti);
        }

        $tagihan->update(['status' => 'menunggu']);

        return redirect()
            ->route('pembayaran.show', $pembayaran->id)
            ->with('success', 'Pembayaran berhasil dikirim dan menunggu verifikasi.');
    }
    public function verify(Request $request, $id)
    {
        $pembayaran = Pembayaran::with('tagihan')->findOrFail($id);

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status_varifikasi' => 'required|in:disetujui,ditolak,pending',
        ]);

        $pembayaran->update($validated);

        if ($validated['status_varifikasi'] === 'disetujui') {
            $pembayaran->tagihan->update(['status' => 'lunas']);
        } elseif ($validated['status_varifikasi'] === 'ditolak') {
            $pembayaran->tagihan->update(['status' => 'belum_bayar']);
        }

        return redirect()
            ->route('pembayaran.show', $pembayaran->id)
            ->with('success', 'Status verifikasi pembayaran berhasil diperbarui.');
    }
}
