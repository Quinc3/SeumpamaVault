@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">

    <div class="mb-8">
        <h2 class="text-4xl font-extrabold text-slate-900 dark:text-white">
            Profil
        </h2>
        <p class="text-slate-500 dark:text-slate-400 mt-2">
            Kelola informasi akun Anda
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 text-green-700 px-5 py-4 rounded-2xl font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-3 gap-6">

        {{-- PROFILE CARD --}}
        <div class="bg-white dark:bg-slate-900/70 backdrop-blur-xl border border-slate-200 dark:border-slate-800 p-6 rounded-3xl shadow-sm flex flex-col items-center text-center">
            
            <div class="w-24 h-24 rounded-full bg-indigo-500 text-white flex items-center justify-center text-4xl font-bold mb-4">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                {{ auth()->user()->name }}
            </h3>

            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">
                {{ auth()->user()->email }}
            </p>

            <span class="mt-3 px-3 py-1 rounded-full text-xs font-bold 
                {{ auth()->user()->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-600' }}">
                {{ strtoupper(auth()->user()->role) }}
            </span>
        </div>

        {{-- EDIT PROFILE --}}
        <div class="col-span-2 bg-white dark:bg-slate-900/70 backdrop-blur-xl border border-slate-200 dark:border-slate-800 p-8 rounded-3xl shadow-sm">
            
            <h3 class="text-xl font-bold mb-6 text-slate-900 dark:text-white">
                Edit Profil
            </h3>

            @if($errors->any())
                <div class="mb-5 bg-red-100 text-red-600 p-4 rounded-xl font-bold">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-5">

                    <div>
                        <label class="font-bold text-sm text-slate-700 dark:text-slate-300">Nama</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                            class="form-input w-full mt-2 rounded-2xl">
                    </div>

                    <div>
                        <label class="font-bold text-sm text-slate-700 dark:text-slate-300">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="form-input w-full mt-2 rounded-2xl">
                    </div>

                </div>

                <button class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold mt-6">
                    Update Profile
                </button>
            </form>
        </div>

        {{-- CHANGE PASSWORD --}}
        <div class="col-span-3 bg-white dark:bg-slate-900/70 backdrop-blur-xl border border-slate-200 dark:border-slate-800 p-8 rounded-3xl shadow-sm">
            
            <h3 class="text-xl font-bold mb-6 text-slate-900 dark:text-white">
                Ganti Password
            </h3>

            <form action="{{ route('profile.password') }}" method="POST">
                @csrf

                <div class="grid grid-cols-3 gap-5">

                    <div>
                        <label class="font-bold text-sm text-slate-700 dark:text-slate-300">Password Lama</label>
                        <input type="password" name="current_password" class="form-input w-full mt-2 rounded-2xl">
                    </div>

                    <div>
                        <label class="font-bold text-sm text-slate-700 dark:text-slate-300">Password Baru</label>
                        <input type="password" name="password" class="form-input w-full mt-2 rounded-2xl">
                    </div>

                    <div>
                        <label class="font-bold text-sm text-slate-700 dark:text-slate-300">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-input w-full mt-2 rounded-2xl">
                    </div>

                </div>

                <button class="primary-gradient text-white px-6 py-3 rounded-2xl font-bold mt-6">
                    Update Password
                </button>
            </form>
        </div>

    </div>
</div>
@endsection