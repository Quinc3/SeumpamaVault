@extends('layouts.app')

@section('content')
<div>
    <div class="flex justify-between items-end mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-primary">Laporan</p>
            <h2 class="text-4xl font-extrabold">Laporan Inventory</h2>
        </div>

        <a href="{{ route('reports.pdf', request()->query()) }}" class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold">
            Download PDF
        </a>
    </div>

    <form method="GET" action="{{ route('reports.index') }}" class="page-card p-6 rounded-3xl shadow-sm mb-8">
        <div class="grid grid-cols-5 gap-4">
            <div>
                <label class="text-sm font-bold">Tanggal Awal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-input w-full mt-2 rounded-2xl">
            </div>

            <div>
                <label class="text-sm font-bold">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-input w-full mt-2 rounded-2xl">
            </div>

            <div>
                <label class="text-sm font-bold">Item</label>
                <select name="item_id" class="form-input w-full mt-2 rounded-2xl">
                    <option value="">Semua Item</option>
                    @foreach($items as $item)
                    <option value="{{ $item->id }}" @selected(request('item_id')==$item->id)>
                        {{ $item->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-bold">Status</label>
                <select name="status" class="form-input w-full mt-2 rounded-2xl">
                    <option value="">Semua Status</option>
                    <option value="baik" @selected(request('status')=='baik' )>Baik</option>
                    <option value="rusak" @selected(request('status')=='rusak' )>Rusak</option>
                    <option value="expired" @selected(request('status')=='expired' )>Expired</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button class="primary-gradient text-white px-5 py-3 rounded-2xl font-bold">
                    Filter
                </button>

                <a href="{{ route('reports.index') }}" class="bg-slate-200 dark:bg-slate-800 px-5 py-3 rounded-2xl font-bold">
                    Reset
                </a>
            </div>
        </div>
    </form>

    <div class="page-card rounded-3xl shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="table-head">
                <tr>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Tanggal</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Barcode</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Item</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Qty</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Harga</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Status</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventories as $inv)
                <tr class="table-row">
                    <td class="px-8 py-5">{{ $inv->created_at->format('d M Y') }}</td>
                    <td class="px-8 py-5 font-mono text-primary font-bold">{{ $inv->barcode }}</td>
                    <td class="px-8 py-5 font-bold">{{ $inv->item->name ?? '-' }}</td>
                    <td class="px-8 py-5">{{ $inv->quantity }}</td>
                    <td class="px-8 py-5">Rp {{ number_format($inv->price, 0, ',', '.') }}</td>
                    <td class="px-8 py-5">{{ strtoupper($inv->status) }}</td>
                    <td class="px-8 py-5">Rp {{ number_format($inv->quantity * $inv->price, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-8 py-10 text-center text-slate-400">
                        Tidak ada data laporan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $inventories->links() }}
    </div>
</div>
@endsection