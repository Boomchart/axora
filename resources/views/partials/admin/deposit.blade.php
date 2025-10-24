    <div class="card mb-10">
        <div class="card-body">
            <h4 class="fw-bold fs-5 mb-6">{{__('Bank Deposit')}}</h4>
            <form action="{{route('admin.settings.update', ['type' => 'bank_deposit'])}}" method="post">
                @csrf
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Bank name')}}</label>
                    <input class="form-control form-control-solid" type="text" name="dp_bank_name" value="{{$set->dp_bank_name}}" required />
                    @error('dp_bank_name')
                    <span class="form-text">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Routing Code')}}</label>
                    <input class="form-control form-control-solid" type="text" name="bk_routing_code" value="{{$set->bk_routing_code}}" required />
                    @error('bk_routing_code')
                    <span class="form-text">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Routing Type')}}</label>
                    <input class="form-control form-control-solid" type="text" name="bk_routing_type" value="{{$set->bk_routing_type}}" required />
                    @error('bk_routing_type')
                    <span class="form-text">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Account Number')}}</label>
                    <input class="form-control form-control-solid" type="text" name="bk_acct_no" value="{{$set->bk_acct_no}}" required />
                    @error('bk_acct_no')
                    <span class="form-text">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Account Name')}}</label>
                    <input class="form-control form-control-solid" type="text" name="bk_acct_name" value="{{$set->bk_acct_name}}" required />
                    @error('bk_acct_name')
                    <span class="form-text">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group mb-6">
                    <label class="form-label text-dark fs-7">{{__('Payout charge type')}}</label>
                    <select class="form-select form-select-solid" name="deposit_pct" id="pct" required>
                        <option value="both" @if($set->deposit_pct=="both") selected @endif>{{__('Percentage & Fiat')}}</option>
                        <option value="percent" @if($set->deposit_pct=="percent") selected @endif>{{__('Percentage')}}</option>
                        <option value="fiat" @if($set->deposit_pct=="fiat") selected @endif>{{__('Fiat')}}</option>
                        <option value="none" @if($set->deposit_pct=="none") selected @endif>{{__('No fees')}}</option>
                        <option value="min" @if($set->deposit_pct=="min") selected @endif>{{__('Below')}}</option>
                        <option value="max" @if($set->deposit_pct=="max") selected @endif>{{__('Above')}}</option>
                    </select>
                    @error('deposit_pct')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-6">
                            <div class="input-group">
                                <input type="number" step="any" name="deposit_percent_pc" id="percent_pc" readonly placeholder="{{__('percent charge')}}" value="{{$set->deposit_percent_pc}}" autocomplete="off" class="form-control form-control-solid">
                                <span class="input-group-text border-0">%</span>
                            </div>
                            @error('deposit_percent_pc')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-6">
                            <div class="input-group">
                                <span class="input-group-text border-0">{{$currency->currency_symbol}}</span>
                                <input type="number" step="any" name="deposit_fiat_pc" id="fiat_pc" placeholder="{{__('fiat charge')}}" value="{{$set->deposit_fiat_pc}}" autocomplete="off" class="form-control form-control-solid">
                                <span class="input-group-text border-0">{{$currency->currency}}</span>
                            </div>
                            @error('deposit_fiat_pc')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-check form-check-custom form-check-solid mb-6">
                    <input class="form-check-input" type="checkbox" id="bk_status" name="bk_status" value="1" @if($set->bk_status==1)checked @endif />
                    <label class="form-check-label" for="bk_status">{{__('Bank Deposit')}}</label>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2">{{__('Update')}}</a>
                </div>
            </form>
        </div>
    </div>
    @livewire('admin.gateway.index', ['admin' => $admin, 'currency' => $currency])