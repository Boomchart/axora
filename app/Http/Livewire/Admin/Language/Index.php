<?php

namespace App\Http\Livewire\Admin\Language;

use Livewire\Component;
use App\Models\Language;
use Illuminate\Support\Facades\Artisan;

class Index extends Component
{
    private $language;
    public $name;
    public $iso2;

    protected $listeners = ['saved' => '$refresh'];

    public function download(Language $lang)
    {
        $file = base_path().'/resources/lang/'.$lang->code.'.json';
        return response()->download($file);
    }


    public function block(Language $lang){
        $lang->update(['status' => 0]);
        $this->emit('success', __('Language blocked'));
    }
    
    public function unblock(Language $lang){
        $lang->update(['status' => 1]);
        $this->emit('success', __('Language unblocked'));
    }

    public function delete(Language $lang)
    {
        @unlink(resource_path('lang/' . $lang->code . '.json'));
        $lang->delete();
        return $this->emit('success', __('Language deleted'));
    }

    public function addLanguage()
    {
        $this->validate([
            'name' => ['required', 'string'],
            'iso2' => ['required', 'string'],
        ]);
        $lang = explode("*", $this->name);
        if (Language::whereCode($lang[0])->count() == 1) {
            return $this->emit('alert', __('Already Added'));
        } else {
            Artisan::call('translatable:export '.strtolower($lang[0]));
            Language::create([
                'name' => $lang[1], 
                'code' => $lang[0], 
                'iso2' => $this->iso2, 
                'status' => 0
            ]);
            $this->reset(['name']);
            return $this->emit('drawer');
            $this->emit('success', __('Language created'));
        }
    }

    public function render()
    {
        $this->language = Language::all();
        return view('livewire.admin.language.index', ['language' => $this->language]);
    }
}
