@extends('layouts.admin')

@section('content')
<div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
    <div class="flex-1 flex flex-col overflow-hidden">
        <main class="flex-1 overflow-y-auto p-6">

            {{-- Back link --}}
            <a href="{{ route('pengaduan.index') }}"
               class="inline-flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400
                      hover:text-slate-800 dark:hover:text-slate-200 transition-colors mb-5">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali ke daftar pengaduan
            </a>

            <div class="w-full mx-auto">
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                            bg-white dark:bg-slate-900 overflow-hidden">

                   

                    {{-- Konten --}}
                    <div class="p-6 sm:p-8">
                        @php
                            $badge = match($pengaduan->status) {
                                'selesai'    => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400',
                                'diproses'       => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-400',
                                'pending' => 'bg-red-100 text-red-700 dark:bg-red-500/15 dark:text-red-400',
                               
                            };
                        @endphp

                        <div class="flex flex-wrap gap-3 mb-5">
                            {{-- Badge Status --}}
                            <span class="px-5 py-2.5 rounded-lg text-sm font-medium {{ $badge }}">
                                <i class="fa-solid fa-circle-dot mr-1.5"></i>
                                {{ ucfirst($pengaduan->status) }}
                            </span>

                        </div>

                        <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100 mb-1">
                            Kamar #{{ $pengaduan->kamar->no_kamar ?? 'Tidak ada kamar terkait' }}
                        </h1>

                    
                        <div class="mb-6">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-2">
                                Pengadu
                            </p>
                            <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                                {{ $pengaduan->user->name ?? 'Tidak ada pengguna terkait' }}
                            </p>
                           
                        </div>

                        {{-- Judul --}}
                        <div class="mb-6">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-2">
                                Laporan Masalah
                            </p>
                            <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                                {{ $pengaduan->judul ?? 'Tidak ada Judul tambahan untuk aduan ini.' }}
                            </p>
                           
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-8">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-2">
                                Deskripsi
                            </p>
                            <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                                {{ $pengaduan->diskripsi ?? 'Tidak ada deskripsi tambahan untuk aduan ini.' }}
                            </p>
                        </div>

                        {{-- Aksi --}}
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('pengaduan.index') }}"
                               class="px-5 py-2.5 rounded-lg text-sm font-medium
                                      text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800
                                      hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                Kembali
                            </a>
                            @if(auth()->user()->role === 'admin' && $pengaduan->status !== 'selesai')
                                <form method="POST" action="{{ route('pengaduan.update', $pengaduan->id) }}">
                                    @csrf
                                    <button type="submit"
                                            class="px-5 py-2.5 rounded-lg text-sm font-medium text-white
                                                   {{ $pengaduan->status === 'pending' ? 'bg-amber-500 hover:bg-amber-600' : 'bg-emerald-500 hover:bg-emerald-600' }} transition-colors">
                                        <i class="fa-solid {{ $pengaduan->status === 'pending' ? 'fa-pen-to-square' : 'fa-check' }} mr-1.5"></i>
                                        {{ $pengaduan->status === 'pending' ? 'Tandai Sedang Diproses' : 'Tandai Selesai' }}
                                    </button>
                                </form>
                            @endif

                                <form method="POST" action="{{ route('pengaduan.delete', $pengaduan->id) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus pengaduan milik {{ $pengaduan->user->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-5 py-2.5 rounded-lg text-sm font-medium
                                                   text-white bg-rose-600 hover:bg-rose-700 transition-colors">
                                        <i class="fa-solid fa-trash mr-1.5"></i>Hapus
                                    </button>
                                </form>
                           
                               

                                @if ($kontrakAktif ?? false)
                                    <a href="{{ route('pengaduan.create', ['kamar_id' => $kamar->id]) }}"
                                       class="px-5 py-2.5 rounded-lg text-sm font-medium
                                              text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10
                                              hover:bg-rose-100 dark:hover:bg-rose-500/20 transition-colors">
                                        <i class="fa-solid fa-triangle-exclamation mr-1.5"></i>Laporkan Masalah
                                    </a>
                                @endif
                          
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
