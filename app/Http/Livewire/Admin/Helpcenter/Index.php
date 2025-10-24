<?php

namespace App\Http\Livewire\Admin\Helpcenter;

use Livewire\Component;
use App\Models\Category;
use App\Models\HelpCenter;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    private $topics;
    public $cat_name;
    public $cat_description;
    public $image;
    public $category;
    public $answer;
    public $question;
    public $search = "";
    public $perPage = 10;
    public $orderBy = "created_at";
    public $sortBy = "desc";

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function addArticle()
    {
        $this->validate([
            'category' => ['required'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);
        HelpCenter::create([
            'question' =>  $this->question,
            'answer' =>  $this->answer,
            'cat_id' =>  $this->category,
            'slug' => Str::slug($this->question)
        ]);
        $this->reset(['question', 'answer', 'category']);
        return $this->emit('drawer');
    }

    public function addCategory()
    {
        $this->validate([
            'cat_name' => ['required', 'string', 'max:50'],
            'cat_description' => ['required', 'string', 'max:255'],
            'image' => 'required|file|mimes:'.allowedFileTypes().'|max:'.allowedFileSize(),
        ]);

        if (Category::whereType('faq')->whereName($this->cat_name)->count() > 0) {
            return $this->addError('cat_name', __('A topic already has this title'));
        } else {
            $filePath = $this->image->storePublicly('help_center');
            Category::create([
                'name' =>  $this->cat_name,
                'description' =>  $this->cat_description,
                'image' => $filePath,
                'slug' => Str::slug($this->cat_name),
                'type' => 'faq'
            ]);
            $this->reset(['cat_name', 'cat_description']);
            return $this->emit('drawer');
        }
    }

    public function render()
    {
        $this->topics = Category::whereType('faq')
        ->withCount('faq')
        ->when($this->search, function ($query) {
            $query->where(function ($query) {
                $query->Where('name', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->search == null, function ($query) {
            $this->emit('searchdrawer');
        })
        ->orderBy('created_at', 'asc')
        ->paginate($this->perPage);

        return view('livewire.admin.helpcenter.index', ['topics' => $this->topics]);
    }
}
