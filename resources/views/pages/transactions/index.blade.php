@extends('layouts.app')

@section('content')
<div>
    <div class="flex justify-between items-end mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-primary">Transaksi</p>
            <h2 class="text-4xl font-extrabold">Data Transaksi</h2>
        </div>

        <a href="{{ route('transactions.create') }}" class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold">
            + Tambah Transaksi
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 text-green-700 px-5 py-4 rounded-2xl font-bold">
        {{ session('success') }}
    </div>
    @endif

    <div class="page-card rounded-3xl shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="table-head">
                <tr>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Kode</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Tanggal</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Jenis</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Budget</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Realisasi</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Evidence</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr class="table-row">
                    <td class="px-8 py-5 font-mono text-primary font-bold">{{ $trx->transaction_code }}</td>
                    <td class="px-8 py-5">{{ $trx->transaction_date }}</td>
                    <td class="px-8 py-5">{{ $trx->type->name ?? '-' }}</td>
                    <td class="px-8 py-5">Rp {{ number_format($trx->total_budget, 0, ',', '.') }}</td>
                    <td class="px-8 py-5">Rp {{ number_format($trx->total_realization, 0, ',', '.') }}</td>
                    <td class="px-8 py-5">
                        @if($trx->evidence_file)
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Ada</span>
                        @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">Tidak Ada</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-right">
                        <a href="{{ route('transactions.show', $trx) }}" class="text-primary font-bold">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-8 py-10 text-center text-slate-400">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
</div>
@endsection