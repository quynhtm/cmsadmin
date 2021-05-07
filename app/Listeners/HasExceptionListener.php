<?php

namespace App\Listeners;

use App\Events\HasExceptionEvent;
use App\Notifications\HasExceptionNotification;
use Illuminate\Support\Facades\Notification;

class HasExceptionListener
{
    public function handle(HasExceptionEvent $event)
    {
        $notify = new HasExceptionNotification($event);
        $slackWebHookUrl = env('SLACK_WEBHOOK_URL','xxxxx'); // paste your webhook slack url here
        Notification::route('slack', $slackWebHookUrl)->notify($notify);
    }
}
