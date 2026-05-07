<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seumpama Vault | Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        .bg-classroom {
            background-image: linear-gradient(rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.65)),
            url("{{ asset('images/bg-classroom.jpg') }}");
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-classroom min-h-screen">
    <main class="min-h-screen flex">
        <section class="hidden lg:flex w-1/2 items-center justify-center p-12">
            <div class="w-full max-w-lg bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-12 shadow-2xl">
                <div class="mb-8 inline-flex items-center justify-center w-16 h-16 rounded-lg bg-blue-600 shadow-lg">
                    <span class="material-symbols-outlined text-white text-4xl">dataset</span>
                </div>

                <h1 class="text-4xl font-extrabold text-white leading-tight mb-6">
                    Seumpama Vault <br>
                    <span class="text-blue-400">Inventory System</span>
                </h1>

                <p class="text-slate-200">
                    Sistem informasi inventory aset untuk pengelolaan barang, transaksi, distribusi, dan laporan.
                </p>
            </div>
        </section>

        <section class="w-full lg:w-1/2 flex items-center justify-center p-6 md:p-12">
            <div class="w-full max-w-md">
                <div class="bg-white/95 backdrop-blur-xl rounded-2xl p-8 md:p-10 shadow-2xl">
                    <header class="mb-10 text-center">
                        <h2 class="text-3xl font-black text-slate-900 mb-2">Welcome Back</h2>
                        <p class="text-slate-500 text-sm">Masuk untuk mengakses sistem inventory.</p>
                    </header>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    @if ($errors->any())
                    <div class="mb-5 rounded-xl bg-red-100 text-red-600 p-4 text-sm font-bold">
                        {{ $errors->first() }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <label class="block text-xs font-bold uppercase text-slate-500 ml-1">Email Address</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-blue-600">mail</span>
                                <input name="email"
                                    value="{{ old('email') }}"
                                    type="email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-0 rounded-xl ring-1 ring-slate-200 focus:ring-2 focus:ring-blue-600 transition-all"
                                    placeholder="admin@seumpama.com">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold uppercase text-slate-500 ml-1">Password</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-blue-600">lock</span>

                                <input id="passwordInput"
                                    name="password"
                                    type="password"
                                    required
                                    autocomplete="current-password"
                                    class="w-full pl-12 pr-12 py-4 bg-slate-50 border-0 rounded-xl ring-1 ring-slate-200 focus:ring-2 focus:ring-blue-600 transition-all"
                                    placeholder="••••••••">

                                <button type="button"
                                    onclick="togglePassword()"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600">
                                    <span id="passwordIcon" class="material-symbols-outlined text-xl">visibility_off</span>
                                </button>
                            </div>
                        </div>

                        <label class="inline-flex items-center text-sm text-slate-600">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                            <span class="ml-2">Remember me</span>
                        </label>

                        <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transition flex items-center justify-center gap-2 uppercase tracking-widest text-sm">
                            Log In
                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </button>
                    </form>
                </div>

                <p class="mt-8 text-center text-xs text-white/70 font-medium">
                    © 2026 Seumpama Vault - Inventory Management System
                </p>
            </div>
        </section>
    </main>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('passwordIcon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        }
    </script>
</body>

</html>