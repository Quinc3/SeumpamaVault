@php
$masterMenus = [
['Kategori', 'item-types.index', 'category'],
['Barang', 'items.index', 'database'],
['Gedung', 'buildings.index', 'apartment'],
['Ruangan', 'rooms.index', 'meeting_room'],
['Jenis Transaksi', 'transaction-types.index', 'swap_horiz'],
];

$operationMenus = [
['Inventaris', 'inventories.index', 'inventory_2'],
['Riwayat Transaksi', 'transactions.index', 'receipt_long'],
];

if (auth()->user()->role === 'admin') {
$operationMenus[] = ['Distribusi', 'inventory-rooms.index', 'local_shipping'];
$operationMenus[] = ['Kelola Pengguna', 'users.index', 'group'];
}
@endphp

<aside id="sidebar"
    class="w-64 flex flex-col p-6 h-screen fixed left-0 top-0 rounded-r-[3rem]
    bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl shadow z-50 text-sm transition-all duration-300">

    {{-- LOGO --}}
    <div class="flex items-center gap-3 mb-6 px-2">
        <div class="w-10 h-10 rounded-2xl overflow-hidden flex items-center justify-center bg-white dark:bg-slate-800 shadow-sm">
            <img src="{{ asset('images/logo-black.svg') }}" class="w-8 h-8 object-contain block dark:hidden">
            <img src="{{ asset('images/logo-white.svg') }}" class="w-8 h-8 object-contain hidden dark:block">
        </div>

        <div class="menu-text">
            <h1 class="text-lg font-extrabold text-indigo-600 dark:text-indigo-400 leading-none">
                Seumpama Vault
            </h1>
            <p class="text-[10px] uppercase text-slate-400 dark:text-slate-500 font-bold mt-1">
                Inventory System
            </p>
        </div>
    </div>

    {{-- TOGGLE --}}
    <button id="sidebarToggle"
        class="group mb-6 p-2 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-800 transition w-fit">
        <span class="material-symbols-outlined text-slate-500 dark:text-slate-400
            transition-transform duration-200 group-hover:scale-125 group-hover:-rotate-6">
            menu
        </span>
    </button>

    {{-- NEW ASSET (ADMIN ONLY) --}}
    @if(auth()->user()->role === 'admin')
    <a href="{{ route('inventories.create') }}"
        class="group mb-6 flex items-center justify-center gap-2 py-3 rounded-2xl
        primary-gradient text-white font-bold shadow hover:scale-105 transition">
        <span class="material-symbols-outlined">add</span>
        <span class="menu-text">New Asset</span>
    </a>
    @endif

    <nav class="flex-1 space-y-2 overflow-y-auto no-scrollbar pr-1">

        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition
            {{ request()->routeIs('dashboard') ? 'bg-slate-100 dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 font-bold shadow' : 'text-slate-500 dark:text-slate-400 hover:text-indigo-500' }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="menu-text">Dashboard</span>
        </a>

        {{-- MASTER DATA (ADMIN ONLY) --}}
        @if(auth()->user()->role === 'admin')
        <p onclick="toggleSection('master')"
            class="cursor-pointer menu-text text-xs text-slate-400 px-4 mt-4 uppercase font-bold flex justify-between">
            Master Data <span id="icon-master">▾</span>
        </p>

        <div id="section-master">
            @foreach ($masterMenus as [$label, $route, $icon])
            <a href="{{ route($route) }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition
                {{ request()->routeIs($route) ? 'bg-slate-100 dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 font-bold shadow' : 'text-slate-500 dark:text-slate-400 hover:text-indigo-500' }}">
                <span class="material-symbols-outlined">{{ $icon }}</span>
                <span class="menu-text">{{ $label }}</span>
            </a>
            @endforeach
        </div>
        @endif

        {{-- OPERATIONS --}}
        <p onclick="toggleSection('operations')"
            class="cursor-pointer menu-text text-xs text-slate-400 px-4 mt-4 uppercase font-bold flex justify-between">
            Operations <span id="icon-operations">▾</span>
        </p>

        <div id="section-operations">
            @foreach ($operationMenus as [$label, $route, $icon])
            <a href="{{ route($route) }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition
                {{ request()->routeIs($route) ? 'bg-slate-100 dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 font-bold shadow' : 'text-slate-500 dark:text-slate-400 hover:text-indigo-500' }}">
                <span class="material-symbols-outlined">{{ $icon }}</span>
                <span class="menu-text">{{ $label }}</span>
            </a>
            @endforeach
        </div>

        {{-- REPORTS --}}
        <p onclick="toggleSection('reports')"
            class="cursor-pointer menu-text text-xs text-slate-400 px-4 mt-4 uppercase font-bold flex justify-between">
            Reports <span id="icon-reports">▾</span>
        </p>

        <div id="section-reports">
            <a href="{{ route('reports.index') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition
                {{ request()->routeIs('reports.index') ? 'bg-slate-100 dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 font-bold shadow' : 'text-slate-500 dark:text-slate-400 hover:text-indigo-500' }}">
                <span class="material-symbols-outlined">assessment</span>
                <span class="menu-text">Reports</span>
            </a>
        </div>
    </nav>

    {{-- FOOTER --}}
    <div class="mt-auto pt-6 border-t border-slate-200 dark:border-slate-800 flex flex-col gap-2">

        <a href="{{ route('settings.index') }}"
            class="group flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-indigo-500">
            <span class="material-symbols-outlined">settings</span>
            <span class="menu-text">Settings</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="group flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-red-500 w-full">
                <span class="material-symbols-outlined">logout</span>
                <span class="menu-text">Logout</span>
            </button>
        </form>

    </div>
</aside>