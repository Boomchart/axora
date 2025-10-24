@extends('user.menu')

@section('css')
<link rel="stylesheet" href="{{asset('vendor/prism/prism.css')}}">
<link rel="stylesheet" href="{{asset('dashboard/css/docs.css')}}" type="text/css">
@endsection
@section('content')
@livewire('user.orders.details', ['user'=> $user, 'settings' => $set, 'val' => $val])
@stop
@push('scripts')
    <script src="{{asset('vendor/prism/prism.js')}}"></script>
@endpush