<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this['name'] ?? null,
            'iso2' => $this['iso2'] ?? null,
            'iso3' => $this['iso3'] ?? null,
            'currency' => $this['currency'] ?? null,
            'currency_symbol' => $this['currency_symbol'] ?? null,
            'phone_code' => $this['phone_code'] ?? null,
            'services' => [
                'giftcards' => $this->giftcards_count,
                'airtime_operators' => $this->airtime_providers_count,
                'data_operators' => $this->data_providers_count,
            ]
        ];
    }
}
