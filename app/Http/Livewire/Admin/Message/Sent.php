<?php

namespace App\Http\Livewire\Admin\Message;

use Livewire\Component;
use App\Models\SentEmail;

class Sent extends Component
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

    public function loadMore()
    {
        $this->perPage = $this->perPage + 10;
        $this->emit('drawer');
    }

    public function checked()
    {
        $collect = collect($this->archive)->filter(function ($key, $item) {
            return $key == true;
        });
        $this->emit('updatemarked', ($collect->count() > 0) ? 1 : 0);
    }

    public function deleteAll()
    {
        foreach ($this->archive as $archive => $key) {
            if ($key == true) {
                SentEmail::find($archive)->delete();
            }
        }
        $this->reset(['archive']);
        $this->emit('saved');
        $this->emit('success', __('Messages deleted'));
        $this->emit('clearMarkAll');
        $this->emit('closeModal', 'deleteall');
    }

    public function setAll()
    {
        if ($this->all) {
            $contactIds = SentEmail::pluck('id')->toArray();
            $replacedArray = array_fill_keys($contactIds, true);
            $this->archive = $replacedArray;
            $this->checked();
        } else {
            $this->archive = [];
        }
    }

    public function render()
    {
        $this->message = SentEmail::when($this->search, function ($query) {
            $this->emit('drawer');
                $query->where(function ($query) {
                    $query->WhereRelation('contact', 'first_name', 'like', '%' . $this->search . '%')
                        ->orWhereRelation('contact', 'last_name', 'like', '%' . $this->search . '%')
                        ->orWhereRelation('contact', 'email', 'like', '%' . $this->search . '%')
                        ->orWhereRelation('contact', 'mobile', 'like', '%' . $this->search . '%')
                        ->orWhere('message', 'like', '%' . $this->search . '%')
                        ->orWhere('subject', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);
        $this->checked();
        return view('livewire.admin.message.sent', [
            'message' => $this->message,
            'type' => $this->type
        ]);
    }
}
