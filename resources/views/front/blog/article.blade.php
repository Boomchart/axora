@extends('front.menu')
<meta name="description" content="{{Str::words(strip_tags($article->details), 25)}}" />
<meta property="og:type" content="website">
<meta property="og:title" content="{{$article->title}}">
<meta property="og:description" content="{{strip_tags($article->details)}}">
<meta property="og:image" content="{{$article->image}}" />
<meta property="og:url" content="{{route('blog.article', ['article' => $article->slug])}}">
@section('css')

@stop
@section('content')
<section class="position-relative py-lg-5 pt-5">
    <div class="container position-relative zindex-2 pt-5 pb-2 pb-md-0 py-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="bx bx-home-alt fs-lg me-1"></i> {{__('Home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('blog')}}">{{__('Newsroom')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('blog.category', ['category' => $article->category->id, 'slug' => Str::slug($article->category->name)])}}">{{$article->category->name}}</a></li>
                <li class="breadcrumb-item active text-success" aria-current="page">{{__('Article')}}</li>
            </ol>
        </nav>
        <div class="row justify-content-center pt-3 mt-3">
            <div class="col-12 text-left">
                <h1 class="mb-4 h2 text-success">{{$article->title}}</h1>
                <p class="fs-sm pb-3 mb-3 text-dark"><i class="fal fa-calendar-alt"></i> {{Carbon\Carbon::create($article->updated_at)->format('M j, Y')}}</p>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-6 text-start mb-3">
                <p class="fs-sm mb-0"><span class="badge bg-faded-primary text-primary fs-base">{{$article->category->name}}</span> <span class="dot"></span>{{estimateReadingTime($article->details)}} {{__('read')}}</p>
            </div>

            <div class="col-md-6 text-md-end">
                <!-- Icons -->
                <ul class="d-inline list-unstyled list-inline list-social">
                    <li class="list-inline-item list-social-item me-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{route('blog.article', ['article' => $article->slug])}}" class="btn btn-icon btn-secondary btn-facebook btn-sm">
                            <i class="bi bi-facebook"></i>
                        </a>
                    </li>
                    <li class="list-inline-item list-social-item me-3">
                        <a href="https://twitter.com/intent/tweet?text={{route('blog.article', ['article' => $article->slug])}}" class="btn btn-icon btn-secondary btn-facebook btn-sm">
                            <i class="bi bi-twitter"></i>
                        </a>
                    </li>
                    <li class="list-inline-item list-social-item me-3">
                        <a href="https://wa.me/?text={{route('blog.article', ['article' => $article->slug])}}" class="btn btn-icon btn-secondary btn-facebook btn-sm">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </li>
                    <li class="list-inline-item list-social-item me-3">
                        <a href="mailto:?body={{route('blog.article', ['article' => $article->slug])}}" class="btn btn-icon btn-secondary btn-facebook btn-sm">
                            <i class="bi bi-envelope"></i>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</section>
<section class="container mb-5 pt-4 pb-2 py-mg-4">
    <div class="row gy-4">

        <!-- Content -->
        <div class="col-lg-8">
            <div class="mb-5 text-center">
                <img class="rounded-5" src="{{url('/').'/storage/app/'.$article->image}}" alt="{{$article->name}}">
            </div>
            <p class="text-start">{!!$article->details!!}</p>
        </div>

        <!-- Sharing -->
        <div class="col-lg-4 position-relative">
            <div class="sticky-top ms-xl-5 ms-lg-4 ps-xxl-4" style="top: 105px !important;">
                <form class="input-group mb-4" action="{{route('blog.search')}}" method="post" autocomplete="off">
                    @csrf
                    <input type="text" name="term" placeholder="Search the blog..." class="form-control rounded pe-5">
                    <i class="bx bx-search position-absolute top-50 end-0 translate-middle-y me-3 fs-lg zindex-5"></i>
                </form>

                <!-- Categories -->
                <div class="card card-body mb-4 border">
                    <h3 class="h5 text-success">{{__('Categories')}}</h3>
                    <ul class="nav flex-column fs-sm">
                        <li class="nav-item mb-1">
                            <a href="{{route('blog')}}" class="nav-link py-1 px-0">{{__('All topics')}}</a>
                        </li>
                        @foreach(getBlogCat() as $val)
                        <li class="nav-item mb-1">
                            <a href="{{route('blog.category', ['category' => $val->id, 'slug' => Str::slug($val->name)])}}" class="nav-link py-1 px-0">{{$val->name}}({{$val->articles->count()}})</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Popular posts -->
                <div class="card card-body border-0 position-relative mb-4">
                    <span class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-primary opacity-10 rounded-3"></span>
                    <div class="position-relative zindex-2">
                        <h3 class="h5 text-success">{{__('Popular posts')}}</h3>
                        <ul class="list-unstyled mb-0">
                            @foreach(getPopularBlog(3) as $val)
                            <li class="border-bottom pb-3 mb-3 cursor-pointer @if($loop->last == $val->id)border-bottom-0 @endif" data-href="{{route('blog.article', ['article' => $val->slug])}}">
                                <p class="fs-5 fs-500 mb-2 text-success">{{Str::words($val->title, 10)}}</p>
                                <div class="d-flex align-items-center text-muted pt-1">
                                    <div class="fs-xs border-end pe-3 me-3">{{$val->created_at->format('M j, Y')}}</div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-secondary pb-5">
    <div class="container pt-2 pt-lg-4 pt-xl-5">
        <h2 class="h3 mb-4 pb-lg-3 pt-lg-1 pb-1 text-left text-success">{{__('Related articles')}}</h2>
        <div class="row mb-6">
            @foreach(getRelatedBlog(3, $article->cat_id, $article->id) as $val)
            <div class="col-12 col-md-6 col-lg-4 d-flex cursor-pointer" data-href="{{route('blog.article', ['article' => $val->slug])}}">
                <article class="card border-0 h-100 mx-1">
                    <div class="position-relative">
                        <img src="{{url('/').'/storage/app/'.$val->image}}" class="card-img-top" alt="{{$val->title}}">
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge fs-sm text-nav bg-secondary text-decoration-none">{{$val->category->name}}</span>
                        </div>
                        <p class="text-success fs-4 fs-500">{{Str::words($val->title, 10)}}</p>
                        <p class="mb-0 text-dark fs-6">{{Str::words(strip_tags(html_entity_decode(trim($val->details))), 20)}}</p>
                    </div>
                    <div class="card-footer">
                        <p class="fs-sm text-uppercase text-muted mb-0 ms-auto">
                            <time datetime="2019-05-02">{{$val->created_at->format('M j, Y')}}</time>
                            <span class="dot"></span> {{estimateReadingTime($val->details)}} {{__('read')}}
                        </p>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
    </div>
</section>
@stop
@section('script')
<script src="{{asset('front/vendor/jquery/dist/jquery.min.js')}}"></script>
<script>
    $('div[data-href]').on("click", function() {
        window.location.href = $(this).data('href');
    });    
    $('li[data-href]').on("click", function() {
        window.location.href = $(this).data('href');
    });
    $('h6[data-href]').on("click", function() {
        window.location.href = $(this).data('href');
    });
</script>
@endsection