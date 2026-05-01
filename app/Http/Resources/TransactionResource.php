<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Orders;

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
        if ($this->type == 'giftcard_purchase') {
            $data = [
                'id' => $this->ref_id,
                'currency' => $this->currency,
                'amount' => (float) number_format($this->amount, 2, '.', ''),
                'charge' => (float) number_format($this->charge, 2, '.', ''),
                'total' => (float) number_format(($this->charge + $this->amount), 2, '.', ''),
                'status' => $this->status,
                'mode' => $this->mode,
                'balance' => [
                    'old_balance' => (float) $this->balance_before,
                    'new_balance' => (float) $this->balance_after,
                ],
                'orders' => Orders::whereTrxId($this->id)->whereType('giftcard')
                    ->get()
                    ->groupBy('external_reference')
                    ->map(function ($group, $reference) {
                        $first = $group->first();
                        return [
                            'external_reference' => $reference !== '' ? $reference : null,
                            'card' => [
                                'id' => $first->card_id,
                                'name' => $first->card_name,
                                'quantity' => $group->count(),
                                'amount' => (float) $first->amount,
                                'currency' => $first->currency,
                            ],
                            'payment' => [
                                'currency' => $this->currency,
                                'rate' => $first->rate,
                                'amount' => (float) number_format($first->amount * $first->rate, 2, '.', ''),
                                'charge' => (float) number_format($first->rev_share + $first->profit + $first->vendor_share, 2, '.', ''),
                                'sub_total' => (float) number_format(($first->rev_share + $first->profit + $first->vendor_share) + ($first->amount * $first->rate), 2, '.', ''),
                                'total' => (float) (number_format(($first->rev_share + $first->profit + $first->vendor_share) + ($first->amount * $first->rate), 2, '.', '')) * $group->count()
                            ],
                            'customer' => [
                                'name' => $first->name,
                                'email' => $first->email,
                                'phone' => $first->phone,
                                'phone_code' => $first->phone_code,
                            ],
                            'items' => $group->map(function ($data) {
                                return [
                                    'id' => $data->id,
                                    'status' => $data->status,
                                    'redeem_code' => [
                                        'url' => !empty(decryptRSA($data->card_url)) ? decryptRSA($data->card_url) : null,
                                        'card_code' => !empty(decryptRSA($data->card_code)) ? decryptRSA($data->card_code) : null,
                                        'pin' => !empty(decryptRSA($data->pin_code)) ? decryptRSA($data->pin_code) : null,
                                    ],
                                ];
                            })->values()->all(),
                        ];
                    })
                    ->values()
                    ->all(),
                'created_at' => $this->created_at,
            ];
        }

        if ($this->type == 'airtime_purchase' || $this->type == 'data_purchase') {
            $data = [
                'id' => $this->ref_id,
                'currency' => $this->currency,
                'amount' => (float) number_format($this->amount, 2, '.', ''),
                'charge' => (float) number_format($this->charge, 2, '.', ''),
                'total' => (float) number_format(($this->charge + $this->amount), 2, '.', ''),
                'status' => $this->status,
                'mode' => $this->mode,
                'balance' => [
                    'old_balance' => $this->balance_before,
                    'new_balance' => $this->balance_after,
                ],
                'orders' => Orders::whereTrxId($this->id)->whereIn('type', ['airtime', 'data'])
                    ->get()
                    ->groupBy('external_reference')
                    ->map(function ($group, $reference) {
                        $first = $group->first();
                        return [
                            'external_reference' => $reference !== '' ? $reference : null,
                            'operator' => [
                                'id' => $first->operator_id,
                                'name' => $first->operator_name,
                                'amount' => (float) $first->amount,
                                'currency' => $first->currency,
                            ],
                            'payment' => [
                                'currency' => $this->currency,
                                'rate' => $first->rate,
                                'amount' => (float) number_format($first->amount * $first->rate, 2, '.', ''),
                                'charge' => (float) number_format($first->rev_share + $first->profit + $first->vendor_share, 2, '.', ''),
                                'sub_total' => (float) number_format(($first->rev_share + $first->profit + $first->vendor_share) + ($first->amount * $first->rate), 2, '.', ''),
                                'total' => (float) (number_format(($first->rev_share + $first->profit + $first->vendor_share) + ($first->amount * $first->rate), 2, '.', '')) * $group->count()
                            ],
                            'customer' => [
                                'phone' => $first->phone,
                                'phone_code' => $first->phone_code,
                            ],
                        ];
                    })
                    ->values()
                    ->all(),
                'created_at' => $this->created_at,
            ];
        }

        return $data;
    }
}
