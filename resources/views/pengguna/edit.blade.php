
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('pengguna.index') }}" class="btn btn-app">
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
                            <h3 class="card-title">Ubah Data Pengguna</h3>
                        </div>
                        
                        {{-- Form diarahkan ke route update --}}
                        <form method="POST" action="{{ route('pengguna.update', $user->nomor_induk) }}">
                            @csrf
                            @method('PUT') {{-- Laravel menggunakan method PUT untuk update --}}
                            
                            <input type="hidden" name="nomor_induk_lama" value="{{ $user->nomor_induk }}">
                            <input type="hidden" name="nama_lama" value="{{ $user->nama }}">

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nomor Induk</label>
                                    <input type="text" class="form-control" name="nomor_induk" 
                                           value="{{ $user->nomor_induk }}" required autofocus>
                                </div>

                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" 
                                           value="{{ $user->nama }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Jabatan / Status</label>
                                    <select name="jabatan_status" class="form-control">
                                        @foreach($jabatans as $j)
                                            <option value="{{ $j->id }}" {{ $user->jabatan_status == $j->id ? 'selected' : '' }}>
                                                {{ $j->jabatan_status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Cabang / Gedung</label>
                                    <select name="cabang_gedung" class="form-control">
                                        @foreach($lokasis as $l)
                                            <option value="{{ $l->id }}" {{ $user->cabang_gedung == $l->id ? 'selected' : '' }}>
                                                {{ $l->lokasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tag</label>
                                    <input type="text" name="tag" class="form-control" value="{{ $user->tag }}" required>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">Ubah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>