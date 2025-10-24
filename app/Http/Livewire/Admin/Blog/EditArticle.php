<?php

namespace App\Http\Livewire\Admin\Blog;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Category;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditArticle extends Component
{
    use WithFileUploads;
    public $val;
    public $image;
    public $admin;
    private $categoryAll;
    public $settings;

    public function rules()
    {
        $rules = [
            'val.status' => ['required'],
            'val.cat_id' => ['required'],
            'val.title' => ['required', 'string', 'max:255'],
            'val.details' => ['required', 'string'],
            'val.image' => 'nullable',
        ];
        if ($this->image) {
            $rules = array_merge($rules, [
                'image' => 'required|file|mimes:'.allowedFileTypes().'|max:'.allowedFileSize(),
            ]);
        }
        return $rules;
    }

    public function delete()
    {
        $this->val->delete();
        $this->emit('saved');
        $this->emit('closeModal', 'delete' . $this->val->id);
    }

    public function forceDelete()
    {
        Storage::delete('blog/' . $this->val->image);
        $this->val->forceDelete();
        $this->emit('closeModal', 'delete' . $this->val->id);
        $this->emit('saved');
        $this->emit('success', __('Article Permanently Deleted'));
    }

    public function update()
    {
        $this->validate();
        if ($this->image) {
            $filePath = $this->image->storePublicly('blog');
            Storage::delete('blog/' . $this->val->image);
            $this->val->update([
                'image' => $filePath,
            ]);
            $this->reset(['image']);
        }

        $this->val->update([
            'title' =>  $this->val->title,
            'details' =>  $this->val->details,
            'cat_id' =>  $this->val->cat_id,
            'status' =>  $this->val->status,
            'slug' => Str::slug($this->val->title),
            'edited_by' => $this->admin->id,
        ]);
        if ($this->val->status == 0) {
            $this->emit('drawer');
        }
        $this->emit('saved');
        $this->emit('success', __('Article updated'));
    }

    public function render()
    {
        $this->categoryAll = Category::whereType('blog')->get();
        return view('livewire.admin.blog.edit-article', ['categoryAll' => $this->categoryAll]);
    }
}
