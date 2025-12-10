<?php

namespace App\Http\Livewire\Admin\Payout;

use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminTransactionExport;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use App\Models\Transactions;

class Index extends Component
{
    public $perPage = 200;
    public $admin;
    public $set;
    public $search = "";
    public $base;
    public $exportType;
    public $exportAs;
    public $date;
    public $sortBy = "created_at";
    public $orderBy = "desc";

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + 10;
        $this->emit('drawer');
    }

    public function save()
    {
        $query = [
            'mode' => 'live',
            'status' => $this->base,
            'date' => $this->date,
            'type' => 'payout',
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
        return view('livewire.admin.payout.index', [
            'transactions' => $page->paginate($this->perPage),
            'first' => ($page->count() > 0) ? date("m/d/Y", strtotime($page->reorder()->oldest()->first()->created_at)) : date("m/d/Y", strtotime(Carbon::now())),
            'last' => ($page->count() > 0) ? date("m/d/Y", strtotime($page->reorder()->latest()->first()->created_at)) : date("m/d/Y", strtotime(Carbon::now())),
        ]);
    }

    protected function pages()
    {
        return Transactions::with(['user', 'business', 'staff'])
            ->whereType('payout')->whereStatus($this->base)
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
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
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
            ->orderby($this->sortBy, $this->orderBy);
    }
}
