<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Exception;

class HasExceptionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $exception;
    public $metas;

    public function __construct(Exception $exception, $metas = [])
    {
        $this->exception = $exception;
        $this->metas = $metas;
    }
}
