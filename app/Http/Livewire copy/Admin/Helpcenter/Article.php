<?php

namespace App\Http\Livewire\Admin\Helpcenter;

use Livewire\Component;
use App\Models\HelpCenter;
use App\Models\Category;
use Illuminate\Support\Str;

class Article extends Component
{
    public $topic;
    public $topics;
    private $articles;
    public $perPage = 10;
    public $search = "";
    public $orderBy = "created_at";
    public $count = 0;
    public $sortBy = "desc";
    public $category;
    public $answer;
    public $question;
    public $settings;

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
    }

    public function mount()
    {
        $this->topics = Category::whereType('faq')->orderby('name', 'asc')->get();
    }

    public function addArticle()
    {
        $this->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);
        HelpCenter::create([
            'question' =>  $this->question,
            'answer' =>  $this->answer,
            'cat_id' =>  $this->topic->id,
            'slug' => Str::slug($this->question)
        ]);
        $this->reset(['question', 'answer']);
        return $this->emit('drawer');
    }

    public function render()
    {
        $this->articles = HelpCenter::whereCatId($this->topic->id)
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->Where('question', 'like', '%' . $this->search . '%')
                        ->orWhere('answer', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);
        return view('livewire.admin.helpcenter.article', ['articles' => $this->articles]);
    }
}
