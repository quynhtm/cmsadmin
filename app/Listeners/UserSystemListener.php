<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Listeners;

use App\Events\UserSystemEvent;
use App\Http\Models\OpenId\UserSystem;
use App\Services\SendMailService;
use Exception;

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
                $dataSend['EMAIL'] = $inforUser->EMAIL;
                $dataSend['USER_NAME'] = $inforUser->USER_NAME;
                $dataSend['FULL_NAME'] = $inforUser->FULL_NAME;
                $dataSend['PASSWORD_NEW'] = $event->password;
                if (app(SendMailService::class)->sentEmailCreaterUser($dataSend)) {
                    $arrData['isOk'] = STATUS_INT_MOT;
                    $arrData['msg'] = 'Bạn hãy vào mail đăng ký để lấy mật khẩu mới.';
                } else {
                    $arrData['msg'] = 'Chưa gửi được mail';
                }
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