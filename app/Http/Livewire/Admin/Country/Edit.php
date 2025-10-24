<?php

namespace App\Http\Livewire\Admin\Country;

use Livewire\Component;

class Edit extends Component
{
    public $val;
    public $settings;

    public function delete()
    {
        $this->val->delete();
        $this->emit('saved');
        $this->emit('closeModal', 'delete' . $this->val->id);
    }

    public function render()
    {
        return view('livewire.admin.country.edit');
    }
}
