@extends('dashboard.admin')

@section('content')

<div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
    <div class="flex-1 flex flex-col overflow-hidden"
         x-data="{
            tab: 'tersedia',
            modalOpen: false,
            selectedKamar: null,
            openModal(kamar) {
                this.selectedKamar = kamar;
                this.modalOpen = true;
            },
            closeModal() {
                this.modalOpen = false;
                setTimeout(() => this.selectedKamar = null, 200);
            }
         }">

        <main class="flex-1 overflow-y-auto p-6">

            {{-- Page intro --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">
                        Kamar
                    </h1>

                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Kelola data kamar yang tersedia untuk disewakan.
                    </p>
                </div>
                @if( auth()->user()->role === 'admin')
                <a href="{{ route('kamar.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5
                        text-sm font-medium text-white hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Kamar
                </a>
                @endif
            </div>

            {{-- Tabs --}}
            <div class="flex items-center gap-1 mb-6 border-b border-slate-200 dark:border-slate-800">
                @if(auth()->user()->role === 'admin')
                <button
                    type="button"
                    @click="tab = 'semua'"
                    :class="tab === 'semua'
                        ? 'border-indigo-600 text-indigo-700 dark:text-indigo-400'
                        : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'"
                    class="px-4 py-2.5 text-sm font-medium border-b-2 transition-colors -mb-px">

                    Semua

                    <span
                        class="ml-1.5 text-xs font-semibold px-1.5 py-0.5 rounded-full
                            bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">

                        {{ $semuaKamar->count() }}

                    </span>

                </button>
                @endif
                <button
                    type="button"
                    @click="tab = 'tersedia'"
                    :class="tab === 'tersedia'
                        ? 'border-indigo-600 text-indigo-700 dark:text-indigo-400'
                        : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'"
                    class="px-4 py-2.5 text-sm font-medium border-b-2 transition-colors -mb-px"
                >
                    Tersedia
                    <span class="ml-1.5 text-xs font-semibold px-1.5 py-0.5 rounded-full
                                 bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                        {{ $kamarTersedia->count() }}
                    </span>
                </button>

                <button
                    type="button"
                    @click="tab = 'saya'"
                    :class="tab === 'saya'
                        ? 'border-indigo-600 text-indigo-700 dark:text-indigo-400'
                        : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'"
                    class="px-4 py-2.5 text-sm font-medium border-b-2 transition-colors -mb-px"
                >
                    Kamar Saya
                    <span class="ml-1.5 text-xs font-semibold px-1.5 py-0.5 rounded-full
                                 bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                        {{ $kamarSaya->count() }}
                    </span>
                </button>
            </div>

            {{-- ====================== TAB: SEMUA ====================== --}}
            @if(auth()->user()->role === 'admin')
                <div x-show="tab === 'semua'" x-cloak>
                    @if($semuaKamar->isEmpty())
                        <div class="flex flex-col items-center justify-center py-20">
                            <i class="fa-solid fa-bed text-5xl text-slate-300 mb-4"></i>
                            <p class="text-slate-500">
                                Belum ada data kamar.
                            </p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                            @foreach($semuaKamar as $kamar)
                                <div
                                    @click="openModal({
                                        id: '{{ $kamar->id }}',
                                        no_kamar: '{{ $kamar->no_kamar }}',
                                        tipe: '{{ $kamar->tipe }}',
                                        harga: '{{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}',
                                        fasilitas: '{{ str_replace("'", "\\'", $kamar->fasilitas) }}',
                                        deskripsi: '{{ str_replace("'", "\\'", $kamar->deskripsi ?? 'Tidak ada deskripsi tambahan.') }}',
                                        status: 'tersedia',
                                        foto: '{{ $kamar->foto ? asset('storage/'.$kamar->foto) : '' }}'
                                    })"
                                    class="group cursor-pointer rounded-xl border border-slate-200 dark:border-slate-800
                                        bg-white dark:bg-slate-900 overflow-hidden
                                        hover:shadow-md hover:border-indigo-200 dark:hover:border-indigo-500/40
                                        transition-all duration-150"
                                >
                                    {{-- Foto kamar --}}
                                    <div class="relative h-40 bg-gradient-to-br from-indigo-50 to-violet-50 dark:from-indigo-500/10 dark:to-violet-500/10
                                                flex items-center justify-center overflow-hidden">
                                        @if($kamar->foto)
                                        <img src="{{ asset('storage/'.$kamar->foto) }}" class="w-full h-full object-cover">
                                        @else
                                        <i class="fa-solid fa-bed text-5xl text-indigo-300"></i>
                                        @endif
                                        {{-- Badge Status --}}
                                        @php
                                            $badge = match($kamar->status) {
                                                'tersedia'   => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                                                'diisi'      => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300',
                                                'maintenance'=> 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-300',
                                                default      => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                                            };
                                        @endphp

                                        {{-- Badge Status --}}
                                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-xs font-semibold {{ $badge }}">
                                            {{ ucfirst($kamar->status) }}
                                        </span>

                                        {{-- Badge Tipe --}}
                                        <span class="absolute top-3 right-3 text-xs font-medium px-2.5 py-1 rounded-md
                                                    bg-white/90 dark:bg-slate-900/80
                                                    text-slate-600 dark:text-slate-300
                                                    backdrop-blur-sm capitalize">
                                            {{ ucfirst($kamar->tipe) }}
                                        </span>
                                    </div>

                                    {{-- Info --}}
                                    <div class="p-4">
                                        <div class="flex items-baseline justify-between gap-2 mb-1.5">
                                            <h3 class="font-semibold text-slate-900 dark:text-slate-100">
                                                Kamar {{ $kamar->no_kamar }}
                                            </h3>
                                        </div>

                                        <p class="text-lg font-semibold text-indigo-700 dark:text-indigo-400">
                                            Rp {{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}
                                            <span class="text-xs font-normal text-slate-400">/bulan</span>
                                        </p>

                                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 line-clamp-2">
                                            {{ $kamar->fasilitas }}
                                        </p>

                                        <button type="button"
                                                class="mt-3 w-full text-center text-sm font-medium py-2 rounded-lg
                                                    text-indigo-700 bg-indigo-50 dark:bg-indigo-500/10 dark:text-indigo-400
                                                    group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                            Lihat Detail
                                        </button>
                                    </div>
                                </div>
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
                            <div
                                @click="openModal({
                                    id: '{{ $kamar->id }}',
                                    no_kamar: '{{ $kamar->no_kamar }}',
                                    tipe: '{{ $kamar->tipe }}',
                                    harga: '{{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}',
                                    fasilitas: '{{ str_replace("'", "\\'", $kamar->fasilitas) }}',
                                    deskripsi: '{{ str_replace("'", "\\'", $kamar->deskripsi ?? 'Tidak ada deskripsi tambahan.') }}',
                                    status: 'tersedia',
                                    foto: '{{ $kamar->foto ? asset('storage/'.$kamar->foto) : '' }}'
                                })"
                                class="group cursor-pointer rounded-xl border border-slate-200 dark:border-slate-800
                                       bg-white dark:bg-slate-900 overflow-hidden
                                       hover:shadow-md hover:border-indigo-200 dark:hover:border-indigo-500/40
                                       transition-all duration-150"
                            >
                                {{-- Foto kamar --}}
                                <div class="relative h-40 bg-gradient-to-br from-indigo-50 to-violet-50 dark:from-indigo-500/10 dark:to-violet-500/10
                                            flex items-center justify-center overflow-hidden">
                                    @if($kamar->foto)
                                    <img src="{{ asset('storage/'.$kamar->foto) }}" class="w-full h-full object-cover">
                                    @else
                                    <i class="fa-solid fa-bed text-5xl text-indigo-300"></i>
                                    @endif
                                    <span class="absolute top-3 left-3 text-xs font-semibold px-2 py-1 rounded-md
                                                 bg-emerald-100 text-emerald-700 dark:bg-emerald-500 dark:text-emerald-100">
                                        Tersedia
                                    </span>

                                    <span class="absolute top-3 right-3 text-xs font-medium px-2 py-1 rounded-md
                                                 bg-white/90 dark:bg-slate-900/80 text-slate-600 dark:text-slate-300 backdrop-blur-sm capitalize">
                                        {{ $kamar->tipe }}
                                    </span>
                                </div>

                                {{-- Info --}}
                                <div class="p-4">
                                    <div class="flex items-baseline justify-between gap-2 mb-1.5">
                                        <h3 class="font-semibold text-slate-900 dark:text-slate-100">
                                            Kamar {{ $kamar->no_kamar }}
                                        </h3>
                                    </div>

                                    <p class="text-lg font-semibold text-indigo-700 dark:text-indigo-400">
                                        Rp {{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}
                                        <span class="text-xs font-normal text-slate-400">/bulan</span>
                                    </p>

                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 line-clamp-2">
                                        {{ $kamar->fasilitas }}
                                    </p>

                                    <button type="button"
                                            class="mt-3 w-full text-center text-sm font-medium py-2 rounded-lg
                                                   text-indigo-700 bg-indigo-50 dark:bg-indigo-500/10 dark:text-indigo-400
                                                   group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
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
                        <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">Pilih kamar dari tab "Tersedia" untuk mengajukan sewa.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach ($kamarSaya as $kamar)
                            @php $kontrakAktif = $kamar->kontrak->first(); @endphp
                            <div
                                @click="openModal({
                                    id: '{{ $kamar->id }}',
                                    no_kamar: '{{ $kamar->no_kamar }}',
                                    tipe: '{{ $kamar->tipe }}',
                                    harga: '{{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}',
                                    fasilitas: '{{ str_replace("'", "\\'", $kamar->fasilitas) }}',
                                    deskripsi: '{{ str_replace("'", "\\'", $kamar->deskripsi ?? 'Tidak ada deskripsi tambahan.') }}',
                                    status: 'dihuni',
                                    tgl_masuk: '{{ $kontrakAktif?->tgl_masuk?->format('d M Y') }}',
                                    tgl_selesai: '{{ $kontrakAktif?->tgl_selesai?->format('d M Y') }}',
                                    foto: '{{ $kamar->foto ? asset('storage/'.$kamar->foto) : '' }}'
                                })"
                                class="group cursor-pointer rounded-xl border border-slate-200 dark:border-slate-800
                                       bg-white dark:bg-slate-900 overflow-hidden
                                       hover:shadow-md hover:border-indigo-200 dark:hover:border-indigo-500/40
                                       transition-all duration-150"
                            >
                                <div class="relative h-40 bg-gradient-to-br from-indigo-50 to-violet-50 dark:from-indigo-500/10 dark:to-violet-500/10
                                            flex items-center justify-center overflow-hidden">
                                    @if ($kamar->foto)
                                        <img src="{{ asset('storage/'.$kamar->foto) }}"
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
                                                 bg-white/90 dark:bg-slate-900/80 text-slate-600 dark:text-slate-300 backdrop-blur-sm capitalize">
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

                                    <button type="button"
                                            class="mt-3 w-full text-center text-sm font-medium py-2 rounded-lg
                                                   text-slate-600 bg-slate-100 dark:bg-slate-800 dark:text-slate-300
                                                   group-hover:bg-slate-200 dark:group-hover:bg-slate-700 transition-colors">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>

        {{-- ====================== MODAL DETAIL KAMAR ====================== --}}
        <div
            x-show="modalOpen"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
            {{-- Overlay --}}
            <div
                x-show="modalOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="closeModal()"
                class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
            ></div>

            {{-- Panel --}}
            <div
                x-show="modalOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-2xl shadow-xl
                       border border-slate-200 dark:border-slate-800 overflow-hidden"
                @click.stop
            >
                <template x-if="selectedKamar">
                    <div>
                        {{-- Foto --}}
                        <div class="relative h-48 bg-gradient-to-br from-indigo-50 to-violet-50 dark:from-indigo-500/10 dark:to-violet-500/10
                                    flex items-center justify-center">
                            <template x-if="selectedKamar.foto">
                                <img :src="selectedKamar.foto" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!selectedKamar.foto">
                                <i class="fa-solid fa-bed text-5xl text-indigo-300 dark:text-indigo-500/40"></i>
                            </template>

                            <button
                                @click="closeModal()"
                                class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 dark:bg-slate-900/80
                                       flex items-center justify-center text-slate-500 hover:text-slate-800
                                       dark:text-slate-300 dark:hover:text-white transition-colors backdrop-blur-sm"
                            >
                                <i class="fa-solid fa-xmark"></i>
                            </button>

                            <span x-show="selectedKamar.status === 'tersedia'"
                                  class="absolute top-3 left-3 text-xs font-semibold px-2 py-1 rounded-md
                                         bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                Tersedia
                            </span>
                            <span x-show="selectedKamar.status === 'dihuni'"
                                  class="absolute top-3 left-3 text-xs font-semibold px-2 py-1 rounded-md
                                         bg-indigo-100 text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-400">
                                Dihuni
                            </span>
                        </div>

                        {{-- Konten --}}
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-1">
                                <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">
                                    Kamar <span x-text="selectedKamar.no_kamar"></span>
                                </h2>
                                <span class="text-xs font-medium px-2 py-1 rounded-md bg-slate-100 dark:bg-slate-800
                                             text-slate-500 dark:text-slate-400 capitalize" x-text="selectedKamar.tipe"></span>
                            </div>

                            <p class="text-2xl font-semibold text-indigo-700 dark:text-indigo-400 mb-4">
                                Rp <span x-text="selectedKamar.harga"></span>
                                <span class="text-sm font-normal text-slate-400">/bulan</span>
                            </p>

                            {{-- Info masa sewa, hanya tampil di kamar yang dihuni --}}
                            <template x-if="selectedKamar.status === 'dihuni'">
                                <div class="flex items-center gap-4 mb-4 p-3 rounded-lg bg-slate-50 dark:bg-slate-800/60">
                                    <div>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Tanggal Masuk</p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200" x-text="selectedKamar.tgl_masuk"></p>
                                    </div>
                                    <div class="w-px h-8 bg-slate-200 dark:bg-slate-700"></div>
                                    <div>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Sewa Berakhir</p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200" x-text="selectedKamar.tgl_selesai"></p>
                                    </div>
                                </div>
                            </template>

                            <div class="mb-4">
                                <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-1.5">
                                    Fasilitas
                                </p>
                                <p class="text-sm text-slate-600 dark:text-slate-300" x-text="selectedKamar.fasilitas"></p>
                            </div>

                            <div class="mb-6">
                                <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-1.5">
                                    Deskripsi
                                </p>
                                <p class="text-sm text-slate-600 dark:text-slate-300" x-text="selectedKamar.deskripsi"></p>
                            </div>

                            {{-- Aksi --}}
                            <div class="flex gap-2">
                                {{-- Tombol Tutup --}}
                                <button
                                    @click="closeModal()"
                                    class="flex-1 py-2.5 rounded-lg text-sm font-medium
                                        bg-slate-100 dark:bg-slate-800
                                        text-slate-600 dark:text-slate-300
                                        hover:bg-slate-200 dark:hover:bg-slate-700 transition">

                                    Tutup
                                </button>

                                @if(auth()->user()->role === 'admin')
                                    {{-- Tombol Edit --}}
                                    <a
                                        :href="`/kamar/${selectedKamar.id}/edit`"
                                        class="flex-1 py-2.5 rounded-lg text-center text-sm font-medium
                                            bg-amber-500 text-white hover:bg-amber-600 transition">
                                        <i class="fa-solid fa-pen-to-square mr-2"></i>
                                        Edit
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form
                                        :action="`/kamar/${selectedKamar.id}`"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kamar ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                                            <i class="fa-solid fa-trash mr-2"></i>
                                            Hapus
                                        </button>

                                    </form>
                                @else
                                    <template x-if="selectedKamar.status === 'tersedia'">
                                        <button
                                            class="flex-1 py-2.5 rounded-lg text-sm font-medium
                                                bg-indigo-600 text-white
                                                hover:bg-indigo-700 transition">
                                            Ajukan Sewa
                                        </button>
                                    </template>
                                @endif
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
@endsection
