<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 13/03/2020
* @Version   : 1.0
*/

namespace App\Services;

use App\Models\OpenId\UserSystem;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Curl;
use App\Library\AdminFunction\Memcache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class ServiceCommon
{
    public function debugLive($data, $is_die = true)
    {
        $user = app(UserSystem::class)->userLogin();
        $debug = Request::get('debug', 0);
        if (isset($user['user_type']) && $user['user_type'] == 'ROOT' && $debug == 1) {
            myDebug($data, $is_die);
        }
    }

    function moveFileToServerStore($linkFile, $is_dev = true)
    {
        $curl = curl_init();
        $is_dev = (Config::get('config.ENVIRONMENT') == 'DEV')? true: false;
        $urlServer = ($is_dev ? Config::get('config.URL_HYPERSERVICES_DEV') : Config::get('config.URL_HYPERSERVICES_LIVE')) . "upload";
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlServer,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,

            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('files' => new \CURLFile($linkFile)),
            CURLOPT_HTTPHEADER => array(
                //"Content-Type:multipart/form-data",
                "ParentCode: HDI_UPLOAD",
                "Secret: HDI_UPLOAD_198282911FASE1239212",
                "UserName: HDI_UPLOAD",
                "environment: LIVE",
                "DeviceEnvironment: WEB",
                "ActionCode: UPLOAD_SIGN"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $dataApi = json_decode($response);
        if ($dataApi->success == 1) {
            return $dataApi->data[0]->file_key;
        }
        return '';
    }

    function moveFileCreateOrder($dataInput = [], $is_dev = true)
    {
        $curl = curl_init();
        $linkFile = isset($dataInput['urlFile']) ? $dataInput['urlFile'] : '';
        $is_dev = (Config::get('config.ENVIRONMENT') == 'DEV')? true: false;
        $urlCreateOrder = ($is_dev ? Config::get('config.URL_API_DEV') : Config::get('config.URL_API_LIVE')) . "OpenApi/v1/import/care/add";
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlCreateOrder,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,

            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('files' => new \CURLFile($linkFile)),
            CURLOPT_HTTPHEADER => array(
                "ACTION: IMP_ADD",
                "ID:" . (isset($dataInput['programme_id']) ? $dataInput['programme_id'] : ''),//id chương trình
                "IS_SMS:" . (isset($dataInput['check_send_sms']) ? $dataInput['check_send_sms'] : '0'),
                "IS_EMAIL:" . (isset($dataInput['check_send_email']) ? $dataInput['check_send_email'] : '0'),
                "ENV:" . (isset($dataInput['check_create_test']) ? $dataInput['check_create_test'] : '0'),
                "IS_SGN:" . (isset($dataInput['check_creat_certification']) ? $dataInput['check_creat_certification'] : '0'),//dùng số SGN sinh trước
                "ParentCode:" . Config::get('config.API_PARENT_CODE'),
                "UserName:" . Config::get('config.API_USER_NAME'),
                "Secret: " . Config::get('config.API_SECRET'),
            )
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $dataApi = json_decode($response);
    }

    /**
     * Send email
     * @param array $dataInput
     * @return false
     */
    public function sendMailCommon($dataInput = array())
    {
        $content = isset($dataInput['CONTENT']) ? $dataInput['CONTENT'] : '';
        $emailTo = isset($dataInput['TO']) ? $dataInput['TO'] : '';
        $emailCC = isset($dataInput['CC']) ? $dataInput['CC'] : '';
        if (trim($content) == '' || trim($emailTo) == '') {
            return false;
        }

        $arrFile['name'] = '';
        $arrFile['path'] = '';

        $dataSendMail = [
            "REFF_ID" => 'PORTAL',
            "CONTENT" => base64_encode($content),
        ];
        $dataSendMail['TEMP'][] = [
            "TEMP_CODE" => 'PORTAL_EMAIL',
            "PRODUCT_CODE" => 'PORTAL_EMAIL',
            "ORG_CODE" => "HDI_PORTAL",
            "ACCOUNT" => "ADMIN",
            "TYPE" => "EMAIL",
            "TO" => $emailTo,
            "CC" => $emailCC,
            "BCC" => CGlobal::mail_test,
            "file" => [json_encode($arrFile)]];

        $dataRequest['Data'] = $dataSendMail;
        $dataRequest['Action'] = [
            'ParentCode' => Config::get('config.API_PARENT_CODE'),
            'UserName' => Config::get('config.API_USER_NAME'),
            'Secret' => Config::get('config.API_SECRET'),
            "ActionCode" => "HDI_EMAIL_JSON"];
        myDebug($dataRequest);
        $param_url = Config::get('config.MAIL_SERVICE');
        $serviceUrl = new ServiceCurl();
        $resultApi = $serviceUrl->postApiUrl($dataRequest, $param_url);
        return $resultApi;
    }

    public function sendMailWithContent($dataInput = array())
    {
        $content = isset($dataInput['CONTENT']) ? $dataInput['CONTENT'] : '';
        $emailTo = isset($dataInput['TO']) ? $dataInput['TO'] : '';
        $emailCC = isset($dataInput['CC']) ? $dataInput['CC'] : '';
        $type = isset($dataInput['TYPE']) ? $dataInput['TYPE'] : 'THONG_BAO';
        if (trim($content) == '' || trim($emailTo) == '') {
            return false;
        }

        $arrFile['name'] = '';
        $arrFile['path'] = '';

        $dataSendMail[] = [
            "CONTENT" => base64_encode($content),
            "REFF_ID" => 'TCBT',
            "SUBJECT" => 'PORTAL_EMAIL',
            "ACCOUNT" => "ADMIN",
            "TYPE" => $type,
            "TO" => $emailTo,
            "CC" => $emailCC,
            "BCC" => CGlobal::mail_test,
            "file" => ''];
            //"file" => [json_encode($arrFile)]];

        $dataRequest['Data'] = $dataSendMail;
        $dataRequest['Action'] = [
            'ParentCode' => Config::get('config.API_PARENT_CODE'),
            'UserName' => Config::get('config.API_USER_NAME'),
            'Secret' => Config::get('config.API_SECRET'),
            "ActionCode" => "HDI_EMAIL_JSON"];

        $param_url = Config::get('config.SEND_MAIL_ADMIN');
        $serviceUrl = new ServiceCurl();
        $resultApi = $serviceUrl->postApiUrl($dataRequest, $param_url);
        return $resultApi;
    }
    /**
     * Lấy quyền theo page
     * @param string $nameController
     * @return string[]
     */
    public function getGroupPermissonWithController($nameController = '')
    {
        $inforUserLogin = app(UserSystem::class)->userLogin();
        $arrPermission = ['APPROVE' => '0', 'CREATE_ORDER' => '0', 'INSPECTION' => '0'];
        if (!empty($inforUserLogin)) {
            if ($inforUserLogin['user_type'] != USER_ROOT) {
                if (isset($inforUserLogin['user_permission'][$nameController])) {
                    if (isset($inforUserLogin['user_permission'][$nameController]['APPROVE'])) {
                        $arrPermission['APPROVE'] = '1';
                    }
                    if (isset($inforUserLogin['user_permission'][$nameController]['CREATE_ORDER'])) {
                        $arrPermission['CREATE_ORDER'] = '1';
                    }
                    if (isset($inforUserLogin['user_permission'][$nameController]['INSPECTION'])) {
                        $arrPermission['INSPECTION'] = '1';
                    }
                }
            } else {
                $arrPermission['APPROVE'] = '1';
                $arrPermission['CREATE_ORDER'] = '1';
                $arrPermission['INSPECTION'] = '1';
            }
        }
        return $arrPermission;
    }
}

