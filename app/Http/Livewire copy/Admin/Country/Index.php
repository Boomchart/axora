<?php

namespace App\Http\Livewire\Admin\Country;

use Livewire\Component;
use App\Models\CountryReg;
use App\Models\Country;

class Index extends Component
{

    private $countries;
    private $allCurrency;
    public $search = "";
    public $category = "";
    public $perPage = 100;
    public $orderBy = "name";
    public $sortBy = "asc";
    public $admin;
    public $country;
    public $settings;

    protected $listeners = ['saved' => '$refresh'];

    public function getAll()
    {
        // Get all country IDs that exist in CountryReg (single query)
        $registeredCountryIds = CountryReg::pluck('country_id')->toArray();

        // Fetch all countries and filter them in memory
        return Country::whereNotIn('id', $registeredCountryIds)->get();
    }

    public function mount()
    {
        $this->allCurrency = $this->getAll();
    }

    public function addCountry()
    {
        $this->validate([
            'country' => ['required'],
        ]);

        $country = Country::whereId($this->country)->first();
        CountryReg::create([
            'country_id' =>  $this->country,
            'iso2' =>  $country->iso2,
            'name' =>  $country->name,
        ]);
        $this->allCurrency = $this->getAll();
        $this->reset(['country']);
        $this->emit('saved');
        $this->emit('drawer');
        $this->emit('success', __('Country Created'));
    }

    public function disable(CountryReg $currency)
    {
        $currency->update(['status' => 0]);
        $this->emit('success', __('Country disabled'));
        $this->emitUp('saved');
    }

    public function enable(CountryReg $currency)
    {
        $currency->update(['status' => 1]);
        $this->emit('success', __('Country enabled'));
        $this->emitUp('saved');
    }

    public function render()
    {
        $this->countries = CountryReg::with(['real'])->when($this->search, function ($query) {
            $this->emit('drawer');
            return $query->Where('name', 'like', '%' . $this->search . '%');
        })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);
        $this->allCurrency = $this->getAll();
        return view('livewire.admin.country.index', ['allCurrency' => $this->allCurrency, 'countries' => $this->countries]);
    }
}
