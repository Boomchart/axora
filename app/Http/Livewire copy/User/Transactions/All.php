<?php

namespace App\Http\Livewire\User\Transactions;

use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Jobs\SendEmail;
use App\Models\Transactions;
use Livewire\WithPagination;

class All extends Component
{
    use WithPagination;

    public $perPage = 100;
    public $user;
    public $search;
    public $status;
    public $mode = 'live';
    public $type;
    public $trx_type;
    public $exportType;
    public $exportAs;
    public $date;
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
            'business_id' => $this->user->business_id,
            'status' => $this->status,
            'date' => $this->date,
            'type' => $this->type,
            'trx_type' => $this->trx_type,
            'user_timezone' => $this->user->user_timezone ?? 'UTC',
        ];

        $filename = now() . '-transactions.xlsx';
        Excel::queue(new TransactionExport($query, $this->user), $filename)
            ->chain([
                new SendEmail(
                    $this->user->email,
                    $this->user->first_name . ' ' . $this->user->last_name,
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
        return view('livewire.user.transactions.all', [
            'transactions' => $page->simplePaginate($this->perPage),
            'total' => $page->count(),
            'first' => Carbon::now()->sub('1 month')->format('m/d/Y'),
            'last' => Carbon::now()->format('m/d/Y'),
        ]);
    }

    protected function pages()
    {
        return Transactions::with(['user', 'business'])
            ->whereUserId($this->user->id)
            ->whereBusinessId($this->user->business_id)
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
                $from = Carbon::create(explode('-', $this->date)[0])->setTimezone($this->user->user_timezone);
                $to = Carbon::create(explode('-', $this->date)[1])->setTimezone($this->user->user_timezone)->addDay(1);
                if ($from != $to) {
                    return $query->whereBetween('created_at', [$from, $to]);
                } else {
                    return $query->where('created_at', '>=', $from);
                }
            }, function ($query) {
                return $query->where('created_at', '>', Carbon::now()->subMonths(6)->endOfDay());
            })
            ->when(($this->type != null), function ($query) {
                return $query->whereType($this->type);
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
