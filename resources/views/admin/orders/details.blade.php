@extends('admin.menu')

@section('css')
<link rel="stylesheet" href="{{asset('vendor/prism/prism.css')}}">
<link rel="stylesheet" href="{{asset('dashboard/css/docs.css')}}" type="text/css">
@endsection
@section('content')
@livewire('admin.orders.details', ['settings' => $set, 'val' => $val, 'admin' => $admin])
@stop
@push('scripts')
    <script src="{{asset('vendor/prism/prism.js')}}"></script>
@endpush