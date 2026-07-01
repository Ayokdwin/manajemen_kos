@extends('layouts.admin')

@section('content')
    @php
        $pembayaran = $tagihan->pembayaran;
        $selectedMetode = old('metode', $pembayaran?->metode ?? 'transfer');

        $tagihanStatusClass = match ($tagihan->status) {
            'lunas' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400',
            'menunggu' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400',
            default => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-400',
        };

        $tagihanStatusLabel = match ($tagihan->status) {
            'lunas' => 'Lunas',
            'menunggu' => 'Menunggu Verifikasi',
            default => 'Belum Bayar',
        };

        $pembayaranStatusClass = match ($pembayaran?->status_varifikasi) {
            'disetujui' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400',
            'ditolak' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-400',
            default => 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400',
        };

        $pembayaranStatusLabel = match ($pembayaran?->status_varifikasi) {
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => 'Pending',
        };
    @endphp

    <div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950" x-data="{ metode: @js($selectedMetode) }">
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

                <a href="{{ route('tagihan.index') }}"
                   class="inline-flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400
                          hover:text-slate-800 dark:hover:text-slate-200 transition-colors mb-5">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Kembali ke daftar tagihan
                </a>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-1 space-y-6">
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase">
                                    Ringkasan Tagihan
                                </p>
                                <span class="text-xs font-medium px-2 py-1 rounded-md {{ $tagihanStatusClass }}">
                                    {{ $tagihanStatusLabel }}
                                </span>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-slate-400 dark:text-slate-500">Penyewa</p>
                                    <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                        {{ $tagihan->kontrak?->user?->name ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 dark:text-slate-500">Kamar</p>
                                    <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                        {{ $tagihan->kontrak?->kamar?->no_kamar ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 dark:text-slate-500">Periode</p>
                                    <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                        {{ \Carbon\Carbon::createFromDate($tagihan->tahun, $tagihan->bulan, 1)->translatedFormat('F Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 dark:text-slate-500">Nominal</p>
                                    <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                                        Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 dark:text-slate-500">Jatuh Tempo</p>
                                    <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                        {{ $tagihan->tanggal_jatuh_tempo?->format('d M Y') ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-4">
                                Status Pembayaran
                            </p>

                            @if ($pembayaran)
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-slate-500 dark:text-slate-400">Verifikasi</span>
                                        <span class="text-xs font-medium px-2 py-1 rounded-md {{ $pembayaranStatusClass }}">
                                            {{ $pembayaranStatusLabel }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Metode</p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200 capitalize">
                                            {{ $pembayaran->metode }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Tanggal Bayar</p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                            {{ \Carbon\Carbon::parse($pembayaran->tgl_bayar)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="rounded-xl border border-dashed border-slate-200 dark:border-slate-700 p-5 text-sm text-slate-500 dark:text-slate-400">
                                    Belum ada pembayaran yang dikirim.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-6">
                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                                <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">
                                    Bayar Tagihan
                                </h1>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                    Pilih metode pembayaran, lihat instruksi transfer bila diperlukan, lalu kirim bukti pembayaran.
                                </p>
                            </div>

                            <form action="{{ route('pembayaran.store', $tagihan->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="rounded-xl bg-slate-50 dark:bg-slate-800/50 p-4">
                                        <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-2">
                                            Penyewa
                                        </p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                            {{ $tagihan->kontrak?->user?->name ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-slate-50 dark:bg-slate-800/50 p-4">
                                        <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase mb-2">
                                            Kamar
                                        </p>
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                            {{ $tagihan->kontrak?->kamar?->no_kamar ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="metode" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                            Metode Pembayaran
                                        </label>
                                        <select id="metode" name="metode" x-model="metode"
                                                class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-slate-700 dark:text-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20 outline-none transition-colors @error('metode') border-rose-300 dark:border-rose-500/50 @enderror">
                                            <option value="transfer">Transfer</option>
                                            <option value="tunai">Tunai</option>
                                        </select>
                                        @error('metode')
                                            <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="tgl_bayar" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                            Tanggal Bayar
                                        </label>
                                        <input type="date" id="tgl_bayar" name="tgl_bayar" value="{{ old('tgl_bayar', now()->format('Y-m-d')) }}"
                                               class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-slate-700 dark:text-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20 outline-none transition-colors @error('tgl_bayar') border-rose-300 dark:border-rose-500/50 @enderror">
                                        @error('tgl_bayar')
                                            <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div x-show="metode === 'transfer'" x-cloak class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    <div class="rounded-2xl border border-indigo-100 dark:border-indigo-500/20 bg-indigo-50/60 dark:bg-indigo-500/10 p-5">
                                        <p class="text-xs font-semibold tracking-wide text-indigo-600 dark:text-indigo-400 uppercase">
                                            Nomor Rekening
                                        </p>
                                        <div class="mt-3 space-y-2 text-sm text-slate-700 dark:text-slate-200">
                                            <p><span class="font-semibold">Bank</span> BCA</p>
                                            <p><span class="font-semibold">No. Rekening</span> 1234567890</p>
                                            <p><span class="font-semibold">A/N</span> Manajemen Kos</p>
                                        </div>

                                       <div class="mt-5 rounded-2xl bg-white dark:bg-slate-900 p-4 border border-dashed border-indigo-200 dark:border-indigo-500/30">
    <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase mb-3">
        QR Simulasi
    </p>

    <div class="flex justify-center">
        {!! QrCode::size(200)->generate(
            'ID:12345|Nominal:50000|Merchant:Toko ABC'
        ) !!}
    </div>

    <p class="mt-3 text-center text-xs text-slate-400">
        Scan QR untuk simulasi pembayaran
    </p>
</div>
                                    </div>

                                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/40 p-5">
                                        <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase">
                                            Bukti Transfer
                                        </p>
                                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
                                            Upload bukti transfer setelah pembayaran dilakukan. Format gambar maksimal 2 MB.
                                        </p>

                                        <div class="mt-4">
                                            <label for="bukti_bayar" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                                Upload Bukti
                                            </label>
                                            <input type="file" id="bukti_bayar" name="bukti_bayar" accept="image/*"
                                                   class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-700 dark:text-slate-200 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-indigo-700 outline-none transition-colors @error('bukti_bayar') border-rose-300 dark:border-rose-500/50 @enderror">
                                            @error('bukti_bayar')
                                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mt-4 rounded-xl border border-amber-200 dark:border-amber-500/20 bg-amber-50 dark:bg-amber-500/10 p-4">
                                            <p class="text-sm font-medium text-amber-800 dark:text-amber-300">
                                                Pastikan nominal transfer sesuai tagihan agar verifikasi lebih cepat.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div x-show="metode === 'tunai'" x-cloak class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/40 p-5">
                                    <p class="text-xs font-semibold tracking-wide text-slate-400 dark:text-slate-500 uppercase">
                                        Pembayaran Tunai
                                    </p>
                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
                                        Jika memilih tunai, pembayaran akan dicatat dan menunggu verifikasi manual dari admin.
                                    </p>
                                </div>

                                <div class="flex flex-wrap items-center gap-3 pt-2">
                                    <button type="submit"
                                            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        Kirim Pembayaran
                                    </button>

                                    <a href="{{ route('tagihan.index') }}"
                                       class="inline-flex items-center gap-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-6 py-3 text-sm font-semibold text-slate-700 dark:text-slate-200 transition hover:bg-slate-50 dark:hover:bg-slate-800">
                                        Batal
                                    </a>
                                </div>
                            </form>
                        </div>

                        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6">
                            <p class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">
                                Status Riwayat
                            </p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                Setelah dikirim, data pembayaran akan muncul di daftar pembayaran dan status tagihan berubah menjadi <span class="font-medium text-slate-700 dark:text-slate-200">menunggu</span>.
                            </p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
