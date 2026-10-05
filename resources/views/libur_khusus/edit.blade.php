{{-- MODAL EDIT LIBUR KHUSUS (dibuka lewat .btn-edit di index) --}}
<style>
    #modalEdit { padding: 1rem; }
    #modalEdit .lk-backdrop {
        position: fixed; inset: 0; background: rgba(15, 23, 42, .6);
        backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
    }
    #modalEdit.flex .lk-backdrop { animation: mFade .2s ease both; }
    #modalEdit.flex .modal-box { animation: mPop .25s cubic-bezier(.2, .9, .3, 1.2) both; }
    #modalEdit .modal-box { max-height: calc(100vh - 2rem); overflow-y: auto; border-radius: 18px; box-shadow: 0 30px 70px -20px rgba(15, 23, 42, .55); }
    #modalEdit .modal-x {
        position: absolute; top: .9rem; right: .9rem; z-index: 5; width: 2.2rem; height: 2.2rem; border: 0; border-radius: 10px;
        display: grid; place-items: center; color: #fff; background: rgba(255, 255, 255, .18); font-size: 1.4rem; line-height: 1; cursor: pointer; transition: .15s;
    }
    #modalEdit .modal-x:hover { background: rgba(255, 255, 255, .32); }
    @keyframes mFade { from { opacity: 0 } to { opacity: 1 } }
    @keyframes mPop { from { opacity: 0; transform: translateY(14px) scale(.96) } to { opacity: 1; transform: none } }
</style>

<div id="modalEdit"
    class="fixed inset-0 hidden items-center justify-center"
    style="z-index: 9999999;"
    role="dialog" aria-modal="true" aria-labelledby="modalEditTitle">

    {{-- BACKDROP FULL LAYAR --}}
    <div class="lk-backdrop js-close-modal"></div>

    {{-- MODAL BOX --}}
    <div class="form-page modal-box relative w-full" style="max-width: 32rem; z-index: 2;">
        <div class="form-card" style="box-shadow:none;border:0">

            {{-- HEADER --}}
            <div class="profile-banner" style="padding:1.2rem 1.5rem">
                <div class="avatar-lg" style="width:3rem;height:3rem;font-size:1.3rem;border-radius:14px">
                    <i class="bi bi-calendar2-heart-fill"></i>
                </div>
                <div class="min-w-0">
                    <p class="banner-name" id="modalEditTitle">Edit Libur Khusus</p>
                    <p class="banner-sub">Ubah tanggal atau keterangan hari libur</p>
                </div>
                <button type="button" id="closeModal" class="modal-x" aria-label="Tutup">&times;</button>
            </div>

            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')

                <div class="form-body" style="grid-template-columns:1fr;padding:1.5rem">

                    <div class="field">
                        <label for="editTanggal">Tanggal</label>
                        <div class="input-icon">
                            <i class="bi bi-calendar-event"></i>
                            <input type="date" id="editTanggal" name="tanggal" class="form-control" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="editKeterangan">Keterangan <span class="opt">(opsional)</span></label>
                        <div class="input-icon">
                            <i class="bi bi-card-text" style="top:1.3rem"></i>
                            <textarea id="editKeterangan" name="keterangan" rows="3" class="form-control"
                                style="height:auto;padding-top:.75rem;resize:vertical"
                                placeholder="Contoh: Cuti bersama Idul Fitri"></textarea>
                        </div>
                    </div>

                </div>

                <div class="form-actions" style="padding:1rem 1.5rem">
                    <button type="button" class="btn-x btn-cancel js-close-modal">
                        <i class="bi bi-x-lg"></i> Batal
                    </button>
                    <button type="submit" class="btn-x btn-submit">
                        <i class="bi bi-check2-circle"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function () {
        const modal = document.getElementById('modalEdit');
        const close = () => { modal.classList.add('hidden'); modal.classList.remove('flex'); };

        // tombol Batal & klik backdrop (tombol X ditangani handler #closeModal di index)
        modal.querySelectorAll('.js-close-modal').forEach(el => el.addEventListener('click', close));

        // tekan Esc untuk menutup
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && modal.classList.contains('flex')) close();
        });
    })();
</script>
