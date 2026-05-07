@extends('layouts.app')

@section('content')
<div>
    <h2 class="text-4xl font-extrabold mb-8 text-slate-900 dark:text-white">
        Dashboard
    </h2>

    <div class="grid grid-cols-5 gap-6 mb-10">
        <a href="{{ route('inventories.index') }}" class="bg-white dark:bg-slate-900/70 backdrop-blur-xl border border-slate-200 dark:border-slate-800 p-6 rounded-3xl shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all block">
            <p class="text-sm text-slate-400">Total Barang</p>
            <h3 class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-2">
                {{ $totalInventory }}
            </h3>
        </a>

        <a href="{{ route('items.index') }}" class="bg-white dark:bg-slate-900/70 backdrop-blur-xl border border-slate-200 dark:border-slate-800 p-6 rounded-3xl shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all block">
            <p class="text-sm text-slate-400">Total Item</p>
            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-2">
                {{ $totalItems }}
            </h3>
        </a>

        <a href="{{ route('rooms.index') }}" class="bg-white dark:bg-slate-900/70 backdrop-blur-xl border border-slate-200 dark:border-slate-800 p-6 rounded-3xl shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all block">
            <p class="text-sm text-slate-400">Total Ruangan</p>
            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-2">
                {{ $totalRooms }}
            </h3>
        </a>

        <a href="{{ route('transactions.index') }}" class="bg-white dark:bg-slate-900/70 backdrop-blur-xl border border-slate-200 dark:border-slate-800 p-6 rounded-3xl shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all block">
            <p class="text-sm text-slate-400">Total Transaksi</p>
            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-2">
                {{ $totalTransactions }}
            </h3>
        </a>

        <a href="{{ route('inventories.index') }}?status=rusak" class="bg-white dark:bg-slate-900/70 backdrop-blur-xl border border-slate-200 dark:border-slate-800 p-6 rounded-3xl shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all block">
            <p class="text-sm text-slate-400">Barang Rusak</p>
            <h3 class="text-3xl font-extrabold text-red-500 dark:text-red-400 mt-2">
                {{ $rusak }}
            </h3>
        </a>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <a href="{{ route('inventories.index') }}?status=expired" class="bg-white dark:bg-slate-900/70 backdrop-blur-xl border border-slate-200 dark:border-slate-800 p-6 rounded-3xl shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all block">
            <p class="text-sm text-slate-400">Barang Expired</p>
            <h3 class="text-3xl font-extrabold text-yellow-500 dark:text-yellow-400 mt-2">
                {{ $expired }}
            </h3>
        </a>

        <div class="bg-white dark:bg-slate-900/70 backdrop-blur-xl border border-slate-200 dark:border-slate-800 p-6 rounded-3xl shadow-sm">
            <p class="text-sm text-slate-400">Info</p>
            <p class="mt-2 text-slate-600 dark:text-slate-300">
                Sistem Inventory Aset Yayasan
            </p>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6 mt-10">
        <div class="col-span-2 bg-white dark:bg-slate-900/70 backdrop-blur-xl border border-slate-200 dark:border-slate-800 p-6 rounded-3xl shadow-sm">
            <h3 class="text-xl font-bold mb-4 text-slate-900 dark:text-white">
                Grafik Transaksi
            </h3>

            @if($hasChartData ?? false)
            <canvas id="chart"></canvas>
            @else
            <div class="py-16 text-center text-slate-400">
                Belum ada data transaksi untuk ditampilkan.
            </div>
            @endif
        </div>

        <div class="bg-white dark:bg-slate-900/70 backdrop-blur-xl border border-slate-200 dark:border-slate-800 p-6 rounded-3xl shadow-sm">
            <h3 class="text-xl font-bold mb-4 text-slate-900 dark:text-white">
                Log Aktivitas
            </h3>

            <div class="space-y-4">
                @forelse($recentTransactions ?? [] as $trx)
                <a href="{{ route('transactions.show', $trx) }}" class="block border-l-4 border-indigo-500 pl-4 py-1">
                    <p class="font-bold text-slate-800 dark:text-slate-100 text-sm">
                        {{ $trx->type->name ?? 'Transaksi' }}
                    </p>
                    <p class="text-xs text-slate-500">
                        {{ $trx->transaction_code }} · Rp {{ number_format($trx->total_realization, 0, ',', '.') }}
                    </p>
                </a>
                @empty
                <p class="text-slate-400 text-sm">Belum ada aktivitas transaksi.</p>
                @endforelse

                @foreach($recentInventories ?? [] as $inv)
                <a href="{{ route('inventories.index') }}" class="block border-l-4 border-emerald-500 pl-4 py-1">
                    <p class="font-bold text-slate-800 dark:text-slate-100 text-sm">
                        Stok {{ $inv->item->name ?? '-' }}
                    </p>
                    <p class="text-xs text-slate-500">
                        {{ $inv->barcode }} · Qty {{ $inv->quantity }}
                    </p>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    @if($hasChartData ?? false)
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            const chartDates = JSON.parse('{!! json_encode($chartDates ?? []) !!}');
            const chartTotals = JSON.parse('{!! json_encode($chartTotals ?? []) !!}');
            const ctx = document.getElementById('chart');

            if (!ctx || chartDates.length === 0) return;

            const isDark = document.documentElement.classList.contains('dark');

            new window.Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartDates,
                    datasets: [{
                        label: 'Total Transaksi',
                        data: chartTotals,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    @endif
    @endsection