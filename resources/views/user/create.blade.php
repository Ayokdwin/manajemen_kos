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

                <div class="max-w-7xl mx-auto">
                    <div class="mb-6">
                        <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Tambah Penyewa</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            Buat akun baru untuk penyewa. Penyewa dapat login menggunakan email dan password ini.
                        </p>
                    </div>

                    {{-- Error summary --}}
                    @if ($errors->any())
                        <div
                            class="mb-6 rounded-lg border border-rose-200 dark:border-rose-500/30
                                    bg-rose-50 dark:bg-rose-500/10 p-4">
                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-medium text-rose-700 dark:text-rose-400">
                                        Periksa kembali data yang Anda masukkan
                                    </p>
                                    <ul
                                        class="mt-1.5 text-sm text-rose-600 dark:text-rose-400 list-disc list-inside space-y-0.5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('user.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div
                            class="rounded-2xl border border-slate-200 dark:border-slate-800
                                    bg-white dark:bg-slate-900 p-6 space-y-5">

                            {{-- Nama --}}
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                    Nama Lengkap
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Contoh: Budi Santoso"
                                    class="w-full px-3.5 py-2.5 rounded-lg text-sm
                                           bg-slate-50 dark:bg-slate-800
                                           border border-slate-200 dark:border-slate-700
                                           text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                           focus:border-indigo-400 dark:focus:border-indigo-500
                                           focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                           outline-none transition-colors
                                           @error('name') border-rose-300 dark:border-rose-500/50 @enderror">
                                @error('name')
                                    <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email & No HP --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                        Email
                                    </label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        placeholder="budi@email.com"
                                        class="w-full px-3.5 py-2.5 rounded-lg text-sm
                                               bg-slate-50 dark:bg-slate-800
                                               border border-slate-200 dark:border-slate-700
                                               text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                               focus:border-indigo-400 dark:focus:border-indigo-500
                                               focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                               outline-none transition-colors
                                               @error('email') border-rose-300 dark:border-rose-500/50 @enderror">
                                    @error('email')
                                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_hp"
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                        Nomor HP
                                    </label>
                                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                                        placeholder="08123456789"
                                        class="w-full px-3.5 py-2.5 rounded-lg text-sm
                                               bg-slate-50 dark:bg-slate-800
                                               border border-slate-200 dark:border-slate-700
                                               text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                               focus:border-indigo-400 dark:focus:border-indigo-500
                                               focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                               outline-none transition-colors
                                               @error('no_hp') border-rose-300 dark:border-rose-500/50 @enderror">
                                    @error('no_hp')
                                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password & Konfirmasi --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="password"
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                        Password
                                    </label>
                                    <div class="relative" x-data="{ show: false }">
                                        <input :type="show ? 'text' : 'password'" id="password" name="password"
                                            placeholder="Minimal 8 karakter"
                                            class="w-full px-3.5 py-2.5 pr-10 rounded-lg text-sm
                                                   bg-slate-50 dark:bg-slate-800
                                                   border border-slate-200 dark:border-slate-700
                                                   text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                                   focus:border-indigo-400 dark:focus:border-indigo-500
                                                   focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                                   outline-none transition-colors
                                                   @error('password') border-rose-300 dark:border-rose-500/50 @enderror">
                                        <button type="button" @click="show = !show"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1.5">
                                        Konfirmasi Password
                                    </label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        placeholder="Ulangi password"
                                        class="w-full px-3.5 py-2.5 rounded-lg text-sm
                                               bg-slate-50 dark:bg-slate-800
                                               border border-slate-200 dark:border-slate-700
                                               text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                               focus:border-indigo-400 dark:focus:border-indigo-500
                                               focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                               outline-none transition-colors">
                                </div>
                            </div>

                            <p class="text-xs text-slate-400 dark:text-slate-500 -mt-1">
                                <i class="fa-solid fa-circle-info mr-1"></i>
                                Penyewa dapat menggunakan email dan password ini untuk login ke sistem.
                            </p>
                        </div>

                        {{-- Aksi --}}
                        <div class="flex items-center gap-3">
                            <button type="submit"
                                class="px-6 py-2.5 rounded-lg text-sm font-medium text-white
                                           bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                Simpan Penyewa
                            </button>
                            <a href="{{ route('user.index') }}"
                                class="px-6 py-2.5 rounded-lg text-sm font-medium
                                      text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800
                                      hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
@endsection
