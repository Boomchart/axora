@extends('front.menu')
<meta name="description" content="{{$set->site_name}} Help Center" />
@section('css')

@stop
@section('content')
<section class="position-relative py-lg-5 pt-5 dd-bg" data-jarallax data-img-position="0% 100%" data-speed="0.5">
    <div class="container position-relative zindex-2 pt-5 pb-2 pb-md-0 py-6">
        <div class="row justify-content-center pt-3 mt-3">
            <div class="col-xl-6 col-lg-7 col-md-8 col-sm-10 text-center">
                <h1 class="mb-4 text-success">{{__('How can we help?')}}</h1>
                <p class="fs-lg pb-3 mb-3 text-dark">{{__('Get quick answers to your questions about '.$set->site_name)}}</p>
                <form class="rounded shadow mt-n6 mb-4" action="{{route('help.search')}}" method="post" autocomplete="off">
                    @csrf
                    <div class="input-group input-group-lg">
                        <span class="input-group-text border-0">
                            <i class="fe fe-search"></i>
                        </span>
                        <input value="" name="term" id="term" class="form-control border-0 px-1" type="text" placeholder="{{__('Search for your issue')}}..." required>
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
<section class="container py-3 my-2 my-md-4 my-lg-5">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-10 text-start">
                    <h2 class="h3 mb-4 text-success">{{__('Popular Articles')}}</h2>
                    <span class="text-dark text-uppercase"></span> @foreach(getPopularHelpCenter(10) as $val) <span class="badge bg-secondary rounded-pill me-2 mb-3 cursor-pointer text-dark badge-lg" data-href="{{route('help.article', ['article' => $val->slug])}}">{{$val->question}}</span> @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<section class="container py-5 my-2 my-md-4 my-lg-5">
    <div class="card bg-secondary rounded-5">
        <div class="card-body p-md-5 p-5">
            <h2 class="h3 pt-1 pt-xl-2 mb-5 text-success">{{__('Browse by Topic')}}</h2>
            <div class="row g-4 pb-xl-3">
                @foreach(getHelpCenterTopics() as $val)
                <div class="col-12 col-md-4">
                    <div class="card mb-6 mb-md-8 cursor-pointer get-color rounded-5" style="z-index:99999;" data-href="{{route('help.topic', ['topic' => $val->slug])}}">
                        <div class="card-body">
                            <img src="{{url('/').'/storage/app/'.$val->image}}" class="d-block mb-4 card-image" width="56" alt="{{$val->title}}">
                            <h3 class="text-dark fw-500 fs-5">{{$val->name}}</h3>
                            <p class="text-dark fs-6">{{$val->description}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@stop
@section('script')

<script>
    function fetchColor(changeClass, fromClass) {
        const colorThief = new ColorThief();
        $('.' + changeClass).each(function(index, card) {
            const cardImage = $(card).find('img.' + fromClass)[0];
            const dominantColor = colorThief.getColor(cardImage);
            $(card).css('background-color', `rgb(${dominantColor[0]}, ${dominantColor[1]}, ${dominantColor[2]}, 0.12)`);

        });
    }

    fetchColor('get-color', 'card-image');

    $('div[data-href]').on("click", function() {
        window.location.href = $(this).data('href');
    });
    $('span[data-href]').on("click", function() {
        window.location.href = $(this).data('href');
    });
</script>
@endsection