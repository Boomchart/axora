@extends('front.menu')
<meta name="description" content="Blog">

@section('css')
    <link href="{{asset('css/posts.css')}}" rel="stylesheet">
@stop

@section('content')
    <section class="axora-blog-hero text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <span class="axora-blog-badge">
                        <i class="bi bi-journal-text"></i>{{ __('Blog') }}
                    </span>

                    <h1 class="axora-blog-title">{{ __('Insights on Digital Assets, API Integrations, and Global Rewards') }}</h1>
                    <p class="axora-blog-subtitle">
                        {{ __('Explore practical articles, product updates, integration tips, and business insights for teams building multi-asset, crypto, airtime, and gift card experiences.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="axora-blog-section">
        <div class="container">
            @if($blogs->count() > 0)
                <div class="row g-4">
                    @foreach($blogs as $blog)
                        <div class="col-12 col-md-6 col-lg-4">
                            <a href="{{ route('blog.article', ['blog' => $blog->slug]) }}" class="axora-blog-card">
                                @php
                                    $blogImagePath = $blog->image ? storage_path('app/' . $blog->image) : null;
                                @endphp

                                @if($blogImagePath && file_exists($blogImagePath))
                                    <img src="{{ url('/') . '/storage/app/' . $blog->image }}" class="axora-blog-image" alt="{{ $blog->title }}" loading="lazy">
                                @else
                                    <div class="axora-blog-image axora-blog-image-placeholder"><i class="bi bi-journal-text"></i></div>
                                @endif

                                <div class="axora-blog-card-body">
                                    <div class="axora-blog-meta">
                                        <span>
                                            <i class="bi bi-calendar3"></i>{{ Carbon\Carbon::create($blog->created_at)->format('M j, Y') }}
                                        </span>

                                        @if(!empty($blog->category))
                                            <span>
                                                <i class="bi bi-folder2"></i>{{ $blog->category->name ?? $blog->category }}
                                            </span>
                                        @endif
                                    </div>

                                    <h3>{{ $blog->title }}</h3>

                                    <p>{{ Str::words(strip_tags($blog->description ?? $blog->content), 24) }}</p>

                                    <span class="axora-blog-read-more">
                                        {{ __('Read article') }}<i class="bi bi-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="axora-pagination-wrap">
                    {{ $blogs->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="axora-blog-empty">
                            <div class="axora-blog-empty-icon">
                                <i class="bi bi-journal-text"></i>
                            </div>

                            <h3>{{ __('No articles yet') }}</h3>

                            <p>{{ __('We are preparing helpful articles about unified APIs, crypto wallets, global airtime, and digital rewards infrastructure. Please check back soon.') }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@stop