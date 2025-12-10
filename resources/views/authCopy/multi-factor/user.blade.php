@extends('auth.menu')

@section('content')
<div class="col-md-4">
  <div class="py-10">
      @livewire('auth.security', ['set' => $set, 'user' => $user])
  </div>
</div>
@stop