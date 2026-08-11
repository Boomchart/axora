<?php

namespace App\Http\Livewire\Admin\Country;

use Livewire\Component;
use App\Models\{DataProvider as TRX, Category};
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Services\Reloadly\ReloadlyAirtimeService;

class DataProvider extends Component
{
    use WithFileUploads;

    private $card;
    public $country;
    public $search;
    public $perPage = 100;
    public $orderBy = "title";
    public $sortBy = "asc";
    public $admin;
    public $settings;
    public $status;
    public $title;
    public $description;
    public $terms;
    public $redemption_instructions;
    public $image;
    public $whatsapp_image;
    public $min;
    public $max;
    public $denominations;
    public $fixed_denominations = false;
    public $fixed_min = false;
    public $fixed_max = false;
    public $margin = 1;
    public $discount;
    public $category;
    public $currency;
    public $cardcurrency;
    private $getCategory;
    public $issuing_fc = 0;
    public $issuing_pc = 0;
    public $issuing_ft = 'both';
    public $issuing_range;
    public $fc_required;
    public $pc_required;
    public $items = [];
    public $features = [];
    public $duration = 365;
    public $delivery_method;
    public $provider;
    public $vendor_id;
    public $only_denominations = 0;
    public $exportEmail;
    public $products = [];
    public $product;
    public $rate;
    public $charge_phase;
    public $tier_pricing;
    public $issuing_tiers;

    protected $listeners = ['saved' => '$refresh', 'updateValue' => 'updateValue'];


    public function updatedIssuingFt()
    {
        $this->fc_required = (in_array($this->issuing_ft, ['both', 'fiat', 'max', 'min'])) ? 1 : 0;
        $this->pc_required = (in_array($this->issuing_ft, ['both', 'percent', 'max', 'min'])) ? 1 : 0;
    }

    public function updatedProvider()
    {
        $this->reset(['product', 'products']);
        if ($this->provider == 'reloadly') {
            $reloadly = new ReloadlyAirtimeService();
            $products = $reloadly->productsByCountry($this->country->iso2);

            if ($products['success'] == true) {
                $this->products = collect($products['data'])->where('bundle', false)->where('data', true)->filter(fn($data) => (!empty($data['localFixedAmounts']) && !empty($data['localFixedAmountsDescriptions'])))->where('status', 'ACTIVE')->where('senderCurrencyCode', 'USD')->where('destinationCurrencyCode', $this->country->currency)->map(function ($data) {
                    return [
                        'id' => $data['id'],
                        'title' => $data['name'],
                        'discount' => $data['internationalDiscount'],
                        'only_denominations' => $data['denominationType'] == 'RANGE' ? false : true,
                        'min' =>  round(min($data['localFixedAmounts'])),
                        'max' =>  round(max($data['localFixedAmounts'])),
                        'denominations' =>  $data['denominationType'] == 'RANGE' ? [] : $data['localFixedAmounts'],
                        'issuing_pc' => $data['fees']['internationalPercentage'],
                        'issuing_fc' => $data['fees']['international'],
                        'charge_phase' => 'after_conversion',
                        'tier_pricing' => 0,
                        'issuing_tiers' => [],
                        'rate' => 1 / $data['fx']['rate'],
                        'description' => $data['localFixedAmountsDescriptions']
                    ];
                })->sortBy('title')->values();
            } else {
                return $this->emit('alert', __('Error fetching operators'));
            }
        }
    }

    public function updatedProduct()
    {
        if ($this->product) {
            $data = collect($this->products)->where('id', $this->product)->first();
            if ($data) {
                $this->vendor_id = $data['id'];
                $this->title = $data['title'];
                $this->description = $data['title'];
                $this->discount = $data['discount'];
                $this->only_denominations = $data['only_denominations'] ? 1 : 0;
                $this->issuing_pc = $data['issuing_pc'];
                $this->issuing_fc = $data['issuing_fc'];
                $this->rate = $data['rate'];
                $this->charge_phase = $data['charge_phase'];
                $this->tier_pricing = $data['tier_pricing'];
                $this->issuing_tiers = $data['issuing_tiers'];
                $this->description = $data['description'];
                $this->min =  $data['min'];
                $this->max =  $data['max'];
                $this->items = array_map(
                    fn($amount, $plan) => ['amount' => (float) round($amount), 'plan' => $plan],
                    array_keys($data['description']),
                    array_values($data['description'])
                );
            }
        }
    }

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function mount()
    {
        $this->items[] = ['amount' => null];
        $this->updatedIssuingFt();
    }

