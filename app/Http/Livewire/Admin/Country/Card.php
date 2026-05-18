<?php

namespace App\Http\Livewire\Admin\Country;

use Livewire\Component;
use App\Models\BuyCard;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;
use App\Models\Category;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Admin\CardExport;
use App\Jobs\SendEmail;
use App\Services\Reloadly\ReloadlyGiftcardService;
use App\Services\Redboxx\RedboxxGiftcardService;

class Card extends Component
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

    public function formatRedeemInstructions($instructions)
    {
        $instructions = preg_replace('/<\s*(p|div|li|h[1-6]|tr)[^>]*>/i', "\n", $instructions);
        $instructions = preg_replace('/<\s*\/?\s*(br|\/?p|\/?div|\/?li|\/?h[1-6]|\/?tr)\s*\/?\s*>/i', "\n", $instructions);
        $instructions = html_entity_decode(strip_tags($instructions), ENT_QUOTES | ENT_HTML5);
        $instructions = preg_replace('/[ \t]+/', ' ', $instructions);
        $instructions = preg_replace('/\n{3,}/', "\n\n", $instructions);
        $instructions = trim($instructions);
        return $instructions;
    }

    public function updatedProvider()
    {
        $this->reset(['product', 'products']);
        if ($this->provider == 'reloadly') {
            $reloadly = new ReloadlyGiftcardService();
            $products = $reloadly->productsByCountry($this->country->iso2);
            if ($products['success'] == true) {
                $this->products = collect($products['data'])->where('status', 'ACTIVE')->where('senderCurrencyCode', 'USD')->where('recipientCurrencyCode', $this->country->currency)->map(function ($data) {
                    $instructions = $this->formatRedeemInstructions($data['redeemInstruction']['verbose'] ?? '');
                    return [
                        'id' => $data['productId'],
                        'title' => $data['productName'],
                        'description' => $data['productName'],
                        'discount' => $data['discountPercentage'],
                        'only_denominations' => $data['denominationType'] == 'RANGE' ? false : true,
                        'redemption_instructions' => $instructions,
                        'min' =>  $data['minRecipientDenomination'],
                        'max' =>  $data['maxRecipientDenomination'],
                        'denominations' =>  $data['denominationType'] == 'RANGE' ? [] : $data['fixedRecipientDenominations'],
                        'issuing_pc' => $data['senderFeePercentage'],
                        'issuing_fc' => $data['senderFee'],
                        'charge_phase' => 'after_conversion',
                        'tier_pricing' => 0,
                        'issuing_tiers' => [],
                        'rate' => $data['recipientCurrencyToSenderCurrencyExchangeRate'],
                    ];
                })->sortBy('title')->values();
                // \Log::info($this->products);
            } else {
                return $this->emit('alert', __('Error fetching cards'));
            }
        } elseif ($this->provider == 'redboxx') {
            $redboxx = new RedboxxGiftcardService();
            $products = $redboxx->productsByCountry($this->country->iso2);

            if ($products['success'] == true) {
                $this->products = collect($products['data'])->where('currency', $this->country->currency)->map(function ($data) {
                    $instructions = $this->formatRedeemInstructions($data['redemption_instructions'] ?? '');
                    return [
                        'id' => $data['id'],
                        'title' => $data['name'],
                        'description' => $data['description'],
                        'discount' => 0,
                        'only_denominations' => $data['denomination_type'] == 'RANGE' ? false : true,
                        'redemption_instructions' => $instructions,
                        'min' =>  $data['min'],
                        'max' =>  $data['max'],
                        'denominations' =>  $data['denomination_type'] == 'RANGE' ? [] : $data['denominations'],
                        'issuing_pc' => ($data['issuing_fee']['type'] == 'single') ? $data['issuing_fee']['fee']['percent'] : 0,
                        'issuing_fc' => ($data['issuing_fee']['type'] == 'single') ? $data['issuing_fee']['fee']['flat'] : 0,
                        'charge_phase' => $data['issuing_fee']['charge_phase'],
                        'tier_pricing' => ($data['issuing_fee']['type'] == 'single') ? 0 : 1,
                        'issuing_tiers' => ($data['issuing_fee']['type'] == 'single') ? [] : $data['issuing_fee']['fee'],
                        'rate' => $data['exchange_rate'],
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
                $this->title = $data['title'];
                $this->description = $data['title'];
                $this->discount = $data['discount'];
                $this->only_denominations = $data['only_denominations'] ? 1 : 0;
                $this->redemption_instructions =  $data['redemption_instructions'];
                $this->issuing_pc = $data['issuing_pc'];
                $this->issuing_fc = $data['issuing_fc'];
                $this->rate = $data['rate'];
                $this->charge_phase = $data['charge_phase'];
                $this->tier_pricing = $data['tier_pricing'];
                $this->issuing_tiers = $data['issuing_tiers'];

                if ($data['only_denominations']) {
                    $this->items = array_map(fn($v) => ['amount' => $v], $data['denominations']);
                    if ($data['min'] == null) {
                        $this->min = min($data['denominations']);
                    }
                    if ($data['max'] == null) {
                        $this->max = max($data['denominations']);
                    }
                } else {
                    $this->items = [['amount' => null]];
                    $this->min =  $data['min'];
                    $this->max =  $data['max'];
                }
            }
        }
    }

    public function save()
    {
        $this->validate([
            'exportEmail' => ['required', 'email:dns,rfc', 'max:255']
        ]);

        $query = [
            'timezone' => $this->admin->timezone,
            'country' => $this->country->id
        ];

        $filename = now() . '-admin-giftcard.xlsx';
        Excel::queue(new CardExport($query), $filename, 'local')
            ->chain([
                new SendEmail(
                    $this->exportEmail,
                    $this->settings->site_name,
                    __('Admin Gift Card'),
                    __('Admin Gift Card exported'),
                    storage_path('app/' . $filename),
                    null,
                    null,
                )
            ]);

        $this->emit('success', __('Gift Card List will be sent to your email'));
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
            'description' => ['required', 'string'],
            'terms' => ['nullable', 'string'],
            'redemption_instructions' => ['nullable', 'string'],
            'category' => ['required'],
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

            if ($item['amount']) {
                $denominations[] = $item['amount'];
            }
        }
        sort($denominations);
        $this->denominations = array_unique($denominations);

        if (empty($this->category)) {
            return $this->emit('alert', __('Select a category'));
        }


        if ($this->provider == 'reloadly') {
            if (BuyCard::whereReloadlyId($this->vendor_id)->exists()) {
                return $this->emit('alert', __('Reloadly Giftcard Already Added'));
            }
        } elseif ($this->provider == 'redboxx') {
            if (BuyCard::whereRedboxxId($this->vendor_id)->exists()) {
                return $this->emit('alert', __('Redboxx Giftcard Already Added'));
            }
        }

        $card = BuyCard::create([
            'title' =>  $this->title,
            'slug' => Str::slug($this->title),
            'description' =>  $this->description,
            'terms' =>  $this->terms,
            'redemption_instructions' =>  $this->redemption_instructions,
            'main_categories' =>  json_encode($this->category),
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
        $this->emit('success', __('Card Created'));
    }

    public function render()
    {
        $this->getCategory = Category::whereType('giftcard_buy')->orderBy('name', 'asc')->get();

        $this->card = BuyCard::whereCountryId($this->country->id)->with(['createdBy', 'editedBy'])->withCount('sales', 'redemptions')
            ->when($this->search, function ($query) {
                $this->emit('drawer');
                $term = trim($this->search);
                if (empty($term)) return $query;
                // Get matching IDs from Meilisearch
                $ids = BuyCard::search($term)->keys(); // returns [1, 4, 23, ...]
                // Apply to your existing Eloquent query (preserves your other filters)
                return $query->whereIn('id', $ids);
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->when($this->status != null, function ($query) {
                return $query->whereStatus($this->status);
            })
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);

        return view('livewire.admin.country.card', [
            'cards' => $this->card,
            'getCategory' => $this->getCategory,
        ]);
    }
}
