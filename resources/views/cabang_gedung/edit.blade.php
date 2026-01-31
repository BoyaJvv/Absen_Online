@extends('layouts.app')

@section('content')

<a href="{{ route('cabang-gedung.index') }}"
   class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded">
← Kembali
</a>

<div class="bg-white border rounded-lg shadow p-6 max-w-xl">

<form method="POST"
      action="{{ route('cabang-gedung.update', $cabang->id) }}">
@csrf
@method('PUT')

<h2 class="text-lg font-semibold mb-4">
Edit Cabang Gedung
</h2>

{{-- LOKASI --}}
<div class="mb-3">
<label class="text-sm">Lokasi</label>
<input type="text"
       name="lokasi"
       value="{{ $cabang->lokasi }}"
       class="w-full border rounded px-3 py-2"
       required>
</div>

{{-- JAM MASUK --}}
<div class="mb-3">
<label class="text-sm">Jam Masuk</label>
<input type="time"
       name="jam_masuk"
       value="{{ $cabang->jam_masuk }}"
       class="w-full border rounded px-3 py-2"
       required>
</div>

{{-- JAM PULANG --}}
<div class="mb-3">
<label class="text-sm">Jam Pulang</label>
<input type="time"
       name="jam_pulang"
       value="{{ $cabang->jam_pulang }}"
       class="w-full border rounded px-3 py-2"
       required>
</div>

{{-- ISTIRAHAT MULAI --}}
<div class="mb-3">
<label class="text-sm">Mulai Istirahat</label>
<input type="time"
       name="istirahat_mulai"
       value="{{ $cabang->istirahat_mulai }}"
       class="w-full border rounded px-3 py-2"
       required>
</div>

{{-- ISTIRAHAT SELESAI --}}
<div class="mb-3">
<label class="text-sm">Selesai Istirahat</label>
<input type="time"
       name="istirahat_selesai"
       value="{{ $cabang->istirahat_selesai }}"
       class="w-full border rounded px-3 py-2"
       required>
</div>

{{-- HARI LIBUR --}}
<div class="mb-3">
<label class="text-sm">Hari Libur</label>
<div class="grid grid-cols-4 gap-2 mt-1">

@php
$hari = [
0=>'Minggu',
1=>'Senin',
2=>'Selasa',
3=>'Rabu',
4=>'Kamis',
5=>'Jumat',
6=>'Sabtu'
];

$libur = explode(',', $cabang->hari_libur);
@endphp

@foreach($hari as $k=>$v)
<label class="text-xs">
<input type="checkbox"
       name="hari_libur[]"
       value="{{ $k }}"
       {{ in_array($k, $libur) ? 'checked' : '' }}>
{{ $v }}
</label>
@endforeach

</div>
</div>

{{-- ZONA WAKTU --}}
<div class="mb-4">
<label class="text-sm">Zona Waktu</label>
<select name="zona_waktu"
        class="w-full border rounded px-3 py-2">
<option value="1" {{ $cabang->zona_waktu==1?'selected':'' }}>WIB</option>
<option value="2" {{ $cabang->zona_waktu==2?'selected':'' }}>WITA</option>
<option value="3" {{ $cabang->zona_waktu==3?'selected':'' }}>WIT</option>
</select>
</div>

<div class="flex justify-end">
<button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
Simpan Perubahan
</button>
</div>

</form>
</div>

@endsection
