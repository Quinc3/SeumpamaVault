@extends('layouts.app')

@section('content')
<div class="flex justify-between items-end mb-8">
    <div>
        <p class="text-xs font-bold uppercase tracking-widest text-primary">Data Master</p>
        <h2 class="text-4xl font-extrabold">Edit Barang</h2>
    </div>
</div>

<form action="{{ route('items.update', $item) }}" method="POST" class="page-card p-8 rounded-3xl shadow-sm max-w-3xl">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-2 gap-5">
        <div>
            <label class="font-bold text-sm">Kode</label>
            <input type="text" name="code" value="{{ old('code', $item->code) }}" class="w-full mt-2 rounded-2xl border-slate-200">
        </div>

        <div>
            <label class="font-bold text-sm">Nama Item</label>
            <input type="text" name="name" value="{{ old('name', $item->name) }}" class="w-full mt-2 rounded-2xl border-slate-200">
        </div>

        <div>
            <label class="font-bold text-sm">Kategori</label>
            <select name="item_type_id" class="w-full mt-2 rounded-2xl border-slate-200">
                @foreach($itemTypes as $type)
                <option value="{{ $type->id }}" @selected($item->item_type_id == $type->id)>
                    {{ $type->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="font-bold text-sm">Satuan</label>
            <input type="text" name="unit" value="{{ old('unit', $item->unit) }}" class="w-full mt-2 rounded-2xl border-slate-200">
        </div>
    </div>

    <div class="mt-5">
        <label class="font-bold text-sm">Deskripsi</label>
        <textarea name="description" class="w-full mt-2 rounded-2xl border-slate-200">{{ old('description', $item->description) }}</textarea>
    </div>

    <button class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold mt-6">Update</button>
    <a href="{{ route('items.index') }}" class="ml-3 font-bold text-slate-500">Batal</a>
</form>
@endsection