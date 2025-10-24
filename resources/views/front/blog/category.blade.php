@extends('front.menu')
<meta name="description" content="Blog" />
@section('css')

@stop
@section('content')
<section class="position-relative py-lg-5 pt-5 dd-bg" data-jarallax data-img-position="0% 100%" data-speed="0.5">
    <div class="container position-relative zindex-2 pt-5 pb-2 pb-md-0 py-6">
        <div class="row justify-content-center pt-3 mt-3">
            <div class="col-xl-6 col-lg-7 col-md-8 col-sm-10 text-center">
                <h1 class="mb-4 text-success">{{$title}}</h1>
                <form class="rounded shadow mt-n6 mb-4" action="{{route('blog.search')}}" method="post" autocomplete="off">
                    @csrf
                    <div class="input-group input-group-lg">
                        <span class="input-group-text border-0">
                            <i class="fe fe-search"></i>
                        </span>
                        <input value="" name="term" id="term" class="form-control border-0 px-1" type="text" placeholder="{{__('Search stories')}}..." required>
                        <span class="input-group-text border-0">
                            <button class="btn btn-sm btn-success rounded-pill" type="submit">{{__('Search')}}</button>
                        </span>
                    </div>
                    @error ('term')
                    <span class="font-size-1 text-danger">{{$message}}</span>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</section>
<section class="bg-secondary py-5 mb-lg-5">
    <div class="container pt-2 pt-lg-4 pt-xl-5">
        <div class="row mb-6">
            <div class="col-12">
                <h2 class="h3 mb-4 pb-lg-3 pt-lg-1 pb-1 text-left text-success">{{__('All articles')}}</h2>
            </div>
        </div>
        @if($category->articles()->paginate(10)->count() > 0)
        <div class="row mb-6">
            @foreach($category->articles()->paginate(10) as $val)
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
        @else
        <div class="row justify-content-center">
            <div class="col-12 col-xl-11">
                <div class="text-center">
                    <img src="{{asset('asset/images/not_found.webp')}}" alt="..." class="img-fluid mb-3" style="width: 200px;">
                </div>
                <h3 class="text-center mb-1">
                    {{__('No article found under this topic')}}
                </h3>
            </div>
        </div>
        @endif
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12 text-center">
                {{getLatestBlog(10)->links('pagination::bootstrap-4')}}
            </div>
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
</script>
@endsection