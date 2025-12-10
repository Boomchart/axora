<div>
	<div class="xcontainer-fluid" wire:init="refreshBack">
		<div class="row justify-content-center">
			<div class="col-md-4 col-lg-4 col-12">
				<div class="py-5 d-none d-md-block d-lg-block">
					<div class="p-5 mx-auto">
						<div class="text-center">
							<a href="{{ route('home') }}" class="navbar-brand pe-3">
								<img class="mb-6 text-center" src="{{asset('asset/images/dark_logo.png')}}" alt="{{ $set->site_name }}"
									loading="lazy" @style(getUi()->light_css)>
							</a>
						</div>
						<div class="timeline mt-6">
							<div class="timeline-item d-flex align-items-center">
								<div class="timeline-line w-45px"></div>
								<div class="timeline-icon symbol symbol-circle symbol-40px me-4">
									<div
										class="symbol-label okay mb-7 @if($stage == 'business_details') bg-danger text-white @else bg-white text-dark @endif">
										<i class="bi bi-bank fs-2"></i>
									</div>
								</div>
								<div class="timeline-content mt-n1">
									<div
										class="bg-white p-4 rounded-4 d-flex align-items-center justify-content-between">
										<div class="d-flex flex-column justify-content-center">
											<p class="text-dark fs-8 mb-0">{{__('Business Details')}}</p>
										</div>
										@if($link['business_details'])
										<span class="d-flex align-items-center">
											<i class="bi bi-check2-circle text-success fs-5"></i>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="timeline-item d-flex align-items-center">
								<div class="timeline-line w-45px"></div>
								<div class="timeline-icon symbol symbol-circle symbol-40px me-4">
									<div
										class="symbol-label okay mb-7 @if($stage == 'business_documents') bg-danger text-white @else bg-white text-dark @endif">
										<i class="bi bi-file-earmark-text fs-2"></i>
									</div>
								</div>
								<div class="timeline-content mt-n1">
									<div
										class="bg-white p-4 rounded-4 d-flex align-items-center justify-content-between">
										<div class="d-flex flex-column justify-content-center">
											<p class="text-dark fs-8 mb-0">{{__('Business Documents')}}</p>
										</div>
										@if($link['business_documents'])
										<span class="d-flex align-items-center">
											<i class="bi bi-check2-circle text-success fs-5"></i>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="timeline-item d-flex align-items-center">
								<div class="timeline-line w-45px"></div>
								<div class="timeline-icon symbol symbol-circle symbol-40px me-4">
									<div
										class="symbol-label okay mb-7 @if($stage == 'business_directors') bg-danger text-white @else bg-white text-dark @endif">
										<i class="bi bi-people fs-2"></i>
									</div>
								</div>
								<div class="timeline-content mt-n1">
									<div
										class="bg-white p-4 rounded-4 d-flex align-items-center justify-content-between">
										<div class="d-flex flex-column justify-content-center">
											<p class="text-dark fs-8 mb-0">{{__('Business Directors')}}</p>
										</div>
										@if($link['business_directors'])
										<span class="d-flex align-items-center">
											<i class="bi bi-check2-circle text-success fs-5"></i>
										</span>
										@endif
									</div>
								</div>
							</div>
						</div>
						<a href="{{route('user.dashboard')}}" class="btn btn-secondary btn-block mb-5 mt-10"><i class="bi bi-arrow-left"></i> {{__('Back to dashboard')}}</a>
					</div>
				</div>
			</div>
			<div class="col-md-8 col-lg-8 col-12 bg-white min-vh-100 p-10">
				<div class="d-block d-md-none d-flex justify-content-center">
					<nav class="navbar fixed-top bg-glass-dark shadow-lg px-1 rounded-4">
						<div class="d-flex w-100 justify-content-between align-items-center timeline-container px-5">
							<div class="step @if($link['business_details'])active @endif"><i class="bi bi-bank"></i>
							</div>
							<div class="step @if($link['business_documents'])active @endif"><i
									class="bi bi-file-earmark-text"></i></div>
							<div class="step @if($link['business_directors'])active @endif"><i class="bi bi-people"></i>
							</div>
						</div>
					</nav>
				</div>
				<div class="row justify-content-center mt-20 mt-md-0">
					<div class="col-md-10">
						<form class="form w-100" wire:submit.prevent="next">
							<div x-data="{stage: @entangle('stage')}">
								<div x-cloak x-show="stage === 'business_details'">
									<div class="text-start mb-15 mt-10">
										<h1 class="text-dark mb-2 fs-2">{{ __('Business Details') }}</h1>
									</div>
									@if($user->business->account_type == 'personal')
									<div class="fv-row mb-6">
										<label class="form-label text-dark fs-7 required">{{__('Legal Business Name')}}</label>
										<input type="text" wire:model="upgrade_business_name" class="form-control form-control-solid" placeholder="{{__('Eg, Flex OEM Wheels')}}">
										@error('upgrade_business_name')
										<span class="form-text text-danger">{{$message}}</span>
										@enderror
									</div>
									@endif
									<div class="fv-row mb-6">
										<label class="form-label text-dark fs-7 required">{{__('Business
                                            Website')}}</label>
										<input type="text" wire:model.debounce.1000ms="website"
											class="form-control form-control-solid"
											placeholder="{{__('Eg, https://example.com')}}">
										@error('website')
										<span class="form-text text-danger">{{$message}}</span>
										@enderror
									</div>
									<div class="fv-row mb-6">
										<label class="form-label text-dark fs-7 col-xl-12 required">{{__('Staff
                                            Size')}}</label>
										<select class="form-select form-select-solid" wire:model="staff_size">
											<option value="">{{__('Select options')}}</option>
											@foreach($staffs as $val)
											<option value="{{$val}}">{{$val}}</option>
											@endforeach
										</select>
										@error('staff_size')
										<span class="form-text text-danger">{{$message}}</span>
										@enderror
									</div>
									<div class="fv-row mb-6">
										<label class="form-label text-dark fs-7 required">{{__('Businesss Registration
                                            Type')}}</label>
										<select class="form-select form-select-solid" wire:model="registration_type">
											<option value="">{{__('Select options')}}</option>
											@foreach(businessRegType() as $val)
											<option value="{{$val->id}}">{{$val->name}}</option>
											@endforeach
										</select>
										@error('registration_type')
										<span class="form-text text-danger">{{$message}}</span>
										@enderror
									</div>
									<div class="fv-row mb-6">
										<label class="form-label text-dark fs-7 required">{{__('Incorporation
                                            Date')}}</label>
										<input type="date" wire:model.debounce.1000ms="incorporation_date"
											class="form-control form-control-solid">
										@error('incorporation_date')
										<span class="form-text text-danger">{{$message}}</span>
										@enderror
									</div>
									<div class="fv-row mb-6">
										<label class="form-label text-dark fs-7 required">{{__('Registration
                                            Location')}}</label>
										<input type="text" wire:model.debounce.1000ms="registration_location"
											class="form-control form-control-solid"
											placeholder="{{__('Eg, 123 Elm Street, Springfield, IL 62704')}}">
										@error('registration_location')
										<span class="form-text text-danger">{{$message}}</span>
										@enderror
									</div>
									@foreach($kyc_fields as $index => $item)
									@if($item->type == 'select')
									<div class="fv-row mb-6">
										<label class="form-label text-dark fs-7 required">{{$item->title}}</label>
										<select class="form-select form-select-solid" wire:model="fields.{{$index}}.{{$item->slug}}">
											<option value="">{{__('Select options')}}</option>
											@foreach(json_decode($item->select_options, true) as $value)
											<option value="{{$value}}">{{$value}}</option>
											@endforeach
										</select>
										@error('fields.'.$index.'.'.$item->slug)
										<span class="form-text text-danger">{{$message}}</span>
										@enderror
									</div>
									@endif
									@if($item->type != 'select')
									<div class="fv-row mb-6">
										<label class="form-label text-dark fs-7 @if($item->required) required @endif">{{$item->title}}</label>
										<input type="text"
											wire:model.debounce.1000ms="fields.{{$index}}.{{$item->slug}}"
											class="form-control form-control-solid"
											placeholder="{{$item->placeholder}}">
										@error('fields.'.$index.'.'.$item->slug)
										<span class="form-text text-danger">{{$message}}</span>
										@enderror
									</div>
									@endif
									@endforeach
									<hr class="bg-secondary my-5">
									<p class="mb-5 fs-7 fw-bold">{{__('Business Address Information')}}</p>
									<div class="fv-row mb-6">
										<label class="form-label text-dark fs-7 required">{{__('Country')}}</label>
										<select class="form-select form-select-solid" wire:model="business_country">
											<option value="">{{__('Select options')}}</option>
											@foreach(getAllCountry() as $value)
											<option value="{{$value->iso2}}">{{$value->name}}</option>
											@endforeach
										</select>
										@error('business_country')
										<span class="form-text text-danger">{{$message}}</span>
										@enderror
									</div>
									<div class="fv-row mb-0">
										<label class="form-label text-dark fs-7 required">{{__('State')}}</label>
										<select class="form-select form-select-solid" wire:model="business_state">
											<option value="">{{__('Select options')}}</option>
											@foreach($states as $value)
											<option value="{{$value->iso2}}">{{$value->name}}</option>
											@endforeach
										</select>
										@error('business_state')
										<span class="form-text text-danger">{{$message}}</span>
										@enderror
									</div>
									<div wire:loading wire:target="business_country" class="fs-8">{{__('Fetching
                                        State/County')}}...</div>
									<div class="fv-row mt-6 mb-6">
										<label class="form-label text-dark fs-7 required">{{__('City')}}</label>
										<input type="text" wire:model.debounce.1000ms="business_city"
											class="form-control form-control-solid" placeholder="Middlesburg">
										@error('business_city')
										<span class="form-text text-danger">{{$message}}</span>
										@enderror
									</div>
									<div class="fv-row mb-6">
										<label class="form-label text-dark fs-7 required">{{__('Street')}}</label>
										<input class="form-control form-control-solid" type="text"
											wire:model.debounce.1000ms="business_street" rows="3"
											placeholder="No.4 brooklyn street">
										@error('business_street')
										<span class="form-text text-danger">{{$message}}</span>
										@enderror
									</div>
									<div class="fv-row mb-6">
										<label class="form-label text-dark fs-7 required">{{__('Postal Code')}}</label>
										<input type="text" wire:model.debounce.1000ms="business_postal_code"
											class="form-control form-control-solid" placeholder="90000">
										@error('business_postal_code')
										<span class="form-text text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
								<div x-cloak x-show="stage === 'business_documents'">
									<div class="text-start mb-15 mt-10">
										<div class="mb-3"><a wire:click="navigateBack"
												class="text-danger cursor-pointer fs-6 navigateBack"><i
													class="bi bi-arrow-left"></i> {{__('Back')}}</a></div>
										<h1 class="text-dark mb-2 fs-2">{{ __('Business Documents') }}</h1>
									</div>
									@foreach($kyc_files as $index => $item)
									<div class="fv-row mb-6">
										<label class="form-label text-dark fs-7 @if($item->required) required @endif">{{$item->title}}</label>
										<div wire:ignore>
											<input type="file" name="{{$item->id}}" class="filepond mb-1 mt-2" data-max-file-size="50MB" data-max-files="1" allow-multiple="false" accepted-file-types="{{allowedFileTypes()}}">
										</div>
									</div>
									@endforeach
									<div class="p-5 border rounded-4 mb-10">
										<p class="fs-7 fw-bold mb-5">{{__('Files Uploaded')}}</p>
										@if(count($kyc_files))
										@forelse($uploadedFiles as $uploaded)
										<a href="{{$uploaded->value}}" target="_blank">
											<div class="p-3 text-left bg-danger rounded-4 mb-2 cursor-pointer">
												<p class="mb-0 text-white fs-7"><i
														class="bi bi-file-earmark-text text-white"></i>
													{{$uploaded?->doc?->title}}
												</p>
											</div>
										</a>
										@empty
										<div class="text-center">
											<div class="symbol symbol-100px symbol-circle mb-5">
												<div class="symbol-label fs-1 bg-danger">
													<i class="bi bi-file-earmark-text text-white"
														style="font-size:46px;"></i>
												</div>
											</div>
											<h6 class="text-dark fw-bold fs-7">{{__('No Files')}}</h6>
										</div>
										@endforelse
										@endif
									</div>
								</div>
								<div x-cloak x-show="stage === 'business_directors'">
									<div class="text-start mb-15 mt-10">
										<div class="mb-3"><a wire:click="navigateBack"
												class="text-danger cursor-pointer fs-6 navigateBack"><i
													class="bi bi-arrow-left"></i> {{__('Back')}}</a></div>
										<h1 class="text-dark mb-2 fs-2">{{ __('Business Directors') }}</h1>
									</div>
									<div class="p-5 border rounded-4 mb-10">
										<div class="row align-items-center justify-content-center mb-5">
											<div class="col-md-4">
												<h5 class="mb-0 fw-bold text-dark">{{__('Company Directors')}}</h5>
											</div>
											<div class="col-md-8 text-end">
												<a id="kt_director_button"
													class="btn btn-dark btn-sm rounded-pill">{{__('Add Director')}}</a>
											</div>
										</div>
										<p class="mb-5 text-gray-800">
											{{__('An individual with substantial responsibility for overseeing the legal
                                            entity, such as a Chief Executive Officer, Chief Financial Officer, Chief
                                            Operating Officer, Managing Member, General Partner, President, Vice
                                            President, or Treasurer.')}}
										</p>
										@livewire('user.directors.index', ['user' => $user])
									</div>
								</div>
							</div>

							@if($stage)
							<div class="text-center mt-10" wire:ignore>
								<button type="submit" class="btn btn-dark btn-block my-4" id="filepond-upload"
									wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="next">
									<span wire:loading.remove wire:target="next">{{($link['business_directors']) ?
										__('Submit for review') : __('Next') }}</span>
									<span wire:loading wire:target="next">{{ __('Processing Request...') }}</span>
								</button>
							</div>
							@endif

							@if($stage == null)
							<div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
								<span class="spinner-border spinner-border-lg"></span>
							</div>
							@endif
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div wire:ignore.self id="kt_director" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true"
		data-kt-drawer-toggle="#kt_director_button" data-kt-drawer-close="#kt_director_close"
		data-kt-drawer-width="{default:'100%', 'md': '500px'}">
		<div class="card w-100">
			<div class="card-header pe-5 border-0">
				<div class="card-title">
					<div class="d-flex justify-content-center flex-column me-3">
						<div class="fs-5 text-gray-900 text-hover-danger me-1 lh-1">{{__('Add Director')}}</div>
					</div>
				</div>
				<div class="card-toolbar">
					<div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-info" data-kt-drawer-dismiss="true"
						id="kt_director_close">
						<span class="svg-icon svg-icon-2">
							<i class="bi bi-x-lg fs-2"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="card-body text-wrap">
				<div class="pb-5 mt-10 position-relative zindex-1">
					<form class="form w-100 mb-10" wire:submit.prevent="addDirector" id="director">
						<div class="card card-flush py-4">
							<div class="card-body text-center pt-0">
								<div wire:ignore
									class="image-input image-input-circle image-input-empty image-input-outline image-input-placeholder mb-3"
									data-kt-image-input="true">
									<div class="image-input-wrapper w-150px h-150px"></div>
									<label
										class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
										data-kt-image-input-action="change" data-bs-toggle="tooltip"
										aria-label="{{__('Change avatar')}}"
										data-bs-original-title="{{__('Change avatar')}}" data-kt-initialized="1">
										<i class="bi bi-pencil-fill fs-7"></i>
										<input type="file" wire:model="passport" id="image" accept=".png, .jpg, .jpeg">
									</label>
									<span
										class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
										data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
										aria-label="{{__('Cancel avatar')}}"
										data-bs-original-title="{{__('Cancel avatar')}}" data-kt-initialized="1">
										<i class="bi bi-x fs-2"></i>
									</span>
									<span
										class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
										data-kt-image-input-action="remove" data-bs-toggle="tooltip"
										aria-label="{{__('Remove avatar')}}"
										data-bs-original-title="{{__('Remove avatar')}}" data-kt-initialized="1">
										<i class="bi bi-x fs-2"></i>
									</span>
								</div>
								<div class="text-dark fs-7">{{__('Passport. Only')}} {{allowedImageTypesDefault()}} {{__('image files are accepted')}}</div>
								<div wire:loading wire:target="passport" class="fs-7" accept="{{allowedImageTypes()}}">
									{{__('Uploading')}}...
								</div>
								@error('passport')
								<span class="form-text text-danger text-danger">{{$message}}</span>
								@enderror
							</div>
						</div>
						<div class="row fv-row mb-6">
							<div class="col-xl-6">
								<label class="form-label text-dark fs-7 required">{{__('Legal First Name')}}</label>
								<input class="form-control form-control-solid border-light" type="text"
									wire:model.defer="first_name" autocomplete="off" placeholder="John" required />
								@error('first_name')
								<span class="form-text text-danger">{{$message}}</span>
								@enderror
							</div>
							<div class="col-xl-6">
								<label class="form-label text-dark fs-7 required">{{__('Legal Last Name')}}</label>
								<input class="form-control form-control-solid border-light" type="text"
									wire:model.defer="last_name" autocomplete="off" placeholder="Doe" required />
								@error('last_name')
								<span class="form-text text-danger">{{$message}}</span>
								@enderror
							</div>
						</div>
						<div class="fv-row mb-6">
							<label class="form-label text-dark fs-7 required">{{__('Email')}}</label>
							<input class="form-control form-control-solid border-light" type="email"
								wire:model.defer="email" autocomplete="email" placeholder="name@email.com" required />
							@error('email')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<div class="fv-row mb-6">
							<label class="form-label text-dark fs-7 required">{{__('Phone')}}</label>
							<div x-data="{
                                    init() {
                                        this.initPhoneToggle('#phone');
                                    },

                                    initPhoneToggle(input) {
                                        const phoneInputField = document.querySelector(input);
                                        if (!phoneInputField) return;

                                        const phoneInput = window.intlTelInput(phoneInputField, {
                                            initialCountry: '{{ $user->getCountrySupported->iso2 }}',
                                            loadUtilsOnInit: true,
                                        });

                                        @this.set('code', '{{ $user->getCountrySupported->iso2 }}');

                                        phoneInputField.addEventListener('countrychange', function() {
                                            const countryData = phoneInput.getSelectedCountryData();
                                            if (countryData && countryData.iso2) {
                                                @this.set('code', countryData.iso2);
                                            }
                                        });
                                    }
                                }">
								<div wire:ignore>
									<input type="tel" wire:model.debounce.1000ms="phone" id="phone"
										class="form-control form-control-solid border-light"
										placeholder="XXXX-XXXX-XXXX" required>
								</div>
							</div>
							@error('phone')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<div class="fv-row mb-6">
							<label class="form-label text-dark fs-7 col-xl-12 required">{{__('Gender')}}</label>
							<select class="form-select form-select-solid" wire:model="director_gender">
								<option value="">{{__('Select options')}}</option>
								<option value="male">{{__('Male')}}</option>
								<option value="female">{{__('Female')}}</option>
							</select>
							@error('director_gender')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<div class="form-row mb-6">
							<label class="form-label text-dark fs-7 required">{{__('Date of Birth')}}</label>
							<input type="date" wire:model="director_birthday" class="form-control form-control-solid">
							@error('director_birthday')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<div class="fv-row mb-6">
							<label class="form-label text-dark fs-7 col-xl-12 required">{{__('Position')}}</label>
							<input class="form-control form-control-solid border-light" type="text"
								wire:model.defer="position"  placeholder="Company Position" required />
							@error('position')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<div class="fv-row mb-6">
							<label class="form-label text-dark fs-7 required">{{__('Ownership')}}</label>
							<div class="input-group">
								<input class="form-control form-control-solid border-light" type="number"
									wire:model.defer="ownership" placeholder="10" required />
								<div class="input-group-text">%</div>
							</div>
							@error('ownership')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<div class="fv-row mb-6">
							<label class="form-label text-dark fs-7 col-xl-12 required">{{__('ID Type')}}</label>
							<select class="form-select form-select-solid" wire:model="doc_type">
								<option value="">{{__('Select options')}}</option>
								<option value="driver_license">{{__('Driver License')}}</option>
								<option value="international_passport">{{__('International Passport')}}</option>
								<option value="national_id">{{__('National ID')}}</option>
							</select>
							@error('doc_type')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<div class="fv-row mb-6">
							<label class="form-label text-dark fs-7 required">{{__('ID Number')}}</label>
							<input class="form-control form-control-solid border-light" type="text"
								wire:model.defer="doc_number" required />
							@error('doc_number')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<div class="fv-row mb-6">
							<label class="form-label text-dark fs-7 required">{{__('Upload ID')}}</label>
							<div wire:ignore>
								<input type="file" class="form-control" wire:model="doc_front" id="doc_front"
									accept="{{allowedFileTypes()}}">
							</div>
							<p class="form-text text-gray-600">{{__('The document must show ID number and Legal Name')}}
							</p>
							@error('doc_front')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<hr class="bg-secondary my-5">
						<p class="mb-5 fs-7 fw-bold">{{__('Director Address Information')}}</p>
						<div class="fv-row mb-6">
							<label class="form-label text-dark fs-7 required">{{__('Country')}}</label>
							<select class="form-select form-select-solid" wire:model="director_country">
								<option value="">{{__('Select options')}}</option>
								@foreach(getAllCountry() as $value)
								<option value="{{$value->iso2}}">{{$value->name}}</option>
								@endforeach
							</select>
							@error('director_country')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<div class="fv-row mb-0">
							<label class="form-label text-dark fs-7 required">{{__('State')}}</label>
							<select class="form-select form-select-solid" wire:model="director_state">
								<option value="">{{__('Select options')}}</option>
								@foreach($director_states as $value)
								<option value="{{$value->iso2}}">{{$value->name}}</option>
								@endforeach
							</select>
							@error('director_state')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<div wire:loading wire:target="director_country" class="fs-8">{{__('Fetching State/County')}}...
						</div>
						<div class="fv-row mt-6 mb-6">
							<label class="form-label text-dark fs-7 required">{{__('City')}}</label>
							<input type="text" wire:model.debounce.1000ms="director_city"
								class="form-control form-control-solid" placeholder="Middlesburg">
							@error('director_city')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<div class="fv-row mb-6">
							<label class="form-label text-dark fs-7 required">{{__('Street')}}</label>
							<input class="form-control form-control-solid" type="text"
								wire:model.debounce.1000ms="director_street" rows="3"
								placeholder="No.4 brooklyn street">
							@error('director_street')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<div class="fv-row mb-6">
							<label class="form-label text-dark fs-7 required">{{__('Postal Code')}}</label>
							<input type="text" wire:model.debounce.1000ms="director_postal_code"
								class="form-control form-control-solid" placeholder="90000">
							@error('director_postal_code')
							<span class="form-text text-danger">{{$message}}</span>
							@enderror
						</div>
						<div class="text-center mt-10">
							<button type="submit" class="btn btn-dark btn-block my-2" wire:loading.attr="disabled"
								wire:loading.class="opacity-50" wire:target="addDirector" form="director">
								<span wire:loading.remove wire:target="addDirector">{{__('Create Director')}}</span>
								<span wire:loading wire:target="addDirector">{{__('Processing Request...')}}</span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@push('scripts')
<script src="{{asset('tel/js/tel.js')}}"></script>
<script>
	$(document).on('click', '.navigateBack', function() {
		showSpinner('show');
	});

	document.addEventListener('livewire:load', function() {
		window.livewire.on('filepond', data => {
			FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginFileValidateSize, FilePondPluginImageCrop);
			const inputElements = document.querySelectorAll('input.filepond');

			Array.from(inputElements).forEach(inputElement => {
				const fieldName = inputElement.getAttribute('name');

				const pond = FilePond.create(inputElement, {
					labelIdle: '<span class="filepond--label-action"> Browse </span>',
					name: fieldName, // This now matches the input name attribute
					maxFileSize: '50MB', // Add this line
					maxFiles: 1,

					server: {
						process: {
							url: "{{route('kyc.image.upload')}}",
							headers: {
								'X-CSRF-TOKEN': '{{ csrf_token() }}'
							},
							method: 'POST',
							timeout: 60000,
							ondata: (formData) => {
								formData.append('type', fieldName);
								return formData;
							},
							onerror: (response) => {
								console.log('Upload error:', response); // Add logging
								pond.setOptions({
									labelFileProcessingError: JSON.parse(response).error
								});
							}
						}
					},
					onaddfilestart(file) {
						$("#filepond-upload").attr('disabled', true);
					},
					onprocessfilestart(file) {
						$("#filepond-upload").attr('disabled', true);
					},
					onerror(error, file, status) {
						$("#filepond-upload").attr('disabled', true);
					},
					onprocessfile(error, file) {
						if (!error) {
							$("#filepond-upload").attr('disabled', false);
							Livewire.emit('fetchDocs');
							$("#filepond-upload").attr('disabled', false);
						}
					}
				});
			});
		});


		window.livewire.on('clearFiles', function() {
			document.getElementById('doc_front').value = null;
		});
	});
</script>
@endpush