<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuyCard extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $casts = [
        'issuing_tiers' => 'array',
    ];

    protected $fillable = [
        'title',
        'slug',
        'image',
        'whatsapp_image',
        'logo',
        'brand_contact',
        'description',
        'redemption_instructions',
        'terms',
        'min',
        'max',
        'margin',
        'denominations',
        'rate',
        'discount',
        'status',
        'edited_by',
        'created_by',
        'country_id',
        'vendor_id',
        'vendor_details',
        'currency',
        'issuing_fc',
        'issuing_pc',
        'issuing_ft',
        'issuing_range',
        'categories',
        'fixed_min',
        'fixed_max',
        'fixed_denominations',
        'iso2',
        'popular',
        'main_categories',
        'currency_symbol',
        'use_cases',
        'merchant_id',
        'duration',
        'provider',
        'delivery_method',
        'requires_review',
        'campaign_id',
        'only_denominations',
        'redemption_count',
        'issued_count',
        'merchant_sales',
        'merchant_redemptions',
        'merchant_commission',
        'stat_migrated',
        'paid_amount',
        'unpaid_amount',
        'payout',
        'bulk_id',
        'tier_pricing',
        'issuing_tiers',
        'charge_phase',
        'reloadly_id',
        'redboxx_id',
    ];

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by')->withTrashed();
    }

    public function editedBy()
    {
        return $this->belongsTo(Admin::class, 'edited_by')->withTrashed();
    }

    public function country()
    {
        return $this->belongsTo(CountryReg::class, 'country_id')->withTrashed();
    }

    public function sales()
    {
        return $this->hasMany(Orders::class, 'card_id')->whereMode('live');
    }

    public function redemptions()
    {
        return $this->hasMany(Transactions::class, 'card_id')->whereMode('live')->whereType('giftcard_redemption');
    }
}
