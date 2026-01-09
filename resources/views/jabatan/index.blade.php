@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <h1 class="text-2xl font-bold mb-6">Jabatan / Status</h1>

        {{-- ALERT --}}
        @if (session('successAdd'))
            <div class="mb-4 rounded bg-green-100 border border-green-400 px-4 py-3 text-green-700">
                <b>{{ session('successAdd') }}</b> sudah ditambahkan.
            </div>
        @endif

        @if (session('successToggle'))
            <div class="mb-4 rounded bg-yellow-100 border border-yellow-400 px-4 py-3 text-yellow-700">
                Status <b>{{ session('successToggle') }}</b> menjadi <b>{{ session('aktifText') }}</b>.
            </div>
        @endif

        {{-- SEARCH --}}
        <div class="mb-4 flex justify-between items-center">
            <form method="GET" action="{{ route('jabatan.index') }}" class="flex gap-2">
                <div class="relative">
                    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari jabatan..."
                        class="border rounded pl-10 pr-3 py-2 focus:ring focus:ring-blue-200">
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <i class="bi bi-search"></i>
                    </span>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Cari
                </button>

                @if (!empty($search))
                    <a href="{{ route('jabatan.index') }}" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">
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
                        <th class="border px-4 py-2">Jabatan / Status</th>
                        <th class="border px-4 py-2">Hak Akses</th>
                        <th class="border px-4 py-2">Aktif</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr class="text-center hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $row->jabatan_status }}</td>
                            <td class="border px-4 py-2">
                                {{ $row->hak_akses == 1 ? 'Full' : 'General' }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ $row->aktif ? 'Aktif' : 'Non-aktif' }}
                            </td>
                            <td class="border px-4 py-2 text-center space-x-3">
                                <a href="{{ route('jabatan.edit', $row->id) }}" class="text-blue-600 hover:text-blue-800"
                                    title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <a href="{{ route('jabatan.toggle', $row->id) }}" class="text-red-600 hover:text-red-800"
                                    title="Aktif / Nonaktif">
                                    <i class="bi bi-dash-circle"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- FORM TAMBAH --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">Data Baru</h3>

            <form method="POST" action="{{ route('jabatan.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Jabatan / Status</label>
                    <input type="text" name="jabatan_status"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Hak Akses</label>
                    <select name="hak_akses" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
                        <option value="1">Full</option>
                        <option value="2">General</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Tambah
                </button>
            </form>
        </div>

    </div>
@endsection
