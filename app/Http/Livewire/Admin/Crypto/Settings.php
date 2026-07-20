<?php

namespace App\Http\Livewire\Admin\Crypto;

use Livewire\Component;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class Settings extends Component
{
    public $val;
    public $admin;
    public $type;
    public $payout;

    public function mount()
    {
        $this->payout = $this->val->payout;
    }

    public function update()
    {
        $this->validate([
            'payout' => ['nullable'],
        ]);

        $this->val->update([
            'payout' =>  $this->payout,
        ]);

        $this->emit('success', __('Crypto wallet vendor updated'));
    }

    public function render()
    {
        return view('livewire.admin.crypto.settings');
    }
}
