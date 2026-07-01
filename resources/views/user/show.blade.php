@extends('layouts.admin')

@section('content')
    <div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-y-auto p-6">
                {{-- Back link --}}
                <a href="{{ route('user.index') }}"
                   class="inline-flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400
                          hover:text-slate-800 dark:hover:text-slate-200 transition-colors mb-5">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Kembali ke daftar penyewa
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

                    {{-- ===================== KOLOM KIRI: PROFIL ===================== --}}
                    <div class="lg:col-span-1 space-y-6">

                        {{-- Profil card --}}
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                    bg-white dark:bg-slate-900 p-6 text-center">
                            <div class="w-16 h-16 mx-auto rounded-full bg-gradient-to-br from-indigo-500 to-violet-500
                                        text-white flex items-center justify-center font-semibold text-2xl mb-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                            <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                                {{ $user->name }}
                            </h2>

                            <span class="inline-flex items-center mt-1.5 text-xs font-medium px-2 py-1 rounded-md
                                         {{ $kontrakAktif
                                            ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400'
                                            : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400' }}">
                                {{ $kontrakAktif ? 'Sedang Menyewa' : 'Tidak Aktif' }}
                            </span>

                            <div class="mt-5 pt-5 border-t border-slate-100 dark:border-slate-800 space-y-3 text-left">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-envelope w-4 text-center text-slate-400 text-sm"></i>
                                    <span class="text-sm text-slate-600 dark:text-slate-300 truncate">{{ $user->email }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-phone w-4 text-center text-slate-400 text-sm"></i>
                                    <span class="text-sm text-slate-600 dark:text-slate-300">{{ $user->no_hp }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i class="fa-regular fa-calendar w-4 text-center text-slate-400 text-sm"></i>
                                    <span class="text-sm text-slate-600 dark:text-slate-300">
                                        Bergabung {{ $user->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-5 pt-5 border-t border-slate-100 dark:border-slate-800 flex gap-2">
                                <a href="{{ route('user.edit', $user->id) }}"
                                   class="flex-1 py-2 rounded-lg text-sm font-medium
                                          text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800
                                          hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                    <i class="fa-solid fa-pen text-xs mr-1.5"></i>Edit
                                </a>

                                <form method="POST" action="{{ route('user.destroy', $user->id) }}"
                                      onsubmit="return confirm('Hapus data user {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.')"
                                      class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full py-2 rounded-lg text-sm font-medium
                                                   text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10
                                                   hover:bg-rose-100 dark:hover:bg-rose-500/20 transition-colors">
                                        <i class="fa-solid fa-trash text-xs mr-1.5"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Kamar aktif --}}
                        @if ($kontrakAktif)
                            <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                        bg-white dark:bg-slate-900 p-6">
                                <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-3">
                                    Kamar Saat Ini
                                </p>

                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-lg bg-indigo-50 dark:bg-indigo-500/10
                                                flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-door-closed text-indigo-600 dark:text-indigo-400"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-900 dark:text-slate-100">
                                            Kamar {{ $kontrakAktif->kamar->nomor_kamar }}
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-slate-500 capitalize">
                                            Tipe {{ $kontrakAktif->kamar->tipe }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Tgl Masuk</p>
                                        <p class="font-medium text-slate-700 dark:text-slate-200">
                                            {{ $kontrakAktif->tanggal_masuk->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Sewa Berakhir</p>
                                        <p class="font-medium text-slate-700 dark:text-slate-200">
                                            {{ $kontrakAktif->tanggal_selesai->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>

                                <a href="{{ route('kamar.index', $kontrakAktif->id) }}"
                                   class="mt-4 block text-center text-sm font-medium py-2 rounded-lg
                                          text-indigo-700 bg-indigo-50 dark:bg-indigo-500/10 dark:text-indigo-400
                                          hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition-colors">
                                    Lihat Detail Kontrak
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- ===================== KOLOM KANAN: RIWAYAT ===================== --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Riwayat Tagihan --}}
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                    bg-white dark:bg-slate-900 overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                                <h3 class="font-semibold text-slate-900 dark:text-slate-100">Riwayat Tagihan</h3>
                            </div>

                            @if ($tagihan->isEmpty())
                                <div class="px-6 py-8 text-center">
                                    <p class="text-sm text-slate-400 dark:text-slate-500">
                                        Belum ada tagihan untuk penyewa ini.
                                    </p>
                                </div>
                            @else
                                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @foreach ($tagihan as $item)
                                        <div class="flex items-center justify-between gap-4 px-6 py-3.5">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <div class="w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-800
                                                            flex items-center justify-center shrink-0">
                                                    <i class="fa-solid fa-file-invoice-dollar text-slate-400 text-sm"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-100">
                                                        Tagihan {{ \Carbon\Carbon::createFromDate($item->tahun, $item->bulan, 1)->translatedFormat('F Y') }}
                                                    </p>
                                                    <p class="text-xs text-slate-400 dark:text-slate-500">
                                                        Periode tagihan
                                                    </p>
                                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">
                                                        Jatuh tempo {{ $item->tanggal_jatuh_tempo->format('d M Y') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-3 shrink-0">
                                                <span class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                                    Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}
                                                </span>

                                                @if ($item->status === 'lunas')
                                                    <span class="text-xs font-medium px-2 py-1 rounded-md
                                                                 bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                                        Lunas
                                                    </span>
                                                @elseif ($item->status === 'menunggu')
                                                    <span class="text-xs font-medium px-2 py-1 rounded-md
                                                                 bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                                        Menunggu
                                                    </span>
                                                @else
                                                    <span class="text-xs font-medium px-2 py-1 rounded-md
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

                        {{-- Riwayat Kontrak --}}
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                    bg-white dark:bg-slate-900 overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                                <h3 class="font-semibold text-slate-900 dark:text-slate-100">Riwayat Kontrak</h3>
                            </div>

                            @if ($user->kontrak->isEmpty())
                                <div class="px-6 py-8 text-center">
                                    <p class="text-sm text-slate-400 dark:text-slate-500">
                                        Penyewa ini belum pernah memiliki kontrak.
                                    </p>
                                </div>
                            @else
                                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @foreach ($user->kontrak as $k)
                                        <div class="flex items-center justify-between gap-4 px-6 py-3.5">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <div class="w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-800
                                                            flex items-center justify-center shrink-0">
                                                    <i class="fa-solid fa-file-signature text-slate-400 text-sm"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-100">
                                                        Kamar {{ $k->kamar->nomor_kamar }}
                                                    </p>
                                                    <p class="text-xs text-slate-400 dark:text-slate-500">
                                                        {{ $k->tanggal_masuk->format('d M Y') }} — {{ $k->tanggal_selesai->format('d M Y') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <span class="text-xs font-medium px-2 py-1 rounded-md shrink-0
                                                         {{ $k->status === 'aktif'
                                                            ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400'
                                                            : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400' }}">
                                                {{ ucfirst($k->status) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Riwayat Pengaduan --}}
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                                    bg-white dark:bg-slate-900 overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                                <h3 class="font-semibold text-slate-900 dark:text-slate-100">Pengaduan</h3>
                            </div>

                            @if ($user->pengaduan->isEmpty())
                                <div class="px-6 py-8 text-center">
                                    <p class="text-sm text-slate-400 dark:text-slate-500">
                                        Penyewa ini belum pernah mengajukan pengaduan.
                                    </p>
                                </div>
                            @else
                                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @foreach ($user->pengaduan as $p)
                                        <div class="flex items-center justify-between gap-4 px-6 py-3.5">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <div class="w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-800
                                                            flex items-center justify-center shrink-0">
                                                    <i class="fa-solid fa-triangle-exclamation text-slate-400 text-sm"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-100 truncate">
                                                        {{ $p->judul }}
                                                    </p>
                                                    <p class="text-xs text-slate-400 dark:text-slate-500">
                                                        Kamar {{ $p->kamar->nomor_kamar }} · {{ $p->created_at->format('d M Y') }}
                                                    </p>
                                                </div>
                                            </div>

                                            @if ($p->status === 'selesai')
                                                <span class="text-xs font-medium px-2 py-1 rounded-md shrink-0
                                                             bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                                    Selesai
                                                </span>
                                            @elseif ($p->status === 'diproses')
                                                <span class="text-xs font-medium px-2 py-1 rounded-md shrink-0
                                                             bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                                    Diproses
                                                </span>
                                            @else
                                                <span class="text-xs font-medium px-2 py-1 rounded-md shrink-0
                                                             bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                                    Pending
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
