@extends('layouts.app')

@section('content')

<!-- Google Font: Source Sans Pro -->

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->

  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

  <!-- DataTables -->

  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pengguna</h1>
                </div>
            </div>
        </div>

        @if(session('successAdd'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                <b>{{ session('nama') }}</b> sudah ditambahkan sebagai pengguna baru.
            </div>
        @elseif(session('successEdit'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                <b>{{ session('nama_lama') }}</b> sudah berhasil diubah.
            </div>
        @elseif(session('successDelete'))
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-exclamation"></i> Berhasil!</h5>
                Status <b>{{ session('nama') }}</b> menjadi pengguna <b>{{ session('aktifText') }}</b>.
            </div>
        @endif
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ url('scan') }}" target="_blank" class="btn btn-block btn-outline-primary">Cek Pengguna (Scan Tag / Kartu)</a>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nomor Induk</th>
                                        <th>Nama</th>
                                        <th>Jabatan / Status</th>
                                        <th>Cabang / Gedung</th>
                                        <th>Aktif</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Data Baru</h3>
                        </div>
                        <form method="POST" action="{{ route('pengguna.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nomor Induk</label>
                                    <input type="text" class="form-control" name="nomor_induk" placeholder="Nomor Induk" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="form-group">
                                    <label>Jabatan / Status</label>
                                    <select name="jabatan_status" class="form-control">
                                        @foreach($jabatans as $j)
                                            <option value="{{ $j->id }}">{{ $j->jabatan_status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Cabang / Gedung</label>
                                    <select name="cabang_gedung" class="form-control">
                                        @foreach($lokasis as $l)
                                            <option value="{{ $l->id }}">{{ $l->lokasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tag</label>
                                    <input type="text" name="tag" placeholder="Scan Tag RFID" class="form-control" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
@endpush