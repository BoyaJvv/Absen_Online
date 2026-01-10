@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('libur_khusus.index') }}"
           class="inline-flex items-center gap-2 rounded bg-gray-200 px-4 py-2 text-sm hover:bg-gray-300">
            <i class="bi bi-arrow-left"></i>
            Batal
        </a>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded shadow border border-blue-300">
        <div class="border-b border-blue-300 px-6 py-4 bg-blue-50">
            <h3 class="text-lg font-semibold text-blue-700">
                Ubah Tanggal Libur Khusus
            </h3>
        </div>

        {{-- FORM --}}
        <form method="POST" action="{{ route('libur_khusus.update', $liburKhusus->id) }}">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-5">

                {{-- Tanggal --}}
                <div>
                    <label class="block mb-1 font-medium">
                        Tanggal
                    </label>
                    <input type="date"
                           name="tanggal"
                           value="{{ old('tanggal', $liburKhusus->tanggal) }}"
                           required
                           class="w-full rounded border px-3 py-2 focus:ring focus:ring-blue-200">
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block mb-1 font-medium">
                        Keterangan
                    </label>
                    <textarea name="keterangan"
                              rows="3"
                              class="w-full rounded border px-3 py-2 focus:ring focus:ring-blue-200"
                              placeholder="Keterangan libur">{{ old('keterangan', $liburKhusus->keterangan) }}</textarea>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="border-t bg-gray-50 px-6 py-4 text-right">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700">
                    <i class="bi bi-pencil-square"></i>
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
