<?php

namespace App\Http\Livewire\Admin\Home;

use Livewire\Component;
use App\Models\Design;

class Index extends Component
{
    private $ui;
    public function render()
    {
        $this->ui = Design::findOrFail(1);
        return view('livewire.admin.home.index', ['ui' => $this->ui]);
    }
}
