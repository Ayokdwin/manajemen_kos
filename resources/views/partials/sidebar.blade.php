<div
    x-data="{
        collapsed: localStorage.getItem('sidebarCollapsed') === 'true',

        openGroups: (() => {
            try {
                return JSON.parse(
                    localStorage.getItem('sidebarGroups')
                ) || {
                    projects: true,
                    team: false,
                    customers: false
                };
            } catch (e) {
                return {
                    projects: true,
                    team: false,
                    customers: false
                };
            }
        })(),

        toggleCollapse() {
            this.collapsed = !this.collapsed;
            localStorage.setItem('sidebarCollapsed', this.collapsed);
        },

        toggleGroup(key) {
            if (this.collapsed) return;

            this.openGroups[key] = !this.openGroups[key];

            localStorage.setItem(
                'sidebarGroups',
                JSON.stringify(this.openGroups)
            );
        }
    }"
    :class="collapsed ? 'w-[72px]' : 'w-[260px]'"
    class="h-screen flex flex-col shrink-0 border-r border-slate-200 dark:border-slate-800
           bg-white dark:bg-slate-900
           transition-[width] duration-200 ease-in-out relative">

    {{-- Org switcher --}}
    <div class="flex items-center gap-3 px-3 h-16 border-b border-slate-200 dark:border-slate-800">
        <div class="w-9 h-9 rounded-lg bg-indigo-600 text-white flex items-center justify-center
                    font-semibold text-sm shrink-0">
            A
        </div>
        <div x-show="!collapsed" x-transition.opacity.duration.150ms class="flex-1 min-w-0 overflow-hidden">
            <button type="button" class="w-full flex items-center justify-between gap-2 group">
                <span class="flex flex-col items-start min-w-0">
                    <span class="text-sm font-semibold text-slate-900 dark:text-slate-100 truncate">
                        {{ auth()->user()->name }}
                    </span>
                    <span class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">
                        {{ auth()->user()->role }}
                    </span>
                </span>
            </button>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-6">

        {{-- Quick actions --}}
        <div class="space-y-1">
            <a href="#" :class="collapsed && 'justify-center'"
               class="flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300
                      hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                </svg>
                <span x-show="!collapsed" x-transition.opacity.duration.150ms>Search</span>
            </a>

            <a href="#" :class="collapsed && 'justify-center'"
               class="flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm font-medium
                      bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400
                      transition-colors">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h6a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM16 16a2 2 0 012-2h0a2 2 0 012 2v2a2 2 0 01-2 2h0a2 2 0 01-2-2v-2z" />
                </svg>
                <span x-show="!collapsed" x-transition.opacity.duration.150ms>Home</span>
            </a>

            <a href="#" :class="collapsed && 'justify-center'"
               class="flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300
                      hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span x-show="!collapsed" x-transition.opacity.duration.150ms class="flex-1">Inbox</span>
                <span x-show="!collapsed" x-transition.opacity.duration.150ms
                      class="text-xs font-medium px-1.5 py-0.5 rounded-full bg-rose-500 text-white">
                    12
                </span>
            </a>

            <a href="#" :class="collapsed && 'justify-center'"
               class="flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300
                      hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h4l3 9 4-18 3 9h4" />
                </svg>
                <span x-show="!collapsed" x-transition.opacity.duration.150ms>Analytics</span>
            </a>
        </div>

        {{-- Workspace group --}}
        <div>
            <p x-show="!collapsed" x-transition.opacity.duration.150ms
               class="px-2.5 text-[11px] font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase mb-1">
                Workspace
            </p>

            <div class="space-y-1">
                {{-- Projects (expandable) --}}
                <div>
                    <button type="button" @click="toggleGroup('projects')" :class="collapsed && 'justify-center'"
                            class="w-full flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300
                                   hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                        </svg>
                        <span x-show="!collapsed" x-transition.opacity.duration.150ms class="flex-1 text-left">Projects</span>
                        <svg x-show="!collapsed" x-transition.opacity.duration.150ms
                             :class="openGroups.projects && 'rotate-90'"
                             class="w-3.5 h-3.5 text-slate-400 transition-transform duration-150"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <div x-show="!collapsed && openGroups.projects" x-transition class="mt-1 ml-[34px] space-y-0.5 border-l border-slate-200 dark:border-slate-800 pl-3">
                        <a href="#" class="block px-2 py-1.5 rounded-md text-sm text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Active</a>
                        <a href="#" class="block px-2 py-1.5 rounded-md text-sm text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Archived</a>
                    </div>
                </div>

                <a href="#" :class="collapsed && 'justify-center'"
                   class="flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300
                          hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M4 11h16M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span x-show="!collapsed" x-transition.opacity.duration.150ms>Calendar</span>
                </a>

                {{-- Team (expandable) --}}
                <div>
                    <button type="button" @click="toggleGroup('team')" :class="collapsed && 'justify-center'"
                            class="w-full flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300
                                   hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-3.13a4 4 0 100-8 4 4 0 000 8zm6 1a4 4 0 10-2-7.46" />
                        </svg>
                        <span x-show="!collapsed" x-transition.opacity.duration.150ms class="flex-1 text-left">Team</span>
                        <svg x-show="!collapsed" x-transition.opacity.duration.150ms
                             :class="openGroups.team && 'rotate-90'"
                             class="w-3.5 h-3.5 text-slate-400 transition-transform duration-150"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <div x-show="!collapsed && openGroups.team" x-transition class="mt-1 ml-[34px] space-y-0.5 border-l border-slate-200 dark:border-slate-800 pl-3">
                        <a href="#" class="block px-2 py-1.5 rounded-md text-sm text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Members</a>
                        <a href="#" class="block px-2 py-1.5 rounded-md text-sm text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Roles</a>
                    </div>
                </div>

                {{-- Customers (expandable) --}}
                <div>
                    <button type="button" @click="toggleGroup('customers')" :class="collapsed && 'justify-center'"
                            class="w-full flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300
                                   hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.6 9h16.8M3.6 15h16.8M11.5 3a17 17 0 000 18M12.5 3a17 17 0 010 18M12 3a9 9 0 100 18 9 9 0 000-18z" />
                        </svg>
                        <span x-show="!collapsed" x-transition.opacity.duration.150ms class="flex-1 text-left">Customers</span>
                        <svg x-show="!collapsed" x-transition.opacity.duration.150ms
                             :class="openGroups.customers && 'rotate-90'"
                             class="w-3.5 h-3.5 text-slate-400 transition-transform duration-150"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <div x-show="!collapsed && openGroups.customers" x-transition class="mt-1 ml-[34px] space-y-0.5 border-l border-slate-200 dark:border-slate-800 pl-3">
                        <a href="#" class="block px-2 py-1.5 rounded-md text-sm text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">All customers</a>
                        <a href="#" class="block px-2 py-1.5 rounded-md text-sm text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Segments</a>
                    </div>
                </div>

                <a href="#" :class="collapsed && 'justify-center'"
                   class="flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300
                          hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
                    </svg>
                    <span x-show="!collapsed" x-transition.opacity.duration.150ms>Finance</span>
                </a>
            </div>
        </div>

        {{-- Developers group --}}
        <div>
            <p x-show="!collapsed" x-transition.opacity.duration.150ms
               class="px-2.5 text-[11px] font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase mb-1">
                Developers
            </p>

            <div class="space-y-1">
                <a href="#" :class="collapsed && 'justify-center'"
                   class="flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300
                          hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7 6.3a1 1 0 010 1.4l-4 4 4 4a1 1 0 01-1.4 1.4l-4.7-4.7a1 1 0 010-1.4l4.7-4.7a1 1 0 011.4 0z" />
                    </svg>
                    <span x-show="!collapsed" x-transition.opacity.duration.150ms>API Keys</span>
                </a>

                <a href="#" :class="collapsed && 'justify-center'"
                   class="flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300
                          hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span x-show="!collapsed" x-transition.opacity.duration.150ms>Webhooks</span>
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
                class="w-full flex items-center gap-3 px-2.5 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300
                    hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 5v1a3 3 0 01-3 3H6a3 3 0 01-3-3V6a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="!collapsed" x-transition.opacity.duration.150ms>
                    Log out
                </span>
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
        <svg :class="collapsed && 'rotate-180'" class="w-3.5 h-3.5 transition-transform duration-200"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
        </svg>
    </button>
</div>
