<?php

namespace App\Http\Livewire\Admin\Mcc;

use Livewire\Component;
use App\Models\Category;

class Index extends Component
{
    private $source;
    public $search = "";
    public $perPage = 50;
    public $orderBy = "name";
    public $sortBy = "asc";
    public $admin;
    public $name;
    public $mcc_code;

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function addPage()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'mcc_code' => ['required', 'string', 'max:255'],
        ]);

        if(Category::whereName($this->name)->whereType('mcc')->whereMccCode('mcc_code')->exists()){
            return $this->emit('alert', __('MCC already added'));
        }

        Category::create([
            'name' =>  $this->name,
            'mcc_code' =>  $this->mcc_code,
            'type' =>  'mcc',
        ]);

        $this->reset(['name', 'mcc_code']);
        $this->emit('saved');
        $this->emit('drawer');
        $this->emit('success', __('Item Created'));
    }

    public function render()
    {
        $this->source = Category::whereType('mcc')
            ->when($this->search, function ($query) {
                $this->emit('drawer');
                $query->where(function ($query) {
                    $query->Where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('mcc_code', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);

        return view('livewire.admin.mcc.index', ['source' => $this->source]);
    }
}
