@extends('layouts.app')

@section('title', 'Layanan Cuti ASN')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Layanan Kepegawaian</span>
                        <h1 class="fs-3 fs-2 fw-bolder text-dark">Layanan Cuti ASN</h1>
                    </div>
                </div>
                <hr class="border-light">
                <div class="stack-gap-3 text-secondary small">
                    <p>
                        Setiap PNS dan PPPK berhak atas cuti tahunan, cuti besar, cuti sakit, cuti melahirkan, cuti karena alasan penting, dan cuti di luar tanggungan negara dengan ketentuan perundang-undangan yang berlaku.
                    </p>
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <div class="bg-body-tertiary p-3 rounded-3 border border-light-subtle">
                            <h4 class="fw-bold small text-primary-emphasis mb-1">Cuti Tahunan</h4>
                            <p class="small text-secondary">Hak cuti 12 hari kerja setelah bekerja sekurang-kurangnya 1 tahun secara terus menerus.</p>
                        </div>
                        <div class="bg-body-tertiary p-3 rounded-3 border border-light-subtle">
                            <h4 class="fw-bold small text-primary-emphasis mb-1">Cuti Sakit / Melahirkan</h4>
                            <p class="small text-secondary">Disertai surat keterangan dokter atau instansi kesehatan resmi di wilayah Konawe Kepulauan.</p>
                        </div>
                    </div>
                    <div class="pt-3">
                        <button onclick="triggerSimulateService('Pengajuan Cuti ASN')" class="bg-primary hover-primary-dark text-white fw-bold small px-4 py-3 rounded-3 shadow">
                            <i class="fa-solid fa-paper-plane me-2"></i> Ajukan Permohonan Cuti
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection
