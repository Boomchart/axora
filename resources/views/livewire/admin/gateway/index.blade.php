<div>
    <div wire:ignore.self id="kt_addmethod" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_addmethod_button" data-kt-drawer-close="#kt_addmethod_close" data-kt-drawer-width="{'md': '900px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1">{{__('Add a Gateway')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_article_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="addMethod" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <!--begin::Thumbnail settings-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card body-->
                                    <div class="card-body text-center pt-0">
                                        <!--begin::Image input-->
                                        <!--begin::Image input placeholder-->

                                        <!--end::Image input placeholder-->

                                        <div wire:ignore class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-150px h-150px"></div>
                                            <!--end::Preview existing avatar-->

                                            <!--begin::Label-->
                                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="{{__('Change avatar')}}" data-bs-original-title="{{__('Change avatar')}}" data-kt-initialized="1">
                                                <i class="bi bi-pencil-fill fs-7"></i>

                                                <!--begin::Inputs-->
                                                <input type="file" wire:model="image" id="image" accept=".png, .jpg, .jpeg, .svg" required>
                                                <input type="hidden" name="avatar_remove">
                                                <!--end::Inputs-->
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Cancel-->
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="{{__('Cancel avatar')}}" data-bs-original-title="{{__('Cancel avatar')}}" data-kt-initialized="1">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Cancel-->

                                            <!--begin::Remove-->
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="{{__('Remove avatar')}}" data-bs-original-title="{{__('Remove avatar')}}" data-kt-initialized="1">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->

                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">{{__('Set the thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted')}}</div>
                                        <div wire:loading wire:target="image" class="fs-7">{{__('Uploading')}}...</div>
                                        @error('image')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Gateway Name')}}</label>
                                    <input class="form-control form-control-solid" type="text" wire:model.defer="name" required placeholder="{{__('Name')}}" />
                                    @error('name')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Minimum')}}</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0">{{$currency->currency_symbol}}</span>
                                        <input type="number" wire:model.defer="min" step="any" class="form-control form-control-solid" required placeholder="0.00">
                                    </div>
                                    @error('min')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Maximum')}}</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0">{{$currency->currency_symbol}}</span>
                                        <input type="number" wire:model.defer="max" step="any" class="form-control form-control-solid" required placeholder="0.00">
                                    </div>
                                    @error('max')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <label class="form-label text-dark fs-7">{{__('Deposit Fee')}}</label>
                                <div class="fv-row mb-6 row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="number" step="any" wire:model.defer="pc" placeholder="{{__('Percent charge')}}" autocomplete="off" class="form-control form-control-solid">
                                            <span class="input-group-text border-0">%</span>
                                        </div>
                                        @error('pc')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text border-0">{{$currency->currency_symbol}}</span>
                                            <input type="number" step="any" wire:model.defer="fc" placeholder="{{__('Fiat charge')}}" autocomplete="off" class="form-control form-control-solid">
                                        </div>
                                        @error('fc')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Deposit Instructions')}}</label>
                                    <textarea class="form-control form-control-solid" type="text" wire:model.defer="instructions" rows="5" required placeholder="{{__('Deposit Instructions')}}"></textarea>
                                    @error('instructions')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Payment Details')}}</label>
                                    <textarea class="form-control form-control-solid" type="text" wire:model.defer="details" rows="5" required placeholder="{{__('Payment Details')}}"></textarea>
                                    @error('details')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Require Receipt')}}</label>
                                    <select class="form-select form-select-solid" wire:model.defer="receipt" required>
                                        <option value="1">{{__('Yes')}}</option>
                                        <option value="0">{{__('No')}}</option>
                                    </select>
                                    @error('receipt')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Status')}}</label>
                                    <select class="form-select form-select-solid" wire:model.defer="status" required>
                                        <option value="1">{{__('Active')}}</option>
                                        <option value="0">{{__('Disabled')}}</option>
                                    </select>
                                    @error('status')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Crypto')}}</label>
                                    <select class="form-select form-select-solid" wire:model="crypto" required>
                                        <option value="1">{{__('Yes')}}</option>
                                        <option value="0">{{__('No')}}</option>
                                    </select>
                                    @error('crypto')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                @if($showCrypto == 1)
                                <div class="fv-row mb-6">
                                    <input class="form-control form-control-solid" id="walletAddress" type="text" wire:model.defer="wallet_address" placeholder="{{__('Wallet Address')}}" @if($showCrypto==1) required @endif />
                                    @error('wallet_address')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                @endif
                                <div class="text-center mt-10">
                                    <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="addMethod">{{__('Submit Method')}}</span>
                                        <span wire:loading wire:target="addMethod">{{__('Processing Request...')}}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr class="bg-secondary">
    <h3 class="mb-6 mt-10 fw-bold fs-5">{{__('Manual Gateways')}}</h3>
    <div class="row g-xl-8">
        <div class="col-md-8">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white" wire:model="search" placeholder="{{__('Search Methods')}}" />
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <button id="kt_addmethod_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> {{__('Add Method')}}</button>
        </div>
    </div>
    @if($manual->count() > 0)
    <div class="table-responsive">
        <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search">
            <thead>
                <tr class="fw-semibold fs-7">
                    <th class="min-w-100px">{{__('Name')}}</th>
                    <th class="min-w-50px">{{__('Limit')}}</th>
                    <th class="min-w-50px">{{__('Charge')}}</th>
                    <th class="min-w-50px">{{__('Status')}}</th>
                    <th class="min-w-100px">{{__('Updated')}}</th>
                    <th class="scope"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($manual as $val)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-40px">
                                <span class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$val->image}});"></span>
                            </div>
                            <div class="ms-5">
                                {{$val->name}}
                            </div>
                        </div>
                    </td>
                    <td>{{$currency->currency_symbol.$val->minamo.' - '.$currency->currency_symbol.number_format($val->maxamo)}}</td>
                    <td>@if($val->percent_charge!=null){{$val->percent_charge}}% @else 0% @endif + @if($val->fiat_charge!=null){{$val->fiat_charge.' '.$currency->currency}} @else 0 {{$currency->currency}} @endif</td>
                    <td>
                        @if($val->status==0)
                        <span class="badge badge-danger badge-pill">{{__('Disabled')}}</span>
                        @elseif($val->status==1)
                        <span class="badge badge-success badge-pill">{{__('Active')}}</span>
                        @endif
                    </td>
                    <td>{{$val->updated_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</td>
                    <td class="text-center">
                        <button id="kt_edit_{{$val->id}}_button" class="btn btn-sm btn-whitelabel rounded-pill">{{__('Edit')}}</button>
                        <a data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}" href="" class="btn btn-sm btn-danger rounded-pill">{{__('Delete')}}</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    @foreach($manual as $val)
    <div>
        <livewire:admin.gateway.edit :val=$val :wire:key="'kt_edit_'. $val->id"></livewire:admin.gateway.edit>
    </div>
    @endforeach
</div>

@push('scripts')
<script>
    function pct() {
        var pct = $("#pct").find(":selected").val();
        var myarr = pct;
        if (myarr == "both") {
            $("#fiat_pc").attr({
                required: true,
                readonly: false,
                placeholder: 'Fiat charge'
            });
            $("#percent_pc").attr({
                required: true,
                readonly: false,
                placeholder: 'Percent charge'
            });
        } else if (myarr == "fiat") {
            $("#fiat_pc").attr({
                required: true,
                readonly: false,
                placeholder: 'Fiat charge'
            });
            $("#percent_pc").attr({
                required: false,
                readonly: true,
                placeholder: 'Percent charge'
            });
        } else if (myarr == "percent") {
            $("#fiat_pc").attr({
                required: false,
                readonly: true,
                placeholder: 'Fiat charge'
            });
            $("#percent_pc").attr({
                required: true,
                readonly: false,
                placeholder: 'Percent charge'
            });
        } else if (myarr == "none") {
            $("#fiat_pc").attr({
                required: false,
                readonly: true,
                placeholder: 'Fiat charge'
            });
            $("#percent_pc").attr({
                required: false,
                readonly: true,
                placeholder: 'Percent charge'
            });
        } else {
            $("#fiat_pc").attr({
                required: true,
                readonly: false,
                placeholder: 'Amount'
            });
            $("#percent_pc").attr({
                required: false,
                readonly: true
            });
        }
    }
    $("#pct").change(pct);
    pct();
</script>
@endpush