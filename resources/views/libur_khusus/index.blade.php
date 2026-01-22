@extends('layouts.app')

@section('content')

{{-- ================= DATA TABLES CSS ================= --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<style>
    /* DataTables Tailwind Friendly */
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

<div class="max-w-7xl mx-auto px-4 py-6 space-y-10">

    {{-- ================= HEADER ================= --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Libur Khusus</h1>
        <p class="text-gray-500 text-sm">Kelola tanggal libur khusus perusahaan</p>
    </div>

    {{-- ================= ALERT ================= --}}
    @foreach (['successAdd', 'successEdit', 'successDelete'] as $msg)
        @if (session($msg))
            <div class="rounded-lg border px-4 py-3
                {{ $msg === 'successAdd' ? 'bg-green-50 border-green-200 text-green-700' : '' }}
                {{ $msg === 'successEdit' ? 'bg-blue-50 border-blue-200 text-blue-700' : '' }}
                {{ $msg === 'successDelete' ? 'bg-yellow-50 border-yellow-200 text-yellow-700' : '' }}">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 overflow-x-auto space-y-4">

        {{-- TABLE --}}
        <table id="datatableLibur" class="min-w-full text-sm">
            <thead class="bg-slate-800 text-white">
                <tr>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Keterangan</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($data as $row)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($row->tanggal)->format('d F Y') }}
                        </td>
                        <td class="px-4 py-3">{{ $row->keterangan }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">

                                {{-- EDIT --}}
                                <button
                                    class="btn-edit inline-flex items-center gap-1 px-3 py-1.5 rounded-lg
                                           border border-blue-300 text-blue-600 hover:bg-blue-50"
                                    data-action="{{ route('libur_khusus.update', $row->id) }}"
                                    data-tanggal="{{ $row->tanggal }}"
                                    data-keterangan="{{ $row->keterangan }}">
                                    <i class="bi bi-pencil"></i>
                                    <span class="hidden sm:inline">Edit</span>
                                </button>

                                {{-- DELETE --}}
                                <form action="{{ route('libur_khusus.destroy', $row->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg
                                               border border-red-300 text-red-600 hover:bg-red-50">
                                        <i class="bi bi-trash"></i>
                                        <span class="hidden sm:inline">Hapus</span>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-6 text-gray-500">
                            Data tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================= FORM ================= --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4">Tambah Libur Khusus</h2>

        <form method="POST" action="{{ route('libur_khusus.store') }}"
            class="grid md:grid-cols-2 gap-6">
            @csrf

            <div>
                <label class="block mb-2 font-medium">Tanggal</label>
                <input type="date" name="tanggal"
                    class="w-full rounded-xl border px-4 py-3" required>
            </div>

            <div>
                <label class="block mb-2 font-medium">Keterangan</label>
                <textarea name="keterangan" rows="3"
                    class="w-full rounded-xl border px-4 py-3"></textarea>
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- MODAL EDIT --}}
    @include('libur_khusus.edit')

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
    let liburDT;

function initDataTable() {
    liburDT = $('#datatableLibur').DataTable({
        pageLength: 8,
        searching: true,
        destroy: true,
        dom: 'Bftip',
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
        language: {
            search: 'Cari:',
            info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
            paginate: {
                previous: '‹',
                next: '›'
            }
        }
    });
}
    

    $(document).ready(function () {
        initDataTable();
    });
</script>

@endsection
