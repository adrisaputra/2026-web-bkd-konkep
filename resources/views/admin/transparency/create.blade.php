<div class="modal fade" id="kt_modal_add_transparency" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_transparency_header">
                <h2 class="fw-bolder" id="head_title"></h2>
                <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Tutup">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="myForm" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_transparency_scroll">
                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2" for="title">{{ __('Judul') }}</label>
                            <input type="hidden" id="id_transparency">
                            <input type="text" class="form-control" placeholder="Judul" name="title" id="title">
                            <div id="title-error" class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2" for="text">{{ __('Isi') }}</label>
                            <textarea name="text" id="text" class="form-control" rows="5"></textarea>
                            <div id="text-error" class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2" for="file">{{ __('File PDF') }}</label>
                            <input type="file" name="file" id="file" class="form-control" accept="application/pdf,.pdf">
                            <b class="text-muted" style="font-size: 12px;">Ukuran file maksimal 5 Mb (pdf)</b>
                            <div id="show_file"></div>
                            <div id="file-error" class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="text-center pt-15">
                        <button type="submit" class="btn btn-primary btn-flat btn-sm" id="action" title="Tambah Data">Simpan</button>
                        <button type="button" class="btn btn-warning btn-flat btn-sm" title="Kembali" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
