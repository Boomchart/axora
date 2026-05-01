<?php

namespace App\Http\Livewire\Admin\Country;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\DataProvider;
use App\Services\Reloadly\ReloadlyAirtimeService;

class EditDataProvider extends Component
{
    use WithFileUploads;
    public $val;
    public $image;
    public $admin;
    public $settings;
    public $fc_required;
    public $pc_required;
    public $getCategory;
    protected $rules = [];
    public $items;
    public $denominations;
    public $category;
    public $products = [];
    public $product;
    public $provider;
    public $vendor_id;

    protected $listeners = ['updateValueEdit' => 'updateValueEdit'];

    public function getSalesCountProperty()
    {
        return $this->val->sales_count;
    }

    public function updatedValIssuingFt()
    {
        $this->fc_required = (in_array($this->val->issuing_ft, ['both', 'fiat', 'max', 'min'])) ? 1 : 0;
        $this->pc_required = (in_array($this->val->issuing_ft, ['both', 'percent', 'max', 'min'])) ? 1 : 0;
    }

    public function getData()
    {
        if (!empty((json_decode($this->val->denominations, true)))) {
            foreach (json_decode($this->val->denominations, true) as $key => $item) {
                $data[] = [
                    'amount' => $item['amount'] ?? null,
                    'plan' => $item['plan'] ?? null,
                ];
            }
        } else {
            $data[] = [
                'amount' => null,
                'plan' => null
            ];
        }

        return $data;
    }

    public function rules()
    {
        $rules = [
            'val.title' => ['required', 'string', 'max:255'],
            'val.description' => ['required', 'string'],
            'val.only_denominations' => ['required'],
            'val.image' => 'nullable',
            'val.min' => ['required', 'numeric', 'lt:val.max'],
            'val.max' => ['required', 'numeric', 'gt:val.min'],
            'val.discount' => ['required', 'numeric', 'min:0'],
            'val.fixed_denominations' => ['required', 'boolean'],
        ];

        if ($this->image) {
            $rules = array_merge($rules, [
                'image' => 'required|file|mimetypes:' . allowedFileTypes() . '|max:' . allowedFileSize(),
            ]);
        }

        $rules = array_merge($rules, [
            'val.issuing_pc' => [($this->pc_required == 1) ? 'required' : 'nullable', 'numeric'],
            'val.issuing_fc' => [($this->fc_required == 1) ? 'required' : 'nullable', 'numeric'],
        ]);

        return $rules;
    }

