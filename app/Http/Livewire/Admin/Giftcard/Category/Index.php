<?php

namespace App\Http\Livewire\Admin\Giftcard\Category;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Category as Topic;

class Index extends Component
{
    private $category;
    public $name;
    public $description;
    public $perPage = 10;
    public $orderBy = "name";
    public $count = 0;
    public $sortBy = "asc";
    public $search;
    public $settings;

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function addCategory()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
        ]);

        if (Topic::whereType('giftcard_buy')->whereName($this->name)->count() > 0) {
            return $this->addError('name', __('A category already has this title'));
        } else {
            Topic::create([
                'name' =>  $this->name,
                'description' =>  $this->description,
                'slug' => Str::slug($this->name),
                'type' => 'giftcard_buy',
                'icon' => $this->icon,
            ]);
            $this->emit('saved');
            $this->reset(['name', 'description']);
            $this->emit('drawer');
            $this->emit('success', __('Category added'));
        }
    }

    public function render()
    {
        $this->category = Topic::whereType('giftcard_buy')
            ->when($this->search, function ($query) {
                $this->emit('drawer');
                return $query->Where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);
        return view('livewire.admin.giftcard.category.index', ['category' => $this->category]);
    }
}
