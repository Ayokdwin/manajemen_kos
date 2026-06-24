<header class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <div>
            <p class="text-sm font-medium text-slate-500">Dashboard Penyewa</p>
            <h1 class="text-2xl font-black tracking-tight text-slate-950 sm:text-3xl">
                Selamat Datang, {{ $tenantName ?? 'Andi' }}! <span aria-hidden="true">👋</span>
            </h1>
            <p class="mt-1 text-sm text-slate-600">Kelola informasi sewa Anda dengan mudah.</p>
        </div>

        <button type="button" class="relative flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:bg-slate-50">
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5"></path>
                <path d="M9 17a3 3 0 0 0 6 0"></path>
            </svg>
            <span class="absolute right-0 top-0 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-blue-600 px-1 text-[11px] font-bold text-white shadow">
                3
            </span>
        </button>
    </div>
</header>
