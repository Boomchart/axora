@extends('front.menu')
<meta name="description" content="SupportMe Blog Search results for {{$term}}" />
@section('content')
<section class="position-relative py-lg-5 pt-5">
    <div class="container position-relative zindex-2 pt-5 pb-2 pb-md-0 py-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('blog')}}">{{__('Blog')}}</a></li>
                <li class="breadcrumb-item active text-success" aria-current="page">{{__('Search results')}}</li>
            </ol>
        </nav>
        <div class="row justify-content-center pt-3 mt-3">
            <div class="col-xl-6 col-lg-7 col-md-8 col-sm-10 text-center">
                <h1 class="mb-4">{{__('Search results')}}</h1>
                <p class="fs-lg pb-3 mb-3">{{count($article)}} {{__('results for')}} "<i>{{$term}}</i>"</p>
            </div>
        </div>
    </div>
</section>
<section class="container py-5 my-2 my-md-4 my-lg-5">
    <div class="row pb-6">
        <div class="col-12 col-md-12">
            <div class="list-group list-group-flush">
                @foreach($article as $val)
                <div class="list-group-item d-flex align-items-center cursor-pointer" data-href="{{route('blog.article', ['article' => $val->slug])}}">
                        <div class="me-auto">
                            <p class="fs-sm mb-0">{{$val->created_at->format('M j, Y')}}<span class="dot"></span>{{estimateReadingTime($val->details)}} read</p>
                            <p class="text-success fw-500 fs-5 mb-1">{{Str::words(strip_tags(html_entity_decode(trim($val->details))), 25)}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row justify-content-center align-items-center">
        <div class="col-md-12 text-center">
            {{$article->links('pagination::bootstrap-4')}}
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