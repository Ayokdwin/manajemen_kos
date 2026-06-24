<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Manajemen Kos') }}</title>

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            body {
                font-family: "Instrument Sans", ui-sans-serif, system-ui, sans-serif;
            }
        </style>
    </head>
    <body class="overflow-x-hidden bg-[#EEF4FB] text-slate-900">
        @php
            $availableKamars = $kamars ?? collect();

            $facilityItems = [
                ['label' => 'Kasur',             'icon' => 'M4 20V9a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v11 M2 20h20 M6 7V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2'],
                ['label' => 'Lemari',            'icon' => 'M7 4h10v16H7z M7 10h10'],
                ['label' => 'Meja Belajar',      'icon' => 'M4 12h16 M7 12v6 M17 12v6 M6 18h12'],
                ['label' => 'Kursi',             'icon' => 'M8 5h6a2 2 0 0 1 2 2v5H8V7a2 2 0 0 1 2-2z M6 18h10 M8 12v6 M16 12v6'],
                ['label' => 'Kipas Angin',       'icon' => 'M12 3v9 M12 12c2.5 0 4.5-1 6-3 M12 12c-2.5 0-4.5 1-6 3 M12 12l2 6 M12 12l-2 6'],
                ['label' => 'Kamar Mandi Dalam', 'icon' => 'M9 3h6v4H9z M7 9h10v8H7z M10 17v2 M14 17v2'],
                ['label' => 'Wi-Fi',             'icon' => 'M5 10a11 11 0 0 1 14 0 M8 13a7 7 0 0 1 8 0 M11 16a3 3 0 0 1 2 0 M12 19h.01'],
                ['label' => 'Stop Kontak',       'icon' => 'M9 3h6v7H9z M10 14h4 M12 10v4 M7 20h10'],
            ];

            $featureHighlights = [
                ['title' => 'Aman',        'text' => 'Data terjaga dengan aman',         'icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z M9 12l2 2 4-4'],
                ['title' => 'Efisien',     'text' => 'Hemat waktu, kelola lebih cepat',  'icon' => 'M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2z M12 6v6l4 2'],
                ['title' => 'Terorganisir','text' => 'Semua data dalam satu tempat',     'icon' => 'M18 20V10 M12 20V4 M6 20v-6'],
            ];

            $heroFeatures = [
                ['label' => 'Kelola Kamar',          'desc' => 'Atur data kamar dan fasilitas dengan mudah',  'icon' => 'M3 10.5 12 3l9 7.5 M5 9.5V21h14V9.5 M9 21v-7h6v7'],
                ['label' => 'Kelola Penghuni',        'desc' => 'Data penghuni rapi dan terorganisir',          'icon' => 'M20 21a8 8 0 1 0-16 0 M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z M16 11c1.5.5 3 1.5 4 3'],
                ['label' => 'Pembayaran & Laporan',   'desc' => 'Catat pembayaran dan pantau laporan kapan saja','icon' => 'M12 2v20 M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6'],
            ];

            $authImage = base64_encode(file_get_contents(resource_path('views/auth/img/image.png')));
        @endphp

        <main>
            {{-- ===== HERO ===== --}}
            <div class="mx-auto max-w-[1400px] px-4 pb-0 pt-5 sm:px-6 lg:px-8">

                {{-- Navbar --}}
                <header class="flex items-center justify-between gap-4 rounded-2xl bg-white px-5 py-3.5 shadow-sm">
                    <a href="{{ route('index') }}" class="flex items-center gap-2.5">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-white">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/><path d="M9 21v-7h6v7"/>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-slate-900">Manajemen Kos</span>
                    </a>
                    <div class="hidden items-center gap-2 sm:flex">
                        <a href="#kamar-tersedia" class="rounded-full px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Kamar Tersedia</a>
                        <a href="{{ route('login') }}" class="rounded-full bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow transition hover:bg-blue-700">Masuk</a>
                    </div>
                </header>

                {{-- Hero 2-col --}}
                <section class="mt-6 grid min-h-[560px] grid-cols-1 gap-6 lg:grid-cols-[1fr_1.1fr]">

                    {{-- Left --}}
                    <div class="flex flex-col justify-center py-6 lg:py-10">
                        <p class="text-sm font-semibold text-slate-500">Selamat Datang! 👋</p>
                        <h1 class="mt-3 text-4xl font-black leading-tight tracking-tight text-blue-600 sm:text-5xl lg:text-[3.25rem]">
                            Kelola kos Anda<br>lebih mudah
                        </h1>
                        <p class="mt-4 max-w-md text-sm leading-7 text-slate-500">
                            Manajemen kos jadi lebih praktis dengan pencatatan kamar, penghuni, pembayaran, dan laporan dalam satu tempat.
                        </p>

                        {{-- Feature list --}}
                        <ul class="mt-7 space-y-4">
                            @foreach ($heroFeatures as $feat)
                                <li class="flex items-start gap-4">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="{{ $feat['icon'] }}"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $feat['label'] }}</p>
                                        <p class="text-sm text-slate-500">{{ $feat['desc'] }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-8">
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-3 rounded-xl bg-blue-600 px-7 py-4 text-sm font-bold text-white shadow-md transition hover:bg-blue-700">
                                Mulai Sekarang
                                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Right: image + feature strip --}}
                    <div class="relative flex flex-col overflow-hidden rounded-3xl bg-[#D6E9F8]">
                        <img
                            src="data:image/png;base64,{{ $authImage }}"
                            alt="Ilustrasi gedung kos modern"
                            class="h-full w-full flex-1 object-cover object-center"
                            style="min-height: 340px;"
                        >
                        {{-- Feature strip --}}
                        <div class="flex divide-x divide-slate-200 bg-white px-4 py-5">
                            @foreach ($featureHighlights as $feat)
                                <div class="flex flex-1 items-center gap-3 px-4 first:pl-0 last:pr-0">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white">
                                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="{{ $feat['icon'] }}"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $feat['title'] }}</p>
                                        <p class="text-xs text-slate-500">{{ $feat['text'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>

            {{-- ===== KAMAR TERSEDIA + FASILITAS ===== --}}
            <div class="mx-auto max-w-[1400px] px-4 py-8 sm:px-6 lg:px-8">
                <div class="grid gap-6 lg:grid-cols-[1fr_380px]">

                    {{-- Kamar list --}}
                    <section id="kamar-tersedia" class="rounded-3xl bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-black tracking-tight text-slate-900">Kamar Tersedia</h2>

                        <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-4">
                            @forelse ($kamars as $kamar)
                                <article class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                                    {{-- Foto --}}
                                    <div class="relative h-28 overflow-hidden bg-slate-100">
                                        @if ($kamar->foto)
                                            <img src="{{ asset('storage/' . $kamar->foto) }}" alt="Foto kamar {{ $kamar->no_kamar }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center bg-blue-50">
                                                <svg viewBox="0 0 24 24" class="h-8 w-8 text-blue-200" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="3" y="3" width="18" height="18" rx="3"/><path d="M3 9h18M9 21V9"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-3">
                                        <div class="flex items-center justify-between gap-1">
                                            <p class="text-xs font-bold text-slate-900">Kamar {{ $kamar->no_kamar }}</p>
                                            <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-600">{{$kamar->status}}</span>
                                        </div>
                                        <p class="mt-0.5 text-[11px] text-slate-500">{{ $kamar->tipe }}</p>
                                        <!-- <p class="mt-0.5 text-[11px] text-slate-500">Lantai {{ $kamar->lantai ?? '1' }}</p> -->
                                        <p class="mt-1.5 text-sm font-black text-blue-600">Rp {{ number_format($kamar->harga_per_bulan, 0, ',', '.') }} <span class="text-[10px] font-normal text-slate-400">/ bulan</span></p>
                                        <a href="{{ route('login') }}" class="mt-2.5 block w-full rounded-xl border border-slate-200 py-1.5 text-center text-xs font-semibold text-slate-700 transition hover:border-blue-300 hover:text-blue-600">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </article>
                            @empty
                                <div class="col-span-full rounded-2xl border border-dashed border-slate-300 py-10 text-center">
                                    <p class="text-sm font-semibold text-slate-600">Belum ada kamar tersedia</p>
                                    <p class="mt-1 text-xs text-slate-400">Silakan cek kembali nanti.</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-5 text-center">
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700">
                                Lihat semua kamar tersedia
                                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </section>

                    {{-- Fasilitas --}}
                    <aside class="rounded-3xl bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-black tracking-tight text-slate-900">Fasilitas Kamar</h2>

                        <div class="mt-5 grid grid-cols-4 gap-y-5">
                            @foreach ($facilityItems as $facility)
                                <div class="flex flex-col items-center gap-2 text-center">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="{{ $facility['icon'] }}"/>
                                        </svg>
                                    </div>
                                    <p class="text-[11px] font-semibold leading-tight text-slate-700">{{ $facility['label'] }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 flex items-center gap-2 rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3">
                            <svg viewBox="0 0 24 24" class="h-4 w-4 shrink-0 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                            <p class="text-xs font-semibold text-blue-700">Fasilitas lengkap untuk kenyamanan tinggal Anda</p>
                        </div>
                    </aside>
                </div>
            </div>

            {{-- Footer --}}
            <footer class="mx-auto max-w-[1400px] px-4 pb-8 sm:px-6 lg:px-8">
                <div class="rounded-2xl bg-white px-6 py-5 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-white">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/><path d="M9 21v-7h6v7"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-700">{{ config('app.name', 'Manajemen Kos') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="#kamar-tersedia" class="rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">Kamar Tersedia</a>
                            <a href="{{ route('login') }}" class="rounded-full bg-blue-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-blue-700">Masuk</a>
                        </div>
                    </div>
                    <p class="mt-4 border-t border-slate-100 pt-4 text-xs text-slate-400">&copy; {{ now()->year }} {{ config('app.name', 'Manajemen Kos') }}. Semua hak dilindungi.</p>
                </div>
            </footer>
        </main>
    </body>
</html>