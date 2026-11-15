@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<div class="container py-5">
    <div class="mx-auto" style="max-width: 900px;">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 3.5rem; height: 3.5rem;">
                        <i class="fa-solid fa-circle-question fs-4"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase">Tanya Jawab</span>
                        <h1 class="h2 fw-bolder text-dark mb-0">Pertanyaan Sering Diajukan (FAQ)</h1>
                    </div>
                </div>
                <hr class="border-light">
                @if($faqs->isNotEmpty())
                    <div class="accordion" id="faqAccordion">
                        @foreach($faqs as $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faq-heading-{{ $faq->id }}">
                                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-answer-{{ $faq->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="faq-answer-{{ $faq->id }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="faq-answer-{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="faq-heading-{{ $faq->id }}" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-secondary" style="white-space: pre-line;">{{ $faq->answer }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info mb-0" role="status">Belum ada pertanyaan yang tersedia.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
