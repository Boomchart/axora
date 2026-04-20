<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BlogCategorySearch extends Component
{
    public $term = '';

    public function searchBlogArticles()
    {
        $this->validate(
            [
                'term' => 'required|string|min:2',
            ],
            [
                'term.required' => __('Please enter a valid search term'),
                'term.min' => __('Please enter at least 2 characters'),
            ]
        );

        return redirect()->route('blog.search', [
            'term' => $this->term,
        ]);
    }

    public function render()
    {
        return view('livewire.blog-category-search');
    }
}
