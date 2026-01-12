<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    {{-- BOOTSLANDER INLINE CSS --}}
    <style>
        :root {
            --accent: #1acc8d;
            --blue-1: #08005e;
            --blue-2: #10058c;
            --bg-light: #f4f5fe;
        }

        .bootslander-sidebar {
            background: linear-gradient(180deg, var(--blue-1), var(--blue-2));
        }

        .bootslander-active {
            background-color: var(--accent);
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="w-64 text-white flex flex-col bootslander-sidebar">

            {{-- LOGO --}}
            <div class="p-4 text-center border-b border-white/10">
                <img src="{{ asset('storage/logo/neper.png') }}" class="mx-auto w-24">
            </div>

            {{-- USER --}}
            <div class="p-4 text-center border-b border-white/10">
                <p class="text-sm opacity-80">Login sebagai</p>
                <p class="font-semibold">
                    {{ auth()->user()->nama ?? 'User' }}
                </p>
            </div>

            {{-- MENU --}}
            <nav class="flex-1 px-3 py-4 text-sm space-y-1">

                <a href="{{ url('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded hover:bg-white/10 bootslander-active">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>

                <a href="{{ url('pengguna') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded hover:bg-white/10">
                    <i class="bi bi-person"></i>
                    Pengguna
                </a>

                <a href="{{ url('absensi') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded hover:bg-white/10">
                    <i class="bi bi-card-checklist"></i>
                    Absensi
                </a>

                <a href="{{ url('cuti') }}" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-white/10">
                    <i class="bi bi-calendar-event"></i>
                    Cuti
                </a>

                <a href="{{ url('libur_khusus') }}" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-white/10">
                    <i class="bi bi-globe"></i>
                    Tanggal Libur Khusus
                </a>

                <a href="{{ url('pages/mesin/mesin_absensi.php') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded hover:bg-white/10">
                    <i class="bi bi-hdd-network"></i>
                    Mesin Absensi
                </a>

                {{-- PENGATURAN --}}
                <details class="group mt-1">
                    <summary
                        class="flex items-center justify-between px-4 py-2 rounded cursor-pointer hover:bg-white/10">
                        <span class="flex items-center gap-3">
                            <i class="bi bi-gear"></i>
                            Pengaturan
                        </span>
                        <i class="bi bi-chevron-down transition group-open:rotate-180"></i>
                    </summary>

                    <div class="ml-6 mt-1 space-y-1">
                        <a href="{{ url('jabatan') }}" class="block px-4 py-2 rounded hover:bg-white/10">
                            Jabatan / Status
                        </a>
                        <a href="{{ route('cabang-gedung.index') }}" class="block px-4 py-2 rounded hover:bg-white/10">
                            Cabang / Gedung
                        </a>

                        <a href="{{ url('pages/denda') }}" class="block px-4 py-2 rounded hover:bg-white/10">
                            Denda
                        </a>
                        <a href="{{ url('pages/sistem') }}" class="block px-4 py-2 rounded hover:bg-white/10">
                            Sistem
                        </a>
                    </div>
                </details>

            </nav>

            {{-- LOGOUT --}}
            <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="w-full bg-red-600 hover:bg-red-700 py-2 rounded flex items-center justify-center gap-2">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            </div>

        </aside>

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col">

            {{-- NAVBAR --}}
            <header class="bg-white shadow px-6 py-4">
                <h1 class="text-xl font-semibold text-gray-700">
                    @yield('title')
                </h1>
            </header>

            {{-- CONTENT --}}
            <main class="flex-1 p-6 bg-[var(--bg-light)]">
                @yield('content')
            </main>

            {{-- FOOTER --}}
            <footer class="bg-white text-center py-3 text-sm text-gray-500">
                © {{ date('Y') }} Absensi Online
            </footer>

        </div>
    </div>
</body>

</html>
