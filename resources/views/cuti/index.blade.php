@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">

    <h1 class="text-2xl font-bold mb-4">Data Cuti</h1>

    {{-- SEARCH --}}
    <!-- <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8"> -->
        <div class="mb-4 w-full md:w-1/3 relative">
            <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input id="searchInput" type="text"
                    class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                    placeholder="Cari pengguna...">
        </div>

        <!-- <form method="GET" action="{{ route('cuti.index') }}">
            //FORM UNTUK FILTER)

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">


                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Tanggal Awal
                    </label>
                    <input type="date"
                        name="start_date"
                        class="w-full h-12 rounded-xl border border-gray-300 text-base"
                        value="{{ request('start_date') }}"
                        required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Tanggal Akhir
                    </label>
                    <input type="date"
                        name="end_date"
                        class="w-full h-12 rounded-xl border border-gray-300 text-base"
                        value="{{ request('end_date') }}"
                        required>
                </div>

            </div>

            <div class="mt-6 flex justify-end">
                <button
                    type="submit"
                    class="flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white text-lg px-6 py-3 rounded-xl shadow-lg transition">
                    <i class="bi bi-filter-circle text-xl"></i>
                    Tampilkan Data
                </button>
            </div>

        </form> -->

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-slate-800 text-slate-100 uppercase">
            <tr>
                <th class="px-6 py-4 text-left">ID</th>
                <th class="px-6 py-4 text-left">Nomor Induk</th>
                <th class="px-6 py-4 text-left">Nama</th>
                <th class="px-6 py-4 text-left">Tanggal</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="tableBody" class="divide-y">
            @foreach($cuti as $item)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-semibold">{{ $item->id }}</td>
                <td class="px-4 py-3 font-semibold">{{ $item->nomor_induk }}</td>
                <td class="px-4 py-3 font-semibold">{{ $item->pengguna->nama ?? '-' }}</td>
                <td class="px-4 py-3 font-semibold" >{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center space-x-2">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('cuti.edit', $item->id) }}" 
                           class="px-3 py-1 border border-blue-400 text-blue-600 rounded hover:bg-blue-50 transition">
                            <i class="bi bi-pencil"></i>
                        </a>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('cuti.destroy', $item->id) }}" method="POST" 
                              onsubmit="return confirm('Yakin hapus cuti ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 border border-red-400 text-red-600 rounded hover:bg-red-50 transition">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

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

<br>
<br>

<h1 class="text-2xl font-bold mb-4">Tambah Cuti</h1>
    <div class="bg-white shadow rounded p-6">

        <form method="POST" action="{{ route('cuti.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium">Pilih Karyawan</label>
                <select name="nomor_induk" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($penggunaList as $pengguna)
                        <option value="{{ $pengguna->nomor_induk }}" 
                            {{ old('nomor_induk') == $pengguna->nomor_induk ? 'selected' : '' }}>
                            {{ $pengguna->nomor_induk }} - {{ $pengguna->nama }}
                        </option>
                    @endforeach
                </select>
                @error('nomor_induk')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Tanggal Cuti</label>
                <input type="date" name="tanggal" 
                       class="w-full border rounded px-3 py-2" 
                       value="{{ old('tanggal', date('Y-m-d')) }}" 
                       min="{{ date('Y-m-d') }}" 
                       required>
                @error('tanggal')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Tambah Cuti
                </button>
                <a href="{{ route('cuti.index') }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    Batal
                </a>
            </div>
        </form>
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