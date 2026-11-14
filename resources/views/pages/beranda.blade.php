@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="stack-gap-5 pb-5">
            <!-- Hero Banner -->
            <div class="hero-pattern text-white hero-padding px-3 text-center position-relative shadow">
                <div class="content-wide mx-auto stack-gap-4 position-relative z-1">
                    <span class="bg-warning text-primary-emphasis fw-bold px-3 py-1 rounded-pill small text-uppercase tracking-widest d-inline-block shadow">
                        <i class="fa-solid fa-shield-halved me-1"></i> Badan Kepegawaian Daerah
                    </span>
                    <h1 class="fs-2 display-5 fw-bolder tracking-tight lh-1">
                        Kabupaten Konawe Kepulauan
                    </h1>
                    <p class="text-light small fs-6 content-reading mx-auto fw-light lh-lg">
                        Mewujudkan Aparatur Sipil Negara (ASN) yang Profesional, Berintegritas, Melayani, dan Berakhlak untuk Kemajuan Pulau Wawonii.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-4 pt-3">
                        <a href="{{ route('page.layanan-pangkat') }}" class="bg-warning hover-warning text-primary-emphasis fw-bold px-4 py-3 rounded-3 shadow-lg d-flex align-items-center gap-2 small">
                            <i class="fa-solid fa-file-lines"></i> Layanan Kepegawaian
                        </a>
                        <a href="{{ route('page.info-pengumuman') }}" class="bg-white bg-opacity-10 hover-bg-white text-white fw-semibold px-4 py-3 rounded-3 border border-white border-opacity-25 d-flex align-items-center gap-2 small">
                            <i class="fa-solid fa-bullhorn text-warning"></i> Lihat Pengumuman
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sambutan Kepala Badan -->
            <section class="container mx-auto px-3">
                <div class="bg-white rounded-4 shadow border border-light row align-items-center">
                    <div class="col-lg-4 bg-primary-subtle p-4 d-flex flex-column align-items-center justify-content-center text-center position-relative">
                        <div class="size-48 rounded-4 bg-primary-subtle border mb-3 border-4 shadow position-relative overflow-hidden">
                            <img src="https://placehold.co/400x500/0369a1/ffffff?text=Kepala+BKD" alt="Kepala BKD Konkep" class="w-100 h-100 object-fit-cover">
                        </div>
                        <h3 class="fw-bold fs-5 text-primary-emphasis">Drs. H. M. Taslim, M.Si</h3>
                        <p class="small text-primary fw-medium">Kepala Badan Kepegawaian Daerah</p>
                        <span class="mt-2 text-10 text-secondary bg-white px-3 py-1 rounded-pill border border-light-subtle">NIP. 19721231 199503 1 001</span>
                    </div>
                    <div class="col-lg-8 p-4 p-5 stack-gap-4">
                        <div class="d-flex align-items-center gap-2 text-primary fw-bold small text-uppercase tracking-wider">
                            <i class="fa-solid fa-quote-left fs-3 text-warning"></i>
                            <span>Sambutan Kepala Badan</span>
                        </div>
                        <h2 class="fs-3 fs-2 fw-bold text-dark lh-sm">
                            "Melayani Kepegawaian dengan Transparansi, Cepat, dan Akuntabel."
                        </h2>
                        <div class="stack-gap-3 text-secondary small lh-lg">
                            <p>
                                Puji syukur kita panjatkan ke hadirat Tuhan Yang Maha Esa. Selamat datang di portal resmi Badan Kepegawaian Daerah (BKD) Kabupaten Konawe Kepulauan. Website ini dikembangkan sebagai wujud komitmen kami dalam memberikan keterbukaan informasi publik serta kemudahan akses layanan kepegawaian bagi seluruh ASN di lingkup Pemerintah Kabupaten Konawe Kepulauan (Wawonii).
                            </p>
                            <p>
                                Kami terus berinovasi untuk menghadirkan birokrasi yang bersih, kompeten, dan melayani dengan sepenuh hati demi terwujudnya visi misi daerah.
                            </p>
                        </div>
                        <div class="pt-2 d-flex align-items-center justify-content-between border-top border-light">
                            <div>
                                <p class="small fw-bold text-body">Langara, Wawonii</p>
                                <p class="text-11 text-secondary">Kabupaten Konawe Kepulauan</p>
                            </div>
                            <div class="text-end fs-4 text-primary fw-bold fst-italic">
                                [ Ttd. Kepala BKD ]
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Quick Links -->
            <section class="container mx-auto px-3">
                <div class="text-center mb-5">
                    <h2 class="fs-3 fw-bold text-dark">Akses Cepat Layanan</h2>
                    <p class="small text-secondary mt-1">Pilih layanan utama kepegawaian yang sering diakses oleh ASN Konawe Kepulauan</p>
                </div>
                <div class="row row-cols-2 row-cols-md-4 g-4">
                    <a href="{{ route('page.layanan-pangkat') }}" class="bg-white p-4 rounded-4 shadow-sm hover-shadow border border-light text-center hover-parent d-flex flex-column align-items-center">
                        <div class="size-14 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-3 mb-3 group-hover-primary group-hover-white">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <h4 class="fw-bold small text-body group-hover-primary-text">Kenaikan Pangkat</h4>
                        <p class="small text-secondary mt-1">Usulan reguler & pilihan</p>
                    </a>
                    <a href="{{ route('page.layanan-pensiun') }}" class="bg-white p-4 rounded-4 shadow-sm hover-shadow border border-light text-center hover-parent d-flex flex-column align-items-center">
                        <div class="size-14 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-3 mb-3 group-hover-primary group-hover-white">
                            <i class="fa-solid fa-file-shield"></i>
                        </div>
                        <h4 class="fw-bold small text-body group-hover-primary-text">Pensiun Pegawai</h4>
                        <p class="small text-secondary mt-1">BUP & janda/duda</p>
                    </a>
                    <a href="{{ route('page.layanan-mutasi') }}" class="bg-white p-4 rounded-4 shadow-sm hover-shadow border border-light text-center hover-parent d-flex flex-column align-items-center">
                        <div class="size-14 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-3 mb-3 group-hover-primary group-hover-white">
                            <i class="fa-solid fa-arrows-split-up-and-left"></i>
                        </div>
                        <h4 class="fw-bold small text-body group-hover-primary-text">Mutasi / Pindah</h4>
                        <p class="small text-secondary mt-1">Antar instansi & daerah</p>
                    </a>
                    <a href="{{ route('page.info-pengumuman') }}" class="bg-white p-4 rounded-4 shadow-sm hover-shadow border border-light text-center hover-parent d-flex flex-column align-items-center">
                        <div class="size-14 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-3 mb-3 group-hover-primary group-hover-white">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <h4 class="fw-bold small text-body group-hover-primary-text">Pengumuman</h4>
                        <p class="small text-secondary mt-1">Informasi & formasi</p>
                    </a>
                </div>
            </section>

            <!-- Statistik Pegawai / ASN -->
            <section class="container mx-auto px-3">
                <div class="bg-gradient-primary rounded-4 p-4 p-5 text-white shadow-lg position-relative">
                    <div class="position-absolute end-0 bottom-0 opacity-10 pe-none">
                        <i class="fa-solid fa-chart-pie display-icon"></i>
                    </div>
                    <div class="position-relative z-1">
                        <div class="text-center content-reading mx-auto mb-5">
                            <span class="bg-warning text-primary-emphasis fw-bold px-3 py-1 rounded-pill text-10 text-uppercase tracking-wider">Data Statistik</span>
                            <h2 class="fs-3 fs-2 fw-bolder mt-2">Statistik ASN Kabupaten Konawe Kepulauan</h2>
                            <p class="text-light small mt-1">Rekapitulasi data kepegawaian aktif di lingkup Pemerintah Kabupaten Konawe Kepulauan</p>
                        </div>
                        <div class="row row-cols-2 row-cols-md-4 g-4 text-center">
                            <div class="bg-white bg-opacity-10 p-4 rounded-4 border border-white border-opacity-10">
                                <i class="fa-solid fa-users fs-2 text-warning mb-3"></i>
                                <h3 class="fs-2 fw-bolder">2.450</h3>
                                <p class="small text-light mt-1">Total ASN Aktif</p>
                            </div>
                            <div class="bg-white bg-opacity-10 p-4 rounded-4 border border-white border-opacity-10">
                                <i class="fa-solid fa-user-tie fs-2 text-warning mb-3"></i>
                                <h3 class="fs-2 fw-bolder">1.980</h3>
                                <p class="small text-light mt-1">Pegawai PNS</p>
                            </div>
                            <div class="bg-white bg-opacity-10 p-4 rounded-4 border border-white border-opacity-10">
                                <i class="fa-solid fa-id-badge fs-2 text-warning mb-3"></i>
                                <h3 class="fs-2 fw-bolder">470</h3>
                                <p class="small text-light mt-1">Pegawai PPPK</p>
                            </div>
                            <div class="bg-white bg-opacity-10 p-4 rounded-4 border border-white border-opacity-10">
                                <i class="fa-solid fa-building-columns fs-2 text-warning mb-3"></i>
                                <h3 class="fs-2 fw-bolder">24</h3>
                                <p class="small text-light mt-1">OPD / Dinas Terkait</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Berita Terbaru -->
            <section class="container mx-auto px-3">
                <div class="d-flex justify-content-between align-items-end mb-5">
                    <div>
                        <h2 class="fs-3 fw-bold text-dark">Berita & Informasi Terbaru</h2>
                        <p class="small text-secondary mt-1">Update kegiatan dan kebijakan terbaru dari BKD Konawe Kepulauan</p>
                    </div>
                    <a href="{{ route('page.info-pengumuman') }}" class="d-sm-flex align-items-center gap-1 text-primary fw-semibold small hover-underline">
                        Lihat Semua <i class="fa-solid fa-arrow-right text-10"></i>
                    </a>
                </div>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <div class="bg-white rounded-4 shadow-sm hover-shadow border border-light d-flex flex-column">
                        <div class="size-48 position-relative">
                            <img src="https://placehold.co/600x400/0284c7/ffffff?text=Sosialisasi+ASN" alt="Berita 1" class="w-100 h-100 object-fit-cover hover-scale">
                            <span class="position-absolute bg-primary text-white text-10 fw-bold px-3 py-1 rounded-2">Kepegawaian</span>
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <p class="text-11 text-secondary mb-2"><i class="fa-regular fa-calendar me-1"></i> 24 Mei 2026</p>
                                <h3 class="fw-bold fs-6 text-body lh-sm mb-2">BKD Konkep Gelar Sosialisasi Aplikasi Layanan Kepegawaian Berbasis Digital</h3>
                                <p class="small text-secondary line-clamp-2">Pemberlakuan sistem layanan berbasis digital guna mempercepat proses administrasi kenaikan pangkat dan cuti...</p>
                            </div>
                            <a href="{{ route('page.info-pengumuman') }}" class="mt-3 text-primary fw-semibold small d-flex align-items-center gap-1 hover-primary-dark">
                                Baca Selengkapnya <i class="fa-solid fa-chevron-right text-9"></i>
                            </a>
                        </div>
                    </div>
                    <div class="bg-white rounded-4 shadow-sm hover-shadow border border-light d-flex flex-column">
                        <div class="size-48 position-relative">
                            <img src="https://placehold.co/600x400/074770/ffffff?text=Penyerahan+SK" alt="Berita 2" class="w-100 h-100 object-fit-cover hover-scale">
                            <span class="position-absolute bg-warning text-primary-emphasis text-10 fw-bold px-3 py-1 rounded-2">PPPK</span>
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <p class="text-11 text-secondary mb-2"><i class="fa-regular fa-calendar me-1"></i> 18 Mei 2026</p>
                                <h3 class="fw-bold fs-6 text-body lh-sm mb-2">Penyerahan SK Pengangkatan PPPK Formasi Tahun 2025 di Lingkup Pemkab Konkep</h3>
                                <p class="small text-secondary line-clamp-2">Bupati Konawe Kepulauan menyerahkan secara langsung Surat Keputusan kepada ratusan PPPK yang lolos seleksi...</p>
                            </div>
                            <a href="{{ route('page.info-pengumuman') }}" class="mt-3 text-primary fw-semibold small d-flex align-items-center gap-1 hover-primary-dark">
                                Baca Selengkapnya <i class="fa-solid fa-chevron-right text-9"></i>
                            </a>
                        </div>
                    </div>
                    <div class="bg-white rounded-4 shadow-sm hover-shadow border border-light d-flex flex-column">
                        <div class="size-48 position-relative">
                            <img src="https://placehold.co/600x400/0a3656/ffffff?text=Pelatihan+DK" alt="Berita 3" class="w-100 h-100 object-fit-cover hover-scale">
                            <span class="position-absolute bg-success text-white text-10 fw-bold px-3 py-1 rounded-2">Diklat</span>
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <p class="text-11 text-secondary mb-2"><i class="fa-regular fa-calendar me-1"></i> 10 Mei 2026</p>
                                <h3 class="fw-bold fs-6 text-body lh-sm mb-2">Pelatihan Peningkatan Kompetensi Teknis dan Disiplin ASN Wawonii</h3>
                                <p class="small text-secondary line-clamp-2">Pelatihan rutin guna memastikan setiap aparatur sipil negara mematuhi kode etik dan standar operasional...</p>
                            </div>
                            <a href="{{ route('page.info-pengumuman') }}" class="mt-3 text-primary fw-semibold small d-flex align-items-center gap-1 hover-primary-dark">
                                Baca Selengkapnya <i class="fa-solid fa-chevron-right text-9"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
