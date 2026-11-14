@extends('layouts.app')

@section('title', 'Kenaikan Pangkat')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Layanan Kepegawaian</span>
                        <h1 class="fs-3 fs-2 fw-bolder text-dark">Kenaikan Pangkat ASN</h1>
                    </div>
                </div>
                <hr class="border-light">
                <div class="stack-gap-3 text-secondary small">
                    <p>
                        Kenaikan pangkat adalah penghargaan yang diberikan atas prestasi kerja dan pengabdian PNS terhadap negara. Periode usulan kenaikan pangkat di Kabupaten Konawe Kepulauan ditetapkan setiap <strong>1 Februari, 1 April, 1 Juni, 1 Agustus, 1 Oktober, dan 1 Desember</strong> (mengikuti regulasi BKN terbaru).
                    </p>
                    <div class="bg-primary-subtle p-4 rounded-4 border border-primary-subtle stack-gap-3">
                        <h3 class="fw-bold text-primary-emphasis small text-uppercase tracking-wide"><i class="fa-solid fa-list-check me-2"></i> Persyaratan Berkas Usulan:</h3>
                        <ul class="list-disc ps-3 stack-gap-2 small text-primary-emphasis">
                            <li>SK Pangkat Terakhir (legalisir).</li>
                            <li>Penilaian Prestasi Kerja (SKP) 2 tahun terakhir bernilai baik.</li>
                            <li>Surat Tanda Lulus Ujian Dinas / Penyesuaian Ijazah (jika naik golongan).</li>
                            <li>Surat Pernyataan Melaksanakan Tugas (SPMT).</li>
                            <li>Asli / Scan berkas digital melalui portal e-Kinerja / SIMPEG BKD Konkep.</li>
                        </ul>
                    </div>
                    <div class="pt-3">
                        <button onclick="triggerSimulateService('Usulan Kenaikan Pangkat')" class="bg-primary hover-primary-dark text-white fw-bold small px-4 py-3 rounded-3 shadow">
                            <i class="fa-solid fa-paper-plane me-2"></i> Ajukan Permohonan / Cek Berkas
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection
