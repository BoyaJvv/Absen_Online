@extends('layouts.app')

@section('title', 'Cabang Gedung')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    {{-- HEADER --}}
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-700">Cabang Gedung</h2>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ url('/cabang-gedung') }}" method="POST"
          class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-6">
        @csrf

        <div class="md:col-span-3">
            <label class="block text-sm text-gray-600 mb-1">Lokasi</label>
            <input type="text" name="lokasi"
                   class="w-full rounded border-gray-300 focus:ring focus:ring-blue-200"
                   required>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm text-gray-600 mb-1">Jam Masuk</label>
            <input type="time" name="jam_masuk"
                   class="w-full rounded border-gray-300"
                   required>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm text-gray-600 mb-1">Jam Pulang</label>
            <input type="time" name="jam_pulang"
                   class="w-full rounded border-gray-300"
                   required>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm text-gray-600 mb-1">Istirahat Mulai</label>
            <input type="time" name="istirahat_mulai"
                   class="w-full rounded border-gray-300"
                   required>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm text-gray-600 mb-1">Istirahat Selesai</label>
            <input type="time" name="istirahat_selesai"
                   class="w-full rounded border-gray-300"
                   required>
        </div>

        <div class="md:col-span-1">
            <label class="block text-sm text-gray-600 mb-1">Hari Libur</label>
            <input type="text" name="hari_libur"
                   class="w-full rounded border-gray-300"
                   placeholder="0,6">
        </div>

        <div class="md:col-span-12">
            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                Simpan
            </button>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-left">ID</th>
                    <th class="border px-3 py-2 text-left">Lokasi</th>
                    <th class="border px-3 py-2">Jam Masuk</th>
                    <th class="border px-3 py-2">Jam Pulang</th>
                    <th class="border px-3 py-2">Istirahat</th>
                    <th class="border px-3 py-2">Hari Libur</th>
                    <th class="border px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                <tr class="hover:bg-gray-50">
                    <td class="border px-3 py-2">{{ $row->id }}</td>
                    <td class="border px-3 py-2">{{ $row->lokasi }}</td>
                    <td class="border px-3 py-2 text-center">{{ $row->jam_masuk }}</td>
                    <td class="border px-3 py-2 text-center">{{ $row->jam_pulang }}</td>
                    <td class="border px-3 py-2 text-center">
                        {{ $row->istirahat_mulai }} - {{ $row->istirahat_selesai }}
                    </td>
                    <td class="border px-3 py-2 text-center">{{ $row->hari_libur }}</td>
                    <td class="border px-3 py-2 text-center">
                        <form action="{{ url('/cabang-gedung/'.$row->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                onclick="return confirm('Hapus data?')"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
