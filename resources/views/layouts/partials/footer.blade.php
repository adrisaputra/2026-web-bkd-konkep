<footer class="bg-primary text-white-50 mt-auto pt-5 pb-4">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4 pb-4">
            <div>
                <h2 class="h5 fw-bold text-white">BKD Konawe Kepulauan</h2>
                <p class="small mb-0">Portal informasi dan layanan kepegawaian Pemerintah Kabupaten Konawe Kepulauan.</p>
            </div>
            <div>
                <h2 class="h6 fw-bold text-white mb-3">Profil &amp; Layanan</h2>
                <ul class="list-unstyled vstack gap-2 small mb-0">
                    <li><a class="link-light link-opacity-75-hover" href="{{ route('page.profil-sejarah') }}">Sejarah Instansi</a></li>
                    <li><a class="link-light link-opacity-75-hover" href="{{ route('page.profil-visimisi') }}">Visi &amp; Misi</a></li>
                    <li><a class="link-light link-opacity-75-hover" href="{{ route('page.layanan-pangkat') }}">Kenaikan Pangkat</a></li>
                    <li><a class="link-light link-opacity-75-hover" href="{{ route('page.layanan-pensiun') }}">Pensiun Pegawai</a></li>
                </ul>
            </div>
            <div>
                <h2 class="h6 fw-bold text-white mb-3">Kontak &amp; Lokasi</h2>
                <ul class="list-unstyled vstack gap-2 small mb-0">
                    <li><i class="fa-solid fa-location-dot text-warning me-2"></i>Langara, Kec. Wawonii Barat</li>
                    <li><i class="fa-solid fa-envelope text-warning me-2"></i>bkd@konkepkab.go.id</li>
                    <li><i class="fa-solid fa-phone text-warning me-2"></i>(0401) 1234567</li>
                </ul>
            </div>
        </div>
        <div class="border-top border-white border-opacity-25 pt-3 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 small">
            <p class="mb-0">&copy; 2026 Badan Kepegawaian Daerah Kabupaten Konawe Kepulauan.</p>
            <a class="link-light link-opacity-75-hover" href="{{ route('page.kontak') }}">Hubungi Kami</a>
        </div>
    </div>
</footer>
