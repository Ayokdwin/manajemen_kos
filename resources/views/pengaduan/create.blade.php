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
                    Kembali ke daftar aduan
                </a>

                <div class="w-full mx-auto">
                    <div class="mb-6">
                        <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Buat Laporan</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            Gunakan form ini untuk membuat laporan masalah terkait kamar Anda. 
                            <br>
                            untuk memberikan informasi yang jelas dan lengkap agar masalah dapat ditangani dengan cepat.
                        </p>
                    </div>

                    {{-- Error summary --}}
                
                        <div
                            class="mb-6 rounded-lg border border-rose-200 dark:border-rose-500/30
                                bg-rose-50 dark:bg-rose-500/10 p-4">
                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-medium text-rose-700 dark:text-rose-400">
                                        Lapor dengan jelas dan lengkap agar masalah dapat ditangani dengan cepat.
                                    </p>
                                    <ul
                                        class="mt-1.5 text-sm text-rose-600 dark:text-rose-400 list-disc list-inside space-y-0.5">
                                      
                                    </ul>
                                </div>
                            </div>
                        </div>
                   

                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <div
                            class="rounded-2xl border border-slate-200 dark:border-slate-800
                                bg-white dark:bg-slate-900 p-6 space-y-4">

                            {{-- Kamar aktif --}}
                            <div>
                                <label for="no_kamar"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                    Nomor Kamar
                                </label>
                                <input type="text" id="no_kamar" value="{{ $kamarAktif?->kamar?->no_kamar ?? 'Tidak ada kamar aktif' }}"
                                    readonly
                                    class="w-full px-3.5 py-2.5 rounded-lg text-sm
                                       bg-slate-50 dark:bg-slate-800
                                       border border-slate-200 dark:border-slate-700
                                       text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                       focus:border-indigo-400 dark:focus:border-indigo-500
                                       focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                       outline-none transition-colors">
                            </div>

                            

                            {{-- judul laporan --}}
                            <div>
                                <label for="judul"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                    Judul Laporan
                                </label>
                                <div class="relative">
                                    <span
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5"></span>
                                    <input type="text" id="judul" name="judul"placeholder="Contoh: Keran mati "
                                        class="w-full px-3.5 py-2.5 rounded-lg text-sm
                                       bg-slate-50 dark:bg-slate-800
                                       border border-slate-200 dark:border-slate-700
                                       text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                       focus:border-indigo-400 dark:focus:border-indigo-500
                                       focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                       outline-none transition-colors
                                       @error('judul') border-rose-300 dark:border-rose-500/50 @enderror">
                                    @error('judul')
                                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>
                             
                            </div>


                            

                            {{-- Deskripsi --}}
                            <div>
                                <label for="diskripsi"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                    Deskripsi
                                </label>
                                <textarea id="diskripsi" name="diskripsi" rows="4" placeholder="Tambahkan detail informasi tentang laporanmu ..."
                                    class="w-full px-3.5 py-2.5 rounded-lg text-sm resize-none
                                       bg-slate-50 dark:bg-slate-800
                                       border border-slate-200 dark:border-slate-700
                                       text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                       focus:border-indigo-400 dark:focus:border-indigo-500
                                       focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                       outline-none transition-colors
                                       @error('diskripsi') border-rose-300 dark:border-rose-500/50 @enderror">{{ old('diskripsi') }}</textarea>
                                @error('diskripsi')
                                    <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                              
                            </div>
                        </div>

                        {{-- Aksi --}}
                        <div class="flex items-center gap-3">
                            <button type="submit"
                                class="px-6 py-2.5 rounded-lg text-sm font-medium text-white
                                       bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                Kirim Laporan
                            </button>
                            <a href="{{ route('pengaduan.index') }}"
                                class="px-6 py-2.5 rounded-lg text-sm font-medium
                                  text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800
                                  hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
@endsection
