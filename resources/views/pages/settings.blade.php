@extends('layouts.app')

@section('content')
<div class="max-w-5xl">
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-primary">Sistem</p>
        <h2 class="text-4xl font-extrabold text-slate-900 dark:text-white">Pengaturan</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-2">
            Atur profile, password, dan permission akses sistem.
        </p>
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

    <div class="grid grid-cols-2 gap-6">
        <div class="page-card p-6 rounded-3xl shadow-sm">
            <h3 class="text-xl font-bold mb-5 text-slate-900 dark:text-white">Profile</h3>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="text-sm font-bold">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="form-input w-full mt-2 rounded-2xl border p-3">
                </div>

                <div class="mb-4">
                    <label class="text-sm font-bold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="form-input w-full mt-2 rounded-2xl border p-3">
                </div>

                <button class="primary-gradient text-white px-5 py-3 rounded-2xl font-bold">
                    Update Profile
                </button>
            </form>
        </div>

        <div class="page-card p-6 rounded-3xl shadow-sm">
            <h3 class="text-xl font-bold mb-5 text-slate-900 dark:text-white">Ganti Password</h3>

            <form method="POST" action="{{ route('profile.password') }}">
                @csrf

                <div class="mb-4">
                    <label class="text-sm font-bold">Password Lama</label>
                    <input type="password" name="current_password"
                        class="form-input w-full mt-2 rounded-2xl border p-3">
                </div>

                <div class="mb-4">
                    <label class="text-sm font-bold">Password Baru</label>
                    <input type="password" name="password"
                        class="form-input w-full mt-2 rounded-2xl border p-3">
                </div>

                <div class="mb-4">
                    <label class="text-sm font-bold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="form-input w-full mt-2 rounded-2xl border p-3">
                </div>

                <button class="bg-red-600 text-white px-5 py-3 rounded-2xl font-bold">
                    Update Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection