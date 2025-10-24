@extends('user.menu')
@section('content')
<div class="toolbar" id="kt_toolbar">
  <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
      <h1 class="text-dark fw-bold my-1 fs-2 mb-6">{{__('Settings')}}</h1>
      <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-7 border-gray-300" id="tabs-icons-text" role="tablist">
        <li class="nav-item">
          <a class="nav-link text-dark @if(route('user.profile', ['type' => 'profile'])==url()->current()) active @endif" id="tabs-icons-text-1-tab" href="{{route('user.profile', ['type' => 'profile'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Profile')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark @if(route('user.profile', ['type' => 'api'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('user.profile', ['type' => 'api'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('API Keys & Webhook')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark @if(route('user.profile', ['type' => 'security'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('user.profile', ['type' => 'security'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Security')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark @if(route('user.profile', ['type' => 'notifications'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('user.profile', ['type' => 'notifications'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Notifications')}}</a>
        </li>
      </ul>
    </div>
  </div>
  @livewire('user.settings.options', ['user' => $user, 'set' => $set, 'secret' => $secret, 'image' => $image])
  <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
    <div class="container">
      @if(route('user.profile', ['type' => 'profile'])==url()->current())
      @livewire('user.settings.index', ['user' => $user, 'type' => 'profile'])
      @endif

      @if(route('user.profile', ['type' => 'api'])==url()->current() && $set->api_resell)
      @livewire('user.settings.index', ['user' => $user, 'type' => 'api', 'settings' => $set])
      @endif

      @if(route('user.profile', ['type' => 'security'])==url()->current())
      <div class="d-flex flex-stack cursor-pointer mt-6" data-bs-toggle="modal" data-bs-target="#resetpassword">
        <div class="d-flex align-items-center">
          <div class="symbol symbol-45px symbol-circle me-4">
            <div class="symbol-label bg-warning">
              <i class="bi bi-unlock text-dark fs-3"></i>
            </div>
          </div>
          <div class="ps-1">
            <p href="#" class="fs-7 text-gray-800 text-hover-success fw-bold mb-0">{{__('Reset Password')}}</p>
          </div>
        </div>
      </div>
      @endif

      @if(route('user.profile', ['type' => 'notifications'])==url()->current())
      @livewire('user.settings.notifications', ['user' => $user])
      @endif
    </div>
  </div>
</div>
@stop