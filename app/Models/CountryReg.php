<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountryReg extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $table = 'country_regs';
    protected $fillable = [
        'country_id',
        'iso2',
        'iso3',
        'status',
        'sms_provider',
        'status',
        'name',
        'currency',
        'currency_symbol',
        'phone_code',
    ];

    public function real()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function giftcards()
    {
        return $this->hasmany(BuyCard::class, 'country_id');
    }

    public function airtimeProviders()
    {
        return $this->hasmany(AirtimeProvider::class, 'country_id');
    }

    public function dataProviders()
    {
        return $this->hasmany(DataProvider::class, 'country_id');
    }
}
