@extends('layouts.app')

@section('title', 'Berita dan Informasi')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
    <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
        <div class="d-flex align-items-center gap-4">
            <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <span class="text-primary fw-bold small text-uppercase tracking-wider">Publikasi</span>
                <h1 class="fs-3 fs-2 fw-bolder text-dark">Berita dan Informasi BKD Konkep</h1>
            </div>
        </div>
        <hr class="border-light">
        <form method="GET" action="{{ request()->url() }}" class="row g-2 mb-4" role="search">
            <div class="col">
                <label for="news-search" class="visually-hidden">Cari berita</label>
                <input
                    type="search"
                    id="news-search"
                    name="search"
                    class="form-control"
                    value="{{ $search }}"
                    placeholder="Cari judul atau isi berita..."
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

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
            @forelse ($news as $newsItem)
                <div class="col">
                    <article class="rounded-4 shadow border border-light h-100 overflow-hidden">
                        @if ($newsItem->cover)
                            <img src="{{ asset('storage/upload/news/'.$newsItem->cover) }}" alt="{{ $newsItem->title }}" class="w-100 size-48 object-fit-cover">
                        @else
                            <div class="size-48 bg-primary-subtle text-primary d-flex align-items-center justify-content-center fs-1" role="img" aria-label="Gambar berita tidak tersedia">
                                <i class="fa-solid fa-newspaper"></i>
                            </div>
                        @endif
                        <div class="p-3 bg-white">
                            @if ($newsItem->created_at)
                                <p class="small text-secondary mb-2">
                                    <i class="fa-regular fa-calendar me-1"></i>{{ $newsItem->created_at->format('d M Y') }}
                                </p>
                            @endif
                            <h2 class="h5 fw-bold text-body">{{ $newsItem->title }}</h2>
                            @if ($newsItem->text)
                                <p class="small text-secondary mt-2 mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($newsItem->text), 180) }}</p>
                            @endif
                            <a href="{{ url('page-news-detail?q='.$newsItem->slug) }}" class="read-more2" target="_blank" data-aos="fade-right" data-aos-delay=300>Selengkapnya</a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        {{ $search !== '' ? 'Tidak ada berita yang cocok dengan pencarian.' : 'Belum ada berita yang tersedia.' }}
                    </div>
                </div>
            @endforelse
        </div>

        @if ($news->hasPages())
            <div class="mt-4">
                {{ $news->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
