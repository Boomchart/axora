<?php

namespace App\Http\Livewire\User\Ticket;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\SendEmail;
use App\Models\Reply as Ticket;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class Reply extends Component
{
    use WithFileUploads;
    public $user;
    public $message;
    public $files = [];
    public $filePaths = [];
    public $val;
    public $settings;
    public $count = 1;

    protected $listeners = ['saved' => '$refresh'];

    public function updatedFiles()
    {
        $this->validate([
            'files.*' => 'nullable|mimetypes:' . allowedFileTypes() . '|max:' . allowedFileSize(),
        ]);
    }

    public function reply()
    {
        $this->validate([
            'message' => ['required', 'string'],
            'files.*' => 'nullable|mimetypes:' . allowedFileTypes() . '|max:' . allowedFileSize(),
        ]);

        try {
            foreach ($this->files as $file) {
                $path = Cloudinary::upload($file->getRealPath())->getSecurePath();
                $this->filePaths[] = $path;
            }
            $filePathsString = implode(',', $this->filePaths);

            Ticket::create([
                'reply' => $this->message,
                'ticket_id' => $this->val->id,
                'status' => 0,
                'user_id' => $this->user->id,
                'business_id' => $this->user->business_id,
                'files' => ($filePathsString != null) ? $filePathsString : null,
            ]);
            updateLocale('admin');
            dispatch(new SendEmail($this->settings->support_email, $this->settings->site_name, __('Ticket Reply') . ' - ' . $this->val->ticket_id, __('New ticket reply request')));
            updateLocale('user');
            $this->files = null;
            $this->count++;
            $this->reset(['message', 'files']);
            $this->emit('newChat');
            $this->emit('success', __('Message Sent'));
        } catch (\Exception $e) {
            return $this->emit('alert', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.user.ticket.reply');
    }
}
