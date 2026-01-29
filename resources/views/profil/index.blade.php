@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Profil Pengguna</h3>
                </div>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="card-body">

                        <div class="form-group">
                            <label>Nomor Induk</label>
                            <input type="text" class="form-control" value="{{ $user->nomor_induk }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   value="{{ $user->nama }}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   placeholder="Kosongkan jika tidak diganti">
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

</div>
@endsection
