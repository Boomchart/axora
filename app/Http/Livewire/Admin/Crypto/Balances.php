<?php

namespace App\Http\Livewire\Admin\Crypto;

use Livewire\Component;
use App\Models\CryptoBalance;

class Balances extends Component
{
    public $val;
    public $admin;
    public $type;
    private $balances;
    public $perPage = 100;
    public $search;
    public $orderBy = "amount";
    public $sortBy = "desc";

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function render()
    {
        $this->balances = CryptoBalance::whereCountryId($this->val->id)
            ->whereMode('live')
            ->with(['business'])
            ->withTrashed()
            ->when($this->search, function ($query) {
                $this->emit('drawer');
                $query->where(function ($query) {
                    $query->Where('amount', 'like', '%' . $this->search . '%')
                        ->orWhere('vendor', 'like', '%' . $this->search . '%')
                        ->orWhereRelation('business', 'name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);

        return view('livewire.admin.crypto.balances', ['balances' => $this->balances]);
    }
}
