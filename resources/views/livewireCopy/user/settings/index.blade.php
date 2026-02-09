<div>
    @if($type == 'profile')
    <div class="card mb-10">
        <div class="card-body">
            <form wire:submit.prevent="profile">
                @csrf
                <div class="row fv-row">
                    <div class="col-xl-6 mb-6">
                        <label class="form-label text-dark fs-7">{{__('First Name')}}</label>
                        <input class="form-control form-control-solid" type="text" name="first_name" autocomplete="off" value="{{$user->first_name}}" required readonly />
                        @error('first_name')
                        <span class="form-text">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-xl-6 mb-6">
                        <label class="form-label text-dark fs-7">{{__('Last Name')}}</label>
                        <input class="form-control form-control-solid" type="text" name="last_name" autocomplete="off" value="{{$user->last_name}}" required readonly />
                        @error('last_name')
                        <span class="form-text">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Email')}}</label>
                    <input class="form-control form-control-solid" type="email" name="email" autocomplete="email" value="{{$user->email}}" required readonly />
                    @error('email')
                    <span class="form-text">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Phone')}}</label>
                    <input class="form-control form-control-solid" type="tel" name="phone" autocomplete="phone" value="{{$user->phone}}" required placeholder="123456789" readonly />
                    @error('phone')
                    <span class="form-text">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6" wire:ignore>
                    <label class="form-label text-dark fs-7">{{__('Timezone')}}</label>
                    <select class="form-select form-select-solid" id="timezone" data-control="select2" data-placeholder="{{__('Select Timezone')}}" wire:model="timezone">
                        @foreach(timezone_identifiers_list() as $val)
                        <option value="{{$val}}">{{$val}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="profile">{{__('Update Account')}}</span>
                        <span wire:loading wire:target="profile">{{__('Processing Request...')}}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
    @if($type == 'api')
    <a href="{{route('developer.index')}}" target="_blank">
        <div class="card bg-secondary mb-5">
            <div class="d-flex align-items-center p-3">
                <div class="symbol symbol-40px me-4">
                    <div class="symbol-label fs-7 text-dark bg-white rounded-5">
                        <i class="bi bi-braces text-dark"></i>
                    </div>
                </div>
                <div class="ps-1">
                    <p class="fs-7 text-dark text-hover-success fw-bold mb-0">{{__('API Documentation')}}</p>
                </div>
            </div>
        </div>
    </a>
    <div class="card mb-10">
        <div class="card-body">
            <form wire:submit.prevent="webhookUpdate" method="post">
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Live Key')}} <span class="badge badge-success badge-pill ms-2 cursor-pointer castro-copy" data-clipboard-text="{{$api_key}}" title="{{__('Copy')}}">{{__('Copy')}}</span></label>
                    <div class="input-group">
                        <input class="form-control form-control-solid border-right-0" type="{{($hide_live == 1) ? 'password' : 'text'}}" wire:model="api_key" readonly />
                        <span class="input-group-text" wire:click="liveStatus">
                            @if($hide_live == 1)
                            <i class="bi bi-eye text-dark castro-copy fw-bold fs-5"></i>
                            @else
                            <i class="bi bi-eye-slash text-dark castro-copy fw-bold fs-5"></i>
                            @endif
                        </span>
                    </div>
                    @error('api_key')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Test Key')}} <span class="badge badge-success badge-pill ms-2 cursor-pointer castro-copy" data-clipboard-text="{{$test_api_key}}" title="{{__('Copy')}}">{{__('Copy')}}</span></label>
                    <div class="input-group">
                        <input class="form-control form-control-solid border-right-0" type="text" wire:model="test_api_key" readonly />
                    </div>
                    @error('test_api_key')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('IP V4 Whitelisted')}}</label>
                    <div wire:ignore>
                        <input class="form-control form-control-solid" wire:model.debounce.1000ms="ip_whitelisting" id="ip_whitelisting" placeholder="{{__('Allowed IP addresses, seperate each ip address with a comma.')}}">
                    </div>
                    @error('ip_whitelisting')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('IP V6 Whitelisted')}}</label>
                    <div wire:ignore>
                        <input class="form-control form-control-solid" wire:model.debounce.1000ms="ipv6_whitelisting" id="ipv6_whitelisting" placeholder="{{__('Allowed IP addresses, seperate each ip address with a comma.')}}">
                    </div>
                    @error('ipv6_whitelisting')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Webhook URL')}}</label>
                    <input class="form-control form-control-solid" type="url" wire:model="webhook_url" autocomplete="off" placeholder="{{__('https://webhook.site')}}" />
                    @error('webhook_url')
                    <span class="form-text">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Webhook Secret')}} <span wire:click="generateWebhookSecret" class="badge badge-dark cursor-pointer">{{__('Generate Webhook Secret')}}</span></label>
                    <input class="form-control form-control-solid" type="text" wire:model.debounce.1000ms="webhook_secret" autocomplete="off" placeholder="{{__('Secret Hash')}}" />
                    <span class="form-text text-dark">{{__('Required to verify webhook signature')}}</span>
                    @error('webhook_secret')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2" wire:loading.attr="disabled" wire:target="webhookUpdate">
                        <span wire:loading.remove wire:target="webhookUpdate">{{__('Update')}}</span>
                        <span wire:loading wire:target="webhookUpdate">{{__('Processing Request...')}}</span>
                    </button>
                    <a wire:click="generate" class="btn rounded-pill btn-light-success me-3 my-2" wire:loading.attr="disabled" wire:target="generate">
                        <span wire:loading.remove wire:target="generate">{{__('Generate New API Keys')}}</span>
                        <span wire:loading wire:target="generate">{{__('Processing Request...')}}</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@push('scripts')
@if($type == 'profile')
<script>
    document.addEventListener('livewire:load', function() {
        $('#timezone').on('change', function(e) {
            @this.set('timezone', $(this).val());
        });
    });
</script>
@else
<script>
    document.addEventListener('livewire:load', function() {
        var ipFilter = document.querySelector("#ip_whitelisting");
        var ipFilterV6 = document.querySelector("#ipv6_whitelisting");
        var tagifyIpFilter = new Tagify(ipFilter);
        var tagifyIpFilterV6 = new Tagify(ipFilterV6);

        ipFilter.addEventListener('change', function(e) {
            @this.set('ip_whitelisting', e.target.value);
        });

        ipFilterV6.addEventListener('change', function(e) {
            @this.set('ipv6_whitelisting', e.target.value);
        });
    });
</script>
@endif
@endpush