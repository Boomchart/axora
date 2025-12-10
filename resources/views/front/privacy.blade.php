@extends('front.pages')

@section('page_header')
    <!-- Clean Page Header -->
    <section class="page-header-clean">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-header-title">Privacy Policy</h1>
                <p class="page-header-subtitle">
                    Your privacy matters to us. Learn how we collect, use, and protect your data when you use our gift card API platform.
                </p>
            </div>
        </div>
    </section>
@endsection


@section('content')
    <section class="image-content-section">
        <div class="container">
            <div class="row align-items-center justify-content-center g-5">
                <div class="col-lg-9">
                    {!!$set->privacy!!}
                </div>
            </div>
        </div>
    </section>
@stop