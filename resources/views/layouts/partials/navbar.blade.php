<div class="bg-primary text-white-50 small py-2">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
        <span><i class="fa-solid fa-location-dot text-warning me-2"></i>Langara, Kab. Konawe Kepulauan, Sulawesi Tenggara</span>
        <span><i class="fa-solid fa-envelope text-warning me-2"></i>bkd@konkepkab.go.id</span>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm border-bottom">
    <div class="container">
        <div class="navbar-heading d-flex align-items-center justify-content-between">
            <a class="navbar-brand d-flex align-items-center gap-3 mb-0" href="{{ route('home') }}">
                <span class="size-12 rounded-3 bg-primary d-flex align-items-center justify-content-center text-warning shadow">
                    <i class="fa-solid fa-landmark fs-4"></i>
                </span>
                <span class="d-flex flex-column">
                    <strong class="text-primary-emphasis lh-sm" style="font-size:18px">BKD KONAWE KEPULAUAN</strong>
                    <small class="text-secondary" style="font-size:12px">Badan Kepegawaian Daerah Kabupaten Wawonii</small>
                </span>
            </a>

            <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNavigation" aria-controls="primaryNavigation" aria-expanded="false" aria-label="Buka menu navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="primaryNavigation">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-semibold' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('page.profil-*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profil</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('page-history') }}">Sejarah Instansi</a></li>
                        <li><a class="dropdown-item" href="{{ url('page-vision-mission') }}">Visi &amp; Misi</a></li>
                        <li><a class="dropdown-item" href="{{ url('page-structure') }}">Struktur Organisasi</a></li>
                        <li><a class="dropdown-item" href="{{ url('page-main-tasks') }}">Tugas Pokok &amp; Fungsi</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('page-promotion', 'page-retirement', 'page-leave', 'page-transfer', 'page-discipline') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Layanan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('page-promotion') }}">Kenaikan Pangkat</a></li>
                        <li><a class="dropdown-item" href="{{ url('page-retirement') }}">Pensiun Pegawai</a></li>
                        <li><a class="dropdown-item" href="{{ url('page-leave') }}">Layanan Cuti ASN</a></li>
                        <li><a class="dropdown-item" href="{{ url('page-transfer') }}">Mutasi / Pindah Tugas</a></li>
                        <li><a class="dropdown-item" href="{{ url('page-discipline') }}">Disiplin &amp; Kinerja</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('page.info-*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Publikasi</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('page-announcement') }}">Pengumuman Resmi</a></li>
                        <li><a class="dropdown-item" href="{{ url('page-legal-product') }}">Produk Hukum &amp; Peraturan</a></li>
                        <li><a class="dropdown-item" href="{{ url('page-galery') }}">Galeri Kegiatan</a></li>
                        <li><a class="dropdown-item" href="{{ url('page-faq') }}">FAQ (Tanya Jawab)</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('page.transparansi-*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Akuntabilitas</a>
                    <ul class="dropdown-menu dropdown-menu-lg-end">
                        <li><a class="dropdown-item" href="{{ route('page.transparansi-lakip') }}">LAKIP</a></li>
                        <li><a class="dropdown-item" href="{{ route('page.transparansi-renstra') }}">Renstra</a></li>
                        <li><a class="dropdown-item" href="{{ route('page.transparansi-ziwbk') }}">Zona Integritas</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->url('contact') ? 'active fw-semibold' : '' }}" href="{{ url('contact') }}">Kontak</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
