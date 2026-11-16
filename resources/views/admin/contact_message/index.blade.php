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
                        <a href="{{ url('/'.Request::segment(1)) }}" class="btn btn-warning btn-icon btn-sm mb-2" title="Refresh Halaman"><i class="fa fa-undo"></i></a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table table-striped table-rounded border border-gray-300 table-row-bordered gy-2 gs-6" id="contact-message-table">
                        <thead style="background-color: #d30e00;">
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th style="display: none;">ID</th>
                                <th style="width: 4%;color: white;border-bottom: white;">No</th>
                                <th style="color: white;border-bottom: white;">Nama</th>
                                <th style="color: white;border-bottom: white;">NIP / Identitas</th>
                                <th style="color: white;border-bottom: white;">Kontak</th>
                                <th style="color: white;border-bottom: white;">Kategori</th>
                                <th style="color: white;border-bottom: white;">Waktu</th>
                                <th style="width: 10%;color: white;border-bottom: white;">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="kt_modal_view_contact_message" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Detail Pesan Kontak</h2>
                <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <dl class="row">
                    <dt class="col-sm-4">Nama</dt>
                    <dd class="col-sm-8" id="detail-name"></dd>
                    <dt class="col-sm-4">NIP / Identitas</dt>
                    <dd class="col-sm-8" id="detail-identifier"></dd>
                    <dt class="col-sm-4">Email / WhatsApp</dt>
                    <dd class="col-sm-8" id="detail-contact"></dd>
                    <dt class="col-sm-4">Kategori</dt>
                    <dd class="col-sm-8" id="detail-category"></dd>
                    <dt class="col-sm-4">Waktu Dikirim</dt>
                    <dd class="col-sm-8" id="detail-created-at"></dd>
                    <dt class="col-sm-4">Pesan</dt>
                    <dd class="col-sm-8" id="detail-message" style="white-space: pre-line;"></dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    var table;

    $(document).ready(function() {
        table = $('#contact-message-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('contact-messages.list') }}",
            columns: [
                {data: 'id', name: 'id', visible: false},
                {data: 'number', name: 'number', orderable: false, searchable: false},
                {data: 'name', name: 'name', render: $.fn.dataTable.render.text()},
                {data: 'identifier', name: 'identifier', render: $.fn.dataTable.render.text()},
                {data: 'contact', name: 'contact', render: $.fn.dataTable.render.text()},
                {data: 'category_label', name: 'category', render: $.fn.dataTable.render.text()},
                {data: 'received_at', name: 'created_at', orderable: false, render: $.fn.dataTable.render.text()},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            order: [[0, 'desc']],
            paging: true
        });
    });

    function viewData(id) {
        $.ajax({
            url: "{{ url('/contact-message/show') }}/" + id,
            type: 'GET',
            success: function(response) {
                var message = response.data;
                document.getElementById('detail-name').textContent = message.name || '-';
                document.getElementById('detail-identifier').textContent = message.identifier || '-';
                document.getElementById('detail-contact').textContent = message.contact || '-';
                document.getElementById('detail-category').textContent = message.category_label || '-';
                document.getElementById('detail-created-at').textContent = message.created_at || '-';
                document.getElementById('detail-message').textContent = message.message || '-';
            },
            error: function(xhr) {
                console.error('Error mengambil pesan kontak:', xhr);
            }
        });
    }

    function showSuccessToast(message) {
        toastr.success(message, '', {
            iconClass: 'toast-success'
        });
    }

    function deleteData(id) {
        new Swal({
            title: 'Apakah Kamu Yakin?',
            text: 'Pesan yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            padding: '2em'
        }).then(function(result) {
            if (!result.isConfirmed) {
                return;
            }

            $.ajax({
                url: "{{ url('/contact-message/delete') }}/" + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response) {
                    showSuccessToast(response.message);
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    console.error('Error menghapus pesan kontak:', xhr);
                }
            });
        });
    }
</script>

@endsection
