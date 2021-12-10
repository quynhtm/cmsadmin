<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;

use App\Models\Admin\User;
use App\Library\AdminFunction\CGlobal;
use App\Services\ServiceCommon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\View;

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

    public function testData()
    {
        //Check phan quyen.
        if (!$this->checkMultiPermiss()) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $functionAction = trim(Request::get('func', ''));
        if ($functionAction != '' && $this->is_root) {
            return $this->$functionAction();
        } else {
            echo 'Chưa nhập tên function để chạy, hãy nhập lại';
        }
    }

    public function sendEmail()
    {
        $dataSend['PASSWORD'] = 'PASSWORD';
        $dataSend['OLD_PASSWORD'] = 'OLD_PASSWORD';
        $dataSend['IS_CHANGE_PWD'] = 1;

        $dataSend['EMAIL'] = CGlobal::mail_test;
        $dataSend['USER_NAME'] = 'USER_NAME';
        $dataSend['FULL_NAME'] = 'FULL_NAME';
        $dataSend['PASSWORD_NEW'] = 'PASSWORD_NEW';
        $dataSend['URL_LOGIN'] = Config::get('config.WEB_ROOT');

        $content = View::make('mail.mailForgotPassword')->with(['data' => $dataSend])->render();
        $dataSenmail['CONTENT'] = $content;
        $dataSenmail['TO'] = CGlobal::mail_test;
        $dataSenmail['CC'] = CGlobal::mail_test;
        $dataSenmail['TYPE'] = 'MAT_KHAU';
        $sendEmail = app(ServiceCommon::class)->sendMailWithContent($dataSenmail);
        myDebug($sendEmail);
    }

}
