<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\Admin;
use App\Models\Settings;
use App\Models\Transactions;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class Details extends Component
{
    public $client;
    public $admin;

    protected $listeners = ['saved' => '$refresh'];

    public function render()
    {
        return view('livewire.admin.users.details');
    }
}
