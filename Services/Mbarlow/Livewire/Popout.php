<?php

namespace Services\Mbarlow\Livewire;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

class Popout extends Component
{
    public $user;

    public $announcements;

    public $unread;

    public $read;

    public $rules = [
        'unread' => 'required',
        'announcements' => 'required',
    ];

    public function mount(Request $request)
    {
        $this->user = $request->user();
        $this->loadAnnouncements($this->user);
    }

    public function loadAnnouncements($user)
    {
        $this->unread = $this->announcements = collect([]);

        if ($user === null || $user::class !== config('megaphone.model')) {
            return;
        }

        $announcements = $user->announcements()->get();
        $this->unread = $announcements->whereNull('read_at');
        $this->announcements = $announcements->whereNotNull('read_at');
        $this->emit('update-notifications');
    }

    public function render()
    {
        return view('megaphone::popout');
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        $this->loadAnnouncements($this->user);
    }    
    
    public function markAllAsRead()
    {
        $announcements = $this->user->announcements()->get();
        $this->unread = $announcements->whereNull('read_at');
        foreach($announcements->whereNull('read_at') as $unread){
            $unread->markAsRead();
        }
        $this->loadAnnouncements($this->user);
    }    
    
    public function clearAllAsRead()
    {
        $announcements = $this->user->announcements()->get();
        $this->read = $announcements->whereNotNull('read_at');
        foreach($announcements->whereNotNull('read_at') as $read){
            $read->delete();
        }
        $this->loadAnnouncements($this->user);
    }
}