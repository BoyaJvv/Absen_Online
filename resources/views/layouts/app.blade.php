<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-slate-900 text-white flex flex-col">

        {{-- LOGO (dari storage) --}}
        <div class="p-4 text-center border-b border-slate-700">
            <img
                src="{{ asset('storage/logo/neper.png') }}"
                alt="Logo"
                class="mx-auto w-24"
            >
        </div>

        {{-- USER --}}
        <div class="p-4 text-center border-b border-slate-700">
            <p class="text-sm text-gray-300">Login sebagai</p>
            <p class="font-semibold">
                {{ auth()->user()->name ?? 'User' }}
            </p>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 p-4 space-y-2">

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg
               {{ request()->routeIs('dashboard') ? 'bg-orange-500' : 'hover:bg-slate-700' }}">
               
                {{-- icon --}}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h5m4 0h5a1 1 0 001-1V10" />
                </svg>

                <span>Dashboard</span>
            </a>

            {{-- Pengguna --}}
            <a href="#"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-700">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.121 17.804A9 9 0 1119.78 7.22M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>

                <span>Pengguna</span>
            </a>

            {{-- Absensi --}}
            <a href="#"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-700">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>

                <span>Absensi</span>
            </a>

        </nav>

        {{-- LOGOUT --}}
        <div class="p-4 border-t border-slate-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-red-500 hover:bg-red-600 py-2 rounded-lg flex items-center justify-center gap-2">
                    
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
                    </svg>

                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- NAVBAR --}}
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-700">
                @yield('title')
            </h1>

            <button class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Bantuan
            </button>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 p-6">
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
