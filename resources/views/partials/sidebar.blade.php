@php
    $currentUser = auth()->user();
    $isActive = fn (string $pattern) => request()->routeIs($pattern);
    $activeClasses   = 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400 font-medium';
    $inactiveClasses = 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800';
@endphp

<div
    x-data="{
        collapsed: localStorage.getItem('sidebarCollapsed') === 'true',

        openGroups: (() => {
            try {
                return JSON.parse(localStorage.getItem('sidebarGroups')) || {
                    projects: true,
                    team: false,
                    customers: false
                };
            } catch (e) {
                return { projects: true, team: false, customers: false };
            }
        })(),

        toggleCollapse() {
            this.collapsed = !this.collapsed;
            localStorage.setItem('sidebarCollapsed', this.collapsed);
        },

        toggleGroup(key) {
            if (this.collapsed) return;
            this.openGroups[key] = !this.openGroups[key];
            localStorage.setItem('sidebarGroups', JSON.stringify(this.openGroups));
        }
    }"
    :class="collapsed ? 'w-[72px]' : 'w-[260px]'"
    class="h-screen flex flex-col shrink-0 border-r border-slate-200 dark:border-slate-800
           bg-white dark:bg-slate-900
           transition-[width] duration-200 ease-in-out relative"
>
    {{-- Org / user switcher --}}
    <div class="flex items-center gap-3 px-3 h-16 border-b border-slate-200 dark:border-slate-800">
        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-500 to-violet-500 text-white
                    flex items-center justify-center font-semibold text-sm shrink-0">
            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
        </div>
        <div x-show="!collapsed" x-transition.opacity.duration.150ms class="flex-1 min-w-0 overflow-hidden">
            <span class="flex flex-col items-start min-w-0">
                <span class="text-sm font-semibold text-slate-900 dark:text-slate-100 truncate">
                    {{ auth()->user()->name }}
                </span>
                <span class="text-xs text-indigo-600 dark:text-indigo-400 font-medium capitalize">
                    {{ auth()->user()->role }}
                </span>
            </span>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-6">

        {{-- Quick actions --}}
        <div class="space-y-1">
            <a href="#" :class="collapsed && 'justify-center'"
               class="flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm transition-colors {{ $inactiveClasses }}">
                <i class="fa-solid fa-magnifying-glass w-[18px] text-center shrink-0"></i>
                <span x-show="!collapsed" x-transition.opacity.duration.150ms>Search</span>
            </a>

            <a href="{{ route('dashboard') }}" :class="collapsed && 'justify-center'"
               class="flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm transition-colors
                      {{ $isActive('dashboard') ? $activeClasses : $inactiveClasses }}">
                <i class="fa-solid fa-house w-[18px] text-center shrink-0"></i>
                <span x-show="!collapsed" x-transition.opacity.duration.150ms>Dashboard</span>
            </a>
        </div>

        {{-- Manajemen group --}}
        <div>
            <p x-show="!collapsed" x-transition.opacity.duration.150ms
               class="px-2.5 text-[11px] font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase mb-1">
                Manajemen
            </p>

            <div class="space-y-1">
                <a href="{{ route('kamar.index') }}" :class="collapsed && 'justify-center'"
                   class="flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm transition-colors
                          {{ $isActive('kamar.*') ? $activeClasses : $inactiveClasses }}">
                    <i class="fa-solid fa-door-closed w-[18px] text-center shrink-0"></i>
                    <span x-show="!collapsed" x-transition.opacity.duration.150ms>Kamar</span>
                </a>

                @if (auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('user.index') }}" :class="collapsed && 'justify-center'"
                   class="flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm transition-colors
                          {{ $isActive('user.*') ? $activeClasses : $inactiveClasses }}">
                    <i class="fa-solid fa-user-group w-[18px] text-center shrink-0"></i>
                    <span x-show="!collapsed" x-transition.opacity.duration.150ms>Penyewa</span>
                </a>
                @endif

                {{-- Kontrak --}}
                 @php
                    $kontrakwaiting = \App\Models\Kontrak::whereIn('approval_status', ['pending', 'rejected'])
                        ->when($currentUser->role !== 'admin', fn ($query) => $query->where('user_id', $currentUser->id))
                        ->count();
                @endphp
                 <a href="{{ route('kontrak.index') }}" :class="collapsed && 'justify-center'"
        class="relative flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm transition-colors
                {{ $isActive('kontrak.*') ? $activeClasses : $inactiveClasses }}">

            <span class="relative shrink-0">
                <i class="fa-solid fa-file-signature w-[18px] text-center shrink-0"></i>

                @if($kontrakwaiting > 0)
                    <span class="absolute -top-1.5 -right-2 min-w-[16px] h-4 px-[3px] flex items-center justify-center
                                 rounded-full bg-rose-500 text-white text-[10px] leading-none font-semibold">
                        {{ $kontrakwaiting > 99 ? '99+' : $kontrakwaiting }}
                    </span>
                @endif
            </span>
            <span x-show="!collapsed" x-transition.opacity.duration.150ms>
                Kontrak
            </span>
        </a>

                {{-- Pengaduan --}}
                @php
                    $pengaduanwaiting = \App\Models\Pengaduan::whereIn('status', ['pending', 'diproses'])->count();
                @endphp
                 <a href="{{ route('pengaduan.index') }}" :class="collapsed && 'justify-center'"
        class="relative flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm transition-colors
                {{ $isActive('pengaduan.*') ? $activeClasses : $inactiveClasses }}">

            <span class="relative shrink-0">
                <i class="fa-solid fa-triangle-exclamation w-[18px] text-center"></i>

                @if(auth()->user()->role === 'admin' && $pengaduanwaiting > 0 )
                    <span class="absolute -top-1.5 -right-2 min-w-[16px] h-4 px-[3px] flex items-center justify-center
                                 rounded-full bg-rose-500 text-white text-[10px] leading-none font-semibold">
                        {{ $pengaduanwaiting > 99 ? '99+' : $pengaduanwaiting }}
                    </span>
                @endif
            </span>
            <span x-show="!collapsed" x-transition.opacity.duration.150ms>
                Pengaduan
            </span>
        </a>

            </div>
        </div>

        {{-- Keuangan group --}}
        <div>
            <p x-show="!collapsed" x-transition.opacity.duration.150ms
               class="px-2.5 text-[11px] font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase mb-1">
                Keuangan
            </p>

            <div class="space-y-1">

                {{-- Pembayaran --}}
                @php
                    $statustagihan = \App\Models\Tagihan::whereHas('kontrak', function ($query) use ($currentUser) {
                            $query->where('user_id', $currentUser->id);
                        })
                        ->where(function ($query) {
                            $query->where('status', 'belum_bayar')
                                ->orWhereHas('pembayaran', function ($pembayaranQuery) {
                                    $pembayaranQuery->where('status_varifikasi', 'pending');
                                });
                        })
                        ->count();
                @endphp
        <a href="{{route('tagihan.index')}}" :class="collapsed && 'justify-center'"
        class="relative flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm transition-colors
                {{ $isActive('tagihan.*') ? $activeClasses : $inactiveClasses }}">
            <span class="relative shrink-0">
                <i class="fa-solid fa-file-invoice-dollar w-[18px] text-center shrink-0"></i>
                    @if($currentUser->role === 'user' && $statustagihan > 0)
                        <span class="absolute -top-1.5 -right-2 min-w-[16px] h-4 px-[3px] flex items-center justify-center
                                     rounded-full bg-rose-500 text-white text-[10px] leading-none font-semibold">
                            {{ $statustagihan > 99 ? '99+' : $statustagihan }}
                        </span>
                    @endif
            </span>
            <span x-show="!collapsed" x-transition.opacity.duration.150ms>
                Tagihan
            </span>
        </a>

                @php
                    $pending = \App\Models\Pembayaran::where('status_varifikasi', 'pending')
                        ->when($currentUser->role !== 'admin', function ($query) use ($currentUser) {
                            $query->whereHas('tagihan.kontrak', function ($kontrakQuery) use ($currentUser) {
                                $kontrakQuery->where('user_id', $currentUser->id);
                            });
                        })
                        ->count();
                @endphp

        <a href="{{ route('pembayaran.index') }}" :class="collapsed && 'justify-center'"
        class="relative flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm transition-colors
                {{ $isActive('pembayaran.*') ? $activeClasses : $inactiveClasses }}">

            <span class="relative shrink-0">
                <i class="fa-solid fa-money-check-dollar w-[18px] text-center"></i>

                    @if($pending > 0)
                        <span class="absolute -top-1.5 -right-2 min-w-[16px] h-4 px-[3px] flex items-center justify-center
                                     rounded-full bg-rose-500 text-white text-[10px] leading-none font-semibold">
                            {{ $pending > 99 ? '99+' : $pending }}
                        </span>
                    @endif


            </span>

            <span x-show="!collapsed" x-transition.opacity.duration.150ms>
                Pembayaran
            </span>
        </a>
            </div>
        </div>
    </nav>

    {{-- Footer --}}
    <div class="border-t border-slate-200 dark:border-slate-800 px-2 py-3 space-y-1">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                :class="collapsed && 'justify-center'"
                class="w-full flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm transition-colors {{ $inactiveClasses }}"
            >
                <i class="fa-solid fa-right-from-bracket w-[18px] text-center shrink-0"></i>
                <span x-show="!collapsed" x-transition.opacity.duration.150ms>Log out</span>
            </button>
        </form>
    </div>

    {{-- Collapse toggle button --}}
    <button
        type="button"
        @click="toggleCollapse()"
        class="absolute -right-3 top-[60px] w-6 h-6 rounded-full bg-white dark:bg-slate-800
               border border-slate-200 dark:border-slate-700 shadow-sm
               flex items-center justify-center text-slate-500 dark:text-slate-300
               hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-300 dark:hover:border-indigo-500
               transition-colors z-10"
    >
        <i :class="collapsed && 'rotate-180'" class="fa-solid fa-angles-left text-xs transition-transform duration-200"></i>
    </button>
</div>