    public function addItem()
    {
        if (count($this->items) == 4) {
            return $this->emit('alert', __('Max Denomination exceeded'));
        }
        $this->items[] = ['amount' => null];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Reindex array
    }

    public function addCard()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'min' => ['required', 'numeric', 'lt:max'],
            'max' => ['required', 'numeric', 'gt:min'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'image' => 'required|file|mimetypes:' . allowedFileTypes() . '|max:' . allowedFileSize(),
            'only_denominations' => ['required'],
            'provider' => ['required', 'string'],
            'product' => ['required'],
        ]);

        if ($this->only_denominations) {
            $this->validate([
                'items.*.amount' => ['required', 'numeric', 'min:' . $this->min, 'max:' . $this->max],
            ]);
        }

        $imageFilePath = Cloudinary::upload($this->image->getRealPath())->getSecurePath();

        $denominations = [];

        foreach ($this->items as $item) {

            if ($item['amount'] && $item['plan']) {
                $denominations[] = $item;
            }
        }
        sort($denominations);
        $this->denominations = array_unique($denominations);

        if ($this->provider == 'reloadly') {
            if (TRX::whereReloadlyId($this->vendor_id)->exists()) {
                return $this->emit('alert', __('Reloadly Item Already Added'));
            }
        } elseif ($this->provider == 'redboxx') {
            if (TRX::whereRedboxxId($this->vendor_id)->exists()) {
                return $this->emit('alert', __('Redboxx Item Already Added'));
            }
        }

        $card = TRX::create([
            'title' =>  $this->title,
            'description' =>  $this->title,
            'terms' =>  $this->terms,
            'redemption_instructions' =>  $this->redemption_instructions,
            'country_id' =>  $this->country->id,
            'iso2' =>  $this->country->iso2,
            'currency' =>  $this->country->currency,
            'currency_symbol' =>  $this->country->currency_symbol,
            'image' => $imageFilePath,
            'created_by' => $this->admin->id,
            'edited_by' => $this->admin->id,
            'min' => $this->min,
            'max' => $this->max,
            'discount' => $this->discount,
            'denominations' => json_encode($this->denominations),
            'status' => 1,
            'provider' => $this->provider,
            'only_denominations' => $this->only_denominations,
            'issuing_type' =>  $this->issuing_ft,
            'issuing_pc' => $this->issuing_pc,
            'issuing_fc' => $this->issuing_fc,
            'rate' => $this->rate,
            'charge_phase' => $this->charge_phase,
            'tier_pricing' => $this->tier_pricing,
            'issuing_tiers' => $this->issuing_tiers,
        ]);

        if ($this->provider == 'reloadly') {
            $card->update([
                'reloadly_id' => $this->vendor_id
            ]);
        } elseif ($this->provider == 'redboxx') {
            $card->update([
                'redboxx_id' => $this->vendor_id
            ]);
        }

        $this->reset(['only_denominations', 'items', 'features', 'title', 'image', 'description', 'terms', 'redemption_instructions', 'category', 'discount', 'min', 'max']);
        $this->emit('saved');
        $this->emit('drawer');
        $this->emit('newCard');
        $this->emit('success', __('Operator Created'));
    }

    public function render()
    {
        $this->card = TRX::whereCountryId($this->country->id)->with(['createdBy', 'editedBy'])->withCount('sales')
            ->when($this->search, function ($query) {
                $this->emit('drawer');
                $query->Where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
                // $term = trim($this->search);
                // if (empty($term)) return $query;
                // // Get matching IDs from Meilisearch
                // $ids = TRX::search($term)->keys(); // returns [1, 4, 23, ...]
                // // Apply to your existing Eloquent query (preserves your other filters)
                // return $query->whereIn('id', $ids);
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->when($this->status != null, function ($query) {
                return $query->whereStatus($this->status);
            })
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);

        return view('livewire.admin.country.data-provider', [
            'cards' => $this->card,
        ]);
    }
}
