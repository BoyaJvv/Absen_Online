@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">

    <h1 class="text-2xl font-bold mb-4">Data Cuti</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow rounded mb-6 overflow-x-auto">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Nomor Induk</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Tanggal</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cuti as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $item->id }}</td>
                    <td class="border px-4 py-2">{{ $item->nomor_induk }}</td>
                    <td class="border px-4 py-2">{{ $item->pengguna->nama ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td class="border px-4 py-2 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('cuti.edit', $item->id) }}" 
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>
                            <form action="{{ route('cuti.destroy', $item->id) }}" method="POST" 
                                  onsubmit="return confirm('Yakin hapus cuti ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="bg-white shadow rounded p-6">
        <h2 class="text-lg font-semibold mb-4">Tambah Cuti</h2>

        <form method="POST" action="{{ route('cuti.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium">Pilih Karyawan</label>
                <select name="nomor_induk" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($penggunaList as $pengguna)
                        <option value="{{ $pengguna->nomor_induk }}" 
                            {{ old('nomor_induk') == $pengguna->nomor_induk ? 'selected' : '' }}>
                            {{ $pengguna->nomor_induk }} - {{ $pengguna->nama }}
                        </option>
                    @endforeach
                </select>
                @error('nomor_induk')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Tanggal Cuti</label>
                <input type="date" name="tanggal" 
                       class="w-full border rounded px-3 py-2" 
                       value="{{ old('tanggal', date('Y-m-d')) }}" 
                       min="{{ date('Y-m-d') }}" 
                       required>
                @error('tanggal')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Tambah Cuti
                </button>
                <a href="{{ route('cuti.index') }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection