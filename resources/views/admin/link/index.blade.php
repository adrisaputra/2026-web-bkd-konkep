@extends('admin.layout')
@section('content')

<link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Data {{ __($title)}}</h1>
                <span class="h-20px border-gray-200 border-start mx-4"></span>
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-dark">Data {{ __($title) }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title"></div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-link-table-toolbar="base">
                            <a href="{{ url('/'.Request::segment(1)) }}" class="btn btn-warning btn-icon btn-sm me-2 mb-2" title="Refresh Halaman"><i class="fa fa-undo"></i></a>
                            <a class="btn btn-success btn-sm me-2 mb-2" data-bs-toggle="modal" data-bs-target="#kt_modal_add_link" onClick="clearForm()"><i class="fa fa-plus"></i>Tambah {{ $title }}</a>
                        </div>
                    </div>
                </div>

                @include('admin.link.create')

                <div class="card-body pt-0">
                    <table class="table table-striped table-rounded border border-gray-300 table-row-bordered table-row-gray-300 gy-2 gs-6" id="link-table">
                        <thead style="background-color: #d30e00;">
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th style="width: 2%;color: white;border-bottom: white;">Number</th>
                                <th style="width: 2%;color: white;border-bottom: white;">No</th>
                                <th style="color: white;border-bottom: white;">Nama Link</th>
                                <th style="color: white;border-bottom: white;">URL</th>
                                <th style="color: white;border-bottom: white;">Gambar</th>
                                <th style="width: 10%;color: white;border-bottom: white;">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    var table;

    $(document).ready(function() {
        table = $('#link-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('link.list') }}",
            columns: [{
                    data: 'id',
                    name: 'id',
                    visible: false
                },
                {
                    data: 'number',
                    name: 'number'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'display_url',
                    name: 'url'
                },
                {
                    data: 'display_image',
                    name: 'image'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            order: [
                [0, 'desc']
            ],
            paging: true,
            drawCallback: function() {
                var api = this.api();
                var startIndex = api.context[0]._iDisplayStart;
                api.column(1, {
                    page: 'current'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = startIndex + i + 1;
                });
            }
        });

        $('#myForm').submit(function(e) {
            e.preventDefault();

            var action = document.getElementById('action').innerText;
            var id_link = $('#id_link').val();
            var name = $('#name').val();
            var url = $('#url').val();
            var formData = new FormData();
            formData.append('id', id_link);
            formData.append('name', name);
            formData.append('url', url);
            formData.append('_token', "{{ csrf_token() }}");

            var image = document.getElementById('image');
            if (image.files.length > 0) {
                formData.append('image', image.files[0]);
            }

            $.ajax({
                url: "{{ url('/link/validate') }}/" + action,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function() {
                    $('.fv-plugins-message-container').html('');
                    $('.is-invalid').removeClass('is-invalid');

                    if (action === "Simpan") {
                        send();
                    } else {
                        update(id_link);
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $('.fv-plugins-message-container').html('');
                    if (errors) {
                        $.each(errors, function(key, value) {
                            $('#' + key + '-error').html(value[0]);
                        });
                    }
                }
            });
        });
    });

    function clearForm() {
        document.getElementById("head_title").textContent = "Tambah {{ $title }}";
        $('#myForm')[0].reset();
        document.getElementById("show_image").textContent = "";
        document.getElementById("action").textContent = "Simpan";
        document.getElementById("id_link").value = "";
    }

    function showSuccessToast(message) {
        toastr.success(message, '', {
            iconClass: 'toast-success',
        });
    }

    function showFailedToast(message) {
        toastr.success(message, '', {
            iconClass: 'toast-error',
        });
    }

    function send() {
        var formData = new FormData($('#myForm')[0]);
        $('#loading').show();

        $.ajax({
            url: "{{ url('link/store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                showSuccessToast(response.message);
                $('#myForm')[0].reset();
                $('#loading').hide();
                $('#kt_modal_add_link').modal('hide');
                table.ajax.reload(null, false);
            },
            error: function(xhr) {
                console.error("Error pengiriman formulir:", xhr);
            }
        });
    }

    function getData(id) {
        document.getElementById("head_title").textContent = "Ubah {{ $title }}";
        document.getElementById("action").textContent = "Update";

        $.ajax({
            url: "{{ url('/link/edit') }}/" + id,
            type: "GET",
            success: function(response) {
                document.getElementById("id_link").value = response.data.id;
                document.getElementById("name").value = response.data.name;
                document.getElementById("url").value = response.data.url;

                var imageLink = '<br><a href="{{ asset("storage/upload/link/") }}/' + response.data.image + '" class="btn mb-2 mr-1 btn-sm btn-info snackbar-bg-info" target="_blank">Lihat Gambar Sebelumnya</a>';
                document.getElementById("show_image").innerHTML = imageLink;
            },
            error: function(xhr) {
                let res = xhr.responseJSON;
                if (res && res.message) {
                    showFailedToast(res.message);
                } else {
                    showFailedToast("Terjadi kesalahan saat menyimpan data.");
                }
                console.error("Error pengiriman formulir:", xhr);
            }
        });
    }

    function update(id) {
        var formData = new FormData($('#myForm')[0]);
        $('#loading').show();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('_method', "PUT");

        $.ajax({
            url: "{{ url('/link/edit') }}/" + id,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                showSuccessToast(response.message);
                $('#myForm')[0].reset();
                $('#loading').hide();
                $('#kt_modal_add_link').modal('hide');
                table.ajax.reload(null, false);
            },
            error: function(xhr) {
                let res = xhr.responseJSON;
                if (res && res.message) {
                    showFailedToast(res.message);
                } else {
                    showFailedToast("Terjadi kesalahan saat menyimpan data.");
                }
                console.error("Error pengiriman formulir:", xhr);
            }
        });
    }

    function deleteData(id) {
        new Swal({
            title: 'Apakah Kamu Yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            padding: '2em'
        }).then(function(result) {
            if (result.isConfirmed) {
                $('#loading').show();
                $.ajax({
                    url: "{{ url('/link/delete') }}/" + id,
                    success: function(response) {
                        $('#loading').hide();
                        new Swal('Deleted!', 'Data Berhasil Dihapus.', 'success').then(function() {
                            showSuccessToast(response.message);
                            $('#myForm')[0].reset();
                            table.ajax.reload(null, false);
                        });
                    },
                    error: function(xhr) {
                        $('#loading').hide();
                        console.error("Error pengiriman formulir:", xhr);
                    }
                });
            }
        });
    }
</script>

@endsection
