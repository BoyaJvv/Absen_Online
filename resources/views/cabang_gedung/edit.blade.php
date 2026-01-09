@extends('layouts.app')

@section('content')

<a href="{{ url('/cabang-gedung') }}"
   class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded">
← Kembali
</a>

<div class="bg-white border rounded-lg shadow p-6">

<form method="POST" action="{{ route('cabang-gedung.update', $cabang->id) }}">
@csrf
@method('PUT')

<h2 class="text-xl font-semibold mb-4">Edit Cabang</h2>

{{-- NAMA CABANG --}}
<input type="text" name="lokasi"
    value="{{ $cabang->lokasi }}"
    class="mb-4 w-full border rounded px-3 py-2"
    required>

<table class="w-full border text-sm mb-4">
<thead class="bg-gray-100">
<tr>
    <th class="border p-2">Hari</th>
    <th class="border p-2">Masuk</th>
    <th class="border p-2">Pulang</th>
    <th class="border p-2">Istirahat</th>
    <th class="border p-2">Libur</th>
</tr>
</thead>
<tbody>

@foreach($cabang->jadwalHarian as $j)
<tr>
<td class="border p-2">{{ $j->hari }}</td>

<td class="border p-2">
<input type="time"
    name="jadwal[{{ $j->hari }}][jam_masuk]"
    value="{{ $j->jam_masuk }}"
    class="border rounded w-full">
</td>

<td class="border p-2">
<input type="time"
    name="jadwal[{{ $j->hari }}][jam_pulang]"
    value="{{ $j->jam_pulang }}"
    class="border rounded w-full">
</td>

<td class="border p-2 flex gap-1">
<input type="time"
    name="jadwal[{{ $j->hari }}][istirahat_mulai]"
    value="{{ $j->istirahat1_mulai }}"
    class="border rounded w-1/2">

<input type="time"
    name="jadwal[{{ $j->hari }}][istirahat_selesai]"
    value="{{ $j->istirahat1_selesai }}"
    class="border rounded w-1/2">
</td>

<td class="border p-2 text-center">
<input type="checkbox"
    name="jadwal[{{ $j->hari }}][libur]"
    {{ $j->keterangan == 'libur' ? 'checked' : '' }}>
</td>
</tr>
@endforeach

</tbody>
</table>

<div class="flex justify-end">
<button class="bg-blue-600 text-white px-6 py-2 rounded">
Update
</button>
</div>

</form>
</div>

@endsection
