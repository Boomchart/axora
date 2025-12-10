<?php

namespace App\Http\Livewire\Admin\Blog;

use Livewire\Component;
use Illuminate\Support\Str;

class EditCategory extends Component
{
    public $val;
    public $settings;

    protected $rules = [
        'val.name' => ['required', 'string', 'max:50'],
    ];

    public function delete()
    {
        $this->val->delete();
        $this->emit('saved');
        $this->emit('closeModal', 'delete'.$this->val->id);
    }

    public function update(){
        $this->validate();
        $this->val->update([
            'name' => $this->val->name,
            'slug' => Str::slug($this->val->name)
        ]);
        $this->emit('saved');
        $this->emit('success', __('Category updated'));

    }

    public function render()
    {
        return view('livewire.admin.blog.edit-category');
    }
}
