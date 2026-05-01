@extends('user.menu')
@section('css')
<link rel="stylesheet" href="{{asset('vendor/prism/prism.css')}}">
<link rel="stylesheet" href="{{asset('dashboard/css/docs.css')}}" type="text/css">
@stop
@section('content')
@livewire('user.settings.api-log', ['user' => $user])
@stop
@push('scripts')
<script src="{{asset('vendor/prism/prism.js')}}"></script>
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', () => {
            if (window.Prism) Prism.highlightAll();
        });
    });
</script>
@endpush