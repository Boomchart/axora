@extends('auth.email.menu')

@section('content')
<div class="d-flex flex-row-fluid flex-column flex-column-fluid text-center p-10 py-20">
    <div class="pt-30 mb-12 error-bg"></div>
    <div class="text-center">
        <div class="d-flex flex-column flex-lg-row-fluid">
            <div class="d-flex flex-center flex-column flex-column-fluid">
                <div class="w-lg-700px w-700px">
                    <h1 class="fw-bolder fs-5tx text-white mb-3">{{__('Sorry to see you go!')}}</h1>
                    <div class="fs-3 text-white mb-10">{{__('You have successfully unsubscribed from receiving promotional emails.')}}</div>
                    <div class="mb-10">
                        <a href="{{route('home')}}" class="btn btn-outline btn-block btn-outline-secondary btn-active-secondary">{{__('Home')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop