@extends('front.menu')

<meta name="description" content="{{ $title ?? 'Blog category articles' }}" />

@section('css')
    <link rel="stylesheet" href="{{ asset('css/posts.css') }}">
@stop

@section('content')
    <section class="axora-blog-hero text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <span class="axora-blog-badge">
                        <i class="bi bi-folder2-open"></i>
                        {{ __('Blog Category') }}
                    </span>

                    <h1 class="axora-blog-title">
                        {{ $title }}
                    </h1>

                    <p class="axora-blog-subtitle">
                        {{ __('Explore articles, guides, and insights from this topic to help you better understand gift card APIs, rewards, digital value, and business integrations.') }}
                    </p>

                @livewire('blog-category-search')
                </div>
            </div>
        </div>
    </section>

    <section class="axora-blog-section">
        <div class="container">
            @php
                $articles = $category->articles()->latest()->paginate(10);
            @endphp

            <div class="row justify-content-between align-items-end mb-4">
                <div class="col-lg-8">
                    <span class="axora-blog-section-kicker">{{ __('All Articles') }}</span>
                    <h2 class="axora-blog-section-title">{{ __('Articles under') }} “{{ $title }}”</h2>
                    <p class="axora-blog-section-subtitle">{{ __('Browse the latest posts published under this category.') }}</p>
                </div>

                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('blog.index') }}" class="axora-blog-back-link"><i class="bi bi-arrow-left"></i>{{ __('Back to Blog') }}</a>
                </div>
            </div>

            @if($articles->count() > 0)
                <div class="row g-4">
                    @foreach($articles as $val)
                        <div class="col-12 col-md-6 col-lg-4">
                            <a href="{{ route('blog.article', ['blog' => $val->slug]) }}" class="axora-blog-card">
                                @php
                                    $blogImagePath = $val->image ? storage_path('app/' . $val->image) : null;
                                @endphp

                                @if($blogImagePath && file_exists($blogImagePath))
                                    <img src="{{ url('/') . '/storage/app/' . $val->image }}" class="axora-blog-image" alt="{{ $val->title }}" loading="lazy">
                                @else
                                    <div class="axora-blog-image axora-blog-image-placeholder"><i class="bi bi-journal-text"></i></div>
                                @endif

                                <div class="axora-blog-card-body">
                                    <div class="axora-blog-meta">
                                        <span><i class="bi bi-folder2"></i>{{ $val->category->name }}</span>
                                        <span><i class="bi bi-calendar3"></i>{{ $val->created_at->format('M j, Y') }}</span>
                                    </div>

                                    <h3>{{ Str::words($val->title, 10) }}</h3>

                                    <p>{{ Str::words(strip_tags(html_entity_decode(trim($val->details))), 20) }}</p>

                                    <span class="axora-blog-read-more">{{ __('Read article') }}<i class="bi bi-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="axora-pagination-wrap">{{ $articles->links('pagination::bootstrap-4') }}</div>
            @else
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="axora-blog-empty">
                            <div class="axora-blog-empty-icon"><i class="bi bi-journal-x"></i></div>
                            <h3>{{ __('No articles found') }}</h3>
                            <p>{{ __('There are currently no articles under this topic. Please check back later or return to the main blog page.') }}</p>
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