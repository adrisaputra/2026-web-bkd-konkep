@extends('layouts.app')

@section('title', $news->title ?? 'Berita dan Informasi')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5">
    <a href="{{ url('page-news') }}" class="text-primary fw-semibold small d-inline-flex align-items-center gap-2 mb-4">
        <i class="fa-solid fa-arrow-left"></i>Kembali ke daftar berita
    </a>

    <article class="bg-white rounded-4 shadow border border-light overflow-hidden">
       
        @if ($news->cover)
            <img src="{{ asset('storage/upload/news/'.$news->cover) }}" alt="{{ $news->title }}" style="width:100%">
        @endif
        <div class="p-4 p-md-5">

            @if ($news->created_at)
                <p class="small text-secondary mb-2">
                    <i class="fa-regular fa-calendar me-1"></i>{{ $news->created_at->format('d M Y') }}
                </p>
            @endif

            <h1 class="fs-3 fw-bolder text-dark mb-4">{{ $news->title }}</h1>
            <div class="text-body lh-lg" style="white-space: pre-line;">{{ $newsContent }}</div>
        </div>
    </article>
</div>
@endsection
