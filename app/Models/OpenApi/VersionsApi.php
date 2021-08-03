<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenApi;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;

class VersionsApi extends ModelService
{
    public $table = TABLE_SYS_VERSIONS;
    public $table_detail_ver = TABLE_SYS_VERSION_DETAILS;
    private $primaryKey = 'VERSION_CODE';

    /*********************************************************************************************************
     * Danh mục: VERSION
     *********************************************************************************************************/
    public function searchData($dataRequest = array())
    {
        try {
            $requestDefault = $this->dataRequestDefault;
            $requestDefault["p_keyword"] = (isset($dataRequest['s_search']) && trim($dataRequest['s_search']) != '') ? $dataRequest['s_search'] : '';
            $requestDefault["p_is_active"] = (isset($dataRequest['s_define_code']) && trim($dataRequest['s_define_code']) != '') ? $dataRequest['s_define_code'] : '';
            $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;

            return $this->searchDataCommon($requestDefault, ACTION_API_SEARCH_VERSIONS);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    /**
     * @param $dataInput
     * @param string $action
     * @return array
     */

    public function editItem($dataInput, $action = 'ADD')
    {
        $this->setUserSchemaDB(SCHEMA_OPEN_API);
        $item = $this->actionEditCommon($dataInput, $action, $this->table, ACTION_API_EDIT_VERSIONS);
        $this->removeCache($dataInput);
        return $item;
    }

    /**
     * @param int $menu_code
     * @return array
     */
    public function getItemById($code = '')
    {
        return $this->getDataCommonByOneKey($code, ACTION_API_GET_VERSIONS_BY_KEY, Memcache::CACHE_VERSIONS_BY_ID);
    }

    public function removeCache($data)
    {
        if (!isset($data['VER_ID']))
            return;
        Memcache::forgetCache(Memcache::CACHE_VERSIONS_BY_ID . $data['VER_ID']);
        Memcache::forgetCache(Memcache::CACHE_VERSIONS_ALL);
    }

    public function getAllVersion()
    {
        try {
            $key_cache = Memcache::CACHE_VERSIONS_ALL;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $requestDefault = $this->dataRequestDefault;
                $dataGet = $this->searchDataCommon($requestDefault, ACTION_API_ALL_VERSIONS);
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

    /*********************************************************************************************************
     * Danh mục: VERSION DETAIL
     *********************************************************************************************************/
    public function getDataDetailByVerCode($version_code = '')
    {
        if (trim($version_code) == '')
            return false;
        try {
            $keyCache = Memcache::CACHE_LIST_DETAIL_BY_VERSIONS_CODE.$version_code;
            $data = Memcache::getCache($keyCache);
            $data = false;
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_version_code"] = $version_code;
                $dataRequestDefault["p_page"] = STATUS_INT_MOT;

                $requestDefault['Action'] = ['ActionCode' => ACTION_API_GET_DETAIL_BY_VER];
                $requestDefault['Data'] = $dataRequestDefault;

                $resultApi = $this->postApiHD($requestDefault);
                $dataGet = $this->setDataFromApi($resultApi);
                $data = isset($dataGet['Data']['data']) ? $dataGet['Data']['data'] : false;
                if ($data && trim($keyCache) != '') {
                    Memcache::putCache($keyCache, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
     }
    public function editDetailVer($dataInput, $action = 'ADD')
    {
        $this->setUserSchemaDB(SCHEMA_OPEN_API);
        $item = $this->actionEditCommon($dataInput, $action, $this->table_detail_ver, ACTION_API_EDIT_DETAIL_VER);
        $this->removeCacheOther($dataInput);
        return $item;
    }

    /**
     * @param int $menu_code
     * @return array
     */
    public function getDetailVerById($code = '')
    {
        return $this->getDataCommonByOneKey($code, ACTION_API_GET_DETAIL_VER_BY_KEY, Memcache::CACHE_DETAIL_VERSIONS_BY_ID);
    }
    public function removeCacheOther($data)
    {
        if(!isset($data['DETAIL_ID']))
            return;
        Memcache::forgetCache(Memcache::CACHE_DETAIL_VERSIONS_BY_ID . $data['DETAIL_ID']);
        Memcache::forgetCache(Memcache::CACHE_LIST_DETAIL_BY_VERSIONS_CODE.$data['VERSION_CODE']);
    }
}
