@extends('layouts.app')

@section('content')
<div>
    <div class="flex justify-between items-end mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-primary">Pengaturan</p>
            <h2 class="text-4xl font-extrabold">Manajemen User</h2>
        </div>

        <a href="{{ route('users.create') }}" class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold">
            + Tambah User
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 text-green-700 px-5 py-4 rounded-2xl font-bold">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-100 text-red-700 px-5 py-4 rounded-2xl font-bold">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="page-card rounded-3xl shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="table-head">
                <tr>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Nama</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Email</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400">Role</th>
                    <th class="px-8 py-5 text-xs uppercase text-slate-400 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="table-row">
                        <td class="px-8 py-5 font-bold">{{ $user->name }}</td>
                        <td class="px-8 py-5">{{ $user->email }}</td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <a href="{{ route('users.edit', $user) }}" class="text-primary font-bold">Edit</a>

                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus user ini?')" class="text-red-600 font-bold ml-4">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-10 text-center text-slate-400">Belum ada user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection