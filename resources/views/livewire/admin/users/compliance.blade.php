<div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post" wire:loading.class.delay="opacity-50" wire:target="approveKYC">
        <div class="container">
            <div class="row g-6 g-xl-9">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="fs-5 mb-6 fw-bold">{{__('Flag Features on this Account')}}</div>
                            <div class="table-responsive">
                                <table class="table table-row-dashed border-gray-300 align-middle gy-4">
                                    <tbody class="fs-7 fw-semibold">
                                        <tr>
                                            <td class="min-w-250px fs-7">{{__('Watchlist (Easily keep track of this user, if user seems suspicious)')}}</td>
                                            <td class="w-125px">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" wire:click="save" wire:model="watchlist">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-250px fs-7">{{__('Agent')}}</td>
                                            <td class="w-125px">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" wire:click="save" wire:model="agent">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form w-100" wire:submit.prevent="updateIssuing">
                                <p class="fs-6 fw-bold mb-5">{{__('Gift Card Issuing Fee & Rev Share')}}</p>
                                <div class="fv-row mb-6 form-floating">
                                    <input class="form-control form-control-solid" type="text" wire:model.debounce.1000ms="issuing_fc" />
                                    <label class="form-label fs-7 text-dark fw-bold required">{{__('Flat Fee')}} ({{$currency->currency}})</label>
                                    @error('issuing_fc')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6 form-floating">
                                    <input class="form-control form-control-solid" type="text" wire:model.debounce.1000ms="issuing_pc" />
                                    <label class="form-label fs-7 text-dark fw-bold required">{{__('Percent Fee')}} (%)</label>
                                    @error('issuing_pc')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="p-5 border rounded-4 mb-10">
                                    <p class="fs-9 fw-bold mb-5 text-uppercase text-gray-700">{{__('Agent Rev Share')}}</p>
                                    @foreach($issuing_agents as $index => $item)
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <p class="fs-7 fw-bold">{{__('Item')}} {{$loop->iteration}}</p>
                                        </div>
                                        <div class="col-6 text-end">
                                            @if($index > 0)
                                            <a class="text-danger mb-0 cursor-pointer" wire:click.prevent="removeIssuingAgent({{ $index }})"><i class="bi bi-trash text-danger"></i> <u>{{__('Remove')}}</u></a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="fv-row mb-6 form-floating">
                                                <input type="text" class="form-control form-control-solid" autocomplete="off" placeholder="{{__('Enter Agent Account Id')}}" wire:model.debounce.1000ms="issuing_agents.{{$index}}.account_id">
                                                <label class="form-label text-dark fs-7 fw-bold">{{__('Account ID')}}</label>
                                                @error('issuing_agents.'.$index.'.account_id')<p class="form-text text-danger">{{$message}}</p>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-6 form-floating">
                                                <input type="text" steps="any" class="form-control form-control-solid" min="0" autocomplete="off" required wire:model.debounce.1000ms="issuing_agents.{{$index}}.rev_fc">
                                                <label class="form-label text-dark fs-7 fw-bold">{{__('Rev Fc')}} ({{$currency->currency}})</label>
                                                @error('issuing_agents.'.$index.'.rev_fc')<p class="form-text text-danger">{{$message}}</p>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-6 form-floating">
                                                <input type="text" steps="any" class="form-control form-control-solid" autocomplete="off" required wire:model.debounce.1000ms="issuing_agents.{{$index}}.rev_pc">
                                                <label class="form-label text-dark fs-7 fw-bold">{{__('Rev Pc')}} (%)</label>
                                                @error('issuing_agents.'.$index.'.rev_pc')<p class="form-text text-danger">{{$message}}</p>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="text-center">
                                        <a class="text-info fw-bold cursor-pointer" wire:click.prevent="addIssuingAgent"><i class="bi bi-plus-lg"></i> <u>{{__('Add Rev Share')}}</u></a>
                                    </div>
                                </div>
                                <div class="text-start mt-10">
                                    <button type="submit" class="btn btn-info" wire:loading.attr="disabled" wire:loading.class="opacity-50">
                                        <span wire:loading.remove wire:target="updateIssuing">{{__('Save Settings')}}</span>
                                        <span wire:loading wire:target="updateIssuing">{{__('Processing Request...')}}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-body p-9">
                            <div class="fs-5 mb-6 fw-bold">{{ __('Company Data') }}</div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{__('KYC Status')}}</div>
                                    <div class="ms-auto text-dark">{{$client->business->kyc_status}}</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{ __('Legal Name') }}</div>
                                    <div class="ms-auto text-dark">{{ $client->first_name.' '.$client->last_name }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{ __('Business Name') }}</div>
                                    <div class="ms-auto text-dark">{{ $client->business->name }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{ __('Staff Size') }}</div>
                                    <div class="ms-auto text-dark">{{ $client->business->staff_size }}</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{ __('Business Monthly Limits') }}</div>
                                    <div class="ms-auto text-dark">{{ $client?->business->business_monthly_limits}}</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{ __('MCC') }}</div>
                                    <div class="ms-auto text-dark">{{ $client->business->getMcc?->name }}</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{ __('Registration Type') }}</div>
                                    <div class="ms-auto text-dark">{{ $client?->business->getRegType?->name }}</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{ __('Incorporation Date') }}</div>
                                    <div class="ms-auto text-dark">
                                        {{ ucwords($client->business->incorporation_date) }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{ __('Registration Location') }}</div>
                                    <div class="ms-auto text-dark">
                                        {{ ucwords($client->business->registration_location) }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{ __('Business Address') }}</div>
                                    <div class="ms-auto text-dark">
                                        {{ $client->business->business_street . ', ' . $client->business->business_state . ', ' . $client->business->business_city . ', ' . $client->business->business_postal_code . ', ' . $client->business->business_country }}
                                    </div>
                                </div>
                            </div>
                            @if ($client?->business->directors->count())
                            <div class="fs-5 mb-6 fw-bold mt-6">{{ __('Directors') }}</div>
                            @foreach ($client->business->directors as $val)
                            <div class="bg-secondary rounded-4 p-4 mb-3">
                                <p class="fs-7 fw-bold mb-0 text-dark">{{ __('Name') }}:
                                    {{ $val->first_name . ' ' . $val->last_name }}
                                </p>
                                <p class="fs-8 mb-0 text-dark">{{ __('Position') }}: {{ $val->position }}</p>
                                <p class="fs-8 mb-0 text-dark">{{ __('Email') }}: {{ $val->email }}</p>
                                <p class="fs-8 mb-0 text-dark">{{ __('Phone') }}: {{ $val->phone }}</p>
                                <p class="fs-8 mb-0 text-dark">{{ __('Ownership') }}: {{ $val->ownership }}%
                                </p>
                                <p class="fs-8 mb-0 text-dark">{{ __('Gender') }}: {{ $val->gender }}</p>
                                <p class="fs-8 mb-0 text-dark">{{ __('Birthday') }}: {{ $val->birthday }}</p>
                                <p class="fs-8 mb-0 text-dark">{{ __('Address') }}:
                                    {{ $val->street . ', ' . $val->state . ', ' . $val->city . ', ' . $val->postal_code . ', ' . $val->country }}
                                </p>
                                <p class="fs-8 mb-0 text-dark">{{ __('ID Type') }}: {{ $val->doc_type }}</p>
                                <p class="fs-8 mb-0 text-dark">{{ __('ID Number') }}: {{ $val->doc_number }}
                                </p>
                                <p class="fs-8 mb-0 text-dark">{{ __('Passport') }}: <a
                                        href="{{ $val->passport }}" target="_blank">{{ $val->passport }}</a>
                                </p>
                                <p class="fs-8 mb-0 text-dark">{{ __('ID URL') }}: <a
                                        href="{{ $val->doc_front }}"
                                        target="_blank">{{ $val->doc_front }}</a></p>
                            </div>
                            <hr class="bg-secondary">
                            @if (!$loop->last)
                            <hr class="bg-light-border">
                            @endif
                            @endforeach
                            @endif
                            <div class="fs-5 mb-6 fw-bold mt-6">{{ __('KYC Doc Data') }}</div>
                            @foreach ($client->kycs as $kyc)
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{ $kyc?->doc?->title }} @if ($kyc->doc->deleted_at != null)
                                        <span
                                            class="badge badge-danger badge-sm">{{ __('Deleted Doc Type') }}</span>
                                        @endif
                                    </div>
                                    @if ($kyc?->doc?->doc)
                                    <div class="ms-auto text-dark"> <a href="{{ $kyc->value }}"
                                            target="_blank">{{ $kyc->value }}</a></div>
                                    @else
                                    <div class="ms-auto text-dark"> {{ $kyc->value }}</div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @if ($client->business->kyc_status == 'PROCESSING')
                            <div class="mt-10">
                                <button class="btn btn-sm btn-success rounded-pill mb-3 me-5" wire:click="approveKYC" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="approveUpgrade"> <span wire:loading.remove wire:target="approveUpgrade"><i class="bi bi-check"></i> {{ __('Approve Business Account') }}</span> <span wire:loading wire:target="approveUpgrade">{{ __('Processing Request...') }}</span></button>
                                <button class='btn btn-sm btn-danger rounded-pill mb-3' data-bs-toggle="modal" data-bs-target="#decline-upgrade"> <i class="bi bi-ban"></i> {{ __('Resubmit Compliance') }} </button>
                            </div>
                            @elseif($client->business->kyc_status == 'APPROVED')
                            <button class='btn btn-sm btn-danger rounded-pill mb-3' data-bs-toggle="modal" data-bs-target="#decline-upgrade"> <i class="bi bi-ban"></i> {{ __('Resubmit Compliance') }} </button>
                            @endif
                            <div wire:ignore.self class="modal fade" id="decline-upgrade" tabindex="-1"
                                role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">{{ __('Decline') }}</h3>
                                            <div class="btn btn-icon btn-sm btn-active-light-info ms-2"
                                                data-bs-dismiss="modal" aria-label="Close">
                                                <span class="svg-icon svg-icon-1">
                                                    <i class="bi bi-x-lg fs-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <form wire:submit.prevent="declineKYC">
                                                <div class="form-group mb-6">
                                                    <textarea type="text" wire:model.defer="reason" class="form-control form-control-solid" rows="5"
                                                        placeholder="{{ __('Provide Reason') }}" required></textarea>
                                                    @error('reason')
                                                    <span class="form-text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-danger btn-block my-2"
                                                        wire:loading.attr="disabled" wire:loading.class="opacity-50"
                                                        wire:target="declineKYC">
                                                        <span wire:loading.remove
                                                            wire:target="declineKYC">{{ __('Submit') }}</span>
                                                        <span wire:loading
                                                            wire:target="declineKYC">{{ __('Processing Request...') }}</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-dark fw-bold mb-0 fs-5">{{__('Block Account')}}</p>
                            <p class="text-gray-800 mb-5 fs-7">{{__('User won\'t be able to log in or use any platform apis')}}</p>
                            @if($client->status==0)
                            <a wire:click="block" class="btn btn-sm btn-danger rounded-pill"><i class="bi bi-ban"></i> {{__('Block Account')}}</a>
                            @else
                            <a wire:click="unblock" class="btn btn-sm btn-info rounded-pill"><i class="bi bi-check2-circle"></i> {{__('Unblock Account')}}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-dark fw-bold mb-0 fs-5">{{__('Change Password')}}</p>
                            <p class="text-gray-800 mb-5 fs-7">{{__('Reset account password')}}</p>
                            <button id="kt_password_button" class="btn btn-sm btn-info rounded-pill"><i class="bi bi-lock"></i> {{__('Reset')}}</button>
                            <div wire:ignore.self id="kt_password" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_password_button" data-kt-drawer-close="#kt_password_close" data-kt-drawer-width="{default:'100%', 'md': '500px'}">
                                <div class="card w-100">
                                    <div class="card-header pe-5 border-0">
                                        <div class="card-title">
                                            <div class="d-flex justify-content-center flex-column me-3">
                                                <div class="fs-4 text-gray-900 text-hover-info me-1 lh-1">{{__('Change Password')}}</div>
                                            </div>
                                        </div>
                                        <div class="card-toolbar">
                                            <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-info" data-kt-drawer-dismiss="true" id="kt_password_close">
                                                <span class="svg-icon svg-icon-2">
                                                    <i class="bi bi-x-lg fs-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-wrap">
                                        <div class="text-center mb-3">
                                            <div class="symbol symbol-100px symbol-circle mb-10">
                                                <div class="symbol-label fs-1 bg-info text-white">
                                                    <i class="bi bi-lock fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pb-5 mt-10 position-relative zindex-1">
                                            <form class="form w-100 mb-10" wire:submit.prevent="editPassword">
                                                <div class="fv-row mb-6">
                                                    <label class="form-label fs-7 text-dark">{{__('New Password')}}</label>
                                                    <input class="form-control form-control-solid" type="password" wire:model.defer="new_password" required placeholder="{{__('Password')}}" />
                                                    @error('new_password')
                                                    <span class="form-text text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="fv-row mb-6">
                                                    <label class="form-label fs-7 text-dark">{{__('Super Admin Password')}}</label>
                                                    <input class="form-control form-control-solid" type="password" wire:model.defer="password" required placeholder="{{__('Password')}}" />
                                                    @error('password')
                                                    <span class="form-text text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="text-center mt-10">
                                                    <button type="submit" class="btn btn-info btn-block my-2" wire:loading.attr="disabled" wire:loading.class="opacity-50">
                                                        <span wire:loading.remove wire:target="editPassword">{{__('Submit Request')}}</span>
                                                        <span wire:loading wire:target="editPassword">{{__('Processing Request...')}}</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-dark fw-bold mb-0 fs-5">{{__('Ban Account')}}</p>
                            <p class="text-gray-800 mb-5 fs-7">{{__('User won\'t be able to create account or login anymore with their current phone number, ip address or emails')}}</p>
                            @if($client->ban == 0)
                            <a wire:click="ban" class="btn btn-sm btn-danger rounded-pill"><i class="bi bi-ban"></i> {{__('Ban Account')}}</a>
                            @else
                            <a wire:click="unban" class="btn btn-sm btn-info rounded-pill"><i class="bi bi-check2-circle"></i> {{__('Unban Account')}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>