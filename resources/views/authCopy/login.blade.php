@extends('auth.menu')

@section('content')
<div class="col-md-4">
  <div class="py-10">
      @livewire('auth.login', ['settings' => $set])
  </div>
</div>
@stop