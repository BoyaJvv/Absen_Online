@extends('layouts.app')

@section('content')
@stack('css')
@push('css')
<style>
    /* Memberikan efek bayangan lembut pada card */
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border: none;
    }

    /* Mempercantik Header Tabel */
    .table {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
    }
    .table thead th {
        background-color: #f8f9fa;
        color: #333;
        text-transform: uppercase;
        font-size: 12px;
        border-bottom: 2px solid #dee2e6;
    }
    .status-aktif {
        background-color: #d1e7dd;
        color: #0f5132;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 13px;
    }
    .status-non { background: #f8d7da; color: #721c24; }

    /* Tombol Aksi */
    .btn-edit {
        color: #007bff;
        transition: all 0.3s;
    }
    .btn-edit:hover {
        color: #0056b3;
        text-decoration: none;
        transform: scale(1.1);
    }
</style>
@endpush

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="head">Pengguna</h1>
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
                            <a href="{{ url('pengguna/create') }}" target="_blank" class="btn btn-block btn-outline-primary">Tambah Pengguna</a>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped" border="1">
                                <thead>
                                    <tr>
                                        <th>Nomor Induk</th>
                                        <th>Nama</th>
                                        <th>Jabatan_Status</th>
                                        <th>Cabang_Gedung</th>
                                        <th>Aktif</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                               <tbody>
                                    @foreach($pengguna as $data)
                                        @if($data->nomor_induk == 0) @continue @endif
                                        <tr>
                                            <td>{{ $data->nomor_induk }}</td>
                                            <td>{{ $data->nama }}</td>
                                            <td>{{ $data->jabatan_status ?? 'Tidak Ada' }}</td>
                                            <td>{{ $data->lokasi ?? 'Tidak Ada' }}</td> 
                                            <td>{{ $data->aktif == 1 ? 'Aktif' : 'Non-aktif' }}</td>
                                            <td>
                                                <a href="{{ route('pengguna.edit', $data->nomor_induk) }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-yellow">
                                                        <i class="fas fa-trash">Edit</i>
                                                    </button>
                                                </a>
                                                <form action="{{ route('pengguna.destroy', $data->nomor_induk) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash">Hapus</i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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