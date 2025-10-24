@extends('errors.menu', ['title' => '429'])

@section('content')
<div class="d-flex flex-row-fluid flex-column flex-column-fluid text-center p-10 py-20">
    <div class="pt-30 mb-12 error-bg"></div>
    <div class="text-center">
        <div class="d-flex flex-column flex-lg-row-fluid">
            <div class="d-flex flex-center flex-column flex-column-fluid">
                <div class="w-lg-700px w-700px">
                    <h1 class="fw-bolder fs-7tx text-white mb-3">{{__('429')}}</h1>
                    <div class="fs-3 fw-bold text-white mb-10">{{__('Too many request.')}}</div>
                    <div class="mb-10">
                        <a href="{{url()->previous()}}" class="btn btn-outline btn-lg btn-outline-secondary btn-active-secondary">{{__('Go back')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop