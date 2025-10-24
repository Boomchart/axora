<?php

namespace App\Http\Livewire\Admin\Regtype;

use Livewire\Component;
use App\Models\Category;
use App\Models\KycDoc;

class Index extends Component
{
    private $source;
    public $search = "";
    public $perPage = 50;
    public $orderBy = "name";
    public $sortBy = "asc";
    public $admin;
    public $name;

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function duplicate(Category $category)
    {
        $data = $category->replicate()->fill([
            'name' =>  $category->name . ' ' . __('copy'),
        ]);

        $data->save();

        if (KycDoc::whereRegId($category->id)->count()) {
            foreach (KycDoc::whereRegId($category->id)->get() as $kyc) {
                $newData = $kyc->replicate()->fill([
                    'reg_id' => $data->id,
                ]);
                $newData->save();
            }
            $this->emit('success', __('KYC DOC updated'));
        }

        $this->emit('success', __('Business Registration Type created'));
    }

    public function addPage()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        if (Category::whereName($this->name)->whereType('regtype')->exists()) {
            return $this->emit('alert', __('Registration Type already added'));
        }

        Category::create([
            'name' =>  $this->name,
            'type' =>  'regtype',
        ]);

        $this->reset(['name']);
        $this->emit('saved');
        $this->emit('drawer');
        $this->emit('success', __('Item Created'));
    }

    public function render()
    {
        $this->source = Category::whereType('regtype')
            ->when($this->search, function ($query) {
                $this->emit('drawer');
                $query->where(function ($query) {
                    $query->Where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);

        return view('livewire.admin.regtype.index', ['source' => $this->source]);
    }
}
