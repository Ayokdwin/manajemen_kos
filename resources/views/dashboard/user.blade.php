{{--
    resources/views/dashboard.blade.php (untuk role: penyewa)

    Asumsi Controller (gabungkan dengan dashboard admin pakai kondisi role):

    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // ... dashboard admin
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

        return view('dashboard', compact(
            'kontrakAktif',
            'tagihanAktif',
            'riwayatTagihan',
            'pengaduan',
        ));
    }
--}}

@extends('layouts.admin')

@section('content')
<div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
    <div class="flex-1 flex flex-col overflow-hidden">
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            {{-- Flash message --}}
            @if (session('success'))
                <div class="rounded-lg border border-emerald-200 dark:border-emerald-500/30
                            bg-emerald-50 dark:bg-emerald-500/10 p-4 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <p class="text-sm font-medium text-emerald-700 dark:text-emerald-400">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            {{-- Greeting --}}
            <div>
                <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">
                    Halo, {{ auth()->user()->name }}
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Berikut informasi hunian dan tagihan Anda.
                </p>
            </div>

            {{-- JIKA TIDAK ADA KONTRAK AKTIF --}}
            @if (!$kontrakAktif)
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                            bg-white dark:bg-slate-900 p-10 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                        <i class="fa-solid fa-house-circle-xmark text-slate-400 text-2xl"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-1">
                        Anda belum menghuni kamar
                    </h2>
                    <p class="text-sm text-slate-400 dark:text-slate-500 max-w-sm">
                        Saat ini Anda belum memiliki kontrak sewa aktif. Lihat kamar yang tersedia untuk memulai.
                    </p>
                    <a href="{{ route('kamar.index') }}"
                       class="mt-5 inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-medium
                              text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        <i class="fa-solid fa-door-open text-xs"></i>
                        Lihat Kamar Tersedia
                    </a>
                </div>

            {{-- ADA KONTRAK AKTIF --}}
            @else
                {{-- STAT CARDS --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                    {{-- Info Kamar --}}
                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                bg-white dark:bg-slate-900 p-5">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Kamar Saya</p>
                            <div class="w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center">
                                <i class="fa-solid fa-door-closed text-indigo-600 dark:text-indigo-400 text-sm"></i>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-slate-900 dark:text-slate-100">
                            {{ $kontrakAktif->kamar->no_kamar }}
                        </p>
                        <p class="mt-2 text-xs text-slate-400 dark:text-slate-500 capitalize">
                            Tipe {{ $kontrakAktif->kamar->tipe }} ·
                            Rp {{ number_format($kontrakAktif->kamar->harga_per_bulan, 0, ',', '.') }}/bln
                        </p>
                    </div>

                    {{-- Masa Sewa --}}
                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                bg-white dark:bg-slate-900 p-5">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Masa Sewa</p>
                            <div class="w-9 h-9 rounded-lg bg-violet-50 dark:bg-violet-500/10 flex items-center justify-center">
                                <i class="fa-regular fa-calendar text-violet-600 dark:text-violet-400 text-sm"></i>
                            </div>
                        </div>
                        @php
                            $sisaHari = floor(
                                now()->diffInDays($kontrakAktif->tanggal_selesai, false)
                            );
                        @endphp
                        <p class="text-3xl font-bold {{ $sisaHari <= 30 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-900 dark:text-slate-100' }}">
                            {{ max(0, $sisaHari) }}
                            <span class="text-base font-normal text-slate-400">hari lagi</span>
                        </p>
                        <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">
                            Berakhir {{ $kontrakAktif->tanggal_selesai->format('d M Y') }}
                        </p>
                    </div>

                    {{-- Status Tagihan Aktif --}}
                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                bg-white dark:bg-slate-900 p-5">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Tagihan Bulan Ini</p>
                            <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center">
                                <i class="fa-solid fa-file-invoice-dollar text-amber-600 dark:text-amber-400 text-sm"></i>
                            </div>
                        </div>
                        @if ($tagihanAktif)
                            <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">
                                Rp {{ number_format($tagihanAktif->jumlah_tagihan, 0, ',', '.') }}
                            </p>
                            <div class="mt-2">
                                @if ($tagihanAktif->status === 'menunggu')
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-md
                                                 bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                        Menunggu Verifikasi
                                    </span>
                                @else
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-md
                                                 bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-400">
                                        Belum Dibayar
                                    </span>
                                @endif
                            </div>
                        @else
                            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">Lunas</p>
                            <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">Semua tagihan sudah dibayar</p>
                        @endif
                    </div>
                </div>

                {{-- BANNER TAGIHAN MENDESAK --}}
                @if ($tagihanAktif && $tagihanAktif->status === 'belum_bayar')
                    @php $hariJatuhTempo = (int) today()->diffInDays(
                            $tagihanAktif->tanggal_jatuh_tempo->startOfDay(),
                            false
                         );
                    @endphp
                    <div class="rounded-2xl border
                                {{ $hariJatuhTempo <= 3 ? 'border-rose-200 dark:border-rose-500/30 bg-rose-50 dark:bg-rose-500/10' : 'border-amber-200 dark:border-amber-500/30 bg-amber-50 dark:bg-amber-500/10' }}
                                p-5 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-exclamation text-xl
                                      {{ $hariJatuhTempo <= 3 ? 'text-rose-500' : 'text-amber-500' }}"></i>
                            <div>
                                <p class="text-sm font-semibold
                                          {{ $hariJatuhTempo <= 3 ? 'text-rose-700 dark:text-rose-400' : 'text-amber-700 dark:text-amber-400' }}">
                                    @if ($hariJatuhTempo < 0)
                                        Tagihan melewati jatuh tempo!
                                    @elseif ($hariJatuhTempo === 0)
                                        Tagihan jatuh tempo hari ini!
                                    @else
                                        Tagihan jatuh tempo dalam {{ $hariJatuhTempo }} hari
                                    @endif
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    Rp {{ number_format($tagihanAktif->jumlah_tagihan, 0, ',', '.') }} ·
                                    Batas {{ $tagihanAktif->tanggal_jatuh_tempo->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('tagihan.index', $tagihanAktif->id) }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium text-white transition-colors
                                  {{ $hariJatuhTempo <= 3 ? 'bg-rose-600 hover:bg-rose-700' : 'bg-amber-500 hover:bg-amber-600' }}">
                            Bayar Sekarang
                        </a>
                    </div>
                @endif

                {{-- PERINGATAN SISA MASA SEWA --}}
                @if ($sisaHari <= 30 && $sisaHari >= 0)
                    <div class="rounded-2xl border border-amber-200 dark:border-amber-500/30
                                bg-amber-50 dark:bg-amber-500/10 p-5 flex items-center gap-3">
                        <i class="fa-solid fa-clock text-amber-500 text-xl"></i>
                        <div>
                            <p class="text-sm font-semibold text-amber-700 dark:text-amber-400">
                                Kontrak sewa Anda akan berakhir dalam {{ $sisaHari }} hari
                            </p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Hubungi admin untuk memperpanjang kontrak Anda.
                            </p>
                        </div>
                    </div>
                @endif

                {{-- INFO KAMAR + RIWAYAT TAGIHAN --}}
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

                    {{-- Detail Kamar (2 kolom) --}}
                    <div class="lg:col-span-2 space-y-4">

                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                    bg-white dark:bg-slate-900 overflow-hidden">

                            {{-- Foto kamar --}}
                            <div class="h-40 bg-gradient-to-br from-indigo-50 to-violet-50
                                        dark:from-indigo-500/10 dark:to-violet-500/10
                                        flex items-center justify-center overflow-hidden">
                                @if ($kontrakAktif->kamar->foto)
                                    <img src="{{ asset('storage/' . $kontrakAktif->kamar->foto) }}"
                                         alt="Kamar {{ $kontrakAktif->kamar->no_kamar }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-bed text-5xl text-indigo-300 dark:text-indigo-500/40"></i>
                                @endif
                            </div>

                            <div class="p-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-semibold text-slate-900 dark:text-slate-100">
                                        Kamar {{ $kontrakAktif->kamar->no_kamar }}
                                    </h3>
                                    <span class="text-xs font-medium px-2 py-1 rounded-md capitalize
                                                 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                                        {{ $kontrakAktif->kamar->tipe }}
                                    </span>
                                </div>

                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-slate-400 dark:text-slate-500">Harga sewa</span>
                                        <span class="font-medium text-slate-700 dark:text-slate-200">
                                            Rp {{ number_format($kontrakAktif->kamar->harga_per_bulan, 0, ',', '.') }}/bln
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-400 dark:text-slate-500">Deposit</span>
                                        <span class="font-medium text-slate-700 dark:text-slate-200">
                                            Rp {{ number_format($kontrakAktif->deposit, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-400 dark:text-slate-500">tanggal masuk</span>
                                        <span class="font-medium text-slate-700 dark:text-slate-200">
                                            {{ $kontrakAktif->tanggal_masuk->format('d M Y') }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-400 dark:text-slate-500">tanggal selesai</span>
                                        <span class="font-medium text-slate-700 dark:text-slate-200">
                                            {{ $kontrakAktif->tanggal_selesai->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-1.5">Fasilitas</p>
                                    <p class="text-sm text-slate-600 dark:text-slate-300">
                                        {{ $kontrakAktif->kamar->fasilitas }}
                                    </p>
                                </div>

                                <div class="flex gap-2 pt-1">
                                    <a href="{{ route('kamar.show', $kontrakAktif->kamar->id) }}"
                                       class="flex-1 text-center py-2 rounded-lg text-sm font-medium
                                              text-indigo-700 dark:text-indigo-400
                                              bg-indigo-50 dark:bg-indigo-500/10
                                              hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition-colors">
                                        Detail Kamar
                                    </a>
                                    <a href="{{ route('pengaduan.create', ['kamar_id' => $kontrakAktif->kamar->id]) }}"
                                       class="flex-1 text-center py-2 rounded-lg text-sm font-medium
                                              text-rose-600 dark:text-rose-400
                                              bg-rose-50 dark:bg-rose-500/10
                                              hover:bg-rose-100 dark:hover:bg-rose-500/20 transition-colors">
                                        Lapor Masalah
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Riwayat Tagihan (3 kolom) --}}
                    <div class="lg:col-span-3 space-y-4">
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                    bg-white dark:bg-slate-900 overflow-hidden">
                            <div class="flex items-center justify-between px-5 py-4
                                        border-b border-slate-100 dark:border-slate-800">
                                <h3 class="font-semibold text-slate-900 dark:text-slate-100">Riwayat Tagihan</h3>
                                <a href="{{ route('tagihan.index') }}"
                                   class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                    Lihat semua
                                </a>
                            </div>

                            @if ($riwayatTagihan->isEmpty())
                                <div class="flex flex-col items-center justify-center py-10 text-center">
                                    <i class="fa-solid fa-file-invoice text-2xl text-slate-300 dark:text-slate-700 mb-2"></i>
                                    <p class="text-sm text-slate-400 dark:text-slate-500">
                                        Belum ada tagihan
                                    </p>
                                </div>
                            @else
                                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @foreach ($riwayatTagihan as $tagihan)
                                        <a href="{{ route('tagihan.index', $tagihan->id) }}"
                                           class="flex items-center justify-between gap-3 px-5 py-3.5
                                                  hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                            <div class="flex items-center gap-3 min-w-0">
                                                {{-- Ikon status --}}
                                                @if ($tagihan->status === 'lunas')
                                                    <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-500/10
                                                                flex items-center justify-center shrink-0">
                                                        <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                                                    </div>
                                                @elseif ($tagihan->status === 'menunggu')
                                                    <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-500/10
                                                                flex items-center justify-center shrink-0">
                                                        <i class="fa-solid fa-clock text-amber-500 text-sm"></i>
                                                    </div>
                                                @else
                                                    <div class="w-9 h-9 rounded-lg bg-rose-50 dark:bg-rose-500/10
                                                                flex items-center justify-center shrink-0">
                                                        <i class="fa-solid fa-file-invoice-dollar text-rose-500 text-sm"></i>
                                                    </div>
                                                @endif

                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-100">
                                                        {{ \Carbon\Carbon::createFromDate($tagihan->tahun, $tagihan->bulan, 1)->translatedFormat('F Y') }}
                                                    </p>
                                                    <p class="text-xs text-slate-400 dark:text-slate-500">
                                                        Jatuh tempo {{ $tagihan->tanggal_jatuh_tempo->format('d M Y') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="text-right shrink-0">
                                                <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                                    Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                                                </p>
                                                @if ($tagihan->status === 'lunas')
                                                    <span class="text-xs font-medium px-2 py-0.5 rounded-md
                                                                 bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                                        Lunas
                                                    </span>
                                                @elseif ($tagihan->status === 'menunggu')
                                                    <span class="text-xs font-medium px-2 py-0.5 rounded-md
                                                                 bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                                        Menunggu
                                                    </span>
                                                @else
                                                    <span class="text-xs font-medium px-2 py-0.5 rounded-md
                                                                 bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-400">
                                                        Belum Bayar
                                                    </span>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Pengaduan Saya --}}
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                    bg-white dark:bg-slate-900 overflow-hidden">
                            <div class="flex items-center justify-between px-5 py-4
                                        border-b border-slate-100 dark:border-slate-800">
                                <h3 class="font-semibold text-slate-900 dark:text-slate-100">Pengaduan Saya</h3>
                                <a href="{{ route('pengaduan.index') }}"
                                   class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                    Lihat semua
                                </a>
                            </div>

                            @if ($pengaduan->isEmpty())
                                <div class="flex flex-col items-center justify-center py-8 text-center">
                                    <i class="fa-solid fa-circle-check text-2xl text-emerald-400 mb-2"></i>
                                    <p class="text-sm text-slate-400 dark:text-slate-500">
                                        Tidak ada pengaduan aktif
                                    </p>
                                </div>
                            @else
                                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @foreach ($pengaduan as $p)
                                        <div class="flex items-center justify-between gap-3 px-5 py-3.5">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <div class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center
                                                            {{ $p->status === 'selesai'
                                                                ? 'bg-emerald-50 dark:bg-emerald-500/10'
                                                                : ($p->status === 'diproses'
                                                                    ? 'bg-amber-50 dark:bg-amber-500/10'
                                                                    : 'bg-slate-100 dark:bg-slate-800') }}">
                                                    <i class="fa-solid fa-triangle-exclamation text-sm
                                                               {{ $p->status === 'selesai'
                                                                   ? 'text-emerald-500'
                                                                   : ($p->status === 'diproses'
                                                                       ? 'text-amber-500'
                                                                       : 'text-slate-400') }}"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-100 truncate">
                                                        {{ $p->judul }}
                                                    </p>
                                                    <p class="text-xs text-slate-400 dark:text-slate-500">
                                                        {{ $p->created_at->format('d M Y') }}
                                                    </p>
                                                </div>
                                            </div>

                                            @if ($p->status === 'selesai')
                                                <span class="text-xs font-medium px-2 py-0.5 rounded-md shrink-0
                                                             bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                                    Selesai
                                                </span>
                                            @elseif ($p->status === 'diproses')
                                                <span class="text-xs font-medium px-2 py-0.5 rounded-md shrink-0
                                                             bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                                    Diproses
                                                </span>
                                            @else
                                                <span class="text-xs font-medium px-2 py-0.5 rounded-md shrink-0
                                                             bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                                    Pending
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        </main>
    </div>
</div>
@endsection
