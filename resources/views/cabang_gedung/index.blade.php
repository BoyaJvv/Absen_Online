@extends('layouts.app')

@section('content')

{{-- FLASH MESSAGE --}}
@if(session('success'))
<div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded">
    {{ session('success') }}
</div>
@endif

{{-- HEADER --}}
<div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-semibold">Manajemen Cabang / Gedung</h1>

    <button onclick="openModal()"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
        + Tambah Cabang
    </button>
</div>

{{-- CARD --}}
<div class="bg-white rounded-lg shadow p-4">

<table class="w-full border-collapse">

<thead>
<tr class="bg-gray-100 text-gray-700">
    <th class="p-3 border">Lokasi</th>
    <th class="p-3 border">Jam Masuk</th>
    <th class="p-3 border">Jam Pulang</th>
    <th class="p-3 border">Istirahat</th>
    <th class="p-3 border">Hari Libur</th>
    <th class="p-3 border">Zona</th>
    <th class="p-3 border">Status</th>
    <th class="p-3 border text-center">Aksi</th>
</tr>
</thead>

<tbody>

@forelse($data as $row)
<tr class="hover:bg-gray-50 transition">

<td class="p-3 border font-medium">
    {{ $row->lokasi }}
</td>

<td class="p-3 border">
    {{ $row->jam_masuk }}
</td>

<td class="p-3 border">
    {{ $row->jam_pulang }}
</td>

<td class="p-3 border text-sm">
    {{ $row->istirahat_mulai }} - {{ $row->istirahat_selesai }}
</td>

<td>
@php
$mapHari = [
0=>'Minggu',
1=>'Senin',
2=>'Selasa',
3=>'Rabu',
4=>'Kamis',
5=>'Jumat',
6=>'Sabtu'
];

$libur = explode(',', $row->hari_libur ?? '');
$nama = [];

foreach($libur as $h){
    if(isset($mapHari[$h])){
        $nama[] = $mapHari[$h];
    }
}
@endphp

{{ implode(', ', $nama) }}
</td>


<td class="p-3 border">
    @if($row->zona_waktu == 1) WIB
    @elseif($row->zona_waktu == 2) WITA
    @else WIT
    @endif
</td>

<td class="p-3 border">
    @if($row->aktif)
        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
            Aktif
        </span>
    @else
        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">
            Nonaktif
        </span>
    @endif
</td>

<td class="p-3 border text-center">

    <div class="flex justify-center gap-2">

        <a href="{{ route('cabang-gedung.edit',$row->id) }}"
           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
            Edit
        </a>

        <form method="POST"
              action="{{ route('cabang-gedung.destroy',$row->id) }}">
            @csrf
            @method('DELETE')

            <button onclick="return confirm('Ubah status cabang ini?')"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                Toggle
            </button>

        </form>

    </div>

</td>

</tr>
@empty
<tr>
<td colspan="8" class="text-center p-4 text-gray-500">
    Belum ada data cabang
</td>
</tr>
@endforelse

</tbody>
</table>

</div>

{{-- ================= MODAL ================= --}}
<div id="modal"
class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">

<div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">

<h2 class="text-lg font-semibold mb-4">Tambah Cabang</h2>

<form method="POST" action="{{ route('cabang-gedung.store') }}">
@csrf

<div class="grid grid-cols-2 gap-3">

<div class="col-span-2">
<label class="text-sm">Lokasi</label>
<input name="lokasi"
 class="border rounded w-full px-3 py-2" required>
</div>

<div>
<label class="text-sm">Jam Masuk</label>
<input type="time" name="jam_masuk"
 class="border rounded w-full px-2 py-1" required>
</div>

<div>
<label class="text-sm">Jam Pulang</label>
<input type="time" name="jam_pulang"
 class="border rounded w-full px-2 py-1" required>
</div>

<div>
<label class="text-sm">Mulai Istirahat</label>
<input type="time" name="istirahat_mulai"
 class="border rounded w-full px-2 py-1" required>
</div>

<div>
<label class="text-sm">Selesai Istirahat</label>
<input type="time" name="istirahat_selesai"
 class="border rounded w-full px-2 py-1" required>
</div>

<div class="col-span-2">
<label class="text-sm">Hari Libur</label>
<div class="grid grid-cols-4 gap-2 mt-1">
@foreach(['0'=>'Minggu','1'=>'Senin','2'=>'Selasa','3'=>'Rabu','4'=>'Kamis','5'=>'Jumat','6'=>'Sabtu'] as $k=>$v)
<label class="text-xs">
<input type="checkbox" name="hari_libur[]" value="{{ $k }}">
 {{ $v }}
</label>
@endforeach
</div>
</div>

<div class="col-span-2">
<label class="text-sm">Zona Waktu</label>
<select name="zona_waktu"
 class="border rounded w-full px-2 py-2">
<option value="1">WIB</option>
<option value="2">WITA</option>
<option value="3">WIT</option>
</select>
</div>

</div>

<div class="flex justify-end gap-2 mt-6">

<button type="button"
 onclick="closeModal()"
 class="px-4 py-2 border rounded">
Batal
</button>

<button
 class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
Simpan
</button>

</div>

</form>

</div>
</div>

{{-- SCRIPT --}}
<script>
function openModal(){
    document.getElementById('modal').classList.remove('hidden')
}
function closeModal(){
    document.getElementById('modal').classList.add('hidden')
}
</script>

@endsection
