<div>
    @foreach($template as $val)
    <div class="d-flex flex-stack cursor-pointer" id="kt_edit_{{$val->id}}_button">
        <div class="d-flex align-items-center">
            <div class="symbol symbol-45px symbol-circle me-4">
                <div class="symbol-label fs-2 fw-bolder text-dark bg-warning">
                    <i class="bi bi-file-richtext text-dark" style='font-size:20px;'></i>
                </div>
            </div>
            <div class="ps-1">
                <p href="#" class="fs-7 text-dark mb-0">{{ucwords(str_replace('_', ' ', $val->type))}}</p>
                <p href="#" class="fs-7 text-dark mb-0">{{__('Allowed Tags')}}: @foreach(explode(',', $val->tags) as $tags) <span class="badge badge-dark badge-sm">{{$tags}}</span> @endforeach</p>
                <p href="#" class="fs-7 text-dark">{{__('Updated at')}}: {{$val->updated_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</p>
            </div>
        </div>
        <button class="btn btn-whitelabel text-dark rounded-pill btn-sm px-5"><i class="bi bi-pen"></i> {{__('Edit')}}</button>
    </div>
    @if(!$loop->last)
    <hr class="bg-light-border">
    @endif
    <div><livewire:admin.template.edit :val=$val :wire:key="'kt_edit_'. $val->id"></livewire:admin.template.edit></div>
    @endforeach
</div>