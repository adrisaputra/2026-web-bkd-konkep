@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
<div class="container mx-auto px-3 py-5 stack-gap-5">
            <div class="text-center content-reading mx-auto">
                <span class="bg-primary-subtle text-primary fw-bold px-3 py-1 rounded-pill small text-uppercase tracking-wider">Hubungi Kami</span>
                <h1 class="fs-2 fw-bolder text-dark mt-2">Pusat Layanan & Pengaduan BKD</h1>
                <p class="small text-secondary mt-1">Silakan kunjungi kantor kami di Langara atau sampaikan pertanyaan dan pengaduan melalui form di bawah ini.</p>
            </div>

            <div class="row g-5 align-items-start">
                <!-- Info Kontak -->
                <div class="col-lg-5 bg-primary text-white p-4 p-5 rounded-4 shadow stack-gap-5">
                    <h3 class="fs-4 fw-bold border-bottom border-primary pb-3">Informasi Kantor BKD</h3>
                    <div class="stack-gap-4 small">
                        <div class="d-flex align-items-start gap-4">
                            <div class="size-10 bg-primary rounded-3 d-flex align-items-center justify-content-center text-warning flex-shrink-0">
                                <i class="fa-solid fa-location-dot fs-5"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold text-white">Alamat Kantor</h4>
                                <p class="small text-white-50 mt-1">Kompleks Perkantoran Bupati Konawe Kepulauan, Langara, Kec. Wawonii Barat, Kabupaten Konawe Kepulauan, Sulawesi Tenggara 93392</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-4">
                            <div class="size-10 bg-primary rounded-3 d-flex align-items-center justify-content-center text-warning flex-shrink-0">
                                <i class="fa-solid fa-envelope fs-5"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold text-white">Email Resmi</h4>
                                <p class="small text-white-50 mt-1">bkd@konkepkab.go.id</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-4">
                            <div class="size-10 bg-primary rounded-3 d-flex align-items-center justify-content-center text-warning flex-shrink-0">
                                <i class="fa-solid fa-phone fs-5"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold text-white">Telepon / WhatsApp</h4>
                                <p class="small text-white-50 mt-1">(0401) 1234567 / +62 821-9876-5432</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-4">
                            <div class="size-10 bg-primary rounded-3 d-flex align-items-center justify-content-center text-warning flex-shrink-0">
                                <i class="fa-solid fa-clock fs-5"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold text-white">Jam Pelayanan</h4>
                                <p class="small text-white-50 mt-1">Senin - Kamis: 08.00 - 16.00 WITA<br>Jumat: 08.00 - 11.30 WITA</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Pesan & Pengaduan -->
                <div class="col-lg-7 bg-white p-4 p-5 rounded-4 shadow border border-light">
                    <h3 class="fs-4 fw-bold text-dark mb-4">Kirim Pesan / Pengaduan Kepegawaian</h3>
                    <form onsubmit="handleContactSubmit(event)" class="stack-gap-3">
                        <div class="row row-cols-1 row-cols-sm-2 g-4">
                            <div>
                                <label class="d-block small fw-bold text-secondary-emphasis mb-1">Nama Lengkap</label>
                                <input type="text" required class="w-100 small bg-body-tertiary border border-light-subtle rounded-3 px-3 py-3 focus-border-primary" placeholder="Masukkan nama lengkap">
                            </div>
                            <div>
                                <label class="d-block small fw-bold text-secondary-emphasis mb-1">NIP / Nomor Identitas (Opsional)</label>
                                <input type="text" class="w-100 small bg-body-tertiary border border-light-subtle rounded-3 px-3 py-3 focus-border-primary" placeholder="NIP bagi ASN Konkep">
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-sm-2 g-4">
                            <div>
                                <label class="d-block small fw-bold text-secondary-emphasis mb-1">Email / WhatsApp</label>
                                <input type="text" required class="w-100 small bg-body-tertiary border border-light-subtle rounded-3 px-3 py-3 focus-border-primary" placeholder="email@domain.com atau no WA">
                            </div>
                            <div>
                                <label class="d-block small fw-bold text-secondary-emphasis mb-1">Kategori Layanan / Perihal</label>
                                <select class="w-100 small bg-body-tertiary border border-light-subtle rounded-3 px-3 py-3 focus-border-primary">
                                    <option>Kenaikan Pangkat</option>
                                    <option>Pensiun</option>
                                    <option>Cuti & Izin</option>
                                    <option>Mutasi / Pindah Tugas</option>
                                    <option>Pengaduan / Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="d-block small fw-bold text-secondary-emphasis mb-1">Pesan atau Pertanyaan Anda</label>
                            <textarea rows="4" required class="w-100 small bg-body-tertiary border border-light-subtle rounded-3 p-3 focus-border-primary" placeholder="Tuliskan pesan atau kendala administrasi kepegawaian Anda secara rinci..."></textarea>
                        </div>
                        <button type="submit" class="w-100 bg-primary hover-primary-dark text-white fw-bold small py-3 rounded-3 shadow-lg d-flex align-items-center justify-content-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Pesan / Pengaduan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Google Map Placeholder Card -->
            <div class="bg-white rounded-4 shadow border border-light p-3">
                <div class="w-100 hero-image-height rounded-4 bg-primary-subtle position-relative d-flex align-items-center justify-content-center text-center border border-light-subtle">
                    <div class="position-absolute top-0 start-0 bottom-0 end-0 bg-cover bg-center opacity-75" style="background-image: url('https://placehold.co/1200x400/074770/ffffff?text=Peta+Lokasi+Kantor+BKD+Kabupaten+Konawe+Kepulauan+di+Langara');"></div>
                    <div class="position-relative z-1 bg-white bg-opacity-75 p-4 rounded-4 shadow content-form mx-3">
                        <i class="fa-solid fa-map-location-dot fs-1 text-primary mb-2"></i>
                        <h4 class="fw-bold small text-dark">Lokasi Kantor BKD Konawe Kepulauan</h4>
                        <p class="small text-secondary mt-1">Langara, Kecamatan Wawonii Barat, Kabupaten Konawe Kepulauan, Sulawesi Tenggara.</p>
                        <a href="https://maps.google.com" target="_blank" class="mt-3 d-inline-block bg-primary text-white fw-bold small px-3 py-2 rounded-3 shadow hover-primary-dark">
                            Buka di Google Maps <i class="fa-solid fa-arrow-up-right-from-square ms-1 text-10"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
@endsection
