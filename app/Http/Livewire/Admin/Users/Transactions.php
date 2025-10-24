<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminTransactionExport;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use App\Models\Transactions as TRX;

class Transactions extends Component
{
    public $perPage = 200;
    public $client;
    public $search;
    public $status;
    public $mode = 'live';
    public $base;
    public $trx_type;
    public $exportType;
    public $exportAs;
    public $date;
    public $admin;
    public $sortBy = "created_at";
    public $orderBy = "desc";

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function save()
    {
        $query = [
            'mode' => $this->mode,
            'business_id' => $this->client->business_id,
            'status' => $this->status,
            'date' => $this->date,
            'type' => $this->base,
            'trx_type' => $this->trx_type,
            'user_timezone' => $this->admin->timezone ?? 'UTC',
        ];

        $filename = now() . '-transactions.xlsx';
        Excel::queue(new AdminTransactionExport($query), $filename)
            ->chain([
                new SendEmail(
                    $this->admin->email,
                    $this->admin->username,
                    __('Transaction Statement'),
                    __('Transaction Statement exported'),
                    storage_path('app/' . $filename),
                )
            ]);

        $this->emit('success', __('Transaction Statement will be sent to your email'));
    }

    public function render()
    {
        $page = $this->pages();
        return view('livewire.admin.users.transactions', [
            'transactions' => $page->simplePaginate($this->perPage),
            'total' => $page->count(),
            'first' => Carbon::now()->sub('1 month')->format('m/d/Y'),
            'last' => Carbon::now()->format('m/d/Y'),
        ]);
    }

    protected function pages()
    {
        return TRX::with(['user', 'business'])
            ->whereUserId($this->client->id)->withTrashed()
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
            ->whereMode('live')
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
            }, function ($query) {
                return $query->where('created_at', '>', Carbon::now()->subMonths(6)->endOfDay());
            })
            ->when(($this->base != null), function ($query) {
                return $query->whereType($this->base);
            })
            ->when(($this->trx_type != null), function ($query) {
                return $query->whereTrxType($this->trx_type);
            })
            ->when(($this->mode != null), function ($query) {
                return $query->whereMode($this->mode);
            })
            ->orderby($this->sortBy, $this->orderBy);
    }
}
