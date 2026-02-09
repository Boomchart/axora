<?php

namespace App\Http\Livewire\Admin\Kyc;

use Livewire\Component;
use Illuminate\Support\Str;

class Edit extends Component
{
    public $val;
    public $items;

    public function getData()
    {
        if (!empty((json_decode($this->val->select_options)))) {
            foreach (json_decode($this->val->select_options) as $key => $item) {
                $data[] = [
                    'option' => $item
                ];
            }
        } else {
            $data[] = [
                'option' => null
            ];
        }

        return $data;
    }

    public function mount()
    {
        $this->items = $this->getData();
    }

    public function addItem()
    {
        if (count($this->items) == 5) {
            return $this->emit('alert', __('Max Emails exceeded'));
        }
        $this->items[] = ['email' => null];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Reindex array
    }


    public function rules()
    {
        $rules = [
            'val.title' => ['required', 'string', 'max:255'],
        ];

        $rules = array_merge($rules, [
            'val.required' => ['required', 'integer'],
            'val.placeholder' => ['required', 'string', 'max:255'],
            'val.type' => ['required', 'string', 'max:255'],
            'val.min' => ['required_if:val.type,text,number', 'nullable', 'integer'],
            'val.max' => ['required_if:val.type,text,number', 'nullable', 'integer', 'gt:min'],
            'items.*.option' => ['required_if:val.type,select', 'nullable', 'string', 'max:255'],
        ]);

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

        $options = [];
        foreach ($this->items as $item) {
            if ($item['option']) {
                $options[] = $item['option'];
            }
        }

        $options = array_unique($options);

        $this->val->update([
            'title' =>  $this->val->title,
            'slug' =>  Str::slug($this->val->title),
            'placeholder' =>  $this->val->placeholder,
            'type' =>  $this->val->type,
            'min' =>  $this->val->min,
            'max' =>  $this->val->max,
            'required' =>  $this->val->required,
            'select_options' => json_encode($options),
        ]);

        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('success', __('Kyc Doc updated'));
    }

    public function render()
    {
        return view('livewire.admin.kyc.edit');
    }
}
