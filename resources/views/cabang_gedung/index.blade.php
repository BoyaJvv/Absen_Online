@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
    {{ session('success') }}
</div>
@endif

{{-- BUTTON ADD --}}
<button onclick="openModal()"
    class="mb-6 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
    + Tambah Cabang
</button>

{{-- CARD LIST --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

@foreach($data as $row)
<div class="border rounded-lg shadow bg-white">

    {{-- HEADER --}}
    <div class="flex justify-between items-center px-4 py-3 border-b bg-gray-50">
        <h3 class="font-semibold text-lg">
            {{ $row->lokasi }}
        </h3>

        <div class="flex gap-2">
            {{-- EDIT (LEGACY PHP) --}}
            <a href="{{ route('cabang-gedung.edit', $row->id) }}"
            class="bg-yellow-500 text-white px-3 py-1 rounded">
                Edit
            </a>


            {{-- DELETE --}}
            <form method="POST" action="{{ url('/cabang-gedung/'.$row->id) }}">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Hapus cabang ini?')"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- BODY --}}
    <div class="p-4 text-sm space-y-2">
        @foreach($row->jadwalHarian as $j)
            <div class="flex justify-between border-b pb-1">
                <span class="font-medium">{{ $j->hari }}</span>

                @if($j->keterangan == 'libur')
                    <span class="text-red-500 font-semibold">Libur</span>
                @else
                    <span>
                        {{ $j->jam_masuk }} - {{ $j->jam_pulang }}
                        <br>
                        <small class="text-gray-500">
                            Istirahat 1 {{ $j->istirahat1_mulai }} - {{ $j->istirahat1_selesai }}
                        </small>
                        <br>
                        <small class="text-gray-500">
                            Istirahat 2 {{ $j->istirahat2_mulai }} - {{ $j->istirahat2_selesai }}
                        </small>
                    </span>
                @endif
            </div>
        @endforeach
    </div>

</div>
@endforeach

</div>

{{-- ================= MODAL ADD ================= --}}
<div id="modal" class="fixed inset-0 bg-black/40 hidden flex items-center justify-center z-50">
<div class="bg-white w-11/12 max-w-4xl p-6 rounded-lg">

<form method="POST" action="{{ url('/cabang-gedung') }}">
@csrf

<h2 class="text-lg font-semibold mb-4">Tambah Cabang & Jadwal</h2>

<input type="text" name="lokasi" placeholder="Nama Lokasi"
    class="mb-4 w-full border rounded px-3 py-2" required>

<table class="w-full border text-sm mb-4">
<thead class="bg-gray-100">
<tr>
    <th class="border p-2">Hari</th>
    <th class="border p-2">Masuk</th>
    <th class="border p-2">Pulang</th>
    <th class="border p-2 w-32">Istirahat 1</th>
    <th class="border p-2 w-32">Istirahat 2</th>
    <th class="border p-2">Libur</th>
</tr>
</thead>
<tbody>
@foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $hari)
<tr>
<td class="border p-2">{{ $hari }}</td>
<td class="border p-2">
    <input type="time" name="jadwal[{{ $hari }}][jam_masuk]" class="border rounded w-full">
</td>
<td class="border p-2">
    <input type="time" name="jadwal[{{ $hari }}][jam_pulang]" class="border rounded w-full">
</td>
<td class="border p-2 flex gap-1">
    <input type="time" name="jadwal[{{ $hari }}][istirahat1_mulai]" class="border rounded w-1/2">
    <input type="time" name="jadwal[{{ $hari }}][istirahat1_selesai]" class="border rounded w-1/2">
</td>
<td class="border p-2">
    <div class="flex flex-col md:flex-row gap-1">
        <input type="time" name="jadwal[{{ $hari }}][istirahat2_mulai]" 
               class="border rounded w-full text-xs p-1">
        <input type="time" name="jadwal[{{ $hari }}][istirahat2_selesai]" 
               class="border rounded w-full text-xs p-1">
    </div>
</td>
<td class="border p-2 text-center">
    <input type="checkbox" name="jadwal[{{ $hari }}][libur]">
</td>
</tr>
@endforeach
</tbody>
</table>

<div class="flex justify-end gap-2">
<button type="button" onclick="closeModal()" class="px-4 py-2 border rounded">
Batal
</button>
<button class="px-4 py-2 bg-blue-600 text-white rounded">
Simpan
</button>
</div>

</form>
</div>
</div>

<script>
function openModal(){document.getElementById('modal').classList.remove('hidden')}
function closeModal(){document.getElementById('modal').classList.add('hidden')}
</script>

@endsection
