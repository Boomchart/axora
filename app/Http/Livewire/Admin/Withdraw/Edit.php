<?php

namespace App\Http\Livewire\Admin\Withdraw;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $val;
    public $fc_required;
    public $pc_required;
    public $pct;
    public $image;

    public function rules()
    {
        $rules = [
            'val.name' => ['required', 'string', 'max:255'],
            'val.min' => ['required', 'integer', 'lt:val.max'],
            'val.max' => ['required', 'integer', 'gte:val.min'],
            'val.requirements' => ['required'],
            'val.fc' => [($this->fc_required == 1) ? 'required' : 'nullable', 'numeric'],
            'val.pc' => [($this->pc_required == 1) ? 'required' : 'nullable', 'numeric'],
            'val.pct' => ['required'],
            'val.image' => 'nullable',
        ];

        if ($this->image) {
            $rules = array_merge($rules, [
                'image' => 'required|file|mimes:'.allowedFileTypes().'|max:'.allowedFileSize(),
            ]);
        }
        return $rules;
    }

    public function mount(){
        $this->updatedValPct();
    }

    public function updatedValPct()
    {
        if ($this->pct == 'both') {
            $this->fc_required = 1;
            $this->pc_required = 1;
        } elseif ($this->pct == 'percent') {
            $this->fc_required = 0;
            $this->pc_required = 1;
        } elseif ($this->pct == 'none') {
            $this->fc_required = 0;
            $this->pc_required = 0;
        } else {
            $this->fc_required = 1;
            $this->pc_required = 0;
        }
    }

    public function delete()
    {
        if ($this->val->withdrawTrx->count()) {
            return $this->emit('alert', __('Method can\'t be deleted, users have added this method already, disable this method to prevent new users from seeing it'));
        }
        Storage::delete('withdraw/' . $this->val->image);
        $this->val->delete();
        $this->emit('saved');
        $this->emit('closeModal', 'delete' . $this->val->id);
    }

    public function update()
    {
        $this->validate();

        if ($this->image) {
            $filePath = $this->image->storePublicly('withdraw');
            Storage::delete('withdraw/' . $this->val->image);
            $this->val->update([
                'image' => $filePath,
            ]);
            $this->reset(['image']);
        }

        $this->val->update([
            'name' =>  $this->val->name,
            'min' => $this->val->min,
            'max' => $this->val->max,
            'requirements' => $this->val->requirements,
            'fc' => $this->val->fc,
            'pc' => $this->val->pc,
            'pct' => $this->val->pct,
        ]);

        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('success', __('Updated'));
    }

    public function render()
    {
        return view('livewire.admin.withdraw.edit');
    }
}
