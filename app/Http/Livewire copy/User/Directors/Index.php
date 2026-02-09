<?php

namespace App\Http\Livewire\User\Directors;

use Livewire\Component;
use App\Models\Directors;
use App\Jobs\SendEmail;
use Services\Sumsub\Api as Sumsub;
use Carbon\Carbon;

class Index extends Component
{
    public $user;
    public $search = "";
 
    protected $listeners = ['saved' => '$refresh'];

    public function render()
    {
        $directors = Directors::whereBusinessId($this->user->business_id)->orderby('created_at', 'DESC')->get();
        return view('livewire.user.directors.index', ['directors' => $directors]);
    }
}
