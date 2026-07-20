<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CryptoBalanceResource extends JsonResource
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

        $deposit_fee_data = [
            'flat' => (float)$this->crypto_wallet_fc + collect(json_decode($this->crypto_wallet_agents, true) ?? [])->sum('rev_fc'),
            'percent' => (float)$this->crypto_wallet_pc + collect(json_decode($this->crypto_wallet_agents, true) ?? [])->sum('rev_pc'),
        ];

        $payout_fee_data = [
            'gas_fee' => 'not_fixed',
            'flat' => (float)$this->crypto_wallet_payout_fc + collect(json_decode($this->crypto_wallet_payout_agents, true) ?? [])->sum('rev_fc'),
            'percent' => (float)$this->crypto_wallet_payout_pc + collect(json_decode($this->crypto_wallet_payout_agents, true) ?? [])->sum('rev_pc'),
        ];

        return [
            'id' => $this->id,
            'name' => $this->getCurrency->name,
            'token' => $this->token,
            'network' => $this->network,
            'balance' => $this->amount,
            'payout' => $this->getCurrency->payout,
            'deposit_fee' => $deposit_fee_data,
            'payout_fee' => $payout_fee_data,
        ];
    }
}
