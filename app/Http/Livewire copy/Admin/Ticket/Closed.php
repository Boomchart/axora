<?php

namespace App\Http\Livewire\Admin\Ticket;

use Livewire\Component;
use App\Models\Ticket;

class Closed extends Component
{
    public $perPage = 100;
    public $admin;
    public $settings;
    public $search = "";
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
        $this->ticket = Ticket::with(['user', 'business', 'reply'])->whereStatus(1)
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->Where('subject', 'like', '%' . $this->search . '%')
                        ->orWhere('priority', 'like', '%' . $this->search . '%')
                        ->orWhere('ticket_id', 'like', '%' . $this->search . '%')
                        ->orWhere('message', 'like', '%' . $this->search . '%');
                });
            })
            ->when(($this->priority != null), function ($query) {
                return $query->wherepriority($this->priority);
            })
            ->orderby('status', 'desc')
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);
        return view('livewire.admin.ticket.closed', ['ticket' => $this->ticket]);
    }
}
