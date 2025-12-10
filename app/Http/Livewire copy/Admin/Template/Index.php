<?php

namespace App\Http\Livewire\Admin\Template;

use Livewire\Component;
use App\Models\Emailtemplate;

class Index extends Component
{
    private $template;
    public $admin;
    public $type;
    public $search = "";

    protected $listeners = ['saved' => '$refresh'];

    public function render()
    {
        $this->template = Emailtemplate::whereSms($this->type)
            ->orderBy('type', 'asc')->get();

        return view('livewire.admin.template.index', ['template' => $this->template]);
    }
}
