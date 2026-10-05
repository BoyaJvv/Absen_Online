@extends('layouts.app')

@section('title', 'Ubah Cuti')

@section('content')
<div class="form-page" style="max-width:640px">

    {{-- HEADER --}}
    <div class="form-head">
        <a href="{{ route('cuti.index') }}" class="back-link"><i class="bi bi-arrow-left"></i> Kembali</a>
        <div>
            <h2 class="text-xl font-extrabold m-0">Ubah Cuti</h2>
            <p class="text-sm text-slate-500 m-0">Perbarui nomor induk atau tanggal cuti.</p>
        </div>
    </div>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="font-bold mb-1"><i class="bi bi-exclamation-triangle-fill"></i> Periksa kembali isian Anda:</div>
            <ul class="mb-0 ps-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">

        {{-- BANNER --}}
        <div class="profile-banner">
            <div class="avatar-lg"><i class="bi bi-calendar-event-fill"></i></div>
            <div class="min-w-0">
                <p class="banner-name">{{ $cuti->pengguna->nama ?? 'Data Cuti' }}</p>
                <p class="banner-sub">
                    <i class="bi bi-person-badge"></i> {{ $cuti->nomor_induk }}
                    · <i class="bi bi-calendar3"></i> {{ $cuti->tanggal->format('d-m-Y') }}
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('cuti.update', $cuti->id) }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" value="{{ $cuti->id }}">
            <input type="hidden" name="nomor_induk_lama" value="{{ $cuti->nomor_induk }}">

            <div class="form-body" style="grid-template-columns:1fr">

                <div class="field">
                    <label for="nomor_induk">Nomor Induk</label>
                    <div class="input-icon">
                        <i class="bi bi-person-badge"></i>
                        <input type="text" id="nomor_induk" name="nomor_induk"
                            class="form-control @error('nomor_induk') is-invalid @enderror"
                            value="{{ old('nomor_induk', $cuti->nomor_induk) }}" autofocus required>
                    </div>
                    @error('nomor_induk') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="tanggal">Tanggal Cuti</label>
                    <div class="input-icon">
                        <i class="bi bi-calendar-event"></i>
                        <input type="date" id="tanggal" name="tanggal"
                            class="form-control @error('tanggal') is-invalid @enderror"
                            value="{{ old('tanggal', $cuti->tanggal->format('Y-m-d')) }}" required>
                    </div>
                    @error('tanggal') <div class="field-error">{{ $message }}</div> @enderror
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('cuti.index') }}" class="btn-x btn-cancel">
                    <i class="bi bi-x-lg"></i> Batal
                </a>
                <button type="submit" name="ubah" class="btn-x btn-submit">
                    <i class="bi bi-check2-circle"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
