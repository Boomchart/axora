<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Transactions;
use App\Models\Balance;
use App\Models\UserBank;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Jobs\CustomEmail;
use App\Jobs\SendEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Jobs\SendSMS;
use Propaganistas\LaravelPhone\PhoneNumber;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use App\Traits\ThrottlesAttempts;

class Withdraw extends Component
{
    use ThrottlesAttempts;

    // The target is the session's own account, so lock the account, not the IP.
    protected function scopesAttemptsToIp()
    {
        return false;
    }

    public $user;
    public $withdraw_type = 'other';
    public $other;
    public $requirements;
    public $settings;
    public $currency;
    public $amount;
    public $bank;
    public $pin;
    public $fee;
    public $balanceAfter;
    public $otp_required = 0;
    public $otp;
    public $pct;
    public $pc;
    public $fc;
    public $placeholder = "Payout Details";
    public $bank_accounts = 0;
    public $other_payment = 1;

    protected $listeners = ['saved' => '$refresh'];

    public function updatedOther()
    {
        if ($this->other == null) {
            $this->pct = $this->settings->withdraw_pct;
            $this->pc = $this->settings->withdraw_fiat_pc;
            $this->fc = $this->settings->withdraw_percent_fc;
        } else {
            $method = Category::whereId($this->other)->first();
            $this->pct = $method->pct;
            $this->pc = $method->pc;
            $this->fc = $method->fc;
            $this->placeholder = $method->requirements;
        }
        $this->fee();
    }

    public function resend()
    {
        if (Carbon::parse($this->user->otp_time)->add($this->settings->otp_resend_duration . ' ' . $this->settings->otp_resend_time) > Carbon::now()) {
            return $this->emit('alert', __('You can resend link after ') . gmdate('i:s', Carbon::parse($this->user->otp_time)->add($this->settings->otp_resend_duration . ' ' . $this->settings->otp_resend_time)->diffInSeconds(Carbon::now())) . __(' minutes'));
        } else {
            $token = generateOTP($this->user->business);
            $this->user->update([
                'otp_time' => Carbon::now(),
                'token_expired' => Carbon::now()->add($this->settings->otp_resend_duration . ' ' . $this->settings->otp_resend_time)
            ]);
            $this->emit('newTime', Carbon::create($this->user->otp_time)->add($this->settings->otp_resend_duration . ' ' . $this->settings->otp_resend_time)->toDateTimeString());
            createAudit('Resent Email OTP');
            dispatch(new CustomEmail('otp', $this->user->id, null, $token));
            return $this->emit('success', __('OTP resent'));
        }
    }

    public function mount()
    {
        $this->balanceAfter = $this->currency->currency_symbol . currencyFormat(number_format($this->user->getFirstBalance()->amount, 2)) . ' ' . $this->currency->currency;
        $this->fee = $this->currency->currency_symbol . currencyFormat('0.00 ') . $this->currency->currency;
        $this->pct == $this->settings->pct;
        $this->pc == $this->settings->pc;
        $this->fc == $this->settings->fc;
    }

    public function max()
    {
        $max = Category::whereId($this->other)->first()->max;
        if ($this->user->getFirstBalance()->amount < $max) {
            $this->amount = number_format($this->user->getFirstBalance()->amount);
        } else {
            $this->amount = number_format($max);
        }
        $this->fee();
    }

    public function fee()
    {
        $this->amount = ($this->amount != null) ? number_format(removeCommas($this->amount)) : $this->amount;
        $fee = calculateFee(removeCommas($this->amount), $this->pct,  $this->fc,  $this->pc);
        $this->fee = $this->currency->currency_symbol . currencyFormat($fee) . ' ' . $this->currency->currency;
        $balance = $this->user->getFirstBalance()->amount;
        if (($fee + removeCommas($this->amount)) <= $balance) {
            $this->balanceAfter = $this->currency->currency_symbol . currencyFormat(number_format(($balance - $fee - removeCommas($this->amount)), 2)) . ' ' . $this->currency->currency;
        } else {
            $this->balanceAfter = __('Insufficient Balance');
        }
    }

