<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ElasticEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Id of the model
     */
    public $model;

    /**
     * The created, updated, deleted action
     */
    public $action;

    /**
     * Create a new event instance.
     *
     * @param $model
     * @param $action
     * @return void
     */
    public function __construct($model, $action)
    {
        $this->model = $model;
        $this->action = $action;
    }
}