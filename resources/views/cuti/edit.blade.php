@extends('layouts.app')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('cuti.index') }}" class="btn btn-app">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Ubah Cuti</h3>
                        </div>

                        <form method="POST" action="{{ route('cuti.update', $cuti->id) }}">
                            @csrf
                            @method('PUT') <!-- INI YANG HARUS DIPERBAIKI -->

                            <input type="hidden" name="id" value="{{ $cuti->id }}">
                            <input type="hidden" name="nomor_induk_lama" value="{{ $cuti->nomor_induk }}">

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nomor Induk</label>
                                    <input type="text"
                                           class="form-control"
                                           name="nomor_induk"
                                           value="{{ $cuti->nomor_induk }}"
                                           autofocus
                                           required>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date"
                                           class="form-control"
                                           name="tanggal"
                                           value="{{ $cuti->tanggal->format('Y-m-d') }}"
                                           required>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" name="ubah" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Ubah
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection