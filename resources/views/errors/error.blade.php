@extends('errors.menu', ['title' => $title])

@section('content')
<div class="d-flex flex-row-fluid flex-column flex-column-fluid text-center p-10 py-20">
    <div class="pt-30 mb-12 error-bg"></div>
    <div class="text-center">
        <div class="d-flex flex-column flex-lg-row-fluid">
            <div class="d-flex flex-center flex-column flex-column-fluid">
                <div class="w-lg-700px w-700px">
                    @if($errors->any())
                    @foreach($errors->all() as $error)
                    <div class="fs-3 fw-bold text-white mb-10">{!!$error!!}</div>
                    @endforeach
                    @endif
                    <div class="mb-10">
                        <a href="{{url()->previous()}}" class="btn btn-outline btn-lg btn-outline-secondary btn-active-secondary">{{__('Go back')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop