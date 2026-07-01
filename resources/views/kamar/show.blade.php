@extends('layouts.admin')

@section('content')
<div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
    <div class="flex-1 flex flex-col overflow-hidden">
        <main class="flex-1 overflow-y-auto p-6">

            {{-- Back link --}}
            <a href="{{ route('kamar.index') }}"
               class="inline-flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400
                      hover:text-slate-800 dark:hover:text-slate-200 transition-colors mb-5">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali ke daftar kamar
            </a>

            <div class="w-full mx-auto">
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                            bg-white dark:bg-slate-900 overflow-hidden">

                    {{-- Foto --}}
                    <div class="relative h-64 sm:h-80 bg-gradient-to-br from-indigo-50 to-violet-50
                                dark:from-indigo-500/10 dark:to-violet-500/10
                                flex items-center justify-center overflow-hidden">
                        @if ($kamar->foto)
                            <img src="{{ asset('storage/' . $kamar->foto) }}"
                                 alt="Kamar {{ $kamar->no_kamar }}"
                                 class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-bed text-6xl text-indigo-300 dark:text-indigo-500/40"></i>
                        @endif
                    </div>

                    {{-- Konten --}}
                    <div class="p-6 sm:p-8">
                        @php
                            $badge = match($kamar->status) {
                                'tersedia'    => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400',
                                'diisi'       => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-400',
                                'maintenance' => 'bg-red-100 text-red-700 dark:bg-red-500/15 dark:text-red-400',
                                default       => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400',
                            };
                        @endphp

                        <div class="flex flex-wrap gap-3 mb-5">
                            {{-- Badge Status --}}
                            <span class="px-5 py-2.5 rounded-lg text-sm font-medium {{ $badge }}">
                                <i class="fa-solid fa-circle-dot mr-1.5"></i>
                                {{ ucfirst($kamar->status) }}
                            </span>

                            {{-- Badge Tipe --}}
                            <span class="px-5 py-2.5 rounded-lg text-sm font-medium
                                        bg-slate-100 dark:bg-slate-800
                                        text-slate-700 dark:text-slate-300 capitalize">
                                <i class="fa-solid fa-bed mr-1.5"></i>
                                {{ ucfirst($kamar->tipe) }}
                            </span>
                        </div>

                        <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100 mb-1">
                            Kamar {{ $kamar->no_kamar }}
                        </h1>

                        <p class="text-3xl font-semibold text-indigo-700 dark:text-indigo-400 mb-6">
                            Rp {{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}
                            <span class="text-base font-normal text-slate-400">/bulan</span>
                        </p>

                        {{-- Info masa sewa — tampil kalau penyewa menghuni kamar ini --}}
                        @if ($kontrakAktif ?? false)
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6 p-4 rounded-xl
                                        bg-slate-50 dark:bg-slate-800/60">
                                <div>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-0.5">Tanggal Masuk</p>
                                    <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                        {{ $kontrakAktif->tgl_masuk->format('d M Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-0.5">Sewa Berakhir</p>
                                    <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                        {{ $kontrakAktif->tgl_selesai->format('d M Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-0.5">Deposit</p>
                                    <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                        Rp {{ number_format($kontrakAktif->deposit, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- Fasilitas --}}
                        <div class="mb-6">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-2">
                                Fasilitas
                            </p>
                            <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                                {{ $kamar->fasilitas }}
                            </p>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-8">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-2">
                                Deskripsi
                            </p>
                            <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                                {{ $kamar->deskripsi ?? 'Tidak ada deskripsi tambahan untuk kamar ini.' }}
                            </p>
                        </div>

                        {{-- Aksi --}}
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('kamar.index') }}"
                               class="px-5 py-2.5 rounded-lg text-sm font-medium
                                      text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800
                                      hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                Kembali
                            </a>

                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('kamar.edit', $kamar->id) }}"
                                   class="px-5 py-2.5 rounded-lg text-sm font-medium text-white
                                          bg-amber-500 hover:bg-amber-600 transition-colors">
                                    <i class="fa-solid fa-pen-to-square mr-1.5"></i>Edit
                                </a>

                                <form method="POST" action="{{ route('kamar.destroy', $kamar->id) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus kamar {{ $kamar->no_kamar }}? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-5 py-2.5 rounded-lg text-sm font-medium
                                                   text-white bg-rose-600 hover:bg-rose-700 transition-colors">
                                        <i class="fa-solid fa-trash mr-1.5"></i>Hapus
                                    </button>
                                </form>
                            @else
                                @if ($kamar->status === 'tersedia')
                                    <a href="{{route('kontrak.create', ['kamar_id' => $kamar->id])}}" type="button"
                                            class="px-5 py-2.5 rounded-lg text-sm font-medium text-white
                                                   bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                        Ajukan Sewa
                                    </a>
                                @endif

                                @if ($kontrakAktif ?? false)
                                    <a href="{{ route('pengaduan.create', ['kamar_id' => $kamar->id]) }}"
                                       class="px-5 py-2.5 rounded-lg text-sm font-medium
                                              text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10
                                              hover:bg-rose-100 dark:hover:bg-rose-500/20 transition-colors">
                                        <i class="fa-solid fa-triangle-exclamation mr-1.5"></i>Laporkan Masalah
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
