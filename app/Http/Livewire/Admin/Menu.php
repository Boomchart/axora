<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Menu extends Component
{
    public $admin;
    public $settings;

    protected $listeners = ['refreshMenu' => '$refresh'];

    public function render()
    {
        return view('livewire.admin.menu');
    }
}
