@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">Tambah Pengguna Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengguna.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Induk</label>
                                <input type="text" name="nomor_induk" class="form-control @error('nomor_induk') is-invalid @enderror" value="{{ old('nomor_induk') }}" placeholder="Contoh: 12300000" required>
                                @error('nomor_induk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Nama Lengkap" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tag</label>
                                <input type="text" name="tag" class="form-control" value="{{ old('tag') }}" placeholder="Scan kartu atau isi manual">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Jabatan</label>
                                <select name="jabatan_status" class="form-select @error('jabatan_status') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach($jabatans as $jab)
                                        <option value="{{ $jab->id }}">{{ $jab->jabatan_status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cabang Gedung</label>
                            <select name="cabang_gedung" class="form-select @error('cabang_gedung') is-invalid @enderror" required>
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach($lokasis as $lok)
                                    <option value="{{ $lok->id }}">{{ $lok->lokasi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('pengguna.index') }}" class="btn btn-light border">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Pengguna</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .card { border-radius: 12px; }
    .form-label { font-weight: 600; color: #444; font-size: 0.9rem; }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #dee2e6;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    .btn { border-radius: 8px; font-weight: 500; }
</style>
@endpush