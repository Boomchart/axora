<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\UserKyc;
use App\Models\KycDoc;
use App\Models\State;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Admin;
use App\Jobs\SendEmail;
use App\Models\Directors;
use Propaganistas\LaravelPhone\PhoneNumber;
use Livewire\WithFileUploads;

class Compliance extends Component
{
	use WithFileUploads;
	public $settings;
	public $user;
	public $stage;
	public $link = [];
	public $fields = [];
	public $files = [];
	public $kyc_fields = [];
	public $kyc_files = [];

	public $website;
	public $staff_size;
	public $volume;
	public $mcc;
	public $registration_type;
	public $incorporation_date;
	public $registration_location;
	public $upgrade_business_name;
	public $business_address;
	public $business_country;
	public $business_state;
	public $business_city;
	public $business_postal_code;
	public $business_street;
	public $states = [];
	public $staffs = [];

	public $first_name;
	public $last_name;
	public $code;
	public $phone;
	public $email;
	public $position;
	public $ownership;
	public $director_birthday;
	public $director_gender;
	public $director_country;
	public $director_state;
	public $director_city;
	public $director_postal_code;
	public $director_street;
	public $director_states = [];
	public $doc_type;
	public $doc_number;
	public $doc_front;
	public $passport;

	public $uploadedFiles;

	protected $listeners = [
		'saved' => '$refresh',
		'showWarning' => 'showWarning',
		'processApplicant' => 'processApplicant',
		'fetchDocs' => 'fetchDocs'
	];

	public function fetchDocs()
	{
		$this->uploadedFiles = UserKyc::whereUserId($this->user->id)->whereRelation('doc', 'doc', '=', 1)->get();
		$this->emit('saved');
	}

	public function updatedBusinessCountry()
	{
		if ($this->business_country) {
			$this->reset(['states']);
			if (State::whereCountryCode($this->business_country)->count()) {
				$this->states = State::whereCountryCode($this->business_country)->orderBy('name', 'asc')->get();
			} else {
				$this->reset(['states']);
			}
		}
	}

	public function updatedDirectorCountry()
	{
		if ($this->director_country) {
			$this->reset(['director_states']);
			if (State::whereCountryCode($this->director_country)->count()) {
				$this->director_states = State::whereCountryCode($this->director_country)->orderBy('name', 'asc')->get();
			} else {
				$this->reset(['director_states']);
			}
		}
	}

	public function showWarning($data)
	{
		return $this->emit('alert', $data);
	}

	public function navigateBack()
	{
		if ($this->stage == 'business_documents') {
			$this->stage = 'business_details';
			$this->link['business_details'] = true;
			$this->link['business_documents'] = false;
		} elseif ($this->stage == 'business_directors') {
			$this->stage = 'business_documents';
			$this->link['business_documents'] = true;
			$this->link['business_directors'] = false;
			$this->emit('filepond');
		}
		cache()->put('compliance_menu_' . $this->user->business_id, $this->stage);
		$this->emit('disableSpinner');
	}

	public function refreshBack()
	{
		$this->stage = 'business_details';
		$this->link[$this->stage] = true;
		foreach (array_keys($this->link) as $key) {
			$this->link[$key] = true;
			if ($key === $this->stage) {
				break;
			}
		}
	}

	public function getFieldData()
	{
		$data = [];

		if (count($this->kyc_fields)) {
			foreach ($this->kyc_fields as $index => $item) {
				$data[$index][$item->slug] = $this->user->getKyc($item->id)?->value ?? '';
			}
		}

		return $data;
	}

	public function getFilesData()
	{
		$data = [];
		if (count($this->kyc_files)) {
			foreach ($this->kyc_files as $index => $item) {
				$data[$index][$item->slug] = $this->user->getKyc($item->id)?->value ?? '';
			}
		}

		return $data;
	}

	public function updatedRegistrationType()
	{
		if ($this->registration_type) {
			$this->kyc_files = KycDoc::whereStatus(1)->whereRegId($this->registration_type)->whereDoc(1)->orderBy('title', 'asc')->get();
			$this->kyc_fields = KycDoc::whereStatus(1)->whereRegId($this->registration_type)->whereDoc(0)->orderBy('title', 'asc')->get();
			$this->fields = $this->getFieldData();
			$this->files = $this->getFilesData();
		}
	}

