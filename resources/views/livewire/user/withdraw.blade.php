<div>
    <div wire:ignore.self id="kt_withdraw_money" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_withdraw_money_button" data-kt-drawer-close="#kt_withdraw_money_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Withdraw')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_withdraw_money_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="btn-wrapper text-center mb-3">
                    <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                        <div class="symbol-label fs-1 bg-secondary">
                            <i class="bi bi-bank fa-2x text-dark" style="font-size:46px;"></i>
                        </div>
                    </div>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="payout(Object.fromEntries(new FormData($event.target)))" method="post">
                        @error('added')
                        <div class="alert alert-danger">
                            <div class="d-flex flex-column">
                                <span>{{$message}}</span>
                            </div>
                        </div>
                        @enderror
                        <div class="d-flex justify-content-between">
                            <label class="form-label text-dark fs-7 required">{{__('Amount')}} ({{$currency->currency}})</label>
                            <a wire:click="max" class="cursor-pointer text-success"><u>{{__('Max Amount')}}</u></a>
                        </div>
                        <div class="fv-row mb-6">
                            <input class="form-control form-control-solid" type="text" step="any" wire:model.denounce.500ms="amount" autocomplete="one-time-code" required placeholder="{{__('0.00')}}" />
                            @error('amount')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div id="other">
                            <div class="fv-row mb-6 form-floating">
                                <label class="form-label text-dark fs-7 required">{{__('Withdrawal options')}}</label>
                                <select class="form-select form-select-solid" wire:model="other" id="changeMethod">
                                    <option value="">{{__('Select options')}}</option>
                                    @foreach(getOtherPayout() as $other)
                                    <option value="{{$other->id}}">{{$other->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="fv-row mb-6">
                                <textarea class="form-control form-control-solid" type="text" wire:model.defer="requirements" placeholder="{{$placeholder}}" rows="3"></textarea>
                            </div>
                        </div>
                        @error('requirements')
                        <span class="text-danger">{{$message}}</span>
                        @enderror

                        <div class="fv-row mb-6 text-start">
                            <label class="form-label text-dark fs-7 required">{{__('2FA Code')}}</label>
                            <input class="form-control form-control-solid" type="tel" minlength="4" maxlength="6" pattern="[0-9]+" wire:model.defer="otp" placeholder="{{__('Enter OTP')}}" required />
                            @error('otp')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="bg-light-primary px-6 py-5 mb-10 rounded-4">
                            <p class="text-dark fs-7 mb-0"><b>{{__('Balance after transaction')}}</b>: {{$balanceAfter}}</p>
                            <p class="text-dark fs-7 mb-0"><b>{{__('Fee')}}</b>: {{$fee}}</p>
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="payout">{{__('Submit Request')}}</span>
                                <span wire:loading wire:target="payout">{{__('Processing Request...')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    window.livewire.on('newTime', data => {
        countDownDate = moment(data).valueOf();
        var x = setInterval(function() {
            var now = moment.utc().valueOf();
            var distance = countDownDate - now + (1 * 60 * 60 * 1000);
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
            var seconds = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');
            document.getElementById("timer").innerHTML = minutes + ":" + seconds;
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("timer").innerHTML = "0:00";
            }
        }, 1);
    });
</script>
@endpush