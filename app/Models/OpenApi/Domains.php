<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenApi;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;

class Domains extends ModelService
{
    /*********************************************************************************************************
     * Domains
     *********************************************************************************************************/
    public $table = TABLE_SYS_DOMAINS;
    private $fieldKey = 'DOMAIN_ID';

    public function searchItem($dataRequest = array())
    {
        $dataRequestDefault = $this->dataRequestDefault;
        $dataRequestDefault["p_keyword"] = (isset($dataRequest['p_search'])) ? $dataRequest['p_search'] : '';
        $dataRequestDefault["p_is_active"] = (isset($dataRequest['p_is_active'])) ? $dataRequest['p_is_active'] : '';
        $dataRequestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;
        return $this->searchDataCommon($dataRequestDefault, ACTION_SEARCH_DOMAINS);
    }

    public function getDataAll()
    {
        return $this->getDataAllCommon(ACTION_GET_DOMAINS_ALL, Memcache::CACHE_DOMAINS_BY_KEY);
    }

    public function editItem($dataInput, $action = 'ADD')
    {
        $this->setUserSchemaDB(SCHEMA_OPEN_API);
        $item = $this->actionEditCommon($dataInput, $action, $this->table, ACTION_EDIT_DOMAINS);
        $this->removeCache($dataInput);
        return $item;
    }

    public function getItemByKey($keyValue = '')
    {
        return $this->getDataCommonByOneKey($keyValue, ACTION_GET_DOMAINS_BY_KEY, Memcache::CACHE_DOMAINS_ALL);
    }

    public function removeCache($data)
    {
        if ($data) {
            if (isset($data[$this->fieldKey]))
                Memcache::forgetCache(Memcache::CACHE_DOMAINS_ALL . $data[$this->fieldKey]);
        }
        Memcache::forgetCache(Memcache::CACHE_DOMAINS_BY_KEY);
    }

    /*********************************************************************************************************
     * Function common
     *********************************************************************************************************/
}
