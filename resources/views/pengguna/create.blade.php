@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <div class="card shadow border-0 rounded-4">

                {{-- HEADER --}}
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-person-plus-fill me-2"></i>
                        Tambah Pengguna Baru
                    </h5>
                </div>

                {{-- BODY --}}
                <div class="card-body bg-light">

                    {{-- 🔴 ERROR GLOBAL (WAJIB ADA) --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pengguna.store') }}" method="POST">
                        @csrf

                        {{-- DATA UTAMA --}}
                        <div class="card mb-4 border">
                            <div class="card-body bg-white rounded">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nomor Induk</label>
                                        <input type="text"
                                            name="nomor_induk"
                                            class="form-control border-primary @error('nomor_induk') is-invalid @enderror"
                                            value="{{ old('nomor_induk') }}"
                                            placeholder="Contoh: 12300000"
                                            required>
                                        @error('nomor_induk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text"
                                            name="nama"
                                            class="form-control border-primary"
                                            value="{{ old('nama') }}"
                                            placeholder="Nama Lengkap"
                                            required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tag</label>
                                        <input type="text"
                                            name="tag"
                                            class="form-control border-primary"
                                            value="{{ old('tag') }}"
                                            placeholder="Scan kartu / isi manual">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status Jabatan</label>
                                        <select name="jabatan_status"
                                            class="form-select border-primary @error('jabatan_status') is-invalid @enderror"
                                            required>
                                            <option value="">-- Pilih Jabatan --</option>
                                            @foreach($jabatans as $jab)
                                                <option value="{{ $jab->id }}"
                                                    {{ old('jabatan_status') == $jab->id ? 'selected' : '' }}>
                                                    {{ $jab->jabatan_status }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('jabatan_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Cabang Gedung</label>
                                    <select name="cabang_gedung"
                                        class="form-select border-primary @error('cabang_gedung') is-invalid @enderror"
                                        required>
                                        <option value="">-- Pilih Lokasi --</option>
                                        @foreach($lokasis as $lok)
                                            <option value="{{ $lok->id }}"
                                                {{ old('cabang_gedung') == $lok->id ? 'selected' : '' }}>
                                                {{ $lok->lokasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cabang_gedung')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="card mb-4 border border-warning">
                            <div class="card-header bg-warning text-dark fw-semibold">
                                Keamanan Akun
                            </div>
                            <div class="card-body bg-white rounded-bottom">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password"
                                            name="password"
                                            class="form-control border-warning @error('password') is-invalid @enderror"
                                            placeholder="Masukkan password"
                                            required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Konfirmasi Password</label>
                                        <input type="password"
                                            name="password_confirmation"
                                            class="form-control border-warning"
                                            placeholder="Ulangi password"
                                            required>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('pengguna.index') }}"
                               class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left"></i> Batal
                            </a>

                            <button type="submit"
                                class="btn btn-success px-4">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
