<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenId;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Facades\Config;

class GroupMenu extends ModelService
{
    public $table = TABLE_SYS_GROUP_MENU;
    private $primaryKey = 'GROUP_CODE';
    /**************************************************************************************
     * SYS_GROUP_MENU
     **************************************************************************************/
    public function searchData($dataRequest = array())
    {
        try {
            $requestDefault = $this->dataRequestDefault;
            $requestDefault["p_keyword"] = (isset($dataRequest['p_keyword']) && trim($dataRequest['p_keyword']) != '') ? $dataRequest['p_keyword'] : '';
            $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code']) && trim($dataRequest['p_org_code']) != '') ? $dataRequest['p_org_code'] : '';
            $requestDefault["p_is_active"] = (isset($dataRequest['p_is_active']) && trim($dataRequest['p_is_active']) != '') ? $dataRequest['p_is_active'] : '';
            $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;

            return $this->searchDataCommon($requestDefault, ACTION_SEARCH_GROUP_MENU);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function editItem($dataInput, $action = 'ADD')
    {
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table, ACTION_EDIT_GROUP_MENU);
        $this->removeCache($dataInput);
        return $item;
    }

    /**
     * @param array $dataInput
     * @return array
     */
    public function deleteItem($dataInput = [])
    {
        if (!isset($dataInput[$this->primaryKey]))
            return $this->returnStatusError();
        $this->setUserAction();
        $delete = $this->deleteDataCommonByOneKey($dataInput[$this->primaryKey], ACTION_DELETE_GROUP_MENU);
        $this->removeCache($dataInput);
        return $delete;
    }

    /**
     * @param int $menu_code
     * @return array
     */
    public function getItemById($code = '')
    {
        return $this->getDataCommonByOneKey($code, ACTION_GET_DATA_BY_GROUP_MENU, Memcache::CACHE_GROUP_MENU_BY_ID);
    }

    public function getDataByOrgCode($orgCode = '')
    {
        $keyCache = Memcache::CACHE_DETAIL_GROUP_MENU_BY_ORG_CODE. $orgCode;
        $data = (trim($keyCache) != '') ? Memcache::getCache($keyCache ) : false;
        $data = false;
        if (!$data) {
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_key"] = $orgCode;

            $dataRequest['Action'] = ['ActionCode' => ACTION_GET_GROUP_MENU_BY_ORG_CODE];
            $dataRequest['Data'] = $dataRequestDefault;
            $resultApi = $this->postApiHD($dataRequest);

            $dataGet = $this->setDataResponce($resultApi);
            $data = isset($dataGet['Data'][0]) ? $dataGet['Data'][0] : false;

            if ($data && trim($keyCache) != '') {
                Memcache::putCache($keyCache, $data);
            }
        }
        return $data;
    }

    public function removeCache($data)
    {
        if (isset($data[$this->primaryKey]) && (int)$data[$this->primaryKey] > 0){
            Memcache::forgetCache(Memcache::CACHE_GROUP_MENU_BY_ID . $data[$this->primaryKey],Config::get('config.DOMAINS_PROJECT'));
        }

    }

    /**************************************************************************************
     * SYS_GROUP_MENU_DETAILS
     **************************************************************************************/
    public function updateDataDetailGroup($dataInput)
    {
        $this->setUserAction();
        $dataRequestDefault = $this->dataRequestDefault;
        $dataRequestDefault["p_str_data_json"] = $dataInput['str_data_json'];

        $dataRequest['Action'] = ['ActionCode' => ACTION_EDIT_DETAIL_GROUP];
        $dataRequest['Data'] = $dataRequestDefault;

        $resultApi = $this->postApiHD($dataRequest);

        if (isset($dataInput['GROUP_CODE']) && isset($dataInput['ORG_CODE'])) {
            Memcache::forgetCache(Memcache::CACHE_DETAIL_GROUP_MENU_BY_KEY . $dataInput['GROUP_CODE']. '_' . $dataInput['ORG_CODE']);
        }
        return $this->setDataFromApi($resultApi);
    }

    public function getDetailGroupMenuByKey($group_code = '', $org_code = '')
    {
        if (trim($group_code) == '' || trim($org_code) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_DETAIL_GROUP_MENU_BY_KEY . $group_code . '_' . $org_code;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_group_code"] = $group_code;
                $dataRequestDefault["p_org_code"] = $org_code;

                $dataRequest['Data'] = $dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_GET_DETAIL_GROUP_MENU_BY_KEY];

                $resultApi = $this->postApiHD($dataRequest);
                $dataGet = $this->setDataFromApi($resultApi);
                $dataSearch = isset($dataGet['Data']['data']) ? $dataGet['Data']['data'] : false;
                if ($dataSearch) {
                    $data = $this->_buildOptionCheckDetailGroup($dataSearch);
                    Memcache::putCache($key_cache, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }
    private function _buildOptionCheckDetailGroup($data = []){
        $result = [];
        if(!empty($data)){
            foreach ($data as $k => $val){
                $result[$val->MENU_CODE][$val->CRUD] = $val->CRUD_LIMIT;
            }
        }
        return $result;
    }
}
