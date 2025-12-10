<?php

namespace App\Http\Livewire\Admin\Helpcenter;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\HelpCenter;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditCategory extends Component
{
    use WithFileUploads;

    public $val;
    public $image;

    public function rules()
    {
        $rules = [
            'val.name' => ['required', 'string', 'max:50'],
            'val.description' => ['required', 'string', 'max:255'],
            'val.image' => 'nullable',
        ];

        if ($this->image) {
            $rules = array_merge($rules, [
                'image' => 'required|file|mimes:'.allowedFileTypes().'|max:'.allowedFileSize(),
            ]);
        }
        return $rules;
    }

    protected $rules = [
        'val.name' => ['required', 'string', 'max:50'],
        'val.description' => ['required', 'string', 'max:255'],
        'val.icon' => ['required', 'string']
    ];

    public function delete()
    {
        if (HelpCenter::wherecatId($this->val->id)->count() > 0) {
            return $this->emit('alert', __('Problem With Deleting Topic, it already used for an existing Faq'));
        } else {
            $this->val->delete();
            $this->emit('saved');
            $this->emit('closeModal', 'delete'.$this->val->id);
        }
    }

    public function update(){
        $this->validate();
        if ($this->image) {
            $filePath = $this->image->storePublicly('help_center');
            Storage::delete('help_center/' . $this->val->image);
            $this->val->update([
                'image' => $filePath,
            ]);
            $this->reset(['image']);
        }
        $this->val->update([
            'name' =>  $this->val->name, 
            'description' =>  $this->val->description, 
            'icon' =>  $this->val->icon, 
            'slug' => Str::slug($this->val->name)
        ]);
        $this->emit('drawer');
        $this->emitUp('saved');
        $this->emit('success', __('Category updated'));

    }

    public function render()
    {
        return view('livewire.admin.helpcenter.edit-category');
    }
}
