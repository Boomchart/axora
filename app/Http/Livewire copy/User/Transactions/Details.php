<?php

namespace App\Http\Livewire\User\Transactions;

use Livewire\Component;

class Details extends Component
{
    public $val;
    public $user;
    public $settings;

    public function render()
    {
        return view('livewire.user.transactions.details');
    }
}
