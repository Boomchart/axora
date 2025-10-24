<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\UserBank;

class Bank extends Component
{
    public $perPage = 10;
    public $admin;
    public $client;
    public $settings;
    public $search = "";
    public $orderBy = "created_at";
    public $sortBy = "desc";
    private $bank;


    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
    }

    public function render()
    {
        $this->bank = UserBank::whereUserId($this->client->id)
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->Where('acct_no', 'like', '%' . $this->search . '%')
                        ->orWhereRelation('bank', 'title', 'like', '%' . $this->search . '%')
                        ->orWhere('acct_name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);
        return view('livewire.admin.users.bank', ['bank' => $this->bank]);
    }
}
