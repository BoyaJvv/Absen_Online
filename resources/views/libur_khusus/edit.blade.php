<div id="modalEdit"
    class="fixed inset-0 hidden items-center justify-center"
    style="z-index: 9999999;">

    {{-- BACKDROP FULL LAYAR --}}
    <div class="fixed inset-0 bg-black/70"></div>

    {{-- MODAL BOX --}}
    <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Edit Libur Khusus</h2>
            <button id="closeModal"
                class="text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>
        </div>

        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-2 font-medium">Tanggal</label>
                <input type="date" id="editTanggal" name="tanggal"
                    class="w-full rounded-xl border px-4 py-3" required>
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-medium">Keterangan</label>
                <textarea id="editKeterangan" name="keterangan" rows="3"
                    class="w-full rounded-xl border px-4 py-3"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" id="closeModal"
                    class="px-4 py-2 rounded-lg border border-gray-300">
                    Batal
                </button>

                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update
                </button>
            </div>
        </form>

    </div>
</div>