<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\EncryptPersonalData;

class Business extends Model
{
    use HasFactory, Uuid, SoftDeletes, EncryptPersonalData;

    protected $casts = [
        'bank_account' => 'array'
    ];
    protected $dates = [
        'kyc_expiry',
        'g_expiry',
        'fa_expiring'
    ];

    protected $fillable = [
        'user_id',
        'name',
        'reference',
        'reveal_balance',
        'kyc_status',
        'kyc_type',
        'pin',
        'tag',
        'otp_login',
        'b_day',
        'b_month',
        'b_year',
        'line_1',
        'line_2',
        'state',
        'city',
        'postal_code',
        'proof_of_address',
        'selfie',
        'doc_front',
        'doc_back',
        'source_of_funds',
        'kin_first_name',
        'kin_last_name',
        'kin_mobile',
        'kin_mobile_code',
        'kin_email',
        'kin_address',
        'doc_type',
        'doc_number',
        'decline_reason',
        'kyc_expiry',
        'watchlist',
        'flag_deposit',
        'flag_savings',
        'flag_withdraw',
        'flag_transfer',
        'fa_status',
        'fa_secret',
        'fa_expiring',
        'api_key',
        'test_api_key',
        'webhook_url',
        'webhook_secret',
        'ip_whitelisting',
        'ipv6_whitelisting',
        'mcc',
        'business_monthly_limits',
        'account_mode',
        'mode',
        'registration_location',
        'website',
        'staff_size',
        'incorporation_date',
        'registration_type',
        'business_country',
        'business_street',
        'business_state',
        'business_city',
        'business_postal_code',
        'issuing_fc',
        'issuing_pc',
        'issuing_agents',
        'agent',
        'charge_account'
    ];

    protected $encryptable = [
        'ssn',
    ];

    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getState()
    {
        return State::wherecountry_code($this->getCountry()->iso2)->orderby('name', 'asc')->get();
    }

    public function myState()
    {
        return $this->belongsTo(State::class, 'state');
    }

    public function getKyc($kyc = null)
    {
        return UserKyc::whereUserId($this->user_id)->whereDocId($kyc)->first();
    }

    public function getMcc()
    {
        return $this->belongsTo(Category::class, 'mcc')->whereType('mcc')->withTrashed();
    }

    public function getRegType()
    {
        return $this->belongsTo(Category::class, 'registration_type')->whereType('regtype')->withTrashed();
    }

    public function directors()
    {
        return $this->hasMany(Directors::class, 'business_id', 'reference');
    }
}
