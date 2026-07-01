@extends('layouts.admin')

@section('content')
<div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
    <div class="flex-1 flex flex-col overflow-hidden"
         x-data="{ tab: '{{ auth()->user()->role === 'admin' ? 'semua' : 'tersedia' }}' }">
        <main class="flex-1 overflow-y-auto p-6">

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

            {{-- Page header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Kamar</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                        {{ auth()->user()->role === 'admin'
                            ? 'Kelola data kamar yang tersedia untuk disewakan.'
                            : 'Lihat kamar tersedia atau kamar yang sedang Anda huni.' }}
                    </p>
                </div>

                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('kamar.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium
                              text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        <i class="fa-solid fa-plus text-xs"></i>
                        Tambah Kamar
                    </a>
                @endif
            </div>

            {{-- Tabs --}}
            <div class="flex items-center gap-1 mb-6 border-b border-slate-200 dark:border-slate-800">
                @if (auth()->user()->role === 'admin')
                    <button type="button" @click="tab = 'semua'"
                            :class="tab === 'semua'
                                ? 'border-indigo-600 text-indigo-700 dark:text-indigo-400'
                                : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'"
                            class="px-4 py-2.5 text-sm font-medium border-b-2 transition-colors -mb-px">
                        Semua
                        <span class="ml-1.5 text-xs font-semibold px-1.5 py-0.5 rounded-full
                                     bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                            {{ $semuaKamar->count() }}
                        </span>
                    </button>
                @endif

                <button type="button" @click="tab = 'tersedia'"
                        :class="tab === 'tersedia'
                            ? 'border-indigo-600 text-indigo-700 dark:text-indigo-400'
                            : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'"
                        class="px-4 py-2.5 text-sm font-medium border-b-2 transition-colors -mb-px">
                    Tersedia
                    <span class="ml-1.5 text-xs font-semibold px-1.5 py-0.5 rounded-full
                                 bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                        {{ $kamarTersedia->count() }}
                    </span>
                </button>

                <button type="button" @click="tab = 'saya'"
                        :class="tab === 'saya'
                            ? 'border-indigo-600 text-indigo-700 dark:text-indigo-400'
                            : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'"
                        class="px-4 py-2.5 text-sm font-medium border-b-2 transition-colors -mb-px">
                    Kamar Saya
                    <span class="ml-1.5 text-xs font-semibold px-1.5 py-0.5 rounded-full
                                 bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                        {{ $kamarSaya->count() }}
                    </span>
                </button>
            </div>

            {{-- ====================== TAB: SEMUA (admin only) ====================== --}}
            @if (auth()->user()->role === 'admin')
                <div x-show="tab === 'semua'" x-cloak>
                    @if ($semuaKamar->isEmpty())
                        <div class="flex flex-col items-center justify-center text-center py-20">
                            <div class="w-14 h-14 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                                <i class="fa-solid fa-bed text-slate-400 text-xl"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-200">Belum ada data kamar</p>
                            <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">
                                Klik "Tambah Kamar" untuk menambahkan kamar baru.
                            </p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                            @foreach ($semuaKamar as $kamar)
                                @php
                                    $badge = match($kamar->status) {
                                        'tersedia'    => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                                        'diisi'       => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300',
                                        'maintenance' => 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-300',
                                        default       => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                                    };
                                @endphp
                                <a href="{{ route('kamar.show', $kamar->id) }}"
                                   class="group rounded-xl border border-slate-200 dark:border-slate-800
                                          bg-white dark:bg-slate-900 overflow-hidden
                                          hover:shadow-md hover:border-indigo-200 dark:hover:border-indigo-500/40
                                          transition-all duration-150">

                                    <div class="relative h-40 bg-gradient-to-br from-indigo-50 to-violet-50
                                                dark:from-indigo-500/10 dark:to-violet-500/10
                                                flex items-center justify-center overflow-hidden">
                                        @if ($kamar->foto)
                                            <img src="{{ asset('storage/' . $kamar->foto) }}"
                                                 alt="Kamar {{ $kamar->no_kamar }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <i class="fa-solid fa-bed text-4xl text-indigo-300 dark:text-indigo-500/40"></i>
                                        @endif

                                        <span class="absolute top-3 left-3 text-xs font-semibold px-2 py-1 rounded-md {{ $badge }}">
                                            {{ ucfirst($kamar->status) }}
                                        </span>
                                        <span class="absolute top-3 right-3 text-xs font-medium px-2 py-1 rounded-md
                                                     bg-white/90 dark:bg-slate-900/80 text-slate-600 dark:text-slate-300
                                                     backdrop-blur-sm capitalize">
                                            {{ $kamar->tipe }}
                                        </span>
                                    </div>

                                    <div class="p-4">
                                        <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-1.5">
                                            Kamar {{ $kamar->no_kamar }}
                                        </h3>
                                        <p class="text-lg font-semibold text-indigo-700 dark:text-indigo-400">
                                            Rp {{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}
                                            <span class="text-xs font-normal text-slate-400">/bulan</span>
                                        </p>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 line-clamp-2">
                                            {{ $kamar->fasilitas }}
                                        </p>
                                        <span class="mt-3 block w-full text-center text-sm font-medium py-2 rounded-lg
                                                     text-indigo-700 bg-indigo-50 dark:bg-indigo-500/10 dark:text-indigo-400
                                                     group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                            Lihat Detail
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            {{-- ====================== TAB: TERSEDIA ====================== --}}
            <div x-show="tab === 'tersedia'" x-cloak>
                @if ($kamarTersedia->isEmpty())
                    <div class="flex flex-col items-center justify-center text-center py-20">
                        <div class="w-14 h-14 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-door-open text-slate-400 text-xl"></i>
                        </div>
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">Belum ada kamar tersedia</p>
                        <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">Coba periksa kembali nanti.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach ($kamarTersedia as $kamar)
                            <a href="{{ route('kamar.show', $kamar->id) }}"
                               class="group rounded-xl border border-slate-200 dark:border-slate-800
                                      bg-white dark:bg-slate-900 overflow-hidden
                                      hover:shadow-md hover:border-indigo-200 dark:hover:border-indigo-500/40
                                      transition-all duration-150">

                                <div class="relative h-40 bg-gradient-to-br from-indigo-50 to-violet-50
                                            dark:from-indigo-500/10 dark:to-violet-500/10
                                            flex items-center justify-center overflow-hidden">
                                    @if ($kamar->foto)
                                        <img src="{{ asset('storage/' . $kamar->foto) }}"
                                             alt="Kamar {{ $kamar->no_kamar }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <i class="fa-solid fa-bed text-4xl text-indigo-300 dark:text-indigo-500/40"></i>
                                    @endif

                                    <span class="absolute top-3 left-3 text-xs font-semibold px-2 py-1 rounded-md
                                                 bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                        Tersedia
                                    </span>
                                    <span class="absolute top-3 right-3 text-xs font-medium px-2 py-1 rounded-md
                                                 bg-white/90 dark:bg-slate-900/80 text-slate-600 dark:text-slate-300
                                                 backdrop-blur-sm capitalize">
                                        {{ $kamar->tipe }}
                                    </span>
                                </div>

                                <div class="p-4">
                                    <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-1.5">
                                        Kamar {{ $kamar->no_kamar }}
                                    </h3>
                                    <p class="text-lg font-semibold text-indigo-700 dark:text-indigo-400">
                                        Rp {{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}
                                        <span class="text-xs font-normal text-slate-400">/bulan</span>
                                    </p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 line-clamp-2">
                                        {{ $kamar->fasilitas }}
                                    </p>
                                    <span class="mt-3 block w-full text-center text-sm font-medium py-2 rounded-lg
                                                 text-indigo-700 bg-indigo-50 dark:bg-indigo-500/10 dark:text-indigo-400
                                                 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                        Lihat Detail
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ====================== TAB: KAMAR SAYA ====================== --}}
            <div x-show="tab === 'saya'" x-cloak>
                @if ($kamarSaya->isEmpty())
                    <div class="flex flex-col items-center justify-center text-center py-20">
                        <div class="w-14 h-14 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-house-circle-xmark text-slate-400 text-xl"></i>
                        </div>
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">Anda belum menghuni kamar mana pun</p>
                        <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">
                            Pilih kamar dari tab "Tersedia" untuk mengajukan sewa.
                        </p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach ($kamarSaya as $kamar)
                            @php $kontrakAktif = $kamar->kontrak->first(); @endphp
                            <a href="{{ route('kamar.show', $kamar->id) }}"
                               class="group rounded-xl border border-slate-200 dark:border-slate-800
                                      bg-white dark:bg-slate-900 overflow-hidden
                                      hover:shadow-md hover:border-indigo-200 dark:hover:border-indigo-500/40
                                      transition-all duration-150">

                                <div class="relative h-40 bg-gradient-to-br from-indigo-50 to-violet-50
                                            dark:from-indigo-500/10 dark:to-violet-500/10
                                            flex items-center justify-center overflow-hidden">
                                    @if ($kamar->foto)
                                        <img src="{{ asset('storage/' . $kamar->foto) }}"
                                             alt="Kamar {{ $kamar->no_kamar }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <i class="fa-solid fa-bed text-4xl text-indigo-300 dark:text-indigo-500/40"></i>
                                    @endif

                                    <span class="absolute top-3 left-3 text-xs font-semibold px-2 py-1 rounded-md
                                                 bg-indigo-100 text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-400">
                                        Dihuni
                                    </span>
                                    <span class="absolute top-3 right-3 text-xs font-medium px-2 py-1 rounded-md
                                                 bg-white/90 dark:bg-slate-900/80 text-slate-600 dark:text-slate-300
                                                 backdrop-blur-sm capitalize">
                                        {{ $kamar->tipe }}
                                    </span>
                                </div>

                                <div class="p-4">
                                    <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-1.5">
                                        Kamar {{ $kamar->no_kamar }}
                                    </h3>
                                    <p class="text-lg font-semibold text-indigo-700 dark:text-indigo-400">
                                        Rp {{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}
                                        <span class="text-xs font-normal text-slate-400">/bulan</span>
                                    </p>
                                    @if ($kontrakAktif)
                                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
                                            <i class="fa-regular fa-calendar w-4 text-center mr-1"></i>
                                            Sewa hingga {{ $kontrakAktif->tgl_selesai?->format('d M Y') ?? '-' }}
                                        </p>
                                    @endif
                                    <span class="mt-3 block w-full text-center text-sm font-medium py-2 rounded-lg
                                                 text-slate-600 bg-slate-100 dark:bg-slate-800 dark:text-slate-300
                                                 group-hover:bg-slate-200 dark:group-hover:bg-slate-700 transition-colors">
                                        Lihat Detail
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
