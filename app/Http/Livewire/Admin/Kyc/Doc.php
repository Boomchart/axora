<?php

namespace App\Http\Livewire\Admin\Kyc;

use Livewire\Component;
use App\Models\KycDoc;
use Illuminate\Support\Str;

class Doc extends Component
{

    private $kycDoc;
    private $kycField;
    public $search = "";
    public $searchField = "";
    public $category = "";
    public $perPage = 10;
    public $orderBy = "created_at";
    public $sortBy = "desc";
    public $admin;
    public $title;
    public $min;
    public $max;
    public $type;
    public $reg;
    public $doc;
    public $placeholder;
    public $required;

    protected $listeners = ['saved' => '$refresh'];

    public function addKYC($doc)
    {

        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'placeholder' => [($doc == 0) ? 'required' : 'nullable', 'string', 'max:255'],
            'type' => [($doc == 0) ? 'required' : 'nullable', 'string', 'max:255'],
            'min' => [($doc == 0) ? 'required' : 'nullable', 'integer'],
            'max' => [($doc == 0) ? 'required' : 'nullable', 'integer', 'gt:min'],
            'required' => [($doc == 0) ? 'required' : 'nullable', 'integer'],
        ]);

        KycDoc::create([
            'title' =>  $this->title,
            'slug' =>  Str::slug($this->title),
            'placeholder' =>  $this->placeholder,
            'type' =>  $this->type,
            'min' => $this->min,
            'max' => $this->max,
            'reg_id' => $this->reg->id,
            'doc' => $doc,
            'required' => $this->required,
        ]);
        $this->reset(['title', 'type', 'min', 'max', 'placeholder']);
        $this->emit('saved');
        $this->emit('drawer');
        $this->emit('success', __('KYC Created'));
    }

    public function disable(KycDoc $kyc)
    {
        $kyc->update(['status' => 0]);
        $this->emit('success', __('KYC disabled'));
        $this->emitUp('saved');
    }

    public function enable(KycDoc $kyc)
    {
        $kyc->update(['status' => 1]);
        $this->emit('success', __('KYCenabled'));
        $this->emitUp('saved');
    }

    public function render()
    {
        $this->kycDoc = KycDoc::whereRegId($this->reg->id)->whereDoc(1)
            ->when($this->search, function ($query) {
                $this->emit('drawer');
                $query->where(function ($query) {
                    $query->Where('title', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->orderby('created_at', 'desc')->get();
        return view('livewire.admin.kyc.doc', ['kycDoc' => $this->kycDoc]);
    }
}
