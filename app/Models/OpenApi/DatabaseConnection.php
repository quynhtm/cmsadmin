<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenApi;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;

class DatabaseConnection extends ModelService
{
    /*********************************************************************************************************
     * DatabaseConnection
     *********************************************************************************************************/
    public $table = TABLE_SYS_DATABASE_DATA;
    private $fieldKey = 'GID';

    public function searchItem($dataRequest = array())
    {
        $dataRequestDefault = $this->dataRequestDefault;
        $dataRequestDefault["p_keyword"] = (isset($dataRequest['p_search'])) ? $dataRequest['p_search'] : '';
        $dataRequestDefault["p_is_active"] = (isset($dataRequest['p_is_active'])) ? $dataRequest['p_is_active'] : '';
        $dataRequestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;
        return $this->searchDataCommon($dataRequestDefault, ACTION_DEVOPS_SEARCH_DATABASES);
    }

    public function getDataAll()
    {
        return $this->getDataAllCommon(ACTION_DEVOPS_GET_DATABASES_ALL, Memcache::CACHE_DATABASES_ALL);
    }

    public function editItem($dataInput, $action = 'ADD')
    {
        $this->setUserSchemaDB(SCHEMA_DEVOPS);
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table, ACTION_DEVOPS_EDIT_DATABASES);
        $this->removeCache($dataInput);
        return $item;
    }

    public function getItemByKey($keyValue = '')
    {
        return $this->getDataCommonByOneKey($keyValue, ACTION_DEVOPS_GET_DATABASES_BY_KEY, Memcache::CACHE_DATABASES_BY_KEY);
    }

    public function removeCache($data)
    {
        if ($data) {
            if (isset($data[$this->fieldKey]))
                Memcache::forgetCache(Memcache::CACHE_DATABASES_BY_KEY . $data[$this->fieldKey]);
        }
        Memcache::forgetCache(Memcache::CACHE_DATABASES_ALL);
    }

    /*********************************************************************************************************
     * Function common
     *********************************************************************************************************/
    public function getOptionDatabase(){
        $data = $this->getDataAll();
        if($data){
            $option = [];
            foreach ($data as $k=>$db){
                if($db->ISACTIVE == STATUS_INT_MOT)
                $option[$db->DB_CODE] = $db->DB_NAME;
            }
            return $option;
        }
        return [];
    }
}
