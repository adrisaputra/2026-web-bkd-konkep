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
            @forelse ($albums as $album)
                <div class="col">
                    <article class="rounded-4 shadow border border-light hover-parent position-relative h-100 overflow-hidden">
                        @if ($album->cover)
                            <img src="{{ asset('storage/upload/album/'.$album->cover) }}" alt="{{ $album->title }}" class="w-100 size-48 object-fit-cover group-hover-scale">
                        @else
                            <div class="size-48 bg-primary-subtle text-primary d-flex align-items-center justify-content-center fs-1">
                                <i class="fa-solid fa-images"></i>
                            </div>
                        @endif
                        <div class="p-3 bg-white">
                            <h2 class="fw-bold small text-body">{{ $album->title }}</h2>
                            @if ($album->text)
                                <p class="text-11 text-secondary mt-1 mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($album->text), 180) }}</p>
                            @endif
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">Belum ada album galeri yang tersedia.</div>
                </div>
            @endforelse
        </div>

        @if ($albums->hasPages())
            <div class="mt-4">
                {{ $albums->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
