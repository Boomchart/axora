@extends('front.pages')

<meta name="description" content="{{ $topic->description }}" />

@section('css')
    <link href="{{asset('css/help.css')}}" rel="stylesheet">
@stop

@section('content')
    <section class="axora-topic-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <nav class="axora-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('help.center') }}">{{ __('Help Center') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $topic->name }}</li>
                        </ol>
                    </nav>
                    <span class="axora-page-badge"><i class="bi bi-folder2-open"></i>{{ __('Help Topic') }}</span>
                    <h1 class="axora-page-title">{{ $topic->name }}</h1>
                    <p class="axora-page-subtitle">{{ $topic->description }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="axora-help-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    @if($topic->faq->count() > 0)
                        <div class="row g-4">
                            @foreach($topic->faq as $val)
                                <div class="col-12 col-md-6">
                                    <a href="{{ route('help.article', ['article' => $val->slug]) }}" class="text-decoration-none d-block h-100">
                                        <article class="axora-topic-article-card">
                                            <h3>{{ $val->question }}</h3>
                                            <p>{{ Str::words(strip_tags($val->answer), 25) }}</p>
                                            <span class="axora-topic-article-meta"><i class="bi bi-arrow-right-circle"></i>{{ __('Read article') }}</span>
                                        </article>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="axora-empty-state">
                            <div class="axora-empty-state-icon"><i class="bi bi-file-earmark-text"></i></div>
                            <h3>{{ __('No articles found') }}</h3>
                            <p>{{ __('There are currently no help articles under this topic. You can return to the Help Center or contact support if you need assistance.') }}</p>
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