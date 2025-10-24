<?php

namespace App\Http\Livewire\Admin\Kyc;

use Livewire\Component;
use App\Models\KycDoc;
use Illuminate\Support\Str;

class Index extends Component
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
    public $items = [];

    protected $listeners = ['saved' => '$refresh'];

    public function mount()
    {
        $this->items[] = ['option' => null];
    }

    public function addItem()
    {
        if (count($this->items) == 50) {
            return $this->emit('alert', __('Max Items exceeded'));
        }
        $this->items[] = ['option' => null];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Reindex array
    }

    public function addKYC($doc)
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'placeholder' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'min' => ['required_if:type,text,number', 'nullable', 'integer'],
            'max' => ['required_if:type,text,number', 'nullable', 'integer', 'gt:min'],
            'required' => ['required', 'integer'],
            'items.*.option' => ['required_if:type,select', 'nullable', 'string', 'max:255'],
        ]);

        $options = [];
        foreach ($this->items as $item) {
            if ($item['option']) {
                $options[] = $item['option'];
            }
        }

        $options = array_unique($options);

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
            'select_options' => json_encode($options),
        ]);
        $this->reset(['title', 'type', 'min', 'max', 'placeholder', 'items']);
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

        $this->kycField = KycDoc::whereRegId($this->reg->id)->whereDoc(0)
            ->when($this->searchField, function ($query) {
                $this->emit('drawer');
                $query->where(function ($query) {
                    $query->Where('title', 'like', '%' . $this->searchField . '%');
                });
            })
            ->when($this->searchField == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->orderby('created_at', 'desc')->get();

        return view('livewire.admin.kyc.index', ['kycDoc' => $this->kycDoc, 'kycField' => $this->kycField]);
    }
}
