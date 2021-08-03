<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenId;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Facades\Config;

class TypeDefine extends ModelService
{
    public $table = TABLE_SYS_TYPE_DEFINES;
    private $primaryKey = 'ID';
    public function searchData($dataRequest = array())
    {
        try {
            $requestDefault = $this->dataRequestDefault;
            $requestDefault["p_keyword"] = (isset($dataRequest['s_search']) && trim($dataRequest['s_search']) != '') ? $dataRequest['s_search'] : '';
            $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;
            $requestDefault["p_is_active"] = (isset($dataRequest['s_define_code']) && trim($dataRequest['s_define_code']) != '') ? $dataRequest['s_define_code'] : '';

            return $this->searchDataCommon($requestDefault, ACTION_SEARCH_TYPE_DEFINE);
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
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table, ACTION_EDIT_TYPE_DEFINE);
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
        $delete = $this->deleteDataCommonByOneKey($dataInput[$this->primaryKey], ACTION_DELETE_TYPE_DEFINE);
        $this->removeCache($dataInput);
        return $delete;
    }

    /**
     * @param int $menu_code
     * @return array
     */
    public function getItemById($code = '')
    {
        return $this->getDataCommonByOneKey($code, ACTION_GET_DATA_BY_TYPE_DEFINE, Memcache::CACHE_TYPE_DEFINE_BY_ID);
    }

    public function removeCache($data)
    {
        if (isset($data[$this->primaryKey]) && (int)$data[$this->primaryKey] > 0){
            Memcache::forgetCache(Memcache::CACHE_TYPE_DEFINE_BY_ID . $data[$this->primaryKey],Config::get('config.DOMAINS_PROJECT'));
        }
        Memcache::forgetCache(Memcache::CACHE_TYPE_DEFINE_ALL,Config::get('config.DOMAINS_PROJECT'));
    }

    public function searchAllTypeDefine($dataRequest = array())
    {
        $data = Memcache::getCache(Memcache::CACHE_TYPE_DEFINE_ALL);
        if (!$data) {
            $dataRequest['Action'] = ['ActionCode' => ACTION_ALL_TYPE_DEFINE];
            $dataRequest['Data'] = $this->dataRequestDefault;
            $search = $this->postApiHD($dataRequest);
            if ($search) {
                if (isset($search->Success) && $search->Success == STATUS_INT_MOT) {
                    $data = isset($search->Data[0]) ? $search->Data[0] : false;
                }
                if($data){
                    Memcache::putCache(Memcache::CACHE_TYPE_DEFINE_ALL, $data);
                }
            }
        }
        return $data;
    }

    public function getOptionTypeDefine($define_code = '', $project_code = 'ALL', $langue = '')
    {
        $dataAll = $this->searchAllTypeDefine();
        $option = [];
        if ($dataAll) {
            foreach ($dataAll as $k => $val) {
                if($project_code == $val->PROJECT_CODE && $define_code == $val->DEFINE_CODE && $val->IS_ACTIVE == STATUS_INT_MOT && ($langue == $val->LANGUAGE || $langue == '')){
                    $option[$val->TYPE_CODE] = $val->TYPE_NAME;
                }
            }
        }
        return $option;
    }

    public function getOptionAllDefineCode()
    {
        $dataAll = $this->searchAllTypeDefine();
        $option = [];
        if ($dataAll) {
            foreach ($dataAll as $k => $val) {
                $option[$val->DEFINE_CODE] = $val->DEFINE_NAME;
            }
        }
        return $option;
    }
}
