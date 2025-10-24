<?php

namespace App\Http\Livewire\Admin\Payout;

use Livewire\Component;
use App\Models\Transactions;

class Header extends Component
{
    private $pending;
    private $success;
    private $declined;
    public $type;
    public $admin;

    protected $listeners = ['saved' => '$refresh'];

    public function render()
    {
        $this->pending = Transactions::whereStatus('pending')->whereType('payout')->whereStatus('pending')->count();
        $this->success = Transactions::whereStatus('success')->whereType('payout')->whereStatus('success')->count();
        $this->declined = Transactions::whereStatus('declined')->whereType('payout')->whereStatus('declined')->count();
        return view('livewire.admin.payout.header', [
            'pending' => $this->pending,
            'success' => $this->success,
            'declined' => $this->declined
        ]);
    }
}
