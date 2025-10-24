@extends('front.menu', ['title' => $set->site_desc])
@section('css')

@stop
@section('content')
<section class="overflow-hidden pt-5 pb-5 hero">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8 text-center mt-md-4 pt-5">
                @if($set->api_resell)
                <div class="center-screen mb-5">
                    <a class="developer-link text-center text-dark" href="{{route('developer.index')}}" target="_blank">
                        {{__('Try our Gift Card Developer API')}}
                        <div class="arrowRight">
                            <i class="bi bi-arrow-right text-white"></i>
                        </div>
                    </a>
                </div>
                @endif

                <h1 class="display-5 pb-3 text-dark">
                    {{getUi()->h1_t}}
                </h1>
                <p class="fs-5 pb-2 pb-md-3 mb-3 text-dark">{{getUi()->h1_b}}</p>
                <div>
                    <a href="{{route('register')}}" class="btn btn-success btn-lg rounded-pill me-3">{{__('Get Started')}}</a>
                    <a href="{{route('contact')}}" class="btn btn-outline-dark btn-lg rounded-pill">{{__('Speak to sales')}}</a>
                </div>
            </div>
            <div class="col-md-11 text-center mt-5">
                <img src="{{asset('asset/images/'.getUi()->image1)}}" style="max-width:100%; height:auto;" class="rounded-5">
            </div>
        </div>
    </div>
</section>
@if($set->giftcard_sell)
<section class="container py-5 mt-md-5 my-lg-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-11">
            <div class="card get-color rounded-5">
                <div class="card-body p-md-5 p-5">
                    <div class="row">
                        <div class="col-md-5">
                            <h2 class="fs-1 pb-3 text-dark">{{getUi()->h3_t}}</h2>
                            <p class="fs-5 text-start text-md-start text-dark">{{getUi()->h3_b}}</p>
                        </div>
                        <div class="col-md-7">
                            <div style="
                            height: 400px;
                            background-image: url({{asset('asset/images/'.getUi()->image2)}}); 
                            background-repeat: no-repeat; 
                            background-position: right bottom;
                            background-size: contain;
                            "></div>
                            <img src="{{asset('asset/images/'.getUi()->image2)}}" style="display:none;" class="card-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if($set->giftcard_buy)
<section class="container py-5 mt-md-5 my-lg-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-11">
            <div class="card get-color rounded-5">
                <div class="card-body p-md-5 p-5">
                    <div class="row">
                        <div class="col-md-5">
                            <h2 class="fs-1 pb-3 text-success">{{getUi()->h4_t}}</h2>
                            <p class="fs-5 text-start text-md-start text-dark">{{getUi()->h4_b}}</p>
                        </div>
                    </div>
                </div>
                <div style="height: 200px;background-image: url({{asset('asset/images/'.getUi()->image3)}}); background-repeat: no-repeat; background-position: bottom;background-size: contain;"></div>
                <img src="{{asset('asset/images/'.getUi()->image3)}}" style="display:none;" class="card-image">

            </div>
        </div>
    </div>
</section>
@endif
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
@if(count(getReview()) > 0 && $set->reviews == 1)
<section class="container py-5 mb-2 mt-md-2 mb-md-4 mt-lg-4 mb-lg-5">
    <h2 class="fs-1 pb-3 text-success">{{getUi()->h5_t}}</h2>
    <div class="row pt-xl-1 pb-xl-3 align-items-center justify-content-center">
        <div class="col-md-12">
            <div class="swiper mx-n2" data-swiper-options='{
              "slidesPerView": 1,
              "spaceBetween": 8,
              "autoplay": true,
              "loop": true,
              "navigation": {
                "prevEl": "#prev-testimonial",
                "nextEl": "#next-testimonial"
              },
              "breakpoints": {
                "500": {
                  "slidesPerView": 1
                },
                "1000": {
                  "slidesPerView": 3
                },
                "1200": {
                  "slidesPerView": 3
                }
              }
            }'>
                <div class="swiper-wrapper">
                    @foreach(getReview() as $val)
                    <div class="swiper-slide h-auto pt-4">
                        <figure class="d-flex flex-column px-2 px-sm-0 mb-0 mx-2">
                            <div class="card position-relative border-0 pt-4 rounded-5 get-color">
                                <figcaption class="d-flex align-items-center ps-4 pt-4">
                                    <img src="{{url('/').'/storage/app/'.$val->image}}" width="48" class="rounded-circle card-image" alt="{{$val->name}}">
                                    <div class="ps-3">
                                        <h4 class="fs-6 fw-500 mb-0">{{$val->name}}</h4>
                                        <span class="fs-6 text-dark">{{$val->occupation}}</span>
                                    </div>
                                </figcaption>
                                <blockquote class="card-body pb-3 mb-5">
                                    <p class="mb-0 card-text-color fs-5 fw-500">“{{$val->review}}”</p>
                                </blockquote>
                            </div>
                        </figure>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if(count(getBrands()) > 0 && $set->brands == 1)
<section class="container mt-2 pt-3 pt-lg-5 pb-5">
    <div class="row">
        @foreach(getBrands() as $val)
        <div class="col-md-2 col-6 py-3">
            <div class="card card-body px-2 mx-2">
                <img src="{{url('/').'/storage/app/'.$val->image}}" class="d-block mx-auto my-2" width="150" alt="Brand">
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif
@if(count(getTeam()) > 0 && $set->team == 1)
<section class="container py-5 my-md-3 my-lg-5">
    <h2 class="fs-1 pb-3 text-success">{{__('Meet The Team')}}</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-6 g-4">

        <!-- Item -->
        @foreach(getTeam() as $val)
        <div class="col">
            <div class="card card-hover border-0 bg-transparent">
                <div class="position-relative">
                    <img src="{{url('/').'/storage/app/'.$val->image}}" class="rounded-3" alt="{{$val->name}}">
                    <div class="card-img-overlay d-flex flex-column align-items-center justify-content-center rounded-3">
                        <span class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-25 rounded-3"></span>
                        <div class="position-relative d-flex zindex-2">
                            @if($val->linkedin != null)
                            <a href="{{$val->linkedin}}" target="_blank" class="btn btn-icon btn-secondary btn-linkedin btn-sm bg-white me-2">
                                <i class="bx bxl-linkedin"></i>
                            </a>
                            @endif
                            @if($val->twitter != null)
                            <a href="{{$val->twitter}}" target="_blank" class="btn btn-icon btn-secondary btn-twitter btn-sm bg-white">
                                <i class="bx bxl-twitter"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body text-center p-3">
                    <h3 class="fs-lg fw-semibold pt-1 mb-2">{{$val->name}}</h3>
                    <p class="fs-sm mb-0">{{$val->position}}</p>
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
            $(card).css('background-color', `rgb(${dominantColor[0]}, ${dominantColor[1]}, ${dominantColor[2]}, 0.12)`);
            const cardTextColor = $(card).find('.card-text-color');
            if (cardTextColor.length > 0) {
                const formatedColor = darkenColor(dominantColor[0], dominantColor[1], dominantColor[2], 0.4);
                cardTextColor.css('color', `rgb(${formatedColor[0]}, ${formatedColor[1]}, ${formatedColor[2]})`)
            }

        });
    }

    fetchColor('get-color', 'card-image');
</script>
@endsection