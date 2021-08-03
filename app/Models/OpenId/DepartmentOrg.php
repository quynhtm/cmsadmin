<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenId;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Facades\Config;

class DepartmentOrg extends ModelService
{
    /*********************************************************************************************************
     * Danh mục phòng ban: DepartmentOrg
     *********************************************************************************************************/
    public $table = TABLE_SYS_STRUCT_COMPONENTS;
    private $fieldKey = 'STC_ID';

    public function searchItem($dataRequest = array())
    {
        if (empty($dataRequest))
            return $this->returnStatusError();
        try {
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
            $dataRequestDefault["p_keyword"] = (isset($dataRequest['p_keyword'])) ? $dataRequest['p_keyword'] : '';
            $dataRequestDefault["p_is_active"] = (isset($dataRequest['p_is_active'])) ? $dataRequest['p_is_active'] : '';
            return $this->searchDataCommon($dataRequestDefault, ACTION_SEARCH_DEPART);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function getDataAllByOrgCode($org_code = '')
    {
        if (empty($org_code))
            return $this->returnStatusError();
        try {
            $key_cache = Memcache::CACHE_ALL_DEPARTMENT_BY_KEY_CODE . $org_code;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $search['p_org_code'] = $org_code;
                $dataGet = $this->searchItem($search);
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

    public function editItem($dataInput, $action = 'ADD')
    {
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table, ACTION_EDIT_DEPART);
        $this->removeCache($dataInput);
        return $item;
    }

    public function getItemByKey($struct_code = '', $org_struct = '', $org_code = '')
    {
        if (trim($struct_code) == '' || trim($org_struct) == '' || trim($org_code) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_DEPARTMENT_BY_KEY . $struct_code . '_' . $org_struct . '_' . $org_code;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_org_code"] = $org_code;
                $dataRequestDefault["p_struct_code"] = $struct_code;
                $dataRequestDefault["p_org_struct"] = $org_struct;

                $dataRequest['Data'] = $dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_GET_DEPART_BY_KEY];

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

    public function deleteItem($dataItem = [])
    {
        $org_code = ($dataItem['ORG_CODE']) ? $dataItem['ORG_CODE'] : '';
        $struct_code = ($dataItem['STRUCT_CODE']) ? $dataItem['STRUCT_CODE'] : '';
        $org_struct = ($dataItem['ORG_STRUCT']) ? $dataItem['ORG_STRUCT'] : '';
        $is_active = ($dataItem['IS_ACTIVE']) ? $dataItem['IS_ACTIVE'] : '';

        if (trim($struct_code) == '' || trim($org_struct) == '' || trim($org_code) == '')
            return $this->returnStatusError();
        try {
            $this->setUserAction();
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_org_code"] = $org_code;
            $dataRequestDefault["p_struct_code"] = $struct_code;
            $dataRequestDefault["p_org_struct"] = $org_struct;
            $dataRequestDefault["p_is_active"] = ($is_active) ? STATUS_INT_KHONG : STATUS_INT_MOT;

            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = ['ActionCode' => ACTION_DELETE_DEPART];

            $resultApi = $this->postApiHD($dataRequest);
            $this->removeCache($dataItem);
            return $this->returnResponse($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function removeCache($data)
    {
        if ($data) {
           Memcache::forgetCache(Memcache::CACHE_DEPARTMENT_BY_KEY . $data['STRUCT_CODE'] . '_' . $data['ORG_STRUCT'] . '_' . $data['ORG_CODE'],Config::get('config.DOMAINS_PROJECT'));
           Memcache::forgetCache(Memcache::CACHE_ALL_DEPARTMENT_BY_KEY_CODE . $data['ORG_CODE'],Config::get('config.DOMAINS_PROJECT'));
        }
    }

    /*********************************************************************************************************
     * function liên quan tới department
     *********************************************************************************************************/
    public function getArrOptionDepartByOrgCode($orgCode = '',$option = true){
        $data = $this->getDataAllByOrgCode($orgCode);
        $arrDepart = [];
        if($data){
            foreach ($data as $depart){
                if($depart->IS_ACTIVE == STATUS_INT_MOT){
                    if($option){
                        $arrDepart[$depart->STRUCT_CODE] = getPrefixLevelName($depart->ORG_LEVEL).$depart->STRUCT_NAME;
                    }else{
                        $arrDepart[$depart->STRUCT_CODE] = $depart->STRUCT_NAME;
                    }
                }
            }
        }
        return $arrDepart;
    }

    public function searchStaffByDepart($dataRequest = array())
    {
        if (empty($dataRequest))
            return $this->returnStatusError();
        try {
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_org_code"] = (isset($dataRequest['ORG_CODE'])) ? $dataRequest['ORG_CODE'] : 'CENTECH_VN';
            $dataRequestDefault["p_struct_code"] = (isset($dataRequest['STRUCT_CODE'])) ? $dataRequest['STRUCT_CODE'] : 'R03';
            $dataRequestDefault["p_keyword"] = (isset($dataRequest['NAME_STAFF'])) ? $dataRequest['NAME_STAFF'] : '';
            $dataRequestDefault["p_isactive"] = (isset($dataRequest['IS_ACTIVE'])) ? $dataRequest['IS_ACTIVE'] : '';
            $dataRequestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;
            $dataRequest['Action'] = ['ActionCode' => ACTION_SEARCH_STAFF_BY_DEPART];
            $dataRequest['Data'] = $dataRequestDefault;
            $resultApi = $this->postApiHD($dataRequest);
            return $this->setDataFromApi($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }
    public function moveDepartOfStaff($str_user_code = '',$struct_code = '')
    {
        if (trim($struct_code) == '' || trim($str_user_code) == '' )
            return $this->returnStatusError();
        try {
            $this->setUserAction();
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_str_user_code"] = $str_user_code;
            $dataRequestDefault["p_struct_code"] = $struct_code;

            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = ['ActionCode' => ACTION_MOVE_STAFF_OF_DEPART];

            $resultApi = $this->postApiHD($dataRequest);
            return $this->returnResponse($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }
}
