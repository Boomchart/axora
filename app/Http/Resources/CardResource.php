<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Category;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    protected $business;

    public function __construct($resource, $business = null)
    {
        parent::__construct($resource);
        $this->business = $business;
    }

    public function toArray($request)
    {
        $vendorCategories = [];
        foreach (json_decode($this->main_categories, true) as $categorydata) {
            if (Category::whereId($categorydata)->whereType('giftcard_buy')->exists()) {
                $vendorCategories[] = Category::whereId($categorydata)->whereType('giftcard_buy')->first()->name;
            }
        }

        $our_flat_fee = $this->business->issuing_fc + collect(json_decode($this->business->issuing_agents, true) ?? [])->sum('rev_fc');

        if ($this->provider == 'reloadly') {
            $fee_data = [
                'type' => 'single',
                'charge_phase' => 'after_conversion',
                'fee' => [
                    'currency' => $this->currency,
                    'flat' => (float)$this->issuing_fc + $our_flat_fee,
                    'percent' => (float)$this->issuing_pc + $this->business->issuing_pc + collect(json_decode($this->business->issuing_agents, true) ?? [])->sum('rev_pc'),
                    'description' => 'Charged after card currency is converted to USD'
                ]
            ];
        } else {
            if ($this->tier_pricing == 0) {
                $fee_data = [
                    'type' => 'single',
                    'charge_phase' => $this->charge_phase,
                    'fee' => [
                        'currency' => ($this->charge_phase == 'before_conversion') ? $this->currency : 'USD',
                        'flat' => (float)$this->issuing_fc + (($this->charge_phase == 'before_conversion') ? ($our_flat_fee / $this->rate) : $our_flat_fee),
                        'percent' => (float)$this->issuing_pc + $this->business->issuing_pc + collect(json_decode($this->business->issuing_agents, true) ?? [])->sum('rev_pc'),
                        'description' => ($this->charge_phase == 'before_conversion') ? 'Charged before card currency is converted to USD' : 'Charged after card currency is converted to USD'
                    ]
                ];
            } else {
                $fee_data = [
                    'type' => 'tier_pricing',
                    'charge_phase' => 'before_conversion',
                    'fee' => collect($this->issuing_tiers)->map(function ($data) use ($our_flat_fee) {
                        return [
                            'currency' => ($this->charge_phase == 'before_conversion') ? $this->currency : 'USD',
                            'min' => (float)$data['min'],
                            'max' => empty($data['max']) ? null : (float)$data['max'],
                            'flat' => (float)$data['flat'] + (($this->charge_phase == 'before_conversion') ? ($our_flat_fee / $this->rate) : $our_flat_fee),
                            'percent' => (float)$data['percent'] + $this->business->issuing_pc + collect(json_decode($this->business->issuing_agents, true) ?? [])->sum('rev_pc'),
                            'description' => (($this->charge_phase == 'before_conversion') ? 'Charged before card currency is converted to USD' : 'Charged after card currency is converted to USD').', amount must be greater than min amount. if max amount is null, means there is no limit on tier pricing'
                        ];
                    })
                ];
            }
        }

        return [
            'id' => $this['id'],
            'name' => $this['title'],
            'country' => $this['iso2'],
            'currency' => $this['currency'],
            'min' => (float)$this['min'],
            'max' => (float)$this['max'],
            'denomination_type' => $this->only_denominations ? 'FIXED' : 'RANGE',
            'denominations' => collect(json_decode($this->denominations, true) ?? [])->map(fn($data) => $data ?? null)->values(),
            'exchange_rate' => $this['rate'],
            'card_art' => $this['image'],
            'description' => $this['description'],
            'redemption_instructions' => $this['redemption_instructions'],
            'terms' => $this['terms'],
            'status' => $this['status'] ? 'Active' : 'Disabled',
            'categories' => $vendorCategories,
            'discount' => ($this->discount) ? ($this->discount * 0.5) : 0,
            'issuing_fee' => $fee_data
        ];
    }
}
