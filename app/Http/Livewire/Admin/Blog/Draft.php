<?php

namespace App\Http\Livewire\Admin\Blog;

use Livewire\Component;
use App\Models\Blog;
use App\Models\Category;

class Draft extends Component
{
    private $articles;
    private $categoryAll;
    public $search = "";
    public $category = "";
    public $perPage = 10;
    public $orderBy = "created_at";
    public $sortBy = "desc";
    public $admin;
    public $settings;

    protected $listeners = ['saved' => '$refresh'];

    public function render()
    {
        $this->articles = Blog::whereStatus(0)
            ->when($this->search, function ($query) {
                $this->emit('drawer');
                $query->where(function ($query) {
                    $query->Where('title', 'like', '%' . $this->search . '%')
                        ->orWhereRelation('category', 'name', 'like', '%' . $this->search . '%')
                        ->orWhere('details', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->when($this->category, function ($query) {
                return $query->whereCatId($this->category);
            })
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);
            $this->categoryAll = Category::whereType('blog')->get();
        return view('livewire.admin.blog.draft', ['articles' => $this->articles, 'categoryAll' => $this->categoryAll, 'admin' => $this->admin]);
    }
}
