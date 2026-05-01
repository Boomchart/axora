<?php

namespace App\Http\Livewire\Admin\Country;

use Livewire\Component;

class Edit extends Component
{
    public $val;
    public $admin;
    public $settings;


    public function getGiftcardsCountProperty()
    {
        return $this->val->giftcards_count;
    }    
    
    public function getAirtimeProvidersCountProperty()
    {
        return $this->val->airtime_providers_count;
    }    
    
    public function getDataProvidersCountProperty()
    {
        return $this->val->data_providers_count;
    }

    public function delete()
    {
        $this->val->delete();
        $this->emit('saved');
        $this->emit('closeModal', 'delete' . $this->val->id);
    }

    public function block()
    {
        $this->val->update(['status' => 0]);
        $this->emit('saved');
        $this->emit('success', __('Country Disabled'));
    }

    public function activate()
    {
        $this->val->update(['status' => 1]);
        $this->emit('saved');
        $this->emit('success', __('Country Enabled'));
    }

    public function render()
    {
        return view('livewire.admin.country.edit');
    }
}
