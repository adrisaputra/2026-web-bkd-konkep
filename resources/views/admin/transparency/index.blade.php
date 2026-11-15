@extends('admin.layout')
@section('content')

<link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3>Data {{ __($title) }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('transparency.index', $category) }}" class="btn btn-warning btn-icon btn-sm me-2 mb-2" title="Refresh Halaman"><i class="fa fa-undo"></i></a>
                            <a class="btn btn-success btn-sm me-2 mb-2" data-bs-toggle="modal" data-bs-target="#kt_modal_add_transparency" onClick="clearForm()"><i class="fa fa-plus"></i>Tambah {{ __($title) }}</a>
                        </div>
                    </div>

                    @include('admin.transparency.create')
                </div>
                <div class="card-body pt-0">
                    <table class="table table-striped table-rounded border border-gray-300 table-row-bordered gy-2 gs-6" id="transparency-table">
                        <thead style="background-color: #d30e00;">
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th style="display: none;">ID</th>
                                <th style="width: 4%;color: white;border-bottom: white;">No</th>
                                <th style="color: white;border-bottom: white;">Judul</th>
                                <th style="color: white;border-bottom: white;">Slug</th>
                                <th style="color: white;border-bottom: white;">Jumlah Unduhan</th>
                                <th style="color: white;border-bottom: white;">Penulis</th>
                                <th style="color: white;border-bottom: white;">File</th>
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
    var category = @json($category);
    var categoryUrl = @json(url('/transparency/'.$category));

    $(document).ready(function() {
        table = $('#transparency-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: @json(route('transparency.list', $category)),
            columns: [
                {data: 'id', name: 'id', visible: false},
                {data: 'number', name: 'number', orderable: false, searchable: false},
                {data: 'title', name: 'title'},
                {data: 'slug', name: 'slug'},
                {data: 'count_view', name: 'count_view'},
                {data: 'user', name: 'user.name', orderable: false},
                {data: 'display_file', name: 'file', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            order: [[0, 'desc']],
            paging: true,
            drawCallback: function() {
                var api = this.api();
                var startIndex = api.context[0]._iDisplayStart;
                api.column(1, {page: 'current'}).nodes().each(function(cell, index) {
                    cell.innerHTML = startIndex + index + 1;
                });
            }
        });

        $('#myForm').submit(function(event) {
            event.preventDefault();

            var action = $('#action').text().trim();
            var id = $('#id_transparency').val();
            var formData = new FormData($('#myForm')[0]);
            formData.append('_token', @json(csrf_token()));

            $.ajax({
                url: categoryUrl + '/validate/' + encodeURIComponent(action),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function() {
                    $('.fv-plugins-message-container').html('');
                    $('.is-invalid').removeClass('is-invalid');

                    if (action === 'Simpan') {
                        send();
                    } else {
                        update(id);
                    }
                },
                error: showErrors
            });
        });
    });

    function clearForm() {
        document.getElementById('head_title').textContent = 'Tambah {{ __($title) }}';
        $('#myForm')[0].reset();
        document.getElementById('id_transparency').value = '';
        document.getElementById('show_file').textContent = '';
        document.getElementById('action').textContent = 'Simpan';
    }

    function showErrors(xhr) {
        var errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
        $('.fv-plugins-message-container').html('');
        $('.is-invalid').removeClass('is-invalid');

        if (errors) {
            $.each(errors, function(key, messages) {
                $('#' + key + '-error').text(messages[0]);
                $('#' + key).addClass('is-invalid');
            });
        } else {
            console.error('Error pengiriman formulir:', xhr);
        }
    }

    function showSuccessToast(message) {
        toastr.success(message, '', {iconClass: 'toast-success'});
    }

    function send() {
        var formData = new FormData($('#myForm')[0]);
        $('#loading').show();

        $.ajax({
            url: categoryUrl + '/store',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                showSuccessToast(response.message);
                $('#myForm')[0].reset();
                $('#loading').hide();
                $('#kt_modal_add_transparency').modal('hide');
                table.ajax.reload(null, false);
            },
            error: function(xhr) {
                $('#loading').hide();
                showErrors(xhr);
            }
        });
    }

    function getData(id) {
        document.getElementById('head_title').textContent = 'Ubah {{ __($title) }}';
        document.getElementById('action').textContent = 'Update';
        document.getElementById('show_file').textContent = '';

        $.ajax({
            url: categoryUrl + '/edit/' + id,
            type: 'GET',
            success: function(response) {
                document.getElementById('id_transparency').value = response.data.id;
                document.getElementById('title').value = response.data.title;
                document.getElementById('text').value = response.data.text || '';

                if (response.data.file) {
                    var link = document.createElement('a');
                    link.href = @json(route('transparency.download', ['category' => $category, 'transparency' => 0])).replace('/0/download', '/' + id + '/download');
                    link.target = '_blank';
                    link.rel = 'noopener';
                    link.className = 'btn btn-sm btn-info mt-2';
                    link.textContent = 'Lihat File Sebelumnya';
                    document.getElementById('show_file').appendChild(link);
                }
            },
            error: function(xhr) {
                console.error('Error mengambil dokumen transparansi:', xhr);
            }
        });
    }

    function update(id) {
        var formData = new FormData($('#myForm')[0]);
        formData.append('_token', @json(csrf_token()));
        formData.append('_method', 'PUT');
        $('#loading').show();

        $.ajax({
            url: categoryUrl + '/edit/' + id,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                showSuccessToast(response.message);
                $('#myForm')[0].reset();
                $('#loading').hide();
                $('#kt_modal_add_transparency').modal('hide');
                table.ajax.reload(null, false);
            },
            error: function(xhr) {
                $('#loading').hide();
                showErrors(xhr);
            }
        });
    }

    function deleteData(id) {
        new Swal({
            title: 'Apakah Kamu Yakin?',
            text: 'Anda tidak akan dapat mengembalikan ini!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            padding: '2em'
        }).then(function(result) {
            if (!result.isConfirmed) {
                return;
            }

            $.ajax({
                url: categoryUrl + '/delete/' + id,
                type: 'GET',
                success: function(response) {
                    showSuccessToast(response.message);
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    console.error('Error menghapus dokumen transparansi:', xhr);
                }
            });
        });
    }
</script>

@endsection
