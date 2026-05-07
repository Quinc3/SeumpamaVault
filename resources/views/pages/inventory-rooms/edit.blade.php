@extends('layouts.app')

@section('content')
    <h2 class="text-4xl font-extrabold mb-8">Edit Distribusi Barang</h2>

    <form action="{{ route('inventory-rooms.update', $inventoryRoom) }}" method="POST" class="bg-white p-8 rounded-3xl shadow-sm max-w-4xl">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-5">
            <div class="col-span-2">
                <label class="font-bold text-sm">Inventory</label>
                <select name="inventory_id" class="w-full mt-2 rounded-2xl border-slate-200">
                    @foreach($inventories as $inventory)
                    <option value="{{ $inventory->id }}" @selected($inventoryRoom->inventory_id == $inventory->id)>
                        {{ $inventory->barcode }} - {{ $inventory->item->name ?? '-' }} | Stok: {{ $inventory->quantity }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-bold text-sm">Ruangan</label>
                <select name="room_id" class="w-full mt-2 rounded-2xl border-slate-200">
                    @foreach($rooms as $room)
                    <option value="{{ $room->id }}" @selected($inventoryRoom->room_id == $room->id)>
                        {{ $room->building->name ?? '-' }} - {{ $room->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-bold text-sm">Jumlah</label>
                <input type="number" name="quantity" value="{{ old('quantity', $inventoryRoom->quantity) }}" class="w-full mt-2 rounded-2xl border-slate-200">
                @error('quantity') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="font-bold text-sm">Tanggal Assign</label>
                <input type="date" name="assigned_at" value="{{ old('assigned_at', $inventoryRoom->assigned_at) }}" class="w-full mt-2 rounded-2xl border-slate-200">
            </div>

            <div>
                <label class="font-bold text-sm">Status</label>
                <select name="status" class="w-full mt-2 rounded-2xl border-slate-200">
                    <option value="baik" @selected($inventoryRoom->status == 'baik')>Baik</option>
                    <option value="rusak" @selected($inventoryRoom->status == 'rusak')>Rusak</option>
                    <option value="dipindahkan" @selected($inventoryRoom->status == 'dipindahkan')>Dipindahkan</option>
                </select>
            </div>

            <div class="col-span-2">
                <label class="font-bold text-sm">Keterangan</label>
                <textarea name="description" class="w-full mt-2 rounded-2xl border-slate-200">{{ old('description', $inventoryRoom->description) }}</textarea>
            </div>
        </div>

        <button class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold mt-6">Update</button>
        <a href="{{ route('inventory-rooms.index') }}" class="ml-3 font-bold text-slate-500">Batal</a>
    </form>
@endsection