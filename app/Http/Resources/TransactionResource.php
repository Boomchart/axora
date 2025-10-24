<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $issued = [];

        foreach (\App\Models\CardIssued::whereTrxId($this->id)->get() as $data) {
            $issued[] = [
                'id' => $data->id,
                'card_id' => $data->card_id,
                'name' => $data->name,
                'amount' => (float) $data->amount,
                'currency' => $data->currency,
                'rate' => (float) number_format($data->rate, 5, '.', ''),
                'value' => (float) number_format($data->amount * $data->rate, 2, '.', ''),
                'status' => $data->status,
                'card_url' => $data->card_url,
                'card_code' => $data->card_code,
                'expires' => $data->expires
            ];
        }

        return [
            'id' => $this->ref_id,
            'amount' => (float) number_format($this->amount, 2, '.', ''),
            'charge' => (float) number_format($this->charge, 2, '.', ''),
            'quantity' => $this->quantity,
            'currency' => $this->currency,
            'status' => $this->status,
            'mode' => $this->mode,
            'customer' => [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'phone_code' => $this->phone_code,
            ],
            'card' => [
                'id' => $this->card_id,
                'name' => $this->card_name,
            ],
            'order' => $issued,
            'created_at' => $this->created_at,
        ];
    }
}
