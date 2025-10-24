@extends('auth.menu')

@section('content')
<div class="col-md-5">
  <div class="py-10">
      @livewire('auth.admin-security', ['set' => $set, 'admin' => $admin])
  </div>
</div>
@stop