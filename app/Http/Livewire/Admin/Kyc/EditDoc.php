<?php

namespace App\Http\Livewire\Admin\Kyc;

use Livewire\Component;
use Illuminate\Support\Str;

class EditDoc extends Component
{
    public $val;

    public function rules()
    {
        $rules = [
            'val.title' => ['required', 'string', 'max:255'],
        ];
        return $rules;
    }

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
            'title' =>  $this->val->title,
            'slug' =>  Str::slug($this->val->title),
        ]);

        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('success', __('Kyc Doc updated'));
    }

    public function render()
    {
        return view('livewire.admin.kyc.edit-doc');
    }
}
