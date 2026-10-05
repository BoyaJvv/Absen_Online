@extends('layouts.app')

@section('title', 'Ubah Pengguna')

@section('content')
@php
    $inisial = strtoupper(mb_substr($user->nama ?? 'U', 0, 2));
@endphp

<div class="form-page">

    {{-- HEADER --}}
    <div class="form-head">
        <a href="{{ route('pengguna.index') }}" class="back-link"><i class="bi bi-arrow-left"></i> Kembali</a>
        <div>
            <h2 class="text-xl font-extrabold m-0">Ubah Data Pengguna</h2>
            <p class="text-sm text-slate-500 m-0">Perbarui informasi pengguna di bawah ini.</p>
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

    <div class="card" style="overflow:hidden">

        {{-- BANNER PROFIL --}}
        <div class="profile-banner">
            <div class="avatar-lg">{{ $inisial }}</div>
            <div class="min-w-0">
                <div class="text-lg font-extrabold truncate">{{ $user->nama }}</div>
                <div class="text-sm" style="color:#e0e7ff">
                    <i class="bi bi-person-badge"></i> No. Induk {{ $user->nomor_induk }}
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('pengguna.update', $user->nomor_induk) }}">
            @csrf
            @method('PUT')

            <div class="card-body" style="padding:1.5rem">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5">

                    <div class="field">
                        <label for="nomor_induk">Nomor Induk</label>
                        <div class="input-icon">
                            <i class="bi bi-person-badge"></i>
                            <input type="text" id="nomor_induk" name="nomor_induk"
                                class="form-control @error('nomor_induk') is-invalid @enderror"
                                value="{{ old('nomor_induk', $user->nomor_induk) }}" required>
                        </div>
                        @error('nomor_induk') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="nama">Nama Lengkap</label>
                        <div class="input-icon">
                            <i class="bi bi-person"></i>
                            <input type="text" id="nama" name="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $user->nama) }}" required>
                        </div>
                        @error('nama') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="jabatan_status">Jabatan</label>
                        <div class="input-icon">
                            <i class="bi bi-briefcase"></i>
                            <select id="jabatan_status" name="jabatan_status"
                                class="form-select @error('jabatan_status') is-invalid @enderror">
                                @foreach ($jabatans as $j)
                                    <option value="{{ $j->id }}"
                                        {{ old('jabatan_status', $user->jabatan_status) == $j->id ? 'selected' : '' }}>
                                        {{ $j->jabatan_status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('jabatan_status') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="cabang_gedung">Lokasi / Cabang</label>
                        <div class="input-icon">
                            <i class="bi bi-geo-alt"></i>
                            <select id="cabang_gedung" name="cabang_gedung"
                                class="form-select @error('cabang_gedung') is-invalid @enderror">
                                @foreach ($lokasis as $l)
                                    <option value="{{ $l->id }}"
                                        {{ old('cabang_gedung', $user->cabang_gedung) == $l->id ? 'selected' : '' }}>
                                        {{ $l->lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('cabang_gedung') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field md:col-span-2">
                        <label for="tag">Tag <span class="opt">(opsional)</span></label>
                        <div class="input-icon">
                            <i class="bi bi-upc-scan"></i>
                            <input type="text" id="tag" name="tag"
                                class="form-control @error('tag') is-invalid @enderror"
                                value="{{ old('tag', $user->tag) }}" placeholder="Kode kartu / tag pengguna">
                        </div>
                        @error('tag') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('pengguna.index') }}" class="btn btn-ghost">
                    <i class="bi bi-x-lg"></i> Batal
                </a>
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-check2-circle"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
