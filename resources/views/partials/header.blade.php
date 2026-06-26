@php
    if (!isset($title) || !$title) {
        $routeName = request()->route()?->getName() ?? '';
        $segment   = explode('.', $routeName)[0] ?? 'Home';
        $title     = ucfirst($segment);
    }
@endphp

<header
    x-data="{
        dark: localStorage.getItem('theme')
            ? localStorage.getItem('theme') === 'dark'
            : window.matchMedia('(prefers-color-scheme: dark)').matches,
        toggleTheme() {
            this.dark = !this.dark;
            localStorage.setItem('theme', this.dark ? 'dark' : 'light');
        }
    }"
    x-init="document.documentElement.classList.toggle('dark', dark)"
    x-effect="document.documentElement.classList.toggle('dark', dark)"
    class="h-16 flex items-center justify-between gap-4 px-4 md:px-6
           bg-white dark:bg-slate-900
           border-b border-slate-200 dark:border-slate-800"
>
    {{-- Left: collapse hint + breadcrumb --}}
    <div class="flex items-center gap-3 min-w-0">
        <button type="button"
                class="hidden md:flex items-center justify-center w-8 h-8 rounded-lg text-slate-400
                       hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800
                       transition-colors shrink-0">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
        </button>

        <nav class="flex items-center gap-1.5 text-sm min-w-0 truncate">
            <a href="#" class="text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
                {{ auth()->user()->name }}
            </a>
            <svg class="w-3.5 h-3.5 text-slate-300 dark:text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="font-semibold text-slate-900 dark:text-slate-100 truncate">{{ $title }}</span>
        </nav>
    </div>

    {{-- Right: search, theme toggle, avatar --}}
    <div class="flex items-center gap-3 shrink-0">
        <div class="hidden sm:block relative">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
            <input
                type="text"
                placeholder="Search..."
                class="w-44 lg:w-64 pl-9 pr-3 py-2 rounded-lg text-sm
                       bg-slate-100 dark:bg-slate-800
                       border border-transparent focus:border-indigo-400 dark:focus:border-indigo-500
                       focus:bg-white dark:focus:bg-slate-900
                       text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                       outline-none ring-0 focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/20
                       transition-colors"
            />
        </div>

        {{-- Theme toggle --}}
        <button
            type="button"
            @click="toggleTheme()"
            class="w-9 h-9 flex items-center justify-center rounded-lg
                   text-slate-500 dark:text-slate-300
                   hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
        >
            <svg x-show="!dark" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.4 6.4l-.7-.7M6.3 6.3l-.7-.7m12.8 0l-.7.7M6.3 17.7l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z" />
            </svg>
            <svg x-show="dark" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.8A9 9 0 0111.2 3 7 7 0 1021 12.8z" />
            </svg>
        </button>

        {{-- Notification --}}
        <button type="button"
                class="relative w-9 h-9 flex items-center justify-center rounded-lg
                       text-slate-500 dark:text-slate-300
                       hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0" />
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500"></span>
        </button>

        {{-- User avatar --}}
        <button type="button" class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500
                                      flex items-center justify-center text-white text-sm font-semibold
                                      ring-2 ring-transparent hover:ring-indigo-200 dark:hover:ring-indigo-500/30
                                      transition-shadow">
            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
        </button>
    </div>
</header>
