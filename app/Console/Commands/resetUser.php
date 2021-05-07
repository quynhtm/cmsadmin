<?php
/**
 * QuynhTM:add
 */

namespace App\Console\Commands;
use Illuminate\Console\Command;

use App\Library\AdminFunction\Define;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Admin\User;


class resetUser extends Command{
    protected $signature = 'resetUser';
    protected $description = 'Reset User';
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $dataUpdate['user_last_login'] = time();
        $dataUpdate['user_edit_name'] = 'cronjob';
        $data = DB::table(TABLE_USER_ADMIN)
            ->where('user_status', '=', Define::STATUS_SHOW)
            ->get(array('user_id'));
        if($data){
            foreach ($data as $k=>$user){
                User::updateUser($user->user_id,$dataUpdate);
            }
            echo 'Co tong: '.count($data).' da cap nhat xong';
        }
    }
}
