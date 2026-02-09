<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Transactions;
use Livewire\WithFileUploads;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Cache;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class Gateway extends Component
{
    use WithFileUploads;
    public $gateway;
    public $image;
    public $user;
    public $details;
    public $amount;
    public $settings;
    public $fee;
    public $receive;
    public $currency;

    protected $listeners = ['saved' => '$refresh'];

    public function mount()
    {
        $this->receive = $this->currency->currency_symbol . currencyFormat('0.00 ') . ' ' . $this->currency->currency;
        $this->fee = $this->currency->currency_symbol . currencyFormat('0.00 ') . $this->currency->currency;
    }

    public function updatedAmount()
    {

        $this->amount = ($this->amount != null) ? number_format(removeCommas($this->amount)) : $this->amount;
        $fee = calculateFee(removeCommas($this->amount), 'both',  $this->gateway->fiat_charge,  $this->gateway->percent_charge);
        $this->fee = $this->currency->currency_symbol . currencyFormat($fee) . ' ' . $this->currency->currency;
        $this->receive = $this->currency->currency_symbol . currencyFormat(number_format(removeCommas($this->amount) - $fee, 2)) . ' ' . $this->currency->currency;
    }

    public function gateway()
    {
        try {
            if ($this->user->business->flag_deposit == 1) {
                return $this->emit('alert', __('Account funding not available on your account, contact support'));
            }
            $this->amount = removeCommas($this->amount);
            $this->validate(
                [
                    'amount' => ['required', 'numeric', 'min:' . $this->gateway->minamo, 'max:' . $this->gateway->maxamo],
                    'details' => ['required', 'string', 'max:255'],
                    'image' => 'required|file|mimetypes:' . allowedFileTypes() . '|max:' . allowedFileSize(),
                ],
                [
                    'amount.required' => __('Amount is required'),
                    'amount.min' => __('Amount must be between ' . $this->currency->currency_symbol . 1 . ' ' . $this->currency->currency . ' & ' . $this->currency->currency_symbol . currencyFormat(number_format($this->user->getFirstBalance()->amount, 2)) . ' ' . $this->currency->currency),
                    'amount.max' => __('Amount must be between ' . $this->currency->currency_symbol . 1 . ' ' . $this->currency->currency . ' & ' . $this->currency->currency_symbol . currencyFormat(number_format($this->user->getFirstBalance()->amount, 2)) . ' ' . $this->currency->currency),
                ]
            );

            if ($this->image->getMimeType() === 'application/pdf') {
                $path = $this->image->storePublicly('deposit');
            } else {
                $path = Cloudinary::upload($this->image->getRealPath())->getSecurePath();
            }

            $charge = ($this->amount * $this->gateway->percent_charge / 100) + $this->gateway->fiat_charge;
            $trx = Transactions::create([
                'user_id' => $this->user->id,
                'business_id' => $this->user->business_id,
                'gateway_id' => $this->gateway->id,
                'amount' => $this->amount - $charge,
                'charge' => $charge,
                'ref_id' => Str::uuid(),
                'trx_type' => 'credit',
                'type' => 'deposit',
                'status' => 'pending',
                'details' => $this->details,
                'image' => $path,
            ]);
            updateLocale('admin');
            foreach (\App\Models\Admin::whereStatus(0)->whereDeposit(1)->get() as $admin) {
                dispatch(new SendEmail(
                    $admin->email,
                    $admin->username,
                    __('New Deposit request'),
                    __('Hello admin, you have a new bank deposit request for ') . $trx->ref_id,
                    null,
                    null,
                    0
                ));
                updateLocale('user');
            }
            createAudit('Created Funding Request of ' . $this->amount . $this->currency->currency . ' via ' . $this->gateway->name);
            Cache::put('Track' . $this->user->id, $trx->ref_id);
            if ($this->gateway->type == 0) {
                return redirect()->route('deposit.confirm', ['deposit' => $trx->secret]);
            } else {
                $this->reset(['amount', 'details']);
                $this->emit('saved');
                $this->emit('success', __('Deposit request is under review'));
                $this->emit('closeModal', 'gateway_deposit' . $this->gateway->id);
            }
        } catch (\Exception $e) {
            return $this->emit('alert', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.user.gateway');
    }
}
