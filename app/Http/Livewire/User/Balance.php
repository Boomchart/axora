<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Transactions;
use App\Jobs\SendEmail;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class Balance extends Component
{

    use WithFileUploads;

    public $user;
    public $type;
    public $settings;
    public $currency;
    public $amount;
    public $fee;
    public $receive;
    private $recent;
    public $trx;
    public $image;
    public $bank_amount;
    public $bank_reference;

    public function displayBalance()
    {
        if ($this->user->business->reveal_balance == 1) {
            $this->user->business->update(['reveal_balance' => 0]);
            createAudit('hide balance');
        } else {
            $this->user->business->update(['reveal_balance' => 1]);
            createAudit('show balance');
        }
    }

    public function mount()
    {
        $this->receive = $this->currency->currency_symbol . currencyFormat('0.00 ') . ' ' . $this->currency->currency;
        $this->fee = $this->currency->currency_symbol . currencyFormat('0.00 ') . $this->currency->currency;
    }

    public function updatedBankAmount()
    {

        $this->bank_amount = ($this->bank_amount != null) ? number_format(removeCommas($this->bank_amount)) : $this->bank_amount;
        $fee = calculateFee(removeCommas($this->bank_amount), $this->settings->deposit_pct,  $this->settings->deposit_fiat_pc,  $this->settings->deposit_percent_pc);
        $this->fee = $this->currency->currency_symbol . currencyFormat($fee) . ' ' . $this->currency->currency;
        $this->receive = $this->currency->currency_symbol . currencyFormat(number_format(removeCommas($this->bank_amount) - $fee, 2)) . ' ' . $this->currency->currency;
    }

    public function bankDeposit()
    {
        if ($this->user->business->flag_deposit == 1) {
            return $this->emit('alert', __('Account funding not available on your account, contact support'));
        }
        $this->bank_amount = removeCommas($this->bank_amount);
        $this->validate([
            'bank_amount' => ['required', 'numeric', 'min:1'],
            'bank_reference' => 'required',
            'image' => 'required|file|mimetypes:' . allowedFileTypes() . '|max:' . allowedFileSize(),
        ]);

        if ($this->image->getMimeType() === 'application/pdf') {
            $path = $this->image->storePublicly('deposit');
        } else {
            $path = Cloudinary::upload($this->image->getRealPath())->getSecurePath();
        }

        $fee = calculateFee(removeCommas($this->bank_amount), $this->settings->deposit_pct,  $this->settings->deposit_fiat_pc,  $this->settings->deposit_percent_pc);
        $trx = Transactions::create([
            'user_id' => $this->user->id,
            'business_id' => $this->user->business_id,
            'amount' => $this->bank_amount - $fee,
            'charge' => $fee,
            'ref_id' => Str::uuid(),
            'bank_reference' => $this->bank_reference,
            'trx_type' => 'credit',
            'type' => 'bank_transfer',
            'status' => 'pending',
            'image' => $path,
        ]);

        createAudit('Created Bank Transfer Request of ' . $this->bank_amount);

        foreach (\App\Models\Admin::whereStatus(0)->whereDeposit(1)->get() as $admin) {
            dispatch(new SendEmail(
                $admin->email,
                $admin->username,
                __('New bank deposit request'),
                __('Hello admin, you have a new bank deposit request for ') . $trx->ref_id,
                null,
                null,
                0
            ));
        }

        $this->reset(['bank_amount', 'bank_reference', 'fee', 'receive']);
        $this->emit('drawer');
        $this->emit('closeModal', 'bank_deposit');
        $this->emit('success', __('Bank deposit request is under review'));
    }

    public function launchChart()
    {
        // Step 2: Add caching for better performance (5-minute cache)
        $cacheKey = sprintf(
            'chart_data_%s_%s_%s',
            $this->user->business_id,
            $this->user->business->account_mode,
            $this->date ?? 'last_month'
        );

        $stats = Cache::get($cacheKey);

        if (!$stats) {
            dispatch(new \App\Jobs\User\CalculateDashboardChartJob($cacheKey, $this->parseDateRange(), $this->user->business_id));
        } else {
            return $this->emit('loadChart', $stats);
        }
    }

    private function parseDateRange()
    {
        $from = Carbon::now()->subDays(30);
        $to = Carbon::now()->endOfDay();

        return [$from, $to];
    }

    public function render()
    {
        $issued = \App\Models\CardIssued::whereUserId($this->user->id)
            ->whereMode('live')
            ->whereStatus('success')
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
            ->get();

        $cacheKey = sprintf(
            'api_logs_stats_%s_%s_%s',
            $this->user->business_id,
            $this->user->business->account_mode,
            md5(Carbon::now()->subDays(30) . ' - ' . Carbon::now())
        );

        $stats = Cache::get($cacheKey);

        if (!$stats) {
            // Dispatch background job to calculate stats
            dispatch(new \App\Jobs\User\CalculateDashboardStatsJob($cacheKey, $this->parseDateRange(), $this->user->business_id));

            // Return default values while job processes
            $stats = [
                'successLogs' => 'Loading...',
                'clientLogs' => 'Loading...',
                'serverLogs' => 'Loading...',
                'loading' => true
            ];
        }

        return view('livewire.user.balance', array_merge($stats, [
            'user' => $this->user,
            'sales' => $issued->sum('amount'),
            'issued' => $issued->count(),
        ]));
    }
}
