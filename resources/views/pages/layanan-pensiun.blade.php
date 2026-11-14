@extends('layouts.app')

@section('title', 'Pensiun Pegawai')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Layanan Kepegawaian</span>
                        <h1 class="fs-3 fs-2 fw-bolder text-dark">Pensiun Pegawai (BUP & Janda/Duda)</h1>
                    </div>
                </div>
                <hr class="border-light">
                <div class="stack-gap-3 text-secondary small">
                    <p>
                        Layanan pemberhentian dan pemberian pensiun bagi PNS yang telah mencapai Batas Usia Pensiun (BUP) 58 tahun untuk pejabat pelaksana/pengawas, 60 tahun untuk pejabat administrator, atau atas permintaan sendiri / janda-duda.
                    </p>
                    <div class="bg-primary-subtle p-4 rounded-4 border border-primary-subtle stack-gap-3">
                        <h3 class="fw-bold text-primary-emphasis small text-uppercase tracking-wide"><i class="fa-solid fa-list-check me-2"></i> Syarat Pengurusan Pensiun:</h3>
                        <ul class="list-disc ps-3 stack-gap-2 small text-primary-emphasis">
                            <li>Surat Permohonan Pensiun dari Pegawai bersangkutan.</li>
                            <li>Data Perorangan Calon Penerima Pensiun (DPCP).</li>
                            <li>SK CPNS, SK PNS, dan SK Pangkat Terakhir.</li>
                            <li>Daftar Gaji Terakhir & Kartu Pegawai (Karpeg).</li>
                            <li>Pas foto terbaru ukuran 3x4 (4 lembar).</li>
                        </ul>
                    </div>
                    <div class="pt-3">
                        <button onclick="triggerSimulateService('Pemberkasan Pensiun')" class="bg-primary hover-primary-dark text-white fw-bold small px-4 py-3 rounded-3 shadow">
                            <i class="fa-solid fa-paper-plane me-2"></i> Ajukan Berkas Pensiun
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection
