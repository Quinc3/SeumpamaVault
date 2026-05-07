@extends('layouts.app')

@section('content')
<div>

    <div class="flex justify-between items-end mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-primary">Master Data</p>
            <h2 class="text-4xl font-extrabold">Jenis Transaksi</h2>
        </div>

        <a href="{{ route('transaction-types.create') }}" class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold">
            + Tambah Jenis
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
                @forelse($transactionTypes as $type)
                <tr class="table-row">
                    <td class="px-8 py-5 font-bold">{{ $type->name }}</td>
                    <td class="px-8 py-5">{{ $type->description }}</td>
                    <td class="px-8 py-5 text-right">
                        <a href="{{ route('transaction-types.edit', $type) }}" class="text-primary font-bold mr-3">Edit</a>

                        <form action="{{ route('transaction-types.destroy', $type) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus data?')" class="text-red-500 font-bold">
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

</div>
@endsection