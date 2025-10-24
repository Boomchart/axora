<?php

namespace App\Http\Livewire\User\Directors;

use Livewire\Component;

class Delete extends Component
{
    public $val;
    public $user;

    public function delete()
    {
        $this->val->delete();
        $this->emit('saved');
        $this->emit('closeModal', 'delete'.$this->val->id);
    }

    public function render()
    {
        return view('livewire.user.directors.delete');
    }
}
