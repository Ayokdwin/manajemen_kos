@extends('layouts.admin')

@section('content')
    @php
        $statusClass = match ($pembayaran->status_varifikasi) {
            'disetujui' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400',
            'ditolak' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-400',
            default => 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400',
        };

        $statusLabel = match ($pembayaran->status_varifikasi) {
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => 'Pending',
        };
    @endphp

    <div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-y-auto p-6">
                <a href="{{ route('pembayaran.index') }}"
                   class="inline-flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400
                          hover:text-slate-800 dark:hover:text-slate-200 transition-colors mb-5">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Kembali ke daftar pembayaran
                </a>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-1 space-y-6">
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase">
                                    Status Verifikasi
                                </p>
                                <span class="text-xs font-medium px-2 py-1 rounded-md {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-money-bill-wave text-indigo-600 dark:text-indigo-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Metode Pembayaran</p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200 capitalize">
                                            {{ $pembayaran->metode }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-violet-50 dark:bg-violet-500/10 flex items-center justify-center shrink-0">
                                        <i class="fa-regular fa-calendar-check text-violet-500 dark:text-violet-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Tanggal Bayar</p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                            {{ \Carbon\Carbon::parse($pembayaran->tgl_bayar)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-receipt text-emerald-600 dark:text-emerald-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Jumlah Pembayaran</p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                            Rp {{ number_format($pembayaran->tagihan?->jumlah_tagihan ?? 0, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 pt-5 border-t border-slate-100 dark:border-slate-800 space-y-2">
                                @if ($pembayaran->tagihan?->kontrak_id)
                                    <a href="{{ route('kontrak.show', $pembayaran->tagihan->kontrak_id) }}"
                                       class="flex items-center justify-center gap-2 w-full py-2 rounded-lg text-sm font-medium
                                              text-indigo-700 bg-indigo-50 dark:bg-indigo-500/10 dark:text-indigo-400
                                              hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition-colors">
                                        <i class="fa-solid fa-folder-open text-xs"></i>
                                        Lihat Kontrak
                                    </a>
                                @endif
                                <a href="{{ route('pembayaran.index') }}"
                                   class="flex items-center justify-center gap-2 w-full py-2 rounded-lg text-sm font-medium
                                          text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800
                                          hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                    <i class="fa-solid fa-list text-xs"></i>
                                    Kembali ke Daftar
                                </a>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-4">
                                Detail Kamar
                            </p>

                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-11 h-11 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-door-open text-slate-400"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-slate-100">
                                        Kamar {{ $pembayaran->tagihan?->kontrak?->kamar?->no_kamar ?? '-' }}
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 capitalize">
                                        {{ $pembayaran->tagihan?->kontrak?->kamar?->tipe ?? 'Data kamar tidak tersedia' }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-2 text-sm">
                                <div class="flex items-center gap-2 text-slate-600 dark:text-slate-300">
                                    <i class="fa-solid fa-user w-4 text-center text-slate-400 text-xs"></i>
                                    {{ $pembayaran->tagihan?->kontrak?->user?->name ?? '-' }}
                                </div>
                                <div class="flex items-center gap-2 text-slate-600 dark:text-slate-300">
                                    <i class="fa-regular fa-calendar w-4 text-center text-slate-400 text-xs"></i>
                                    {{ $pembayaran->tagihan ? 'Tagihan ' . \Carbon\Carbon::createFromDate($pembayaran->tagihan->tahun, $pembayaran->tagihan->bulan, 1)->translatedFormat('F Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-6">
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                                <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">
                                    Detail Pembayaran
                                </h1>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                    Ringkasan transaksi pembayaran tagihan dan status verifikasinya.
                                </p>
                            </div>

                            <div class="p-6 sm:p-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <div class="rounded-xl bg-slate-50 dark:bg-slate-800/50 p-4">
                                        <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-2">
                                            Penyewa
                                        </p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                            {{ $pembayaran->tagihan?->kontrak?->user?->name ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-slate-50 dark:bg-slate-800/50 p-4">
                                        <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-2">
                                            Kamar
                                        </p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                            {{ $pembayaran->tagihan?->kontrak?->kamar?->no_kamar ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-slate-50 dark:bg-slate-800/50 p-4">
                                        <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-2">
                                            Metode
                                        </p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200 capitalize">
                                            {{ $pembayaran->metode }}
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-slate-50 dark:bg-slate-800/50 p-4">
                                        <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-2">
                                            Status Verifikasi
                                        </p>
                                        <span class="inline-flex items-center text-xs font-medium px-2 py-1 rounded-md {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="rounded-2xl border border-slate-100 dark:border-slate-800 p-5">
                                        <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-4">
                                            Informasi Tagihan
                                        </p>

                                        <div class="space-y-4 text-sm">
                                            <div>
                                                <p class="text-slate-400 dark:text-slate-500 text-xs mb-1">Periode</p>
                                                <p class="text-slate-700 dark:text-slate-200 font-medium">
                                                    {{ $pembayaran->tagihan ? 'Tagihan ' . \Carbon\Carbon::createFromDate($pembayaran->tagihan->tahun, $pembayaran->tagihan->bulan, 1)->translatedFormat('F Y') : '-' }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-slate-400 dark:text-slate-500 text-xs mb-1">Jatuh Tempo</p>
                                                <p class="text-slate-700 dark:text-slate-200 font-medium">
                                                    {{ $pembayaran->tagihan?->tanggal_jatuh_tempo?->format('d M Y') ?? '-' }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-slate-400 dark:text-slate-500 text-xs mb-1">Nominal Tagihan</p>
                                                <p class="text-slate-700 dark:text-slate-200 font-medium">
                                                    Rp {{ number_format($pembayaran->tagihan?->jumlah_tagihan ?? 0, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <div>
                                                @if (auth()->user()->role === 'admin' && $pembayaran->status_varifikasi == 'pending')
                                                    <div class="space-y-2">
                                                        <form method="POST" action="{{ route('pembayaran.verify', $pembayaran->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status_varifikasi" value="disetujui">

                                                            <button type="submit"
                                                                class="flex items-center justify-center gap-2 w-full py-2 rounded-lg text-sm font-medium
                                                                    text-white bg-green-600 hover:bg-green-700">
                                                                <i class="fa-solid fa-check text-xs"></i>
                                                                Approve Pembayaran
                                                            </button>
                                                        </form>

                                                        <form method="POST" action="{{ route('pembayaran.verify', $pembayaran->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status_varifikasi" value="ditolak">

                                                            <button type="submit"
                                                                class="flex items-center justify-center gap-2 w-full py-2 rounded-lg text-sm font-medium
                                                                    text-white bg-red-600 hover:bg-red-700">
                                                                <i class="fa-solid fa-xmark text-xs"></i>
                                                                Reject Pembayaran
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-2xl border border-slate-100 dark:border-slate-800 p-5">
                                        <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-4">
                                            Bukti Pembayaran
                                        </p>

                                        @if ($pembayaran->metode === 'transfer' && $pembayaran->bukti_bayar)
                                            <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800">
                                                <img src="{{ asset('storage/' . $pembayaran->bukti_bayar) }}"
                                                     alt="Bukti Pembayaran"
                                                     class="w-full h-64 object-contain bg-white dark:bg-slate-900">
                                            </div>
                                            <p class="mt-3 text-xs text-slate-400 dark:text-slate-500 break-all">
                                                {{ $pembayaran->bukti_bayar }}
                                            </p>
                                        @else
                                            <div class="rounded-xl border border-dashed border-slate-200 dark:border-slate-700 p-8 text-center text-slate-400 dark:text-slate-500">
                                                <i class="fa-regular fa-image text-2xl mb-2 block"></i>
                                                Tidak ada bukti pembayaran.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
