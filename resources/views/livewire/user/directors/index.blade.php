<div>
    @if($directors->count() > 0)
    <div class="" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage, date">
        @foreach($directors as $val)
        <div class="d-flex flex-stack">
            <div class="d-flex align-items-center">
                <div class="symbol symbol-40px symbol-circle" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$val->first_name.' '.$val->last_name}}">
                    <span class="symbol-label bg-danger text-white fw-boldest">{{substr($val->first_name, 0, 1)}}{{substr($val->last_name, 0, 1)}}</span>
                </div>
                <div class="ps-2">
                    <p class="fs-7 text-dark text-hover-danger fw-bold mb-0"> {{$val->first_name.' '.$val->last_name}} <span class="dot"></span> {{$val->position}}</p>
                    <p class="fs-8 text-gray-800 text-hover-danger mb-0">{{$val->email}} <span class="dot"></span> {{$val->phone}} <span class="dot"></span> {{__('Ownership')}}: {{$val->ownership}}%</p>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <a data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}" href="" class="btn btn-sm rounded-pill btn-danger">{{__('Delete')}}</a>
            </div>
        </div>
        @if(!$loop->last)
        <hr class="bg-light-border">
        @endif
        <livewire:user.directors.delete :val=$val :settings=$set :wire:key="'kt_edit_'. $val->id"></livewire:user.directors.delete>
        @endforeach
    </div>
    @else
    <div class="text-center mt-20 mb-10">
        <div class="symbol symbol-150px symbol-circle mb-5">
            <div class="symbol-label fs-1 bg-danger">
                <i class="bi bi-people text-white" style="font-size:66px;"></i>
            </div>
        </div>
        <h5 class="text-dark fw-bold">{{__('No Directors')}}</h5>
    </div>
    @endif
</div>