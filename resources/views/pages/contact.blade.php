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
        <div class="col-lg-5">
            <div class="bg-primary text-white p-4 p-5 rounded-4 shadow stack-gap-5">
                <h3 class="fs-4 fw-bold border-bottom border-primary pb-3">Informasi Kantor BKD</h3>
                <div class="stack-gap-4 small">
                    <div class="d-flex align-items-start gap-4">
                        <div class="size-10 bg-primary rounded-3 d-flex align-items-center justify-content-center text-warning flex-shrink-0">
                            <i class="fa-solid fa-location-dot fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white">Alamat Kantor</h6>
                            <p class="small text-white-50 mt-1">Kompleks Perkantoran Bupati Konawe Kepulauan, Langara, Kec. Wawonii Barat, Kabupaten Konawe Kepulauan, Sulawesi Tenggara 93392</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-4">
                        <div class="size-10 bg-primary rounded-3 d-flex align-items-center justify-content-center text-warning flex-shrink-0">
                            <i class="fa-solid fa-envelope fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white">Email Resmi</h6>
                            <p class="small text-white-50 mt-1">bkd@konkepkab.go.id</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-4">
                        <div class="size-10 bg-primary rounded-3 d-flex align-items-center justify-content-center text-warning flex-shrink-0">
                            <i class="fa-solid fa-phone fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white">Telepon / WhatsApp</h6>
                            <p class="small text-white-50 mt-1">(0401) 1234567 / +62 821-9876-5432</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-4">
                        <div class="size-10 bg-primary rounded-3 d-flex align-items-center justify-content-center text-warning flex-shrink-0">
                            <i class="fa-solid fa-clock fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white">Jam Pelayanan</h6>
                            <p class="small text-white-50 mt-1">Senin - Kamis: 08.00 - 16.00 WITA<br>Jumat: 08.00 - 11.30 WITA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Pesan & Pengaduan -->
        <div class="col-lg-7">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light">
                <h3 class="fs-4 fw-bold text-dark mb-4">Kirim Pesan / Pengaduan Kepegawaian</h3>
                @if (session('contact_status'))
                    <div class="alert alert-success" role="status">{{ session('contact_status') }}</div>
                @endif
                <form method="POST" action="{{ route('contact-messages.store') }}" class="stack-gap-3">
                    @csrf
                    <div class="row row-cols-1 row-cols-sm-2 g-4">
                        <div>
                            <label for="contact-name" class="d-block small fw-bold text-secondary-emphasis mb-1">Nama Lengkap</label>
                            <input type="text" id="contact-name" name="name" value="{{ old('name') }}" required maxlength="150" autocomplete="name" class="w-100 small bg-body-tertiary border border-light-subtle rounded-3 px-3 py-3 focus-border-primary" placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="contact-identifier" class="d-block small fw-bold text-secondary-emphasis mb-1">NIP / Nomor Identitas (Opsional)</label>
                            <input type="text" id="contact-identifier" name="identifier" value="{{ old('identifier') }}" maxlength="50" class="w-100 small bg-body-tertiary border border-light-subtle rounded-3 px-3 py-3 focus-border-primary" placeholder="NIP bagi ASN Konkep">
                            @error('identifier')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 g-4">
                        <div>
                            <label for="contact-address" class="d-block small fw-bold text-secondary-emphasis mb-1">Email / WhatsApp</label>
                            <input type="text" id="contact-address" name="contact" value="{{ old('contact') }}" required maxlength="255" autocomplete="email" class="w-100 small bg-body-tertiary border border-light-subtle rounded-3 px-3 py-3 focus-border-primary" placeholder="email@domain.com atau no WA">
                            @error('contact')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="contact-category" class="d-block small fw-bold text-secondary-emphasis mb-1">Kategori Layanan / Perihal</label>
                            <select id="contact-category" name="category" required class="w-100 small bg-body-tertiary border border-light-subtle rounded-3 px-3 py-3 focus-border-primary">
                                <option value="">Pilih kategori</option>
                                <option value="promotion" @selected(old('category') === 'promotion')>Kenaikan Pangkat</option>
                                <option value="retirement" @selected(old('category') === 'retirement')>Pensiun</option>
                                <option value="leave" @selected(old('category') === 'leave')>Cuti &amp; Izin</option>
                                <option value="transfer" @selected(old('category') === 'transfer')>Mutasi / Pindah Tugas</option>
                                <option value="complaint" @selected(old('category') === 'complaint')>Pengaduan / Lainnya</option>
                            </select>
                            @error('category')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="contact-message" class="d-block small fw-bold text-secondary-emphasis mb-1">Pesan atau Pertanyaan Anda</label>
                        <textarea id="contact-message" name="message" rows="4" required maxlength="10000" class="w-100 small bg-body-tertiary border border-light-subtle rounded-3 p-3 focus-border-primary" placeholder="Tuliskan pesan atau kendala administrasi kepegawaian Anda secara rinci...">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="w-100 bg-primary hover-primary-dark text-white fw-bold small py-3 rounded-3 shadow-lg d-flex align-items-center justify-content-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Pesan / Pengaduan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Google Map Placeholder Card -->
    <div class="bg-white rounded-4 shadow border border-light p-3">
        <div class="w-100 hero-image-height rounded-4 bg-primary-subtle position-relative d-flex align-items-center justify-content-center text-center border border-light-subtle">
            <div class="mapouter"><div class="gmap_canvas"><iframe class="gmap_iframe" width="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=bkd konawe kepulauan&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe><a href="https://minecraftlegame.net/">Minecraftle Game</a></div><style>.mapouter{position:relative;text-align:right;width:100%;height:400px;}.gmap_canvas {overflow:hidden;background:none!important;width:100%;height:400px;}.gmap_iframe {height:400px!important;}</style></div>
        </div>
    </div>
</div>
@endsection