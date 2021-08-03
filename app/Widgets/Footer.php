<?php

namespace App\Widgets;

use App\Library\Funcs;
use App\Models\Users;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Request;

class Footer extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    protected $user = [];
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */

    public function run()
    {
//        $notice = null;
//        $viewed = 0;
//        if(1 ||  session('is_login')) {
//            $email = session('user_email');
//            $email = 'notification@buv.edu.vn';
//
//            $user = Users::findByEmail($email);
//            if(!is_null($user)) {
//                $this->user['name'] = $user->name;
//                $this->user['email'] = $user->email;
//                $this->user['avatar'] = $user->avatar;
//                $notice = Notice::findByUserId($user->id);
//                $viewed = Notice::where('user_id', $user->id)->where('viewed', 0)->count();
//            }
//        }
////        Funcs::debug($notice);
//        $list_user = Users::findShortList();
        return view('widgets.footer', [
            'config' => $this->config,
            'user' => $this->user,
//            'notice' => $notice,
//            'viewed' => $viewed,
//            'list_user'=>$list_user
        ]);
    }
}
