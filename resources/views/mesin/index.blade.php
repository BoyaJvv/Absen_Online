@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">Daftar Mesin</h3>

    {{-- ===== DESKTOP TABLE ===== --}}
    <div class="d-none d-md-block">
        <div class="bg-white rounded shadow-lg border p-4 mb-5">
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
                            <td>{{ $row->idmesin }}</td>
                            <td>{{ $row->idmesin }}</td>
                            <td>{{ $row->cabangGedung->lokasi ?? '-' }}</td>
                            <td>{{ $row->keterangan }}</td>
                            <td>
                                <a href="{{ route('mesin.edit', $row->idmesin) }}" class="btn btn-sm btn-primary w-100">
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
        <div class="card mb-3 shadow">
            <div class="card-body">
                <div class="mb-1"><strong>ID Mesin:</strong> {{ $row->idmesin }}</div>
                <div class="mb-1"><strong>Kode Mesin:</strong> {{ $row->idmesin }}</div>
                <div class="mb-1"><strong>Cabang:</strong> {{ $row->cabangGedung->lokasi ?? '-' }}</div>
                <div class="mb-3"><strong>Keterangan:</strong> {{ $row->keterangan }}</div>

                <a href="{{ route('mesin.edit', $row->idmesin) }}" class="btn btn-primary btn-sm w-100">
                    Edit
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <hr class="my-5">

    {{-- ===== FORM EDIT (include) ===== --}}
    @if($editData)
        @include('mesin.edit')
    @endif

    {{-- ===== FORM TAMBAH ===== --}}
    <div class="bg-white rounded shadow-lg border p-4">
        <h4 class="mb-4">Tambah Mesin</h4>

        <form method="POST" action="{{ route('mesin.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Kode Mesin</label>
                <input type="text" name="idmesin" class="form-control" value="" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Cabang Gedung</label>
                <select name="id_cabang_gedung" class="form-select" required>
                    @foreach ($cabang as $c)
                        <option value="{{ $c->id }}">{{ $c->lokasi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <input type="text" name="keterangan" class="form-control" value="" required>
            </div>

            <button class="btn btn-success">Simpan</button>
        </form>
    </div>

</div>
@endsection

@push('styles')
<style>
.dataTables_wrapper { padding-bottom: 1.5rem; }
.dataTables_filter, .dt-buttons { margin-bottom: 1rem; }
.dataTables_info, .dataTables_paginate { margin-top: 1rem; }
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
            { extend: 'copy', title: 'Daftar Mesin' },
            { extend: 'excel', title: 'Daftar Mesin' },
            { extend: 'pdf', title: 'Daftar Mesin' },
            { extend: 'print', title: 'Daftar Mesin' },
            { extend: 'colvis', text: 'Column visibility' }
        ],
        language: {
            search: "Cari:",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: { previous: "‹", next: "›" },
            zeroRecords: "Data tidak ditemukan"
        }
    });
});
</script>
@endpush