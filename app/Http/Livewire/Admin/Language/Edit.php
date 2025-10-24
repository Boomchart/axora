<?php

namespace App\Http\Livewire\Admin\Language;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use App\Models\Language;

class Edit extends Component
{
    public $admin;
    public $set;
    public $lang;
    public $keys;

    public function update($formData)
    {
        unset($formData['_token']);
        if (json_encode($this->keys) == null) {
            return $this->emit('alert', __('At Least One Field Should Be Fill-up'));
        }
        file_put_contents(resource_path('lang/' . strtolower($this->lang->code)  . '.json'), json_encode($formData));
        $this->emit('success', __('Updated'));
    }

    public function render()
    {
        return view('livewire.admin.language.edit');
    }
}
