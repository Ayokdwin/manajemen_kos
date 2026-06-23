<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', ' Kos') }}</title>

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
    <body class="min-h-screen overflow-hidden bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,0.18),_transparent_34%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.16),_transparent_30%),linear-gradient(180deg,_#f8fbff_0%,_#edf6ff_100%)] text-slate-900">
        <main class="relative mx-auto flex min-h-screen w-full max-w-7xl items-center px-6 py-10 lg:px-10">
            <div class="pointer-events-none absolute left-[-5rem] top-[-4rem] h-80 w-80 rounded-full bg-sky-300/30 blur-3xl"></div>
            <div class="pointer-events-none absolute bottom-[-6rem] right-[-4rem] h-96 w-96 rounded-full bg-blue-200/40 blur-3xl"></div>

            <section class="relative grid w-full gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:gap-16">
                <div class="flex flex-col justify-center">
                    <div class="mb-8 inline-flex items-center gap-3 self-start rounded-full border border-blue-100 bg-white/80 px-4 py-2 shadow-sm backdrop-blur">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-200">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M3 10.5 12 3l9 7.5"></path>
                                <path d="M5 9.5V21h14V9.5"></path>
                                <path d="M9 21v-7h6v7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-blue-600">Sistem Kos</p>
                            <p class="text-base font-semibold text-slate-900"> Badar Kos </p>
                        </div>
                    </div>

                    <h1 class="max-w-xl text-4xl font-black tracking-tight text-slate-950 sm:text-5xl lg:text-6xl">
                        Selamat Datang! Kelola kos Anda lebih mudah
                    </h1>

                    <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                        Pusat pengelolaan kos yang membantu Anda mencatat kamar, memantau data penghuni, mengelola pembayaran, dan menyusun laporan dalam satu sistem yang rapi.
                    </p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-3xl border border-white/70 bg-white/85 p-5 shadow-[0_20px_60px_rgba(15,23,42,0.08)] backdrop-blur">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M3 21h18"></path>
                                    <path d="M5 21V7l7-4 7 4v14"></path>
                                    <path d="M9 21v-8h6v8"></path>
                                </svg>
                            </div>
                            <h2 class="text-base font-semibold text-slate-900">Kelola Kamar</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Mengatur data kamar dan fasilitas kos dengan lebih terstruktur.</p>
                        </div>

                        <div class="rounded-3xl border border-white/70 bg-white/85 p-5 shadow-[0_20px_60px_rgba(15,23,42,0.08)] backdrop-blur">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-50 text-sky-600">
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="8" r="3"></circle>
                                    <path d="M5 20c1.5-4 4-6 7-6s5.5 2 7 6"></path>
                                </svg>
                            </div>
                            <h2 class="text-base font-semibold text-slate-900">Kelola Penghuni</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Menyimpan data penghuni secara rapi dan mudah dipantau.</p>
                        </div>

                        <div class="rounded-3xl border border-white/70 bg-white/85 p-5 shadow-[0_20px_60px_rgba(15,23,42,0.08)] backdrop-blur">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M6 6h15"></path>
                                    <path d="M6 12h15"></path>
                                    <path d="M6 18h15"></path>
                                    <path d="M3 6h.01"></path>
                                    <path d="M3 12h.01"></path>
                                    <path d="M3 18h.01"></path>
                                </svg>
                            </div>
                            <h2 class="text-base font-semibold text-slate-900">Pembayaran & Laporan</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Mencatat transaksi dan melihat laporan dengan cepat.</p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-3 rounded-full bg-blue-600 px-7 py-4 text-base font-semibold text-white shadow-lg shadow-blue-200 transition duration-200 hover:-translate-y-0.5 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">
                            Mulai Sekarang
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>

                        <div class="text-sm text-slate-500">
                            Akses login untuk mulai mengelola data kos.
                        </div>
                    </div>
                </div>

                <div class="relative flex items-center justify-center lg:justify-end">
                    <div class="relative w-full max-w-[620px]">
                        <div class="absolute left-8 top-8 h-28 w-28 rounded-full bg-emerald-300/25 blur-2xl"></div>
                        <div class="absolute right-10 top-20 h-36 w-36 rounded-full bg-sky-400/20 blur-2xl"></div>

                        <div class="relative overflow-hidden rounded-[2rem] border border-white/70 bg-white/75 p-5 shadow-[0_30px_80px_rgba(15,23,42,0.14)] backdrop-blur-xl">
                            <div class="rounded-[1.7rem] bg-gradient-to-b from-sky-50 via-white to-emerald-50 p-5">
                                <div class="mb-4 flex items-center justify-between rounded-2xl border border-sky-100 bg-white/90 px-4 py-3 shadow-sm">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">KOS</p>
                                        <p class="text-sm font-semibold text-slate-900">Nyaman, Aman, Terpercaya</p>
                                    </div>
                                    <div class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">Tersedia 24 Kamar</div>
                                </div>

                                <div class="relative rounded-[1.6rem] bg-gradient-to-b from-[#dff0ff] to-[#f4fbff] p-4 shadow-inner">
                                    <svg viewBox="0 0 760 620" class="h-auto w-full" role="img" aria-labelledby="kos-illustration-title">
                                        <title id="kos-illustration-title">Ilustrasi gedung kos modern dua lantai</title>
                                        <defs>
                                            <linearGradient id="sky" x1="0" x2="0" y1="0" y2="1">
                                                <stop offset="0%" stop-color="#dff2ff" />
                                                <stop offset="100%" stop-color="#f9fdff" />
                                            </linearGradient>
                                            <linearGradient id="building" x1="0" x2="0" y1="0" y2="1">
                                                <stop offset="0%" stop-color="#f8fbff" />
                                                <stop offset="100%" stop-color="#dbeafe" />
                                            </linearGradient>
                                        </defs>

                                        <rect x="0" y="0" width="760" height="620" rx="28" fill="url(#sky)"></rect>
                                        <circle cx="620" cy="104" r="34" fill="#fde68a"></circle>
                                        <path d="M0 448h760v172H0z" fill="#e7f7ea"></path>
                                        <path d="M0 446h760v10H0z" fill="#c8e8cf"></path>

                                        <rect x="155" y="150" width="450" height="255" rx="22" fill="#ffffff" stroke="#cfe3f5" stroke-width="4"></rect>
                                        <rect x="195" y="115" width="370" height="50" rx="16" fill="#1d4ed8"></rect>
                                        <text x="380" y="148" text-anchor="middle" font-size="26" font-weight="700" fill="#ffffff" font-family="Instrument Sans, Arial, sans-serif">Nyaman, Aman, Terpercaya</text>

                                        <rect x="175" y="205" width="410" height="180" rx="18" fill="url(#building)" stroke="#bfd4ea" stroke-width="3"></rect>

                                        <line x1="175" y1="295" x2="585" y2="295" stroke="#b7cee3" stroke-width="4"></line>

                                        <g fill="#ffffff" stroke="#6ea3d4" stroke-width="3">
                                            <rect x="205" y="224" width="50" height="55" rx="8"></rect>
                                            <rect x="270" y="224" width="50" height="55" rx="8"></rect>
                                            <rect x="335" y="224" width="50" height="55" rx="8"></rect>
                                            <rect x="400" y="224" width="50" height="55" rx="8"></rect>
                                            <rect x="465" y="224" width="50" height="55" rx="8"></rect>
                                            <rect x="530" y="224" width="30" height="55" rx="8"></rect>
                                            <rect x="205" y="314" width="50" height="55" rx="8"></rect>
                                            <rect x="270" y="314" width="50" height="55" rx="8"></rect>
                                            <rect x="335" y="314" width="50" height="55" rx="8"></rect>
                                            <rect x="400" y="314" width="50" height="55" rx="8"></rect>
                                            <rect x="465" y="314" width="50" height="55" rx="8"></rect>
                                            <rect x="530" y="314" width="30" height="55" rx="8"></rect>
                                        </g>

                                        <g fill="#bfdbfe">
                                            <rect x="220" y="240" width="20" height="22" rx="4"></rect>
                                            <rect x="285" y="240" width="20" height="22" rx="4"></rect>
                                            <rect x="350" y="240" width="20" height="22" rx="4"></rect>
                                            <rect x="415" y="240" width="20" height="22" rx="4"></rect>
                                            <rect x="480" y="240" width="20" height="22" rx="4"></rect>
                                            <rect x="220" y="330" width="20" height="22" rx="4"></rect>
                                            <rect x="285" y="330" width="20" height="22" rx="4"></rect>
                                            <rect x="350" y="330" width="20" height="22" rx="4"></rect>
                                            <rect x="415" y="330" width="20" height="22" rx="4"></rect>
                                            <rect x="480" y="330" width="20" height="22" rx="4"></rect>
                                        </g>

                                        <rect x="592" y="250" width="20" height="150" rx="10" fill="#94a3b8"></rect>
                                        <path d="M592 262 642 300 592 338" fill="#dbeafe" stroke="#94a3b8" stroke-width="3"></path>

                                        <path d="M140 430h480v18H140z" fill="#c4d4e2"></path>
                                        <rect x="286" y="350" width="90" height="65" rx="10" fill="#f8fafc" stroke="#94a3b8" stroke-width="3"></rect>
                                        <rect x="300" y="362" width="62" height="53" rx="7" fill="#c9e3ff"></rect>
                                        <path d="M322 416v-20h18v20" fill="#93c5fd"></path>

                                        <g>
                                            <path d="M136 470c22-20 48-20 70 0" fill="none" stroke="#8ccf9a" stroke-width="10" stroke-linecap="round"></path>
                                            <rect x="144" y="445" width="16" height="50" rx="8" fill="#86efac"></rect>
                                            <circle cx="152" cy="438" r="22" fill="#4ade80"></circle>
                                        </g>
                                        <g>
                                            <path d="M592 470c22-20 48-20 70 0" fill="none" stroke="#8ccf9a" stroke-width="10" stroke-linecap="round"></path>
                                            <rect x="600" y="445" width="16" height="50" rx="8" fill="#86efac"></rect>
                                            <circle cx="608" cy="438" r="22" fill="#4ade80"></circle>
                                        </g>
                                        <g>
                                            <path d="M90 500c26-18 52-18 78 0" fill="none" stroke="#6b7280" stroke-width="5" stroke-linecap="round"></path>
                                            <path d="M80 520h110" fill="none" stroke="#cbd5e1" stroke-width="8" stroke-linecap="round"></path>
                                        </g>
                                    </svg>
                                </div>

                                <div class="mt-4 grid gap-3 sm:grid-cols-3">
                                    <div class="rounded-2xl bg-white px-4 py-3 text-center shadow-sm">
                                        <p class="text-lg font-bold text-slate-900">Rapi</p>
                                        <p class="text-xs text-slate-500">Data terorganisir</p>
                                    </div>
                                    <div class="rounded-2xl bg-white px-4 py-3 text-center shadow-sm">
                                        <p class="text-lg font-bold text-slate-900">Cepat</p>
                                        <p class="text-xs text-slate-500">Akses mudah</p>
                                    </div>
                                    <div class="rounded-2xl bg-white px-4 py-3 text-center shadow-sm">
                                        <p class="text-lg font-bold text-slate-900">Profesional</p>
                                        <p class="text-xs text-slate-500">Tampilan modern</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
