@extends('dashboard.admin')

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
                    <div class="mb-6">
                        <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Edit Kamar</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            Ubah informasi kamar sesuai kebutuhan. Pastikan data yang dimasukkan akurat dan lengkap.
                        </p>
                    </div>

                    {{-- Error summary --}}
                    @if ($errors->any())
                        <div
                            class="mb-6 rounded-lg border border-rose-200 dark:border-rose-500/30
                                bg-rose-50 dark:bg-rose-500/10 p-4">
                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-medium text-rose-700 dark:text-rose-400">
                                        Periksa kembali data yang Anda masukkan
                                    </p>
                                    <ul
                                        class="mt-1.5 text-sm text-rose-600 dark:text-rose-400 list-disc list-inside space-y-0.5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('kamar.update', $kamar->id) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div
                            class="rounded-2xl border border-slate-200 dark:border-slate-800
                                bg-white dark:bg-slate-900 p-6 space-y-4">

                            {{-- Nomor Kamar --}}
                            <div>
                                <label for="no_kamar"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                    Nomor Kamar
                                </label>
                                <input type="text" id="no_kamar" name="no_kamar" value="{{ old('no_kamar', $kamar->no_kamar) }}""
                                    placeholder="Contoh: A-101"
                                    class="w-full px-3.5 py-2.5 rounded-lg text-sm
                                       bg-slate-50 dark:bg-slate-800
                                       border border-slate-200 dark:border-slate-700
                                       text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                       focus:border-indigo-400 dark:focus:border-indigo-500
                                       focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                       outline-none transition-colors
                                       @error('no_kamar') border-rose-300 dark:border-rose-500/50 @enderror">
                                @error('no_kamar')
                                    <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tipe & Status --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="tipe"
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                        Tipe Kamar
                                    </label>
                                    <select
                                        id="tipe"
                                        name="tipe"
                                        class="w-full rounded-lg border border-slate-300 dark:border-slate-700
                                            bg-white dark:bg-slate-800 px-4 py-3
                                            text-slate-700 dark:text-slate-200
                                            focus:border-indigo-400 dark:focus:border-indigo-500
                                            focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                            outline-none transition-colors capitalize
                                            @error('tipe') border-rose-300 dark:border-rose-500/50 @enderror">

                                        <option value="" disabled>Pilih tipe</option>

                                        @foreach (['standar', 'deluxe', 'vip'] as $tipe)
                                            <option
                                                value="{{ $tipe }}"
                                                {{ old('tipe', $kamar->tipe) == $tipe ? 'selected' : '' }}
                                                class="capitalize">
                                                {{ ucfirst($tipe) }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('tipe')
                                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status"
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                        Status
                                    </label>
                                    <select id="status" name="status"
                                        class="w-full px-3.5 py-2.5 rounded-lg text-sm
                                           bg-slate-50 dark:bg-slate-800
                                           border border-slate-200 dark:border-slate-700
                                           text-slate-700 dark:text-slate-200
                                           focus:border-indigo-400 dark:focus:border-indigo-500
                                           focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                           outline-none transition-colors
                                           @error('status') border-rose-300 dark:border-rose-500/50 @enderror">
                                        @foreach (['tersedia', 'diisi', 'maintenance'] as $status)
                                            <option value="{{ $status }}"
                                                {{ old('status', $kamar->status) == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Harga per bulan --}}
                            <div>
                                <label for="harga_per_bulan"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                    Harga per Bulan
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400">Rp</span>
                                    <input type="number" id="harga_per_bulan" name="harga_per_bulan"
                                        value="{{ old('harga_per_bulan', $kamar->harga_per_bulan) }}"" placeholder="1500000" min="0"
                                        step="1000"
                                        class="w-full pl-10 pr-3.5 py-2.5 rounded-lg text-sm
                                           bg-slate-50 dark:bg-slate-800
                                           border border-slate-200 dark:border-slate-700
                                           text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                           focus:border-indigo-400 dark:focus:border-indigo-500
                                           focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                           outline-none transition-colors
                                           @error('harga_per_bulan') border-rose-300 dark:border-rose-500/50 @enderror">
                                </div>
                                @error('harga_per_bulan')
                                    <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>

                            @if($kamar->foto)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2"> Foto Saat Ini
                                    </label> <img src="{{ asset('storage/'.$kamar->foto) }}" alt="Foto Kamar" class="w-48 h-32 object-cover rounded-lg border border-slate-200 dark:border-slate-700">
                                </div>
                                @endif

                            {{-- Foto Kamar --}}
                            <div>
                                <label for="foto"
                                    class="block mb-1.5 text-sm font-medium text-slate-700 dark:text-slate-200">
                                    Foto Kamar
                                </label>

                                <input type="file" id="foto" name="foto" accept="image/*"
                                    class="w-full rounded-lg border bg-slate-50 px-3.5 py-2.5 text-sm
                                    text-slate-700 outline-none transition-colors
                                    file:mr-4 file:rounded-lg file:border-0
                                    file:bg-indigo-600 file:px-4 file:py-2
                                    file:text-sm file:font-medium file:text-white
                                    hover:file:bg-indigo-700
                                    dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200
                                    border-slate-200 placeholder:text-slate-400
                                    focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100
                                    dark:focus:border-indigo-500 dark:focus:ring-indigo-500/20
                                    @error('foto') border-rose-300 dark:border-rose-500/50 @enderror">

                                <p class="mt-1 text-xs text-slate-400">
                                    Kosongkan jika tidak ingin mengganti foto.
                                </p>

                                @error('foto')
                                    <p class="mt-1.5 text-xs text-rose-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Fasilitas --}}
                            <div>
                                <label for="fasilitas"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                    Fasilitas
                                </label>
                                <textarea id="fasilitas" name="fasilitas" rows="3"
                                    placeholder="Contoh: AC, kamar mandi dalam, WiFi, lemari pakaian"
                                    class="w-full px-3.5 py-2.5 rounded-lg text-sm resize-none
                                       bg-slate-50 dark:bg-slate-800
                                       border border-slate-200 dark:border-slate-700
                                       text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                       focus:border-indigo-400 dark:focus:border-indigo-500
                                       focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                       outline-none transition-colors
                                       @error('fasilitas') border-rose-300 dark:border-rose-500/50 @enderror">{{ old('fasilitas', $kamar->fasilitas) }}</textarea>
                                <p class="mt-1.5 text-xs text-slate-400 dark:text-slate-500">
                                    Pisahkan setiap fasilitas dengan koma.
                                </p>
                                @error('fasilitas')
                                    <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <label for="deskripsi"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                    Deskripsi
                                    <span class="text-slate-400 font-normal">(opsional)</span>
                                </label>
                                <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Tambahkan informasi lain tentang kamar ini..."
                                    class="w-full px-3.5 py-2.5 rounded-lg text-sm resize-none
                                       bg-slate-50 dark:bg-slate-800
                                       border border-slate-200 dark:border-slate-700
                                       text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                       focus:border-indigo-400 dark:focus:border-indigo-500
                                       focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                       outline-none transition-colors
                                       @error('deskripsi') border-rose-300 dark:border-rose-500/50 @enderror">{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Aksi --}}
                        <div class="flex items-center gap-3">
                            <button type="submit"
                                class="px-6 py-2.5 rounded-lg text-sm font-medium text-white
                                       bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                Perbarui Kamar
                            </button>
                            <a href="{{ route('kamar.index') }}"
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
