<?php

namespace App\Http\Livewire\Admin\Deposit;

use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminTransactionExport;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use App\Models\Transactions;

class Index extends Component
{
    public $perPage = 10;
    public $admin;
    public $set;
    public $search;
    public $base;
    public $type;
    public $date;
    public $sortBy = "created_at";
    public $orderBy = "desc";
    public $settings;

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
            'status' => $this->base,
            'date' => $this->date,
            'type' => 'deposit',
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
        return view('livewire.admin.deposit.index', [
            'transactions' => $page->paginate($this->perPage),
            'total' => $page->count(),
            'first' => Carbon::now()->sub('1 month')->format('m/d/Y'),
            'last' => Carbon::now()->format('m/d/Y'),
        ]);
    }

    protected function pages()
    {
        return Transactions::with(['user', 'business'])
            ->whereStatus($this->base)
            ->whereIn('type', ['bank_transfer', 'deposit'])
            ->when($this->search, function ($query) {
                $this->emit('drawer');
                $query->where(function ($query) {
                    $query->where('amount', 'like', '%' . $this->search . '%')
                        ->orWhere('charge', 'like', '%' . $this->search . '%')
                        ->orWhere('ref_id', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhereRelation('user', 'first_name', 'like', '%' . $this->search . '%')
                        ->orWhereRelation('user', 'last_name', 'like', '%' . $this->search . '%');
                });
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
            ->when(($this->type != null), function ($query) {
                if ($this->type == 'bank_transfer') {
                    return $query->whereType('bank_transfer');
                } else {
                    return $query->whereRelation('gateway', 'id', '=', $this->type);
                }
            })
            ->orderby($this->sortBy, $this->orderBy);
    }
}
