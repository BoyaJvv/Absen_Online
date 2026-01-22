<div id="editModal"
    class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">

    <div class="bg-white rounded shadow w-full max-w-lg">

        {{-- HEADER --}}
        <div class="border-b px-6 py-4 flex justify-between items-center">
            <h3 class="font-semibold text-lg">Edit Libur Khusus</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-red-600">
                ✕
            </button>
        </div>

        {{-- FORM --}}
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-4">
                <div>
                    <label class="block mb-1 font-medium">Tanggal</label>
                    <input type="date" id="editTanggal" name="tanggal"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Keterangan</label>
                    <textarea id="editKeterangan" name="keterangan" rows="3"
                        class="w-full border rounded px-3 py-2"></textarea>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="border-t px-6 py-4 text-right space-x-2">
                <button type="button" onclick="closeModal()"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
