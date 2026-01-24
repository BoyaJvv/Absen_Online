@extends('layouts.app')

@section('content')

{{-- ================= DATA TABLES CSS ================= --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<style>
/* DataTables Friendly */
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
.dt-button:hover {
    background: #f1f5f9 !important;
}
</style>

<div class="max-w-7xl mx-auto px-4 py-6 space-y-8">

    {{-- ================= HEADER ================= --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Pengaturan Denda</h1>
        <p class="text-sm text-gray-500">Kelola aturan dan nominal denda</p>
    </div>

    {{-- ================= ALERT ================= --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 overflow-x-auto">
        <table id="dendaTable" class="min-w-full text-sm">
            <thead class="bg-slate-800 text-white">
                <tr>
                    <th class="py-3 px-4">Urutan</th>
                    <th class="py-3 px-4">Jenis</th>
                    <th class="py-3 px-4">Denda</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($denda as $d)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-semibold">
                        {{ $d->prioritas }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $d->jenis }}
                    </td>

                    <td class="px-4 py-3">
                        @if(in_array($d->prioritas, [5,6,7,8]))
                            Rp {{ number_format($d->rupiah_pertama) }}
                        @else
                            Rp {{ number_format($d->rupiah_pertama) }}
                            (Rp {{ number_format($d->rupiah_selanjutnya) }}
                            / {{ $d->per_menit }} Menit)
                        @endif
                    </td>

                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('denda.edit', $d->prioritas) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg
                                  border border-blue-300 text-blue-600
                                  hover:bg-blue-50 transition">
                            <i class="bi bi-pencil"></i>
                            <span class="hidden sm:inline">Edit</span>
                        </a>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
$(function () {
    $('#dendaTable').DataTable({
        responsive: true,
        pageLength: 8,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print', 'colvis'
        ],
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
