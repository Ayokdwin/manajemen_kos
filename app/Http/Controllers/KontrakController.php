<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontrak;
use App\Models\Kamar;
use App\Models\User;
use App\Models\Tagihan;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class KontrakController extends Controller
{
    public function index(Request $request)
    {
        $kontrak = Kontrak::with(['user', 'kamar'])
            ->when($request->search, function ($q, $search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('kamar', function ($q) use ($search) {
                    $q->where('nomor_kamar', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('kontrak.index', compact('kontrak'));
    }

    public function create()
    {
        $penyewa = User::where('role', 'user')->orderBy('name')->get();
        $kamar = Kamar::where('status', 'tersedia')->orderBy('no_kamar')->get();


        return view('kontrak.create', compact('penyewa', 'kamar'));
    }

    public function store()
    {
        $validated = request()->validate([
            'user_id'     => 'required|exists:users,id',
            'kamar_id'    => 'required|exists:kamars,id',
            'tanggal_masuk'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_masuk',
            'deposit'     => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            Kontrak::create([
                ...$validated,
                'status' => 'aktif',
            ]);

            Kamar::where('id', $validated['kamar_id'])->update(['status' => 'diisi']);

        });

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil dibuat.');
    }

    public function show(Kontrak $kontrak)
    {
        $kontrak->load(['user', 'kamar', 'tagihan.pembayaran']);

        return view('kontrak.show', compact('kontrak'));
    }

    public function edit(Kontrak $kontrak)
    {
        $penyewa = User::where('role', 'user')->orderBy('name')->get();
        $kamar = Kamar::where('status', 'tersedia')
            ->orWhere('id', $kontrak->kamar_id)
            ->orderBy('no_kamar')
            ->get();

        return view('kontrak.edit', compact('kontrak', 'penyewa', 'kamar'));
    }

    public function update(Request $request, Kontrak $kontrak)
{
    $validated = $request->validate([
        'user_id'           => 'required|exists:users,id',
        'kamar_id'          => 'required|exists:kamars,id',
        'tanggal_masuk'     => 'required|date',
        'tanggal_selesai'   => 'required|date|after:tanggal_masuk',
        'deposit'           => 'required|numeric|min:0',
        'status'            => 'required|in:aktif,selesai',
    ]);

    DB::transaction(function () use ($validated, $kontrak) {

        if ($kontrak->kamar_id != $validated['kamar_id']) {

            Kamar::where('id', $kontrak->kamar_id)
                ->update(['status' => 'tersedia']);

            Kamar::where('id', $validated['kamar_id'])
                ->update(['status' => 'diisi']);
        }

        $kontrak->update($validated);
    });

    return redirect()
        ->route('kontrak.index')
        ->with('success', 'Kontrak berhasil diperbarui.');
}

    public function destroy(Kontrak $kontrak)
    {
        DB::transaction(function () use ($kontrak) {
            Kamar::where('id', $kontrak->kamar_id)
                ->update(['status' => 'tersedia']);

            $kontrak->delete();
        });

        return redirect()
            ->route('kontrak.index')
            ->with('success', 'Kontrak berhasil dihapus.');
    }
    public function approve(Kontrak $kontrak)
    {
        DB::transaction(function () use ($kontrak) {
            $kontrak->update(['approval_status' => 'approved']);

            $this->generateTagihanBulanan($kontrak->fresh(['kamar']));
        });

        return redirect()
            ->route('kontrak.index')
            ->with('success', 'Kontrak berhasil disetujui.');
    }
    public function reject(Kontrak $kontrak)
    {
        $kontrak->update(['approval_status' => 'rejected']);
        return redirect()
            ->route('kontrak.index')
            ->with('success', 'Kontrak berhasil ditolak.');
    }

    private function generateTagihanBulanan(Kontrak $kontrak): void
    {
        if (! $kontrak->kamar) {
            return;
        }

        $start = $kontrak->tanggal_masuk->copy()->startOfMonth();
        $end = $kontrak->tanggal_selesai->copy()->startOfMonth();
        $periode = CarbonPeriod::create($start, '1 month', $end);

        foreach ($periode as $tanggal) {
            $jatuhTempo = $tanggal->copy()->addMonthNoOverflow()->day(10)->toDateString();

            Tagihan::firstOrCreate(
                [
                    'kontrak_id' => $kontrak->id,
                    'bulan' => $tanggal->month,
                    'tahun' => $tanggal->year,
                ],
                [
                    'jumlah_tagihan' => $kontrak->kamar->harga_per_bulan,
                    'tanggal_jatuh_tempo' => $jatuhTempo,
                    'status' => 'belum_bayar',
                ]
            );
        }
    }

}
