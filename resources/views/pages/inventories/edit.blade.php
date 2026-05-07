@extends('layouts.app')

@section('content')
    <h2 class="text-4xl font-extrabold mb-8">Edit Inventory</h2>

    <form action="{{ route('inventories.update', $inventory) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl shadow-sm max-w-4xl">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="font-bold text-sm">Item</label>
                <select name="item_id" class="w-full mt-2 rounded-2xl border-slate-200">
                    @foreach($items as $item)
                    <option value="{{ $item->id }}" @selected($inventory->item_id == $item->id)>
                        {{ $item->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-bold text-sm">Barcode</label>
                <input type="text" name="barcode" value="{{ old('barcode', $inventory->barcode) }}" class="w-full mt-2 rounded-2xl border-slate-200">
            </div>

            <div>
                <label class="font-bold text-sm">Quantity</label>
                <input type="number" name="quantity" value="{{ old('quantity', $inventory->quantity) }}" class="w-full mt-2 rounded-2xl border-slate-200">
            </div>

            <div>
                <label class="font-bold text-sm">Harga</label>
                <input type="number" name="price" value="{{ old('price', $inventory->price) }}" class="w-full mt-2 rounded-2xl border-slate-200">
            </div>

            <div>
                <label class="font-bold text-sm">Expired Date</label>
                <input type="date" name="expired_date" value="{{ old('expired_date', $inventory->expired_date) }}" class="w-full mt-2 rounded-2xl border-slate-200">
            </div>

            <div>
                <label class="font-bold text-sm">Status</label>
                <select name="status" class="w-full mt-2 rounded-2xl border-slate-200">
                    <option value="baik" @selected($inventory->status == 'baik')>Baik</option>
                    <option value="rusak" @selected($inventory->status == 'rusak')>Rusak</option>
                    <option value="expired" @selected($inventory->status == 'expired')>Expired</option>
                </select>
            </div>

            <div class="col-span-2">
                <label class="font-bold text-sm">Upload Foto Baru</label>
                <input type="file" name="photo" class="w-full mt-2 rounded-2xl border-slate-200 bg-white">

                @if($inventory->photo)
                <img src="{{ asset('storage/' . $inventory->photo) }}" class="w-24 h-24 object-cover rounded-2xl mt-4">
                @endif
            </div>

            <div class="col-span-2">
                <label class="font-bold text-sm">Deskripsi</label>
                <textarea name="description" class="w-full mt-2 rounded-2xl border-slate-200">{{ old('description', $inventory->description) }}</textarea>
            </div>
        </div>

        <button class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold mt-6">Update</button>
        <a href="{{ route('inventories.index') }}" class="ml-3 font-bold text-slate-500">Batal</a>
    </form>
@endsection