	public function mount()
	{
		$this->link = [
			'business_details' => false,
			'business_documents' => false,
			'business_directors' => false,
		];

		$this->staffs = [
			'1-5',
			'5-10',
			'10+'
		];

		$business = $this->user->business;

		$this->website = $business->website;
		$this->staff_size = $business->staff_size;
		$this->mcc = $business->mcc;
		$this->volume = $business->volume;
		$this->registration_type = $business->registration_type;
		$this->incorporation_date = $business->incorporation_date;
		$this->registration_location = $business->registration_location;
		$this->business_address = $business->business_address;
		$this->business_country = $business->business_country;
		$this->business_street = $business->business_street;
		$this->business_city = $business->business_city;
		$this->business_postal_code = $business->business_postal_code;
		$this->upgrade_business_name = $business->upgrade_business_name;

		if ($this->registration_type) {
			$this->kyc_files = KycDoc::whereStatus(1)->whereRegId($this->registration_type)->whereDoc(1)->orderBy('title', 'asc')->get();
			$this->kyc_fields = KycDoc::whereStatus(1)->whereRegId($this->registration_type)->whereDoc(0)->orderBy('title', 'asc')->get();
			$this->fields = $this->getFieldData();
			$this->files = $this->getFilesData();
		}

		$this->uploadedFiles = UserKyc::whereUserId($this->user->id)->whereRelation('doc', 'doc', '=', 1)->get();

		if ($this->business_country) {
			$this->updatedBusinessCountry();
			$this->business_state = $business->business_state;
		}
	}

	public function processApplicant()
	{
		$this->stage = 'business_details';
		$this->link['control_person_document'] = true;
		$this->link['business_details'] = true;
	}

	public function next()
	{
		if ($this->stage == 'business_details') {
			$business = $this->user->business;
			$rules = [
				'registration_type' => ['required'],
				'incorporation_date' => ['required', 'date_format:Y-m-d'],
				'registration_location' => ['required', 'max:255'],
				'website' => ['required', 'string'],
				'staff_size' => ['required'],
				'business_country' => 'required|string|max:255',
				'business_city' => 'required|string|max:255',
				'business_state' => 'required|string|max:255',
				'business_street' => ['required', 'max:255', 'string'],
			];

			$userkycData = [];
			foreach ($this->kyc_fields as $index => $val) {
				$required = ($val->required == 1) ? 'required' : 'nullable';
				if ($val->type == 'number') {
					$userkycData['fields.' . $index . '.' . $val->slug] = [$required, 'digits_between:' . $val->min . ',' . $val->max];
				} elseif ($val->type == 'text') {
					$userkycData['fields.' . $index . '.' . $val->slug] = [$required, 'string', 'min:' . $val->min, 'max:' . $val->max];
				} elseif ($val->type == 'select') {
					$userkycData['fields.' . $index . '.' . $val->slug] = [$required, 'string'];
				}
			}

			if (count($this->kyc_fields)) {
				$rules = array_merge($rules, $userkycData);
			}

			$this->validate($rules);

			$this->validate([
				'business_postal_code' => 'required|string|max:255',
			]);

			$business->update([
				'website' => $this->website,
				'staff_size' => $this->staff_size,
				'registration_type' => $this->registration_type,
				'incorporation_date' => $this->incorporation_date,
				'registration_location' => $this->registration_location,
				'business_country' => $this->business_country,
				'business_street' => $this->business_street,
				'business_state' => $this->business_state,
				'business_postal_code' => $this->business_postal_code,
				'business_city' => $this->business_city,
			]);

			foreach ($this->kyc_fields as $index => $val) {
				if ($this->user->getKyc($val->id) != null) {
					$this->user->getKyc($val->id)->update(['value' => $this->fields[$index][$val->slug]]);
				} else {
					UserKyc::create([
						'user_id' => $this->user->id,
						'doc_id' => $val->id,
						'value' => $this->fields[$index][$val->slug],
					]);
				}
			}

			if ($this->registration_type) {
				$this->kyc_files = KycDoc::whereStatus(1)->whereRegId($this->registration_type)->whereDoc(1)->orderBy('title', 'asc')->get();
				$this->kyc_fields = KycDoc::whereStatus(1)->whereRegId($this->registration_type)->whereDoc(0)->orderBy('title', 'asc')->get();
				$this->fields = $this->getFieldData();
				$this->files = $this->getFilesData();
			}
			$this->stage = 'business_documents';
			cache()->put('compliance_menu_' . $this->user->business_id, $this->stage);
			$this->link['business_documents'] = true;
			$this->emit('filepond');
		} elseif ($this->stage == 'business_documents') {
			$business = $this->user->business;
			foreach ($this->kyc_files as $files) {
				if (UserKyc::whereUserId($this->user->id)->whereDocId($files->id)->exists() == false) {
					return $this->emit('alert', __('Upload All required files'));
				}
			}

			$this->stage = 'business_directors';
			cache()->put('compliance_menu_' . $this->user->business_id, $this->stage);
			$this->link['business_directors'] = true;
		} elseif ($this->stage == 'business_directors') {
			$directors = Directors::whereBusinessId($this->user->business_id);

			if ($directors->count() == 0) {
				return $this->emit('alert', __('Add a director in your company'));
			}

			$this->user->business->update([
				'kyc_status' => 'PROCESSING'
			]);
			
			cache()->forget('compliance_menu_' . $this->user->business_id);
			updateLocale('admin');
			foreach (Admin::whereStatus(0)->whereProfile(1)->get() as $admin) {
				dispatch(new SendEmail(
					(($admin->role == 'super') ? $this->settings->support_email : $admin->email),
					(($admin->role == 'super') ? $this->settings->site_name : $admin->username),
					__('Compliance Review') . ', ' . $this->user->business->name,
					$this->user->business->name . __(" Just submitted a new compliance review, please review it & process applicant"),
					null,
					null,
					0
				));
			}
			updateLocale('user');
			createAudit('Submitted all details for compliance review');
			return redirect()->route('user.dashboard')->with('success', __('We will get back to you.'));
		}
	}

