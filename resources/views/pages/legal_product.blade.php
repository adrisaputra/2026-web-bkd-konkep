@extends('layouts.app')

@section('title', 'Produk Hukum dan Peraturan')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light stack-gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="size-12 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center fs-4 fw-bold">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Regulasi</span>
                        <h1 class="fs-3 fs-2 fw-bolder text-dark">Produk Hukum & Peraturan Kepegawaian</h1>
                    </div>
                </div>
                <hr class="border-light">
                <form method="GET" action="{{ request()->url() }}" class="row g-2 mb-4" role="search">
                    <div class="col">
                        <label for="legal-product-search" class="visually-hidden">Cari produk hukum</label>
                        <input
                            type="search"
                            id="legal-product-search"
                            name="search"
                            class="form-control"
                            value="{{ $search }}"
                            placeholder="Cari judul atau isi produk hukum..."
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
                    @forelse ($legalProducts as $legalProduct)
                        <div class="p-3 rounded-4 border border-light-subtle bg-body-tertiary d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <h2 class="h5 fw-bold text-body">Kenaikan Pangkat</h2>
                                @if ($legalProduct->text)
                                    <p class="small text-secondary mt-1">{{ \Illuminate\Support\Str::limit(strip_tags($legalProduct->text), 240) }}</p>
                                @endif
                                <span class="small text-secondary">Diunduh {{ $legalProduct->count_view ?? 0 }} kali</span>
                            </div>
                            @if ($legalProduct->file)
                                <a href="{{ route('legal_product.download', $legalProduct) }}" class="text-primary fw-bold small d-flex align-items-center gap-1 flex-shrink-0 bg-white px-3 py-2 rounded-3 border border-light-subtle shadow-sm">
                                    <i class="fa-solid fa-download"></i> Unduh
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="alert alert-info mb-0">Belum ada produk hukum yang tersedia.</div>
                    @endforelse
                </div>

                @if ($legalProducts->hasPages())
                    <div class="mt-4">
                        {{ $legalProducts->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
@endsection
