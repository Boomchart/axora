<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardIssued extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $fillable = [
        'user_id',
        'business_id',
        'trx_id',
        'order_id',
        'card_id',
        'data',
        'rate',
        'amount',
        'profit',
        'rev_share',
        'status',
        'currency',
        'name',
        'mode',
        'expires',
        'card_code',
        'card_url',
        'agents',
        'paid_agents',
        'paid_profit',
        'redboxx_share',
        'card_amount',
        'card_currency',
        'card_name',
        'email',
        'phone',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'reference')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'trx_id')->withTrashed();
    }

    public function webhooks()
    {
        return $this->hasMany(Webhook::class, 'reference')->orderBy('created_at', 'desc');
    }
}
