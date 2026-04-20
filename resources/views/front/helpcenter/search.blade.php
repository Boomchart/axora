@extends('front.menu')

<meta name="description" content="{{ $set->site_name }} Help Center search results for {{ $term }}" />

@section('css')
    <link rel="stylesheet" href="{{ asset('css/help.css') }}">
@stop

@section('content')
    <section class="axora-topic-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <nav class="axora-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('help.center') }}">{{ __('Help Center') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Search Results') }}</li>
                        </ol>
                    </nav>

                    <span class="axora-page-badge"><i class="bi bi-search"></i>{{ __('Search Results') }}</span>
                    <h1 class="axora-page-title">{{ __('Search Results') }}</h1>

                    <p class="axora-page-subtitle">
                        {{ $topic->total() ?? count($topic) }} {{ __('results found for') }}<strong>“{{ $term }}”</strong>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="axora-help-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @if($topic->count() > 0)
                        <div class="row g-4">
                            @foreach($topic as $val)
                                <div class="col-12 col-md-6">
                                    <a href="{{ route('help.article', ['article' => $val->slug]) }}" class="text-decoration-none d-block h-100">
                                        <article class="axora-topic-article-card">
                                            <h3>{{ $val->question }}</h3>
                                            <p>{{ Str::words(strip_tags($val->answer), 25) }}</p>

                                            <span class="axora-topic-article-meta">
                                                <i class="bi bi-arrow-right-circle"></i>{{ __('Read article') }}
                                            </span>
                                        </article>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <div class="axora-pagination-wrap">
                            {{ $topic->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="axora-empty-state">
                            <div class="axora-empty-state-icon"><i class="bi bi-search"></i></div>
                            <h3>{{ __('No results found') }}</h3>
                            <p>{{ __('We could not find any help articles matching your search. Try a different keyword or return to the Help Center to browse by topic.') }}</p>
                            <a href="{{ route('help.center') }}" class="btn btn-primary">{{ __('Back to Help Center') }}</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
@endsection