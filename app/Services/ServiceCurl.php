<?php

namespace App\Services;

use App\Library\AdminFunction\Curl;
use App\Library\AdminFunction\Memcache;
use Illuminate\Support\Facades\Config;

class ServiceCurl
{
    const flagHttps = true;
    const apiDefault = STATUS_INT_MOT;

    private $curl = false;
    private $typeApi = self::apiDefault;

    function __construct()
    {
        $this->curl = Curl::getInstance();
    }

    public function setTypeApi($type)
    {
        $this->typeApi = $type;
    }

    public $dataRequestDefault = [
        "p_channel" => "",
        "p_username" => ""];

    /**
     * @param string $param
     * @return string
     */
    private function _getUrlApi($param = '')
    {
        switch ($this->typeApi) {
            case STATUS_INT_MOT:
                $urlApi = Config::get('config.URL_API_' . Config::get('config.ENVIRONMENT')) . $param;
                break;
            default:
                $urlApi = Config::get('config.URL_API_' . Config::get('config.ENVIRONMENT')) . $param;
                break;
        }
        return $urlApi;
    }

    private function _buildParam($dataRequest = [])
    {
        switch ($this->typeApi) {
            case STATUS_INT_MOT:
                $dataParam = $this->_paramDefault($dataRequest);
                break;
            default:
                $dataParam = $this->_paramDefault($dataRequest);
                break;
        }
        return $dataParam;
    }

    private function _getUserApi()
    {
        switch ($this->typeApi) {
            case STATUS_INT_MOT:
                $dataUserApi = [
                    'UserName' => Config::get('config.API_USER_NAME'),
                    'Password' => Config::get('config.API_PASSWORD')
                ];
                break;
            default:
                $dataUserApi = [
                    'UserName' => Config::get('config.API_USER_NAME'),
                    'Password' => Config::get('config.API_PASSWORD')
                ];
                break;
        }
        return $dataUserApi;
    }

    /**
     * @param array $dataRequest
     * @return mixed
     */
    private function _paramDefault($dataRequest = [])
    {
        $arrDefault['Device'] = [
            'DeviceId' => '',
            'DeviceCode' => '',
            'DeviceName' => '',
            'IpPrivate' => '',
            'IpPublic' => '',
            'X' => '',
            'Y' => '',
            'Province' => '',
            'District' => '',
            'Wards' => '',
            'Address' => '',
            'Environment' => '',
            'Browser' => '',
            'DeviceEnvironment' => 'WEB',
        ];
        $arrActionRequest = $dataRequest['Action'] ?? [];
        $arrDefault['Action'] = [
            'ParentCode' => isset($arrActionRequest['ParentCode']) ? $arrActionRequest['ParentCode'] : Config::get('config.API_PARENT_CODE'),
            'UserName' => isset($arrActionRequest['UserName']) ? $arrActionRequest['UserName'] : Config::get('config.API_USER_NAME'),
            'Secret' => isset($arrActionRequest['Secret']) ? $arrActionRequest['Secret'] : Config::get('config.API_SECRET'),
            'ActionCode' => isset($arrActionRequest['ActionCode']) ? $arrActionRequest['ActionCode'] : 'HDI_API_LOGIN',
        ];
        $arrDefault['Data'] = isset($dataRequest['Data']) ? $dataRequest['Data'] : null;
        $arrDefault['Signature'] = isset($dataRequest['Signature']) ? $dataRequest['Signature'] : '';
        return $arrDefault;
    }

    /**
     * @return bool|string
     */
    private function _getTokenCallApi($isCallBack = true)
    {
        $keyCache = Memcache::CACHE_API_TOKEN_HD . '_' . $this->typeApi;
        $token = ($isCallBack) ? Memcache::getCache($keyCache) : false;
        if (!$token) {
            $token = '';
            $request['Data'] = $this->_getUserApi();
            $dataRequest = $this->_buildParam($request);
            $url = $this->_getUrlApi('OpenApi/Login');
            $response = json_decode($this->curl->post($url, $dataRequest, '', self::flagHttps));
            if (isset($response->Success) && $response->Success == STATUS_INT_MOT) {
                $token = $response->Token;
                $expriesToken = $response->Expries - 3;
                if ($token != '') {
                    Memcache::putCache($keyCache, $token, $expriesToken);
                }
            }
        }
        return $token;
    }

    /**
     * @param array $dataPost
     * @param string $url
     * @param bool $flagHttps
     * @param bool $flgJson
     * @return mixed|string
     */
    public function postApiHD($dataPost = array(), $flagHttps = self::flagHttps)
    {
        try {
            $dataApi = $this->_methodPost($dataPost, $flagHttps);
            //check token exp
            if (isset($dataApi->Error) && $dataApi->Error == ERROR_AUT_EXP_API) {
                $dataApi = $this->_methodPost($dataPost, $flagHttps, false);
            }
            return $dataApi;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function postApiUrl($dataPost = array(), $param_url = '', $flagHttps = self::flagHttps)
    {
        try {
            if (trim($param_url) == '')
                return returnError();

            $token = $this->_getTokenCallApi(true);
            $dataRequest = $this->_buildParam($dataPost);
            $url = $this->_getUrlApi($param_url);
            $response = $this->curl->post($url, $dataRequest, $token, $flagHttps);
            $dataApi = json_decode($response);
            return $dataApi;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function postApiByUrl($dataPost = array(), $url = '', $flagHttps = self::flagHttps)
    {
        try {
            if (trim($url) == '')
                return returnError();
            $token = $this->_getTokenCallApi(true);
            $dataRequest = $this->_buildParam($dataPost);
            $response = $this->curl->post($url, $dataRequest, $token, $flagHttps);
            $dataApi = json_decode($response);
            return $dataApi;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function _methodPost($dataPost = array(), $flagHttps = self::flagHttps, $isCallBack = true)
    {
        $token = $this->_getTokenCallApi($isCallBack);
        $url = $this->_getUrlApi('OpenApi/PostDev');
        $dataRequest = $this->_buildParam($dataPost);
        $response = $this->curl->post($url, $dataRequest, $token, $flagHttps);

        $dataApi = json_decode($response);
        return $dataApi;
    }

    public function returnResponse($response)
    {
        $status = isset($response->Success) ? $response->Success : STATUS_INT_KHONG;
        $error = isset($response->Error) ? $response->Error : '';
        $message = isset($response->ErrorMessage) ? $response->ErrorMessage : '';
        $data = isset($response->Data) ? $response->Data : [];
        return [
            'Success' => ($status) ? STATUS_INT_MOT : STATUS_INT_KHONG,
            'Data' => $data,
            'Error' => $error,
            'Message' => $message,
        ];
    }

    public function returnStatusError($msg = 'Error! Try again.', $error_code = 'ERROR')
    {
        return [
            'Success' => STATUS_INT_KHONG,
            'Data' => [],
            'Error' => $error_code,
            'Message' => $msg,
        ];
    }

    public function returnStatusSuccess($data = [], $msg = 'Successfully')
    {
        return [
            'Success' => STATUS_INT_MOT,
            'Data' => $data,
            'Error' => '',
            'Message' => $msg,
        ];
    }

    public function closeConnect()
    {
        $this->curl->__destruct();
    }

}

