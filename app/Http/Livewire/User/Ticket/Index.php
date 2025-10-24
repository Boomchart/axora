<?php

namespace App\Http\Livewire\User\Ticket;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithFileUploads;
use App\Jobs\CustomEmail;
use App\Jobs\SendEmail;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class Index extends Component
{
    use WithFileUploads;
    public $perPage = 10;
    public $user;
    public $settings;
    public $search = "";
    public $status = "";
    public $priority = "";
    public $orderBy = "created_at";
    public $subject;
    public $details;
    public $selectPriority = "low";
    public $files = [];
    public $filePaths = [];
    public $sortBy = "desc";
    private $ticket;
    public $count = 1;

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function updatedFiles()
    {
        $this->validate([
            'files.*' => 'nullable|mimetypes:' . allowedFileTypes() . '|max:' . allowedFileSize(),
        ]);
    }

    public function addTicket()
    {
        $this->validate([
            'subject' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string'],
            'selectPriority' => ['required', 'string'],
            'files.*' => 'nullable|mimetypes:' . allowedFileTypes() . '|max:' . allowedFileSize(),
        ]);
        
        try {
            foreach ($this->files as $file) {
                $path = Cloudinary::upload($file->getRealPath())->getSecurePath();
                $this->filePaths[] = $path;
            }

            $filePathsString = implode(',', $this->filePaths);

            $ticket = Ticket::create([
                'user_id' => $this->user->id,
                'subject' => $this->subject,
                'priority' => $this->selectPriority,
                'message' => $this->details,
                'ticket_id' => randomNumber(16),
                'business_id' => $this->user->business_id,
                'files' => ($filePathsString != null) ? $filePathsString : null,
            ]);

            updateLocale('admin');
            dispatch(new SendEmail($this->settings->support_email, $this->settings->site_name, __('New Ticket') . ' - ' . $ticket->ticket_id, __('New ticket request'), null, null, 0));
            updateLocale('user');
            dispatch(new CustomEmail('ticket_new', $ticket->id));

            $this->reset(['subject', 'details', 'selectPriority', 'files']);
            $this->files = null;
            $this->count++;
            $this->emit('drawer');
            $this->emit('newChat');
            $this->emit('success', __('Ticket created'));
        } catch (\Exception $e) {
            return $this->emit('alert', $e->getMessage());
        }
    }

    public function render()
    {
        $this->ticket = Ticket::whereUserId($this->user->id)->whereBusinessId($this->user->business_id)
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->Where('subject', 'like', '%' . $this->search . '%')
                        ->orWhere('priority', 'like', '%' . $this->search . '%')
                        ->orWhere('ticket_id', 'like', '%' . $this->search . '%')
                        ->orWhere('message', 'like', '%' . $this->search . '%');
                });
            })
            ->when(($this->status != null), function ($query) {
                return $query->whereStatus($this->status);
            })
            ->when(($this->priority != null), function ($query) {
                return $query->wherepriority($this->priority);
            })
            ->orderby('status', 'desc')
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);
        return view('livewire.user.ticket.index', ['ticket' => $this->ticket]);
    }
}
