@extends('layouts.app')

@section('title', 'Zona Integritas')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-lg-5">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="bg-primary-subtle text-primary rounded-3 p-3 fs-4">
                    <i class="fa-solid {{ $categoryDetails['icon'] }}"></i>
                </div>
                <div>
                    <span class="text-primary fw-bold small text-uppercase">{{ $categoryDetails['eyebrow'] }}</span>
                    <h1 class="h2 fw-bold mb-0">{{ $categoryDetails['heading'] }}</h1>
                </div>
            </div>
            <hr>
            <p class="text-secondary">{{ $categoryDetails['description'] }}</p>
            <div class="alert alert-primary">
                <h2 class="h5 fw-bold"><i class="fa-solid fa-shield-heart text-warning me-2"></i>Komitmen Pelayanan Bersih</h2>
                <ul class="mb-0">
                    <li>Bebas dari Praktik Korupsi, Kolusi, dan Nepotisme (KKN).</li>
                    <li>Anti Pungutan Liar (Pungli) dan Gratifikasi dalam pengurusan administrasi kepegawaian.</li>
                    <li>Standar Operasional Prosedur (SOP) yang transparan dan tepat waktu.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
