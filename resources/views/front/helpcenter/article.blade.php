@extends('front.pages')

<meta name="description" content="{{ Str::words(strip_tags($article->answer), 25) }}" />

@section('css')
    <link href="{{asset('css/help.css')}}" rel="stylesheet">
@stop

@section('content')
    <section class="axora-article-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <nav class="axora-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('help.center') }}">
                                    {{ __('Help Center') }}
                                </a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $article->category->name }}
                            </li>
                        </ol>
                    </nav>
                    <span class="axora-article-badge"><i class="bi bi-file-text"></i>
                        {{ $article->category->name }}
                    </span>

                    <h1 class="axora-article-title">{{ $article->question }}</h1>

                    <div class="axora-article-meta">
                        <span><i class="bi bi-calendar3"></i>{{ __('Last updated') }}:
                            {{ Carbon\Carbon::create($article->updated_at)->format('M j, Y') }}
                        </span>

                        <span><i class="bi bi-eye"></i>
                            {{ number_format($article->views) }}{{ __('views') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="axora-article-section">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-12 col-lg-8">
                    <article class="axora-article-content-card">
                        <div class="axora-article-content preserveLines">{!! $article->answer !!}</div>

                        <div class="mt-5">
                            @livewire('article-likes', ['article' => $article])
                        </div>
                    </article>

                    <a href="{{ route('help.center') }}" class="axora-back-help">
                        <i class="bi bi-arrow-left"></i>{{ __('Back to Help Center') }}
                    </a>
                </div>

                <div class="col-12 col-lg-4">
                    @if(count($article->relatedArticles(10)) > 0)
                        <aside class="axora-sidebar-card">
                            <h5>{{ __('Related Articles') }}</h5>

                            <ul class="axora-related-list">
                                @foreach($article->relatedArticles(10) as $val)
                                    <li>
                                        <a href="{{ route('help.article', ['article' => $val->slug]) }}" class="axora-related-link">
                                            <i class="bi bi-arrow-right-circle"></i><span>{{ $val->question }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </aside>
                    @endif
                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
@endsection