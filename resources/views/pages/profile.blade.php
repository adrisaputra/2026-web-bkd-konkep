@extends('layouts.app')

@section('title', '{{ $title }}')

@section('content')
<div class="container content-narrow mx-auto px-3 py-5 stack-gap-5">
            <div class="bg-white p-4 p-5 rounded-4 shadow border border-light">
                <span class="text-primary fw-bold small text-uppercase tracking-wider bg-primary-subtle px-3 py-1 rounded-pill">{{ $head }}</span>
                <h1 class="fs-2 fw-bolder text-dark mt-3 mb-4">{{ $title }}</h1>
                <div class="stack-gap-3 text-secondary small fs-6 lh-lg">
                    {!! $profile->text !!}
                                        
                    @if($profile->menu=="structure")
                        @if($profile->image)
                        <div class="entry-image" data-animate="backInRight" data-delay="10">
                            <img src="{{ asset('storage/upload/profile/'.$profile->image) }}" alt="Image" style="border-radius: 25px;">
                        </div>
                        @endif
                    @else
                        {!! $profile->text !!}                
                    @endif
                </div>
            </div>
        </div>
@endsection
