@extends('layouts.app')

@section('content')
<div>
    <div class="flex justify-between items-end mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-primary">Transactions</p>
            <h2 class="text-4xl font-extrabold">Detail Transaksi</h2>
        </div>

        <a href="{{ route('transactions.index') }}" class="px-6 py-3 rounded-2xl bg-slate-200 font-bold">
            Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 text-green-700 px-5 py-4 rounded-2xl font-bold">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl shadow-sm">
            <p class="text-sm text-slate-400">Kode Transaksi</p>
            <h3 class="text-2xl font-extrabold text-primary mt-2">{{ $transaction->transaction_code }}</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm">
            <p class="text-sm text-slate-400">Jenis Transaksi</p>
            <h3 class="text-2xl font-extrabold mt-2">{{ $transaction->type->name ?? '-' }}</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm">
            <p class="text-sm text-slate-400">Tanggal</p>
            <h3 class="text-xl font-bold mt-2">{{ $transaction->transaction_date }}</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm">
            <p class="text-sm text-slate-400">Evidence</p>
            @if($transaction->evidence_file)
            <a href="{{ asset('storage/' . $transaction->evidence_file) }}" target="_blank" class="text-primary font-bold mt-2 inline-block">
                Lihat Evidence
            </a>
            @else
            <p class="text-slate-500 mt-2">Tidak ada evidence.</p>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="table-head">
                <tr>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Item</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Qty</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Harga</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                <tr class="table-row">
                    <td class="px-8 py-5 font-bold">{{ $detail->item->name ?? '-' }}</td>
                    <td class="px-8 py-5">{{ $detail->quantity }}</td>
                    <td class="px-8 py-5">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td class="px-8 py-5">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-sm mt-8 text-right">
        <p class="text-slate-400">Total Realisasi</p>
        <h3 class="text-3xl font-extrabold text-primary">
            Rp {{ number_format($transaction->total_realization, 0, ',', '.') }}
        </h3>
    </div>
</div>
@endsection