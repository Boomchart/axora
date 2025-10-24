<?php
namespace App\Http\Livewire\Admin\Mcc;

use Livewire\Component;

class Edit extends Component
{
    public $val;
    
    protected $rules = [
        'val.name' => ['required', 'string', 'max:255'],
        'val.mcc_code' => ['required', 'string', 'max:255'],
    ];

    public function delete()
    {
        $this->val->delete();
        $this->emit('saved');
        $this->emit('closeModal', 'delete'.$this->val->id);
    }

    public function update()
    {
        $this->validate();

        $this->val->update([
            'name' =>  $this->val->name,
            'mcc_code' =>  $this->val->mcc_code,
        ]);

        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('success', __('Item updated'));
    }

    public function render()
    {
        return view('livewire.admin.mcc.edit');
    }
}
