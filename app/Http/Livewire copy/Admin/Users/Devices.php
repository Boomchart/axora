<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;

class Devices extends Component
{
    public $perPage = 10;
    public $admin;
    public $client;
    public $settings;
    public $orderBy = "created_at";
    public $sortBy = "desc";

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    protected function pages()
    {
        return \App\Models\Devices::whereUserId($this->client->id)
        ->whereBusinessId($this->client->business_id)->withTrashed()
        ->orderby($this->orderBy, $this->sortBy);
    }

    public function render()
    {
        return view('livewire.admin.users.devices', ['devices' => $this->pages()->paginate($this->perPage)]);
    }
}
