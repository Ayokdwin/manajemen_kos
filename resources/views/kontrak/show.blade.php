@extends('layouts.admin')

@section('content')
    <div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-y-auto p-6">
                {{-- Back link --}}
                <a href="{{ route('kontrak.index') }}"
                   class="inline-flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400
                          hover:text-slate-800 dark:hover:text-slate-200 transition-colors mb-5">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Kembali ke daftar kontrak
                </a>

                {{-- Flash message --}}
                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-emerald-200 dark:border-emerald-500/30
                                bg-emerald-50 dark:bg-emerald-500/10 p-4 flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        <p class="text-sm font-medium text-emerald-700 dark:text-emerald-400">
                            {{ session('success') }}
                        </p>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- ============ KOLOM KIRI ============ --}}
                    <div class="lg:col-span-1 space-y-6">

                        {{-- Status kontrak --}}
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                    bg-white dark:bg-slate-900 p-6">

                            <div class="flex items-center justify-between mb-4">
                                <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase">
                                    Status Kontrak
                                </p>
                                @if ($kontrak->status === 'aktif')
                                    <span class="text-xs font-medium px-2 py-1 rounded-md
                                                 bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                        Aktif
                                    </span>
                                @else
                                    <span class="text-xs font-medium px-2 py-1 rounded-md
                                                 bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                        Selesai
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-500/10
                                                flex items-center justify-center shrink-0">
                                        <i class="fa-regular fa-calendar text-indigo-600 dark:text-indigo-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Tanggal Masuk</p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                            @if ($kontrak->tanggal_masuk)
                                                {{ $kontrak->tanggal_masuk->format('d M Y') }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-rose-50 dark:bg-rose-500/10
                                                flex items-center justify-center shrink-0">
                                        <i class="fa-regular fa-calendar-xmark text-rose-500 dark:text-rose-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Tanggal Selesai</p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                            @if ($kontrak->tanggal_selesai)
                                                {{ $kontrak->tanggal_selesai->format('d M Y') }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-violet-50 dark:bg-violet-500/10
                                                flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-coins text-violet-500 dark:text-violet-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Deposit</p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                            Rp {{ number_format($kontrak->deposit, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Aksi --}}
                            <div class="mt-5 pt-5 border-t border-slate-100 dark:border-slate-800 space-y-2">
                                <a href="{{ route('kontrak.edit', $kontrak->id) }}"
                                   class="flex items-center justify-center gap-2 w-full py-2 rounded-lg text-sm font-medium
                                          text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800
                                          hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                    <i class="fa-solid fa-pen text-xs"></i>Edit Kontrak
                                </a>
                                {{--approval--}}
                       
                                 @if (auth()->user()->role === 'admin'&& $kontrak->approval_status == 'pending')
                               <form method="POST" action="{{ route('kontrak.approve', $kontrak->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="flex items-center justify-center gap-2 w-full py-2 rounded-lg text-sm font-medium
                                            text-white bg-green-600 dark:bg-green-500
                                            hover:bg-green-700 dark:hover:bg-green-600
                                            transition-colors duration-200">
                                        <i class="fa-solid fa-check text-xs"></i>
                                        Approve Kontrak
                                    </button>
                                </form>
                                #reject
                               <form method="POST" action="{{ route('kontrak.reject', $kontrak->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="flex items-center justify-center gap-2 w-full py-2 rounded-lg text-sm font-medium
                                            text-white bg-red-600 dark:bg-red-500
                                            hover:bg-red-700 dark:hover:bg-red-600
                                            transition-colors duration-200">
                                        <i class="fa-solid fa-times text-xs"></i>
                                        Reject Kontrak
                                    </button>
                                </form>
                                @endif

                                @if ($kontrak->status === 'aktif')
                                    <form method="POST" action="{{ route('kontrak.update', $kontrak->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="selesai">
                                        <input type="hidden" name="user_id" value="{{ $kontrak->user_id }}">
                                        <input type="hidden" name="kamar_id" value="{{ $kontrak->kamar_id }}">
                                        <input type="hidden" name="tanggal_masuk" value="{{ $kontrak->tanggal_masuk->format('Y-m-d') }}">
                                        <input type="hidden" name="tanggal_selesai" value="{{ $kontrak->tanggal_selesai->format('Y-m-d') }}">
                                        <input type="hidden" name="deposit" value="{{ $kontrak->deposit }}">
                                        <button type="submit"
                                                onclick="return confirm('Tandai kontrak ini sebagai selesai? Status kamar akan kembali jadi tersedia.')"
                                                class="w-full flex items-center justify-center gap-2 py-2 rounded-lg text-sm font-medium
                                                       text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10
                                                       hover:bg-rose-100 dark:hover:bg-rose-500/20 transition-colors">
                                            <i class="fa-solid fa-circle-xmark text-xs"></i>Selesaikan Kontrak
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        {{-- Info Penyewa --}}
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                    bg-white dark:bg-slate-900 p-6">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-4">
                                Penyewa
                            </p>

                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500
                                            text-white flex items-center justify-center font-semibold shrink-0">
                                    {{ strtoupper(substr($kontrak->user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-slate-900 dark:text-slate-100 truncate">
                                        {{ $kontrak->user->name }}
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 truncate">
                                        {{ $kontrak->user->email }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-2 text-sm">
                                <div class="flex items-center gap-2 text-slate-600 dark:text-slate-300">
                                    <i class="fa-solid fa-phone w-4 text-center text-slate-400 text-xs"></i>
                                    {{ $kontrak->user->no_hp }}
                                </div>
                            </div>

                            <a href="{{ route('user.show', $kontrak->user->id) }}"
                               class="mt-4 block text-center text-sm font-medium py-2 rounded-lg
                                      text-indigo-700 bg-indigo-50 dark:bg-indigo-500/10 dark:text-indigo-400
                                      hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition-colors">
                                Lihat Profil Penyewa
                            </a>
                        </div>

                        {{-- Info Kamar --}}
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                    bg-white dark:bg-slate-900 p-6">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-4">
                                Kamar
                            </p>

                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-11 h-11 rounded-lg bg-indigo-50 dark:bg-indigo-500/10
                                            flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-door-closed text-indigo-600 dark:text-indigo-400"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-slate-100">
                                        Kamar {{ $kontrak->kamar->nomor_kamar }}
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 capitalize">
                                        Tipe {{ $kontrak->kamar->tipe }}
                                    </p>
                                </div>
                            </div>

                            <div class="text-sm text-slate-600 dark:text-slate-300 mb-1">
                                <span class="text-slate-400 dark:text-slate-500 text-xs">Harga</span><br>
                                <span class="font-medium text-indigo-700 dark:text-indigo-400">
                                    Rp {{ number_format($kontrak->kamar->harga_per_bulan, 0, ',', '.') }}
                                </span>
                                <span class="text-xs text-slate-400">/bulan</span>
                            </div>

                            <a href="{{ route('kamar.show', $kontrak->kamar->id) }}"
                               class="mt-4 block text-center text-sm font-medium py-2 rounded-lg
                                      text-indigo-700 bg-indigo-50 dark:bg-indigo-500/10 dark:text-indigo-400
                                      hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition-colors">
                                Lihat Detail Kamar
                            </a>
                        </div>
                    </div>

                    {{-- ============ KOLOM KANAN: TAGIHAN ============ --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Header tagihan + tombol generate --}}
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                    bg-white dark:bg-slate-900 overflow-hidden">

                            <div class="flex items-center justify-between gap-3 px-6 py-4
                                        border-b border-slate-100 dark:border-slate-800">
                                <h3 class="font-semibold text-slate-900 dark:text-slate-100">Tagihan Bulanan</h3>

                               
                            </div>

                            @if ($kontrak->tagihan->isEmpty())
                                <div class="flex flex-col items-center justify-center text-center py-12">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800
                                                flex items-center justify-center mb-3">
                                        <i class="fa-solid fa-file-invoice-dollar text-slate-400"></i>
                                    </div>
                                    <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                        Belum ada tagihan
                                    </p>
                                    <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">
                                        Klik "Generate Tagihan" untuk membuat tagihan bulan ini.
                                    </p>
                                </div>
                            @else
                                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @foreach ($kontrak->tagihan->sortByDesc(fn($t) => [$t->tahun, $t->bulan]) as $tagihan)
                                        <div class="flex items-center justify-between gap-4 px-6 py-4">
                                            <div class="flex items-center gap-3 min-w-0">
                                                {{-- Ikon status pembayaran --}}
                                                @if ($tagihan->status === 'lunas')
                                                    <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-500/10
                                                                flex items-center justify-center shrink-0">
                                                        <i class="fa-solid fa-circle-check text-emerald-500 dark:text-emerald-400 text-sm"></i>
                                                    </div>
                                                @elseif ($tagihan->status === 'menunggu')
                                                    <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-500/10
                                                                flex items-center justify-center shrink-0">
                                                        <i class="fa-solid fa-clock text-amber-500 dark:text-amber-400 text-sm"></i>
                                                    </div>
                                                @else
                                                    <div class="w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-800
                                                                flex items-center justify-center shrink-0">
                                                        <i class="fa-solid fa-file-invoice-dollar text-slate-400 text-sm"></i>
                                                    </div>
                                                @endif

                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-100">
                                                        {{ \Carbon\Carbon::createFromDate($tagihan->tahun, $tagihan->bulan, 1)->translatedFormat('F Y') }}
                                                    </p>
                                                    <p class="text-xs text-slate-400 dark:text-slate-500">
                                                        Periode tagihan
                                                    </p>
                                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">
                                                        Jatuh tempo {{ $tagihan->tanggal_jatuh_tempo->format('d M Y') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-3 shrink-0">
                                                <div class="text-right">
                                                    <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                                        Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                                                    </p>

                                                    {{-- Badge status --}}
                                                    @if ($tagihan->status === 'lunas')
                                                        <span class="text-xs font-medium px-2 py-0.5 rounded-md
                                                                     bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                                            Lunas
                                                        </span>
                                                    @elseif ($tagihan->status === 'menunggu')
                                                        <span class="text-xs font-medium px-2 py-0.5 rounded-md
                                                                     bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                                            Menunggu Verifikasi
                                                        </span>
                                                    @else
                                                        <span class="text-xs font-medium px-2 py-0.5 rounded-md
                                                                     bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-400">
                                                            Belum Bayar
                                                        </span>
                                                    @endif
                                                </div>

                                                <a href=""
                                                   class="w-8 h-8 inline-flex items-center justify-center rounded-lg
                                                          text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400
                                                          hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-colors">
                                                    <i class="fa-solid fa-eye text-sm"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Ringkasan total --}}
                                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800
                                            bg-slate-50 dark:bg-slate-800/40">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-slate-500 dark:text-slate-400">Total Tagihan</span>
                                        <span class="font-semibold text-slate-900 dark:text-slate-100">
                                            Rp {{ number_format($kontrak->tagihan->sum('jumlah_tagihan'), 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm mt-1">
                                        <span class="text-slate-500 dark:text-slate-400">Sudah Lunas</span>
                                        <span class="font-semibold text-emerald-600 dark:text-emerald-400">
                                            Rp {{ number_format($kontrak->tagihan->where('status', 'lunas')->sum('jumlah_tagihan'), 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm mt-1">
                                        <span class="text-slate-500 dark:text-slate-400">Belum Lunas</span>
                                        <span class="font-semibold text-rose-600 dark:text-rose-400">
                                            Rp {{ number_format($kontrak->tagihan->whereNotIn('status', ['lunas'])->sum('jumlah_tagihan'), 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
