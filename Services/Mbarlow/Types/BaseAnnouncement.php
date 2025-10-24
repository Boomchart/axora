<?php

namespace Services\Mbarlow\Types;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class BaseAnnouncement extends Notification implements ShouldQueue
{
    use Queueable;

    public $title;
    public $body;
    public $link;
    public $linkText;

    public function __construct($title, $body, $link = '', $linkText = '')
    {
        $this->title = $title;
        $this->body = $body;
        $this->link = $link;
        $this->linkText = $linkText;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'link' => $this->link,
            'linkText' => $this->linkText,
        ];
    }

    public static function name(): string
    {
        $elements = explode('\\', static::class);
        $class = end($elements);

        return implode(' ', Str::ucsplit($class));
    }
}
