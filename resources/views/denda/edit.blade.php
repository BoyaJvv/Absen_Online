@extends('layouts.app')

@section('title', 'Edit Denda')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Denda</h3>

    <form method="POST" action="{{ route('denda.update', $denda->id) }}">
        @csrf
        @method('PUT')

        {{-- JENIS --}}
        <div class="mb-3">
            <label class="form-label">Jenis</label>
            <input name="jenis" class="form-control"
                   value="{{ $denda->jenis }}" readonly>
        </div>

        {{-- PRIORITAS --}}
        <div class="mb-3">
            <label class="form-label">Prioritas</label>
            <input name="prioritas" class="form-control"
                   value="{{ $denda->prioritas }}">
        </div>

        {{-- PER MENIT --}}
        <div class="mb-3">
            <label class="form-label">Per Menit</label>
            <input name="per_menit" class="form-control"
                   value="{{ $denda->per_menit }}">
        </div>

        {{-- RUPIAH PERTAMA --}}
        <div class="mb-3">
            <label class="form-label">Rupiah Pertama</label>
            <input name="rupiah_pertama" class="form-control"
                   value="{{ $denda->rupiah_pertama }}">
        </div>

        {{-- RUPIAH SELANJUTNYA --}}
        <div class="mb-3">
            <label class="form-label">Rupiah Selanjutnya</label>
            <input name="rupiah_selanjutnya" class="form-control"
                   value="{{ $denda->rupiah_selanjutnya }}">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('denda.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>
@endsection
