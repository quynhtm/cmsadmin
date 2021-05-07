<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 13/03/2020
* @Version   : 1.0
*/

namespace App\Services;

use App\Http\Models\OpenId\UserSystem;
use App\Library\AdminFunction\Curl;
use App\Library\AdminFunction\Memcache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class ServiceCommon
{
    public function debugLive($data,$is_die = true)
    {
        $user = app(UserSystem::class)->userLogin();
        $debug = Request::get('debug', 0);
        if(isset($user['user_type']) && $user['user_type'] == 'ROOT' && $debug == 1){
            myDebug($data,$is_die);
        }
    }

    function moveFileToServerStore($linkFile, $is_dev = true){
        //$link = Config::get('config.DIR_ROOT') . 'uploads/' . FOLDER_PRODUCT . '/1111/1615433042_123015319203603646862047047385511712892307n.jpg'  ;
        $curl = curl_init();
        $urlServer = ($is_dev?Config::get('config.URL_HYPERSERVICES_DEV'):Config::get('config.URL_HYPERSERVICES_LIVE'))."upload";
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
            CURLOPT_POSTFIELDS =>array('files'=> new \CURLFile($linkFile)) ,
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
        if($dataApi->success == 1){
            return $dataApi->data[0]->file_key;
        }
        return '';
    }
}

