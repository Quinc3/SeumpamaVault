<header class="sticky top-0 w-full z-40 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800 flex justify-between items-center h-20 px-10 text-sm font-medium">
    <div class="relative w-full max-w-md">
        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">search</span>

        <form action="{{ route('inventories.index') }}" method="GET" class="relative w-full max-w-md">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">search</span>

            <input
                name="search"
                value="{{ request('search') }}"
                class="w-full bg-slate-100/70 dark:bg-slate-800/80 border-0 rounded-full py-2.5 pl-12 pr-4 focus:ring-2 focus:ring-indigo-500/30 outline-none text-slate-700 dark:text-slate-100"
                placeholder="Search inventory, item, barcode..."
                type="text" />
        </form>
    </div>

    <div class="flex items-center gap-4">
        <button id="themeToggle" type="button" class="p-3 text-slate-400 dark:text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition">
            <span id="themeIcon" class="material-symbols-outlined">dark_mode</span>
        </button>

        <a href="{{ route('notifications.index') }}" class="relative p-3 text-slate-400 dark:text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition">
            <span class="material-symbols-outlined">notifications</span>

            @if($hasNotification ?? false)
            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
            @endif
        </a>

        <a href="{{ route('help.index') }}" class="p-3 text-slate-400 dark:text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition">
            <span class="material-symbols-outlined">help_outline</span>
        </a>

        <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-700 mx-2"></div>

        <a href="{{ route('profile.index') }}" class="flex items-center gap-3 pl-2 hover:opacity-80 transition">
            <div class="text-right">
                <p class="text-xs font-bold text-slate-700 dark:text-slate-100">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase">
                    Vault Manager
                </p>
            </div>

            <div class="w-10 h-10 rounded-full bg-indigo-500 dark:bg-indigo-600 text-white flex items-center justify-center font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </a>
    </div>
</header>