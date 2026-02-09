<?php

namespace App\Http\Livewire\Admin\Message;

use Livewire\Component;
use App\Models\Messages;

class Deleted extends Component
{
    private $message;
    public $perPage = 10;
    public $type;
    public $archive = [];
    public $all = false;
    public $admin;
    public $add;
    public $search = "";
    public $orderBy = "created_at";
    public $count = 0;
    public $sortBy = "desc";

    protected $listeners = ['saved' => '$refresh'];

    public function checked()
    {
        $collect = collect($this->archive)->filter(function ($key, $item) {
            return $key == true;
        });
        $this->emit('updatemarked', ($collect->count() > 0) ? 1 : 0);
    }

    public function setAll()
    {
        if ($this->all) {
            $contactIds = Messages::onlyTrashed()->pluck('id')->toArray();
            $replacedArray = array_fill_keys($contactIds, true);
            $this->archive = $replacedArray;
            $this->checked();
        } else {
            $this->archive = [];
        }
    }

    public function restoreAll(){
        foreach($this->archive as $archive=>$key){
            if($key == true){
                Messages::whereId($archive)->onlyTrashed()->first()->restore();
            }
        }
        $this->reset(['archive']);
        $this->emit('saved');
        $this->emit('success', __('Messages restored'));
        $this->emit('clearMarkAll');
    }

    public function forceDelete(){
        foreach($this->archive as $archive=>$key){
            if($key == true){
                Messages::whereId($archive)->onlyTrashed()->first()->forceDelete();
            }
        }
        $this->reset(['archive']);
        $this->emit('saved');
        $this->emit('success', __('Inbox deleted'));
        $this->emit('clearMarkAll');
    }

    public function render()
    {
        $this->message = Messages::orderBy('seen', 'asc')->onlyTrashed()
        ->when($this->search, function ($query) {
            $this->emit('drawer');
            $query->where(function ($query) {
                $query->Where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('message', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('mobile', 'like', '%' . $this->search . '%')
                    ->orWhere('subject', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->search == null, function ($query) {
            $this->emit('searchdrawer');
        })
        ->orderby($this->orderBy, $this->sortBy)
        ->paginate($this->perPage);
        $this->checked();
        return view('livewire.admin.message.deleted', ['message' => $this->message, 'type' => $this->type]);
    }
}
