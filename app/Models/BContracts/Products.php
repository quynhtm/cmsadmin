<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\BContracts;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Products extends ModelService
{
    /*********************************************************************************************************
     * Danh mục tổ chức: TABLE_B_CONTRACTS_PRODUCTS
     *********************************************************************************************************/
    public $table = TABLE_B_CONTRACTS_PRODUCTS;

    public function searchProduct($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_keyword"] = (isset($dataRequest['p_keyword'])) ? $dataRequest['p_keyword'] : '';
        $requestDefault["p_status"] = (isset($dataRequest['p_status'])) ? $dataRequest['p_status'] : '';
        $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;
        return $this->searchDataCommon($requestDefault, ACTION_B_CONTRACTS_SEARCH_PRODUCT);
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

    public function removeCache($data)
    {
        if ($data) {
            if (isset($data[$this->fieldKey]))
                Memcache::forgetCache(Memcache::CACHE_BANK_BY_KEY . $data[$this->fieldKey],Config::get('config.DOMAINS_PROJECT'));
        }
        Memcache::forgetCache(Memcache::CACHE_BANK_ALL,Config::get('config.DOMAINS_PROJECT'));
    }

    public function getProductWithUserCode($user_code = '')
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_user_code"] = $user_code;

        $requestDefault['Action'] = ['ActionCode' => ACTION_B_CONTRACTS_GET_PRODUCT_BY_USER_CODE];
        $requestDefault['Data'] = $requestDefault;
        $resultApi = $this->postApiHD($requestDefault);

        $dataGet = $this->setDataOneResponce($resultApi);
        $data = isset($dataGet['Data']) ? $dataGet['Data'] : false;
        return $data;
    }

    public function editProductWithUser($dataInput = [])
    {
        if (empty($dataInput))
            return $this->returnStatusError();
        $this->setUserAction();
        $dataUpdate = $this->dataRequestDefault;

        $dataUpdate['p_user_code'] = $dataInput['USER_CODE'];
        $dataUpdate['p_org_code'] = $dataInput['ORG_CODE'];
        $dataUpdate['p_struct_code'] = $dataInput['STRUCT_CODE'];
        $dataUpdate['p_str_product_user'] = $dataInput['STR_PRODUCT_USER'];

        $dataRequest['Action'] = ['ActionCode' => ACTION_B_CONTRACTS_ADD_PRODUCT_USER];
        $dataRequest['Data'] = $dataUpdate;

        $resultApi = $this->postApiHD($dataRequest);
        return $this->returnResponse($resultApi);
    }
}
