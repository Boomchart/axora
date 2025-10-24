<?php

namespace App\Http\Livewire\Admin\Regtype;

use Livewire\Component;

class Edit extends Component
{
    public $val;

    protected $rules = [
        'val.name' => ['required', 'string', 'max:255'],
    ];

    public function delete()
    {
        $this->val->delete();
        $this->emit('saved');
        $this->emit('closeModal', 'delete' . $this->val->id);
    }

    public function update()
    {
        $this->validate();

        $this->val->update([
            'name' =>  $this->val->name,
        ]);

        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('success', __('Item updated'));
    }

    public function render()
    {
        return view('livewire.admin.regtype.edit');
    }
}
