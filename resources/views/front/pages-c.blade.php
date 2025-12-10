@extends('front.menu')

@section('content')
<section class="position-relative py-lg-5 pt-5" style="background-image: url({{asset('asset/images/auth.svg')}});" data-jarallax data-img-position="0% 100%" data-speed="0.5">
    <div class="container position-relative zindex-2 pt-5 pb-2 pb-md-0 py-6">
        <div class="row justify-content-center pt-3 mt-3">
            <div class="col-xl-6 col-lg-7 col-md-8 col-sm-10 text-center">
                <h1 class="mb-4">{{$page->title}}</h1>
            </div>
        </div>
    </div>
</section>
<section class="container mb-5 pt-4 pb-2 py-mg-4">
    <div class="row gy-4">
        <div class="col-lg-12">
            <p class="text-start">{!!$page->details!!}</p>
        </div>
    </div>
</section>
@stop