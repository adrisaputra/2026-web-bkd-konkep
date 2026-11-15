@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">{{ $head }}</span>
                        <h1 class="fs-3 fs-2 fw-bolder text-dark">{{ $title }}</h1>
                    </div>
                </div>
                <hr class="border-light">
                <div class="stack-gap-3 text-secondary small">
                    <div>{!! $service->text !!}</div>
                    @if ($service->condition)
                        <div class="bg-primary-subtle p-4 rounded-4 border border-primary-subtle stack-gap-3">
                            <h2 class="fw-bold text-primary-emphasis small text-uppercase tracking-wide">
                                <i class="fa-solid fa-list-check me-2"></i>Persyaratan
                            </h2>
                            <div class="small text-primary-emphasis">{!! $service->condition !!}</div>
                        </div>
                    @endif
                    @if ($serviceUrl)
                        <div class="pt-3">
                            <a href="{{ $serviceUrl }}" class="bg-primary hover-primary-dark text-white fw-bold small px-4 py-3 rounded-3 shadow d-inline-block">
                                <i class="fa-solid fa-paper-plane me-2"></i>Ajukan Permohonan / Cek Berkas
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
@endsection
