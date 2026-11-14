@extends('admin.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ __($title) }}</h1>
                <span class="h-20px border-gray-200 border-start mx-4"></span>
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="../../demo13/dist/index.html" class="text-muted text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-dark">{{ __($title) }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-body pt-0">
                    @include('admin.service.create')
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        $('#myForm').submit(function(e) {
            e.preventDefault();

            var id_service = $('#id_service').val();
            var formData = new FormData($('#myForm')[0]);
            formData.set('text', CKEDITOR.instances.text.getData());
            formData.set('condition', CKEDITOR.instances.condition.getData());

            $.ajax({
                url: "{{ url('/service/validate') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function() {
                    $('.fv-plugins-message-container').html('');
                    $('.is-invalid').removeClass('is-invalid');
                    update(id_service);
                },
                error: function(xhr) {
                    showErrors(xhr);
                }
            });
        });
    });

    function showSuccessToast(message) {
        toastr.success(message, '', {
            iconClass: 'toast-success',
        });
    }

    function showErrors(xhr) {
        var errors = xhr.responseJSON ? xhr.responseJSON.errors : null;

        $('.fv-plugins-message-container').html('');
        $('.is-invalid').removeClass('is-invalid');

        if (errors) {
            $.each(errors, function(key, value) {
                $('#' + key + '-error').html(value[0]);
                $('#' + key).addClass('is-invalid');
            });
        } else {
            console.error('Error pengiriman formulir:', xhr);
        }
    }

    function update(id) {
        var formData = new FormData($('#myForm')[0]);
        formData.set('text', CKEDITOR.instances.text.getData());
        formData.set('condition', CKEDITOR.instances.condition.getData());
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('_method', "PUT");
        $('#loading').show();

        $.ajax({
            url: "{{ url('/service/edit') }}/" + id,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                showSuccessToast(response.message);
                $('#loading').hide();
                window.location.reload(true);
            },
            error: function(xhr) {
                $('#loading').hide();
                showErrors(xhr);
            }
        });
    }
</script>

@endsection
