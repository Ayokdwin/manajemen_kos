<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Manajemen Kos') }} - Dashboard Penyewa</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 text-slate-900">
        <div class="min-h-screen lg:pl-80">
            @include('user.partials.sidebar', ['tenantName' => $user->name])

            <div class="flex min-h-screen flex-col">
                @include('user.partials.header', ['tenantName' => $user->name])

                <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-7xl space-y-6">
                        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                            <article class="rounded-[1.75rem] bg-white p-5 shadow-sm ring-1 ring-slate-200">
                                <div class="flex items-start justify-between gap-4">
                                    
                                    <div>
                                        <p class="text-sm font-medium text-slate-500">Kamar Anda</p>
                                        <p class="mt-2 text-3xl font-black text-slate-950">{{ $kamar?->no_kamar ?? '-' }}</p>
                                        <p class="mt-1 text-sm text-slate-600">
                                            {{ $kamar ? 'Lantai ' . (preg_replace('/\D+/', '', $kamar->no_kamar) ?: '1') : 'Belum ada kamar' }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 21h18"></path>
                                            <path d="M5 21V7l7-4 7 4v14"></path>
                                            <path d="M9 21v-8h6v8"></path>
                                        </svg>
                                    </div>
                                </div>
                            </article>

                            <article class="rounded-[1.75rem] bg-white p-5 shadow-sm ring-1 ring-slate-200">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-slate-500">Status Sewa</p>
                                        <p class="mt-2 text-3xl font-black text-emerald-600">{{ $kontrakAktif?->status ? ucfirst($kontrakAktif->status) : 'Belum ada' }}</p>
                                        <p class="mt-1 text-sm text-slate-600">
                                            {{ $kontrakAktif?->tanggal_selesai ? 'Berakhir ' . \Illuminate\Support\Carbon::parse($kontrakAktif->tanggal_selesai)->translatedFormat('d F Y') : 'Belum ada kontrak aktif' }}
                                        </p>
                                    </div>
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M20 7 10 17l-5-5"></path>
                                        </svg>
                                    </div>
                                </div>
                            </article>

                            <article class="rounded-[1.75rem] bg-white p-5 shadow-sm ring-1 ring-slate-200">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-slate-500">Total Tagihan</p>
                                        <p class="mt-2 text-3xl font-black text-slate-950">
                                            Rp {{ $kamar ? number_format($kamar->harga_per_bulan, 0, ',', '.') : '0' }}
                                        </p>
                                        <p class="mt-1 text-sm text-slate-600">/Bulan berjalan</p>
                                    </div>
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 1v22"></path>
                                            <path d="M17 5H9.5a3.5 3.5 0 1 0 0 7H14a3.5 3.5 0 1 1 0 7H6"></path>
                                        </svg>
                                    </div>
                                </div>
                            </article>

                            <article class="rounded-[1.75rem] bg-white p-5 shadow-sm ring-1 ring-slate-200">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-slate-500">Pembayaran Terakhir</p>
                                        <p class="mt-2 text-3xl font-black text-slate-950">Rp {{ $kamar ? number_format($kamar->harga_per_bulan, 0, ',', '.') : '0' }}</p>
                                        <p class="mt-1 text-sm text-slate-600">{{ now()->translatedFormat('d F Y') }}</p>
                                    </div>
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-50 text-sky-600">
                                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M4 19h16"></path>
                                            <path d="M6 19V5h12v14"></path>
                                            <path d="M9 9h6"></path>
                                            <path d="M9 13h6"></path>
                                        </svg>
                                    </div>
                                </div>
                            </article>
                        </section>

                        <section class="grid gap-6 xl:grid-cols-[1.55fr_0.95fr]">
                            <div class="space-y-6">
                                <article class="rounded-[1.75rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Tagihan Bulan Ini</p>
                                            <h2 class="mt-1 text-2xl font-black text-slate-950">Periode {{ now()->translatedFormat('F Y') }}</h2>
                                        </div>
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">
                                            Lunas
                                        </span>
                                    </div>

                                    <div class="mt-6 grid gap-4 sm:grid-cols-3">
                                        <div class="rounded-2xl bg-slate-50 p-4">
                                            <p class="text-sm text-slate-500">Total tagihan</p>
                                            <p class="mt-2 text-2xl font-black text-slate-950">Rp 1.500.000</p>
                                        </div>
                                        <div class="rounded-2xl bg-slate-50 p-4">
                                            <p class="text-sm text-slate-500">Tanggal pembayaran</p>
                                            <p class="mt-2 text-2xl font-black text-slate-950">12 Juni</p>
                                        </div>
                                        <div class="rounded-2xl bg-slate-50 p-4">
                                            <p class="text-sm text-slate-500">Status</p>
                                            <p class="mt-2 text-2xl font-black text-emerald-600">Terverifikasi</p>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex flex-wrap items-center gap-3">
                                        <a href="#" class="inline-flex items-center rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                                            Lihat Riwayat
                                        </a>
                                        <p class="text-sm text-slate-500">Pembayaran bulan ini sudah masuk pada sistem.</p>
                                    </div>
                                </article>

                                <article class="rounded-[1.75rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Riwayat Pembayaran</p>
                                            <h2 class="mt-1 text-2xl font-black text-slate-950">3 Bulan Terakhir</h2>
                                        </div>
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Detail transaksi</span>
                                    </div>

                                    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200">
                                        <table class="min-w-full divide-y divide-slate-200 text-left">
                                            <thead class="bg-slate-50">
                                                <tr class="text-sm text-slate-500">
                                                    <th class="px-4 py-3 font-medium">Bulan</th>
                                                    <th class="px-4 py-3 font-medium">Status</th>
                                                    <th class="px-4 py-3 font-medium">Tanggal pembayaran</th>
                                                    <th class="px-4 py-3 font-medium">Jumlah pembayaran</th>
                                                    <th class="px-4 py-3 font-medium"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-200 bg-white">
                                                @foreach($pembayaran as $bayar)
                                                <tr class="text-sm">
                                                    <td class="px-4 py-4 font-medium text-slate-900">{{$bayar->tgl_bayar}}</td>
                                                    <td class="px-4 py-4"><span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">{{$bayar->status}}</span></td>
                                                    <td class="px-4 py-4 text-slate-600">12 Juni 2026</td>
                                                    <td class="px-4 py-4 text-slate-900">Rp 1.500.000</td>
                                                    <td class="px-4 py-4 text-right">
                                                        <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-slate-700 transition hover:bg-slate-200">
                                                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                <path d="m9 18 6-6-6-6"></path>
                                                            </svg>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </article>
                            </div>

                            <aside class="space-y-6">
                                <article class="overflow-hidden rounded-[1.75rem] bg-white shadow-sm ring-1 ring-slate-200">
                                    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
                                        <div>
                                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Informasi Kamar</p>
                                            <h2 class="mt-1 text-2xl font-black text-slate-950">Unit 101</h2>
                                        </div>
                                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">Lantai 1</span>
                                    </div>

                                    <div class="grid gap-5 p-6 lg:grid-cols-[1fr_150px]">
                                        <div class="space-y-4 text-sm">
                                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                                <span class="text-slate-500">Nomor kamar</span>
                                                <span class="font-semibold text-slate-900">101</span>
                                            </div>
                                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                                <span class="text-slate-500">Lantai</span>
                                                <span class="font-semibold text-slate-900">1</span>
                                            </div>
                                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                                <span class="text-slate-500">Tipe kamar</span>
                                                <span class="font-semibold text-slate-900">Standar</span>
                                            </div>
                                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                                <span class="text-slate-500">Harga per bulan</span>
                                                <span class="font-semibold text-slate-900">Rp 1.500.000</span>
                                            </div>
                                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                                <span class="text-slate-500">Masa sewa</span>
                                                <span class="font-semibold text-slate-900">1 Jan - 30 Sep 2026</span>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-center">
                                            <div class="relative h-40 w-full rounded-[1.5rem] bg-gradient-to-b from-sky-100 via-white to-emerald-100 p-3">
                                                <svg viewBox="0 0 220 220" class="h-full w-full" aria-hidden="true">
                                                    <rect x="8" y="8" width="204" height="204" rx="28" fill="#f8fbff"></rect>
                                                    <rect x="36" y="44" width="148" height="108" rx="18" fill="#dbeafe"></rect>
                                                    <rect x="48" y="58" width="124" height="70" rx="10" fill="#ffffff" stroke="#93c5fd" stroke-width="2"></rect>
                                                    <rect x="52" y="132" width="116" height="16" rx="8" fill="#cbd5e1"></rect>
                                                    <rect x="74" y="118" width="72" height="28" rx="8" fill="#60a5fa"></rect>
                                                    <rect x="82" y="126" width="18" height="14" rx="3" fill="#bfdbfe"></rect>
                                                    <rect x="106" y="126" width="18" height="14" rx="3" fill="#bfdbfe"></rect>
                                                    <circle cx="70" cy="176" r="11" fill="#4ade80"></circle>
                                                    <circle cx="154" cy="176" r="11" fill="#22c55e"></circle>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </article>

                                <article class="rounded-[1.75rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Pengumuman Terbaru</p>
                                            <h2 class="mt-1 text-2xl font-black text-slate-950">Info dari Pengelola</h2>
                                        </div>
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">3 notifikasi</span>
                                    </div>

                                    <div class="mt-6 space-y-4">
                                        <div class="flex gap-4 rounded-2xl bg-slate-50 p-4">
                                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M12 2v20"></path>
                                                    <path d="M2 12h20"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900">Jadwal perawatan rutin</p>
                                                <p class="mt-1 text-xs text-slate-500">24 Juni 2026</p>
                                                <p class="mt-2 text-sm leading-6 text-slate-600">Akan ada pengecekan listrik dan kebersihan area umum pada pagi hari.</p>
                                            </div>
                                        </div>

                                        <div class="flex gap-4 rounded-2xl bg-slate-50 p-4">
                                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M12 20h9"></path>
                                                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900">Pengingat pembayaran</p>
                                                <p class="mt-1 text-xs text-slate-500">22 Juni 2026</p>
                                                <p class="mt-2 text-sm leading-6 text-slate-600">Mohon lakukan pembayaran sebelum tanggal jatuh tempo untuk menghindari denda.</p>
                                            </div>
                                        </div>

                                        <div class="flex gap-4 rounded-2xl bg-slate-50 p-4">
                                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M4 7h16"></path>
                                                    <path d="M4 12h10"></path>
                                                    <path d="M4 17h7"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900">Informasi fasilitas</p>
                                                <p class="mt-1 text-xs text-slate-500">20 Juni 2026</p>
                                                <p class="mt-2 text-sm leading-6 text-slate-600">Wifi area lounge sudah diperbarui untuk mendukung aktivitas penghuni.</p>
                                            </div>
                                        </div>
                                    </div>
                                </article>

                                <div class="rounded-[1.75rem] bg-blue-600 p-6 text-white shadow-lg shadow-blue-200">
                                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-100">Bantuan Cepat</p>
                                    <h2 class="mt-2 text-2xl font-black">Nikmati kenyamanan tinggal di kos kami!</h2>
                                    <p class="mt-3 text-sm leading-6 text-blue-100">
                                        Jika ada kendala atau pertanyaan, hubungi pengelola kapan saja untuk mendapatkan bantuan.
                                    </p>
                                    <a href="#" class="mt-5 inline-flex items-center rounded-full bg-white px-5 py-3 text-sm font-semibold text-blue-700 transition hover:bg-blue-50">
                                        Hubungi Pengelola
                                    </a>
                                </div>
                            </aside>
                        </section>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
