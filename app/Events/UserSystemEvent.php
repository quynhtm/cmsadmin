<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserSystemEvent{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user_name;
    public $password;

    /**
     * Create a new event instance.
     * @param $user_name
     * @param $password
     */
    public function __construct($user_name,$password){
        $this->user_name = $user_name;
        $this->password = $password;
    }
}