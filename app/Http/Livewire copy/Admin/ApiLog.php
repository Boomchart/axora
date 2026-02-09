<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ApiLog extends Component
{
    use WithPagination;

    public $perPage = 100;
    public $admin;
    public $search;
    public $mode = "live";
    public $code;
    public $date;
    public $sortBy = "created_at";
    public $orderBy = "desc";

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function render()
    {
        return view('livewire.admin.api-log', [
            'transactions' => $this->pages(),
            'first' => Carbon::now()->sub('1 month')->format('m/d/Y'),
            'last' => Carbon::now()->format('m/d/Y'),
        ]);
    }

    protected function pages()
    {
        $query = DB::table('api_logs')
            ->leftJoin('businesses', 'api_logs.business_id', '=', 'businesses.reference') // assuming FK
            ->select('api_logs.*', 'businesses.name as business_name', 'businesses.id as business_id');

        // Search filter
        if ($this->search) {
            $this->emit('drawer');
            $search = '%' . $this->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('api_logs.ip_address', 'like', $search)
                    ->orWhere('api_logs.url', 'like', $search);
            });
        } else {
            $this->emit('searchdrawer');
        }

        // Date filter
        if ($this->date != null) {
            [$fromRaw, $toRaw] = explode('-', $this->date);
            $from = Carbon::create($fromRaw);
            $to = Carbon::create($toRaw)->addDay(1);

            if ($from != $to) {
                $query->whereBetween('api_logs.created_at', [$from, $to]);
            } else {
                $query->where('api_logs.created_at', '>=', $from);
            }
        } else {
            $query->where('api_logs.created_at', '>', Carbon::now()->subMonths(6)->endOfDay());
        }

        // Mode filter
        if ($this->mode != null) {
            $query->where('api_logs.mode', $this->mode);
        }

        // Status code filter
        if ($this->code != null) {
            $query->where('api_logs.status_code', $this->code);
        }

        // Sorting
        $query->orderBy($this->sortBy, $this->orderBy);

        return $query->simplePaginate($this->perPage);
    }
}
