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

<div class="max-w-7xl mx-auto px-4 py-6 space-y-8">

    {{-- ================= HEADER ================= --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Jabatan / Status</h1>
        <p class="text-gray-500 text-sm">Kelola data jabatan dan hak akses</p>
    </div>

    {{-- ================= ALERT NOTIFIKASI ================= --}}
    @if (session('successAdd'))
        <div class="rounded-lg border bg-emerald-50 border-emerald-200 px-4 py-3 text-emerald-700 text-sm">
            {{ session('successAdd') }}
        </div>
    @endif

    @if (session('successEdit'))
        <div class="rounded-lg border bg-blue-50 border-blue-200 px-4 py-3 text-blue-700 text-sm">
            {{ session('successEdit') }}
        </div>
    @endif

    @if (session('successDelete'))
        <div class="rounded-lg border bg-emerald-50 border-emerald-200 px-4 py-3 text-emerald-700 text-sm">
            {{ session('successDelete') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-lg border bg-rose-50 border-rose-200 px-4 py-3 text-rose-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- ================= TABEL JABATAN ================= --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 overflow-x-auto">
        <table id="datatableJabatan" class="min-w-full text-sm">
            <thead class="bg-slate-800 text-white">
                <tr>
                    <th class="px-4 py-3">Jabatan / Status</th>
                    <th class="px-4 py-3">Hak Akses</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($data as $row)
                    <tr class="hover:bg-slate-50 transition text-center">
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $row->jabatan_status }}</td>
                        <td class="px-4 py-3">
                            {{ $row->hakAkses->hak ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $row->aktif ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $row->aktif ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center items-center gap-3">
                                {{-- Tombol Edit (Tetap Biru dengan Pensil) --}}
                                <a href="{{ route('jabatan.edit', $row->id) }}"
                                    class="text-blue-600 hover:text-blue-800 transition"
                                    title="Edit Jabatan">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>

                                {{-- Form Hapus Permanen (Merah dengan Ikon Trash) --}}
                                <form action="{{ route('jabatan.destroy', $row->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data jabatan \'{{ $row->jabatan_status }}\' secara permanen?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-rose-600 hover:text-rose-800 transition cursor-pointer bg-transparent border-0 p-0"
                                            title="Hapus Jabatan">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ================= FORM TAMBAH ================= --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-semibold mb-4 text-slate-800">Tambah Jabatan / Status</h3>

        <form method="POST" action="{{ route('jabatan.store') }}" class="grid md:grid-cols-2 gap-6">
            @csrf

            <div>
                <label class="block mb-2 font-medium text-sm text-slate-700">Jabatan / Status</label>
                <input type="text" name="jabatan_status"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block mb-2 font-medium text-sm text-slate-700">Hak Akses</label>
                <select name="hak_akses"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach ($hakAksesList as $hak)
                        <option value="{{ $hak->id }}">{{ $hak->hak }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-semibold shadow-md shadow-blue-500/20 transition cursor-pointer">
                    Simpan
                </button>
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

<script>
$(document).ready(function () {
    $('#datatableJabatan').DataTable({
        pageLength: 8,
        searching: true,
        destroy: true,
        dom: 'Bftip',
        buttons: [
            { extend: 'copy', title: 'jabatan_status' },
            { extend: 'excel', title: 'jabatan_status' },
            { extend: 'pdf', title: 'jabatan_status' },
            { extend: 'print', title: 'jabatan_status' },
            'colvis'
        ],
        language: {
            search: 'Cari:',
            info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
            paginate: {
                previous: '‹',
                next: '›'
            }
        }
    });
});
</script>

@endsection