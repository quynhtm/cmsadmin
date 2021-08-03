<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\Selling;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;

class Campaigns extends ModelService
{
    /*********************************************************************************************************
     * Danh mục: Campaigns
     *********************************************************************************************************/
    public $table = TABLE_MD_CAMPAIGNS;

    public function searchCampaigns($dataRequest = array())
    {
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_keyword"] = (isset($dataRequest['p_keyword'])) ? $dataRequest['p_keyword'] : '';
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        $requestDefault["p_gift_type"] = (isset($dataRequest['p_gift_type'])) ? $dataRequest['p_gift_type'] : '';
        $requestDefault["p_is_active"] = (isset($dataRequest['p_is_active'])) ? $dataRequest['p_is_active'] : '';
        $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;

        return $this->searchDataCommon($requestDefault, ACTION_SEARCH_CONFIG_CODE);
    }

    public function removeCache($data)
    {
        if (empty($data))
            return false;
        Memcache::forgetCache(Memcache::CACHE_CAMPAIGNS_ALL);
    }

    /**
     * @return array|bool: array[0=>,1=>]
     */
    public function getCampaignsAll()
    {
        try {
            $keyCache = Memcache::CACHE_CAMPAIGNS_ALL;
            $data = (trim($keyCache) != '') ? Memcache::getCache($keyCache) : false;
            if (!$data) {
                $this->setUserAction();
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_GET_ALL_MD_CAMPAIGNS];
                $dataRequest['Data'] = $dataRequestDefault;
                $search = $this->postApiHD($dataRequest);
                if ($search) {
                    if (isset($search->Success) && $search->Success == STATUS_INT_MOT) {
                        $data = isset($search->Data) ? $search->Data : false;
                    }
                    if ($data && trim($keyCache) != '') {
                        Memcache::putCache($keyCache, $data);
                    }
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function getArrOptionCampaigns($campaign_mode = '',$org_code = '')
    {
        $data = $this->getCampaignsAll();
        $option = [];
        if ($data) {
            $dataCampain = $data[0] ?? false;
            if ($dataCampain) {
                foreach ($dataCampain as $k => $item) {
                    if ($item->STATUS == 'OPEN') {
                        if(trim($campaign_mode) != ''){
                            if(trim($org_code) != ''){
                                if($item->CAMPAIGN_MODE == $campaign_mode && $item->ORG_CODE == $org_code){
                                    $option[$item->CAMPAIGN_CODE] = $item->CAMPAIGN_NAME;
                                }
                            }else{
                                if($item->CAMPAIGN_MODE == $campaign_mode){
                                    $option[$item->CAMPAIGN_CODE] = $item->CAMPAIGN_NAME;
                                }
                            }
                        }else{
                            if(trim($org_code) != ''){
                                if($item->ORG_CODE == $org_code){
                                    $option[$item->CAMPAIGN_CODE] = $item->CAMPAIGN_NAME;
                                }
                            }else {
                                $option[$item->CAMPAIGN_CODE] = $item->CAMPAIGN_NAME;
                            }
                        }
                    }
                }
            }
        }
        return $option;
    }

    public function getArrOptionOrgByCampaignCode($campaignCode = '')
    {
        $option = [];
        if (trim($campaignCode) == '')
            return $option;

        $data = $this->getCampaignsAll();
        if ($data) {
            $dataOrg = $data[1] ?? false;
            if ($dataOrg) {
                foreach ($dataOrg as $k => $item) {
                    if ($item->STATUS == 'OPEN' && $campaignCode == $item->CAMPAIGN_CODE) {
                        $option[$item->ORG_CODE_ASSIGN] = $item->ORG_NAME_ASSIGN;
                    }
                }
            }
        }
        return $option;
    }
    public function getArrOptionProduct()
    {
        $option = [];
        $data = $this->getCampaignsAll();
        if ($data) {
            $dataProduct = $data[2] ?? false;
            if ($dataProduct) {
                foreach ($dataProduct as $k => $item) {
                    $option[$item->PRODUCT_CODE] = $item->PRODUCT_NAME;
                }
            }
        }
        return $option;
    }
}
