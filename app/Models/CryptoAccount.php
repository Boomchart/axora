<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CryptoAccount extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $fillable = [
        'user_id',
        'business_id',
        'balance_id',
        'wallet_address',
        'network',
        'token',
        'currency',
        'gateway_id',
        'hasapay_deposit_code',
        'type',
        'label',
        'mode'
    ];

    public function cryptoBalance()
    {
        return $this->belongsTo(CryptoBalance::class, 'balance_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'reference')->withTrashed();
    }
}
