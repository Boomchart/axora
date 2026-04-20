<div>
	<div class="axora-kyc-layout" wire:init="refreshBack" wire:key="business-compliance-layout">
		<aside class="axora-kyc-sidebar d-none d-md-flex">
			<div class="axora-kyc-sidebar-inner">
				<div class="axora-kyc-brand">
					<a href="{{ route('home') }}">
						<img src="{{ asset('asset/images/dark_logo.png') }}" alt="{{ $set->site_name }}" loading="lazy" class="axora-kyc-logo" @style(getUi()->light_css)>
					</a>
					<p>{{ __('Complete your business verification to unlock full platform access.') }}</p>
				</div>

				<div class="axora-kyc-steps">
					<div class="axora-kyc-step {{ $stage == 'business_details' ? 'active' : '' }} {{ $link['business_details'] ? 'completed' : '' }}">
						<div class="axora-kyc-step-icon"><i class="bi bi-bank"></i></div>
						<div class="axora-kyc-step-content">
							<h6>{{ __('Business Details') }}</h6>
							<p>{{ __('Company profile and address') }}</p>
						</div>
						@if($link['business_details']) <i class="bi bi-check-circle-fill axora-kyc-step-check"></i> @endif
					</div>

					<div class="axora-kyc-step {{ $stage == 'business_documents' ? 'active' : '' }} {{ $link['business_documents'] ? 'completed' : '' }}">
						<div class="axora-kyc-step-icon"><i class="bi bi-file-earmark-text"></i></div>
						<div class="axora-kyc-step-content">
							<h6>{{ __('Business Documents') }}</h6>
							<p>{{ __('Upload required documents') }}</p>
						</div>
						@if($link['business_documents']) <i class="bi bi-check-circle-fill axora-kyc-step-check"></i> @endif
					</div>

					<div class="axora-kyc-step {{ $stage == 'business_directors' ? 'active' : '' }} {{ $link['business_directors'] ? 'completed' : '' }}">
						<div class="axora-kyc-step-icon"><i class="bi bi-people"></i></div>
						<div class="axora-kyc-step-content">
							<h6>{{ __('Business Directors') }}</h6>
							<p>{{ __('Add ownership details') }}</p>
						</div>
						@if($link['business_directors']) <i class="bi bi-check-circle-fill axora-kyc-step-check"></i> @endif
					</div>
				</div>

				<a href="{{ route('user.dashboard') }}" class="axora-kyc-back-btn">
					<i class="bi bi-arrow-left"></i>
					{{ __('Back to dashboard') }}
				</a>
			</div>
		</aside>

		<main class="axora-kyc-main">
			<div class="axora-kyc-mobile-steps d-md-none">
				<div class="axora-kyc-mobile-step {{ $link['business_details'] ? 'active' : '' }}"><i class="bi bi-bank"></i></div>
				<div class="axora-kyc-mobile-step {{ $link['business_documents'] ? 'active' : '' }}"><i class="bi bi-file-earmark-text"></i></div>
				<div class="axora-kyc-mobile-step {{ $link['business_directors'] ? 'active' : '' }}"><i class="bi bi-people"></i></div>
			</div>

			<div class="axora-kyc-content">
				<form class="form w-100" wire:submit.prevent="next">
					<div x-data="{stage: @entangle('stage')}">

						<div x-cloak x-show="stage === 'business_details'" class="axora-kyc-panel">
							<div class="axora-kyc-header">
								<span class="axora-kyc-badge"><i class="bi bi-bank"></i>{{ __('Business Verification') }}</span>
								<h1>{{ __('Business Details') }}</h1>
								<p>{{ __('Provide your company profile, registration details, and business address information.') }}</p>
							</div>

							@if($user->business->account_type == 'personal')
								<div class="form-group">
									<label class="form-label required">{{ __('Legal Business Name') }}</label>
									<input type="text" wire:model="upgrade_business_name" class="form-control" placeholder="{{ __('Eg, Flex OEM Wheels') }}">
									@error('upgrade_business_name') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
								</div>
							@endif

							<div class="form-group">
								<label class="form-label required">{{ __('Business Website') }}</label>
								<input type="text" wire:model.debounce.1000ms="website" class="form-control" placeholder="{{ __('Eg, https://example.com') }}">
								@error('website') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label required">{{ __('Staff Size') }}</label>
										<select class="form-select" wire:model="staff_size">
											<option value="">{{ __('Select options') }}</option>
											@foreach($staffs as $val)
												<option value="{{ $val }}">{{ $val }}</option>
											@endforeach
										</select>
										@error('staff_size') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label required">{{ __('Business Registration Type') }}</label>
										<select class="form-select" wire:model="registration_type">
											<option value="">{{ __('Select options') }}</option>
											@foreach(businessRegType() as $val)
												<option value="{{ $val->id }}">{{ $val->name }}</option>
											@endforeach
										</select>
										@error('registration_type') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="form-label required">{{ __('Incorporation Date') }}</label>
								<input type="date" wire:model.debounce.1000ms="incorporation_date" class="form-control">
								@error('incorporation_date') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
							</div>

							<div class="form-group">
								<label class="form-label required">{{ __('Registration Location') }}</label>
								<input type="text" wire:model.debounce.1000ms="registration_location" class="form-control" placeholder="{{ __('Eg, 123 Elm Street, Springfield, IL 62704') }}">
								@error('registration_location') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
							</div>

							@foreach($kyc_fields as $index => $item)
								@if($item->type == 'select')
									<div class="form-group">
										<label class="form-label required">{{ $item->title }}</label>
										<select class="form-select" wire:model="fields.{{ $index }}.{{ $item->slug }}">
											<option value="">{{ __('Select options') }}</option>
											@foreach(json_decode($item->select_options, true) as $value)
												<option value="{{ $value }}">{{ $value }}</option>
											@endforeach
										</select>
										@error('fields.'.$index.'.'.$item->slug) <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
									</div>
								@else
									<div class="form-group">
										<label class="form-label @if($item->required) required @endif">{{ $item->title }}</label>
										<input type="text" wire:model.debounce.1000ms="fields.{{ $index }}.{{ $item->slug }}" class="form-control" placeholder="{{ $item->placeholder }}">
										@error('fields.'.$index.'.'.$item->slug) <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
									</div>
								@endif
							@endforeach

							<div class="axora-kyc-section-title">
								<i class="bi bi-geo-alt"></i>
								{{ __('Business Address Information') }}
							</div>

							<div class="form-group">
								<label class="form-label required">{{ __('Country') }}</label>
								<select class="form-select" wire:model="business_country">
									<option value="">{{ __('Select options') }}</option>
									@foreach(getAllCountry() as $value)
										<option value="{{ $value->iso2 }}">{{ $value->name }}</option>
									@endforeach
								</select>
								@error('business_country') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
							</div>

							<div class="form-group">
								<label class="form-label required">{{ __('State') }}</label>
								<select class="form-select" wire:model="business_state">
									<option value="">{{ __('Select options') }}</option>
									@foreach($states as $value)
										<option value="{{ $value->iso2 }}">{{ $value->name }}</option>
									@endforeach
								</select>
								@error('business_state') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
								<div wire:loading wire:target="business_country" class="axora-kyc-loading">{{ __('Fetching State/County') }}...</div>
							</div>

							<div class="form-group">
								<label class="form-label required">{{ __('City') }}</label>
								<input type="text" wire:model.debounce.1000ms="business_city" class="form-control" placeholder="Middlesburg">
								@error('business_city') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
							</div>

							<div class="form-group">
								<label class="form-label required">{{ __('Street') }}</label>
								<input type="text" wire:model.debounce.1000ms="business_street" class="form-control" placeholder="No.4 brooklyn street">
								@error('business_street') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
							</div>

							<div class="form-group">
								<label class="form-label required">{{ __('Postal Code') }}</label>
								<input type="text" wire:model.debounce.1000ms="business_postal_code" class="form-control" placeholder="90000">
								@error('business_postal_code') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
							</div>
						</div>

						<div x-cloak x-show="stage === 'business_documents'" class="axora-kyc-panel">
							<div class="axora-kyc-header">
								<button type="button" wire:click="navigateBack" class="axora-kyc-back-link navigateBack"><i class="bi bi-arrow-left"></i>{{ __('Back') }}</button>
								<span class="axora-kyc-badge"><i class="bi bi-file-earmark-text"></i>{{ __('Document Upload') }}</span>
								<h1>{{ __('Business Documents') }}</h1>
								<p>{{ __('Upload the required documents so we can complete your business review.') }}</p>
							</div>

							@foreach($kyc_files as $index => $item)
								<div class="form-group">
									<label class="form-label @if($item->required) required @endif">{{ $item->title }}</label>
									<div wire:ignore>
										<input type="file" name="{{ $item->id }}" class="filepond mb-1 mt-2" data-max-file-size="50MB" data-max-files="1" allow-multiple="false" accepted-file-types="{{ allowedFileTypes() }}">
									</div>
								</div>
							@endforeach

							<div class="axora-uploaded-files">
								<div class="axora-kyc-section-title mb-3">
									<i class="bi bi-cloud-check"></i>
									{{ __('Files Uploaded') }}
								</div>

								@if(count($kyc_files))
									@forelse($uploadedFiles as $uploaded)
										<a href="{{ $uploaded->value }}" target="_blank" class="axora-uploaded-file">
											<i class="bi bi-file-earmark-text"></i>
											<span>{{ $uploaded?->doc?->title }}</span>
										</a>
									@empty
										<div class="axora-kyc-empty">
											<div class="axora-kyc-empty-icon"><i class="bi bi-file-earmark-text"></i></div>
											<h6>{{ __('No Files') }}</h6>
											<p>{{ __('Uploaded documents will appear here.') }}</p>
										</div>
									@endforelse
								@endif
							</div>
						</div>

						<div x-cloak x-show="stage === 'business_directors'" class="axora-kyc-panel">
							<div class="axora-kyc-header">
								<button type="button" wire:click="navigateBack" class="axora-kyc-back-link navigateBack"><i class="bi bi-arrow-left"></i>{{ __('Back') }}</button>
								<span class="axora-kyc-badge"><i class="bi bi-people"></i>{{ __('Ownership Review') }}</span>
								<h1>{{ __('Business Directors') }}</h1>
								<p>{{ __('Add directors, owners, or control persons with substantial responsibility for the business.') }}</p>
							</div>

							<div class="axora-director-summary">
								<div>
									<h5>{{ __('Company Directors') }}</h5>
									<p>{{ __('An individual with substantial responsibility for overseeing the legal entity, such as CEO, CFO, COO, Managing Member, General Partner, President, Vice President, or Treasurer.') }}</p>
								</div>

								<button type="button" id="kt_director_button" class="btn btn-primary">
									<i class="bi bi-plus-lg me-1"></i>
									{{ __('Add Director') }}
								</button>
							</div>

							@livewire('user.directors.index', ['user' => $user])
						</div>
					</div>

					@if($stage)
						<div class="axora-kyc-actions" wire:ignore>
							<button type="submit" class="btn btn-primary w-100" id="filepond-upload" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="next">
								<span wire:loading.remove wire:target="next">{{ ($link['business_directors']) ? __('Submit for review') : __('Next') }}</span>
								<span wire:loading wire:target="next">{{ __('Processing Request...') }}</span>
							</button>
						</div>
					@endif

					@if($stage == null)
						<div class="axora-kyc-loading-state">
							<span class="spinner-border spinner-border-lg"></span>
						</div>
					@endif
				</form>
			</div>
		</main>
	</div>

	<div wire:ignore.self id="kt_director" class="axora-director-drawer" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_director_button" data-kt-drawer-close="#kt_director_close" data-kt-drawer-width="{default:'100%', 'md': '520px'}">
		<div class="axora-director-drawer-card">
			<div class="axora-director-drawer-header">
				<div>
					<span>{{ __('Director Information') }}</span>
					<h4>{{ __('Add Director') }}</h4>
				</div>

				<button type="button" class="axora-director-close" data-kt-drawer-dismiss="true" id="kt_director_close">
					<i class="bi bi-x-lg"></i>
				</button>
			</div>

			<div class="axora-director-drawer-body">
				<form class="form w-100" wire:submit.prevent="addDirector" id="director">
					<div class="axora-director-photo-card">
						<div wire:ignore class="image-input image-input-circle image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
							<div class="image-input-wrapper w-150px h-150px"></div>
							<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="{{ __('Change avatar') }}" data-bs-original-title="{{ __('Change avatar') }}" data-kt-initialized="1">
								<i class="bi bi-pencil-fill fs-7"></i>
								<input type="file" wire:model="passport" id="image" accept=".png, .jpg, .jpeg">
							</label>
							<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="{{ __('Cancel avatar') }}" data-bs-original-title="{{ __('Cancel avatar') }}" data-kt-initialized="1"><i class="bi bi-x fs-2"></i></span>
							<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="{{ __('Remove avatar') }}" data-bs-original-title="{{ __('Remove avatar') }}" data-kt-initialized="1"><i class="bi bi-x fs-2"></i></span>
						</div>

						<p>{{ __('Passport. Only') }} {{ allowedImageTypesDefault() }} {{ __('image files are accepted') }}</p>
						<div wire:loading wire:target="passport" class="axora-kyc-loading" accept="{{ allowedImageTypes() }}">{{ __('Uploading') }}...</div>
						@error('passport') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="row">
						<div class="col-xl-6">
							<div class="form-group">
								<label class="form-label required">{{ __('Legal First Name') }}</label>
								<input class="form-control" type="text" wire:model.defer="first_name" autocomplete="off" placeholder="John" required>
								@error('first_name') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
							</div>
						</div>

						<div class="col-xl-6">
							<div class="form-group">
								<label class="form-label required">{{ __('Legal Last Name') }}</label>
								<input class="form-control" type="text" wire:model.defer="last_name" autocomplete="off" placeholder="Doe" required>
								@error('last_name') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('Email') }}</label>
						<input class="form-control" type="email" wire:model.defer="email" autocomplete="email" placeholder="name@email.com" required>
						@error('email') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('Phone') }}</label>
						<div x-data="{ init() { this.initPhoneToggle('#phone'); }, initPhoneToggle(input) { const phoneInputField = document.querySelector(input); if (!phoneInputField) return; const phoneInput = window.intlTelInput(phoneInputField, { initialCountry: '{{ $user->getCountrySupported->iso2 }}', loadUtilsOnInit: true }); @this.set('code', '{{ $user->getCountrySupported->iso2 }}'); phoneInputField.addEventListener('countrychange', function() { const countryData = phoneInput.getSelectedCountryData(); if (countryData && countryData.iso2) { @this.set('code', countryData.iso2); } }); } }">
							<div wire:ignore>
								<input type="tel" wire:model.debounce.1000ms="phone" id="phone" class="form-control" placeholder="XXXX-XXXX-XXXX" required>
							</div>
						</div>
						@error('phone') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('Gender') }}</label>
						<select class="form-select" wire:model="director_gender">
							<option value="">{{ __('Select options') }}</option>
							<option value="male">{{ __('Male') }}</option>
							<option value="female">{{ __('Female') }}</option>
						</select>
						@error('director_gender') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('Date of Birth') }}</label>
						<input type="date" wire:model="director_birthday" class="form-control">
						@error('director_birthday') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('Position') }}</label>
						<input class="form-control" type="text" wire:model.defer="position" placeholder="Company Position" required>
						@error('position') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('Ownership') }}</label>
						<div class="input-group">
							<input class="form-control" type="number" wire:model.defer="ownership" placeholder="10" required>
							<div class="input-group-text">%</div>
						</div>
						@error('ownership') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('ID Type') }}</label>
						<select class="form-select" wire:model="doc_type">
							<option value="">{{ __('Select options') }}</option>
							<option value="driver_license">{{ __('Driver License') }}</option>
							<option value="international_passport">{{ __('International Passport') }}</option>
							<option value="national_id">{{ __('National ID') }}</option>
						</select>
						@error('doc_type') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('ID Number') }}</label>
						<input class="form-control" type="text" wire:model.defer="doc_number" required>
						@error('doc_number') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('Upload ID') }}</label>
						<div wire:ignore>
							<input type="file" class="form-control" wire:model="doc_front" id="doc_front" accept="{{ allowedFileTypes() }}">
						</div>
						<p class="form-text">{{ __('The document must show ID number and Legal Name') }}</p>
						@error('doc_front') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="axora-kyc-section-title">
						<i class="bi bi-geo-alt"></i>
						{{ __('Director Address Information') }}
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('Country') }}</label>
						<select class="form-select" wire:model="director_country">
							<option value="">{{ __('Select options') }}</option>
							@foreach(getAllCountry() as $value)
								<option value="{{ $value->iso2 }}">{{ $value->name }}</option>
							@endforeach
						</select>
						@error('director_country') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('State') }}</label>
						<select class="form-select" wire:model="director_state">
							<option value="">{{ __('Select options') }}</option>
							@foreach($director_states as $value)
								<option value="{{ $value->iso2 }}">{{ $value->name }}</option>
							@endforeach
						</select>
						@error('director_state') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
						<div wire:loading wire:target="director_country" class="axora-kyc-loading">{{ __('Fetching State/County') }}...</div>
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('City') }}</label>
						<input type="text" wire:model.debounce.1000ms="director_city" class="form-control" placeholder="Middlesburg">
						@error('director_city') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('Street') }}</label>
						<input class="form-control" type="text" wire:model.debounce.1000ms="director_street" placeholder="No.4 brooklyn street">
						@error('director_street') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="form-group">
						<label class="form-label required">{{ __('Postal Code') }}</label>
						<input type="text" wire:model.debounce.1000ms="director_postal_code" class="form-control" placeholder="90000">
						@error('director_postal_code') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
					</div>

					<div class="axora-kyc-actions">
						<button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="addDirector" form="director">
							<span wire:loading.remove wire:target="addDirector">{{ __('Create Director') }}</span>
							<span wire:loading wire:target="addDirector">{{ __('Processing Request...') }}</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@push('scripts')
	<script src="{{ asset('tel/js/tel.js') }}"></script>
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
						name: fieldName,
						maxFileSize: '50MB',
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
									console.log('Upload error:', response);
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