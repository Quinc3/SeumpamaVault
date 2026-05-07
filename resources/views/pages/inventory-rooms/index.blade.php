@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-end mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-primary">Distribusi</p>
            <h2 class="text-4xl font-extrabold">Monitoring Distribusi</h2>
        </div>

        <a href="{{ route('inventory-rooms.create') }}" class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold">
            + Assign Barang
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
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Barcode</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Item</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Gedung</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Ruangan</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Qty</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Status</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventoryRooms as $row)
                <tr class="table-row">
                    <td class="px-8 py-5 font-mono text-primary font-bold">
                        {{ $row->inventory->barcode ?? '-' }}
                    </td>
                    <td class="px-8 py-5 font-bold">
                        {{ $row->inventory->item->name ?? '-' }}
                    </td>
                    <td class="px-8 py-5">
                        {{ $row->room->building->name ?? '-' }}
                    </td>
                    <td class="px-8 py-5">
                        {{ $row->room->name ?? '-' }}
                    </td>
                    <td class="px-8 py-5">
                        {{ $row->quantity }}
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                                {{ $row->status == 'baik' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $row->status == 'rusak' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $row->status == 'dipindahkan' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                            {{ strtoupper($row->status) }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <a href="{{ route('inventory-rooms.edit', $row) }}" class="text-primary font-bold">Edit</a>

                        <form action="{{ route('inventory-rooms.destroy', $row) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus distribusi ini?')" class="text-red-600 font-bold ml-4">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-8 py-10 text-center text-slate-400">
                        Belum ada distribusi barang.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection