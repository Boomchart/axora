<div>
    <div wire:ignore.self class="modal fade" id="resetpassword" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h3 class="modal-title">{{__('Reset Password')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="resetPassword" method="post" class="mb-10">
                        @csrf
                        <div class="fv-row mb-6 form-floating">
                            <input type="password" wire:model="password" class="form-control form-control-solid" required>
                            <label class="form-label text-dark fs-7 mb-0" for="password">{{__('Current password')}}</label>
                            @error('password')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6 form-floating">
                            <input type="password" wire:model="new_password" id="new_password" class="form-control form-control-solid" required>
                            <label class="form-label text-dark fs-7 mb-0" for="new_password">{{__('New password')}}</label>
                            @error('new_password')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6 form-floating">
                            <input type="password" wire:model="confirm_password" id="confirm_password" class="form-control form-control-solid" required>
                            <label class="form-label text-dark fs-7 mb-0" for="confirm_password">{{__('Confirm password')}}</label>
                            @error('confirm_password')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-block" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="resetPassword">{{__('Change Password')}}</span>
                                <span wire:loading wire:target="resetPassword">{{__('Processing Request...')}}</span>
                            </button>
                        </div>
                    </form>
                    <div class="axora-dashboard-icon px-6 py-5 mb-10 rounded-5">
                        <h4 class="mb-0 text-dark fw-bold">{{__('Password requirements')}}</h4>
                        <p class="mb-2 text-gray-800 fs-7">{{__('Ensure that these requirements are met')}}</p>
                        <ul class="text-gray-800 fs-8">
                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-success bullet-vertical"></span>{{__('Minimum 8 characters long - the more, the better')}}</li>
                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-success bullet-vertical"></span>{{__('At least one lowercase character')}}</li>
                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-success bullet-vertical"></span>{{__('At least one uppercase character')}}</li>
                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-success bullet-vertical"></span>{{__('At least one number')}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>