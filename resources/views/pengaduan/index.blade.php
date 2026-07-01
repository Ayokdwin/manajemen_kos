@extends('layouts.admin')

@section('content')
@php
$no = 1;
@endphp
<div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
    <div class="flex-1 flex flex-col overflow-hidden">
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
            <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Pengaduan</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Kelola seluruh pengaduan yang masuk di sistem.
                    </p>
                    
                </div>
                 @if( auth()->user()->role === 'user')
                <a href="{{ route('pengaduan.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5
                        text-sm font-medium text-white hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-plus"></i>
                    Buat Laporan
                </a>
                @endif
            </div>

            {{-- Search & filter --}}
            <form method="GET" action="{{ route('pengaduan.index') }}"
                  class="flex flex-wrap items-center gap-3 mb-5">
                <div class="relative flex-1 min-w-[220px] max-w-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari judul atau deskripsi..."
                        class="w-full pl-9 pr-3.5 py-2.5 rounded-lg text-sm
                               bg-white dark:bg-slate-900
                               border border-slate-200 dark:border-slate-800
                               text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                               focus:border-indigo-400 dark:focus:border-indigo-500
                               focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                               outline-none transition-colors"
                    >
                </div>

                <button type="submit"
                        class="px-4 py-2.5 rounded-lg text-sm font-medium
                               text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-900
                               border border-slate-200 dark:border-slate-800
                               hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    Cari
                </button>

                @if (request('search'))
                    <a href="{{ route('pengaduan.index') }}"
                       class="text-sm text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 transition-colors">
                        Reset
                    </a>
                @endif
            </form>

            {{-- Table --}}
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                        bg-white dark:bg-slate-900 overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                                <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">No</th>
                                <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Nama</th>
                                <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Judul</th>
                                <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Deskripsi</th>
                                <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Kamar</th>
                                <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Status</th>
                                <th class="text-right font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($pengaduans as $pengaduan)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">

                                 {{-- Nomor --}}
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                           
                                            <p class="font-medium text-slate-900 dark:text-slate-100 truncate">
                                                {{ $no++}}
                                            </p>
                                        </div>
                                    </td>

                                {{-- Judul --}}
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                           
                                            <p class="font-medium text-slate-900 dark:text-slate-100 truncate">
                                                {{ $pengaduan->user->name }}
                                            </p>
                                        </div>
                                    </td>

                                    {{-- Judul --}}
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                           
                                            <p class="font-medium text-slate-900 dark:text-slate-100 truncate">
                                                {{ $pengaduan->judul }}
                                            </p>
                                        </div>
                                    </td>

                                    {{-- Deskripsi --}}
                                    <td class="px-5 py-3.5 max-w-xs">
                                        <p class="text-slate-700 dark:text-slate-200 truncate">
                                            {{ $pengaduan->diskripsi }}
                                        </p>
                                    </td>

                                    {{-- Kamar --}}
                                    <td class="px-5 py-3.5">
                                        <span class="text-slate-700 dark:text-slate-200">
                                            {{ $pengaduan->kamar->no_kamar}}
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-5 py-3.5">
                                        @if($pengaduan->status === 'selesai')
                                            <span class="inline-flex items-center text-xs font-medium px-2 py-1 rounded-md
                                                         bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                                Selesai
                                            </span>
                                        @elseif($pengaduan->status === 'diproses')
                                            <span class="inline-flex items-center text-xs font-medium px-2 py-1 rounded-md
                                                         bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                                Diproses
                                            </span>
                                        @else
                                            <span class="inline-flex items-center text-xs font-medium px-2 py-1 rounded-md
                                                         bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                                Pending
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-5 py-3.5 text-right">
                                        <div class="inline-flex items-center gap-1.5">
                                            <a href=""
                                               class="w-8 h-8 inline-flex items-center justify-center rounded-lg
                                                      text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400
                                                      hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-colors">
                                                <i class="fa-solid fa-eye text-sm"></i>
                                            </a>

                                            <a href=""
                                               class="w-8 h-8 inline-flex items-center justify-center rounded-lg
                                                      text-slate-400 hover:text-amber-600 dark:hover:text-amber-400
                                                      hover:bg-amber-50 dark:hover:bg-amber-500/10 transition-colors">
                                                <i class="fa-solid fa-pen text-sm"></i>
                                            </a>

                                            <form method="POST" action=""
                                                  onsubmit="return confirm('Hapus pengaduan ini? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="w-8 h-8 inline-flex items-center justify-center rounded-lg
                                                               text-slate-400 hover:text-rose-600 dark:hover:text-rose-400
                                                               hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-slate-400 dark:text-slate-500">
                                        <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
                                        Belum ada pengaduan yang masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

               
            </div>
        </main>
    </div>
</div>
@endsection