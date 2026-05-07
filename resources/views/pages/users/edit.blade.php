@extends('layouts.app')

@section('content')
<div>
    <h2 class="text-4xl font-extrabold mb-8">Edit User</h2>

    @if($errors->any())
    <div class="mb-6 bg-red-100 text-red-700 px-5 py-4 rounded-2xl font-bold">
        {{ $errors->first() }}
    </div>
    @endif

    <form action="{{ route('users.update', $user) }}" method="POST" class="page-card p-8 rounded-3xl shadow-sm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-5 max-w-3xl">
            <div>
                <label class="font-bold text-sm">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full mt-2 rounded-2xl form-input">
            </div>

            <div>
                <label class="font-bold text-sm">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full mt-2 rounded-2xl form-input">
            </div>

            <div>
                <label class="font-bold text-sm">Role</label>
                <select name="role" class="w-full mt-2 rounded-2xl form-input">
                    <option value="admin" @selected($user->role === 'admin')>Admin</option>
                    <option value="staff" @selected($user->role === 'staff')>Staff</option>
                </select>
            </div>

            <div></div>

            <div>
                <label class="font-bold text-sm">Password Baru</label>
                <input type="password" name="password" class="w-full mt-2 rounded-2xl form-input">
                <p class="text-xs text-slate-400 mt-1">Kosongkan kalau tidak ingin mengganti password.</p>
            </div>

            <div>
                <label class="font-bold text-sm">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full mt-2 rounded-2xl form-input">
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-xl font-bold mb-4">Permissions</h3>

            @php
            $permissions = config('permissions') ?? [];
            $userPermissions = old('permissions', $user->permissions ?? []);
            @endphp

            <div class="grid grid-cols-2 gap-6">
                @foreach($permissions as $group => $perms)
                <div class="bg-slate-50 dark:bg-slate-800/60 p-5 rounded-2xl">
                    <p class="font-extrabold capitalize mb-4">
                        {{ $group }}
                    </p>

                    <div class="space-y-3">
                        @foreach($perms as $perm)
                        <label class="flex items-center gap-3 text-sm">
                            <input type="checkbox"
                                name="permissions[]"
                                value="{{ $perm }}"
                                class="rounded text-indigo-600"
                                {{ in_array($perm, $userPermissions) ? 'checked' : '' }}>
                            <span>{{ $perm }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="mt-8">
            <button class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold">Update</button>
            <a href="{{ route('users.index') }}" class="ml-3 font-bold text-slate-500">Batal</a>
        </div>
    </form>
</div>
@endsection