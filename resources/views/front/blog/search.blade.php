@extends('front.menu')

<meta name="description" content="{{ $set->site_name ?? 'Blog' }} search results for {{ $term }}" />

@section('css')
    <link rel="stylesheet" href="{{ asset('css/posts.css') }}">
@stop

@section('content')
    <section class="axora-blog-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <nav class="axora-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">{{ __('Blog') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Search Results') }}</li>
                        </ol>
                    </nav>

                    <div class="text-center">
                        <span class="axora-blog-badge"><i class="bi bi-search"></i>{{ __('Search Results') }}</span>

                        <h1 class="axora-blog-title">{{ __('Search Results') }}</h1>
                        <p class="axora-blog-subtitle">{{ $article->total() ?? count($article) }} {{ __('results found for') }}<strong>“{{ $term }}”</strong></p>
                        <form class="axora-blog-hero-search" action="{{ route('blog.search') }}" method="post">
                            @csrf

                            <div class="input-group input-group-lg">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input value="{{ $term }}" name="term" id="term" class="form-control" type="search" placeholder="{{ __('Search blog articles') }}..." required>
                                <span class="input-group-text pe-2">
                                    <button class="btn btn-primary" type="submit">{{ __('Search') }}</button>
                                </span>
                            </div>

                            @error('term')
                            <span class="d-block mt-2 text-danger small">{{ $message }}</span>
                            @enderror
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="axora-blog-section">
        <div class="container">
            <div class="row justify-content-between align-items-end mb-4">
                <div class="col-lg-8">
                    <span class="axora-blog-section-kicker">{{ __('Search') }}</span>
                    <h2 class="axora-blog-section-title">{{ __('Articles matching your search') }}</h2>
                    <p class="axora-blog-section-subtitle">{{ __('Browse the articles we found based on your search term.') }}</p>
                </div>

                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('blog.index') }}" class="axora-blog-back-link"><i class="bi bi-arrow-left"></i>{{ __('Back to Blog') }}</a>
                </div>
            </div>

            @if($article->count() > 0)
                <div class="row g-4">
                    @foreach($article as $val)
                        <div class="col-12 col-md-6 col-lg-4">
                            <a href="{{ route('blog.article', ['blog' => $val->slug]) }}" class="axora-blog-card">
                                @php
                                    $blogImagePath = $val->image ? storage_path('app/' . $val->image) : null;
                                @endphp

                                @if($blogImagePath && file_exists($blogImagePath))
                                    <img src="{{ url('/') . '/storage/app/' . $val->image }}" class="axora-blog-image" alt="{{ $val->title }}" loading="lazy">
                                @else
                                    <div class="axora-blog-image axora-blog-image-placeholder">
                                        <i class="bi bi-journal-text"></i>
                                    </div>
                                @endif

                                <div class="axora-blog-card-body">
                                    <div class="axora-blog-meta">
                                        @if(!empty($val->category))
                                            <span><i class="bi bi-folder2"></i>{{ $val->category->name }}</span>
                                        @endif
                                        <span><i class="bi bi-calendar3"></i>{{ $val->created_at->format('M j, Y') }}</span>
                                        <span><i class="bi bi-clock"></i>{{ estimateReadingTime($val->details) }} {{ __('read') }}</span>
                                    </div>

                                    <h3>{{ Str::words($val->title, 10) }}</h3>
                                    <p>{{ Str::words(strip_tags(html_entity_decode(trim($val->details))), 22) }}</p>
                                    <span class="axora-blog-read-more">{{ __('Read article') }}<i class="bi bi-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="axora-pagination-wrap">
                    {{ $article->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="axora-blog-empty">
                            <div class="axora-blog-empty-icon"><i class="bi bi-search"></i></div>
                            <h3>{{ __('No results found') }}</h3>
                            <p>{{ __('We could not find any blog articles matching your search. Try a different keyword or return to the main blog page.') }}</p>
                            <a href="{{ route('blog.index') }}" class="btn btn-primary mt-4 rounded-pill px-4">{{ __('Back to Blog') }}</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@stop

@section('script')
@endsection