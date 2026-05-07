<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Seumpama Vault' }}</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class"
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        .primary-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }

        #sidebar {
            overflow: hidden;
        }

        #sidebar.w-24 .menu-text {
            display: none;
        }

        #sidebar.w-24 a {
            justify-content: center;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .page-card {
            background: white;
            border: 1px solid #e2e8f0;
        }

        .dark .page-card {
            background: rgba(15, 23, 42, 0.75);
            border-color: #1e293b;
        }

        .table-head {
            background: #f8fafc;
        }

        .dark .table-head {
            background: #1e293b;
        }

        .table-row {
            border-top: 1px solid #f1f5f9;
        }

        .dark .table-row {
            border-top-color: #1e293b;
        }

        .form-input {
            background: white;
            color: #0f172a;
            border-color: #cbd5e1;
        }

        .dark .form-input {
            background: #0f172a;
            color: #f8fafc;
            border-color: #334155;
        }

        .dark .form-input::placeholder {
            color: #64748b;
        }

        body {
            font-family: 'Manrope', sans-serif;
        }

        .primary-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }

        #sidebar {
            overflow: hidden;
        }

        #sidebar.w-24 .menu-text {
            display: none;
        }

        #sidebar.w-24 a {
            justify-content: center;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* GLOBAL DARK MODE FIX */
        .dark table {
            color: #e5e7eb;
        }

        .dark thead {
            background: #1e293b !important;
        }

        .dark tbody tr {
            border-color: #1e293b !important;
        }

        .dark td {
            color: #e5e7eb;
        }

        .dark th {
            color: #94a3b8;
        }

        .dark input,
        .dark select,
        .dark textarea {
            background: #0f172a !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }

        .dark input::placeholder,
        .dark textarea::placeholder {
            color: #64748b !important;
        }

        .dark .bg-white {
            background-color: #0f172a !important;
        }

        .dark .bg-slate-50 {
            background-color: #1e293b !important;
        }

        .dark .text-slate-900 {
            color: #f8fafc !important;
        }

        .dark .text-slate-800 {
            color: #f1f5f9 !important;
        }

        .dark .text-slate-700 {
            color: #e2e8f0 !important;
        }

        .dark .text-slate-600 {
            color: #cbd5e1 !important;
        }

        .dark .text-slate-500 {
            color: #94a3b8 !important;
        }

        .dark .border-slate-100,
        .dark .border-slate-200 {
            border-color: #1e293b !important;
        }

        /* CHECKBOX DARK MODE FIX */
        .dark input[type="checkbox"] {
            background-color: #0f172a !important;
            border: 1px solid #64748b !important;
        }

        .dark input[type="checkbox"]:checked {
            background-color: #4f46e5 !important;
            border-color: #4f46e5 !important;
        }

        .dark input[type="checkbox"]:focus {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.35) !important;
        }
    </style>
    </style>
</head>

<body class="bg-slate-100 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased overflow-x-hidden">
    @auth
    @include('components.sidebar')

    <main id="mainContent" class="ml-64 min-h-screen transition-all duration-300">
        @include('components.topbar')
        <div class="px-10 py-8">
            @yield('content')
        </div>
    </main>
    @else
    @yield('content')
    @endauth

    <script>
        const html = document.documentElement;
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');

        function applyTheme(theme) {
            if (theme === 'dark') {
                html.classList.add('dark');
                if (themeIcon) themeIcon.textContent = 'light_mode';
            } else {
                html.classList.remove('dark');
                if (themeIcon) themeIcon.textContent = 'dark_mode';
            }
        }

        applyTheme(localStorage.getItem('theme') || 'light');

        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                const newTheme = html.classList.contains('dark') ? 'light' : 'dark';
                localStorage.setItem('theme', newTheme);
                applyTheme(newTheme);
            });
        }

        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('sidebarToggle');

        function applySidebar(state) {
            if (!sidebar || !main) return;

            if (state === 'collapsed') {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-24');
                main.classList.remove('ml-64');
                main.classList.add('ml-24');
                document.querySelectorAll('.menu-text').forEach(el => el.classList.add('hidden'));
            } else {
                sidebar.classList.remove('w-24');
                sidebar.classList.add('w-64');
                main.classList.remove('ml-24');
                main.classList.add('ml-64');
                document.querySelectorAll('.menu-text').forEach(el => el.classList.remove('hidden'));
            }
        }

        applySidebar(localStorage.getItem('sidebar') || 'open');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const newState = sidebar.classList.contains('w-24') ? 'open' : 'collapsed';
                localStorage.setItem('sidebar', newState);
                applySidebar(newState);
            });
        }

        function toggleSection(section) {
            const el = document.getElementById('section-' + section);
            const icon = document.getElementById('icon-' + section);

            if (!el || !icon) return;

            if (el.style.display === 'none') {
                el.style.display = 'block';
                icon.innerText = '▾';
                localStorage.setItem('section-' + section, 'open');
            } else {
                el.style.display = 'none';
                icon.innerText = '▸';
                localStorage.setItem('section-' + section, 'closed');
            }
        }

        ['master', 'operations', 'reports'].forEach(section => {
            const state = localStorage.getItem('section-' + section);
            const el = document.getElementById('section-' + section);
            const icon = document.getElementById('icon-' + section);

            if (state === 'closed' && el && icon) {
                el.style.display = 'none';
                icon.innerText = '▸';
            }
        });
    </script>
</body>

</html>