{{-- MODAL TAMBAH LIBUR KHUSUS (dibuka lewat tombol #btnTambah di index) --}}
@php $tambahTerbuka = $errors->any() && old('_form') === 'tambah'; @endphp

<style>
    #modalTambah { padding: 1rem; }
    #modalTambah .lk-backdrop {
        position: fixed; inset: 0; background: rgba(15, 23, 42, .6);
        backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
    }
    #modalTambah.flex .lk-backdrop { animation: tFade .2s ease both; }
    #modalTambah.flex .modal-box { animation: tPop .25s cubic-bezier(.2, .9, .3, 1.2) both; }
    #modalTambah .modal-box { max-height: calc(100vh - 2rem); overflow-y: auto; border-radius: 18px; box-shadow: 0 30px 70px -20px rgba(15, 23, 42, .55); }
    #modalTambah .modal-x {
        position: absolute; top: .9rem; right: .9rem; z-index: 5; width: 2.2rem; height: 2.2rem; border: 0; border-radius: 10px;
        display: grid; place-items: center; color: #fff; background: rgba(255, 255, 255, .18); font-size: 1.4rem; line-height: 1; cursor: pointer; transition: .15s;
    }
    #modalTambah .modal-x:hover { background: rgba(255, 255, 255, .32); }
    @keyframes tFade { from { opacity: 0 } to { opacity: 1 } }
    @keyframes tPop { from { opacity: 0; transform: translateY(14px) scale(.96) } to { opacity: 1; transform: none } }
</style>

<div id="modalTambah"
    class="fixed inset-0 {{ $tambahTerbuka ? 'flex' : 'hidden' }} items-center justify-center"
    style="z-index: 9999999;"
    role="dialog" aria-modal="true" aria-labelledby="modalTambahTitle">

    {{-- BACKDROP FULL LAYAR --}}
    <div class="lk-backdrop js-close-tambah"></div>

    {{-- MODAL BOX --}}
    <div class="form-page modal-box relative w-full" style="max-width: 32rem; z-index: 2;">
        <div class="form-card" style="box-shadow:none;border:0">

            {{-- HEADER --}}
            <div class="profile-banner" style="padding:1.2rem 1.5rem">
                <div class="avatar-lg" style="width:3rem;height:3rem;font-size:1.3rem;border-radius:14px">
                    <i class="bi bi-calendar-plus-fill"></i>
                </div>
                <div class="min-w-0">
                    <p class="banner-name" id="modalTambahTitle">Tambah Libur Khusus</p>
                    <p class="banner-sub">Daftarkan tanggal libur baru</p>
                </div>
                <button type="button" class="modal-x js-close-tambah" aria-label="Tutup">&times;</button>
            </div>

            <form method="POST" action="{{ route('libur_khusus.store') }}">
                @csrf
                <input type="hidden" name="_form" value="tambah">

                <div class="form-body" style="grid-template-columns:1fr;padding:1.5rem">

                    {{-- ERROR VALIDASI --}}
                    @if ($tambahTerbuka)
                        <div class="alert alert-danger" style="margin:0">
                            <ul class="mb-0 ps-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="field">
                        <label for="tambahTanggal">Tanggal</label>
                        <div class="input-icon">
                            <i class="bi bi-calendar-event"></i>
                            <input type="date" id="tambahTanggal" name="tanggal" class="form-control"
                                value="{{ old('_form') === 'tambah' ? old('tanggal') : '' }}" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="tambahKeterangan">Keterangan <span class="opt">(opsional)</span></label>
                        <div class="input-icon">
                            <i class="bi bi-card-text" style="top:1.3rem"></i>
                            <textarea id="tambahKeterangan" name="keterangan" rows="3" class="form-control"
                                style="height:auto;padding-top:.75rem;resize:vertical"
                                placeholder="Contoh: Cuti bersama Idul Fitri">{{ old('_form') === 'tambah' ? old('keterangan') : '' }}</textarea>
                        </div>
                    </div>

                </div>

                <div class="form-actions" style="padding:1rem 1.5rem">
                    <button type="button" class="btn-x btn-cancel js-close-tambah">
                        <i class="bi bi-x-lg"></i> Batal
                    </button>
                    <button type="submit" class="btn-x btn-submit">
                        <i class="bi bi-check2-circle"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function () {
        const modal = document.getElementById('modalTambah');
        const open = () => {
            modal.classList.remove('hidden'); modal.classList.add('flex');
            setTimeout(() => document.getElementById('tambahTanggal').focus(), 50);
        };
        const close = () => { modal.classList.add('hidden'); modal.classList.remove('flex'); };

        document.querySelectorAll('.js-open-tambah').forEach(el => el.addEventListener('click', open));
        modal.querySelectorAll('.js-close-tambah').forEach(el => el.addEventListener('click', close));
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && modal.classList.contains('flex')) close();
        });
    })();
</script>
