@extends('front.menu')
<meta name="description" content="{{$topic->description}}" />
@section('css')

@stop
@section('content')
<section class="position-relative py-lg-5 pt-5 dd-bg" data-jarallax data-img-position="0% 100%" data-speed="0.5">
    <div class="container position-relative zindex-2 pt-5 pb-2 pb-md-0 py-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="bx bx-home-alt fs-lg me-1"></i> {{__('Home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('help.center')}}">{{__('Help Center')}}</a></li>
                <li class="breadcrumb-item active text-success" aria-current="page">{{$topic->name}}</li>
            </ol>
        </nav>
        <div class="row justify-content-center pt-3 mt-3">
            <div class="col-xl-6 col-lg-7 col-md-8 col-sm-10 text-center">
                <h1 class="mb-4 text-success">{{$topic->name}}</h1>
                <p class="fs-lg pb-3 mb-3 text-dark">{{$topic->description}}</p>
            </div>
        </div>
    </div>
</section>
<section class="container py-5 my-2 my-md-4 my-lg-5">
    @if($topic->faq->count()>0)
    <div class="row pb-6">
        <div class="col-12 col-md-12">
            <div class="list-group list-group-flush">
                @foreach($topic->faq as $val)
                <div class="list-group-item d-flex align-items-center cursor-pointer" data-href="{{route('help.article', ['article' => $val->slug])}}">
                    <div class="me-auto">
                        <p class="fw-semibold mb-1 text-success fs-5">{{$val->question}}</p>
                        <p class="fs-6 mb-0">{{Str::words(strip_tags($val->answer), 25)}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
            <h3 class="text-center mb-1">
                {{__('No article found under this topic')}}
            </h3>
        </div>
    </div>
    @endif
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