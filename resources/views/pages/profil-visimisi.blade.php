@extends('layouts.app')

@section('title', 'Visi dan Misi')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-5">
                <div>
                    <span class="text-primary fw-bold small text-uppercase tracking-wider bg-primary-subtle px-3 py-1 rounded-pill">Arah Kebijakan</span>
                    <h1 class="fs-2 fw-bolder text-dark mt-3">Visi & Misi BKD Kabupaten Konawe Kepulauan</h1>
                </div>

                <div class="bg-primary-subtle border-start border-4 p-4 rounded-end-4">
                    <h3 class="fw-bold text-primary-emphasis fs-6 mb-2"><i class="fa-solid fa-eye me-2"></i> Visi</h3>
                    <p class="text-secondary-emphasis fs-6 fst-italic fw-medium">
                        "Terwujudnya Manajemen ASN Kabupaten Konawe Kepulauan yang Profesional, Berintegritas, dan Berakhlak Menuju Wawonii yang Maju dan Sejahtera."
                    </p>
                </div>

                <div>
                    <h3 class="fw-bold text-dark fs-5 mb-3"><i class="fa-solid fa-bullseye text-warning me-2"></i> Misi</h3>
                    <ul class="stack-gap-3 small text-secondary">
                        <li class="d-flex align-items-start gap-3 bg-body-tertiary p-3 rounded-3 border border-light">
                            <span class="size-6 bg-primary text-white rounded-pill d-flex align-items-center justify-content-center fw-bold small flex-shrink-0 mt-1">1</span>
                            <span>Meningkatkan kualitas perencanaan, pengadaan, dan penempatan pegawai sesuai dengan kompetensi dan kebutuhan formasi daerah.</span>
                        </li>
                        <li class="d-flex align-items-start gap-3 bg-body-tertiary p-3 rounded-3 border border-light">
                            <span class="size-6 bg-primary text-white rounded-pill d-flex align-items-center justify-content-center fw-bold small flex-shrink-0 mt-1">2</span>
                            <span>Mengembangkan kapasitas, kompetensi, dan profesionalisme ASN secara berkelanjutan dan merata di seluruh wilayah pulau.</span>
                        </li>
                        <li class="d-flex align-items-start gap-3 bg-body-tertiary p-3 rounded-3 border border-light">
                            <span class="size-6 bg-primary text-white rounded-pill d-flex align-items-center justify-content-center fw-bold small flex-shrink-0 mt-1">3</span>
                            <span>Menyelenggarakan pelayanan administrasi kepegawaian yang transparan, cepat, berbasis digital, dan berorientasi pada kepuasan pelanggan.</span>
                        </li>
                        <li class="d-flex align-items-start gap-3 bg-body-tertiary p-3 rounded-3 border border-light">
                            <span class="size-6 bg-primary text-white rounded-pill d-flex align-items-center justify-content-center fw-bold small flex-shrink-0 mt-1">4</span>
                            <span>Menegakkan disiplin, kode etik, serta kesejahteraan aparatur sipil negara secara adil dan akuntabel.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
@endsection
