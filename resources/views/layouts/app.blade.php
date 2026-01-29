<!DOCTYPE html>
<html lang="id">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard')</title>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Tailwind CDN (fallback HP / ngrok) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    {{-- Tailwind via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-dark: #0f172a;
            --sidebar-mid: #020617;
            --accent: #2563eb;
            --bg-main: #f8fafc;
        }

        @media (max-width: 1024px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                height: 100vh;
                width: 16rem;
                z-index: 50;
            }

            #sidebar.show {
                left: 0;
            }
        }
    </style>
</head>

<body class="bg-[var(--bg-main)] text-gray-800">

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside id="sidebar"
            class="w-64 bg-gradient-to-b from-[var(--sidebar-dark)] to-[var(--sidebar-mid)]
        text-white flex flex-col transition-all duration-300">

            <div class="p-4 text-center border-b border-white/10">
                <img src="{{ asset('storage/logo/neper.png') }}" class="mx-auto w-20">
            </div>

            <div class="px-4 py-3 border-b border-white/10 text-center">
                <p class="text-sm opacity-70">Login sebagai</p>
                <p class="font-semibold text-base">
                    {{ auth()->user()?->nama ?? 'User' }}
                </p>
            </div>

            @php
                $user = auth()->user();
                $jabatanStatus = $user->jabatanStatus;
                $hakAkses = $jabatanStatus?->hakAkses;
                $userRole = $hakAkses?->hak;
                $isAdmin = in_array($userRole, ['nusabot', 'full']);
                $isGeneral = $userRole === 'general';
            @endphp

            <nav class="flex-1 px-3 py-4 space-y-1 text-sm text-white">

                {{-- DASHBOARD --}}
                <a href="{{ url('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
              hover:bg-white/10 transition whitespace-nowrap">
                    <i class="bi bi-speedometer2 text-lg w-5 text-center"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>

                {{-- ================= ADMIN (nusabot, full) ================= --}}
                @if ($isAdmin)
                    <a href="{{ url('pengguna') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="bi bi-person text-lg w-5 text-center"></i>
                        <span class="sidebar-text">Pengguna</span>
                    </a>

                    <a href="{{ url('absensi') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="bi bi-card-checklist text-lg w-5 text-center"></i>
                        <span class="sidebar-text">Absensi</span>
                    </a>

                    <a href="{{ url('cuti') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="bi bi-calendar-event text-lg w-5 text-center"></i>
                        <span class="sidebar-text">Cuti</span>
                    </a>

                    <a href="{{ url('libur_khusus') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="bi bi-globe text-lg w-5 text-center"></i>
                        <span class="sidebar-text">Tanggal Libur</span>
                    </a>

                    <a href="{{ url('mesin') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="bi bi-cpu text-lg w-5 text-center"></i>
                        <span class="sidebar-text">Mesin</span>
                    </a>

                    {{-- PENGATURAN --}}
                    <details class="group">
                        <summary
                            class="flex items-center justify-between px-4 py-3 rounded-lg
                       cursor-pointer hover:bg-white/10 transition list-none">
                            <span class="flex items-center gap-3">
                                <i class="bi bi-gear text-lg w-5 text-center"></i>
                                <span class="sidebar-text">Pengaturan</span>
                            </span>
                            <i class="bi bi-chevron-down text-xs transition group-open:rotate-180"></i>
                        </summary>

                        <div class="ml-11 mt-2 space-y-1 text-sm">
                            <a href="{{ url('jabatan') }}" class="block px-2 py-1 rounded hover:bg-white/10">
                                Jabatan
                            </a>
                            <a href="{{ route('cabang-gedung.index') }}"
                                class="block px-2 py-1 rounded hover:bg-white/10">
                                Cabang
                            </a>
                            <a href="{{ route('denda.index') }}" class="block px-2 py-1 rounded hover:bg-white/10">
                                Denda
                            </a>
                        </div>
                    </details>

                {{-- ================= GENERAL USER ================= --}}
                @elseif ($isGeneral)
                    <a href="{{ url('/absensi/pengguna') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="bi bi-clipboard-data text-lg w-5 text-center"></i>
                        <span class="sidebar-text">Rekap Absensi</span>
                    </a>
                @endif

            </nav>


            <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="w-full bg-red-600 hover:bg-red-700 py-2 rounded-lg flex items-center justify-center gap-2">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="sidebar-text">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 hidden z-40 lg:hidden"></div>

        <div class="flex-1 flex flex-col">

            <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="text-xl">
                        <i class="bi bi-list"></i>
                    </button>
                    <h1 class="text-2xl font-semibold text-gray-700">
                        @yield('title')
                    </h1>
                </div>

                <button onclick="toggleFocus()" class="text-xl">
                    <i class="bi bi-arrows-fullscreen"></i>
                </button>
            </header>

            <main class="flex-1 p-6 transition-all">
                @yield('content')
            </main>

            <footer class="bg-white text-center py-3 text-sm text-gray-500">
                © {{ date('Y') }} Absensi Online
            </footer>

            @stack('scripts')
        </div>
    </div>

    <script>
        let collapsed = false;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const texts = document.querySelectorAll('.sidebar-text');

            if (window.innerWidth <= 1024) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('hidden');
                return;
            }

            collapsed = !collapsed;
            sidebar.classList.toggle('w-64');
            sidebar.classList.toggle('w-20');
            texts.forEach(t => t.classList.toggle('hidden'));
        }

        function toggleFocus() {
            document.getElementById('sidebar').classList.toggle('hidden');
        }
    </script>

</body>

</html>
