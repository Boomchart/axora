<div>
    <div wire:ignore.self id="kt_staff_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_staff_{{$val->id}}_button" data-kt-drawer-close="#kt_staff_{{$val->id}}_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Edit Staff')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_staff__{{$val->id}}_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="btn-wrapper text-center mb-3">
                    <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                        <div class="symbol-label fs-1 text-dark">
                            <i class="bi bi-people text-dark" style="font-size:44px;"></i>
                        </div>
                    </div>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="update">
                        <label class="form-label text-dark fs-7">{{__('Full name')}}</label>
                        <div class="row fv-row mb-6">
                            <div class="col-xl-6">
                                <input class="form-control form-control-solid" type="text" wire:model="val.first_name" autocomplete="off" required placeholder="{{__('First Name')}}" />
                                @error('val.first_name')
                                <span class="form-text">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-xl-6">
                                <input class="form-control form-control-solid" type="text" wire:model="val.last_name" autocomplete="off" required placeholder="{{__('Last Name')}}" />
                                @error('val.last_name')
                                <span class="form-text">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Username')}}</label>
                            <input class="form-control form-control-solid" type="text" wire:model="val.username" required placeholder="{{__('Username')}}" />
                            @error('val.username')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Notification Email Address')}}</label>
                            <input class="form-control form-control-solid" type="email" wire:model.debounce.1000ms="val.email" required placeholder="{{__('Email Address')}}" />
                            @error('val.email')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6" wire:ignore>
                            <label class="form-label text-dark fs-7">{{__('Timezone')}}</label>
                            <select class="form-select form-select-solid" id="timezone{{$val->id}}" data-control="select2" data-placeholder="{{__('Select Timezone')}}" wire:model="val.timezone">
                                @foreach(config('timezones') as $key => $value)
                                <option value="{{$key}}">{{$key}} - {{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="form-label text-dark fs-7">{{__('Permissions')}}</label>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model="val.profile" id="customCheckLogin1" class="custom-control-input">
                                    <label class="custom-control-label" for="customCheckLogin1">
                                        <span class="text-muted">{{__('Customer')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model="val.support" id="customCheckLogin2" class="custom-control-input">
                                    <label class="custom-control-label" for="customCheckLogin2">
                                        <span class="text-muted">{{__('Ticket')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model="val.promo" id="customCheckLogin3" class="custom-control-input">
                                    <label class="custom-control-label" for="customCheckLogin3">
                                        <span class="text-muted">{{__('Promotion')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model="val.message" id="customCheckLogin4" class="custom-control-input">
                                    <label class="custom-control-label" for="customCheckLogin4">
                                        <span class="text-muted">{{__('Message')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="val.deposit" id="deposit" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="deposit">
                                        <span class="text-muted">{{__('Deposit')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="val.payout" id="payout" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="payout">
                                        <span class="text-muted">{{__('Payout')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model="val.email_configuration" id="customCheckLogin14" class="custom-control-input">
                                    <label class="custom-control-label" for="customCheckLogin14">
                                        <span class="text-muted">{{__('Email Template')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model="val.general_settings" id="customCheckLogin15" class="custom-control-input">
                                    <label class="custom-control-label" for="customCheckLogin15">
                                        <span class="text-muted">{{__('General Settings')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model="val.giftcard" id="giftcard" class="custom-control-input">
                                    <label class="custom-control-label" for="giftcard">
                                        <span class="text-muted">{{__('Giftcard')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="val.decline_compliance" id="decline_compliance" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="decline_compliance">
                                        <span class="text-muted">{{__('Decline compliance')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="val.approve_compliance" id="approve_compliance" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="approve_compliance">
                                        <span class="text-muted">{{__('Approve compliance')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="val.unblock_user" id="unblock_user" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="unblock_user">
                                        <span class="text-muted">{{__('Unblock user')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="val.block_user" id="block_user" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="block_user">
                                        <span class="text-muted">{{__('Block user')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="val.unban_user" id="unban_user" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="unban_user">
                                        <span class="text-muted">{{__('Unban user')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="val.ban_user" id="ban_user" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="ban_user">
                                        <span class="text-muted">{{__('Ban user')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="val.rev_share" id="rev_share" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="rev_share">
                                        <span class="text-muted">{{__('Rev share')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="val.edit_password" id="edit_password" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="edit_password">
                                        <span class="text-muted">{{__('Edit password')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="val.edit_balance" id="edit_balance" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="edit_balance">
                                        <span class="text-muted">{{__('Edit balance')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="val.api_error" id="api_error" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="api_error">
                                        <span class="text-muted">{{__('Receive API Error')}}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" wire:click.prevent="update" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="update">{{__('Update Staff')}}</span>
                                <span wire:loading wire:target="update">{{__('Processing Request...')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Delete Staff')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <button wire:click="delete" class="btn btn-danger btn-block" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="delete">{{__('Delete')}}</span>
                            <span wire:loading wire:target="delete">{{__('Processing Request...')}}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        $('#timezone{{$val->id}}').on('change', function(e) {
            @this.set('val.timezone', $(this).val());
        });
    });
</script>
@endpush