@extends('layouts.app')

@section('content')

{{-- ================= DATA TABLES CSS ================= --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

@push('styles')
<style>
.dataTables_wrapper {
    padding: 1rem;
}

.dataTables_filter,
.dt-buttons {
    margin-bottom: 1rem;
}

.dataTables_info,
.dataTables_paginate {
    margin-top: 1rem;
}

table.dataTable {
    margin-top: 0.75rem !important;
    margin-bottom: 0.75rem !important;
}
</style>
@endpush


<div class="max-w-7xl mx-auto px-4 py-6 space-y-10">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Cuti</h1>
            <p class="text-gray-500 text-sm">Kelola data cuti karyawan secara efisien</p>
        </div>
    </div>

    {{-- ================= ALERT ================= --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ================= TABLE CARD ================= --}}
    {{-- <div class="bg-white rounded-2xl shadow-lg p-6 overflow-x-auto"> --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-visible mb-12 p-6">
        <table id="cutiTable" class="w-full text-sm border-collapse">
            <thead class="bg-slate-800 text-white">
                <tr>
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Nomor Induk</th>
                    <th class="py-3 px-4">Nama</th>
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($cuti as $item)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-semibold">{{ $item->id }}</td>
                    <td class="px-4 py-3">{{ $item->nomor_induk }}</td>
                    <td class="px-4 py-3">{{ $item->pengguna->nama ?? '-' }}</td>
                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('cuti.edit', $item->id) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg
                                      border border-blue-300 text-blue-600
                                      hover:bg-blue-50 transition">
                                <i class="bi bi-pencil"></i>
                                <span class="hidden sm:inline">Edit</span>
                            </a>

                            <form action="{{ route('cuti.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus data cuti ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg
                                           border border-red-300 text-red-600
                                           hover:bg-red-50 transition">
                                    <i class="bi bi-trash"></i>
                                    <span class="hidden sm:inline">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ================= FORM CARD ================= --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Tambah Cuti</h2>

        <form method="POST" action="{{ route('cuti.store') }}"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <div>
                <label class="block mb-2 font-medium text-gray-700">
                    Karyawan
                </label>
                <select name="nomor_induk"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring focus:ring-blue-200"
                        required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($penggunaList as $pengguna)
                        <option value="{{ $pengguna->nomor_induk }}">
                            {{ $pengguna->nomor_induk }} - {{ $pengguna->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 font-medium text-gray-700">
                    Tanggal Cuti
                </label>
                <input type="date"
                       name="tanggal"
                       value="{{ date('Y-m-d') }}"
                       min="{{ date('Y-m-d') }}"
                       class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring focus:ring-blue-200"
                       required>
            </div>

            <div class="md:col-span-2 flex flex-col sm:flex-row gap-4 justify-end">
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2
                               bg-blue-600 hover:bg-blue-700 text-white
                               px-6 py-3 rounded-xl shadow transition">
                    <i class="bi bi-save"></i>
                    Simpan
                </button>

                <a href="{{ route('cuti.index') }}"
                   class="inline-flex items-center justify-center gap-2
                          bg-gray-200 hover:bg-gray-300 text-gray-700
                          px-6 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>

{{-- ================= JS ================= --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

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

<script>
$(document).ready(function () {
    $('#cutiTable').DataTable({
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

@endsection
