<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;
use App\Events\HasExceptionEvent;

class HasExceptionNotification extends Notification
{
    use Queueable;

    protected $event;

    public function __construct(HasExceptionEvent $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $notification = (new SlackMessage)
            ->error()
            ->content($this->event->exception->getMessage())
            ->attachment(function ($attachment) {
                $attachment->title(get_class($this->event->exception))
                    ->content('File: ' . $this->event->exception->getFile() . ' on line' . $this->event->exception->getLine());
            });

        if ($this->event->metas and is_array($this->event->metas)) {
            $notification->attachment(function ($attachment) {
                $contents = [];
                foreach ($this->event->metas as $name => $value) {
                    $contents[] = "$name: $value";
                }
                $attachment->title('Metas')->content(implode("\n", $contents));
            });
        }

        return $notification;
    }
}
