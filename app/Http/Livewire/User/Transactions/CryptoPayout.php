<?php

namespace App\Http\Livewire\User\Transactions;

use Livewire\Component;
use App\Models\{Transactions, CryptoBalance};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\Hasapay\HasapayService;
use App\Traits\ThrottlesAttempts;

class CryptoPayout extends Component
{
    use ThrottlesAttempts;

    // The target is the session's own account, so lock the account, not the IP.
    protected function scopesAttemptsToIp()
    {
        return false;
    }

    public $amount = '0.00';
    public $wallet_address;
    public $validationAmount;
    public $fee = 0;
    public $settings;
    public $currency;
    public $user;
    public $feeBen = '0.00';
    public $balanceAfter = '0.00';
    public $balance;
    public $sent = 'pending';
    public $min_amount;
    public $max_amount;
    public $success_reference;
    public $recipient;
    public $validRecipient = false;
    public $config = [];
    public $error;
    public $debit_trx;

    public $fa_code;
    public $agents = [];
    public $process = false;

    public function mount()
    {
        $this->balance = CryptoBalance::whereBusinessId($this->user->business_id)->orderBy('amount', 'desc')->orderBy('token', 'asc')->first();
        $this->balanceAfter = $this->balance->amount . ' ' . $this->balance->token;
        $this->fee();
    }

    public function changeDefaultWallet(string $data)
    {
        if ($data) {
            $this->balance = CryptoBalance::whereId($data)->whereBusinessId($this->user->business_id)->orderBy('amount', 'desc')->orderBy('token', 'asc')->first();
            $this->balanceAfter = $this->balance->amount . ' ' . $this->balance->token;
            $this->fee();
        }
    }

    public function fee()
    {
        $this->amount = ($this->amount != null) ? removeCommas($this->amount) : $this->amount;
        $fee = calculateFee(
            removeCommas($this->amount),
            $this->balance->getCurrency->crypto_wallet_payout_ft,
            ($this->balance->getCurrency->crypto_wallet_payout_fc + collect(json_decode($this->balance->getCurrency->crypto_wallet_payout_agents, true) ?? [])->sum('rev_fc')),
            ($this->balance->getCurrency->crypto_wallet_payout_pc + collect(json_decode($this->balance->getCurrency->crypto_wallet_payout_agents, true) ?? [])->sum('rev_pc')),
        );

        if ($this->amount) {
            $balance = $this->balance;
            $hasapay = new HasapayService('live');
            $wallet = $hasapay->fetchWalletId($balance->token, $balance->network);

            $estimate = $hasapay->estimateGasFee(
                $wallet['token'],
                $wallet['chain'],
                $wallet['network_name'],
                removeCommas($this->amount)
            );

            if ($estimate['success'] == true) {
                $flat = (float)$balance->crypto_wallet_payout_fc + collect(json_decode($balance->crypto_wallet_payout_agents, true) ?? [])->sum('rev_fc');
                $percent = (float)$balance->crypto_wallet_payout_pc + collect(json_decode($balance->crypto_wallet_payout_agents, true) ?? [])->sum('rev_pc');
                $charge = [
                    'gas_fee' => $estimate['data']['total_fee']['amount'],
                    'azora_charge' => ($this->amount * $percent / 100) + $flat,
                    'total' => (($this->amount * $percent / 100) + $flat) + $estimate['data']['total_fee']['amount'],
                ];
                $this->process = true;
                $fee = $fee + $charge['total'];
            } else {
                return $this->emit('alert', __('An error occurred while calculating gas fee'));
            }
        }

        $this->fee = $fee;
        $this->agents = $this->balance->crypto_wallet_payout_agents;

        $this->feeBen = $this->fee;
        if ((removeCommas($this->amount)) <= $this->balance->amount) {
            $this->balanceAfter = ($this->balance->amount - removeCommas($this->amount)) . ' ' . $this->balance->token;
        } else {
            $this->balanceAfter = __('Insufficient Balance');
        }
    }

    public function updatedWalletAddress()
    {
        $this->reset(['recipient', 'error']);
        $this->validate([
            'wallet_address' => ['required', 'string']
        ]);
        $result = verifyWalletAddress($this->wallet_address, $this->balance->token, $this->balance->network);
        if ($result['valid']) {
            $this->validRecipient = 'allowed_user';
            $this->fee();
        } else {
            $this->validRecipient = 'not_allowed';
            return $this->emit('alert', $result['reason']);
        }
    }

    public function newTrx()
    {
        $this->emit('successModal', 'hide');
        $this->reset(['sent', 'validRecipient']);
    }

