@extends('layouts.app')

@section('content')
<div>
    <h2 class="text-4xl font-extrabold mb-8">Tambah User</h2>

    @if($errors->any())
        <div class="mb-6 bg-red-100 text-red-700 px-5 py-4 rounded-2xl font-bold">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="page-card p-8 rounded-3xl shadow-sm max-w-3xl">
        @csrf

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="font-bold text-sm">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full mt-2 rounded-2xl form-input">
            </div>

            <div>
                <label class="font-bold text-sm">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full mt-2 rounded-2xl form-input">
            </div>

            <div>
                <label class="font-bold text-sm">Role</label>
                <select name="role" class="w-full mt-2 rounded-2xl form-input">
                    <option value="admin">Admin</option>
                    <option value="staff" selected>Staff</option>
                </select>
            </div>

            <div></div>

            <div>
                <label class="font-bold text-sm">Password</label>
                <input type="password" name="password" class="w-full mt-2 rounded-2xl form-input">
            </div>

            <div>
                <label class="font-bold text-sm">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full mt-2 rounded-2xl form-input">
            </div>
        </div>

        <button class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold mt-6">Simpan</button>
        <a href="{{ route('users.index') }}" class="ml-3 font-bold text-slate-500">Batal</a>
    </form>
</div>
@endsection