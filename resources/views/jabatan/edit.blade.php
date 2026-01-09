@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-6">

        {{-- HEADER --}}
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('jabatan.index') }}"
                class="inline-flex items-center gap-2 rounded bg-gray-200 px-4 py-2 text-sm hover:bg-gray-300">
                <i class="bi bi-arrow-left"></i>
                Batal
            </a>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded shadow border border-blue-200">
            <div class="border-b border-blue-200 px-6 py-4 bg-blue-50">
                <h3 class="text-lg font-semibold text-blue-700">
                    Ubah Jabatan / Status
                </h3>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('jabatan.update', $jabatan->id) }}">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-5">

                    {{-- Jabatan --}}
                    <div>
                        <label class="block mb-1 font-medium">
                            Jabatan / Status
                        </label>
                        <input type="text" name="jabatan_status"
                            value="{{ old('jabatan_status', $jabatan->jabatan_status) }}" autofocus required
                            class="w-full rounded border px-3 py-2
                                  focus:ring focus:ring-blue-200
                                  focus:border-blue-400">
                    </div>

                    {{-- Hak Akses --}}
                    <div>
                        <label class="block mb-1 font-medium">
                            Hak Akses
                        </label>
                        <select name="hak_akses"
                            class="w-full rounded border px-3 py-2
                                   focus:ring focus:ring-blue-200
                                   focus:border-blue-400">
                            <option value="1" {{ $jabatan->hak_akses == 1 ? 'selected' : '' }}>
                                Full
                            </option>
                            <option value="2" {{ $jabatan->hak_akses == 2 ? 'selected' : '' }}>
                                General
                            </option>
                        </select>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="border-t bg-gray-50 px-6 py-4 text-right">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded
                               bg-blue-600 px-5 py-2 text-white
                               hover:bg-blue-700">
                        <i class="bi bi-pencil-square"></i>
                        Ubah
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
