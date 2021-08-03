<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenApi;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;

class ApiSystem extends ModelService
{
    /*********************************************************************************************************
     * Danh mục: SYS_APIS
     *********************************************************************************************************/
    public $table = TABLE_SYS_ACTION_API;
    public $table_api_databases = TABLE_SYS_API_DATABASE;

    public function searchApi($dataRequest = array())
    {
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_keyword"] = (isset($dataRequest['p_keyword'])) ? $dataRequest['p_keyword'] : '';
        $requestDefault["p_is_active"] = (isset($dataRequest['p_is_active'])) ? $dataRequest['p_is_active'] : '';
        $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;

        return $this->searchDataCommon($requestDefault, ACTION_DEVOPS_SEARCH_APIS);
    }

    public function getApiByKey($org_code = '')
    {
        return $this->getDataCommonByOneKey($org_code, ACTION_DEVOPS_GET_APIS_BY_KEY, Memcache::CACHE_APIS_BY_KEY);
    }

    public function editApi($dataInput, $action = 'ADD')
    {
        $this->setUserSchemaDB(SCHEMA_OPEN_API);
        if (trim($action) == '' || empty($dataInput))
            return $this->returnStatusError();
        try {
            $this->setUserAction();
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["P_ACTION"] = $action;
            foreach ($dataInput as $key =>$value){
                $dataRequestDefault[trim($key)] = trim($value);
            }
            $dataRequest['Action'] = ['ActionCode' => ACTION_DEVOPS_EDIT_APIS];
            $dataRequest['Data'] = $dataRequestDefault;
            $resultApi = $this->postApiHD($dataRequest);
            $this->removeCache($dataInput);

            return $this->setDataOneResponce($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
        return false;
    }

    public function getAllApi()
    {
        try {
            $key_cache = Memcache::CACHE_APIS_ALL;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $requestDefault = $this->dataRequestDefault;
                $dataGet = $this->searchDataCommon($requestDefault, ACTION_GET_APIS_ALL);
                $data = isset($dataGet['Data']['data']) ? $dataGet['Data']['data'] : false;
                if ($data) {
                    Memcache::putCache($key_cache, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function removeCache($data)
    {
        if (!isset($data['API_CODE']))
            return false;
        Memcache::forgetCache(Memcache::CACHE_APIS_BY_KEY . $data['GID']);
        Memcache::forgetCache(Memcache::CACHE_APIS_ALL);
        Memcache::forgetCache(Memcache::CACHE_DATABASES_ALL);
    }

    /**************************************************************************************
     * DATABASES
     **************************************************************************************/
    public function editDatabases($dataInput, $action = 'ADD')
    {
        $this->setUserSchemaDB(SCHEMA_DEVOPS);
        $item = $this->actionEditCommon($dataInput, $action, $this->table_api_databases, ACTION_DEVOPS_EDIT_DATABASES_BY_ID);
        $this->removeCacheRelation($dataInput);
        return $item;
    }

    public function getDatabasesById($gid = '')
    {
        if (trim($gid) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_DATABASES_APIS_BY_ID . $gid;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_api_code"] = $gid;
                $dataRequest['Data'] = $dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_DEVOPS_GET_DATABASES_BY_ID];

                $resultApi = $this->postApiHD($dataRequest);
                $dataGet = $this->setDataFromApi($resultApi);
                $data = isset($dataGet['Data']['data'][0]) ? $dataGet['Data']['data'][0] : false;
                if ($data) {
                    Memcache::putCache($key_cache, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }
    public function getDatabasesByKey($api_code = '')
    {
        if (trim($api_code) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_DATABASES_APIS_BY_KEY . $api_code;
            $data = Memcache::getCache($key_cache);
            $data = false;
            if (!$data) {
                $this->setUserAction();
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_api_code"] = $api_code;
                $dataRequest['Data'] = $dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_DEVOPS_GET_DATABASES_BY_API_CODE];
                $resultApi = $this->postApiHD($dataRequest);
                $dataGet = $this->setDataFromApi($resultApi);
                $data = isset($dataGet['Data']['data']) ? $dataGet['Data']['data'] : false;
                if ($data) {
                    Memcache::putCache($key_cache, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function removeCacheRelation($data, $type = '')
    {
        if (isset($data['GID']) && isset($data['GID'])) {
            Memcache::forgetCache(Memcache::CACHE_DATABASES_APIS_BY_ID . $data['GID']);
        }
    }
}
