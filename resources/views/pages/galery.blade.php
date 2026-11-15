@extends('layouts.app')

@section('title', 'Galeri Kegiatan')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                        <i class="fa-solid fa-images"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Dokumentasi</span>
                        <h1 class="fs-3 fs-2 fw-bolder text-dark">Galeri Kegiatan BKD Konkep</h1>
                    </div>
                </div>
                <hr class="border-light">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    <div class="rounded-4 shadow border border-light hover-parent position-relative">
                        <img src="https://placehold.co/500x350/0284c7/ffffff?text=Rapat+Koordinasi" alt="Kegiatan 1" class="w-100 size-48 object-fit-cover group-hover-scale">
                        <div class="p-3 bg-white">
                            <h4 class="fw-bold small text-body">Rapat Koordinasi Kepegawaian Daerah</h4>
                            <p class="text-11 text-secondary mt-1">Langara, Wawonii</p>
                        </div>
                    </div>
                    <div class="rounded-4 shadow border border-light hover-parent position-relative">
                        <img src="https://placehold.co/500x350/074770/ffffff?text=Penyerahan+SK" alt="Kegiatan 2" class="w-100 size-48 object-fit-cover group-hover-scale">
                        <div class="p-3 bg-white">
                            <h4 class="fw-bold small text-body">Penyerahan SK Pengangkatan PPPK</h4>
                            <p class="text-11 text-secondary mt-1">Aula Kantor Bupati Konkep</p>
                        </div>
                    </div>
                    <div class="rounded-4 shadow border border-light hover-parent position-relative">
                        <img src="https://placehold.co/500x350/d97706/ffffff?text=Sosialisasi+Aplikasi" alt="Kegiatan 3" class="w-100 size-48 object-fit-cover group-hover-scale">
                        <div class="p-3 bg-white">
                            <h4 class="fw-bold small text-body">Bimbingan Teknis e-Kinerja & SIMPEG</h4>
                            <p class="text-11 text-secondary mt-1">Pusat Pelatihan BKD</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
