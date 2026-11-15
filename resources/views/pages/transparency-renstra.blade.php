@extends('layouts.app')

@section('title', 'Renstra')

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
            <div class="d-grid gap-3">
                @forelse ($transparencies as $transparency)
                    <article class="card bg-light border-0">
                        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <div>
                                <h2 class="h5 fw-bold mb-1">{{ $transparency->title }}</h2>
                                <p class="text-secondary mb-0">{{ $transparency->text }}</p>
                            </div>
                            @if ($transparency->file)
                                <a href="{{ route('transparency.download', ['category' => $category, 'transparency' => $transparency->id]) }}" class="btn btn-primary flex-shrink-0">
                                    <i class="fa-solid fa-download me-1"></i> Unduh PDF
                                </a>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="alert alert-light border mb-0">Belum ada dokumen Renstra yang tersedia.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
