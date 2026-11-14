<script src="{{ url('backend/assets/ckeditor/ckeditor.js') }}"></script>
<form id="myForm" action="{{ url('/service/'.Request::segment(2)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
    {{ csrf_field() }}
    <input type="hidden" class="form-control" id="id_service" value="{{ $service->id }}" />
    <div class="card-body border-top p-9">
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-bold fs-6">Judul</label>
            <div class="col-lg-8 fv-row">
                <input type="text" name="title" id="title" class="form-control" placeholder="Judul" value="{{ $service->title }}" disabled />
            </div>
        </div>
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-bold fs-6">Deskripsi</label>
            <div class="col-lg-8 fv-row">
                <textarea name="text" id="text" class="form-control ckeditor">{{ $service->text }}</textarea>
                <div id="text-error" class="fv-plugins-message-container invalid-feedback"></div>
            </div>
        </div>
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-bold fs-6">Persyaratan</label>
            <div class="col-lg-8 fv-row">
                <textarea name="condition" id="condition" class="form-control ckeditor">{{ $service->condition }}</textarea>
                <div id="condition-error" class="fv-plugins-message-container invalid-feedback"></div>
            </div>
        </div>
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-bold fs-6">URL Layanan</label>
            <div class="col-lg-8 fv-row">
                <input type="text" name="url" id="url" class="form-control" placeholder="URL Layanan" value="{{ $service->url }}" />
                <div id="url-error" class="fv-plugins-message-container invalid-feedback"></div>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end py-6 px-9">
        <button type="reset" class="btn btn-danger btn-flat btn-sm me-2 mb-2">Reset</button>
        <button type="submit" class="btn btn-primary btn-flat btn-sm me-2 mb-2" id="action" title="Simpan"> Simpan</button>
    </div>
</form>

<script>
    CKEDITOR.replace('text');
    CKEDITOR.replace('condition');
</script>
