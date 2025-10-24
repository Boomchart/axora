@extends('front.menu', ['title' => $card->name])
@section('css')

@stop
@section('content')
<section class="overflow-hidden pt-5 pb-5 hero">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8 text-center mt-md-4 pt-5">
                <h1 class="display-5 pb-3 text-success">
                    {{__('Buy & Sell')}} {{$card->name}} {{__('Gift Cards')}}
                </h1>
                <p class="fs-3 pb-2 pb-md-3 mb-3 text-dark">{{$card->slogan}}</p>
                <div class="">
                    <a href="{{route('register')}}" class="btn btn-success btn-lg flex-shrink-0 me-md-4 mb-md-0 mb-sm-4 mb-3 rounded-pill">{{__('Get Started')}}</a>
                </div>

            </div>
            <div class="col-md-11 text-center mt-5">
                <img src="{{url('/').'/storage/app/'.$card->image}}" style="max-width:100%; height:auto;" class="rounded-5">
            </div>
        </div>
    </div>
</section>
<section class="container py-5 mt-md-5 my-lg-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-10">
            <div class="card card-body">
                <h2 class="fs-1 pb-3 text-success">{{__('Explore')}} {{$card->name}} {{__('Gift Cards on')}} {{$set->site_name}}</h2>
                <p class="fs-5 text-start text-md-start pb-2 pb-md-3 mb-3 text-dark">{{$card->description}}</p>
            </div>
        </div>
    </div>
</section>
<section class="container py-5 mt-md-5 my-lg-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-body">
                <h2 class="fs-1 pb-3 text-success">{{__('Popular')}} {{$card->name}} {{__('Gift Cards')}}</h2>
                <p class="fs-5 text-start text-md-start pb-2 pb-md-3 mb-3 text-dark">{{__('Some of the most popular')}} {{$card->name}} {{__('Gift Cards include')}} {{$suggestions}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($popular as $popularCards)
        <div class="col-md-3 px-4 mb-5">
            <div class="card position-relative border-0 pt-4 rounded-5 get-color">
                <div class="card-body">
                    <img src="{{url('/').'/storage/app/'.$popularCards->image}}" class="d-block mb-5 card-image rounded-circle" width="86" alt="{{$popularCards->name}}">
                    <h3 class="text-dark fw-500 fs-5">{{$popularCards->name}}</h3>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@if($set->services == 1)
<section class="container py-5 mt-md-5 my-lg-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-body">
                <h2 class="fs-1 pb-3 text-success">{{getUi()->h2_t}}</h2>
                <p class="fs-5 text-start text-md-start pb-2 pb-md-3 mb-3 text-dark">{{getUi()->h2_b}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach(getService() as $val)
        <div class="col-md-6 px-4 mb-5">
            <div class="card position-relative border-0 pt-4 rounded-5 get-color">
                <div class="card-body">
                    <img src="{{url('/').'/storage/app/'.$val->image}}" class="d-block mb-4 card-image" width="56" alt="{{$val->title}}">
                    <h3 class="text-dark fw-500 fs-4">{{$val->title}}</h3>
                    <p class="text-dark fs-5">{{$val->details}}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif
@stop
@section('script')
<script>
    function darkenColor(r, g, b, factor) {
        // Ensure the factor is between 0 and 1
        if (factor < 0 || factor > 1) {
            throw new Error('Factor must be between 0 and 1');
        }

        // Calculate the darkened color
        const darkenedR = Math.round(r * factor);
        const darkenedG = Math.round(g * factor);
        const darkenedB = Math.round(b * factor);

        return [darkenedR, darkenedG, darkenedB];
    }

    function fetchColor(changeClass, fromClass) {
        const colorThief = new ColorThief();
        $('.' + changeClass).each(function(index, card) {
            const cardImage = $(card).find('img.' + fromClass)[0];
            const dominantColor = colorThief.getColor(cardImage);
            $(card).css('background-color', `rgb(${dominantColor[0]}, ${dominantColor[1]}, ${dominantColor[2]}, 0.2)`);
        });
    }

    fetchColor('get-color', 'card-image');
</script>
@endsection