<?php

namespace App\Http\Livewire\Admin\Blog;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Category as Topic;

class Category extends Component
{
    private $category;
    public $cat_name;
    public $perPage = 10;
    public $orderBy = "created_at";
    public $count = 0;
    public $sortBy = "desc";
    public $search = "";
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
            'cat_name' => ['required', 'string', 'max:50'],
        ]);

        if (Topic::whereType('blog')->whereName($this->cat_name)->count() > 0) {
            return $this->addError('cat_name', __('A category already has this title'));
        } else {
            Topic::create([
                'name' =>  $this->cat_name,
                'slug' => Str::slug($this->cat_name),
                'type' => 'blog'
            ]);
            $this->emit('saved');
            $this->reset(['cat_name']);
            $this->emit('drawer');
        }
    }

    public function render()
    {
        $this->category = Topic::whereType('blog')->when($this->search, function ($query) {
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
        return view('livewire.admin.blog.category', ['category' => $this->category]);
    }
}
