<?php

namespace App\Http\Livewire\Admin\Gateway;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $val;
    public $showCrypto;
    public $crypto;
    public $image;

    protected function rules()
    {

        $rules = [
            'val.name' => ['required', 'string', 'max:255'],
            'val.minamo' => ['required', 'integer', 'lt:val.maxamo'],
            'val.maxamo' => ['required', 'integer', 'gte:val.minamo'],
            'val.status' => ['required'],
            'val.fiat_charge' => ['required', 'numeric'],
            'val.percent_charge' => ['required', 'numeric'],
            'val.instructions' => [($this->val->type == 1) ? 'required' : 'nullable'],
            'crypto' => [($this->val->type == 1) ? 'required' : 'nullable'],
            'val.val1' => ['required'],
            'val.val2' => [($this->val->crypto == 1) ? 'required' : 'nullable'],
            'val.image' => 'nullable',
        ];

        if ($this->image) {
            $rules = array_merge($rules, [
                'image' => 'required|file|mimes:'.allowedFileTypes().'|max:'.allowedFileSize(),
            ]);
        }
        return $rules;
    }
    

    public function updatedCrypto()
    {
        if ($this->crypto == 1) {
            $this->showCrypto = 1;
        } else {
            $this->showCrypto = 0;
        }
    }

    public function mount()
    {
        $this->crypto = $this->val->crypto;
        if ($this->val->type == 1) {
            $this->showCrypto = $this->val->crypto;
        }
    }

    public function delete()
    {
        Storage::delete('gateway/'.$this->val->image);
        $this->val->delete();
        $this->emit('saved');
        $this->emit('closeModal', 'delete' . $this->val->id);
    }

    public function update()
    {
        $this->validate();

        if ($this->image) {
            $filePath = $this->image->storePublicly('brand');
            Storage::delete('brand/'.$this->val->image);
            $this->val->update([
                'image' => $filePath,
            ]);
            $this->reset(['image']);
        }
        
        $this->val->update([
            'name' => $this->val->name,
            'minamo' => $this->val->minamo,
            'maxamo' => $this->val->maxamo,
            'fiat_charge' => $this->val->fiat_charge,
            'percent_charge' => $this->val->percent_charge,
            'val1' => $this->val->val1,
            'val2' => $this->val->val2,
            'instructions' => $this->val->instructions,
            'crypto' => $this->crypto,
            'status' => $this->val->status,
            'receipt' => $this->val->receipt,
        ]);

        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('success', __('Gateway updated'));
    }

    public function render()
    {
        return view('livewire.admin.gateway.edit');
    }
}