    public function mount()
    {
        $this->updatedValIssuingFt();
        $this->items = $this->getData();
        $this->category = json_decode($this->val->main_categories);
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

    public function update()
    {
        $this->validate($this->rules());
        if ($this->image) {
            $this->val->update([
                'image' => Cloudinary::upload($this->image->getRealPath(), [
                    'folder' => 'images',
                    'format' => 'jpg'
                ])->getSecurePath(),
            ]);
        }

        $denominations = [];
        foreach ($this->items as $item) {
            if ($item['amount']) {
                $denominations[] = $item['amount'];
            }
        }

        sort($denominations);

        $this->denominations = array_unique($denominations);

        $this->val->update([
            'title' =>  $this->val->title,
            'slug' => Str::slug($this->val->title),
            'description' =>  $this->val->description,
            'terms' =>  $this->val->terms,
            'redemption_instructions' =>  $this->val->redemption_instructions,
            'main_categories' =>  json_encode($this->category),
            'min' => $this->val->min,
            'max' => $this->val->max,
            'issuing_pc' => $this->val->issuing_pc ?? 0,
            'issuing_fc' => $this->val->issuing_fc ?? 0,
            'denominations' => json_encode($this->denominations),
            'edited_by' => $this->admin->id,
            'only_denominations' => $this->val->only_denominations,
        ]);

        $this->emit('success', __('Card updated'));

        if ($this->val->status == 0) {
            $this->emit('drawer');
        }

        $this->emit('saved');
        $this->emit('newCard' . $this->val->id);
    }

    public function updatedProvider()
    {
        $this->reset(['product', 'products']);
        if ($this->provider == 'reloadly') {
            $reloadly = new ReloadlyAirtimeService();
            $products = $reloadly->productsByCountry($this->val->iso2);
            if ($products['success'] == true) {
                $this->products = collect($products['data'])->where('bundle', false)->where('data', true)->where('status', 'ACTIVE')->where('senderCurrencyCode', 'USD')->where('destinationCurrencyCode', $this->val->currency)->map(function ($data) {
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
                return $this->emit('alert', __('Error fetching cards'));
            }
        }
    }

    public function updatedProduct()
    {
        if ($this->product) {
            $data = collect($this->products)->where('id', $this->product)->first();
            if ($data) {
                $this->vendor_id = $data['id'];
                $this->val->title = $data['title'];
                $this->val->description = $data['title'];
                $this->val->discount = $data['discount'];
                $this->val->only_denominations = $data['only_denominations'] ? 1 : 0;
                $this->val->issuing_pc = $data['issuing_pc'];
                $this->val->issuing_fc = $data['issuing_fc'];
                $this->val->rate = $data['rate'];
                $this->val->charge_phase = $data['charge_phase'];
                $this->val->tier_pricing = $data['tier_pricing'];
                $this->val->issuing_tiers = $data['issuing_tiers'];
                $this->val->description = $data['description'];
                $this->val->min = $data['min'];
                $this->val->max = $data['max'];
                $this->items = array_map(
                    fn($amount, $plan) => ['amount' => (float) round($amount), 'plan' => $plan],
                    array_keys($data['description']),
                    array_values($data['description'])
                );
            }
        }
    }

    public function updateVendor()
    {
        $this->validate([
            'provider' => ['required', 'string'],
            'product' => ['required'],
        ]);

        if ($this->provider == 'reloadly') {
            if (DataProvider::whereReloadlyId($this->vendor_id)->exists()) {
                return $this->emit('alert', __('Reloadly Operator Already Added'));
            }
        } elseif ($this->provider == 'redboxx') {
            if (DataProvider::whereRedboxxId($this->vendor_id)->exists()) {
                return $this->emit('alert', __('Redboxx Operator Already Added'));
            }
        }

        $this->val->update([
            'title' =>  $this->val->title,
            'description' =>  $this->val->title,
            'discount' =>  $this->val->discount,
            'only_denominations' => $this->val->only_denominations,
            'min' => $this->val->min,
            'max' => $this->val->max,
            'issuing_pc' => $this->val->issuing_pc ?? 0,
            'issuing_fc' => $this->val->issuing_fc ?? 0,
            'rate' => $this->val->rate,
            'charge_phase' => $this->val->charge_phase,
            'tier_pricing' => $this->val->tier_pricing,
            'issuing_tiers' => $this->val->issuing_tiers,
            'denominations' => json_encode($this->items),
            'edited_by' => $this->admin->id,
        ]);

        if ($this->provider == 'reloadly') {
            $this->val->update([
                'reloadly_id' => $this->vendor_id,
                'redboxx_id' => null
            ]);
        } elseif ($this->provider == 'redboxx') {
            $this->val->update([
                'redboxx_id' => $this->vendor_id,
                'reloadly_id' => null,
            ]);
        }

        $this->emit('success', __('Card updated'));

        if ($this->val->status == 0) {
            $this->emit('drawer');
        }

        $this->emit('saved');
        $this->emit('newCard' . $this->val->id);
    }

    public function delete()
    {
        $this->val->delete();
        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('closeModal', 'delete' . $this->val->id);
    }

    public function block()
    {
        $this->val->update([
            'status' => 0
        ]);
        $this->emit('saved');
        $this->emit('success', __('Card Disabled'));
    }

    public function activate()
    {
        $this->val->update([
            'status' => 1
        ]);
        $this->emit('saved');
        $this->emit('success', __('Card Enabled'));
    }

    public function render()
    {
        return view('livewire.admin.country.edit-data-provider');
    }
}
