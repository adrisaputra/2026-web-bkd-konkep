@extends('layouts.app')

@section('title', 'Produk Hukum dan Peraturan')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Regulasi</span>
                        <h1 class="fs-3 fs-2 fw-bolder text-dark">Produk Hukum & Peraturan Kepegawaian</h1>
                    </div>
                </div>
                <hr class="border-light">
                <div class="stack-gap-3">
                    <div class="p-3 rounded-4 border border-light-subtle bg-body-tertiary d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold small text-body">Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara</h4>
                            <p class="small text-secondary mt-1">Regulasi utama pengelolaan manajemen ASN nasional terbaru.</p>
                        </div>
                        <button onclick="triggerDownload('UU_No_20_Tahun_2023.pdf')" class="text-primary hover-primary-dark fw-bold small d-flex align-items-center gap-1 flex-shrink-0 bg-white px-3 py-2 rounded-3 border border-light-subtle shadow-sm">
                            <i class="fa-solid fa-download"></i> Unduh
                        </button>
                    </div>
                    <div class="p-3 rounded-4 border border-light-subtle bg-body-tertiary d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold small text-body">Peraturan Pemerintah Nomor 94 Tahun 2021 tentang Disiplin PNS</h4>
                            <p class="small text-secondary mt-1">Pedoman penegakan kewajiban dan larangan bagi pegawai.</p>
                        </div>
                        <button onclick="triggerDownload('PP_No_94_Tahun_2021.pdf')" class="text-primary hover-primary-dark fw-bold small d-flex align-items-center gap-1 flex-shrink-0 bg-white px-3 py-2 rounded-3 border border-light-subtle shadow-sm">
                            <i class="fa-solid fa-download"></i> Unduh
                        </button>
                    </div>
                    <div class="p-3 rounded-4 border border-light-subtle bg-body-tertiary d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold small text-body">Peraturan Bupati Konawe Kepulauan tentang Struktur Organisasi BKD</h4>
                            <p class="small text-secondary mt-1">Pedoman tata kerja dan uraian tugas instansi.</p>
                        </div>
                        <button onclick="triggerDownload('Perbup_OTK_BKD_Konkep.pdf')" class="text-primary hover-primary-dark fw-bold small d-flex align-items-center gap-1 flex-shrink-0 bg-white px-3 py-2 rounded-3 border border-light-subtle shadow-sm">
                            <i class="fa-solid fa-download"></i> Unduh
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection
