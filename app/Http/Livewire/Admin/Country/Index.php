<?php

namespace App\Http\Livewire\Admin\Country;

use Livewire\Component;
use App\Models\CountryReg;
use App\Models\Country as Region;

class Index extends Component
{

    private $countries;
    private $allCountries;
    public $search;
    public $category;
    public $perPage = 100;
    public $orderBy = "name";
    public $sortBy = "asc";
    public $admin;
    public $country;
    public $settings;

    protected $listeners = ['saved' => '$refresh'];

    public function getAll()
    {
        $regions = Region::all();
        $existingCountryIds = CountryReg::pluck('country_id')->toArray();
        return $regions->whereNotIn('id', $existingCountryIds)->values();
    }

    public function mount()
    {
        $this->allCountries = $this->getAll();
    }

    public function addCountry()
    {

        $this->validate([
            'country' => ['required'],
        ]);

        $country = Region::whereId($this->country)->first();

        if (CountryReg::whereCountryId($this->country)->withTrashed()->exists()) {
            $check = CountryReg::whereCountryId($this->country)->withTrashed();
            if ($check->first()->deleted_at != null) {
                $check->restore();
                $this->emit('saved');
                $this->emit('drawer');
                $this->emit('resetForm');
                return $this->emit('success', __('Country Restored from trash'));
            }
        }

        if (CountryReg::whereCountryId($this->country)->exists()) {
            return $this->emit('alert', __('Country already added'));
        }
        CountryReg::create([
            'country_id' =>  $this->country,
            'iso2' =>  $country->iso2,
            'iso3' =>  $country->iso3,
            'name' =>  $country->name,
            'phone_code' =>  $country->phonecode,
            'currency' =>  $country->currency,
            'currency_symbol' =>  $country->currency_symbol,
        ]);
        $this->allCountries = $this->getAll();
        $this->reset(['country']);
        $this->emit('saved');
        $this->emit('drawer');
        $this->emit('success', __('Country Created'));
    }

    public function render()
    {
        $this->countries = CountryReg::with(['real'])->withCount(['giftcards', 'airtimeProviders', 'dataProviders'])->when($this->search, function ($query) {
            $this->emit('drawer');
            return $query->Where('name', 'like', '%' . $this->search . '%');
        })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            }) 
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);
        $this->allCountries = $this->getAll();
        return view('livewire.admin.country.index', ['allCountries' => $this->allCountries, 'countries' => $this->countries]);
    }
}
