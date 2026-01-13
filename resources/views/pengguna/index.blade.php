@extends('layouts.app')

@section('content')
<div class="p-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Pengguna</h1>

        <div class="flex gap-2">
            <a href="{{ url('scan') }}" target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50">
                <i class="bi bi-upc-scan"></i>
                Cek Pengguna
            </a>

            <button onclick="openModal('{{ route('pengguna.create') }}')"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="bi bi-plus-circle"></i>
                Tambah Pengguna
            </button>
        </div>
    </div>

    {{-- SEARCH --}}
    <div class="mb-4 w-full md:w-1/3 relative">
        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <input id="searchInput" type="text"
            class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
            placeholder="Cari pengguna...">
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Nomor Induk</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Jabatan</th>
                    <th class="px-4 py-3 text-left">Lokasi</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="divide-y">
                @foreach($pengguna as $data)
                @if($data->nomor_induk == 0) @continue @endif
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $data->nomor_induk }}</td>
                    <td class="px-4 py-3">{{ $data->nama }}</td>
                    <td class="px-4 py-3">{{ $data->jabatan_status ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $data->lokasi ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-3 py-1 text-xs rounded-full
                            {{ $data->aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $data->aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <button onclick="openModal('{{ route('pengguna.edit',$data->nomor_induk) }}')"
                            class="px-3 py-1 border border-yellow-400 text-yellow-600 rounded hover:bg-yellow-50">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <form action="{{ route('pengguna.destroy',$data->nomor_induk) }}"
                            method="POST" class="inline"
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

    {{-- PAGINATION --}}
    <div class="flex justify-between items-center mt-4">
        <button id="prevPage"
            class="px-4 py-2 border rounded-lg hover:bg-gray-100 disabled:opacity-50">
            <i class="bi bi-arrow-left"></i> Previous
        </button>

        <span id="pageInfo" class="text-sm text-gray-600"></span>

        <button id="nextPage"
            class="px-4 py-2 border rounded-lg hover:bg-gray-100 disabled:opacity-50">
            Next <i class="bi bi-arrow-right"></i>
        </button>
    </div>

</div>

{{-- MODAL --}}
<div id="modal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-2xl rounded-xl shadow-lg">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Form Pengguna</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-red-500">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div id="modalContent" class="p-6"></div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
const rows = Array.from(document.querySelectorAll('#tableBody tr'));
const rowsPerPage = 8;
let currentPage = 1;

function renderTable(filteredRows = rows) {
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    rows.forEach(r => r.style.display = 'none');
    filteredRows.slice(start, end).forEach(r => r.style.display = '');

    document.getElementById('pageInfo').innerText =
        `Halaman ${currentPage} dari ${totalPages || 1}`;

    document.getElementById('prevPage').disabled = currentPage === 1;
    document.getElementById('nextPage').disabled = currentPage === totalPages;
}

let filteredRows = rows;
renderTable();

document.getElementById('searchInput').addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();
    filteredRows = rows.filter(row =>
        row.innerText.toLowerCase().includes(keyword)
    );
    currentPage = 1;
    renderTable(filteredRows);
});

document.getElementById('prevPage').onclick = () => {
    if (currentPage > 1) {
        currentPage--;
        renderTable(filteredRows);
    }
};

document.getElementById('nextPage').onclick = () => {
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderTable(filteredRows);
    }
};

function openModal(url) {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');

    fetch(url)
        .then(res => res.text())
        .then(html => document.getElementById('modalContent').innerHTML = html);
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
    document.getElementById('modal').classList.remove('flex');
    document.getElementById('modalContent').innerHTML = '';
}
</script>
@endsection
