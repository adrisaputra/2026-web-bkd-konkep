@extends('layouts.app')

@section('title', 'Struktur Organisasi')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div>
                    <span class="text-primary fw-bold small text-uppercase tracking-wider bg-primary-subtle px-3 py-1 rounded-pill">Kelembagaan</span>
                    <h1 class="fs-2 fw-bolder text-dark mt-3">Struktur Organisasi BKD Konkep</h1>
                    <p class="text-secondary small mt-1">Bagan susunan organisasi Badan Kepegawaian Daerah Kabupaten Konawe Kepulauan</p>
                </div>

                <div class="border border-light-subtle rounded-4 p-4 bg-body-tertiary text-center stack-gap-4">
                    <div class="d-inline-block bg-primary text-white px-4 py-3 rounded-3 shadow fw-bold small">
                        KEPALA BADAN KEPEGAWAIAN DAERAH<br>
                        <span class="small text-warning fw-normal">Drs. H. M. Taslim, M.Si</span>
                    </div>
                    <div class="divider-width size-8 bg-secondary mx-auto"></div>
                    <div class="d-inline-block bg-dark text-white px-3 py-2 rounded-3 shadow fw-bold small">
                        SEKRETARIAT
                    </div>
                    <div class="row row-cols-1 row-cols-md-3 g-4 pt-3">
                        <div class="bg-white p-3 rounded-3 border border-light-subtle shadow-sm">
                            <h4 class="fw-bold small text-primary-emphasis">Bidang Mutasi & Status Kepegawaian</h4>
                            <p class="text-11 text-secondary mt-1">Mengelola kenaikan pangkat, mutasi, dan kedudukan hukum.</p>
                        </div>
                        <div class="bg-white p-3 rounded-3 border border-light-subtle shadow-sm">
                            <h4 class="fw-bold small text-primary-emphasis">Bidang Pengadaan, Pemberhentian & Informasi</h4>
                            <p class="text-11 text-secondary mt-1">Mengelola formasi CPNS/PPPK, pensiun, dan database SIMPEG.</p>
                        </div>
                        <div class="bg-white p-3 rounded-3 border border-light-subtle shadow-sm">
                            <h4 class="fw-bold small text-primary-emphasis">Bidang Pengembangan Kompetensi & Disiplin</h4>
                            <p class="text-11 text-secondary mt-1">Mengelola diklat, izin belajar, dan penegakan disiplin ASN.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
