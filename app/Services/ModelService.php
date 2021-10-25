<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 13/03/2020
* @Version   : 1.0
*/

namespace App\Services;

use App\Models\OpenId\UserSystem;
use App\Library\AdminFunction\Memcache;

class ModelService extends ServiceCurl
{
    private $schema_db = SCHEMA_OPEN_ID;
    public $userAdmin = false;

    public function setUserAction()
    {
        $user = new UserSystem();
        $userAdmin = $user->userLogin();
        $this->dataRequestDefault['p_username'] = isset($userAdmin['user_name']) ? $userAdmin['user_name'] : 'ADMIN.HDI';
    }

    public function setUserSchemaDB($database)
    {
        $this->schema_db = $database;
    }

    /**
     * Lấy 1 kết quả đầu tiên
     * @param array $dataRequest
     * @param string $actionCode
     * @return array
     */
    public function searchDataCommon($dataRequest = [], $actionCode = '')
    {
        if (trim($actionCode) == '' || empty($dataRequest))
            return $this->returnStatusError();
        try {
            $dataRequest['Action'] = ['ActionCode' => $actionCode];
            $dataRequest['Data'] = $dataRequest;
            $resultApi = $this->postApiHD($dataRequest);

            //myDebug($dataRequest);
            return $this->setDataPaging($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function searchDataOne($dataRequest = [], $actionCode = '')
    {
        if (trim($actionCode) == '' || empty($dataRequest))
            return $this->returnStatusError();
        try {
            $dataRequest['Action'] = ['ActionCode' => $actionCode];
            $dataRequest['Data'] = $dataRequest;
            $resultApi = $this->postApiHD($dataRequest);
            return $this->setDataOneResponce($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    /**
     * Get all kết quả trả về của api
     * @param array $dataRequest
     * @param string $actionCode
     * @return array
     */
    public function searchAllDataResponce($dataRequest = [], $actionCode = '')
    {
        if (trim($actionCode) == '' || empty($dataRequest))
            return $this->returnStatusError();
        try {
            $dataRequest['Action'] = ['ActionCode' => $actionCode];
            $dataRequest['Data'] = $dataRequest;
            $resultApi = $this->postApiHD($dataRequest);
            return $this->setDataResponce($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    /**
     * Lấy phần tử dầu tiên có phân trang
     * @param $response
     * @return array
     */
    public function setDataPaging($response)
    {
        $result = $this->returnStatusError();
        if (isset($response->Success) && $response->Success == STATUS_INT_MOT) {
            $data['data'] = isset($response->Data[0]) ? $response->Data[0] : false;
            $data['total'] = isset($response->Data[0][0]->TOTAL) ? $response->Data[0][0]->TOTAL : STATUS_INT_MOT;
            $result = $this->returnStatusSuccess($data);
        } else {
            $is_live = env('IS_LIVE', false);
            if ($is_live) {
                return $result;
            }
            myDebug($response);
        }
        return $result;
    }

    /**
     * Lấy phần tử đầu tiên trả ra
     * @param $response
     * @return array
     */
    public function setDataOneResponce($response)
    {
        $result = $this->returnStatusError();
        if (isset($response->Success) && $response->Success == STATUS_INT_MOT) {
            $data = isset($response->Data[0]) ? $response->Data[0] : false;
            $result = $this->returnStatusSuccess($data);
        } else {
            $is_live = env('IS_LIVE', false);
            if ($is_live) {
                return $result;
            }
            myDebug($response);
        }
        return $result;
    }

    /**
     * Lấy all data trả ra
     * @param $response
     * @return array
     */
    public function setDataResponce($response)
    {
        $result = $this->returnStatusError();
        if (isset($response->Success) && $response->Success == STATUS_INT_MOT) {
            $data = isset($response->Data) ? $response->Data : false;
            $result = $this->returnStatusSuccess($data);
        } else {
            $is_live = env('IS_LIVE', false);
            if ($is_live) {
                return $result;
            }
            myDebug('Du lieu tra ve dang loi',false);
            myDebug($response);
        }
        return $result;
    }

    public function checkReturnData($response)
    {
        if (isset($response->Success) && $response->Success) {
            return $this->returnStatusSuccess();
        } else {
            $msg = isset($response->ErrorMessage)?$response->ErrorMessage:'Có lỗi trả về';
            return $this->returnStatusError($msg);
        }
    }

    public function setDataFromApi($response)
    {
        return $this->setDataPaging($response);
    }

    /*********************************************************************************************************
     * List function Common action database with Api
     *********************************************************************************************************/
    public function getFieldByTableName($tableName = '', $userSchema = SCHEMA_OPEN_ID)
    {
        if (trim($tableName) == '')
            return [];

        $list_field = Memcache::getCache(Memcache::CACHE_LIST_FIELD_TABLE_NAME . $tableName);
        $list_field = false;
        if (!$list_field) {
            $request['Data']['p_owner'] = $userSchema;
            $request['Data']['p_table'] = $tableName;
            $request['Action'] = ['ActionCode' => ACTION_GET_FIELD_TABLE];
            $response = $this->postApiHD($request);
            if (isset($response->Success) && $response->Success == STATUS_INT_MOT) {
                $dataResp = $response->Data[0] ?? [];
                if ($dataResp) {
                    foreach ($dataResp as $obj_field) {
                        $list_field[$obj_field->COLUMN_NAME] = $obj_field->COLUMN_NAME;
                    }
                    Memcache::putCache(Memcache::CACHE_LIST_FIELD_TABLE_NAME . $tableName, $list_field, CACHE_ONE_MONTH);
                }
            }
        }
        return $list_field;
    }

    public function mergeFieldInputWithTable($dataNew = [], $table = '', &$dataOut = [], $arrTableRelation = [])
    {
        $arrField = $this->getFieldByTableName($table, $this->schema_db);
        if (!empty($dataNew) && !empty($arrField)) {
            foreach ($arrField as $key => $field) {
                if (isset($dataNew[trim($field)])) {
                    $dataOut[trim($field)] = trim($dataNew[trim($field)]);
                }
            }
            //lấy field các bảng liên quan nếu có
            if (!empty($arrTableRelation)) {
                foreach ($arrTableRelation as $k => $tableRelation) {
                    $arrFieldRelation = $this->getFieldByTableName($tableRelation, $this->schema_db);
                    foreach ($arrFieldRelation as $keyRelation => $fieldRelation) {
                        if (isset($dataNew[trim($fieldRelation)])) {
                            $dataOut[trim($fieldRelation)] = trim($dataNew[trim($fieldRelation)]);
                        }
                    }
                }
            }
            return $dataOut;
        }
        return [];
    }

    public function getDataAllCommon($actionCode = '', $keyCache = '')
    {
        if (trim($actionCode) == '')
            return false;
        try {
            $data = (trim($keyCache) != '') ? Memcache::getCache($keyCache) : false;
            if (!$data) {
                $dataRequest['Action'] = ['ActionCode' => $actionCode];
                $dataRequest['Data'] = $this->dataRequestDefault;
                $search = $this->postApiHD($dataRequest);
                if ($search) {
                    if (isset($search->Success) && $search->Success == STATUS_INT_MOT) {
                        $data = isset($search->Data[0]) ? $search->Data[0] : false;
                    }
                    if ($data && trim($keyCache) != '') {
                        Memcache::putCache($keyCache, $data);
                    }
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function actionEditCommon($dataInput = [], $action = 'ADD', $table = '', $actionCode = '', $arrTableRelation = [])
    {
        if (trim($table) == '' || trim($actionCode) == '' || trim($action) == '' || empty($dataInput))
            return $this->returnStatusError();
        try {
            $this->setUserAction();
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["P_ACTION"] = $action;
            $dataUpdate = $dataRequestDefault;

            $this->mergeFieldInputWithTable($dataInput, $table, $dataUpdate, $arrTableRelation);
            $dataRequest['Action'] = ['ActionCode' => $actionCode];
            $dataRequest['Data'] = $dataUpdate;

            $resultApi = $this->postApiHD($dataRequest);
            return $this->setDataOneResponce($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function deleteDataCommonByOneKey($keyValue = '', $actionCode = '')
    {
        if (trim($keyValue) == '' || trim($actionCode) == '')
            return $this->returnStatusError();
        try {
            $dataDelete = $this->dataRequestDefault;
            $dataDelete['p_key'] = $keyValue;
            $dataRequest['Action'] = ['ActionCode' => $actionCode];
            $dataRequest['Data'] = $dataDelete;

            $resultApi = $this->postApiHD($dataRequest);
            return $this->returnResponse($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function getDataCommonByOneKey($keyValue = '', $actionCode = '', $keyCache = '')
    {
        if (trim($keyValue) == '' || trim($actionCode) == '')
            return false;
        try {
            $data = (trim($keyCache) != '') ? Memcache::getCache($keyCache . $keyValue) : false;
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_key"] = $keyValue;

                $dataRequest['Action'] = ['ActionCode' => $actionCode];
                $dataRequest['Data'] = $dataRequestDefault;
                $resultApi = $this->postApiHD($dataRequest);

                $dataGet = $this->setDataOneResponce($resultApi);
                $data = isset($dataGet['Data'][0]) ? $dataGet['Data'][0] : false;

                if ($data && trim($keyCache) != '') {
                    Memcache::putCache($keyCache . $keyValue, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }
}

