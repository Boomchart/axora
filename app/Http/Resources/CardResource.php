<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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
            'id' => $this['id'],
            'name' => $this['name'],
            'country' => $this['country'],
            'currency' => $this['currency'],
            'min' => (float)$this['min'],
            'max' => (float)$this['max'],
            'denominations' => $this['denominations'],
            'exchange_rate' => $this['exchange_rate'],
            'delivery_method' => $this['delivery_method'],
            'logo' => $this['logo'],
            'card_art' => $this['card_art'],
            'description' => $this['description'],
            'redemption_instructions' => $this['redemption_instructions'],
            'terms' => $this['terms'],
            'categories' => $this['categories']
        ];
    }
}
