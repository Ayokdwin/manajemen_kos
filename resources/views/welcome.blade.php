<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Anti-flash: set tema sebelum halaman dirender --}}
        <script>
            (function () {
                var stored = localStorage.getItem('theme');
                var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                var isDark = stored ? stored === 'dark' : prefersDark;
                document.documentElement.classList.toggle('dark', isDark);
            })();
        </script>

        <title>{{ config('app.name', 'Manajemen Kos') }}</title>

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            html {
                scroll-behavior: smooth;
            }
            body {
                font-family: "Instrument Sans", ui-sans-serif, system-ui, sans-serif;
            }

            ::selection {
                background-color: #C7D2FE;
                color: #312E81;
            }
            .dark ::selection {
                background-color: #4338CA;
                color: #EEF2FF;
            }

            @keyframes blob {
                0%, 100% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -40px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.95); }
            }
            .animate-blob { animation: blob 9s infinite ease-in-out; }
            .animation-delay-2000 { animation-delay: 2s; }
            .animation-delay-4000 { animation-delay: 4s; }

            .reveal {
                opacity: 0;
                transform: translateY(24px);
                transition: opacity .7s ease, transform .7s ease;
            }
            .reveal.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            #site-header { transition: box-shadow .3s ease, background-color .3s ease; }

            #back-to-top {
                opacity: 0;
                pointer-events: none;
                transform: translateY(12px);
                transition: opacity .3s ease, transform .3s ease;
            }
            #back-to-top.is-visible {
                opacity: 1;
                pointer-events: auto;
                transform: translateY(0);
            }

            .filter-btn[data-active="true"] {
                background-image: linear-gradient(to right, #4F46E5, #7C3AED);
                color: #fff;
                box-shadow: 0 6px 16px -4px rgba(79, 70, 229, 0.45);
            }

            :focus-visible {
                outline: 2px solid #6366F1;
                outline-offset: 2px;
            }
        </style>
    </head>
    <body class="relative overflow-x-hidden bg-gradient-to-b from-indigo-50 via-violet-50 to-white text-slate-900 transition-colors duration-300 dark:from-slate-950 dark:via-indigo-950 dark:to-slate-900 dark:text-slate-100">
        @php
            $availableKamars = $kamars ?? collect();
            $statusOptions = $availableKamars->pluck('status')->filter()->unique()->values();

            $statusStyle = function ($status) {
                $s = strtolower($status ?? '');
                if (str_contains($s, 'kosong') || str_contains($s, 'tersedia')) {
                    return 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400';
                }
                if (str_contains($s, 'isi') || str_contains($s, 'penuh')) {
                    return 'bg-rose-50 text-rose-600 dark:bg-rose-950/50 dark:text-rose-400';
                }
                return 'bg-indigo-50 text-indigo-600 dark:bg-indigo-950/50 dark:text-indigo-400';
            };

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

        {{-- Decorative blobs --}}
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div class="animate-blob absolute -left-24 -top-24 h-96 w-96 rounded-full bg-violet-300 opacity-30 blur-3xl dark:bg-violet-700 dark:opacity-20"></div>
            <div class="animate-blob animation-delay-2000 absolute right-0 top-40 h-96 w-96 rounded-full bg-indigo-300 opacity-30 blur-3xl dark:bg-indigo-700 dark:opacity-20"></div>
            <div class="animate-blob animation-delay-4000 absolute bottom-0 left-1/3 h-96 w-96 rounded-full bg-violet-200 opacity-30 blur-3xl dark:bg-violet-800 dark:opacity-20"></div>
        </div>

        <main>
            {{-- ===== HERO ===== --}}
            <div class="mx-auto max-w-[1400px] px-4 pb-0 pt-5 sm:px-6 lg:px-8">

                {{-- Navbar --}}
                <header id="site-header" class="sticky top-5 z-50 flex items-center justify-between gap-4 rounded-2xl bg-white/80 px-5 py-3.5 shadow-sm backdrop-blur-md dark:bg-slate-900/80">
                    <a href="{{ route('index') }}" class="flex items-center gap-2.5">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white shadow-md shadow-indigo-200 dark:shadow-black/40">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/><path d="M9 21v-7h6v7"/>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">Manajemen Kos</span>
                    </a>

                    <div class="flex items-center gap-1.5">
                        <div class="hidden items-center gap-2 sm:flex">
                            <a href="#kamar-tersedia" class="relative rounded-full px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-600 dark:text-slate-300 dark:hover:bg-indigo-950/50 dark:hover:text-indigo-400">Kamar Tersedia</a>
                            <a href="#fasilitas" class="relative rounded-full px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-600 dark:text-slate-300 dark:hover:bg-indigo-950/50 dark:hover:text-indigo-400">Fasilitas</a>
                            <a href="{{ route('login') }}" class="rounded-full bg-gradient-to-r from-indigo-600 to-violet-600 px-5 py-2 text-sm font-semibold text-white shadow-md shadow-indigo-200 transition hover:shadow-lg hover:shadow-indigo-300 active:scale-95 dark:shadow-black/40">Masuk</a>
                        </div>

                        {{-- Dark / light mode toggle --}}
                        <button id="theme-toggle" type="button" aria-label="Ganti mode gelap/terang" class="flex h-10 w-10 items-center justify-center rounded-full text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-600 dark:text-slate-300 dark:hover:bg-indigo-950/50 dark:hover:text-indigo-400">
                            <svg id="theme-icon-sun" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="4"/><path d="M12 2v2 M12 20v2 M4.93 4.93l1.41 1.41 M17.66 17.66l1.41 1.41 M2 12h2 M20 12h2 M4.93 19.07l1.41-1.41 M17.66 6.34l1.41-1.41"/>
                            </svg>
                            <svg id="theme-icon-moon" viewBox="0 0 24 24" class="hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                            </svg>
                        </button>

                        {{-- Mobile menu button --}}
                        <button id="menu-toggle" type="button" class="flex h-10 w-10 items-center justify-center rounded-full text-slate-600 transition hover:bg-indigo-50 dark:text-slate-300 dark:hover:bg-indigo-950/50 sm:hidden" aria-label="Buka menu" aria-expanded="false">
                            <svg id="menu-icon-open" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 6h16 M4 12h16 M4 18h16"/>
                            </svg>
                            <svg id="menu-icon-close" viewBox="0 0 24 24" class="hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 6l12 12 M18 6L6 18"/>
                            </svg>
                        </button>
                    </div>
                </header>

                {{-- Mobile menu panel --}}
                <div id="mobile-menu" class="hidden sm:hidden">
                    <div class="mx-1 mt-2 flex flex-col gap-1 rounded-2xl bg-white/95 p-3 shadow-md backdrop-blur-md dark:bg-slate-900/95">
                        <a href="#kamar-tersedia" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-600 dark:text-slate-300 dark:hover:bg-indigo-950/50 dark:hover:text-indigo-400">Kamar Tersedia</a>
                        <a href="#fasilitas" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-600 dark:text-slate-300 dark:hover:bg-indigo-950/50 dark:hover:text-indigo-400">Fasilitas</a>
                        <a href="{{ route('login') }}" class="rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2.5 text-center text-sm font-semibold text-white shadow-md">Masuk</a>
                    </div>
                </div>

                {{-- Hero 2-col --}}
                <section class="mt-6 grid min-h-[560px] grid-cols-1 gap-6 lg:grid-cols-[1fr_1.1fr]">

                    {{-- Left --}}
                    <div class="flex flex-col justify-center py-6 lg:py-10">
                        <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-indigo-100 px-3 py-1 text-xs font-bold text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300">
                            <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="currentColor"><path d="M12 2l1.8 5.6L19.5 9l-5.7 1.4L12 16l-1.8-5.6L4.5 9l5.7-1.4L12 2z"/></svg>
                            Selamat Datang!
                        </span>
                        <h1 class="mt-3 text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-[3.25rem]">
                            <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Kelola kos Anda</span><br>
                            <span class="text-slate-900 dark:text-white">lebih mudah</span>
                        </h1>
                        <p class="mt-4 max-w-md text-sm leading-7 text-slate-500 dark:text-slate-400">
                            Manajemen kos jadi lebih praktis dengan pencatatan kamar, penghuni, pembayaran, dan laporan dalam satu tempat.
                        </p>

                        {{-- Feature list --}}
                        <ul class="mt-7 space-y-4">
                            @foreach ($heroFeatures as $feat)
                                <li class="group flex items-start gap-4">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-50 to-violet-50 text-indigo-600 transition duration-300 group-hover:scale-110 group-hover:from-indigo-600 group-hover:to-violet-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-indigo-200 dark:from-indigo-950 dark:to-violet-950 dark:text-indigo-400 dark:group-hover:shadow-black/40">
                                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="{{ $feat['icon'] }}"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $feat['label'] }}</p>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $feat['desc'] }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-8">
                            <a href="{{ route('login') }}" class="group inline-flex items-center gap-3 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-7 py-4 text-sm font-bold text-white shadow-md shadow-indigo-200 transition hover:shadow-xl hover:shadow-indigo-300 active:scale-95 dark:shadow-black/40">
                                Mulai Sekarang
                                <svg viewBox="0 0 24 24" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Right: image + feature strip --}}
                    <div class="relative flex flex-col overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-100 to-violet-100 shadow-xl shadow-indigo-100 dark:from-indigo-950 dark:to-violet-950 dark:shadow-black/40">
                        <div class="relative flex-1 overflow-hidden" style="min-height: 340px;">
                            <img
                                src="data:image/png;base64,{{ $authImage }}"
                                alt="Ilustrasi gedung kos modern"
                                class="h-full w-full object-cover object-center transition-transform duration-700 hover:scale-105"
                            >
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-indigo-900/30 via-transparent to-transparent"></div>
                        </div>
                        {{-- Feature strip --}}
                        <div class="flex divide-x divide-indigo-100 bg-white/90 px-4 py-5 backdrop-blur-sm dark:divide-indigo-900 dark:bg-slate-900/90">
                            @foreach ($featureHighlights as $feat)
                                <div class="group flex flex-1 items-center gap-3 px-4 first:pl-0 last:pr-0">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white transition duration-300 group-hover:scale-110 group-hover:rotate-3">
                                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="{{ $feat['icon'] }}"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $feat['title'] }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $feat['text'] }}</p>
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
                    <section id="kamar-tersedia" class="reveal rounded-3xl bg-white p-6 shadow-sm dark:bg-slate-900">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <h2 class="text-xl font-black tracking-tight text-slate-900 dark:text-white">Kamar Tersedia</h2>

                            @if ($statusOptions->isNotEmpty())
                                <div class="flex flex-wrap gap-2" id="filter-group">
                                    <button type="button" data-filter="semua" data-active="true" class="filter-btn rounded-full bg-indigo-50 px-3.5 py-1.5 text-xs font-semibold text-indigo-600 transition hover:opacity-90 dark:bg-indigo-950/60 dark:text-indigo-300">
                                        Semua
                                    </button>
                                    @foreach ($statusOptions as $status)
                                        <button type="button" data-filter="{{ strtolower($status) }}" data-active="false" class="filter-btn rounded-full bg-indigo-50 px-3.5 py-1.5 text-xs font-semibold text-indigo-600 transition hover:opacity-90 dark:bg-indigo-950/60 dark:text-indigo-300">
                                            {{ $status }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-4" id="kamar-grid">
                            @forelse ($kamars as $kamar)
                                <article data-status="{{ strtolower($kamar->status) }}" class="kamar-card group overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-indigo-200 hover:shadow-lg hover:shadow-indigo-100 dark:border-slate-800 dark:bg-slate-800/60 dark:hover:border-indigo-800 dark:hover:shadow-black/40">
                                    {{-- Foto --}}
                                    <div class="relative h-28 overflow-hidden bg-indigo-50 dark:bg-indigo-950">
                                        @if ($kamar->foto)
                                            <img src="{{ asset('storage/' . $kamar->foto) }}" alt="Foto kamar {{ $kamar->no_kamar }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-indigo-50 to-violet-50 dark:from-indigo-950 dark:to-violet-950">
                                                <svg viewBox="0 0 24 24" class="h-8 w-8 text-indigo-200 dark:text-indigo-800" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="3" y="3" width="18" height="18" rx="3"/><path d="M3 9h18M9 21V9"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-3">
                                        <div class="flex items-center justify-between gap-1">
                                            <p class="text-xs font-bold text-slate-900 dark:text-white">Kamar {{ $kamar->no_kamar }}</p>
                                            <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $statusStyle($kamar->status) }}">{{ $kamar->status }}</span>
                                        </div>
                                        <p class="mt-0.5 text-[11px] text-slate-500 dark:text-slate-400">{{ $kamar->tipe }}</p>
                                        <!-- <p class="mt-0.5 text-[11px] text-slate-500">Lantai {{ $kamar->lantai ?? '1' }}</p> -->
                                        <p class="mt-1.5 text-sm font-black text-indigo-600 dark:text-indigo-400">Rp {{ number_format($kamar->harga_per_bulan, 0, ',', '.') }} <span class="text-[10px] font-normal text-slate-400 dark:text-slate-500">/ bulan</span></p>
                                        <a href="{{ route('login') }}" class="mt-2.5 flex w-full items-center justify-center gap-1 rounded-xl border border-slate-200 py-1.5 text-center text-xs font-semibold text-slate-700 transition duration-300 hover:border-transparent hover:bg-gradient-to-r hover:from-indigo-600 hover:to-violet-600 hover:text-white dark:border-slate-700 dark:text-slate-300">
                                            Lihat Detail
                                            <svg viewBox="0 0 24 24" class="h-3 w-3 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </article>
                            @empty
                                <div class="col-span-full rounded-2xl border border-dashed border-indigo-200 bg-indigo-50/40 py-10 text-center dark:border-indigo-900 dark:bg-indigo-950/20">
                                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">Belum ada kamar tersedia</p>
                                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Silakan cek kembali nanti.</p>
                                </div>
                            @endforelse
                        </div>

                        <p id="no-result" class="mt-5 hidden text-center text-sm text-slate-400 dark:text-slate-500">Tidak ada kamar dengan status ini.</p>

                        <div class="mt-5 text-center">
                            <a href="{{ route('login') }}" class="group inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-violet-600 dark:text-indigo-400 dark:hover:text-violet-400">
                                Lihat semua kamar tersedia
                                <svg viewBox="0 0 24 24" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </section>

                    {{-- Fasilitas --}}
                    <aside id="fasilitas" class="reveal rounded-3xl bg-white p-6 shadow-sm dark:bg-slate-900">
                        <h2 class="text-xl font-black tracking-tight text-slate-900 dark:text-white">Fasilitas Kamar</h2>

                        <div class="mt-5 grid grid-cols-4 gap-y-5">
                            @foreach ($facilityItems as $facility)
                                <div class="group flex flex-col items-center gap-2 text-center">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-50 to-violet-50 text-indigo-600 transition duration-300 group-hover:-rotate-3 group-hover:scale-110 group-hover:from-indigo-600 group-hover:to-violet-600 group-hover:text-white group-hover:shadow-md group-hover:shadow-indigo-200 dark:from-indigo-950 dark:to-violet-950 dark:text-indigo-400 dark:group-hover:shadow-black/40">
                                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="{{ $facility['icon'] }}"/>
                                        </svg>
                                    </div>
                                    <p class="text-[11px] font-semibold leading-tight text-slate-700 dark:text-slate-300">{{ $facility['label'] }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 flex items-center gap-2 rounded-2xl border border-indigo-100 bg-gradient-to-r from-indigo-50 to-violet-50 px-4 py-3 dark:border-indigo-900 dark:from-indigo-950 dark:to-violet-950">
                            <svg viewBox="0 0 24 24" class="h-4 w-4 shrink-0 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                            <p class="text-xs font-semibold text-indigo-700 dark:text-indigo-300">Fasilitas lengkap untuk kenyamanan tinggal Anda</p>
                        </div>
                    </aside>
                </div>
            </div>

            {{-- Footer --}}
            <footer class="mx-auto max-w-[1400px] px-4 pb-8 sm:px-6 lg:px-8">
                <div class="rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-5 shadow-lg shadow-indigo-200 dark:shadow-black/40">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/15 text-white">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/><path d="M9 21v-7h6v7"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-white">{{ config('app.name', 'Manajemen Kos') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="#kamar-tersedia" class="rounded-full bg-white/15 px-4 py-2 text-xs font-semibold text-white transition hover:bg-white/25">Kamar Tersedia</a>
                            <a href="{{ route('login') }}" class="rounded-full bg-white px-4 py-2 text-xs font-semibold text-indigo-600 transition hover:bg-indigo-50">Masuk</a>
                        </div>
                    </div>
                    <p class="mt-4 border-t border-white/20 pt-4 text-xs text-indigo-100">&copy; {{ now()->year }} {{ config('app.name', 'Manajemen Kos') }}. Semua hak dilindungi.</p>
                </div>
            </footer>
        </main>

        {{-- Back to top --}}
        <button id="back-to-top" type="button" aria-label="Kembali ke atas" class="fixed bottom-6 right-6 z-50 flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-indigo-600 to-violet-600 text-white shadow-lg shadow-indigo-300 transition hover:scale-110 dark:shadow-black/40">
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 19V5 M5 12l7-7 7 7"/>
            </svg>
        </button>

        <script>
            (function () {
                // Sticky header shadow on scroll
                var header = document.getElementById('site-header');
                var backToTop = document.getElementById('back-to-top');

                function onScroll() {
                    var scrolled = window.scrollY > 12;
                    if (header) header.classList.toggle('shadow-lg', scrolled);
                    if (backToTop) backToTop.classList.toggle('is-visible', window.scrollY > 400);
                }
                document.addEventListener('scroll', onScroll, { passive: true });
                onScroll();

                if (backToTop) {
                    backToTop.addEventListener('click', function () {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                }

                // Mobile menu toggle
                var menuToggle = document.getElementById('menu-toggle');
                var mobileMenu = document.getElementById('mobile-menu');
                var iconOpen = document.getElementById('menu-icon-open');
                var iconClose = document.getElementById('menu-icon-close');

                if (menuToggle && mobileMenu) {
                    menuToggle.addEventListener('click', function () {
                        var isHidden = mobileMenu.classList.contains('hidden');
                        mobileMenu.classList.toggle('hidden');
                        iconOpen.classList.toggle('hidden');
                        iconClose.classList.toggle('hidden');
                        menuToggle.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
                    });

                    mobileMenu.querySelectorAll('a').forEach(function (link) {
                        link.addEventListener('click', function () {
                            mobileMenu.classList.add('hidden');
                            iconOpen.classList.remove('hidden');
                            iconClose.classList.add('hidden');
                            menuToggle.setAttribute('aria-expanded', 'false');
                        });
                    });
                }

                // Dark / light mode toggle
                var themeToggle = document.getElementById('theme-toggle');
                var sunIcon = document.getElementById('theme-icon-sun');
                var moonIcon = document.getElementById('theme-icon-moon');

                function updateThemeIcons() {
                    var isDark = document.documentElement.classList.contains('dark');
                    if (sunIcon) sunIcon.classList.toggle('hidden', isDark);
                    if (moonIcon) moonIcon.classList.toggle('hidden', !isDark);
                }
                updateThemeIcons();

                if (themeToggle) {
                    themeToggle.addEventListener('click', function () {
                        var isDark = document.documentElement.classList.toggle('dark');
                        localStorage.setItem('theme', isDark ? 'dark' : 'light');
                        updateThemeIcons();
                    });
                }

                // Scroll reveal animation
                var revealEls = document.querySelectorAll('.reveal');
                if ('IntersectionObserver' in window && revealEls.length) {
                    var observer = new IntersectionObserver(function (entries) {
                        entries.forEach(function (entry) {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('is-visible');
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.1 });
                    revealEls.forEach(function (el) { observer.observe(el); });
                } else {
                    revealEls.forEach(function (el) { el.classList.add('is-visible'); });
                }

                // Room status filter
                var filterGroup = document.getElementById('filter-group');
                var kamarGrid = document.getElementById('kamar-grid');
                var noResult = document.getElementById('no-result');

                if (filterGroup && kamarGrid) {
                    var cards = kamarGrid.querySelectorAll('.kamar-card');

                    filterGroup.addEventListener('click', function (e) {
                        var btn = e.target.closest('.filter-btn');
                        if (!btn) return;

                        filterGroup.querySelectorAll('.filter-btn').forEach(function (b) {
                            b.setAttribute('data-active', 'false');
                        });
                        btn.setAttribute('data-active', 'true');

                        var filter = btn.getAttribute('data-filter');
                        var visibleCount = 0;

                        cards.forEach(function (card) {
                            var match = filter === 'semua' || card.getAttribute('data-status') === filter;
                            card.style.display = match ? '' : 'none';
                            if (match) visibleCount++;
                        });

                        if (noResult) noResult.classList.toggle('hidden', visibleCount !== 0);
                    });
                }
            })();
        </script>
    </body>
</html>
