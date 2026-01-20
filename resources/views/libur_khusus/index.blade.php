    @extends('layouts.app')

    @section('content')
        <div class="max-w-7xl mx-auto px-4 py-6">

            {{-- TITLE --}}
            <h1 class="text-2xl font-bold mb-6">Tanggal Libur Khusus</h1>

            {{-- ALERT --}}
            @foreach (['successAdd', 'successEdit', 'successDelete'] as $msg)
                @if (session($msg))
                    <div
                        class="mb-4 rounded border px-4 py-3
                        {{ $msg == 'successAdd' ? 'bg-green-100 border-green-300 text-green-700' : '' }}
                        {{ $msg == 'successEdit' ? 'bg-blue-100 border-blue-300 text-blue-700' : '' }}
                        {{ $msg == 'successDelete' ? 'bg-yellow-100 border-yellow-300 text-yellow-700' : '' }}">
                        {{ session($msg) }}
                    </div>
                @endif
            @endforeach
            <div class="mb-4 flex gap-3 items-center flex-wrap">
                {{-- TANGGAL AWAL --}}
                <input type="date" id="tanggalAwal" class="border rounded px-3 py-2 focus:ring focus:ring-blue-200">

                {{-- TANGGAL AKHIR --}}
                <input type="date" id="tanggalAkhir" class="border rounded px-3 py-2 focus:ring focus:ring-blue-200">

                {{-- SEARCH KETERANGAN --}}
                <div class="relative">
                    <input type="text" id="searchKeterangan" placeholder="Cari keterangan..."
                        class="border rounded pl-10 pr-3 py-2 focus:ring focus:ring-blue-200">
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <i class="bi bi-search"></i>
                    </span>
                </div>

                {{-- RESET --}}
                <button type="button" id="btnReset" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Reset
                </button>
            </div>

            {{-- TABLE --}}
            <div class="bg-white shadow rounded mb-8 overflow-x-auto">
                <table class="min-w-full border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2 text-left">Tanggal</th>
                            <th class="border px-4 py-2 text-left">Keterangan</th>
                            <th class="border px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="liburTable">
                        @forelse($data as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">
                                    {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $row->keterangan }}
                                </td>
                                <td class="border px-4 py-2 text-center space-x-3">
                                    <button type="button" class="text-blue-600 cursor-pointer btn-edit"
                                        data-action="{{ route('libur_khusus.update', $row->id) }}"
                                        data-tanggal="{{ $row->tanggal }}" data-keterangan="{{ $row->keterangan }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('libur_khusus.destroy', $row->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600">
                                            <i class="bi bi-dash-circle"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-500">
                                    Data tidak ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- FORM TAMBAH --}}
            <div class="bg-white shadow rounded p-6 w-full">
                <h3 class="text-lg font-semibold mb-4">Data Baru</h3>

                <form method="POST" action="{{ route('libur_khusus.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Tanggal</label>
                        <input type="date" name="tanggal"
                            class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Keterangan</label>
                        <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                            placeholder="Keterangan libur"></textarea>
                    </div>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Tambah
                    </button>
                </form>
            </div>

            {{-- MODAL EDIT --}}
            @include('libur_khusus.edit')

        </div>
    @endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                // ===============================
                // FILTER & LIVE SEARCH
                // ===============================
                const tglAwal = document.getElementById('tanggalAwal');
                const tglAkhir = document.getElementById('tanggalAkhir');
                const searchKet = document.getElementById('searchKeterangan');
                const btnReset = document.getElementById('btnReset');
                const tableBody = document.getElementById('liburTable');

                let timer = null;

                function fetchData() {
                    fetch(`{{ route('libur_khusus.index') }}?tanggal_awal=${tglAwal.value}&tanggal_akhir=${tglAkhir.value}&keterangan=${encodeURIComponent(searchKet.value)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(res => res.text())
                        .then(html => {
                            const doc = new DOMParser().parseFromString(html, 'text/html');
                            const newTable = doc.querySelector('#liburTable');
                            if (newTable) {
                                tableBody.innerHTML = newTable.innerHTML;
                            }
                        });
                }

                [tglAwal, tglAkhir].forEach(el => el.addEventListener('change', fetchData));

                searchKet.addEventListener('keyup', () => {
                    clearTimeout(timer);
                    timer = setTimeout(fetchData, 300);
                });

                btnReset.addEventListener('click', () => {
                    tglAwal.value = '';
                    tglAkhir.value = '';
                    searchKet.value = '';
                    fetchData();
                });

                // ===============================
                // MODAL EDIT
                // ===============================
                const modal = document.getElementById('editModal');
                const form = document.getElementById('editForm');
                const editTanggal = document.getElementById('editTanggal');
                const editKeterangan = document.getElementById('editKeterangan');

                document.addEventListener('click', e => {
                    const btn = e.target.closest('.btn-edit');
                    if (!btn) return;

                    form.action = btn.dataset.action;
                    editTanggal.value = btn.dataset.tanggal;
                    editKeterangan.value = btn.dataset.keterangan;

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });

                window.closeModal = function() {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                };

                document.addEventListener('keydown', e => {
                    if (e.key === 'Escape') closeModal();
                });
            });
        </script>
    @endpush
