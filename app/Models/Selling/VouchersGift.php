<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\Selling;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;

class VouchersGift extends ModelService
{
    /*********************************************************************************************************
     * Danh mục: SYS_APIS
     *********************************************************************************************************/
    public $table = TABLE_GIFT_CONFIG_CODE;
    public $table_gift_config_values = TABLE_GIFT_CONFIG_VALUES;

    public function searchVoucherCode($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_keyword"] = (isset($dataRequest['p_keyword'])) ? $dataRequest['p_keyword'] : '';
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        $requestDefault["p_gift_type"] = (isset($dataRequest['p_gift_type'])) ? $dataRequest['p_gift_type'] : '';
        $requestDefault["p_is_active"] = (isset($dataRequest['p_is_active'])) ? $dataRequest['p_is_active'] : '';
        $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;

        return $this->searchDataCommon($requestDefault, ACTION_SEARCH_CONFIG_CODE);
    }

    public function searchVoucherDetails($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;

        $requestDefault["p_keyword"] = (isset($dataRequest['p_keyword'])) ? $dataRequest['p_keyword'] : '';
        $requestDefault["p_campaign_code"] = (isset($dataRequest['p_campaign_code'])) ? $dataRequest['p_campaign_code'] : '';
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        $requestDefault["p_gift_code"] = (isset($dataRequest['p_gift_code'])) ? $dataRequest['p_gift_code'] : '';
        $requestDefault["p_block_code"] = (isset($dataRequest['p_block_code'])) ? $dataRequest['p_block_code'] : '';
        $requestDefault["p_sort_order"] = (isset($dataRequest['p_sort_order'])) ? $dataRequest['p_sort_order'] : '';
        $requestDefault["p_status"] = (isset($dataRequest['p_status'])) ? $dataRequest['p_status'] : '';
        $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;

        return $this->searchDataCommon($requestDefault, ACTION_SEARCH_DETAIL_GIFT);
    }
    public function getVoucherCodeByKey($campaign_code = '',$gift_code = '',$gift_type = '')
    {
        if (trim($campaign_code) == '' || trim($gift_code) == '' || trim($gift_type) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_DATA_CONFIG_CODE_BY_KEY . $campaign_code . '_' . $gift_code . '_' . $gift_type;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_campaign_code"] = $campaign_code;
                $dataRequestDefault["p_gift_code"] = $gift_code;
                $dataRequestDefault["p_gift_type"] = $gift_type;
                $dataRequest['Data'] = $dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_GET_DATA_CONFIG_CODE_BY_KEY];

                $resultApi = $this->postApiHD($dataRequest);
                $dataGet = $this->setDataOneResponce($resultApi);
                $data = isset($dataGet['Data'][0]) ? $dataGet['Data'][0] : false;
                if ($data) {
                    Memcache::putCache($key_cache, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function editVoucherCode($dataInput, $action = 'ADD')
    {
        $this->setUserSchemaDB(SCHEMA_OPEN_MEDIA);
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table, ACTION_EDIT_CONFIG_CODE);
        $this->removeCache($dataInput);
        return $item;
    }

    public function updateStatusVoucherCode($data = [], $status = ''){
        if(isset($data['CAMPAIGN_CODE']) && isset($data['GIFT_CODE']) && isset($data['GIFT_TYPE']) && trim($status) != ''){
            $this->setUserAction();
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_campaign_code"] = $data['CAMPAIGN_CODE'];
            $dataRequestDefault["p_gift_code"] = $data['GIFT_CODE'];
            $dataRequestDefault["p_gift_type"] = $data['GIFT_TYPE'];
            $dataRequestDefault["p_status"] = $status;
            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = ['ActionCode' => ACTION_UPDATE_STATUS_CONFIG_CODE];

            $resultApi = $this->postApiHD($dataRequest);
            $this->removeCache($data);
            return $this->returnResponse($resultApi);
        }
        return $this->returnStatusError();
    }
    public function removeCache($data)
    {
        if (empty($data))
            return false;
        Memcache::forgetCache(Memcache::CACHE_DATA_CONFIG_CODE_BY_KEY . $data['CAMPAIGN_CODE'] . '_' . $data['GIFT_CODE'] . '_' . $data['GIFT_TYPE']);
    }

    public function getOptionDataByCampaignCode($campaign_code = '')
    {
        if (trim($campaign_code) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_CAMPAIGN_INFO_BY_CAMPAIGN_CODE . $campaign_code;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_campaign_code"] = $campaign_code;
                $dataRequest['Data'] = $dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_GET_CAMPAIGN_INFO_BY_KEY];

                $resultApi = $this->postApiHD($dataRequest);
                $dataGet = $this->setDataResponce($resultApi);
                $data2 = isset($dataGet['Data']) ? $dataGet['Data']: false;
                if ($data2) {
                    $dataProduct = $data2[0]??[];
                    $dataPack = $data2[1]??[];
                    $optionProduct = $optionPack = [];
                    if(!empty($dataProduct)){
                        foreach ($dataProduct as $kk => $p){
                            $optionProduct[$p->PRODUCT_CODE] = $p->PRODUCT_NAME;
                        }
                    }
                    if(!empty($dataPack)){
                        foreach ($dataPack as $k => $pa){
                            $optionPack[$pa->PACK_CODE] = $pa->PACK_NAME;
                        }
                    }
                    $data = ['optionProduct'=>$optionProduct,'optionPack'=>$optionPack];
                    Memcache::putCache($key_cache, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    /**************************************************************************************
     * Voucher Value
     **************************************************************************************/
    /**
     * @param int $gcv_id
     * @param string $status
     * @param string $approve_note
     * @return false|mixed|string
     */
    public function updateStatusVoucherValue($data = [],$gcv_id = 0, $status = '', $approve_note = ''){
        if((int)$gcv_id > 0 && trim($status) != ''){
            $this->setUserAction();
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_gcv_id"] = $gcv_id;
            $dataRequestDefault["p_status"] = $status;
            $dataRequestDefault["p_approve_note"] = $approve_note;
            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = ['ActionCode' => ACTION_UPDATE_STATUS_CONFIG_VALUE];
            $resultApi = $this->postApiHD($dataRequest);
            $this->removeVoucherValue($data);
            return $this->returnResponse($resultApi);
        }
        return $this->returnStatusError();
    }
    public function getListVoucherValueByKey($campaign_code = '',$gift_code = '',$gift_type = '',$key_search = '')
    {
        if (trim($campaign_code) == '' || trim($gift_code) == '' || trim($gift_type) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_ALL_VOUCHER_VALUE_BY_KEY . $campaign_code . '_' . $gift_code . '_' . $gift_type;
            $data = (trim($key_search) == '')?Memcache::getCache($key_cache): false;
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_campaign_code"] = $campaign_code;
                $dataRequestDefault["p_gift_code"] = $gift_code;
                $dataRequestDefault["p_gift_type"] = $gift_type;
                $dataRequestDefault["p_key_search"] = $key_search;
                $dataRequest['Data'] = $dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_LIST_CONFIG_VALUE];

                $resultApi = $this->postApiHD($dataRequest);
                $dataGet = $this->setDataPaging($resultApi);
                $data = isset($dataGet['Data']['data']) ? $dataGet['Data']['data'] : false;
                if ($data && trim($key_search) == '') {
                    Memcache::putCache($key_cache, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }
    public function editVoucherValue($dataInput, $action = 'ADD')
    {
        $this->setUserSchemaDB(SCHEMA_OPEN_MEDIA);
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table_gift_config_values, ACTION_EDIT_CONFIG_VALUE);
        $this->removeVoucherValue($dataInput);
        return $item;
    }

    public function editVoucherValuePresent($dataInput)
    {
        $this->setUserSchemaDB(SCHEMA_OPEN_MEDIA);
        $this->setUserAction();
        $dataRequestDefault = $this->dataRequestDefault;
        $dataUpdate = $dataRequestDefault;
        $dataUpdate['DATA_VOUCHER'] = json_encode($dataInput, false);

        $dataRequest['Action'] = ['ActionCode' => ACTION_UPDATE_VALUES_PRESENT];
        $dataRequest['Data'] = $dataUpdate;
        $resultApi = $this->postApiHD($dataRequest);

        return $this->setDataOneResponce($resultApi);

    }

    /**
     * Lấy dữ liệu cấp phát cho đối tác
     * @param string $campaign_code
     * @param string $gift_code
     * @param string $gift_type
     * @return array|bool|mixed
     */
    public function getVoucherValuesPresentByKey($campaign_code = '',$gift_code = '',$gift_type = '')
    {
        if (trim($campaign_code) == '' || trim($gift_code) == '' || trim($gift_type) == '')
            return false;
        try {
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_campaign_code"] = $campaign_code;
            $dataRequestDefault["p_gift_code"] = $gift_code;
            $dataRequestDefault["p_gift_type"] = $gift_type;
            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = ['ActionCode' => ACTION_GET_VALUES_PRESENT];

            $resultApi = $this->postApiHD($dataRequest);
            $dataGet = $this->setDataOneResponce($resultApi);
            $data = isset($dataGet['Data']) ? $dataGet['Data'] : false;

            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function getVoucherValueByKey($id = '')
    {
        if (trim($id) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_VOUCHER_VALUE_BY_KEY . $id;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_api_code"] = $id;
                $dataRequest['Data'] = $dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_GET_DATA_CONFIG_VALUE_BY_KEY];

                $resultApi = $this->postApiHD($dataRequest);
                $dataGet = $this->setDataOneResponce($resultApi);
                $data = isset($dataGet['Data'][0]) ? $dataGet['Data'][0] : false;
                if ($data) {
                    Memcache::putCache($key_cache, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function removeVoucherValue($data, $type = '')
    {
        if(isset($data['GCV_ID'])){
            Memcache::forgetCache(Memcache::CACHE_VOUCHER_VALUE_BY_KEY . $data['GCV_ID']);
        }
        Memcache::forgetCache(Memcache::CACHE_ALL_VOUCHER_VALUE_BY_KEY . $data['CAMPAIGN_CODE'] . '_' . $data['GIFT_CODE'] . '_' . $data['GIFT_TYPE']);
    }

    public function searchListVoucherDetail($dataRequest = array())
    {
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_campaign_code"] = (isset($dataRequest['p_campaign_code'])) ? $dataRequest['p_campaign_code'] : '';
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        $requestDefault["p_gift_code"] = (isset($dataRequest['p_gift_code'])) ? $dataRequest['p_gift_code'] : '';
        $requestDefault["p_block_code"] = (isset($dataRequest['p_block_code'])) ? $dataRequest['p_block_code'] : '';
        return $this->searchDataCommon($requestDefault, ACTION_EXPORT_GIFT_DETAIL);
    }
}
