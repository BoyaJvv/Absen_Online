@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-6">
    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Rekap Absensi
            <span class="text-blue-600">{{ $pengguna->nama }}</span>
        </h1>
        <p class="text-gray-600 mt-2">
            Nomor Induk: {{ $pengguna->nomor_induk }} | 
            Cabang: {{ $cabang->lokasi ?? '-' }}
        </p>
    </div>

    {{-- FILTER FORM --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-8">
        <form method="GET" action="{{ route('absensi.pengguna', $pengguna->nomor_induk) }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                {{-- Tanggal Awal --}}
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Tanggal Awal
                    </label>
                    <input type="date" 
                           name="awal" 
                           value="{{ $firstDay }}"
                           class="w-full h-12 rounded-lg border border-gray-300 px-4 focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Tanggal Akhir --}}
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Tanggal Akhir
                    </label>
                    <input type="date" 
                           name="akhir" 
                           value="{{ $lastDay }}"
                           class="w-full h-12 rounded-lg border border-gray-300 px-4 focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Kategori
                    </label>
                    <select name="kategori"
                            class="w-full h-12 rounded-lg border border-gray-300 px-4 focus:ring-2 focus:ring-blue-500">
                        <option value="0" {{ request('kategori') == '0' ? 'selected' : '' }}>
                            Semua Kategori
                        </option>
                        <option value="1" {{ request('kategori') == '1' ? 'selected' : '' }}>
                            Masuk
                        </option>
                        <option value="2" {{ request('kategori') == '2' ? 'selected' : '' }}>
                            Mulai Istirahat
                        </option>
                        <option value="3" {{ request('kategori') == '3' ? 'selected' : '' }}>
                            Selesai Istirahat
                        </option>
                        <option value="4" {{ request('kategori') == '4' ? 'selected' : '' }}>
                            Pulang
                        </option>
                    </select>
                </div>

                {{-- Submit Button --}}
                <div class="flex items-end">
                    <button type="submit"
                            class="w-full h-12 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                        Tampilkan
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- STATISTICS BOXES - TERLAMBAT/CEPAT --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        {{-- Masuk Terlambat --}}
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-sign-in-alt text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Masuk</h3>
                    <p class="text-sm text-gray-600">Total menit terlambat</p>
                </div>
            </div>
            <p class="text-2xl font-bold text-red-600">
                {{ $statistics['terlambatMasuk'] }} <span class="text-lg">Menit</span>
            </p>
        </div>

        {{-- Mulai Istirahat Cepat --}}
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-utensils text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Mulai Istirahat</h3>
                    <p class="text-sm text-gray-600">Total menit cepat</p>
                </div>
            </div>
            <p class="text-2xl font-bold text-red-600">
                {{ $statistics['cepatIstirahatMulai'] }} <span class="text-lg">Menit</span>
            </p>
        </div>

        {{-- Selesai Istirahat Cepat --}}
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-laptop-house text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Selesai Istirahat</h3>
                    <p class="text-sm text-gray-600">Total menit cepat</p>
                </div>
            </div>
            <p class="text-2xl font-bold text-red-600">
                {{ $statistics['cepatIstirahatSelesai'] }} <span class="text-lg">Menit</span>
            </p>
        </div>

        {{-- Pulang Cepat --}}
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-sign-out-alt text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Pulang</h3>
                    <p class="text-sm text-gray-600">Total menit cepat</p>
                </div>
            </div>
            <p class="text-2xl font-bold text-red-600">
                {{ $statistics['cepatPulang'] }} <span class="text-lg">Menit</span>
            </p>
        </div>
    </div>

    {{-- STATISTICS BOXES - TEPAT WAKTU --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        {{-- Masuk Tepat --}}
        <div class="bg-green-50 border border-green-200 rounded-xl p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                    <i class="fa fa-sign-in-alt text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Masuk</h3>
                    <p class="text-sm text-gray-600">Total menit tepat</p>
                </div>
            </div>
            <p class="text-2xl font-bold text-green-600">
                {{ $statistics['tepatMasuk'] }} <span class="text-lg">Menit</span>
            </p>
        </div>

        {{-- Mulai Istirahat Tepat --}}
        <div class="bg-green-50 border border-green-200 rounded-xl p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-utensils text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Mulai Istirahat</h3>
                    <p class="text-sm text-gray-600">Total menit tepat</p>
                </div>
            </div>
            <p class="text-2xl font-bold text-green-600">
                {{ $statistics['tepatIstirahatMulai'] }} <span class="text-lg">Menit</span>
            </p>
        </div>

        {{-- Selesai Istirahat Tepat --}}
        <div class="bg-green-50 border border-green-200 rounded-xl p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-laptop-house text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Selesai Istirahat</h3>
                    <p class="text-sm text-gray-600">Total menit tepat</p>
                </div>
            </div>
            <p class="text-2xl font-bold text-green-600">
                {{ $statistics['tepatIstirahatSelesai'] }} <span class="text-lg">Menit</span>
            </p>
        </div>

        {{-- Pulang Tepat --}}
        <div class="bg-green-50 border border-green-200 rounded-xl p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-sign-out-alt text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Pulang</h3>
                    <p class="text-sm text-gray-600">Total menit tepat</p>
                </div>
            </div>
            <p class="text-2xl font-bold text-green-600">
                {{ $statistics['tepatPulang'] }} <span class="text-lg">Menit</span>
            </p>
        </div>
    </div>

    {{-- TABLE ABSENSI dengan pagination --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-800 text-gray-100">
                    <tr>
                        <th class="px-6 py-4 border border-gray-700">Absen</th>
                        <th class="px-6 py-4 border border-gray-700">Batas</th>
                        <th class="px-6 py-4 border border-gray-700">Selisih</th>
                        <th class="px-6 py-4 border border-gray-700">Status</th>
                        <th class="px-6 py-4 border border-gray-700">Cabang</th>
                        <th class="px-6 py-4 border border-gray-700">Kategori</th>
                        <th class="px-6 py-4 border border-gray-700">ID Mesin</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $perPage = 10;
                        $currentPage = request()->get('page', 1);
                        $total = count($absensis);
                        $absensisPaginated = collect($absensis)->forPage($currentPage, $perPage);
                    @endphp
                    
                    @forelse($absensisPaginated as $absensi)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 border {{ $absensi->warna }}">
                                    {{ $absensi->display_absen ?? ($absensi->absen_at ?? '-') }}
                                </td>
                                <td class="px-6 py-4 border">
                                    {{ $absensi->display_batas ?? '-' }}
                                </td>
                                <td class="px-6 py-4 border {{ $absensi->warna }}">
                                    {{ $absensi->selisih_menit !== null ? $absensi->selisih_menit . ' Menit' : '-' }}
                                </td>
                                <td class="px-6 py-4 border text-center">
                                    @if(is_null($absensi->status))
                                        <span class="px-3 py-1 rounded-full bg-gray-200 text-gray-700 font-semibold">-</span>
                                    @elseif(($absensi->status ?? '') === 'tepat')
                                        <span class="px-3 py-1 rounded-full bg-green-600 text-white font-semibold">{{ $absensi->status_label ?? 'Tepat Waktu' }}</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-red-600 text-white font-semibold">{{ $absensi->status_label ?? 'Terlambat' }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border">
                                    {{ $cabang->lokasi ?? '-' }}
                                </td>
                                <td class="px-6 py-4 border">
                                    {{ $absensi->kategori_label ?? '-' }}
                                </td>
                                <td class="px-6 py-4 border">
                                    {{ $absensi->idmesin }}
                                </td>
                            </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-500">
                                Tidak ada data absensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            {{-- Pagination --}}
            @if($total > $perPage)
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Menampilkan {{ (($currentPage - 1) * $perPage) + 1 }} sampai {{ min($currentPage * $perPage, $total) }} dari {{ $total }} data
                        </div>
                        <div class="flex space-x-2">
                            @if($currentPage > 1)
                                <a href="?page={{ $currentPage - 1 }}&{{ http_build_query(request()->except('page')) }}"
                                   class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                                    Sebelumnya
                                </a>
                            @endif
                            
                            @for($i = 1; $i <= ceil($total / $perPage); $i++)
                                <a href="?page={{ $i }}&{{ http_build_query(request()->except('page')) }}"
                                   class="px-3 py-1 rounded-lg {{ $i == $currentPage ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                                    {{ $i }}
                                </a>
                            @endfor
                            
                            @if($currentPage < ceil($total / $perPage))
                                <a href="?page={{ $currentPage + 1 }}&{{ http_build_query(request()->except('page')) }}"
                                   class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                                    Selanjutnya
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- TANPA ABSEN TABLES tanpa scroll --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        {{-- Tanpa Absen Masuk --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="border-b border-gray-200 px-6 py-4">
                <h3 class="font-bold text-gray-800">Tanpa Absen Masuk</h3>
            </div>
            <div class="p-4">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left border-b">Tanggal</th>
                            <th class="px-4 py-3 text-left border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tanpaAbsen['masuk'] as $item)
                            <tr>
                                <td class="px-4 py-3 border-b {{ $item['warna'] }}">
                                    {{ $item['tanggal'] }}
                                </td>
                                <td class="px-4 py-3 border-b {{ $item['warna'] }}">
                                    {{ $item['keterangan'] }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-8 text-gray-500 border-b">
                                    Semua hari tercatat
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tanpa Absen Mulai Istirahat --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="border-b border-gray-200 px-6 py-4">
                <h3 class="font-bold text-gray-800">Tanpa Absen Mulai Istirahat</h3>
            </div>
            <div class="p-4">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left border-b">Tanggal</th>
                            <th class="px-4 py-3 text-left border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tanpaAbsen['mulai'] as $item)
                            <tr>
                                <td class="px-4 py-3 border-b {{ $item['warna'] }}">
                                    {{ $item['tanggal'] }}
                                </td>
                                <td class="px-4 py-3 border-b {{ $item['warna'] }}">
                                    {{ $item['keterangan'] }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-8 text-gray-500 border-b">
                                    Semua hari tercatat
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tanpa Absen Selesai Istirahat --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="border-b border-gray-200 px-6 py-4">
                <h3 class="font-bold text-gray-800">Tanpa Absen Selesai Istirahat</h3>
            </div>
            <div class="p-4">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left border-b">Tanggal</th>
                            <th class="px-4 py-3 text-left border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tanpaAbsen['selesai'] as $item)
                            <tr>
                                <td class="px-4 py-3 border-b {{ $item['warna'] }}">
                                    {{ $item['tanggal'] }}
                                </td>
                                <td class="px-4 py-3 border-b {{ $item['warna'] }}">
                                    {{ $item['keterangan'] }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-8 text-gray-500 border-b">
                                    Semua hari tercatat
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tanpa Absen Pulang --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="border-b border-gray-200 px-6 py-4">
                <h3 class="font-bold text-gray-800">Tanpa Absen Pulang</h3>
            </div>
            <div class="p-4">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left border-b">Tanggal</th>
                            <th class="px-4 py-3 text-left border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tanpaAbsen['pulang'] as $item)
                            <tr>
                                <td class="px-4 py-3 border-b {{ $item['warna'] }}">
                                    {{ $item['tanggal'] }}
                                </td>
                                <td class="px-4 py-3 border-b {{ $item['warna'] }}">
                                    {{ $item['keterangan'] }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-8 text-gray-500 border-b">
                                    Semua hari tercatat
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Tambahkan sedikit ruang di bagian bawah card tanpa absen */
    .bg-white.rounded-xl {
        display: flex;
        flex-direction: column;
        min-height: 300px; /* Atur tinggi minimum */
    }
    
    .bg-white.rounded-xl .p-4 {
        flex: 1;
    }
    
    .bg-white.rounded-xl table {
        height: 100%;
    }
</style>
@endpush
@endsection