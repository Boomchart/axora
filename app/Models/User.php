<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use MBarlow\Megaphone\HasMegaphone;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, Uuid, HasMegaphone;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'first_name',
        'last_name',
        'country_id',
        'business_id',
        'email',
        'email_verify',
        'verification_code',
        'email_time',
        'ip_address',
        'password',
        'last_login',
        'account_type',
        'phone',
        'phone_verify',
        'phone_code',
        'phone_time',
        'otp_required',
        'token_expired',
        'social',
        'login_alert',
        'transaction_notification',
        'promotional_emails',
        'contact_id',
        'social_account',
        'social_account_id',
        'status',
        'iso2',
        'mobile_code',
        'referral',
        'merchant_id',
        'avatar',
        'language',
        'referred_date',
        'email_auth',
        'ban',
        'user_timezone',
        'otp_time',
        'referral_bonus',
        'ref_buy_times',
        'ref_sell_times',
        'business_name',
        'email_verify_duration',
        'mode',
        'retry_reset_password',
    ];
    protected $guard = 'user';

    protected $table = 'users';

    protected $dates = [
        'retry_reset_password',
        'last_login',
        'email_time'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getKyc($kyc = null)
    {
        return UserKyc::whereUserId($this->id)->whereDocId($kyc)->first();
    }

    public function kycs()
    {
        return $this->hasMany(UserKyc::class, 'user_id');
    }

    public function userCharges($type = null, $duration = null)
    {
        if ($duration == null) {
            $charge = ($type === null) ? Transactions::whereUserId($this->id)->whereStatus('success')->get() : Transactions::whereUserId($this->id)->whereStatus('success')->whereType($type)->get();
        } else {
            if ($duration == 'today') {
                $charge = Transactions::whereUserId($this->id)->whereStatus('success')->where('created_at', '=', Carbon::today())->get();
            } elseif ($duration == 'week') {
                $charge = Transactions::whereUserId($this->id)->whereStatus('success')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            } elseif ($duration == 'month') {
                $charge = Transactions::whereUserId($this->id)->whereStatus('success')->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->get();
            } elseif ($duration == 'year') {
                $charge = Transactions::whereUserId($this->id)->whereStatus('success')->whereYear('created_at', '=', date('Y'))->get();
            }
        }
        return [$charge->sum('charge'), $charge->count()];
    }

    public function userFunds($type = null)
    {
        $account = Balance::whereUserId($this->id)->get()->sum('amount');
        return $account;
    }

    public function lastMac()
    {
        return Devices::whereUser_id($this->business->user->id)->wherebusiness_id($this->business_id)->whereNotNull('mac_address')->orderby('created_at', 'desc')->first();
    }

    public function devices()
    {
        return Devices::whereUserId($this->business->user->id)->whereBusinessId($this->business_id)->orderby('created_at', 'desc')->withTrashed()->get();
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'user_id')->whereBusinessId($this->business_id)->orderBy('created_at', 'desc');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'reference');
    }

    public function audit()
    {
        return $this->hasMany(Audit::class, 'user_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id')->withTrashed();
    }

    public function businesses()
    {
        return $this->hasMany(Business::class, 'user_id');
    }

    public function getCountrySupported()
    {
        return $this->belongsTo(CountryReg::class, 'country_id');
    }

    public function getCountry()
    {
        return Country::find($this->getCountrySupported->country_id);
    }

    public function getState()
    {
        return State::wherecountry_code(Settings::find(1)->real->iso2)->orderby('name', 'asc')->get();
    }

    public function myState()
    {
        return State::whereid($this->state)->first();
    }

    public function getFirstBalance()
    {
        return Balance::where('user_id', $this->id)->wherebusiness_id($this->business_id)->withTrashed()->first();
    }

    public function getBalance($id)
    {
        return Balance::where('user_id', $this->id)->wherebusiness_id($this->business_id)->first();
    }
}
