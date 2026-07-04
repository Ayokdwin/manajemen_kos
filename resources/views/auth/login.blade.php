<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Kos Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        [x-cloak] { display: none !important; }
        .floating-label {
            transition: all 0.15s ease;
        }
    </style>
</head>
<body class="h-full bg-slate-50 dark:bg-slate-950 antialiased">

<div class="min-h-full flex"
     x-data="{
        dark: localStorage.getItem('theme') === 'dark'
            || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
        showPassword: false,
        emailFocus: false,
        passwordFocus: false,
        email: '{{ old('email') }}',
        password: '',
        loading: false,
     }"
     x-init="document.documentElement.classList.toggle('dark', dark)"
     x-effect="document.documentElement.classList.toggle('dark', dark)"
>
        {{-- PANEL KIRI: ILUSTRASI + FOTO --}}
        <div class="hidden lg:flex lg:w-[55%] relative flex-col justify-between p-10 overflow-hidden">

            {{-- Background foto --}}
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=900&auto=format&fit=crop&q=80"
                    alt="Background kos"
                    class="w-full h-full object-cover">
                {{-- Overlay gradien gelap supaya teks tetap terbaca --}}
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900/80 via-violet-950/70 to-slate-900/90"></div>
            </div>

            {{-- Konten atas: logo + tagline --}}
            <div class="relative z-10">
                <div class="flex items-center gap-2.5 mb-12">
                    <div class="w-9 h-9 rounded-lg bg-violet-600/20 border border-violet-600/30
                                backdrop-blur-sm flex items-center justify-center">
                        <i class="fa-solid fa-building text-indigo-700 text-sm"></i>
                    </div>
                    <span class="font-semibold text-white text-sm tracking-wide">Kos Manager</span>
                </div>
            </div>

            {{-- Konten tengah: heading besar --}}
            <div class="relative z-10 flex-1 flex flex-col justify-center">
                <p class="text-violet-600 text-sm font-medium tracking-widest uppercase mb-4">
                    Mulai sekarang
                </p>
                <h1 class="text-5xl font-bold text-white leading-tight mb-4">
                    Kelola<br>Hunian Kos<br>
                    <span class="text-violet-600">Lebih Mudah</span>
                </h1>
                <p class="text-slate-300 text-sm leading-relaxed max-w-xs">
                    Kos Manager adalah aplikasi manajemen kos berbasis web yang memudahkan pemilik kos untuk mengelola hunian mereka dengan efisien dan efektif.
                </p>
            </div>

            {{-- Step cards di bawah --}}
            <div class="relative z-10 grid grid-cols-3 gap-3">
                @foreach ([
                    ['1', 'Masuk ke akun', 'fa-user-plus'],
                    ['2', 'Isi formulir pendaftaran', 'fa-file-signature'],
                    ['3', 'Nikmati hunian Anda', 'fa-house-chimney'],
                ] as [$num, $text, $icon])
                    <div class="rounded-xl bg-white/10 backdrop-blur-sm border border-white/15 p-4">
                        <div class="w-7 h-7 rounded-full bg-indigo-600 flex items-center justify-center
                                    text-white text-xs font-bold mb-3">
                            {{ $num }}
                        </div>
                        <i class="fa-solid {{ $icon }} text-slate-300 text-sm mb-2 block"></i>
                        <p class="text-white text-xs font-medium leading-snug">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>

    {{-- PANEL KANAN: FORM --}}
    <div class="flex-1 flex flex-col items-center justify-center px-6 py-12 lg:px-12">

        {{-- Dark mode toggle --}}
        <div class="absolute top-4 right-4">
            <button @click="dark = !dark; localStorage.setItem('theme', dark ? 'dark' : 'light')"
                    class="w-9 h-9 flex items-center justify-center rounded-lg
                           text-slate-400 hover:text-slate-600 dark:hover:text-slate-200
                           hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <i class="fa-solid text-sm" :class="dark ? 'fa-sun' : 'fa-moon'"></i>
            </button>
        </div>

        <div class="w-full max-w-sm">

            {{-- Header mobile --}}
            <div class="text-center mb-8">
                <div class="w-12 h-12 mx-auto rounded-xl bg-gradient-to-br from-indigo-500 to-violet-500
                            flex items-center justify-center mb-4 lg:hidden">
                    <i class="fa-solid fa-building text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Masuk ke akun</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Selamat datang kembali di Kos Manager
                </p>
            </div>

            {{-- Error / session --}}
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-emerald-200 dark:border-emerald-500/30
                            bg-emerald-50 dark:bg-emerald-500/10 p-3.5 flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                    <p class="text-sm text-emerald-700 dark:text-emerald-400">{{ session('status') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-rose-200 dark:border-rose-500/30
                            bg-rose-50 dark:bg-rose-500/10 p-3.5 flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-sm mt-0.5"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-rose-700 dark:text-rose-400">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4"
                  @submit="loading = true">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                        Email
                    </label>
                    <div class="relative" @focusin="emailFocus = true" @focusout="emailFocus = false">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 transition-colors"
                             :class="emailFocus ? 'text-indigo-500' : 'text-slate-400'">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            x-model="email"
                            autocomplete="email"
                            placeholder="nama@email.com"
                            required
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg text-sm
                                   bg-slate-50 dark:bg-slate-800
                                   border border-slate-200 dark:border-slate-700
                                   text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                   focus:border-indigo-400 dark:focus:border-indigo-500
                                   focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                   outline-none transition-all
                                   @error('email') border-rose-300 dark:border-rose-500/50 @enderror"
                        >
                        {{-- Checkmark kalau email terisi --}}
                        <div x-show="email.includes('@') && email.includes('.')"
                             class="absolute right-3.5 top-1/2 -translate-y-1/2 text-emerald-500">
                            <i class="fa-solid fa-circle-check text-sm"></i>
                        </div>
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-200">
                            Password
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <div class="relative" @focusin="passwordFocus = true" @focusout="passwordFocus = false">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 transition-colors"
                             :class="passwordFocus ? 'text-indigo-500' : 'text-slate-400'">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            id="password"
                            name="password"
                            x-model="password"
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                            required
                            class="w-full pl-10 pr-10 py-2.5 rounded-lg text-sm
                                   bg-slate-50 dark:bg-slate-800
                                   border border-slate-200 dark:border-slate-700
                                   text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                   focus:border-indigo-400 dark:focus:border-indigo-500
                                   focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                   outline-none transition-all
                                   @error('password') border-rose-300 dark:border-rose-500/50 @enderror"
                        >
                        <button type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2
                                       text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                            <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" id="remember" name="remember"
                           class="w-4 h-4 rounded border-slate-300 dark:border-slate-600
                                  text-indigo-600 focus:ring-indigo-500 focus:ring-offset-0
                                  bg-slate-50 dark:bg-slate-800 cursor-pointer">
                    <label for="remember" class="text-sm text-slate-600 dark:text-slate-300 cursor-pointer">
                        Ingat saya
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        :disabled="loading || !email || !password"
                        class="w-full py-2.5 rounded-lg text-sm font-semibold text-white
                               bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800
                               disabled:opacity-50 disabled:cursor-not-allowed
                               transition-all flex items-center justify-center gap-2">
                    <template x-if="loading">
                        <i class="fa-solid fa-circle-notch fa-spin text-sm"></i>
                    </template>
                    <span x-text="loading ? 'Masuk...' : 'Masuk'"></span>
                </button>
            </form>

            {{-- Register link --}}
            <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
                Belum punya akun?
                <a href="{{ route('register') }}"
                   class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline ml-1">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
