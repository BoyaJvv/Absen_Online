@extends('layouts.app')

@section('title', 'Jam Pembelajaran')

@section('content')

<div class="card">
    <div class="card-header">
        <strong>Jam Pembelajaran</strong>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('/jam-pembelajaran') }}" method="POST" class="row g-3 mb-4">
            @csrf

            <div class="col-md-3">
                <label class="form-label">Jam Masuk</label>
                <input type="time" name="jam_masuk" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Jam Pulang</label>
                <input type="time" name="jam_pulang" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Jam Mulai</label>
                <input type="time" name="jam_mulai" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Jam Selesai</label>
                <input type="time" name="jam_selesai" class="form-control" required>
            </div>

            <div class="col-12">
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->jam_masuk }}</td>
                    <td>{{ $row->jam_pulang }}</td>
                    <td>{{ $row->jam_mulai }}</td>
                    <td>{{ $row->jam_selesai }}</td>
                    <td>
                        <form action="{{ url('/jam-pembelajaran/'.$row->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus data?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
