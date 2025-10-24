<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ArticleLikes extends Component
{
    public $article;

    public function like(): void
    {
        if ($this->article->reacted()) {
            $this->article->addLike();
        } else {
            $reaction = new \App\Models\ArticleLikes();
            $reaction->ip = user_ip();
            $reaction->post_id = $this->article->id;
            $reaction->user_agent = request()->userAgent();
            $reaction->type = 1;
            $reaction->save();
        }
    }    
    
    public function dislike(): void
    {
        if ($this->article->reacted()) {
            $this->article->removeLike();
        } else {
            $reaction = new \App\Models\ArticleLikes();
            $reaction->ip = user_ip();
            $reaction->post_id = $this->article->id;
            $reaction->user_agent = request()->userAgent();
            $reaction->type = 0;
            $reaction->save();
        }
    }

    public function render()
    {
        return view('livewire.article-likes');
    }
}
