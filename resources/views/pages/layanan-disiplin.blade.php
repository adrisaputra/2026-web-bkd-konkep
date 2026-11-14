@extends('layouts.app')

@section('title', 'Disiplin dan Kinerja')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Layanan Kepegawaian</span>
                        <h1 class="fs-3 fs-2 fw-bolder text-dark">Layanan Disiplin & Kinerja ASN</h1>
                    </div>
                </div>
                <hr class="border-light">
                <div class="stack-gap-3 text-secondary small">
                    <p>
                        Pengawasan dan penegakan disiplin Pegawai Negeri Sipil berlandaskan pada Peraturan Pemerintah Nomor 94 Tahun 2021 tentang Disiplin Pegawai Negeri Sipil serta pengelolaan e-Kinerja BKN.
                    </p>
                    <div class="bg-body-tertiary p-4 rounded-4 border border-light-subtle stack-gap-2">
                        <h4 class="fw-bold text-primary-emphasis small">Pelaporan & Konsultasi Disiplin</h4>
                        <p class="small text-secondary">
                            Setiap pangkat/golongan wajib menaati jam kerja instansi dan melaporkan target kinerja bulanan secara berkala melalui sistem penilaian kinerja terpadu.
                        </p>
                    </div>
                    <div class="pt-3">
                        <button onclick="triggerSimulateService('Konsultasi Disiplin ASN')" class="bg-primary hover-primary-dark text-white fw-bold small px-4 py-3 rounded-3 shadow">
                            <i class="fa-solid fa-headset me-2"></i> Konsultasi Disiplin / Kinerja
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection
