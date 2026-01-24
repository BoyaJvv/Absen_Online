@extends('layouts.app')

@section('content')

<a href="{{ url('/cabang-gedung') }}" class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded">
    ← Kembali
</a>

<div class="bg-white border rounded-lg shadow p-6">
    <form method="POST" action="{{ route('cabang-gedung.update', $cabang->id) }}">
        @csrf
        @method('PUT')

        <h2 class="text-xl font-semibold mb-4">Edit Cabang & Jadwal</h2>

        {{-- NAMA CABANG --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Lokasi Cabang</label>
            <input type="text" name="lokasi" value="{{ $cabang->lokasi }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <table class="w-full border text-sm mb-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Hari</th>
                    <th class="border p-2">Libur</th>
                    <th class="border p-2">Masuk</th>
                    <th class="border p-2">Pulang</th>
                    <th class="border p-2">Istirahat 1 (Mulai - Selesai)</th>
                    <th class="border p-2">Istirahat 2 (Mulai - Selesai)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Kita definisikan 7 hari agar tabel selalu lengkap
                    $daftar_hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                @endphp

                @foreach($daftar_hari as $hari)
                    @php
                        // Ambil data hari ini dari variabel $jadwal (keyBy) yang dikirim Controller
                        $j = $jadwal->get($hari);
                        // Jika data tidak ada atau status libur true
                        $isLibur = $j ? $j->libur : (in_array($hari, ['Sabtu', 'Minggu']));
                    @endphp
                    <tr class="hari-row">
                        <td class="border p-2 font-bold">{{ $hari }}</td>

                        <td class="border p-2 text-center">
                            <input type="checkbox" 
                                   name="jadwal[{{ $hari }}][libur]" 
                                   class="check-libur"
                                   {{ $isLibur ? 'checked' : '' }}>
                        </td>

                        <td class="border p-2">
                            <input type="time" name="jadwal[{{ $hari }}][jam_masuk]" 
                                   value="{{ $j ? $j->jam_masuk : '' }}" 
                                   class="border rounded w-full input-field {{ $isLibur ? 'bg-gray-100' : '' }}" {{ $isLibur ? 'readonly' : '' }}>
                        </td>

                        <td class="border p-2">
                            <input type="time" name="jadwal[{{ $hari }}][jam_pulang]" 
                                   value="{{ $j ? $j->jam_pulang : '' }}" 
                                   class="border rounded w-full input-field {{ $isLibur ? 'bg-gray-100' : '' }}" {{ $isLibur ? 'readonly' : '' }}>
                        </td>

                        <td class="border p-2">
                            <div class="flex gap-1">
                                <input type="time" name="jadwal[{{ $hari }}][istirahat1_mulai]" 
                                       value="{{ $j ? $j->istirahat1_mulai : '' }}" 
                                       class="border rounded w-1/2 input-field {{ $isLibur ? 'bg-gray-100' : '' }}" {{ $isLibur ? 'readonly' : '' }}>
                                <input type="time" name="jadwal[{{ $hari }}][istirahat1_selesai]" 
                                       value="{{ $j ? $j->istirahat1_selesai : '' }}" 
                                       class="border rounded w-1/2 input-field {{ $isLibur ? 'bg-gray-100' : '' }}" {{ $isLibur ? 'readonly' : '' }}>
                            </div>
                        </td>

                        <td class="border p-2">
                            <div class="flex gap-1">
                                <input type="time" name="jadwal[{{ $hari }}][istirahat2_mulai]" 
                                       value="{{ $j ? $j->istirahat2_mulai : '' }}" 
                                       class="border rounded w-1/2 input-field {{ $isLibur ? 'bg-gray-100' : '' }}" {{ $isLibur ? 'readonly' : '' }}>
                                <input type="time" name="jadwal[{{ $hari }}][istirahat2_selesai]" 
                                       value="{{ $j ? $j->istirahat2_selesai : '' }}" 
                                       class="border rounded w-1/2 input-field {{ $isLibur ? 'bg-gray-100' : '' }}" {{ $isLibur ? 'readonly' : '' }}>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    // Script agar input jam otomatis abu-abu dan tidak bisa diisi jika "Libur" dicentang
    document.querySelectorAll('.check-libur').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            let row = this.closest('tr');
            let inputs = row.querySelectorAll('.input-field');
            
            inputs.forEach(input => {
                if (this.checked) {
                    input.value = '';
                    input.classList.add('bg-gray-100');
                    input.readOnly = true;
                } else {
                    input.classList.remove('bg-gray-100');
                    input.readOnly = false;
                }
            });
        });
    });
</script>

@endsection