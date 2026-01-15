@extends('layouts.app')

@section('content')
<div class="container-fluid px-5 py-6 text-[16px]">

    {{-- HEADER --}}
    <div class="mb-6 flex items-center gap-3">
        <div class="bg-blue-600 text-white p-3 rounded-xl shadow">
            <i class="bi bi-clipboard-data text-2xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Laporan Absensi
            </h1>
            <p class="text-gray-600 text-base">
                Rekap data absensi berdasarkan filter
            </p>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
        <form method="POST" action="{{ route('absensi.index') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Cabang Gedung
                    </label>
                    <select name="cabang_gedung"
                        class="w-full h-12 rounded-xl border border-gray-300 text-base focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Cabang --</option>
                        @foreach($cabangGedungs as $cabang)
                            <option value="{{ $cabang->id }}"
                                {{ request('cabang_gedung') == $cabang->id ? 'selected' : '' }}>
                                {{ $cabang->lokasi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Tanggal Awal
                    </label>
                    <input type="date"
                        name="awal"
                        class="w-full h-12 rounded-xl border border-gray-300 text-base"
                        value="{{ request('awal') }}"
                        required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Tanggal Akhir
                    </label>
                    <input type="date"
                        name="akhir"
                        class="w-full h-12 rounded-xl border border-gray-300 text-base"
                        value="{{ request('akhir') }}"
                        required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Kategori
                    </label>
                    <select name="kategori"
                        class="w-full h-12 rounded-xl border border-gray-300 text-base">
                        <option value="">Semua Kategori</option>
                        <option value="1" {{ request('kategori') == 1 ? 'selected' : '' }}>Masuk</option>
                        <option value="2" {{ request('kategori') == 2 ? 'selected' : '' }}>Istirahat Mulai</option>
                        <option value="3" {{ request('kategori') == 3 ? 'selected' : '' }}>Istirahat Selesai</option>
                        <option value="4" {{ request('kategori') == 4 ? 'selected' : '' }}>Pulang</option>
                    </select>
                </div>

            </div>

            <div class="mt-6 flex justify-end">
                <button
                    class="flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white text-lg px-6 py-3 rounded-xl shadow-lg transition">
                    <i class="bi bi-filter-circle text-xl"></i>
                    Tampilkan Data
                </button>
            </div>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-base border-collapse">
                <thead class="bg-slate-800 text-slate-100">
                    <tr>
                        <th class="px-6 py-4 border border-slate-700">Absen</th>
                        <th class="px-6 py-4 border border-slate-700">Nama</th>
                        <th class="px-6 py-4 border border-slate-700">Nomor Induk</th>
                        <th class="px-6 py-4 border border-slate-700">Cabang</th>
                        <th class="px-6 py-4 border border-slate-700">Kategori</th>
                        <th class="px-6 py-4 border border-slate-700">ID Mesin</th>
                    </tr>
                </thead>


                <tbody>
                    @forelse($absensis as $a)
                        <tr class="hover:bg-blue-50 transition text-gray-800">
                            <td class="px-6 py-4 border font-medium">{{ $a->absen }}</td>
                            <td class="px-6 py-4 border font-semibold">
                                {{ $a->pengguna->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-4 border">{{ $a->nomor_induk }}</td>
                            <td class="px-6 py-4 border">
                                {{ $a->pengguna->cabangGedung->lokasi ?? '-' }}
                            </td>
                            <td class="px-6 py-4 border">
                                @switch($a->kategori)
                                    @case(1)
                                        <span class="px-4 py-2 rounded-full bg-green-600 text-white font-semibold">
                                            Masuk
                                        </span>
                                        @break
                                    @case(2)
                                        <span class="px-4 py-2 rounded-full bg-yellow-500 text-black font-semibold">
                                            Mulai Istirahat
                                        </span>
                                        @break
                                    @case(3)
                                        <span class="px-4 py-2 rounded-full bg-blue-500 text-white font-semibold">
                                            Selesai Istirahat
                                        </span>
                                        @break
                                    @case(4)
                                        <span class="px-4 py-2 rounded-full bg-gray-600 text-white font-semibold">
                                            Pulang
                                        </span>
                                        @break
                                    @default
                                        -
                                @endswitch
                            </td>
                            <td class="px-6 py-4 border">{{ $a->idmesin }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"
                                class="text-center py-10 text-gray-500 text-lg">
                                <i class="bi bi-inbox text-3xl block mb-2"></i>
                                Data tidak ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
