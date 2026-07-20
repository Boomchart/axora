<?php

namespace App\Http\Livewire\Admin\Crypto;

use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminTransactionExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Jobs\SendEmail;
use App\Models\Transactions as TRX;
use Illuminate\Support\Facades\DB;

class Transactions extends Component
{
    public int $perPage = 100;
    public $val;
    public $search;
    public $status;
    public $trx_type;
    public $base;
    public $exportType;
    public $exportAs;
    public $date;
    public $settings;
    public $sortBy = "created_at";
    public $orderBy = "desc";
    public $type;
    public $exportEmail;
    public $admin;

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function save()
    {
        $query = [
            'mode' => 'live',
            'hide' => 0,
            'crypto_currency' => $this->val->id,
            'status' => $this->status,
            'date' => $this->date,
            'trx_type' => $this->trx_type,
            'type' => $this->base,
            'admin_timezone' => $this->admin->timezone ?? 'UTC', // Pass admin timezone,
        ];

        $filename = now() . '-transaction.xlsx';
        Excel::queue(new AdminTransactionExport($query), $filename, 'local')
            ->chain([
                new SendEmail(
                    $this->admin->email,
                    $this->admin->username,
                    __('Transaction Statement'),
                    __('Transaction Statement exported'),
                    storage_path('app/' . $filename),
                    null,
                    null,
                )
            ]);

        $this->emit('success', __('Transaction Statement will be sent to your email'));
    }

    public function render()
    {
        $page = $this->pages();
        return view('livewire.admin.crypto.transactions', [
            'transactions' => $page->simplePaginate($this->perPage),
            'total' => $page->count(),
            'first' => Carbon::now()->sub('1 month')->format('m/d/Y'),
            'last' => Carbon::now()->format('m/d/Y'),
        ]);
    }

    protected function pages()
    {
        return TRX::with(['user', 'business'])
            ->whereCurrency($this->val->id)
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('amount', 'like', '%' . $this->search . '%')
                        ->orWhere('charge', 'like', '%' . $this->search . '%')
                        ->orWhere('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%')
                        ->orWhere('ref_id', 'like', '%' . $this->search . '%');
                });
            })
            ->when(($this->status != null), function ($query) {
                return $query->whereStatus($this->status);
            })
            ->when(($this->date != null), function ($query) {
                $from = Carbon::create(explode('-', $this->date)[0])->setTimezone($this->admin->timezone);
                $to = Carbon::create(explode('-', $this->date)[1])->setTimezone($this->admin->timezone)->addDay(1);
                if ($from != $to) {
                    return $query->whereBetween('created_at', [$from, $to]);
                } else {
                    return $query->where('created_at', '>=', $from);
                }
            })
            ->when(($this->base != null), function ($query) {
                return $query->whereType($this->base);
            })
            ->when(($this->trx_type != null), function ($query) {
                return $query->whereTrxType($this->trx_type);
            })
            ->orderby($this->sortBy, $this->orderBy);
    }
}
