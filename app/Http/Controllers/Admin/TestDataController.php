<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;

use App\Http\Models\Admin\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;

class  TestDataController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    ///manager/runCronjob?job=CronExcelExportInsmart
    public function runCronjob()
    {
        //Check phan quyen.
        if (!$this->checkMultiPermiss()) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $nameCronjob = trim(Request::get('job', ''));
        $taskAction = trim(Request::get('action', ''));
        if ($nameCronjob != '' && $this->is_root) {
            Artisan::call('cronjob:' . $nameCronjob);
            echo 'Đã chạy thành công';
        }/* else {
            if(trim($taskAction) != ''){
                $this->$taskAction();
            }
            echo 'Chưa nhập tên cronjob để chạy, hãy nhập lại';
        }*/
        echo 'Chưa nhập tên cronjob để chạy, hãy nhập lại';
    }

    /*public function clearCache(){
        Artisan::call('cache:clear');
        die('da xoa cache xong');
    }*/
}
