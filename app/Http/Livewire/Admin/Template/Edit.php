<?php

namespace App\Http\Livewire\Admin\Template;

use Livewire\Component;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Validator;

class Edit extends Component
{
    public $val;

    public function update($formData)
    {
        preg_match_all('/{{(.*?)}}/', $formData['body'], $matches);
        $filtered = $matches[0];

        Validator::make($formData, [
            'subject' => [($this->val->sms == 0) ? 'required' : 'nullable', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ])->validate();

        foreach($filtered as $tag){
            if(!in_array(trim($tag), explode(',', str_replace(' ', '', $this->val->tags)))){
                return $this->emit('alert', trim($tag).__(' is not an allowed tag'));
            }
        }

        $this->val->update([
            'subject' =>  $formData['subject'],
            'body' =>  $formData['body'],
        ]);

        $this->emit('saved');
        $this->emit('success', __('Template updated'));
    }

    public function render()
    {
        return view('livewire.admin.template.edit');
    }
}
