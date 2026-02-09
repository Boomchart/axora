<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Transactions;
use App\Models\UserBank;
use App\Models\Category;
use App\Jobs\CustomEmail;
use App\Jobs\SendEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Jobs\SendSMS;
use Propaganistas\LaravelPhone\PhoneNumber;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;

class Withdraw extends Component
{
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
        $balance->update(['amount' => $balance->amount - ($this->amount + $fee)]);

        $object = [
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
        ];

        $trx = Transactions::create($object);

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

            $g = new GoogleAuthenticator();
            if ($g->checkcode($this->user->business->fa_secret, $this->otp, 3) == false) {
                return $this->emit('alert', __('Invalid 2fa Code'));
            }

            if (($balance->amount + $fee) < $this->amount) {
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
