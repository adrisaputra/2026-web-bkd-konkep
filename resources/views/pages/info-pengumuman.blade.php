@extends('layouts.app')

@section('title', 'Pengumuman Resmi')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Publikasi Resmi</span>
                        <h1 class="fs-3 fs-2 fw-bolder text-dark">Pengumuman & Berita Kepegawaian</h1>
                    </div>
                </div>
                <hr class="border-light">
                <div class="stack-gap-3">
                    <div class="p-3 rounded-4 border border-light-subtle hover-border-primary bg-body-tertiary d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-4">
                        <div>
                            <span class="bg-primary text-white text-10 fw-bold px-2 py-1 rounded">Formasi PPPK</span>
                            <h3 class="fw-bold small text-body mt-1">Pengumuman Hasil Seleksi Administrasi PPPK Tahap I Kabupaten Konawe Kepulauan Tahun 2026</h3>
                            <p class="small text-secondary mt-1"><i class="fa-regular fa-calendar me-1"></i> 20 Mei 2026</p>
                        </div>
                        <button onclick="triggerDownload('Pengumuman_PPPK_Konkep_2026.pdf')" class="bg-primary hover-primary-dark text-white fw-semibold small px-3 py-2 rounded-3 shadow flex-shrink-0">
                            <i class="fa-solid fa-download me-1"></i> Unduh PDF
                        </button>
                    </div>
                    <div class="p-3 rounded-4 border border-light-subtle hover-border-primary bg-body-tertiary d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-4">
                        <div>
                            <span class="bg-warning text-primary-emphasis text-10 fw-bold px-2 py-1 rounded">Kenaikan Pangkat</span>
                            <h3 class="fw-bold small text-body mt-1">Jadwal Pemberkasan Usulan Kenaikan Pangkat Periode 1 Oktober 2026</h3>
                            <p class="small text-secondary mt-1"><i class="fa-regular fa-calendar me-1"></i> 15 Mei 2026</p>
                        </div>
                        <button onclick="triggerDownload('Jadwal_KP_Oktober_2026.pdf')" class="bg-primary hover-primary-dark text-white fw-semibold small px-3 py-2 rounded-3 shadow flex-shrink-0">
                            <i class="fa-solid fa-download me-1"></i> Unduh PDF
                        </button>
                    </div>
                    <div class="p-3 rounded-4 border border-light-subtle hover-border-primary bg-body-tertiary d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-4">
                        <div>
                            <span class="bg-success text-white text-10 fw-bold px-2 py-1 rounded">Diklat</span>
                            <h3 class="fw-bold small text-body mt-1">Pendaftaran Pelatihan Kepemimpinan Administrator (PKA) dan Pengawas Angkatan XIII</h3>
                            <p class="small text-secondary mt-1"><i class="fa-regular fa-calendar me-1"></i> 02 Mei 2026</p>
                        </div>
                        <button onclick="triggerDownload('Info_Diklat_PKA_2026.pdf')" class="bg-primary hover-primary-dark text-white fw-semibold small px-3 py-2 rounded-3 shadow flex-shrink-0">
                            <i class="fa-solid fa-download me-1"></i> Unduh PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection
