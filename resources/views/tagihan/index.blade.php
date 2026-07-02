@extends('layouts.admin')

@section('content')
    @php
        $isAdmin = auth()->user()->role === 'admin';
    @endphp

    <div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-y-auto p-6">
                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-emerald-200 dark:border-emerald-500/30 bg-emerald-50 dark:bg-emerald-500/10 p-4 flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        <p class="text-sm font-medium text-emerald-700 dark:text-emerald-400">
                            {{ session('success') }}
                        </p>
                    </div>
                @endif

                <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Tagihan</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            {{ $isAdmin ? 'Kelola seluruh tagihan yang ada di sistem.' : 'Pantau tagihan milik Anda.' }}
                        </p>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                                    <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">No</th>
                                    @if ($isAdmin)
                                        <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Penyewa</th>
                                    @endif
                                    <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Kamar</th>
                                    <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Periode Tagihan</th>
                                    <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Jatuh Tempo</th>
                                    <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Jumlah</th>
                                    <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Status</th>
                                    <th class="text-right font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse ($tagihans as $tagihan)
                                    @php
                                        $statusClass = match ($tagihan->status) {
                                            'lunas' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400',
                                            'menunggu' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400',
                                            default => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-400',
                                        };

                                        $statusLabel = match ($tagihan->status) {
                                            'lunas' => 'Lunas',
                                            'menunggu' => 'Menunggu',
                                            default => 'Belum Bayar',
                                        };
                                    @endphp

                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                        <td class="px-5 py-3.5 font-medium text-slate-900 dark:text-slate-100">
                                            {{ $loop->iteration }}
                                        </td>

                                        @if ($isAdmin)
                                            <td class="px-5 py-3.5 text-slate-700 dark:text-slate-200">
                                                {{ $tagihan->kontrak?->user?->name ?? '-' }}
                                            </td>
                                        @endif

                                        <td class="px-5 py-3.5 text-slate-700 dark:text-slate-200">
                                            {{ $tagihan->kontrak?->kamar?->nomor_kamar ?? $tagihan->kontrak?->kamar?->no_kamar ?? '-' }}
                                        </td>

                                        <td class="px-5 py-3.5 text-slate-700 dark:text-slate-200">
                                            {{ \Carbon\Carbon::createFromDate($tagihan->tahun, $tagihan->bulan, 1)->translatedFormat('F Y') }}
                                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                                                Periode tagihan
                                            </p>
                                        </td>

                                        <td class="px-5 py-3.5 text-slate-700 dark:text-slate-200">
                                            {{ $tagihan->tanggal_jatuh_tempo->format('d M Y') }}
                                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                                                Bayar sebelum tanggal ini
                                            </p>
                                        </td>

                                        <td class="px-5 py-3.5 text-slate-700 dark:text-slate-200">
                                            Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                                        </td>

                                        <td class="px-5 py-3.5">
                                            <span class="inline-flex items-center text-xs font-medium px-2 py-1 rounded-md {{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>

                                        <td class="px-5 py-3.5 text-right">
                                            @if (auth()->check() && auth()->user()->role === 'user')
                                            <a href="{{ route('pembayaran.payment', $tagihan->id) }}"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 transition-colors"
                                               title="Bayar tagihan">
                                                <i class="fa-solid fa-money-bill-wave text-sm"></i>
                                            </a>
                                            @endif
                                            <a href="{{ route('kontrak.show', $tagihan->kontrak_id) }}"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-colors"
                                               title="Lihat kontrak">
                                                <i class="fa-solid fa-eye text-sm"></i>
                                            </a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $isAdmin ? 8 : 7 }}" class="px-5 py-10 text-center text-slate-400 dark:text-slate-500">
                                            <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
                                            Belum ada tagihan.
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
