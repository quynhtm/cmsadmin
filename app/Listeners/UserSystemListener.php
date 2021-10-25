<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Listeners;

use App\Events\UserSystemEvent;
use App\Models\OpenId\UserSystem;
use App\Library\AdminFunction\CGlobal;
use App\Services\ServiceCommon;
use Exception;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class UserSystemListener
{
    private $user;

    /**
     * UserSystemListener constructor.
     */
    public function __construct()
    {
        $this->user = new UserSystem();
    }

    public function handle(UserSystemEvent $event)
    {
        $inforUser = $this->user->getInforUserByKey($event->user_name, 'USER_NAME');
        try {
            if (isset($inforUser->USER_CODE)) {
                $mail_send = (isset($inforUser->EMAIL) && trim($inforUser->EMAIL) != '')?trim($inforUser->EMAIL): '';

                $dataUser['FULL_NAME'] = $inforUser->FULL_NAME;
                $dataUser['USER_NAME'] = $inforUser->USER_NAME;
                $dataUser['PASSWORD_NEW'] = $event->password;
                $content = View::make('mail.mailCreaterUser')->with(['data' => $dataUser])->render();

                //gửi mail
                $dataSenmail['CONTENT'] = $content;
                $dataSenmail['TO'] = trim($mail_send) != ''? $mail_send: CGlobal::mail_test;
                if(trim($mail_send) != ''){
                    $dataSenmail['CC'] = CGlobal::mail_test;
                }
                $dataSenmail['TYPE'] = 'MAT_KHAU';
                app(ServiceCommon::class)->sendMailWithContent($dataSenmail);
            }
        } catch (Exception $e) {
            $this->writeLog('Event usser Error', $e->getMessage());
        }
    }

    public function writeLog($msg = 'ket qua log', $dataLog = [], $end_log = false)
    {
        $name_log = 'UserSystemListener.log';
        $name_folder = FOLDER_FILE_LOG_COMMON;
        //$name_folder = FOLDER_FILE_LOG_COMMON . '_' . getParamDate('m') . '_' . getParamDate('Y');
        debugLog($msg, $name_log, $name_folder);
        if (!empty($dataLog)) {
            debugLog($dataLog, $name_log, $name_folder);
        }

        if ($end_log) {
            endLog($name_log, $name_folder);
        }
    }
}
