<?php

namespace App\Http\Livewire\Admin\Message;

use Livewire\Component;
use App\Jobs\SendEmail;
use App\Models\Contact;
use App\Models\SentEmail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContactExport;

class Contacts extends Component
{
    private $contacts;
    public $perPage = 10;
    public $type;
    public $archive = [];
    public $all = false;
    public $admin;
    public $subject;
    public $message;
    public $search = "";
    public $orderBy = "created_at";
    public $subscribed = "";
    public $customer = "";
    public $count = 0;
    public $sortBy = "desc";

    protected $listeners = ['saved' => '$refresh', 'fileError' => 'attachement'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('reload');
    }

    public function csv()
    {
        if ($this->pages()->count() > 0) {
            return Excel::download(new ContactExport($this->pages()), 'contact.csv');
            return $this->emit('success', __('Contacts Exported'));
        } else {
            return $this->emit('alert', __('No Contacts to export!'));
        }
    }

    public function checked()
    {
        $collect = collect($this->archive)->filter(function ($key, $item) {
            return $key == true;
        });
        $this->emit('updatemarked', ($collect->count() > 0) ? 1 : 0);
        if (count($this->archive) > $collect->count()) {
            $this->all = false;
        }
    }

    public function setAll()
    {
        if ($this->all) {
            $contactIds = Contact::pluck('id')->toArray();
            $replacedArray = array_fill_keys($contactIds, true);
            $this->archive = $replacedArray;
            $this->checked();
        } else {
            $this->archive = [];
        }
    }

    public function deleteAll()
    {
        foreach ($this->archive as $archive => $key) {
            if ($key == true) {
                Contact::find($archive)->delete();
            }
        }
        $this->reset(['archive', 'all']);
        $this->emit('saved');
        $this->emit('success', 'Contacts deleted');
        $this->emit('clearMarkAll');
    }

    public function sendEmail()
    {
        $collect = collect($this->archive)->filter(function ($key, $item) {
            return $key == true;
        });
        if ($collect->count() > 0) {
            if($collect->count() > 1){
                if($this->admin->promo == 0){
                    $this->emit('alert', __('Permission denied'));
                    return;
                }
            }
            foreach ($collect->toArray() as $archive => $key) {
                if ($key == true) {
                    $contact = Contact::find($archive);
                    SentEmail::create([
                        'subject' => $this->subject,
                        'message' => $this->message,
                        'contact_id' => $contact->id,
                        'admin_id' => $this->admin->id,
                    ]);
                    dispatch(new SendEmail($contact->email, $contact->first_name . ' ' . $contact->last_name, $this->subject, $this->message, null, $contact));
                }
            }
            $this->reset(['archive', 'all', 'subject', 'message']);
            $this->emit('success', __('Email added to queue'));
            $this->emit('clearMarkAll');
            $this->emit('drawer');
            $this->emit('saved');
        } else {
            $this->emit('alert', __('Select a contact'));
        }
    }

    public function render()
    {
        $page = $this->pages();
        $this->contacts = $page->paginate($this->perPage);
        $this->checked();
        return view('livewire.admin.message.contacts', [
            'contacts' => $this->contacts,
            'type' => $this->type
        ]);
    }

    protected function pages()
    {
        return Contact::when($this->search, function ($query) {
            $this->emit('drawer');
            $searchTerm = str_replace('-', '', str_replace('+', '', str_replace('@', '', $this->search)));
            return $query->whereRaw("MATCH(first_name, last_name, email, mobile) AGAINST(? IN BOOLEAN MODE)", [$searchTerm]);
        })
        ->when($this->search == null, function ($query) {
            $this->emit('searchdrawer');
        })->when(($this->subscribed != null), function ($query) {
            return $query->whereSubscribed($this->subscribed);
        })->when(($this->customer != null), function ($query) {
            return ($this->customer == 1) ? $query->whereNotNull('user_id') : $query->whereNull('user_id');
        })
            ->orderby($this->orderBy, $this->sortBy);
    }
}
