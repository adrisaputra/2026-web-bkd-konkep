@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                        <i class="fa-solid fa-circle-question"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Tanya Jawab</span>
                        <h1 class="fs-3 fs-2 fw-bolder text-dark">Pertanyaan Sering Diajukan (FAQ)</h1>
                    </div>
                </div>
                <hr class="border-light">
                <div class="stack-gap-3">
                    <div class="bg-body-tertiary p-4 rounded-4 border border-light-subtle stack-gap-2">
                        <h4 class="fw-bold small text-body"><i class="fa-solid fa-q text-primary me-2"></i> Bagaimana cara mengecek status kenaikan pangkat ASN di Konawe Kepulauan?</h4>
                        <p class="small text-secondary">ASN dapat mengecek progres usulan kenaikan pangkat secara berkala melalui aplikasi SIMPEG BKD Konkep atau berkoordinasi langsung dengan Bidang Mutasi.</p>
                    </div>
                    <div class="bg-body-tertiary p-4 rounded-4 border border-light-subtle stack-gap-2">
                        <h4 class="fw-bold small text-body"><i class="fa-solid fa-q text-primary me-2"></i> Di mana alamat kantor BKD Kabupaten Konawe Kepulauan?</h4>
                        <p class="small text-secondary">Kantor BKD berlokasi di Kompleks Perkantoran Bupati Konawe Kepulauan di Langara, Kecamatan Wawonii Barat.</p>
                    </div>
                    <div class="bg-body-tertiary p-4 rounded-4 border border-light-subtle stack-gap-2">
                        <h4 class="fw-bold small text-body"><i class="fa-solid fa-q text-primary me-2"></i> Apakah layanan pengaduan kepegawaian dipungut biaya?</h4>
                        <p class="small text-secondary">Seluruh layanan administrasi dan pengaduan di BKD Konawe Kepulauan adalah <strong>GRATIS</strong> dan bebas dari pungutan liar (Pungli).</p>
                    </div>
                </div>
            </div>
        </div>
@endsection
