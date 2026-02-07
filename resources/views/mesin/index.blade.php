@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">Daftar Mesin</h3>

    {{-- ===== DESKTOP TABLE ===== --}}
    <div class="d-none d-md-block">
        <div class="bg-white rounded shadow border p-4 mb-5 overflow-visible mb-12 p-6">
            <div class="table-responsive">
                <table id="mesinTable" class="table table-bordered align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Kode Mesin</th>
                            <th>Cabang</th>
                            <th>Keterangan</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mesin as $row)
                        <tr>
                            <td>{{ $row->id_mesin }}</td>
                            <td>{{ $row->idmesin }}</td>
                            <td>{{ $row->cabangGedung->lokasi ?? '-' }}</td>
                            <td>{{ $row->keterangan }}</td>
                            <td>
                                <a href="{{ route('mesin.edit', $row->id_mesin) }}"
                                   class="btn btn-sm btn-primary w-100">
                                    Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ===== MOBILE CARD ===== --}}
    <div class="d-block d-md-none">
        @foreach ($mesin as $row)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="mb-1"><strong>ID Mesin:</strong> {{ $row->id_mesin }}</div>
                <div class="mb-1"><strong>Kode Mesin:</strong> {{ $row->idmesin }}</div>
                <div class="mb-1"><strong>Cabang:</strong> {{ $row->cabangGedung->lokasi ?? '-' }}</div>
                <div class="mb-3"><strong>Keterangan:</strong> {{ $row->keterangan }}</div>

                <a href="{{ route('mesin.edit', $row->id_mesin) }}"
                   class="btn btn-primary btn-sm w-100">
                    Edit
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <hr class="my-4">

    {{-- ===== FORM ===== --}}
    <h4 class="mb-3">{{ $editData ? 'Ubah Mesin' : 'Tambah Mesin' }}</h4>

    <form method="POST"
          action="{{ $editData ? route('mesin.update', $editData->id_mesin) : route('mesin.store') }}">
        @csrf
        @if($editData) @method('PUT') @endif

        <div class="mb-3">
            <label class="form-label">Kode Mesin</label>
            <input type="string" name="idmesin" class="form-control"
                   value="{{ $editData->idmesin ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cabang Gedung</label>
            <select name="id_cabang_gedung" class="form-select" required>
                @foreach ($cabang as $c)
                <option value="{{ $c->id }}"
                    {{ $editData && $editData->id_cabang_gedung == $c->id ? 'selected' : '' }}>
                    {{ $c->lokasi }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control"
                   value="{{ $editData->keterangan ?? '' }}" required>
        </div>

        <button class="btn btn-success">
            {{ $editData ? 'Simpan Perubahan' : 'Simpan' }}
        </button>
    </form>

</div>
@endsection


@push('styles')
<style>
.dataTables_wrapper {
    padding-bottom: 1.5rem;
}

.dataTables_filter,
.dt-buttons {
    margin-bottom: 1rem;
}

.dataTables_info,
.dataTables_paginate {
    margin-top: 1rem;
}
</style>
@endpush


@push('scripts')
<script>
$(document).ready(function () {
    $('#mesinTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']],
        lengthChange: false,

        dom:
            "<'d-flex flex-column flex-md-row justify-content-between align-items-center mb-3'Bf>" +
            "<'table-responsive't>" +
            "<'d-flex flex-column flex-md-row justify-content-between align-items-center mt-3'ip>",

        buttons: [
            'copy',
            'csv',
            'excel',
            'pdf',
            'print',
            {
                extend: 'colvis',
                text: 'Column visibility'
            }
        ],

        language: {
            search: "Cari:",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "‹",
                next: "›"
            },
            zeroRecords: "Data tidak ditemukan"
        }
    });
});
</script>
@endpush
