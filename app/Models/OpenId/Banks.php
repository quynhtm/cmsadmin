<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenId;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Facades\Config;

class Banks extends ModelService
{
    /*********************************************************************************************************
     * Danh mục ngân hàng: Banks
     *********************************************************************************************************/
    public $table = TABLE_SYS_BANK;
    private $fieldKey = 'BANK_ID';

    public function searchItem($dataRequest = array())
    {
        $dataRequestDefault = $this->dataRequestDefault;
        $dataRequestDefault["p_keyword"] = (isset($dataRequest['p_search'])) ? $dataRequest['p_search'] : '';
        $dataRequestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;
        return $this->searchDataCommon($dataRequestDefault, ACTION_SEARCH_BANK);
    }

    public function getDataAll()
    {
        return $this->getDataAllCommon(ACTION_GET_BANK_ALL, Memcache::CACHE_BANK_ALL);
    }

    public function editItem($dataInput, $action = 'ADD')
    {
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table, ACTION_EDIT_BANK);
        $this->removeCache($dataInput);
        return $item;
    }

    public function getItemByKey($keyValue = '')
    {
        return $this->getDataCommonByOneKey($keyValue, ACTION_GET_BANK_BY_KEY, Memcache::CACHE_BANK_BY_KEY);
    }

    public function deleteItem($dataInput = [])
    {
        if (!isset($dataInput[$this->fieldKey]))
            return $this->returnStatusError();
        $this->setUserAction();
        $delete = $this->deleteDataCommonByOneKey($dataInput[$this->fieldKey], ACTION_DELETE_BANK);
        $this->removeCache($dataInput);
        return $delete;
    }

    public function removeCache($data)
    {
        if ($data) {
            if (isset($data[$this->fieldKey]))
                Memcache::forgetCache(Memcache::CACHE_BANK_BY_KEY . $data[$this->fieldKey],Config::get('config.DOMAINS_PROJECT'));
        }
        Memcache::forgetCache(Memcache::CACHE_BANK_ALL,Config::get('config.DOMAINS_PROJECT'));
    }

    /*********************************************************************************************************
     * Function riêng cho Banks
     *********************************************************************************************************/
    public function getArrOptionBank(){
        $dataBank = $this->getDataAll();
        if($dataBank){
            $result = [];
            foreach ($dataBank as $k=>$bank){
                if($bank->IS_ACTIVE == STATUS_INT_MOT){
                    if(trim($bank->PARENT_CODE) == ''){
                        $result[$bank->BANK_CODE][$bank->BANK_CODE] = $bank->BANK_NAME;
                    }else{
                        $result[$bank->PARENT_CODE][$bank->BANK_CODE] = '--- '.$bank->BANK_NAME;
                    }
                }
            }
        }
        return $result;
    }
    public function getArrOptionBankParent(){
        $dataBank = $this->getDataAll();
        if($dataBank){
            $result = [];
            foreach ($dataBank as $k=>$bank){
                if($bank->IS_ACTIVE == STATUS_INT_MOT){
                    if(trim($bank->PARENT_CODE) == ''){
                        $result[$bank->BANK_CODE] = $bank->BANK_NAME;
                    }
                }
            }
        }
        return $result;
    }
}
