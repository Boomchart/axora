<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2">{{__('Crypto Currency')}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-5">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-info">{{__('Dashboard')}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="kt_currency" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_currency_button" data-kt-drawer-close="#kt_currency_close" data-kt-drawer-width="{default:'100%', 'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-info me-1 lh-1">{{__('Create a Crypto')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-primary" data-kt-drawer-dismiss="true" id="kt_currency_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg text-dark"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="addCurrency">
                        <div class="card card-flush py-4">
                            <div class="card-body text-center pt-0">
                                <div wire:ignore class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="{{__('Change avatar')}}" data-bs-original-title="{{__('Change avatar')}}" data-kt-initialized="1">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <input type="file" wire:model="image" id="image" accept="{{allowedImageTypes()}}" required>
                                        <input type="hidden" name="avatar_remove">
                                    </label>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="{{__('Cancel avatar')}}" data-bs-original-title="{{__('Cancel avatar')}}" data-kt-initialized="1">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="{{__('Remove avatar')}}" data-bs-original-title="{{__('Remove avatar')}}" data-kt-initialized="1">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                </div>
                                <div class="text-muted fs-7">{{__('Set the thumbnail image. Only')}} {{allowedImageTypesDefault()}} {{__('image files are accepted')}}</div>
                                <div wire:loading wire:target="image" class="fs-7">{{__('Uploading')}}...</div>
                                @error('image')
                                <span class="form-text text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Network & Token')}}</label>
                            <div wire:ignore>
                                <select class="form-select form-select-solid" id="currency" data-control="select2" data-placeholder="{{__('Select Currency')}}" wire:model="currency">
                                    <option value="">{{__('Select Currency')}}</option>
                                    @foreach($this->cryptos() as $index => $cval)
                                    <option value="{{$index}}">{{$cval['network']}} - {{$cval['token']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('currency')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-check form-check-custom form-check-solid mb-6">
                            <input class="form-check-input" type="checkbox" id="active" wire:model="active" />
                            <label class="form-check-label" for="active">{{__('Activate currency after creation')}}</label>
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" class="btn btn-primary btn-block my-2" wire:loading.attr="disabled" wire:target="addCurrency,image">
                                <span wire:loading.remove wire:target="addCurrency">{{__('Submit Request')}}</span>
                                <span wire:loading wire:target="addCurrency">{{__('Processing Request...')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8 mb-6">
                <div class="col-md-8">
                    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                        <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                            <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white" wire:model="search" placeholder="{{__('Search Crypto Currency')}}" />
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button id="kt_currency_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> {{__('New Currency')}}</button>
                </div>
            </div>
            @if($data->count() > 0 )
            @foreach($data as $currency)
            <div class="p-4">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50px symbol-circle me-4">
                                <span class="symbol-label" style="background-image:url({{getPublicImage($currency->image)}});"></span>
                            </div>
                            <div class="ps-1">
                                <p class="fs-5 text-dark mb-0">{{$currency->name}} ({{$currency->token}}) <span class="dot"></span> {{$currency->network}}</p>
                                <p class="fs-3 text-dark mb-0 fw-bold">
                                    {{$currency->balance_amount}} {{$currency->token}}
                                    <span class="dot"></span>
                                    @if($currency->status==1)
                                    <span class="badge badge-pill badge-success mb-2">{{__('Status: Active')}}</span>
                                    @elseif($currency->status==0)
                                    <span class="badge badge-pill badge-danger mb-2">{{__('Status: Disabled')}}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-2 text-start">
                        <livewire:admin.crypto.edit :val=$currency :type="'settings'" :wire:key="$currency->id"></livewire:admin.crypto.edit>
                    </div>
                </div>
            </div>
            @if(!$loop->last)
            <hr class="bg-light-border my-0">
            @endif
            @endforeach
            @else
            <div class="text-center mt-20">
                <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                    <div class="symbol-label fs-1 axora-dashboard-icon">
                        <i class="bi bi-coin" style="font-size:66px;"></i>
                    </div>
                </div>
                <h3 class="text-dark">{{__('No Currency Found')}}</h3>
                <p class="text-dark">{{__('We couldn\'t find any Currency')}}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        $('#currency').on('change', function(e) {
            @this.set('currency', $(this).val());
        });

        window.livewire.on('resetForm', data => {
            $('#currency').val(null).trigger('change');
        });
    });
</script>
@endpush