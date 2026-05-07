@extends('layouts.app')

@section('content')
<div>
    <div class="flex justify-between items-end mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-primary">Inventaris</p>
            <h2 class="text-4xl font-extrabold">Data Inventaris</h2>
        </div>

        @if(auth()->user()->role === 'admin')
        <a href="{{ route('inventories.create') }}" class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold">
            + Tambah Stok
        </a>
        @endif
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
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Foto</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Barcode</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Item</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Qty</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Harga</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Status</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventories as $inventory)
                <tr class="table-row">
                    <td class="px-8 py-5">
                        @if($inventory->photo)
                        <img src="{{ asset('storage/' . $inventory->photo) }}" class="w-12 h-12 object-cover rounded-xl">
                        @else
                        <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-slate-400">image</span>
                        </div>
                        @endif
                    </td>
                    <td class="px-8 py-5">
                        @if($inventory->barcode)
                        <div class="flex flex-col items-start">
                            <img
                                src="data:image/png;base64,{{ \Milon\Barcode\Facades\DNS1DFacade::getBarcodePNG($inventory->barcode, 'C128') }}"
                                class="h-10 w-48 object-contain">
                            <span class="text-xs font-mono font-bold mt-1">
                                {{ $inventory->barcode }}
                            </span>
                        </div>
                        @else
                        <span class="text-slate-400 text-xs">Belum ada</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 font-bold">{{ $inventory->item->name ?? '-' }}</td>
                    <td class="px-8 py-5">{{ $inventory->quantity }}</td>
                    <td class="px-8 py-5">Rp {{ number_format($inventory->price, 0, ',', '.') }}</td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                                {{ $inventory->status == 'baik' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $inventory->status == 'rusak' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $inventory->status == 'expired' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                            {{ strtoupper($inventory->status) }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-right">
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('inventories.edit', $inventory) }}" class="text-primary font-bold">Edit</a>
                        <a href="{{ route('inventories.print', $inventory) }}"
                            class="text-blue-500 font-bold ml-4">
                            Print
                        </a>
                        <form action="{{ route('inventories.destroy', $inventory) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus data ini?')" class="text-red-600 font-bold ml-4">
                                Hapus
                            </button>
                        </form>
                        @else
                        <span class="text-slate-400 text-sm">View only</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-8 py-10 text-center text-slate-400">Belum ada data inventory.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex items-center justify-between">
        <p class="text-sm text-slate-500">
            @if(request('search'))
            Hasil pencarian untuk: <b>{{ request('search') }}</b>
            @else
            Menampilkan data inventory
            @endif
        </p>

        <div>
            {{ $inventories->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection