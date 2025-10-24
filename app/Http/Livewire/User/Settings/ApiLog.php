<?php

namespace App\Http\Livewire\User\Settings;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\ApiLogs as Transactions;
use Livewire\WithPagination;

class ApiLog extends Component
{
    use WithPagination;

    public $perPage = 100;
    public $user;
    public $search;
    public $mode;
    public $date;
    public $sortBy = "created_at";
    public $orderBy = "desc";
    public $code;

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function render()
    {
        $page = $this->pages();
        return view('livewire.user.settings.api-log', [
            'total' => $page->count(),
            'transactions' => $page->simplePaginate($this->perPage),
            'first' => Carbon::now()->sub('1 month')->format('m/d/Y'),
            'last' => Carbon::now()->format('m/d/Y'),
        ]);
    }

    protected function pages()
    {
        return Transactions::with(['business'])
            ->whereBusinessId($this->user->business_id)
            ->when($this->search, function ($query) {
                $this->emit('drawer');
                $query->where(function ($query) {
                    $query->Where('ip_address', 'like', '%' . $this->search . '%')
                        ->orWhere('url', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->when(($this->date != null), function ($query) {
                $from = Carbon::create(explode('-', $this->date)[0]);
                $to = Carbon::create(explode('-', $this->date)[1])->addDay(1);
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
            ->when(($this->code != null), function ($query) {
                return $query->whereStatusCode($this->code);
            })
            ->orderby($this->sortBy, $this->orderBy);
    }
}
