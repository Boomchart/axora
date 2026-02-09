<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;

class Ticket extends Component
{
    public $perPage = 10;
    public $admin;
    public $client;
    public $settings;
    public $search = "";
    public $status = "";
    public $priority = "";
    public $orderBy = "created_at";
    public $sortBy = "desc";
    private $ticket;

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function render()
    {
        $this->ticket = \App\Models\Ticket::whereUserId($this->client->id)
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->Where('subject', 'like', '%' . $this->search . '%')
                        ->orWhere('priority', 'like', '%' . $this->search . '%')
                        ->orWhere('ticket_id', 'like', '%' . $this->search . '%')
                        ->orWhere('message', 'like', '%' . $this->search . '%');
                });
            })
            ->when(($this->status != null), function ($query) {
                return $query->whereStatus($this->status);
            })
            ->when(($this->priority != null), function ($query) {
                return $query->wherepriority($this->priority);
            })->withTrashed()
            ->orderby('status', 'desc')
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);
        return view('livewire.admin.users.ticket', ['ticket' => $this->ticket]);
    }
}
