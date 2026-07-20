<?php

namespace App\Http\Livewire\Admin\Crypto;

use Livewire\Component;

class Edit extends Component
{
    public $val;
    public $type;

    public function block()
    {
        $this->val->update(['status' => 0]);
        $this->emit('success', __('Currency disabled'));
        $this->emitUp('saved');
    }

    public function unblock()
    {
        $this->val->update(['status' => 1]);
        $this->emit('success', __('Currency enabled'));
        $this->emitUp('saved');
    }

    public function delete()
    {
        $this->val->delete();

        $this->emit('saved');
        $this->emit('closeModal', 'delete' . $this->val->id);
    }

    public function render()
    {
        return view('livewire.admin.crypto.edit');
    }
}
