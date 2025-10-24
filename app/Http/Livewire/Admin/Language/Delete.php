<?php

namespace App\Http\Livewire\Admin\Language;

use Livewire\Component;

class Delete extends Component
{
    public $val;

    public function delete()
    {
        $this->val->delete();
        $this->emit('saved');
        $this->emit('closeModal', 'delete'.$this->val->id);
    }

    public function render()
    {
        return view('livewire.admin.language.delete');
    }
}
