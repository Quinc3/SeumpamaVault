@extends('layouts.app')

@section('content')
<div class="flex justify-between items-end mb-8">
    <div>
        <p class="text-xs font-bold uppercase tracking-widest text-primary">Data Master</p>
        <h2 class="text-4xl font-extrabold">Tambah Ruangan</h2>
    </div>
</div>

<form action="{{ route('rooms.store') }}" method="POST" class="page-card p-8 rounded-3xl shadow-sm max-w-3xl">
    @csrf

    <div class="grid grid-cols-2 gap-5">
        <div>
            <label class="font-bold text-sm">Gedung</label>
            <select name="building_id" class="w-full mt-2 rounded-2xl border-slate-200">
                <option value="">Pilih Gedung</option>
                @foreach($buildings as $building)
                <option value="{{ $building->id }}" @selected(old('building_id')==$building->id)>
                    {{ $building->name }}
                </option>
                @endforeach
            </select>
            @error('building_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="font-bold text-sm">Kode Ruangan</label>
            <input type="text" name="code" value="{{ old('code') }}" class="w-full mt-2 rounded-2xl border-slate-200">
        </div>

        <div class="col-span-2">
            <label class="font-bold text-sm">Nama Ruangan</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full mt-2 rounded-2xl border-slate-200">
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="mt-5">
        <label class="font-bold text-sm">Deskripsi</label>
        <textarea name="description" class="w-full mt-2 rounded-2xl border-slate-200">{{ old('description') }}</textarea>
    </div>

    <button class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold mt-6">Simpan</button>
    <a href="{{ route('rooms.index') }}" class="ml-3 font-bold text-slate-500">Batal</a>
</form>
@endsection