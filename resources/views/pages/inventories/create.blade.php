@extends('layouts.app')

@section('content')
    <h2 class="text-4xl font-extrabold mb-8">Tambah Stok Inventory</h2>

    <form action="{{ route('inventories.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl shadow-sm max-w-4xl">
        @csrf

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="font-bold text-sm">Item</label>
                <select name="item_id" class="form-input w-full mt-2 rounded-2xl">
                    <option value="">Pilih Item</option>
                    @foreach($items as $item)
                    <option value="{{ $item->id }}" @selected(old('item_id')==$item->id)>
                        {{ $item->name }}
                    </option>
                    @endforeach
                </select>
                @error('item_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="font-bold text-sm">Barcode</label>
                <input class="form-input w-full mt-2 rounded-2xl" type="text" name="barcode" value="{{ old('barcode', $barcode) }}" class="w-full mt-2 rounded-2xl border-slate-200">
                @error('barcode') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="font-bold text-sm">Quantity</label>
                <input class="form-input w-full mt-2 rounded-2xl" type="number" name="quantity" value="{{ old('quantity') }}" class="w-full mt-2 rounded-2xl border-slate-200">
                @error('quantity') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="font-bold text-sm">Harga</label>
                <input class="form-input w-full mt-2 rounded-2xl" type="number" name="price" value="{{ old('price') }}" class="w-full mt-2 rounded-2xl border-slate-200">
                @error('price') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="font-bold text-sm">Expired Date</label>
                <input class="form-input w-full mt-2 rounded-2xl" type="date" name="expired_date" value="{{ old('expired_date') }}" class="w-full mt-2 rounded-2xl border-slate-200">
            </div>

            <div>
                <label class="font-bold text-sm">Status</label>
                <select name="status" class="w-full mt-2 rounded-2xl border-slate-200">
                    <option value="baik">Baik</option>
                    <option value="rusak">Rusak</option>
                    <option value="expired">Expired</option>
                </select>
            </div>

            <div class="col-span-2">
                <label class="font-bold text-sm">Upload Foto</label>
                <input class="form-input w-full mt-2 rounded-2xl" type="file" name="photo" class="w-full mt-2 rounded-2xl border-slate-200 bg-white">
                @error('photo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="col-span-2">
                <label class="font-bold text-sm">Deskripsi</label>
                <textarea name="description" class="w-full mt-2 rounded-2xl border-slate-200">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>
        </div>

        <button class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold mt-6">Simpan</button>
        <a href="{{ route('inventories.index') }}" class="ml-3 font-bold text-slate-500">Batal</a>
    </form>
@endsection