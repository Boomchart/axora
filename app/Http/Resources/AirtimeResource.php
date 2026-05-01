<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AirtimeResource extends JsonResource
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

        $our_flat_fee = $this->business->airtime_issuing_fc + collect(json_decode($this->business->airtime_issuing_agents, true) ?? [])->sum('rev_fc');

        if ($this->provider == 'reloadly') {
            $fee_data = [
                'type' => 'single',
                'charge_phase' => 'after_conversion',
                'fee' => [
                    'currency' => 'USD',
                    'flat' => (float)$this->airtime_issuing_fc + $our_flat_fee,
                    'percent' => (float)$this->airtime_issuing_pc + $this->business->airtime_issuing_pc + collect(json_decode($this->business->airtime_issuing_agents, true) ?? [])->sum('rev_pc'),
                    'description' => 'Charged after card currency is converted to USD'
                ]
            ];
        }

        return [
            'id' => $this['id'],
            'name' => $this['title'],
            'country' => $this['iso2'],
            'currency' => $this['currency'],
            'min' => (float)$this['min'],
            'max' => (float)$this['max'],
            'denomination_type' => $this->only_denominations ? 'FIXED' : 'RANGE',
            'denominations' => collect(json_decode($this->denominations, true))->map(fn($data) => $data['amount'])->values(),
            'exchange_rate' => $this['rate'],
            'logo' => $this['image'],
            'status' => $this['status'] ? 'Active' : 'Disabled',
            'discount' => ($this->discount) ? ($this->discount * 0.5) : 0,
            'issuing_fee' => $fee_data
        ];
    }
}
