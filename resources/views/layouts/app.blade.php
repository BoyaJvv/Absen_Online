<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    {{-- Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-dark: #0f172a;
            --sidebar-mid: #020617;
            --accent: #2563eb;
            --bg-main: #f8fafc;
        }
    </style>
</head>

<body class="bg-[var(--bg-main)] text-gray-800">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside id="sidebar"
        class="w-64 bg-gradient-to-b from-[var(--sidebar-dark)] to-[var(--sidebar-mid)]
        text-white flex flex-col transition-all duration-300">

        {{-- LOGO --}}
        <div class="p-4 text-center border-b border-white/10">
            <img src="{{ asset('storage/logo/neper.png') }}" class="mx-auto w-20">
        </div>

        {{-- USER --}}
        <div class="px-4 py-3 border-b border-white/10 text-center">
            <p class="text-sm opacity-70">Login sebagai</p>
            <p class="font-semibold text-base">
                {{ auth()->user()->nama ?? 'User' }}
            </p>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-2 py-4 space-y-1 text-base">

            @php
                $menu = [
                    ['Dashboard','dashboard','bi-speedometer2'],
                    ['Pengguna','pengguna','bi-person'],
                    ['Absensi','absensi','bi-card-checklist'],
                    ['Cuti','cuti','bi-calendar-event'],
                    ['Tanggal Libur','libur_khusus','bi-globe'],
                ];
            @endphp

            @foreach($menu as [$label,$url,$icon])
            <a href="{{ url($url) }}"
               class="flex items-center gap-4 px-4 py-3 rounded-lg
               hover:bg-white/10 transition">
                <i class="bi {{ $icon }} text-lg"></i>
                <span class="sidebar-text">{{ $label }}</span>
            </a>
            @endforeach

            {{-- PENGATURAN --}}
            <details class="group mt-2">
                <summary class="flex items-center justify-between px-4 py-3 rounded-lg cursor-pointer hover:bg-white/10">
                    <span class="flex items-center gap-4">
                        <i class="bi bi-gear text-lg"></i>
                        <span class="sidebar-text">Pengaturan</span>
                    </span>
                    <i class="bi bi-chevron-down transition group-open:rotate-180 sidebar-text"></i>
                </summary>

                <div class="ml-10 mt-2 space-y-1 text-sm">
                    <a href="{{ url('jabatan') }}" class="block py-2 hover:text-blue-400">Jabatan</a>
                    <a href="{{ route('cabang-gedung.index') }}" class="block py-2 hover:text-blue-400">Cabang</a>
                </div>
            </details>

        </nav>

        {{-- LOGOUT --}}
        <div class="p-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-red-600 hover:bg-red-700 py-2 rounded-lg flex items-center justify-center gap-2">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="sidebar-text">Logout</span>
                </button>
            </form>
        </div>

    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- TOPBAR --}}
        <header class="bg-white shadow px-6 py-4 flex items-center justify-between">

            <div class="flex items-center gap-3">
                {{-- Burger --}}
                <button onclick="toggleSidebar()" class="text-xl">
                    <i class="bi bi-list"></i>
                </button>

                <h1 class="text-2xl font-semibold text-gray-700">
                    @yield('title')
                </h1>
            </div>

            {{-- ACTION --}}
            <div class="flex items-center gap-3">
                <button onclick="toggleFocus()" class="text-xl">
                    <i class="bi bi-arrows-fullscreen"></i>
                </button>
            </div>

        </header>

        {{-- CONTENT --}}
        <main id="mainContent" class="flex-1 p-6 transition-all">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="bg-white text-center py-3 text-sm text-gray-500">
            © {{ date('Y') }} Absensi Online
        </footer>

    </div>
</div>

{{-- JS --}}
<script>
    let collapsed = false;
    let hidden = false;

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const texts = document.querySelectorAll('.sidebar-text');

        collapsed = !collapsed;

        if (collapsed) {
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');
            texts.forEach(t => t.classList.add('hidden'));
        } else {
            sidebar.classList.add('w-64');
            sidebar.classList.remove('w-20');
            texts.forEach(t => t.classList.remove('hidden'));
        }
    }

    function toggleFocus() {
        const sidebar = document.getElementById('sidebar');
        hidden = !hidden;

        if (hidden) {
            sidebar.classList.add('hidden');
        } else {
            sidebar.classList.remove('hidden');
        }
    }
</script>

</body>
</html>