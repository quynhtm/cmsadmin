<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenApi;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;

class BlackList extends ModelService
{
    public $table = TABLE_SYS_BLACK_LIST;
    public $table_ddos = TABLE_SYS_BLACK_LIST_DDOS;

    public function searchBlackList($dataRequest = array())
    {
        $dataRequestDefault = $this->dataRequestDefault;
        $dataRequestDefault["p_keyword"] = (isset($dataRequest['p_search'])) ? $dataRequest['p_search'] : '';
        $dataRequestDefault["p_is_active"] = (isset($dataRequest['p_is_active'])) ? $dataRequest['p_is_active'] : '';
        $dataRequestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;
        return $this->searchDataCommon($dataRequestDefault, ACTION_SEARCH_BLACK_LIST);
    }

    public function searchBlackListDdos($dataRequest = array())
    {
        $dataRequestDefault = $this->dataRequestDefault;
        $dataRequestDefault["p_keyword"] = (isset($dataRequest['p_search'])) ? $dataRequest['p_search'] : '';
        $dataRequestDefault["p_is_active"] = (isset($dataRequest['p_is_active'])) ? $dataRequest['p_is_active'] : '';
        $dataRequestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;
        return $this->searchDataCommon($dataRequestDefault, ACTION_SEARCH_BLACK_LIST_DDOS);
    }

}
