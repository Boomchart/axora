<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class BalanceCapture extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $fillable = [
        'balance_id',
        'amount',
        'hold',
        'user_id',
        'business_id',
        'currency',
        'trx_id',
    ];

    public function balance()
    {
        return $this->belongsTo(balance::class, 'balance_id')->withTrashed();
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
