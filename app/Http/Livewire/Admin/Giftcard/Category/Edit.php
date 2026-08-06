<?php

namespace App\Http\Livewire\Admin\Giftcard\Category;

use Livewire\Component;
use Illuminate\Support\Str;

class Edit extends Component
{
    public $val;
    public $settings;

    public function rules()
    {
        $rules = [
            'val.name' => ['required', 'string', 'max:50'],
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
            'name' => $this->val->name,
            'slug' => Str::slug($this->val->name),
        ]);
        $this->emit('saved');
        $this->emit('success', __('Category updated'));
    }

    public function render()
    {
        return view('livewire.admin.giftcard.category.edit');
    }
}
