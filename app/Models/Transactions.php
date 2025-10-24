<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Services\Cachable\ModelCaching\Traits\Cachable;

class Transactions extends Model
{
    use HasFactory, SoftDeletes, Uuid, Cachable;

    protected $fillable = [
        'user_id',
        'staff_id',
        'business_id',
        'beneficiary_id',
        'sender_id',
        'withdraw_id',
        'ref_id',
        'amount',
        'charge',
        'status',
        'trx_type',
        'type',
        'acct_id',
        'gateway_id',
        'transfer_reference',
        'bank_reference',
        'description',
        'decline_reason',
        'secret',
        'txn_id',
        'details',
        'image',
        'buy_card_rate_id',
        'buy_card_id',
        'sell_card_id',
        'code_id',
        'coupon_id',
        'discount',
        'referral_id',
        'receipt',
        'code',
        'mode',
        'quantity',
        'currency',
        'email',
        'phone',
        'phone_code',
        'card_name',
        'card_id',
        'name',
        'agent_trx_id',
        'issue_id',
        'card_amount',
        'card_currency',
        'card_country',
        'rate'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'reference')->withTrashed();
    }

    public function staff()
    {
        return $this->belongsTo(Admin::class, 'staff_id')->withTrashed();
    }

    public function agentTransaction()
    {
        return $this->belongsTo(Transactions::class, 'agent_trx_id')->withTrashed();
    }

    public function issue()
    {
        return $this->belongsTo(CardIssued::class, 'issue_id')->withTrashed();
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class, 'gateway_id')->withTrashed();
    }

    public function withdrawMethod()
    {
        return $this->belongsTo(Category::class, 'withdraw_id')->withTrashed();
    }
}
