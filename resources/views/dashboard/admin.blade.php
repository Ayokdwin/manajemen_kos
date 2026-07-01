@extends('layouts.admin')

@section('content')
<div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
    <div class="flex-1 flex flex-col overflow-hidden">
        <main class="flex-1 overflow-y-auto p-6 space-y-6">

            {{-- Greeting --}}
            <div>
                <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">
                    Hallo, {{ auth()->user()->name }}
                </h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Berikut ringkasan kondisi kos hari ini.
                </p>
            </div>

            {{--  STAT CARDS  --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- Total Kamar --}}
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                            bg-white dark:bg-slate-900 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Total Kamar</p>
                        <div class="w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center">
                            <i class="fa-solid fa-door-closed text-indigo-600 dark:text-indigo-400 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $totalKamar }}</p>
                    <div class="flex items-center gap-3 mt-2 text-xs text-slate-400 dark:text-slate-500">
                        <span class="text-emerald-600 dark:text-emerald-400 font-medium">{{ $kamarTersedia }} tersedia</span>
                        <span>·</span>
                        <span>{{ $kamarTerisi }} terisi</span>
                    </div>
                </div>

                {{-- Penyewa Aktif --}}
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                            bg-white dark:bg-slate-900 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Penyewa</p>
                        <div class="w-9 h-9 rounded-lg bg-violet-50 dark:bg-violet-500/10 flex items-center justify-center">
                            <i class="fa-solid fa-user-group text-violet-600 dark:text-violet-400 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $totalPenyewa }}</p>
                    <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">
                        <span class="text-emerald-600 dark:text-emerald-400 font-medium">{{ $kontrakAktif }} kontrak</span>
                        aktif saat ini
                    </p>
                </div>

                {{-- Tagihan Pending --}}
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                            bg-white dark:bg-slate-900 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Tagihan Pending</p>
                        <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center">
                            <i class="fa-solid fa-file-invoice-dollar text-amber-600 dark:text-amber-400 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 dark:text-slate-100">
                        {{ $tagihanBelumBayar + $tagihanMenunggu }}
                    </p>
                    <div class="flex items-center gap-3 mt-2 text-xs text-slate-400 dark:text-slate-500">
                        <span class="text-rose-600 dark:text-rose-400 font-medium">{{ $tagihanBelumBayar }} belum bayar</span>
                        <span>·</span>
                        <span class="text-amber-600 dark:text-amber-400 font-medium">{{ $tagihanMenunggu }} menunggu</span>
                    </div>
                </div>

                {{-- Total Pemasukan --}}
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                            bg-white dark:bg-slate-900 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Total Pemasukan</p>
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center">
                            <i class="fa-solid fa-money-bill-trend-up text-emerald-600 dark:text-emerald-400 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </p>
                    <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">Dari tagihan lunas</p>
                </div>
            </div>

            {{--  STATUS KAMAR BAR  --}}
            @php
                $total         = $totalKamar ?: 1;
                $pctTersedia   = round(($kamarTersedia / $total) * 100);
                $pctTerisi     = round(($kamarTerisi / $total) * 100);
                $pctLainnya    = max(0, 100 - $pctTersedia - $pctTerisi);
            @endphp
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Okupansi Kamar</p>
                    <span class="text-xs text-slate-400 dark:text-slate-500">{{ $totalKamar }} kamar total</span>
                </div>

                <div class="flex h-3 rounded-full overflow-hidden gap-0.5 mb-3">
                    @if ($pctTerisi > 0)
                        <div class="bg-indigo-500 rounded-l-full transition-all" style="width: {{ $pctTerisi }}%"></div>
                    @endif
                    @if ($pctTersedia > 0)
                        <div class="bg-emerald-400 transition-all" style="width: {{ $pctTersedia }}%"></div>
                    @endif
                    @if ($pctLainnya > 0)
                        <div class="bg-red-400 rounded-r-full transition-all" style="width: {{ $pctLainnya }}%"></div>
                    @endif
                </div>

                <div class="flex items-center gap-5 text-xs text-slate-500 dark:text-slate-400">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 inline-block"></span>
                        Terisi ({{ $kamarTerisi }})
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 inline-block"></span>
                        Tersedia ({{ $kamarTersedia }})
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-400 inline-block"></span>
                        Maintenance ({{ $totalKamar - $kamarTersedia - $kamarTerisi }})
                    </span>
                </div>
            </div>

            {{--  TABEL + PENGADUAN  --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Tagihan Perlu Perhatian --}}
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                            bg-white dark:bg-slate-900 overflow-hidden">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="font-semibold text-slate-900 dark:text-slate-100">Tagihan Perlu Perhatian</h3>
                        <a href="{{route('tagihan.index')}}"
                           class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                            Lihat semua
                        </a>
                    </div>

                    @if ($tagihanTerbaru->isEmpty())
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <i class="fa-solid fa-circle-check text-2xl text-emerald-400 mb-2"></i>
                            <p class="text-sm text-slate-400 dark:text-slate-500">Semua tagihan sudah lunas</p>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($tagihanTerbaru as $tagihan)
                                <div class="flex items-center justify-between gap-3 px-5 py-3.5">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500
                                                    text-white flex items-center justify-center font-semibold text-xs shrink-0">
                                            {{ strtoupper(substr($tagihan->kontrak->user->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-slate-800 dark:text-slate-100 truncate">
                                                {{ $tagihan->kontrak->user->name }}
                                            </p>
                                            <p class="text-xs text-slate-400 dark:text-slate-500">
                                                Kamar {{ $tagihan->kontrak->kamar->no_kamar }} ·
                                                {{ \Carbon\Carbon::createFromDate($tagihan->tahun, $tagihan->bulan, 1)->translatedFormat('M Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 shrink-0">
                                        <span class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                            Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                                        </span>
                                        @if ($tagihan->status === 'menunggu')
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
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Pengaduan Terbaru --}}
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                            bg-white dark:bg-slate-900 overflow-hidden">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="font-semibold text-slate-900 dark:text-slate-100">Pengaduan Aktif</h3>
                        <div class="flex items-center gap-3">
                            @if ($pengaduanPending + $pengaduanDiproses > 0)
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                             bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-400">
                                    {{ $pengaduanPending + $pengaduanDiproses }} aktif
                                </span>
                            @endif
                            <a href="{{ route('pengaduan.index') }}"
                               class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                Lihat semua
                            </a>
                        </div>
                    </div>

                    @if ($pengaduanTerbaru->isEmpty())
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <i class="fa-solid fa-circle-check text-2xl text-emerald-400 mb-2"></i>
                            <p class="text-sm text-slate-400 dark:text-slate-500">Tidak ada pengaduan aktif</p>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($pengaduanTerbaru as $pengaduan)
                                <div class="flex items-center justify-between gap-3 px-5 py-3.5">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center
                                                    {{ $pengaduan->status === 'diproses'
                                                        ? 'bg-amber-50 dark:bg-amber-500/10'
                                                        : 'bg-slate-100 dark:bg-slate-800' }}">
                                            <i class="fa-solid fa-triangle-exclamation text-sm
                                                       {{ $pengaduan->status === 'diproses'
                                                           ? 'text-amber-500 dark:text-amber-400'
                                                           : 'text-slate-400' }}"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-slate-800 dark:text-slate-100 truncate">
                                                {{ $pengaduan->judul }}
                                            </p>
                                            <p class="text-xs text-slate-400 dark:text-slate-500">
                                                {{ $pengaduan->user->name }} · Kamar {{ $pengaduan->kamar->no_kamar }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="shrink-0">
                                        @if ($pengaduan->status === 'diproses')
                                            <span class="text-xs font-medium px-2 py-0.5 rounded-md
                                                         bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                                Diproses
                                            </span>
                                        @else
                                            <span class="text-xs font-medium px-2 py-0.5 rounded-md
                                                         bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                                Pending
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{--  SHORTCUT AKSI  --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="{{ route('kamar.create') }}"
                   class="flex flex-col items-center gap-2.5 p-4 rounded-2xl border border-slate-200 dark:border-slate-800
                          bg-white dark:bg-slate-900 hover:border-indigo-200 dark:hover:border-indigo-500/40
                          hover:shadow-sm transition-all text-center group">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center
                                group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                        <i class="fa-solid fa-door-closed text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Tambah Kamar</span>
                </a>

                <a href="{{ route('user.create') }}"
                   class="flex flex-col items-center gap-2.5 p-4 rounded-2xl border border-slate-200 dark:border-slate-800
                          bg-white dark:bg-slate-900 hover:border-violet-200 dark:hover:border-violet-500/40
                          hover:shadow-sm transition-all text-center group">
                    <div class="w-10 h-10 rounded-xl bg-violet-50 dark:bg-violet-500/10 flex items-center justify-center
                                group-hover:bg-violet-100 dark:group-hover:bg-violet-500/20 transition-colors">
                        <i class="fa-solid fa-user-plus text-violet-600 dark:text-violet-400"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Tambah Penyewa</span>
                </a>

                <a href="{{ route('kontrak.create') }}"
                   class="flex flex-col items-center gap-2.5 p-4 rounded-2xl border border-slate-200 dark:border-slate-800
                          bg-white dark:bg-slate-900 hover:border-emerald-200 dark:hover:border-emerald-500/40
                          hover:shadow-sm transition-all text-center group">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center
                                group-hover:bg-emerald-100 dark:group-hover:bg-emerald-500/20 transition-colors">
                        <i class="fa-solid fa-file-signature text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Buat Kontrak</span>
                </a>

                <a href=""
                   class="flex flex-col items-center gap-2.5 p-4 rounded-2xl border border-slate-200 dark:border-slate-800
                          bg-white dark:bg-slate-900 hover:border-amber-200 dark:hover:border-amber-500/40
                          hover:shadow-sm transition-all text-center group">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center
                                group-hover:bg-amber-100 dark:group-hover:bg-amber-500/20 transition-colors">
                        <i class="fa-solid fa-file-invoice-dollar text-amber-600 dark:text-amber-400"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Generate Tagihan</span>
                </a>
            </div>

        </main>
    </div>
</div>
@endsection
