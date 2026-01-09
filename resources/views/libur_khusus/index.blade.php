@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        {{-- TITLE --}}
        <h1 class="text-2xl font-bold mb-6">Tanggal Libur Khusus</h1>

        {{-- ALERT --}}
        @foreach (['successAdd', 'successEdit', 'successDelete'] as $msg)
            @if (session($msg))
                <div
                    class="mb-4 rounded border px-4 py-3
                {{ $msg == 'successAdd' ? 'bg-green-100 border-green-300 text-green-700' : '' }}
                {{ $msg == 'successEdit' ? 'bg-blue-100 border-blue-300 text-blue-700' : '' }}
                {{ $msg == 'successDelete' ? 'bg-yellow-100 border-yellow-300 text-yellow-700' : '' }}">
                    {{ session($msg) }}
                </div>
            @endif
        @endforeach

        {{-- SEARCH --}}
        <div class="mb-4 flex justify-between items-center">
            <form method="GET" action="{{ route('libur_khusus.index') }}" class="flex gap-2">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari tanggal / keterangan..."
                        class="border rounded pl-10 pr-3 py-2 focus:ring focus:ring-blue-200">
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <i class="bi bi-search"></i>
                    </span>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Cari
                </button>

                {{-- RESET --}}
                @if (request()->filled('search'))
                    <a href="{{ route('libur_khusus.index') }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 flex items-center gap-1">
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset
                    </a>
                @endif
            </form>
        </div>


        {{-- TABLE --}}
        <div class="bg-white shadow rounded mb-8 overflow-x-auto">
            <table class="min-w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left">Tanggal</th>
                        <th class="border px-4 py-2 text-left">Keterangan</th>
                        <th class="border px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">
                                {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ $row->keterangan }}
                            </td>
                            <td class="border px-4 py-2 text-center space-x-3">
                                <a href="{{ route('libur_khusus.edit', $row->id) }}"
                                    class="text-blue-600 hover:text-blue-800">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('libur_khusus.destroy', $row->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800">
                                        <i class="bi bi-dash-circle"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">
                                Data tidak ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- FORM TAMBAH --}}
        <div class="bg-white shadow rounded p-6 max-w-xl">
            <h3 class="text-lg font-semibold mb-4">Data Baru</h3>

            <form method="POST" action="{{ route('libur_khusus.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Tanggal</label>
                    <input type="date" name="tanggal"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Keterangan</label>
                    <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                        placeholder="Keterangan libur"></textarea>
                </div>

                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Tambah
                </button>
            </form>
        </div>

    </div>
@endsection
