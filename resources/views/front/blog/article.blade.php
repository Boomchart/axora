@extends('front.menu', ['title' => $article->title])

@php
    $seoArticleUrl = route('blog.article', ['blog' => $article->slug]);
    $seoArticleImage = (!empty($article->image) && file_exists(storage_path('app/' . $article->image)))
        ? url('/') . '/storage/app/' . $article->image
        : null;
    // Decode twice to unwind any double-encoded entities in stored content, then collapse whitespace.
    $seoArticlePlain = trim(preg_replace('/\s+/', ' ',
        html_entity_decode(html_entity_decode(strip_tags($article->details), ENT_QUOTES | ENT_HTML5), ENT_QUOTES | ENT_HTML5)));
    $seoArticleDesc = Str::words($seoArticlePlain, 30, '');
@endphp

@section('meta_description', Str::words($seoArticlePlain, 25, ''))
@section('seo_type', 'article')
@section('seo_canonical', $seoArticleUrl)
@if($seoArticleImage)
    @section('seo_image', $seoArticleImage)
@endif

@push('ld')
<script type="application/ld+json">
{!! json_encode(array_filter([
    '@context'         => 'https://schema.org',
    '@type'            => 'Article',
    'headline'         => $article->title,
    'description'      => $seoArticleDesc,
    'image'            => $seoArticleImage,
    'datePublished'    => optional($article->created_at)->toIso8601String(),
    'dateModified'     => optional($article->updated_at ?? $article->created_at)->toIso8601String(),
    'mainEntityOfPage' => $seoArticleUrl,
    'author'           => ['@type' => 'Organization', 'name' => $set->site_name],
    'publisher'        => [
        '@type' => 'Organization',
        'name'  => $set->site_name,
        'logo'  => ['@type' => 'ImageObject', 'url' => asset('asset/images/favicon.png')],
    ],
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('css')
 <link href="{{asset('css/posts.css')}}" rel="stylesheet">
@stop

@section('content')
    <section class="axora-blog-article-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <nav class="axora-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">{{ __('Blog') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blog.category', ['category' => $article->category->id, 'slug' => Str::slug($article->category->name)]) }}">{{ $article->category->name }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Article') }}</li>
                        </ol>
                    </nav>

                    <span class="axora-blog-category-badge"><i class="bi bi-folder2-open"></i>{{ $article->category->name }}</span>
                    <h1 class="axora-blog-article-title">{{ $article->title }}</h1>

                    <div class="axora-blog-article-meta">
                        <span><i class="bi bi-calendar3"></i>{{ Carbon\Carbon::create($article->updated_at)->format('M j, Y') }}</span>
                        <span><i class="bi bi-clock"></i>{{ estimateReadingTime($article->details) }} {{ __('read') }}</span>
                    </div>

                    <div class="axora-blog-share">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.article', ['blog' => $article->slug])) }}" target="_blank" rel="noopener" aria-label="{{ __('Share on Facebook') }}">
                            <i class="bi bi-facebook"></i>
                        </a>

                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.article', ['blog' => $article->slug])) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener" aria-label="{{ __('Share on X') }}">
                            <i class="bi bi-twitter-x"></i>
                        </a>

                        <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . route('blog.article', ['blog' => $article->slug])) }}" target="_blank" rel="noopener" aria-label="{{ __('Share on WhatsApp') }}">
                            <i class="bi bi-whatsapp"></i>
                        </a>

                        <a href="mailto:?subject={{ urlencode($article->title) }}&body={{ urlencode(route('blog.article', ['blog' => $article->slug])) }}"
                           aria-label="{{ __('Share by email') }}">
                            <i class="bi bi-envelope"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="axora-blog-article-section">
        <div class="container">
            <div class="row justify-content-center g-4">

                <div class="col-lg-8">
                    @php
                        $articleImagePath = $article->image ? storage_path('app/' . $article->image) : null;
                    @endphp

                    @if($articleImagePath && file_exists($articleImagePath))
                        <img class="axora-blog-featured-image" src="{{ url('/') . '/storage/app/' . $article->image }}" alt="{{ $article->title }}" loading="lazy">
                    @endif

                    <article class="axora-blog-content-card">
                        <div class="axora-blog-content">{!! $article->details !!}</div>
                    </article>
                </div>

                <div class="col-lg-4">
                    <aside class="axora-blog-sidebar">

                        <div class="axora-blog-sidebar-card">
                            <h3>{{ __('Search the Blog') }}</h3>
                            @livewire('blog-article-search')
                        </div>

                        <div class="axora-blog-sidebar-card">
                            <h3>{{ __('Categories') }}</h3>

                            <ul class="axora-blog-category-list">
                                <li><a href="{{ route('blog.index') }}"><span>{{ __('All topics') }}</span></a></li>

                                @foreach(getBlogCat() as $val)
                                    <li>
                                        <a href="{{ route('blog.category', ['category' => $val->id, 'slug' => Str::slug($val->name)]) }}">
                                            <span>{{ $val->name }}</span>
                                            <span class="axora-blog-category-count">{{ $val->articles->count() }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @if(count(getPopularBlog(3)) > 0)
                            <div class="axora-blog-sidebar-card">
                                <h3>{{ __('Popular Posts') }}</h3>

                                <ul class="axora-popular-list">
                                    @foreach(getPopularBlog(3) as $val)
                                        <li>
                                            <a href="{{ route('blog.article', ['blog' => $val->slug]) }}">{{ Str::words($val->title, 10) }}</a>
                                            <span class="axora-popular-date"><i class="bi bi-calendar3"></i>{{ $val->created_at->format('M j, Y') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </aside>
                </div>

            </div>
        </div>
    </section>

    @if(count(getRelatedBlog(3, $article->cat_id, $article->id)) > 0)
        <section class="axora-related-section">
            <div class="container">
                <div class="axora-related-header">
                    <h2>{{ __('Related Articles') }}</h2>

                    <p>{{ __('Continue exploring more insights, guides, and updates from this topic.') }}</p>
                </div>

                <div class="row justify-content-center g-4">
                    @foreach(getRelatedBlog(3, $article->cat_id, $article->id) as $val)
                        <div class="col-12 col-md-6 col-lg-4">
                            <a href="{{ route('blog.article', ['blog' => $val->slug]) }}" class="axora-related-card">
                                @php
                                    $relatedImagePath = $val->image ? storage_path('app/' . $val->image) : null;
                                @endphp

                                @if($relatedImagePath && file_exists($relatedImagePath))
                                    <div class="axora-related-card-image"><img src="{{ url('/') . '/storage/app/' . $val->image }}" alt="{{ $val->title }}" loading="lazy"></div>
                                @else
                                    <div class="axora-blog-image axora-blog-image-placeholder"><i class="bi bi-journal-text"></i></div>
                                @endif

                                <div class="axora-related-card-body">
                                    <span class="axora-related-card-category">{{ $val->category->name }}</span>
                                    <h3>{{ Str::words($val->title, 10) }}</h3>
                                    <p>{{ Str::words(strip_tags(html_entity_decode(trim($val->details))), 20) }}</p>
                                    <div class="axora-related-card-meta">
                                        <span><i class="bi bi-calendar3"></i>{{ $val->created_at->format('M j, Y') }}</span>
                                        <span><i class="bi bi-clock"></i>{{ estimateReadingTime($val->details) }} {{ __('read') }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@stop

@section('script')
@endsection