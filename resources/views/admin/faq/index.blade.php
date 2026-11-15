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
                            <a href="{{ url('/'.Request::segment(1)) }}" class="btn btn-warning btn-icon btn-sm me-2 mb-2" title="Refresh Halaman"><i class="fa fa-undo"></i></a>
                            <a class="btn btn-success btn-sm me-2 mb-2" data-bs-toggle="modal" data-bs-target="#kt_modal_add_faq" onClick="clearForm()"><i class="fa fa-plus"></i>Tambah {{ __($title) }}</a>
                        </div>
                    </div>

                    @include('admin.faq.create')
                </div>
                <div class="card-body pt-0">
                    <table class="table table-striped table-rounded border border-gray-300 table-row-bordered gy-2 gs-6" id="faq-table">
                        <thead style="background-color: #d30e00;">
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th style="display: none;">ID</th>
                                <th style="width: 4%;color: white;border-bottom: white;">No</th>
                                <th style="color: white;border-bottom: white;">Pertanyaan</th>
                                <th style="color: white;border-bottom: white;">Jawaban</th>
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
        table = $('#faq-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('faq.list') }}",
            columns: [
                {data: 'id', name: 'id', visible: false},
                {data: 'number', name: 'number', orderable: false, searchable: false},
                {data: 'question', name: 'question'},
                {data: 'answer', name: 'answer'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            order: [[0, 'asc']],
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
            var id = $('#id_faq').val();
            var formData = new FormData($('#myForm')[0]);
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ url('/faq/validate') }}/" + encodeURIComponent(action),
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
        document.getElementById('id_faq').value = '';
        document.getElementById('action').textContent = 'Simpan';
        $('.fv-plugins-message-container').html('');
        $('.is-invalid').removeClass('is-invalid');
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
        toastr.success(message, '', {
            iconClass: 'toast-success'
        });
    }

    function send() {
        $('#loading').show();

        $.ajax({
            url: "{{ url('/faq/store') }}",
            type: 'POST',
            data: new FormData($('#myForm')[0]),
            contentType: false,
            processData: false,
            success: function(response) {
                showSuccessToast(response.message);
                $('#myForm')[0].reset();
                $('#loading').hide();
                $('#kt_modal_add_faq').modal('hide');
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
        clearValidationErrors();

        $.ajax({
            url: "{{ url('/faq/edit') }}/" + id,
            type: 'GET',
            success: function(response) {
                document.getElementById('id_faq').value = response.data.id;
                document.getElementById('question').value = response.data.question;
                document.getElementById('answer').value = response.data.answer;
            },
            error: function(xhr) {
                console.error('Error mengambil FAQ:', xhr);
            }
        });
    }

    function clearValidationErrors() {
        $('.fv-plugins-message-container').html('');
        $('.is-invalid').removeClass('is-invalid');
    }

    function update(id) {
        var formData = new FormData($('#myForm')[0]);
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('_method', 'PUT');
        $('#loading').show();

        $.ajax({
            url: "{{ url('/faq/edit') }}/" + id,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                showSuccessToast(response.message);
                $('#myForm')[0].reset();
                $('#loading').hide();
                $('#kt_modal_add_faq').modal('hide');
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
                url: "{{ url('/faq/delete') }}/" + id,
                type: 'GET',
                success: function(response) {
                    showSuccessToast(response.message);
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    console.error('Error menghapus FAQ:', xhr);
                }
            });
        });
    }
</script>

@endsection
