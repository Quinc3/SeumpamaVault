@extends('layouts.app')

@section('content')
<div class="flex justify-between items-end mb-8">
    <div>
        <p class="text-xs font-bold uppercase tracking-widest text-primary">Data Master</p>
        <h2 class="text-4xl font-extrabold">Kategori Barang</h2>
    </div>

    <a href="{{ route('item-types.create') }}" class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold">
        + Tambah Kategori
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
                <th class="px-8 py-5 text-xs uppercase text-slate-400">Nama</th>
                <th class="px-8 py-5 text-xs uppercase text-slate-400">Deskripsi</th>
                <th class="px-8 py-5 text-xs uppercase text-slate-400 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($itemTypes as $itemType)
            <tr class="table-row">
                <td class="px-8 py-5 font-bold">{{ $itemType->name }}</td>
                <td class="px-8 py-5 text-slate-500">{{ $itemType->description ?? '-' }}</td>
                <td class="px-8 py-5 text-right">
                    <a href="{{ route('item-types.edit', $itemType) }}" class="text-primary font-bold">Edit</a>

                    <form action="{{ route('item-types.destroy', $itemType) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus data ini?')" class="text-red-600 font-bold ml-4">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-8 py-10 text-center text-slate-400">Belum ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $itemTypes->links() }}
</div>
@endsection