<?php

namespace App\Http\Livewire\Admin\Ticket;

use Livewire\Component;
use App\Models\Ticket;
use Illuminate\Support\Str;

class Header extends Component
{
    private $open;
    private $closed;
    public $type;

    protected $listeners = ['saved' => '$refresh'];

    public function render()
    {
        $this->open = Ticket::whereStatus(0)->get()->count();
        $this->closed = Ticket::whereStatus(1)->get()->count();
        return view('livewire.admin.ticket.header', [
            'open' => $this->open,
            'closed' => $this->closed,
        ]);
    }
}
