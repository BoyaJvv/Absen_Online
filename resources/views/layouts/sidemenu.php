<!-- Sidebar Container -->
<aside id="sidebar" class="fixed top-0 left-0 z-40 h-screen transition-all duration-300 ease-in-out bg-slate-900 border-r border-slate-800 text-slate-300 flex flex-col justify-between w-64 group-[.sidebar-collapsed]:w-20 overflow-y-auto">

    <div>
        <!-- Brand Header (Tanpa Foto/Logo Pecah) -->
        <div class="h-16 flex items-center px-4 border-b border-slate-800/80">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 text-white flex items-center justify-center font-extrabold text-lg shadow-md shadow-blue-500/20 shrink-0">
                    A
                </div>
                <div class="sidebar-text transition-opacity duration-200">
                    <h1 class="font-bold text-white text-base tracking-wide whitespace-nowrap">ABSENSI</h1>
                    <p class="text-[10px] text-blue-400 font-semibold tracking-wider uppercase whitespace-nowrap">Cendekia System</p>
                </div>
            </div>
        </div>

        <!-- User Profile Info (Inisial Nama User) -->
        <div class="p-3 mx-2 my-3 rounded-xl bg-slate-800/50 border border-slate-700/40 flex items-center gap-3 overflow-hidden">
            <div class="w-9 h-9 rounded-lg bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                {{ strtoupper(substr(Auth::user()->nama ?? Auth::user()->name ?? 'A', 0, 2)) }}
            </div>
            <div class="sidebar-text min-w-0 flex-1 transition-opacity duration-200">
                <p class="text-[10px] text-slate-400 font-medium leading-none">Login sebagai</p>
                <p class="text-xs font-semibold text-white truncate mt-1">{{ Auth::user()->nama ?? Auth::user()->name ?? 'Admin' }}</p>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="px-2 space-y-1.5 mt-2">
            
            <!-- 1. Dashboard -->
            <a href="{{ url('pages/dashboard') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->is('pages/dashboard*') || request()->is('dashboard*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-semibold' : 'hover:bg-slate-800/70 hover:text-white' }}"
               title="Dashboard">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="sidebar-text truncate">Dashboard</span>
            </a>

            <!-- 2. Pengguna -->
            <a href="{{ url('pages/pengguna') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->is('pages/pengguna*') || request()->is('pengguna*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-semibold' : 'hover:bg-slate-800/70 hover:text-white' }}"
               title="Pengguna">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span class="sidebar-text truncate">Pengguna</span>
            </a>

            <!-- 3. Absensi -->
            <a href="{{ url('pages/absensi') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->is('pages/absensi*') || request()->is('absensi*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-semibold' : 'hover:bg-slate-800/70 hover:text-white' }}"
               title="Absensi">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                <span class="sidebar-text truncate">Absensi</span>
            </a>

            <!-- 4. Cuti -->
            <a href="{{ url('pages/cuti') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->is('pages/cuti*') || request()->is('cuti*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-semibold' : 'hover:bg-slate-800/70 hover:text-white' }}"
               title="Cuti">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="sidebar-text truncate">Cuti</span>
            </a>

            <!-- 5. Tanggal Libur Khusus -->
            <a href="{{ url('pages/libur') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->is('pages/libur*') || request()->is('libur*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-semibold' : 'hover:bg-slate-800/70 hover:text-white' }}"
               title="Tanggal Libur Khusus">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V11a2 2 0 012-2h1.055"/></svg>
                <span class="sidebar-text truncate">Tanggal Libur Khusus</span>
            </a>

            <!-- 6. Mesin Absensi -->
            <a href="{{ url('pages/mesin/mesin_absensi.php') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->is('pages/mesin*') || request()->is('mesin*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-semibold' : 'hover:bg-slate-800/70 hover:text-white' }}"
               title="Mesin Absensi">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                <span class="sidebar-text truncate">Mesin Absensi</span>
            </a>

            <!-- 7. Dropdown Pengaturan -->
            <div x-data="{ open: {{ request()->is('pages/jabatan*') || request()->is('pages/cabang*') || request()->is('pages/denda*') || request()->is('pages/sistem*') || request()->is('jabatan*') || request()->is('cabang*') || request()->is('denda*') || request()->is('sistem*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                        type="button" 
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 hover:bg-slate-800/70 hover:text-white cursor-pointer"
                        title="Pengaturan">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="sidebar-text truncate">Pengaturan</span>
                    </div>
                    <svg class="w-4 h-4 sidebar-text transition-transform duration-200" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>

                <!-- Submenu Items -->
                <div x-show="open" 
                     x-collapse 
                     class="pl-9 pr-2 py-1 space-y-1 sidebar-text">
                    
                    <a href="{{ url('pages/jabatan') }}" 
                       class="block px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->is('pages/jabatan*') || request()->is('jabatan*') ? 'text-blue-400 font-semibold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800/30' }}">
                       • Jabatan / Status
                    </a>

                    <a href="{{ url('pages/cabang') }}" 
                       class="block px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->is('pages/cabang*') || request()->is('cabang*') ? 'text-blue-400 font-semibold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800/30' }}">
                       • Cabang / Gedung
                    </a>

                    <a href="{{ url('pages/denda') }}" 
                       class="block px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->is('pages/denda*') || request()->is('denda*') ? 'text-blue-400 font-semibold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800/30' }}">
                       • Denda
                    </a>

                    <a href="{{ url('pages/sistem') }}" 
                       class="block px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->is('pages/sistem*') || request()->is('sistem*') ? 'text-blue-400 font-semibold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800/30' }}">
                       • Sistem
                    </a>
                </div>
            </div>

        </nav>
    </div>

    <!-- Bottom Logout Button -->
    <div class="p-3 border-t border-slate-800/80">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center justify-center gap-3 px-3.5 py-2.5 rounded-xl bg-rose-600/10 hover:bg-rose-600 text-rose-400 hover:text-white text-sm font-semibold transition-all duration-200 cursor-pointer"
                    title="Logout">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span class="sidebar-text truncate">Logout</span>
            </button>
        </form>
    </div>

</aside>