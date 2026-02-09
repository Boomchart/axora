<?php

namespace App\Http\Livewire\Admin\Blog;

use Livewire\Component;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Header extends Component
{

    use WithFileUploads;

    private $articles;
    private $draft;
    private $deleted;
    private $category;
    private $categoryAll;
    public $selectCategory;
    public $type;
    public $admin;
    public $status = 0;
    public $title;
    public $details = "";
    public $image;
    public $settings;

    protected $listeners = ['saved' => '$refresh'];

    public function addArticle()
    {

        $this->validate([
            'status' => ['required'],
            'selectCategory' => ['required'],
            'title' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string'],
            'image' => 'required|file|mimes:'.allowedFileTypes().'|max:'.allowedFileSize(),
        ]);

        $filePath = $this->image->storePublicly('blog');

        Blog::create([
            'title' =>  $this->title,
            'details' =>  $this->details,
            'cat_id' =>  $this->selectCategory,
            'status' =>  $this->status,
            'slug' => Str::slug($this->title),
            'image' => $filePath,
            'created_by' => $this->admin->id,
            'edited_by' => $this->admin->id,
        ]);
        $this->reset(['title', 'details', 'selectCategory', 'status', 'image']);
        $this->emit('saved');
        $this->emit('drawer');
        $this->emit('success', __('Article Created'));
    }

    public function render()
    {
        $this->articles = Blog::whereStatus(1)->get()->count();
        $this->category = Category::whereType('blog')->get()->count();
        $this->categoryAll = Category::whereType('blog')->get();
        $this->deleted = Blog::onlyTrashed()->count();
        $this->draft = Blog::whereStatus(0)->get()->count();
        return view('livewire.admin.blog.header', [
            'articles' => $this->articles,
            'category' => $this->category,
            'categoryAll' => $this->categoryAll,
            'draft' => $this->draft,
            'deleted' => $this->deleted,
        ]);
    }
}
