<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\Beneficiary;

class Beneficiaries extends Component
{
    public $perPage = 10;
    public $admin;
    public $client;
    public $settings;
    public $search = "";
    public $orderBy = "created_at";
    public $sortBy = "desc";
    private $beneficiary;


    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
    }

    public function render()
    {
        $this->beneficiary = Beneficiary::whereUserId($this->client->id)
        ->when($this->search, function ($query) {
            $query->where(function ($query) {
                $query->Where('merchant_id', 'like', '%' . $this->search . '%')
                    ->orWhereRelation('recipient', 'first_name', 'like', '%' . $this->search . '%')
                    ->orWhereRelation('recipient', 'last_name', 'like', '%' . $this->search . '%');
            });
        })
        ->orderby($this->orderBy, $this->sortBy)
        ->paginate($this->perPage);
        return view('livewire.admin.users.beneficiaries', ['beneficiary' => $this->beneficiary]);
    }
}
