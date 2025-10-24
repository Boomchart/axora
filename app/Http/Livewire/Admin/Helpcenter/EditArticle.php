<?php

namespace App\Http\Livewire\Admin\Helpcenter;

use Livewire\Component;
use Illuminate\Support\Str;

class EditArticle extends Component
{
    public $val;
    public $topics;

    protected $rules = [
        'val.question' => ['required', 'string'],
        'val.answer' => ['required', 'string'],
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
            'question' =>  $this->val->question, 
            'answer' =>  $this->val->answer, 
            'slug' => Str::slug($this->val->question)
        ]);
        $this->emit('drawer');
        $this->emitUp('saved');
        $this->emit('success', __('Article updated'));

    }

    public function render()
    {
        return view('livewire.admin.helpcenter.edit-article');
    }
}
