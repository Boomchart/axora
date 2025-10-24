<?php

namespace App\Http\Livewire\Admin\Deposit;

use Livewire\Component;
use App\Models\Transactions;

class Header extends Component
{
    private $pending;
    private $success;
    private $declined;
    public $type;
    public $admin;
    public $settings;

    protected $listeners = ['saved' => '$refresh'];

    public function render()
    {
        $this->pending = Transactions::whereStatus('pending')->whereIn('type', ['bank_transfer', 'deposit'])->whereStatus('pending')->count();
        $this->success = Transactions::whereStatus('success')->whereIn('type', ['bank_transfer', 'deposit'])->whereStatus('success')->count();
        $this->declined = Transactions::whereStatus('declined')->whereIn('type', ['bank_transfer', 'deposit'])->whereStatus('declined')->count();
        return view('livewire.admin.deposit.header', [
            'pending' => $this->pending,
            'success' => $this->success,
            'declined' => $this->declined
        ]);
    }
}