	public function addDirector()
	{
		try {
			$rules = [
				'email' => 'required|email:rfc,dns|max:255',
				'position' => 'required|string|max:255',
				'ownership' => 'required|numeric',
				'first_name' => 'required|string|max:255',
				'last_name' => 'required|string|max:255',
				'phone' => 'required|phone:' . $this->code,
				'director_birthday' => ['required', 'date_format:Y-m-d', 'before:today', 'before_or_equal:' . now()->subYears($this->settings->min_age)->format('Y-m-d')],
				'director_gender' => 'required',
				'director_country' => 'required|string|max:255',
				'director_city' => 'required|string|max:255',
				'director_state' => 'required|string|max:255',
				'director_street' => ['required', 'max:255', 'string'],
				'doc_type' => ['required'],
				'doc_number' => ['required', 'max:255', 'string'],
				'doc_front' => 'required|mimetypes:' . allowedFileTypes() . '|max:' . allowedFileSize(),
				'passport' => 'required|file|mimetypes:' . allowedImageTypes() . '|max:' . allowedFileSize(),
			];
			$this->validate($rules, [
				'phone.required' => __('Phone number is required'),
				'phone.phone' => __('Invalid phone number'),
			]);
			$this->validate([
				'director_postal_code' => 'required|string|max:255',
			]);

			$person = Directors::create([
				'user_id' => $this->user->business->user_id,
				'email' => $this->email,
				'position' => $this->position,
				'first_name' => ucwords(strtolower($this->first_name)),
				'last_name' => ucwords(strtolower($this->last_name)),
				'phone' => PhoneNumber::make($this->phone, strtoupper($this->code))->formatE164(),
				'business_id' => $this->user->business_id,
				'ownership' => $this->ownership,
				'gender' => $this->director_gender,
				'birthday' => $this->director_birthday,
				'country' => $this->director_country,
				'street' => $this->director_street,
				'state' => $this->director_state,
				'postal_code' => $this->director_postal_code,
				'city' => $this->director_city,
				'doc_type' => $this->doc_type,
				'doc_number' => $this->doc_number,
				'doc_front' => Cloudinary::upload($this->doc_front->getRealPath())->getSecurePath(),
				'passport' => Cloudinary::upload($this->passport->getRealPath())->getSecurePath()
			]);

			$this->emit('clearFiles');

			createAudit('Created director ' . $person->id);

			$this->reset(['director_city', 'director_postal_code', 'director_state', 'director_street', 'director_country', 'director_birthday', 'first_name', 'last_name', 'phone', 'email', 'position', 'ownership', 'director_gender', 'doc_type', 'doc_number']);
			$this->emit('saved');
			$this->emit('success', __('Director created'));
			$this->emit('drawer');
		} catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
			return $this->addError('phone', $e->getMessage());
		} catch (\Propaganistas\LaravelPhone\Exceptions\NumberFormatException $e) {
			return $this->addError('phone', $e->getMessage());
		} catch (\Propaganistas\LaravelPhone\Exceptions\InvalidParameterException $e) {
			return $this->addError('phone', $e->getMessage());
		} catch (\Propaganistas\LaravelPhone\Exceptions\CountryCodeException $e) {
			return $this->addError('phone', $e->getMessage());
		}
	}

	public function render()
	{
		return view('livewire.auth.compliance');
	}
}
