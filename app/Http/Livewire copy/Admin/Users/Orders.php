<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminOrderExport;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use App\Models\CardIssued;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public $perPage = 200;
    public $client;
    public $search;
    public $status;
    public $mode = "live";
    public $exportType;
    public $exportAs;
    public $date;
    public $sortBy = "created_at";
    public $orderBy = "desc";
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
            'status' => $this->status,
            'business_id' => $this->client->business_id,
            'date' => $this->date,
            'mode' => $this->mode,
            'user_timezone' => $this->admin->timezone ?? 'UTC',
        ];

        $filename = now() . '-orders.xlsx';
        Excel::queue(new AdminOrderExport($query), $filename)
            ->chain([
                new SendEmail(
                    $this->admin->email,
                    $this->admin->username,
                    __('Card Orders'),
                    __('Orders exported'),
                    storage_path('app/' . $filename),
                )
            ]);

        $this->emit('success', __('Card Orders will be sent to your email'));
    }

    public function render()
    {
        $page = $this->pages();
        return view('livewire.admin.users.orders', [
            'transactions' => $page->simplePaginate($this->perPage),
            'total' => $page->count(),
            'first' => Carbon::now()->sub('1 month')->format('m/d/Y'),
            'last' => Carbon::now()->format('m/d/Y'),
        ]);
    }

    protected function pages()
    {
        return CardIssued::with(['user', 'business', 'transaction'])
            ->whereUserId($this->client->id)->withTrashed()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('amount', 'like', '%' . $this->search . '%')
                        ->orWhere('name', 'like', '%' . $this->search . '%')
                        ->orWhere('card_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%')
                        ->orWhere('id', 'like', '%' . $this->search . '%');
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
            }, function ($query) {
                return $query->where('created_at', '>', Carbon::now()->subMonths(6)->endOfDay());
            })
            ->when(($this->mode != null), function ($query) {
                return $query->whereMode($this->mode);
            })
            ->orderby($this->sortBy, $this->orderBy);
    }
}
