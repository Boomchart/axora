<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Illuminate\Support\Facades\DB;

class CryptoBalance extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $table = 'crypto_balances';

    protected $fillable = [
        'user_id',
        'business_id',
        'country_id',
        'ref_id',
        'amount',
        'network',
        'token',
        'mode',
        'wallet_address',
        'deposit_code',
        'vendor',
        'reveal_balance',
        'last_trx_id',
        'stratos_id',
        'crypto_wallet_payout_ft',
        'crypto_wallet_payout_pc',
        'crypto_wallet_payout_fc',
        'crypto_wallet_payout_range',
        'crypto_wallet_payout_agents',
        'crypto_wallet_vendor',
        'crypto_wallet_ft',
        'crypto_wallet_pc',
        'crypto_wallet_fc',
        'crypto_wallet_range',
        'crypto_wallet_agents',
    ];

    public function getAmountAttribute($value)
    {
        $net = BalanceLog::where('balance_id', $this->id)
            ->where('type', 'amount')
            ->selectRaw("
                SUM(
                    CASE 
                        WHEN trx_type = 'credit' THEN amount
                        WHEN trx_type = 'debit'  THEN -amount
                        ELSE 0
                    END
                ) as net
            ")->value('net');

        return $value + ($net ?? 0);
    }

    public function lastTransaction()
    {
        return $this->belongsTo(Transactions::class, 'last_trx_id')->withTrashed();
    }

    public function getShortCodeAttribute()
    {
        return $this->token;
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'reference')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function getCurrency()
    {
        return $this->belongsTo(CryptoCurrencies::class, 'country_id')->withTrashed();
    }

    public function currency()
    {
        return $this->belongsTo(CryptoCurrencies::class, 'country_id')->withTrashed();
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'crypto_currency', 'country_id')->whereBusinessId($this->business_id)->whereMode('live')->whereHide(0);
    }

    public function history($mode = null)
    {
        return Transactions::select(DB::raw('year(created_at) as year'), DB::raw('count(*) as total'))
            ->whereMode($mode ?? $this->mode)
            ->groupBy(DB::raw('year(created_at)'))
            ->orderByDesc('year')
            ->get();
    }

    public function cryptoAccounts()
    {
        return $this->hasMany(CryptoAccount::class, 'balance_id');
    }

    public function masterAccount()
    {
        return $this->hasOne(CryptoAccount::class, 'balance_id')->whereType('master');
    }

    public function wallets()
    {
        return $this->hasMany(CryptoAccount::class, 'balance_id')->pluck('wallet_address')->toArray();
    }
}
