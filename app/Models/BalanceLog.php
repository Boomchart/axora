<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class BalanceLog extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $fillable = [
        'balance_id',
        'trx_id',
        'amount',
        'type',
        'trx_type',
        'crypto',
        'locked',
        'currency_id'
    ];

    public function balance()
    {
        return $this->belongsTo(balance::class, 'balance_id')->withTrashed();
    }
}
