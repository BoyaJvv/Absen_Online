@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
  :root {
    --accent: #1acc8d;
    --dark-blue: #08005e;
    --dark-blue-2: #10058c;
    --light-bg: #f4f5fe;
  }

  .bootslander-bg {
    background: linear-gradient(135deg, var(--dark-blue), var(--dark-blue-2));
  }

  .bootslander-accent {
    background-color: var(--accent);
  }

  .bootslander-accent:hover {
    background-color: #17b87f;
  }
</style>

<div class="bg-white rounded-xl shadow overflow-hidden">

    {{-- TOP BAR --}}
    <div class="flex items-center gap-2 px-4 py-2 text-white bootslander-bg">

        {{-- Dropdown Tutup --}}
        <div class="relative group">
            <button class="flex items-center gap-1 bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">
                <i class="bi bi-x-circle"></i>
                Tutup
            </button>

            <div class="absolute left-0 mt-1 hidden group-hover:block bg-white border rounded shadow text-sm w-48 z-10 text-gray-700">
                <button class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                    Tutup Semua
                </button>
                <button class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                    Tutup Yang Lainnya
                </button>
            </div>
        </div>

        {{-- Scroll Left --}}
        <button class="px-3 py-1 bg-white/20 rounded hover:bg-white/30">
            <i class="bi bi-chevron-left"></i>
        </button>

        {{-- Tab placeholder --}}
        <div class="flex-1 overflow-hidden text-sm opacity-80">
            {{-- tab placeholder --}}
        </div>

        {{-- Scroll Right --}}
        <button class="px-3 py-1 bg-white/20 rounded hover:bg-white/30">
            <i class="bi bi-chevron-right"></i>
        </button>

        {{-- Fullscreen --}}
        <button class="px-3 py-1 bg-white/20 rounded hover:bg-white/30">
            <i class="bi bi-arrows-fullscreen"></i>
        </button>
    </div>

    {{-- CONTENT --}}
    <div class="p-12 text-center bg-[var(--light-bg)]">

        {{-- EMPTY STATE --}}
        <div>
            <h2 class="text-4xl font-bold text-gray-700 mb-3">
                Selamat Datang
            </h2>
            <p class="text-gray-500">
                Silakan pilih menu di sidebar untuk mulai bekerja
            </p>
        </div>

        {{-- LOADING STATE --}}
        <div class="hidden mt-8">
            <h2 class="text-3xl font-semibold text-gray-500 flex justify-center items-center gap-2">
                Mohon tunggu
                <i class="bi bi-arrow-repeat animate-spin"></i>
            </h2>
        </div>

        {{-- ACTION --}}
        <div class="mt-10">
            <button class="px-6 py-3 rounded-lg text-white font-semibold bootslander-accent shadow inline-flex items-center gap-2">
                <i class="bi bi-play-fill"></i>
                Mulai
            </button>
        </div>

    </div>
</div>
@endsection
