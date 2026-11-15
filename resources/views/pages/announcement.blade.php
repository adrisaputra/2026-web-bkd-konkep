@extends('layouts.app')

@section('title', 'Pengumuman Resmi')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Publikasi Resmi</span>
                        <h1 class="fs-3 fs-2 fw-bolder text-dark">Pengumuman & Berita Kepegawaian</h1>
                    </div>
                </div>
                <hr class="border-light">
                <form method="GET" action="{{ request()->url() }}" class="row g-2 mb-4" role="search">
                    <div class="col">
                        <label for="announcement-search" class="visually-hidden">Cari pengumuman</label>
                        <input
                            type="search"
                            id="announcement-search"
                            name="search"
                            class="form-control"
                            value="{{ $search }}"
                            placeholder="Cari judul atau isi pengumuman..."
                        >
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass me-1"></i>Cari
                        </button>
                    </div>
                    @if ($search !== '')
                        <div class="col-auto">
                            <a href="{{ request()->url() }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    @endif
                </form>
                <div class="stack-gap-3">
                    @forelse ($announcements as $announcement)
                        <article class="p-3 rounded-4 border border-light-subtle bg-body-tertiary d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-4">
                            <div>
                                <h2 class="h5 fw-bold text-body">{{ $announcement->title }}</h2>
                                @if ($announcement->text)
                                    <p class="small text-secondary mt-1 mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($announcement->text), 240) }}</p>
                                @endif
                                @if ($announcement->created_at)
                                    <p class="small text-secondary mt-2 mb-0">
                                        <i class="fa-regular fa-calendar me-1"></i>{{ $announcement->created_at->format('d M Y') }}
                                    </p>
                                @endif
                            </div>
                            @if ($announcement->file)
                                <a href="{{ asset('storage/upload/announcement/'.$announcement->file) }}" target="_blank" class="text-primary fw-bold small d-flex align-items-center gap-1 flex-shrink-0 bg-white px-3 py-2 rounded-3 border border-light-subtle shadow-sm">
                                    <i class="fa-solid fa-download"></i> Unduh
                                </a>
                            @endif
                        </article>
                    @empty
                        <div class="alert alert-info mb-0">Belum ada pengumuman yang tersedia.</div>
                    @endforelse
                </div>

                @if ($announcements->hasPages())
                    <div class="mt-4">
                        {{ $announcements->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
@endsection
