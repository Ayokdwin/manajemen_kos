@extends('layouts.admin')

@section('content')
    <div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-y-auto p-6">
                {{-- Flash message --}}
                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-emerald-200 dark:border-emerald-500/30
                                bg-emerald-50 dark:bg-emerald-500/10 p-4 flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        <p class="text-sm font-medium text-emerald-700 dark:text-emerald-400">
                            {{ session('success') }}
                        </p>
                    </div>
                @endif

                {{-- Page header --}}
                <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Penyewa</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            Kelola data seluruh penyewa yang terdaftar di sistem.
                        </p>
                    </div>

                    <a href="{{ route('user.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium text-white
                              bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        <i class="fa-solid fa-plus text-xs"></i>
                        Tambah Penyewa
                    </a>
                </div>

                {{-- Search & filter --}}
                <form method="GET" action="{{ route('user.index') }}"
                      class="flex flex-wrap items-center gap-3 mb-5">
                    <div class="relative flex-1 min-w-[220px] max-w-sm">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama, email, atau no. HP..."
                            class="w-full pl-9 pr-3.5 py-2.5 rounded-lg text-sm
                                   bg-white dark:bg-slate-900
                                   border border-slate-200 dark:border-slate-800
                                   text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                   focus:border-indigo-400 dark:focus:border-indigo-500
                                   focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                                   outline-none transition-colors"
                        >
                    </div>

                    <button type="submit"
                            class="px-4 py-2.5 rounded-lg text-sm font-medium
                                   text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-900
                                   border border-slate-200 dark:border-slate-800
                                   hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        Cari
                    </button>

                    @if (request('search'))
                        <a href="{{ route('user.index') }}"
                           class="text-sm text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 transition-colors">
                            Reset
                        </a>
                    @endif
                </form>

                {{-- Table --}}
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800
                            bg-white dark:bg-slate-900 overflow-hidden">

                    @if ($user->isEmpty())
                        <div class="flex flex-col items-center justify-center text-center py-20">
                            <div class="w-14 h-14 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                                <i class="fa-solid fa-user-group text-slate-400 text-xl"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                @if (request('search'))
                                    Tidak ada penyewa yang cocok dengan pencarian "{{ request('search') }}"
                                @else
                                    Belum ada data penyewa
                                @endif
                            </p>
                            <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">
                                Klik "Tambah Penyewa" untuk menambahkan data baru.
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                                        <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Nama</th>
                                        <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Kontak</th>
                                        <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Kamar</th>
                                        <th class="text-left font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Status</th>
                                        <th class="text-right font-medium text-slate-500 dark:text-slate-400 px-5 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @foreach ($user as $item)
                                        @php $kontrakAktif = $item->kontrak->first(); @endphp
                                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                            {{-- Nama --}}
                                            <td class="px-5 py-3.5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500
                                                                text-white flex items-center justify-center font-semibold text-xs shrink-0">
                                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="font-medium text-slate-900 dark:text-slate-100 truncate">
                                                            {{ $item->name }}
                                                        </p>
                                                        <p class="text-xs text-slate-400 dark:text-slate-500">
                                                            Bergabung {{ $item->created_at->format('d M Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Kontak --}}
                                            <td class="px-5 py-3.5">
                                                <p class="text-slate-700 dark:text-slate-200">{{ $item->email }}</p>
                                                <p class="text-xs text-slate-400 dark:text-slate-500">{{ $item->no_hp }}</p>
                                            </td>

                                            {{-- Kamar --}}
                                            <td class="px-5 py-3.5">
                                                @if ($kontrakAktif)
                                                    <span class="text-slate-700 dark:text-slate-200">
                                                        Kamar {{ $kontrakAktif->kamar->nomor_kamar }}
                                                    </span>
                                                @else
                                                    <span class="text-slate-400 dark:text-slate-500">—</span>
                                                @endif
                                            </td>

                                            {{-- Status --}}
                                            <td class="px-5 py-3.5">
                                                @if ($kontrakAktif)
                                                    <span class="inline-flex items-center text-xs font-medium px-2 py-1 rounded-md
                                                                 bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                                        Menyewa
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center text-xs font-medium px-2 py-1 rounded-md
                                                                 bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                                        Tidak Aktif
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- Aksi --}}
                                            <td class="px-5 py-3.5 text-right">
                                                <div class="inline-flex items-center gap-1.5">
                                                    <a href="{{ route('user.show', $item->id) }}"
                                                       class="w-8 h-8 inline-flex items-center justify-center rounded-lg
                                                              text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400
                                                              hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-colors">
                                                        <i class="fa-solid fa-eye text-sm"></i>
                                                    </a>

                                                    <a href="{{ route('user.edit', $item->id) }}"
                                                       class="w-8 h-8 inline-flex items-center justify-center rounded-lg
                                                              text-slate-400 hover:text-amber-600 dark:hover:text-amber-400
                                                              hover:bg-amber-50 dark:hover:bg-amber-500/10 transition-colors">
                                                        <i class="fa-solid fa-pen text-sm"></i>
                                                    </a>

                                                    <form method="POST" action="{{ route('user.destroy', $item->id) }}"
                                                          onsubmit="return confirm('Hapus data penyewa {{ $item->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg
                                                                       text-slate-400 hover:text-rose-600 dark:hover:text-rose-400
                                                                       hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors">
                                                            <i class="fa-solid fa-trash text-sm"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-800">
                            {{ $user->links() }}
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
@endsection
