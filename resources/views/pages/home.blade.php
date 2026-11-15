@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="stack-gap-5 pb-5">
            <!-- Hero Banner -->
            <div id="homeHeroCarousel" class="carousel slide carousel-fade shadow" data-bs-ride="carousel" data-bs-interval="5000">
                @if ($slider->count() > 1)
                    <div class="carousel-indicators">
                        @foreach ($slider as $index => $slide)
                            <button type="button" data-bs-target="#homeHeroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                @endif

                <div class="carousel-inner">
                    @forelse ($slider as $index => $slide)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/upload/slider/'.$slide->image) }}" class="d-block w-100" alt="Slider BKD Kabupaten Konawe Kepulauan" style="height: 700px; object-fit: cover; background-color: #042743;">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center text-center text-white px-3" style="background: linear-gradient(90deg, rgba(4, 39, 67, .82), rgba(4, 39, 67, .45));">
                                <div class="content-wide mx-auto">
                                    <span class="bg-warning text-primary-emphasis fw-bold px-3 py-1 rounded-pill small text-uppercase d-inline-block shadow">
                                        <i class="fa-solid fa-shield-halved me-1"></i> Badan Kepegawaian Daerah
                                    </span>
                                    <h1 class="display-5 fw-bolder lh-1 mt-4">
                                        Kabupaten Konawe Kepulauan
                                    </h1>
                                    <p class="text-light fs-6 content-reading mx-auto fw-light lh-lg mt-3">
                                        Mewujudkan Aparatur Sipil Negara (ASN) yang Profesional, Berintegritas, Melayani, dan Berakhlak untuk Kemajuan Pulau Wawonii.
                                    </p>
                                    <div class="d-flex flex-wrap justify-content-center gap-3 pt-3">
                                        <a href="{{ url('page-promotion') }}" class="btn btn-warning fw-bold px-4 py-3 shadow">
                                            <i class="fa-solid fa-file-lines me-2"></i>Layanan Kepegawaian
                                        </a>
                                        <a href="{{ url('page-announcement') }}" class="btn btn-outline-light fw-semibold px-4 py-3">
                                            <i class="fa-solid fa-bullhorn text-warning me-2"></i>Lihat Pengumuman
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="carousel-item active">
                            <div class="hero-pattern text-white hero-padding px-3 text-center position-relative" style="min-height: 420px;">
                                <div class="content-wide mx-auto stack-gap-4 position-relative z-1">
                                    <span class="bg-warning text-primary-emphasis fw-bold px-3 py-1 rounded-pill small text-uppercase d-inline-block shadow">
                                        <i class="fa-solid fa-shield-halved me-1"></i> Badan Kepegawaian Daerah
                                    </span>
                                    <h1 class="display-5 fw-bolder lh-1">
                                        Kabupaten Konawe Kepulauan
                                    </h1>
                                    <p class="text-light fs-6 content-reading mx-auto fw-light lh-lg">
                                        Mewujudkan Aparatur Sipil Negara (ASN) yang Profesional, Berintegritas, Melayani, dan Berakhlak untuk Kemajuan Pulau Wawonii.
                                    </p>
                                    <div class="d-flex flex-wrap justify-content-center gap-3 pt-3">
                                        <a href="{{ url('page-promotion') }}" class="btn btn-warning fw-bold px-4 py-3 shadow">
                                            <i class="fa-solid fa-file-lines me-2"></i>Layanan Kepegawaian
                                        </a>
                                        <a href="{{ url('page-announcement') }}" class="btn btn-outline-light fw-semibold px-4 py-3">
                                            <i class="fa-solid fa-bullhorn text-warning me-2"></i>Lihat Pengumuman
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if ($slider->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="prev" aria-label="Slide sebelumnya">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="next" aria-label="Slide berikutnya">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                @endif
            </div>

            <!-- Sambutan Kepala Badan -->
            <section class="container mx-auto">
                <div class="bg-white rounded-4 shadow border border-light row align-items-center">
                    <div class="col-lg-4 bg-primary-subtle p-4 d-flex flex-column align-items-center justify-content-center text-center position-relative">
                        <div class="size-48 rounded-4 bg-primary-subtle border mb-3 border-4 shadow position-relative overflow-hidden">
                            <img src="{{ asset('storage/upload/profile/' . $profile->image) }}" alt="Kepala BKD Konkep" class="w-100 h-100 object-fit-cover">
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
                        {!! $profile->text !!}
                    </div>
                </div>
            </section>

            <!-- Quick Links -->
            <section class="container mx-auto">
                <div class="text-center mb-5">
                    <h2 class="fs-3 fw-bold text-dark">Akses Cepat Layanan</h2>
                    <p class="small text-secondary mt-1">Pilih layanan utama kepegawaian yang sering diakses oleh ASN Konawe Kepulauan</p>
                </div>
                <div class="row">
                    <div class="col-lg-3" >
                        <a href="{{ url('page-promotion') }}" class="bg-white p-4 rounded-4 shadow-sm hover-shadow border border-light text-center hover-parent d-flex flex-column align-items-center">
                            <div class="size-14 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-3 mb-3 group-hover-primary group-hover-white">
                                <i class="fa-solid fa-award"></i>
                            </div>
                            <h4 class="fw-bold small text-body group-hover-primary-text">Kenaikan Pangkat</h4>
                            <p class="small text-secondary mt-1">Usulan reguler & pilihan</p>
                        </a>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{ url('page-retirement') }}" class="bg-white p-4 rounded-4 shadow-sm hover-shadow border border-light text-center hover-parent d-flex flex-column align-items-center">
                            <div class="size-14 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-3 mb-3 group-hover-primary group-hover-white">
                                <i class="fa-solid fa-file-shield"></i>
                            </div>
                            <h4 class="fw-bold small text-body group-hover-primary-text">Pensiun Pegawai</h4>
                            <p class="small text-secondary mt-1">BUP & janda/duda</p>
                        </a>
                    </div>
                    <div class="col-lg-3">
                    <a href="{{ url('page-transfer') }}" class="bg-white p-4 rounded-4 shadow-sm hover-shadow border border-light text-center hover-parent d-flex flex-column align-items-center">
                        <div class="size-14 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-3 mb-3 group-hover-primary group-hover-white">
                            <i class="fa-solid fa-arrows-split-up-and-left"></i>
                        </div>
                        <h4 class="fw-bold small text-body group-hover-primary-text">Mutasi / Pindah</h4>
                        <p class="small text-secondary mt-1">Antar instansi & daerah</p>
                    </a>
                    </div>
                    <div class="col-lg-3">
                    <a href="{{ url('page-announcement') }}" class="bg-white p-4 rounded-4 shadow-sm hover-shadow border border-light text-center hover-parent d-flex flex-column align-items-center">
                        <div class="size-14 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-3 mb-3 group-hover-primary group-hover-white">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <h4 class="fw-bold small text-body group-hover-primary-text">Pengumuman</h4>
                        <p class="small text-secondary mt-1">Informasi & formasi</p>
                    </a>
                    </div>
                </div>
            </section>

            <!-- Statistik Pegawai / ASN -->
            <section class="container mx-auto">
                <div class="bg-gradient-primary rounded-4 p-4 p-5 text-white shadow-lg position-relative">
                     <!-- Background Icon -->
                    <div class="position-absolute end-0 bottom-0 opacity-10 pe-none"
                        style="z-index: 0;color: #1e648f;">
                        <i class="fa-solid fa-chart-pie display-icon"></i>
                    </div>
                    <div class="position-relative z-1">
                        <div class="text-center content-reading mx-auto mb-5">
                            <span class="bg-warning text-primary-emphasis fw-bold px-3 py-1 rounded-pill text-10 text-uppercase tracking-wider">Data Statistik</span>
                            <h2 class="fs-3 fs-2 fw-bolder mt-2">Statistik ASN Kabupaten Konawe Kepulauan</h2>
                            <p class="text-light small mt-1">Rekapitulasi data kepegawaian aktif di lingkup Pemerintah Kabupaten Konawe Kepulauan</p>
                        </div>
                        <div class="row">
                            
                            <div class="col-lg-3" >
                                <div class="bg-white bg-opacity-10 p-4 rounded-4 border border-white border-opacity-10">
                                    <i class="fa-solid fa-users fs-2 text-warning mb-3"></i>
                                    <h3 class="fs-2 fw-bolder">2.450</h3>
                                    <p class="small text-light mt-1">Total ASN Aktif</p>
                                </div>
                            </div>
                            <div class="col-lg-3" >
                                <div class="bg-white bg-opacity-10 p-4 rounded-4 border border-white border-opacity-10">
                                    <i class="fa-solid fa-user-tie fs-2 text-warning mb-3"></i>
                                    <h3 class="fs-2 fw-bolder">1.980</h3>
                                    <p class="small text-light mt-1">Pegawai PNS</p>
                                </div>
                            </div>
                            <div class="col-lg-3" >
                                <div class="bg-white bg-opacity-10 p-4 rounded-4 border border-white border-opacity-10">
                                    <i class="fa-solid fa-id-badge fs-2 text-warning mb-3"></i>
                                    <h3 class="fs-2 fw-bolder">470</h3>
                                    <p class="small text-light mt-1">Pegawai PPPK</p>
                                </div>
                            </div>
                            <div class="col-lg-3" >
                                <div class="bg-white bg-opacity-10 p-4 rounded-4 border border-white border-opacity-10">
                                    <i class="fa-solid fa-building-columns fs-2 text-warning mb-3"></i>
                                    <h3 class="fs-2 fw-bolder">24</h3>
                                    <p class="small text-light mt-1">OPD / Dinas Terkait</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Berita Terbaru -->
            <section class="container mx-auto">
                <div class="d-flex justify-content-between align-items-end mb-5">
                    <div>
                        <h2 class="fs-3 fw-bold text-dark">Berita & Informasi Terbaru</h2>
                        <p class="small text-secondary mt-1">Update kegiatan dan kebijakan terbaru dari BKD Konawe Kepulauan</p>
                    </div>
                    <a href="{{ url('page-announcement') }}" class="d-sm-flex align-items-center gap-1 text-primary fw-semibold small hover-underline">
                        Lihat Semua <i class="fa-solid fa-arrow-right text-10"></i>
                    </a>
                </div>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($news as $v)
                    <div class="col-lg-4">
                        <div class="bg-white rounded-4 shadow-sm hover-shadow border border-light d-flex flex-column">
                            <div class="rounded-top-4 position-relative overflow-hidden">
                                <img src="{{ asset('storage/upload/news/' . $v->cover) }}" alt="Berita 1" class="w-100 h-100 object-fit-cover hover-scale">
                                {{--<span class="position-absolute bg-primary text-white text-10 fw-bold px-3 py-1 rounded-2">Kepegawaian</span>--}}
                            </div>
                            <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                                <div>
                                    <p class="text-11 text-secondary mb-2"><i class="fa-regular fa-calendar me-1"></i> {{ $v->created_at->format('d M Y') }}</p>
                                    <h3 class="fw-bold fs-6 text-body lh-sm mb-2">{{ $v->title }}</h3>
                                    <p class="small text-secondary line-clamp-2">{!! Str::limit(strip_tags($v->text), 200, ' ...') !!}</p>
                                </div>
                                <a href="{{ url('page-news-detail?q='.$v->slug) }}" class="mt-3 text-primary fw-semibold small d-flex align-items-center gap-1 hover-primary-dark">
                                    Baca Selengkapnya <i class="fa-solid fa-chevron-right text-9"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        </div>
@endsection
