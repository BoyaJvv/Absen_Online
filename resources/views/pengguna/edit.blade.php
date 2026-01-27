@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="card card-warning">
        <div class="card-header">
            <h5 class="mb-0">Ubah Data Pengguna</h5>
        </div>

        <form method="POST" action="{{ route('pengguna.update', $user->nomor_induk) }}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="mb-3">
                    <label>Nomor Induk</label>
                    <input type="text" name="nomor_induk"
                           class="form-control"
                           value="{{ $user->nomor_induk }}" required>
                </div>

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama"
                           class="form-control"
                           value="{{ $user->nama }}" required>
                </div>

                <div class="mb-3">
                    <label>Jabatan</label>
                    <select name="jabatan_status" class="form-control">
                        @foreach($jabatans as $j)
                            <option value="{{ $j->id }}"
                                {{ $user->jabatan_status == $j->id ? 'selected' : '' }}>
                                {{ $j->jabatan_status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Lokasi</label>
                    <select name="cabang_gedung" class="form-control">
                        @foreach($lokasis as $l)
                            <option value="{{ $l->id }}"
                                {{ $user->cabang_gedung == $l->id ? 'selected' : '' }}>
                                {{ $l->lokasi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Tag</label>
                    <input type="text" name="tag"
                           class="form-control"
                           value="{{ $user->tag }}">
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button class="btn btn-warning">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
