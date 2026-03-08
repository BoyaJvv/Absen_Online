@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">Ubah Mesin</h3>

    <div class="bg-white rounded shadow-lg border p-4">
        <form method="POST" action="{{ route('mesin.update', $editData->idmesin) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Kode Mesin</label>
                <input type="text" name="idmesin" class="form-control" value="{{ $editData->idmesin }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Cabang Gedung</label>
                <select name="id_cabang_gedung" class="form-select" required>
                    @foreach ($cabang as $c)
                        <option value="{{ $c->id }}" {{ $editData->id_cabang_gedung == $c->id ? 'selected' : '' }}>
                            {{ $c->lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <input type="text" name="keterangan" class="form-control" value="{{ $editData->keterangan }}" required>
            </div>

            <button class="btn btn-success">Simpan Perubahan</button>
            <a href="{{ route('mesin.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

</div>
@endsection