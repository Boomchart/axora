<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Filetypes extends Component
{
    public $settings;
    public $files_allowed;
    public $images_allowed;
    public $file_upload_size;

    public function mount()
    {
        $this->files_allowed = $this->settings->files_allowed;
        $this->images_allowed = $this->settings->images_allowed;
        $this->file_upload_size = $this->settings->file_upload_size;
    }

    public function filetypeUpdate()
    {
        $this->validate([
            'files_allowed' => ['required'],
            'images_allowed' => ['required'],
            'file_upload_size' => ['required'],
        ]);

        foreach (explode(',', formatTag($this->files_allowed)) as $file) {
            if (!in_array($file, array_keys(config('mimes')))) {
                return $this->addError('files_allowed', $file.' '.__('is an invalid file type'));
            }
        }

        foreach (explode(',', formatTag($this->images_allowed)) as $file) {
            if (!in_array($file, array_keys(config('mimes')))) {
                return $this->addError('images_allowed', $file.' '.__('is an invalid file type'));
            }
        }

        $this->settings->update([
            'files_allowed' => $this->files_allowed,
            'images_allowed' => $this->images_allowed,
            'file_upload_size' => $this->file_upload_size,
        ]);
        $this->emit('saved');
        $this->emit('success', __('Settings updated'));
    }

    public function render()
    {
        return view('livewire.admin.filetypes');
    }
}
