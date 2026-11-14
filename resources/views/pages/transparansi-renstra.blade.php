@extends('layouts.app')

@section('title', 'Renstra')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                        <i class="fa-solid fa-map"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Perencanaan Strategis</span>
                        <h1 class="fs-3 fs-2 fw-bolder text-dark">Rencana Strategis (Renstra) & Renja</h1>
                    </div>
                </div>
                <hr class="border-light">
                <div class="stack-gap-3">
                    <p class="small text-secondary">
                        Dokumen Rencana Strategis (Renstra) BKD Kabupaten Konawe Kepulauan memuat visi, misi, tujuan, sasaran, strategi, dan kebijakan program kerja untuk periode 5 tahun.
                    </p>
                    <div class="p-3 rounded-4 border border-light-subtle bg-body-tertiary d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold small text-body">Rencana Strategis (Renstra) BKD Konkep 2021-2026</h4>
                            <p class="small text-secondary mt-1">Dokumen perencanaan jangka menengah badan kepegawaian.</p>
                        </div>
                        <button onclick="triggerDownload('Renstra_BKD_Konkep.pdf')" class="text-primary hover-primary-dark fw-bold small d-flex align-items-center gap-1 flex-shrink-0 bg-white px-3 py-2 rounded-3 border border-light-subtle shadow-sm">
                            <i class="fa-solid fa-download"></i> Unduh
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection
