@if($set->language==1 && count(getLang()) > 0)
<div class="text-center mb-6">
  <div class="row align-items-center justify-content-center">
    <div class="col-md-6">
      <div class="btn-group dropdown">
        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="fi fi-{{strtolower(getDefaultLang()->iso2)}} me-2 fis fs-sm rounded-4 text-dark"></span> <span>{{ucwords(getDefaultLang()->name)}} ({{ucwords(getDefaultLang()->iso2)}})</span>
        </button>
        <div class="dropdown-menu my-1">
          @foreach(getLang() as $val)
          <a class="dropdown-item" href="{{route('lang', ['locale' => $val->code])}}"><span class="fi fi-{{strtolower($val->iso2)}} me-2 fis fs-sm rounded-4 text-dark"></span> {{ucwords($val->name)}} ({{$val->iso2}})</a>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endif

@if($set->homepage == 1) 
<div class="d-flex flex-center flex-wrap fs-7 p-5 pb-0">
  <div class="d-flex flex-center fw-bold fs-7">
    <a href="{{route('terms')}}" class="text-dark text-hover-success px-2" target="_blank">{{__('Terms & Conditions')}}</a>
    <a href="{{route('privacy')}}" class="text-dark text-hover-success px-2" target="_blank">{{__('Privacy')}}</a>
  </div>
</div>
@endif