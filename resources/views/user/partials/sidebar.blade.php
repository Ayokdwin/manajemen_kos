<aside class="w-full border-b border-slate-200 bg-white lg:fixed lg:inset-y-0 lg:left-0 lg:z-30 lg:w-80 lg:border-b-0 lg:border-r">
    <div class="flex h-full flex-col px-5 py-6">
        <div class="flex items-center gap-3 px-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-100">
                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 10.5 12 3l9 7.5"></path>
                    <path d="M5 9.5V21h14V9.5"></path>
                    <path d="M9 21v-7h6v7"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-blue-600"></p>
                <p class="text-lg font-bold text-slate-900">Manajemen Kos</p>
            </div>
        </div>

        <nav class="mt-8 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-2xl bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-700">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 10.5 12 3l9 7.5"></path>
                        <path d="M5 9.5V21h14V9.5"></path>
                    </svg>
                </span>
                Dashboard
            </a>

           

            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-medium text-slate-600 transition hover:bg-rose-50 hover:text-rose-600">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-50 text-rose-500">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M10 17l5-5-5-5"></path>
                            <path d="M15 12H3"></path>
                            <path d="M21 3v18"></path>
                        </svg>
                    </span>
                    Keluar
                </button>
            </form>
        </nav>

        <div class="mt-auto rounded-[1.75rem] bg-slate-50 p-4">
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-sm font-bold text-white ring-2 ring-white">
                    A
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-slate-900">{{ $tenantName ?? 'Andi' }}</p>
                    <p class="text-xs text-slate-500">Penyewa</p>
                </div>
            </div>
        </div>
    </div>
</aside>
