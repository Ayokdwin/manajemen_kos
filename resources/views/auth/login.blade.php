<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Manajemen Kos') }} - Login</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: "Instrument Sans", ui-sans-serif, system-ui, sans-serif;
            }
        </style>
    </head>
    <body class="min-h-screen bg-[#EEF4FB] text-slate-900">
        @php
            $featureHighlights = [
                [
                    'title' => 'Aman',
                    'text'  => 'Data terjaga dengan aman',
                    'color' => 'bg-blue-600',
                    'icon'  => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4" stroke="white"/>',
                ],
                [
                    'title' => 'Efisien',
                    'text'  => 'Hemat waktu, kelola lebih cepat',
                    'color' => 'bg-blue-600',
                    'icon'  => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14" stroke="white"/>',
                ],
                [
                    'title' => 'Terorganisir',
                    'text'  => 'Semua data dalam satu tempat',
                    'color' => 'bg-blue-600',
                    'icon'  => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14" stroke="white"/>',
                ],
            ];

            $authImage = base64_encode(file_get_contents(resource_path('views/auth/img/image.png')));
        @endphp

        <div class="mx-auto grid min-h-screen max-w-7xl grid-cols-1 gap-0 px-4 py-6 sm:px-6 lg:grid-cols-2 lg:gap-8 lg:px-8 lg:py-8">

            {{-- LEFT SECTION --}}
            <section class="flex flex-col rounded-3xl bg-[#EAF2FB] p-6 lg:p-8">

                {{-- Logo --}}
                <a href="{{ route('index') }}" class="inline-flex items-center gap-2 self-start">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 10.5 12 3l9 7.5"/>
                            <path d="M5 9.5V21h14V9.5"/>
                            <path d="M9 21v-7h6v7"/>
                        </svg>
                    </div>
                    <span class="text-base font-bold text-slate-800">Manajemen Kos</span>
                </a>

                {{-- Headline --}}
                <div class="mt-8">
                    <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-slate-900 sm:text-5xl">
                        Kelola kos dengan<br>
                        <span class="text-blue-600">mudah dan efisien</span>
                    </h1>
                    <p class="mt-4 max-w-md text-sm leading-7 text-slate-500">
                        Solusi lengkap untuk pengelolaan kamar, penghuni, pembayaran, dan laporan dalam satu sistem.
                    </p>
                </div>

                {{-- Illustration --}}
                <div class="mt-6 flex-1 overflow-hidden rounded-3xl bg-[#D6E9F8]">
                    <img
                        src="data:image/png;base64,{{ $authImage }}"
                        alt="Ilustrasi gedung kos modern"
                        class="h-full w-full object-cover object-center"
                        style="min-height: 280px; max-height: 420px;"
                    >
                </div>

                {{-- Feature Cards --}}
                <div class="mt-5 grid grid-cols-3 gap-3">
                    @foreach ($featureHighlights as $feature)
                        <div class="rounded-2xl bg-white px-4 py-4 shadow-sm">
                            <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl {{ $feature['color'] }}">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    {!! $feature['icon'] !!}
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-slate-900">{{ $feature['title'] }}</p>
                            <p class="mt-1 text-xs leading-5 text-slate-500">{{ $feature['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- RIGHT SECTION --}}
            <section class="flex items-center justify-center py-8 lg:py-0">
                <div class="w-full max-w-md rounded-3xl border border-slate-100 bg-white p-8 shadow-lg">

                    {{-- Lock Icon --}}
                    <div class="mb-6 flex justify-center">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50">
                            <svg viewBox="0 0 24 24" class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="9" rx="2"/>
                                <path d="M7 11V8a5 5 0 0 1 10 0v3"/>
                            </svg>
                        </div>
                    </div>

                    <div class="mb-7 text-center">
                        <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">Selamat Datang Kembali!</h2>
                        <p class="mt-2 text-sm text-slate-500">Silakan masuk untuk melanjutkan</p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        {{-- Email / Username --}}
                        <div>
                            <label for="login" class="mb-1.5 block text-sm font-semibold text-slate-700">Email atau Username</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21a8 8 0 1 0-16 0"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                </span>
                                <input
                                    id="login"
                                    name="login"
                                    type="text"
                                    value="{{ old('login') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="Masukkan email atau username"
                                    class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 shadow-sm outline-none placeholder:text-slate-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                                >
                            </div>
                            <x-input-error :messages="$errors->get('login')" class="mt-1.5" />
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Password</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="9" rx="2"/>
                                        <path d="M7 11V8a5 5 0 0 1 10 0v3"/>
                                    </svg>
                                </span>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Masukkan password"
                                    class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-12 text-sm text-slate-900 shadow-sm outline-none placeholder:text-slate-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                                >
                                <button
                                    id="toggle-password"
                                    type="button"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 transition hover:text-slate-600"
                                    aria-label="Tampilkan password"
                                >
                                    <svg id="eye-open" viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg id="eye-closed" viewBox="0 0 24 24" class="hidden h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 3l18 18"/>
                                        <path d="M10.6 10.6A3 3 0 0 0 12 15a3 3 0 0 0 2.4-1.2"/>
                                        <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a18.4 18.4 0 0 1-3.2 4.4"/>
                                        <path d="M6.1 6.1C3.6 8.1 2 12 2 12s3.5 7 10 7a11 11 0 0 0 4.8-1.1"/>
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    name="remember"
                                    class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-400"
                                    checked
                                >
                                Ingat saya
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="w-full rounded-xl bg-blue-600 py-3.5 text-sm font-bold text-white shadow-md shadow-blue-100 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200"
                        >
                            Masuk
                        </button>

                        {{-- Divider --}}
                        <div class="relative py-1">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-slate-200"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="bg-white px-4 text-xs text-slate-400">atau masuk dengan</span>
                            </div>
                        </div>

                        {{-- Social Buttons --}}
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                <svg viewBox="0 0 24 24" class="h-5 w-5">
                                    <path fill="#EA4335" d="M21.35 11.1h-9.18v2.98h5.27c-.23 1.43-1.69 4.19-5.27 4.19-3.18 0-5.77-2.64-5.77-5.9s2.59-5.9 5.77-5.9c1.81 0 3.02.77 3.72 1.44l2.54-2.45C16.81 4.9 14.79 4 12.17 4 6.92 4 2.65 8.24 2.65 13.47S6.92 22.94 12.17 22.94c5.49 0 9.1-3.86 9.1-9.32 0-.63-.07-1.11-.17-1.52z"/>
                                </svg>
                                Google
                            </button>
                            <button type="button" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="#1877F2">
                                    <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073c0 6.02 4.388 11.013 10.125 11.927v-8.437H7.078v-3.49h3.047V9.414c0-3.026 1.791-4.698 4.533-4.698 1.313 0 2.686.235 2.686.235v2.953h-1.513c-1.49 0-1.953.932-1.953 1.888v2.271h3.328l-.532 3.49h-2.796V24C19.612 23.086 24 18.092 24 12.073z"/>
                                </svg>
                                Facebook
                            </button>
                        </div>

                        {{-- Register link --}}
                        <p class="pt-1 text-center text-sm text-slate-500">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700">Daftar sekarang</a>
                        </p>
                    </form>
                </div>
            </section>
        </div>

        <script>
            const toggleButton = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (toggleButton && passwordInput && eyeOpen && eyeClosed) {
                toggleButton.addEventListener('click', () => {
                    const isHidden = passwordInput.type === 'password';
                    passwordInput.type = isHidden ? 'text' : 'password';
                    eyeOpen.classList.toggle('hidden', !isHidden);
                    eyeClosed.classList.toggle('hidden', isHidden);
                    toggleButton.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
                });
            }
        </script>
    </body>
</html>