    public function updatedAmount()
    {
        $this->amount = ($this->amount != null) ? number_format(removeCommas($this->amount)) : $this->amount;
        $this->fee();
    }

    public function create($balance, $fee)
    {
        $total = $this->amount + $fee;

        // Serialize concurrent debits on this balance row so two requests can't
        // both pass the balance check and overdraw the account (race / double-spend).
        $trx = DB::transaction(function () use ($balance, $fee, $total) {
            $locked = Balance::disableCache()->whereKey($balance->id)->lockForUpdate()->first();

            if (! $locked || $locked->amount < $total) {
                throw new \RuntimeException(__('Insufficient Balance'));
            }

            $balance_before = $locked->amount;
            $locked->update(['amount' => $balance_before - $total]);

            return Transactions::create([
                'user_id' => $this->user->id,
                'business_id' => $this->user->business_id,
                'amount' => $this->amount,
                'charge' => $fee,
                'ref_id' => Str::uuid(),
                'trx_type' => 'debit',
                'type' => 'payout',
                'status' => 'pending',
                'withdraw_id' => $this->other,
                'details' => $this->requirements,
                'balance_before' => $balance_before,
                'balance_after' => $balance_before - $total,
            ]);
        });

        createAudit('Submitted withdraw request ' . $trx->ref_id);
        updateLocale('admin');
        foreach (\App\Models\Admin::whereStatus(0)->wherePayout(1)->get() as $admin) {
            dispatch(new SendEmail(
                $admin->email,
                $admin->username,
                __('New payout request'),
                __('Hello admin, you are required to review payout request of ') . number_format($trx->amount, 2) . __(' for ') . $this->user->business->name,
                null,
                null,
                0
            ));
        }
        updateLocale('user');

        $this->reset(['bank', 'amount', 'withdraw_type', 'other', 'requirements', 'otp_required', 'otp']);
        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('success', __('Payout request submitted'));
    }

    public function payout()
    {
        try {
            $this->amount = removeCommas($this->amount);
            $balance = $this->user->getFirstBalance();
            $max = Category::whereId($this->other)->first()->max;
            $min = Category::whereId($this->other)->first()->min;

            $method = Category::whereId($this->other)->first();
            $fee = calculateFee($this->amount, $method->pct,  $method->fc,  $method->pc);

            $this->validate(
                [
                    'amount' => ['required', 'numeric', 'min:' . $min, 'max:' . $max],
                    'other' => [($this->withdraw_type == 'other') ? 'required' : 'nullable'],
                    'requirements' => [($this->withdraw_type == 'other') ? 'required' : 'nullable', 'string'],
                    'otp' => ['required', 'numeric', 'min_digits:6', 'max_digits:6'],
                ],
                [
                    'amount.required' => __('Amount is required'),
                    'other.required' => __('Select a Payout method'),
                    'amount.min' => __('Amount must be between') . ' ' . $this->currency->currency_symbol . currencyFormat(number_format($min, 2)) . ' ' . $this->currency->currency . ' & ' . $this->currency->currency_symbol . currencyFormat(number_format($max, 2) . ' ' . $this->currency->currency),
                    'amount.max' => __('Amount must be between') . ' ' . $this->currency->currency_symbol . currencyFormat(number_format($min, 2)) . ' ' . $this->currency->currency . ' & ' . $this->currency->currency_symbol . currencyFormat(number_format($max, 2) . ' ' . $this->currency->currency),
                ]
            );

            $lockout = $this->attemptLockout('user-2fa', $this->user->id);
            if ($lockout !== null) {
                return $this->emit('alert', $this->attemptLockoutMessage($lockout));
            }

            $g = new GoogleAuthenticator();
            if ($g->checkcode($this->user->business->fa_secret, $this->otp, 0) == false) {
                $this->recordFailedAttempt('user-2fa', $this->user->id);
                return $this->emit('alert', __('Invalid 2fa Code'));
            }
            $this->clearAttempts('user-2fa', $this->user->id);

            if (($this->amount + $fee) > $balance->amount) {
                return $this->addError('amount', __('Insufficient Balance'));
            }

            $this->create($balance, $fee);
        } catch (\Exception $e) {
            return $this->emit('alert', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.user.withdraw');
    }
}