    public function max()
    {
        $this->amount = truncateToDecimals(($this->balance->getCurrency->max_swap > $this->balance->amount) ? $this->balance->amount : $this->balance->getCurrency->max_swap, 2);
        $this->fee();
    }

    public function updatedAmount()
    {
        
        if ($this->user->business->flag_withdraw) {
            return $this->emit('alert', __('Withdraw not available on your account, contact support'));
        }
        
        $this->validationAmount = $this->amount;
        $this->fee();
    }

    public function next()
    {
        if ($this->error) {
            return $this->emit('alert', $this->error);
        }

        if ($this->balance->getCurrency->payout == 0) {
            return $this->emit('alert', __('Payout is not currently available for') . ' ' . $this->balance->token);
        }

        if ($this->user->business->flag_withdraw) {
            return $this->emit('alert', __('Transfer not available on your account, contact support'));
        }

        if ($this->validRecipient == 'not_allowed') {
            return $this->emit('alert', __('Transaction failed, you are not allowed to send money to this wallet address'));
        }

        if ($this->user->business->kyc_status != 'APPROVED') {
            return $this->emit('alert', __('Approved compliance is required'));
        }

        $this->validationAmount = removeCommas($this->amount);
        $amount = removeCommas($this->amount);
        $this->fee();

        $validationData = [
            'validationAmount' => [
                'required',
                'numeric',
                'gt:0',
                'lte:' . $this->balance->amount,
                'max:' . $this->balance->amount
            ],
            'wallet_address' => ['required', 'string'],
            'fa_code' => ['required', 'numeric', 'min_digits:6', 'max_digits:6', 'regex:/[0-9]+/'],
        ];

        $this->validate(
            $validationData,
            [
                'validationAmount.required' => __('Amount is required'),
            ]
        );

        if (($amount  + $this->fee) > $this->balance->amount) {
            return $this->emit('alert', __('Insufficient balance.'));
        }

        if ($this->process == false) {
            return $this->emit('alert', __('An error occurred while calculating gas fee'));
        }
        $lockout = $this->attemptLockout('user-2fa', $this->user->id);
        if ($lockout !== null) {
            return $this->emit('alert', $this->attemptLockoutMessage($lockout));
        }

        $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
        if ($g->checkcode($this->user->business->fa_secret, $this->fa_code, 0)) {
            $this->clearAttempts('user-2fa', $this->user->id);
            try {
                $this->create();
            } catch (\Throwable $e) {
                return $this->emit('alert', $e->getMessage());
            }
        } else {
            $this->recordFailedAttempt('user-2fa', $this->user->id);
            return $this->emit('alert', __('Invalid code'));
        }
    }

    private function create()
    {
        $amount = removeCommas($this->amount);
        $fee = $this->fee ?? 0;
        $total = $amount + $fee;

        // Lock the balance row for the whole debit so concurrent payouts (extra tabs,
        // scripted requests reusing the same still-valid 2FA code) can't both pass the
        // balance check and overdraw. CryptoBalance->amount is derived from BalanceLog,
        // which is always read live, so re-reading under the lock is authoritative.
        $debit = DB::transaction(function () use ($amount, $fee, $total) {
            $locked = CryptoBalance::whereKey($this->balance->id)->lockForUpdate()->first();

            if (! $locked || $locked->amount < $total) {
                throw new \RuntimeException(__('Insufficient balance.'));
            }

            $senderBalBefore = $locked->amount;
            $senderBalAfter = $senderBalBefore - $total;

            $debit = Transactions::create([
                'user_id' => $this->user->business->user_id,
                'business_id' => $this->user->business_id,
                'amount' => $amount,
                'charge' => $fee,
                'crypto_wallet_id' => $locked->id,
                'ref_id' => Str::uuid(),
                'trx_type' => 'debit',
                'type' => 'crypto_payout',
                'balance_before' => $senderBalBefore,
                'balance_after' => $senderBalAfter,
                'wallet_address' => $this->wallet_address,
                'currency' => $locked->token,
                'agents' => $this->agents,
                'status' => 'pending',
            ]);

            logBalance($locked->id, $total, 'debit', $debit->id, 'amount', true);

            return $debit;
        });

        $this->debit_trx = $debit;

        createAudit('Sent Crypto Payout to ' . $this->wallet_address . ' ' . $debit->ref_id);

        $this->reset(['wallet_address', 'amount', 'recipient', 'validRecipient', 'success_reference', 'fa_code']);
        $this->sent = 'transfer';
        $this->success_reference = $debit->id;
    }

    public function render()
    {
        return view('livewire.user.transactions.crypto-payout');
    }
}
