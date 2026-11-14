@extends('layouts.app')

@section('title', 'Mutasi dan Pindah Tugas')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                        <i class="fa-solid fa-arrows-split-up-and-left"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Layanan Kepegawaian</span>
                        <h1 class="fs-3 fs-2 fw-bolder text-dark">Mutasi / Pindah Tugas ASN</h1>
                    </div>
                </div>
                <hr class="border-light">
                <div class="stack-gap-3 text-secondary small">
                    <p>
                        Layanan perpindahan tugas pegawai, baik mutasi antar OPD di dalam lingkup Pemerintah Kabupaten Konawe Kepulauan maupun mutasi masuk/keluar dari instansi pusat atau daerah lain ke wilayah Kabupaten Konawe Kepulauan.
                    </p>
                    <div class="bg-primary-subtle p-4 rounded-4 border border-primary-subtle stack-gap-3">
                        <h3 class="fw-bold text-primary-emphasis small text-uppercase tracking-wide"><i class="fa-solid fa-list-check me-2"></i> Persyaratan Mutasi Masuk Konkep:</h3>
                        <ul class="list-disc ps-3 stack-gap-2 small text-primary-emphasis">
                            <li>Surat Permohonan Pindah Instansi dari Pegawai.</li>
                            <li>Rekomendasi persetujuan pindah dari instansi asal (pejabat pembina kepegawaian).</li>
                            <li>Analisis Jabatan (Anjab) dan Analisis Beban Kerja (ABK) formasi tujuan.</li>
                            <li>Surat Bebas Temuan dari Inspektorat daerah asal.</li>
                        </ul>
                    </div>
                    <div class="pt-3">
                        <button onclick="triggerSimulateService('Usulan Mutasi Pegawai')" class="bg-primary hover-primary-dark text-white fw-bold small px-4 py-3 rounded-3 shadow">
                            <i class="fa-solid fa-paper-plane me-2"></i> Ajukan Layanan Mutasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection
