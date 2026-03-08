@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Denda</h1>
        <p class="text-sm text-gray-500 mt-1">
            Buat kategori aturan denda baru untuk sistem absensi
        </p>
    </div>

    {{-- Card --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8">

        <form action="{{ route('denda.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Prioritas --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Urutan / Prioritas
                    </label>

                    <input
                        type="number"
                        name="prioritas"
                        required
                        value="{{ old('prioritas') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('prioritas') border-red-500 @enderror">

                    @error('prioritas')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jenis Denda
                    </label>

                    <input
                        type="text"
                        name="jenis"
                        required
                        value="{{ old('jenis') }}"
                        placeholder="Contoh: Terlambat Masuk"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                {{-- Rupiah Pertama --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nominal Pertama (Rp)
                    </label>

                    <input
                        type="number"
                        name="rupiah_pertama"
                        required
                        value="{{ old('rupiah_pertama') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                {{-- Per Menit --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Interval (Menit)
                    </label>

                    <input
                        type="number"
                        name="per_menit"
                        value="{{ old('per_menit') }}"
                        placeholder="Kosongkan jika flat"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                {{-- Rupiah Selanjutnya --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nominal Selanjutnya (Rp)
                    </label>

                    <input
                        type="number"
                        name="rupiah_selanjutnya"
                        value="{{ old('rupiah_selanjutnya') }}"
                        placeholder="Kosongkan jika flat"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                    <p class="text-xs text-gray-400 mt-2">
                        *Gunakan Interval dan Nominal Selanjutnya untuk denda progresif / berulang.
                    </p>
                </div>

            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">

                <a href="{{ route('denda.index') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800">
                    Batal
                </a>

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold shadow-sm transition">
                    Simpan 
                </button>

            </div>

        </form>

    </div>

</div>
@endsection