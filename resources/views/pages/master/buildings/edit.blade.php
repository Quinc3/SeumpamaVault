@extends('layouts.app')

@section('content')
<div class="flex justify-between items-end mb-8">
    <div>
        <p class="text-xs font-bold uppercase tracking-widest text-primary">Data Master</p>
        <h2 class="text-4xl font-extrabold">Edit Gedung</h2>
    </div>
</div>

<form action="{{ route('buildings.update', $building) }}" method="POST" class="page-card p-8 rounded-3xl shadow-sm max-w-2xl">
    @csrf
    @method('PUT')

    <div class="mb-5">
        <label class="font-bold text-sm">Kode Gedung</label>
        <input type="text" name="code" value="{{ old('code', $building->code) }}" class="w-full mt-2 rounded-2xl border-slate-200">
    </div>

    <div class="mb-5">
        <label class="font-bold text-sm">Nama Gedung</label>
        <input type="text" name="name" value="{{ old('name', $building->name) }}" class="w-full mt-2 rounded-2xl border-slate-200">
        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-5">
        <label class="font-bold text-sm">Deskripsi</label>
        <textarea name="description" class="w-full mt-2 rounded-2xl border-slate-200">{{ old('description', $building->description) }}</textarea>
    </div>

    <button class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold">Update</button>
    <a href="{{ route('buildings.index') }}" class="ml-3 font-bold text-slate-500">Batal</a>
</form>
@endsection