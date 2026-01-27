@extends('layouts.app')

@section('content')

{{-- ================= DATATABLES CSS ================= --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<style>
.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #d1d5db;
    border-radius: .5rem;
    padding: .45rem .75rem;
    margin-left: .5rem;
}
.dataTables_wrapper .dataTables_length select {
    border-radius: .5rem;
    padding: .3rem .6rem;
}
.dt-button {
    border-radius: .5rem !important;
    padding: .4rem .8rem !important;
    border: 1px solid #e5e7eb !important;
    background: #fff !important;
}
</style>

<div class="p-6 space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">Pengguna</h1>

        <div class="flex gap-2">
            <a href="{{ url('scan') }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50">
                <i class="bi bi-upc-scan"></i> Cek Pengguna
            </a>

            <a href="{{ route('pengguna.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="bi bi-plus-circle"></i> Tambah Pengguna
            </a>
        </div>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-xl shadow p-4 overflow-x-auto">
        <table id="penggunaTable" class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th>Nomor Induk</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Lokasi</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($pengguna as $data)
                    @continue($data->nomor_induk == 0)

                    <tr class="hover:bg-gray-50">
                        <td>{{ $data->nomor_induk }}</td>

                        <td>
                            <a href="{{ route('absensi.pengguna', $data->nomor_induk) }}"
                               class="text-blue-600 hover:underline">
                                {{ $data->nama }}
                            </a>
                        </td>

                        <td>{{ $data->jabatan_status ?? '-' }}</td>
                        <td>{{ $data->lokasi ?? '-' }}</td>

                        <td class="text-center">
                            <span class="px-3 py-1 text-xs rounded-full
                                {{ $data->aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $data->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>

                        <td class="text-center space-x-2">
                            <a href="{{ route('pengguna.edit', $data->nomor_induk) }}"
                               class="px-3 py-1 border border-yellow-400 text-yellow-600 rounded hover:bg-yellow-50">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('pengguna.destroy', $data->nomor_induk) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 border border-red-400 text-red-600 rounded hover:bg-red-50">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ================= JS ================= --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

<script>
$(function () {
    $('#penggunaTable').DataTable({
        pageLength: 8,
        responsive: true,
        dom: 'Bfrtip',
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "‹",
                next: "›"
            }
        }
    });
});
</script>

@endsection
