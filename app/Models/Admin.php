<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Services\Cachable\ModelCaching\Traits\Cachable;
use Carbon\Carbon;

class Admin extends Authenticatable
{
    use Notifiable, Uuid, SoftDeletes, Cachable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = [
        'fa_expiring'
    ];
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'password',
        'status',
        'profile',
        'promo',
        'support',
        'deposit',
        'payout',
        'news',
        'message',
        'knowledge_base',
        'email_configuration',
        'general_settings',
        'giftcard',
        'firewall',
        'token',
        'token_expired',
        'timezone',
        'fa_status',
        'googlefa_secret',
        'fa_expiring',
        'rfi',
        'email',
        'edit_balance',
        'edit_password',
        'ban_user',
        'unban_user',
        'block_user',
        'unblock_user',
        'approve_compliance',
        'decline_compliance',
        'rev_share',
        'api_error'
    ];
    protected $guard = 'admin';

    protected $table = "admin";

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function emailTemplate()
    {
        return Emailtemplate::whereSms(0)->orderBy('type', 'asc')->get();
    }

    public function unreadMessages()
    {
        return Messages::whereseen(0)->count();
    }

    public function openTickets()
    {
        return Ticket::wherestatus(0)->count();
    }

    public function pendingKYC()
    {
        return Business::whereIn('kyc_status', ['PROCESSING'])->count();
    }

    public function watchList()
    {
        return Business::whereWatchlist(1)->count();
    }

    public function pendingOrders()
    {
        return CardIssued::whereStatus('pending')->whereMode('live')->count();
    }

    public function completedOrders()
    {
        return CardIssued::whereStatus('success')->whereMode('live')->count();
    }

    public function pendingTransactions()
    {
        return Transactions::whereStatus('pending')->whereMode('live')->count();
    }

    public function completedTransactions()
    {
        return Transactions::whereStatus('success')->whereMode('live')->count();
    }

    public function currency()
    {
        return Settings::first();
    }

    public function socialLinks()
    {
        return Social::orderBy('type', 'asc')->get();
    }

    public function userFunds($type = null)
    {
        $value = Cache::remember('userFunds' . $type, 600, function () use ($type) {
            $account = Balance::all()->sum('amount');
            if ($type == 'account') {
                return $account;
            }
        });
        return $value;
    }

    public function userCharges($type = null, $duration = null)
    {
        $value = Cache::remember('userCharges' . $type . $duration, 600, function () use ($type, $duration) {
            if ($duration == null) {
                $charge = ($type === null) ? Transactions::whereStatus('success') : Transactions::whereStatus('success')->whereType($type);
            } else {
                if ($duration == 'today') {
                    $charge = Transactions::whereStatus('success')->whereDate('created_at', Carbon::today());
                } elseif ($duration == 'week') {
                    $charge = Transactions::whereStatus('success')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                } elseif ($duration == 'month') {
                    $charge = Transactions::whereStatus('success')->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'));
                } elseif ($duration == 'year') {
                    $charge = Transactions::whereStatus('success')->whereYear('created_at', '=', date('Y'));
                }
            }
            return [$charge->sum('charge'), $charge->count()];
        });
        return $value;
    }

    public function contacts($type = null)
    {
        $value = Cache::remember('contacts' . $type, 600, function () use ($type) {
            if ($type === null) {
                $contacts = Contact::all();
            } else if ($type === 'subscribed') {
                $contacts = Contact::whereSubscribed(1)->get();
            } else if ($type === 'unsubscribed') {
                $contacts = Contact::whereSubscribed(0)->get();
            } else if ($type === 'inbox') {
                $contacts = Messages::whereSeen(0)->get();
            } else if ($type === 'open_tickets') {
                $contacts = Ticket::whereStatus(0)->get();
            }
            return $contacts;
        });
        return $value;
    }

    public function customers($type = null)
    {
        $value = Cache::remember('customers' . $type, 600, function () use ($type) {
            if ($type === null) {
                $customers = User::withTrashed()->get();
            } else if ($type === 'active') {
                $customers = User::whereStatus(0)->get();
            } else if ($type === 'blocked') {
                $customers = User::whereStatus(1)->get();
            } else if ($type === 'kyc') {
                $customers = User::whereRelation('business', 'kyc_status', '!=', 'APPROVED')->get();
            } else if ($type === 'deleted') {
                $customers = User::onlyTrashed()->get();
            } else if ($type === 'notdeleted') {
                $customers = User::all();
            }
            return $customers->count();
        });
        return $value;
    }

    public function deletedMessages()
    {
        return Messages::whereNotNull('deleted_at')->withTrashed()->count();
    }

    public function pages()
    {
        return Page::orderBy('id', 'desc')->get();
    }

    public function devices()
    {
        return Devices::whereUser_id($this->id)->orderby('created_at', 'desc')->paginate(10);
    }
}
