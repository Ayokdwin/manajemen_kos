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

                <div class="w-full mx-auto"
                     x-data="{
                        kamarList: {{ $kamar->map(fn($k) => [
                            'id' => $k->id,
                            'no_kamar' => $k->no_kamar,
                            'tipe' => $k->tipe,
                            'harga' => $k->harga_per_bulan,
                        ])->values()->toJson() }},
                        selectedHarga: null,
                        onKamarChange(kamarId) {
                            const kamar = this.kamarList.find(k => k.id == kamarId);
                            this.selectedHarga = kamar ? kamar.harga : null;
                        }
                     }">

                    <div class="mb-6">
                        <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Edit Kontrak</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            Hubungkan penyewa dengan kamar yang akan disewa.
                        </p>
                    </div>

                    {{-- Error summary --}}
                    @if ($errors->any())
                        <div class="mb-6 rounded-lg border border-rose-200 dark:border-rose-500/30
                                    bg-rose-50 dark:bg-rose-500/10 p-4">
                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-medium text-rose-700 dark:text-rose-400">
                                        Periksa kembali data yang Anda masukkan
                                    </p>
                                    <ul class="mt-1.5 text-sm text-rose-600 dark:text-rose-400 list-disc list-inside space-y-0.5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Empty state kalau tidak ada kamar tersedia --}}
                    @if ($kamar->isEmpty())
                        <div class="rounded-2xl border border-amber-200 dark:border-amber-500/30
                                    bg-amber-50 dark:bg-amber-500/10 p-5 flex items-start gap-3">
                            <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5"></i>
                            <div>
                                <p class="text-sm font-medium text-amber-700 dark:text-amber-400">
                                    Tidak ada kamar tersedia
                                </p>
                                <p class="text-sm text-amber-600 dark:text-amber-400/80 mt-0.5">
                                    Semua kamar sedang terisi atau dalam maintenance. Tambahkan kamar baru atau tunggu kontrak lain selesai.
                                </p>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('kontrak.update', $kontrak->id) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                        bg-white dark:bg-slate-900 p-6 space-y-5">

                                {{-- Penyewa --}}
                                <div>
                                    <label for="user_id" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                        Penyewa
                                    </label>
                                    <select id="user_id" name="user_id"
                                            class="w-full px-3.5 py-2.5 rounded-lg text-sm
                                                   bg-slate-50 dark:bg-slate-800
                                                   border border-slate-200 dark:border-slate-700
                                                   text-slate-700 dark:text-slate-200
                                                   focus:border-indigo-400 dark:focus:border-indigo-500
                                                   focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                                   outline-none transition-colors
                                                   @error('user_id') border-rose-300 dark:border-rose-500/50 @enderror">
                                        <option value="" disabled {{ old('user_id', $kontrak->user_id) ? '' : 'selected' }}>Pilih penyewa</option>
                                        @foreach ($penyewa as $p)
                                            <option value="{{ $p->id }}" {{ old('user_id', $kontrak->user_id) == $p->id ? 'selected' : '' }}>
                                                {{ $p->name }} — {{ $p->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                    @enderror

                                    @if ($penyewa->isEmpty())
                                        <p class="mt-1.5 text-xs text-amber-600 dark:text-amber-400">
                                            Belum ada penyewa terdaftar. <a href="{{ route('penyewa.create') }}" class="underline">Tambah penyewa</a> dulu.
                                        </p>
                                    @endif
                                </div>

                                {{-- Kamar --}}
                                <div>
                                    <label for="kamar_id" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                        Kamar
                                    </label>
                                    <select id="kamar_id" name="kamar_id"
                                            @change="onKamarChange($event.target.value)"
                                            class="w-full px-3.5 py-2.5 rounded-lg text-sm
                                                   bg-slate-50 dark:bg-slate-800
                                                   border border-slate-200 dark:border-slate-700
                                                   text-slate-700 dark:text-slate-200
                                                   focus:border-indigo-400 dark:focus:border-indigo-500
                                                   focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                                   outline-none transition-colors
                                                   @error('kamar_id') border-rose-300 dark:border-rose-500/50 @enderror">
                                        <option value="" disabled {{ old('kamar_id', $kontrak->kamar_id) ? '' : 'selected' }}>Pilih kamar tersedia</option>
                                        @foreach ($kamar as $k)
                                            <option value="{{ $k->id }}" {{ old('kamar_id', $kontrak->kamar_id) == $k->id ? 'selected' : '' }}>
                                                Kamar {{ $k->no_kamar }} — {{ ucfirst($k->tipe) }} (Rp {{ number_format($k->harga_per_bulan, 0, ',', '.') }}/bln)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kamar_id')
                                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                    @enderror

                                    {{-- Info harga otomatis --}}
                                    <p x-show="selectedHarga" x-cloak class="mt-1.5 text-xs text-indigo-600 dark:text-indigo-400">
                                        <i class="fa-solid fa-circle-info mr-1"></i>
                                        Harga sewa: Rp <span x-text="selectedHarga ? new Intl.NumberFormat('id-ID').format(selectedHarga) : ''"></span>/bulan
                                    </p>
                                </div>

                                {{-- Tanggal Masuk & Selesai --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label for="tanggal_masuk" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                            Tanggal Masuk
                                        </label>
                                        <input
                                            type="date"
                                            id="tanggal_masuk"
                                            name="tanggal_masuk"
                                            value="{{ old('tanggal_masuk', optional($kontrak->tanggal_masuk)->format('Y-m-d')) }}"
                                            class="w-full px-3.5 py-2.5 rounded-lg text-sm
                                                   bg-slate-50 dark:bg-slate-800
                                                   border border-slate-200 dark:border-slate-700
                                                   text-slate-700 dark:text-slate-200
                                                   focus:border-indigo-400 dark:focus:border-indigo-500
                                                   focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                                   outline-none transition-colors
                                                   @error('tanggal_masuk') border-rose-300 dark:border-rose-500/50 @enderror"
                                        >
                                        @error('tanggal_masuk')
                                            <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="tanggal_selesai" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                            Tanggal Selesai
                                        </label>
                                        <input
                                            type="date"
                                            id="tanggal_selesai"
                                            name="tanggal_selesai"
                                            value="{{ old('tanggal_selesai', optional($kontrak->tanggal_selesai)->format('Y-m-d')) }}"
                                            class="w-full px-3.5 py-2.5 rounded-lg text-sm
                                                   bg-slate-50 dark:bg-slate-800
                                                   border border-slate-200 dark:border-slate-700
                                                   text-slate-700 dark:text-slate-200
                                                   focus:border-indigo-400 dark:focus:border-indigo-500
                                                   focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                                   outline-none transition-colors
                                                   @error('tanggal_selesai') border-rose-300 dark:border-rose-500/50 @enderror"
                                        >
                                        @error('tanggal_selesai')
                                            <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Deposit --}}
                                <div>
                                    <label for="deposit" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                        Deposit
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400">Rp</span>
                                        <input
                                            type="number"
                                            id="deposit"
                                            name="deposit"
                                            value="{{ old('deposit', $kontrak->deposit) }}"
                                            placeholder="500000"
                                            min="0"
                                            step="1000"
                                            class="w-full pl-10 pr-3.5 py-2.5 rounded-lg text-sm
                                                   bg-slate-50 dark:bg-slate-800
                                                   border border-slate-200 dark:border-slate-700
                                                   text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                                   focus:border-indigo-400 dark:focus:border-indigo-500
                                                   focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                                   outline-none transition-colors
                                                   @error('deposit') border-rose-300 dark:border-rose-500/50 @enderror"
                                        >
                                    </div>
                                    @error('deposit')
                                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Status --}}
                                <div>
                                    <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                        Status
                                    </label>
                                    <select name="status" id="status"
                                            class="w-full pl-3.5 pr-10 py-2.5 rounded-lg text-sm
                                                bg-slate-50 dark:bg-slate-800
                                                border border-slate-200 dark:border-slate-700
                                                text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                                focus:border-indigo-400 dark:focus:border-indigo-500
                                                focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                                outline-none transition-colors
                                                @error('status') border-rose-300 dark:border-rose-500/50 @enderror">
                                        <option value="aktif" {{ old('status', $kontrak->status) == 'aktif' ? 'selected' : '' }}>
                                            Aktif
                                        </option>
                                        <option value="selesai" {{ old('status', $kontrak->status) == 'selesai' ? 'selected' : '' }}>
                                            Selesai
                                        </option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Aksi --}}
                            <div class="flex items-center gap-3">
                                <button type="submit"
                                        class="px-6 py-2.5 rounded-lg text-sm font-medium text-white
                                               bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                    Simpan Kontrak
                                </button>
                                <a href="{{ route('kontrak.index') }}"
                                   class="px-6 py-2.5 rounded-lg text-sm font-medium
                                          text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800
                                          hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                    Batal
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </main>
        </div>
    </div>
@endsection
