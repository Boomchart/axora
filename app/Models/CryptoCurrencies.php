<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class CryptoCurrencies extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $table = 'crypto_currencies';

    protected $fillable = [
        'name',
        'network',
        'token',
        'image',
        'country_id',
        'local_swap',
        'local_transfer',
        'crypto_wallet_vendor',
        'crypto_wallet_ft',
        'crypto_wallet_pc',
        'crypto_wallet_fc',
        'crypto_wallet_range',
        'crypto_wallet_agents',
        'status',
        'min_swap',
        'max_swap',
        'min_swap_usd',
        'min_send_usd',
        'max_swap_usd',
        'max_send_usd',
        'balance_migrated',
        'balance_amount',
        'payout',
        'crypto_wallet_payout_ft',
        'crypto_wallet_payout_pc',
        'crypto_wallet_payout_fc',
        'crypto_wallet_payout_range',
        'crypto_wallet_payout_agents'
    ];

    public function getCurrencyAttribute()
    {
        return $this->token;
    }

    public function countryReg()
    {
        return $this->belongsTo(CountryReg::class, 'country_id')->with(['real'])->withTrashed();
    }

    public function balances()
    {
        return $this->hasMany(CryptoBalance::class, 'country_id')->whereMode('live')->withTrashed();
    }

    public function cryptoRates()
    {
        return $this->hasMany(Rates::class, 'from_currency')->with(['toCrypto', 'toCurrency'])->whereIn('type', ['crypto_to_crypto', 'crypto_to_fiat', 'fiat_to_crypto'])->orderby('token', 'asc');
    }
}
