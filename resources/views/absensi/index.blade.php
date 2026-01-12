@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Laporan Absensi</h1>

    <form method="POST" action="{{ route('absensi.index') }}">
        @csrf

        {{-- FILTER CABANG --}}
        <select name="cabang_gedung" class="form-control mb-2">
    <option value="">-- Pilih Cabang --</option>
    @foreach($cabangGedungs as $cabang)
        <option value="{{ $cabang->id }}"
            {{ request('cabang_gedung') == $cabang->id ? 'selected' : '' }}>
            {{ $cabang->lokasi }}
        </option>
    @endforeach
</select>

        {{-- FILTER TANGGAL --}}
        <div class="row">
            <div class="col-md-4">
                <input
                    type="date"
                    name="awal"
                    class="form-control"
                    value="{{ request('awal') }}"
                    required
                >
            </div>

            <div class="col-md-4">
                <input
                    type="date"
                    name="akhir"
                    class="form-control"
                    value="{{ request('akhir') }}"
                    required
                >
            </div>
        </div>

        {{-- FILTER KATEGORI --}}
        <select name="kategori" class="form-control mt-2">
            <option value="">Semua Kategori</option>
            <option value="1" {{ request('kategori') == 1 ? 'selected' : '' }}>Masuk</option>
            <option value="2" {{ request('kategori') == 2 ? 'selected' : '' }}>Istirahat Mulai</option>
            <option value="3" {{ request('kategori') == 3 ? 'selected' : '' }}>Istirahat Selesai</option>
            <option value="4" {{ request('kategori') == 4 ? 'selected' : '' }}>Pulang</option>
        </select>

        <button class="btn btn-success mt-3">Tampilkan</button>
    </form>

    {{-- TABEL --}}
    <table id="example1" class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Absen</th>
                <th>Nama</th>
                <th>Nomor Induk</th>
                <th>Cabang</th>
                <th>Kategori</th>
                <th>ID Mesin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensis as $a)
                <tr>
                    <td>{{ $a->absen }}</td>
                    <td>{{ $a->pengguna->nama ?? '-' }}</td>
                    <td>{{ $a->nomor_induk }}</td>
                    <td>{{ $a->pengguna->cabangGedung->lokasi ?? '-' }}
                    </td>

                    <td>
                        @switch($a->kategori)
                            @case(1) Masuk @break
                            @case(2) Mulai Istirahat @break
                            @case(3) Selesai Istirahat @break
                            @case(4) Pulang @break
                            @default -
                        @endswitch
                    </td>
                    <td>{{ $a->idmesin }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
