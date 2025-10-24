@extends('front.menu')
<meta name="description" content="{{Str::words(strip_tags($article->answer), 25)}}" />
@livewireStyles
@section('css')

@stop
@section('content')
<section class="position-relative py-lg-5 pt-5">
    <div class="container position-relative zindex-2 pt-5 pb-2 pb-md-0 py-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="bx bx-home-alt fs-lg me-1"></i> {{__('Home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('help.center')}}">{{__('Help Center')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('help.topic', ['topic' => $article->category->slug])}}">{{$article->category->name}}</a></li>
                <li class="breadcrumb-item active text-success" aria-current="page">{{__('Article')}}</li>
            </ol>
        </nav>
        <div class="row justify-content-center pt-3 mt-3">
            <div class="col-12 text-left">
                <h1 class="mb-4 h2 text-success">{{$article->question}}</h1>
                <p class="fs-lg pb-3 mb-3 text-dark">{{__('Last update')}}: {{Carbon\Carbon::create($article->updated_at)->format('M j, Y')}}</p>
            </div>
        </div>
    </div>
</section>
<section class="pt-8 pt-md-11 py-8">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8">
                <span class="preserveLines">{{$article->answer}}</span>
                <div class="mt-5"></div>
                @livewire('article-likes', ['article' => $article])
            </div>
            <div class="col-12 col-md-4">
                @if(count($article->relatedArticles(10))>0)
                <div class="card shadow-light-lg mb-5">
                    <div class="card-body">
                        <h5 class="mb-6 h5">{{__('Related articles')}}</h5>
                        @foreach($article->relatedArticles(10) as $val)
                        <p class="text-uppercase text-success mb-6 cursor-pointer fs-sm" data-href="{{route('help.article', ['article' => $val->slug])}}">
                            <u>{{$val->question}}</u>
                        </p>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="card shadow-light-lg">
                    <div class="card-body">
                        <h5>{{__('Not seeing what you need')}}?</h5>
                        <a href="{{route('contact')}}" class="text-decoration-none text-primary cursor-pointer">{{__('Contact us')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
@livewireScripts
@section('script')
<script src="{{asset('asset/dashboard/vendor/jquery/dist/jquery.min.js')}}"></script>
<script>
    $('div[data-href]').on("click", function() {
        window.location.href = $(this).data('href');
    });
    $('h6[data-href]').on("click", function() {
        window.location.href = $(this).data('href');
    });
</script>
@endsection