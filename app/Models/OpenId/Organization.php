<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenId;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Facades\Config;

class Organization extends ModelService
{
    /*********************************************************************************************************
     * Danh mục tổ chức: ORGANIZATION
     *********************************************************************************************************/
    public $table = TABLE_SYS_ORG;
    public $table_org_bank = TABLE_SYS_ORG_BANK;
    public $table_org_contracts = TABLE_SYS_ORG_CONTRACTS;
    public $table_org_structs = TABLE_SYS_ORG_STRUCTS;
    public $table_org_relationship = TABLE_SYS_ORG_RELATIONSHIP;

    public function searchOrganization($dataRequest = array())
    {
        $dataRequestDefault = $this->dataRequestDefault;
        $dataRequestDefault["p_keyword"] = (isset($dataRequest['p_keyword'])) ? $dataRequest['p_keyword'] : '';
        $dataRequestDefault["p_org_type"] = (isset($dataRequest['p_org_type'])) ? $dataRequest['p_org_type'] : '';
        $dataRequestDefault["p_is_active"] = (isset($dataRequest['p_is_active'])) ? $dataRequest['p_is_active'] : '';
        $dataRequestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;
        return $this->searchDataCommon($dataRequestDefault, ACTION_SEARCH_ORG);
    }

    public function getOrganizationByKey($org_code = '')
    {
        return $this->getDataCommonByOneKey($org_code, ACTION_GET_DATA_ORG_BY_ID, Memcache::CACHE_ORGANIZATION_BY_KEY);
    }

    public function getOrganizationAll()
    {
        return $this->getDataAllCommon(ACTION_GET_DATA_ORG_ALL, Memcache::CACHE_ORGANIZATION_ALL);
    }

    public function editOrganization($dataInput, $action = 'ADD')
    {
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table, ACTION_EDIT_ORG);
        $this->removeCacheOrg($dataInput);
        return $item;
    }

    public function deleteOrganization($dataInput = [])
    {
        if (!isset($dataInput['ORG_CODE']))
            return $this->returnStatusError();
        $this->setUserAction();
        $delete = $this->deleteDataCommonByOneKey($dataInput['ORG_CODE'], ACTION_DELETE_ORG);
        $this->removeCacheOrg($dataInput);
        return $delete;
    }

    public function removeCacheOrg($data)
    {
        Memcache::forgetCache(Memcache::CACHE_ORGANIZATION_ALL,Config::get('config.DOMAINS_PROJECT'));

        if (isset($data['ORG_CODE'])){
            Memcache::forgetCache(Memcache::CACHE_ORGANIZATION_BY_KEY . $data['ORG_CODE'],Config::get('config.DOMAINS_PROJECT'));
        }
    }

    /**
     * @param string $orgCode
     * @param string $relation : B:Bank, C:contract, S:Struct, R:Relationship, ALL
     * @return array
     */
    public function getDataRelationByOrgCode($orgCode = '', $relation = DEFINE_ALL, $page_no = STATUS_INT_MOT)
    {
        if ($orgCode == '')
            return returnError('Dữ liệu đầu vào không đúng');
        try {
            $key_cache = Memcache::CACHE_ORGANIZATION_DATA_RELATION_BY_ORG_CODE . $orgCode . '_' . $relation;
            $data = Memcache::getCache($key_cache);
            $data = false;
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_OrgCode"] = $orgCode;
                $dataRequestDefault["p_Type"] = $relation;
                $dataRequestDefault["p_Page"] = $page_no;
                $dataRequest['Action'] = ['ActionCode' => ACTION_GET_DATA_RELATION_BY_ORG_CODE];
                $dataRequest['Data'] = $dataRequestDefault;

                $resultApi = $this->postApiHD($dataRequest);
                $data = $this->setDataFromApi($resultApi);

                if ($data) {
                    Memcache::putCache($key_cache, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    /*Banks*/
    public function editOrgBank($dataInput, $action = 'ADD')
    {
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table_org_bank, ACTION_EDIT_ORG_BANK);
        $this->removeCacheRelationOrg($dataInput, 'B');
        return $item;
    }

    public function getOrgBankByKey($orgCode = '', $bankCode = '')
    {
        if (trim($orgCode) == '' || trim($bankCode) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_ORG_BANK_BY_KEY . $orgCode . '_' . $bankCode;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_OrgCode"] = $orgCode;
                $dataRequestDefault["p_BankCode"] = $bankCode;
                $dataRequest['Data'] = $dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_GET_DATA_ORG_BANK_BY_KEY];

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

    public function deleteOrgBankByKey($dataItem)
    {
        $orgCode = ($dataItem['ORG_CODE']) ? $dataItem['ORG_CODE'] : '';
        $bankCode = ($dataItem['BRANCH_CODE']) ? $dataItem['BRANCH_CODE'] : '';
        $isActive = ($dataItem['IS_ACTIVE']) ? $dataItem['IS_ACTIVE'] : '';
        if (trim($orgCode) == '' || trim($bankCode) == '')
            return $this->returnStatusError();
        try {
            $this->setUserAction();
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_OrgCode"] = $orgCode;
            $dataRequestDefault["p_BankCode"] = $bankCode;
            $dataRequestDefault["p_IsActive"] = ($isActive) ? STATUS_INT_KHONG : STATUS_INT_MOT;
            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = ['ActionCode' => ACTION_DELETE_ORG_BANK];

            $resultApi = $this->postApiHD($dataRequest);
            $dataItem['BANK_CODE'] = $dataItem['BRANCH_CODE'];
            $this->removeCacheRelationOrg($dataItem, 'B');
            return $this->returnResponse($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    /*Contracts*/
    public function editOrgContracts($dataInput, $action = 'ADD')
    {
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table_org_contracts, ACTION_EDIT_ORG_CONTRACT);
        $this->removeCacheRelationOrg($dataInput, 'C');
        return $item;
    }

    public function getOrgContractsByKey($orgCode = '', $orgPartnerCode = '', $structNo = '')
    {
        if (trim($orgCode) == '' || trim($orgPartnerCode) == '' || trim($structNo) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_ORG_CONTRACT_BY_KEY . $orgCode . '_' . $orgPartnerCode . '_' . $structNo;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_OrgCode"] = $orgCode;
                $dataRequestDefault["p_PartnerCode"] = $orgPartnerCode;
                $dataRequestDefault["p_StructNo"] = $structNo;
                $dataRequest['Data'] = $dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_GET_DATA_ORG_CONTRACT_BY_KEY];

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

    public function deleteOrgContractsByKey($dataItem)
    {
        $orgCode = ($dataItem['ORG_CODE']) ? $dataItem['ORG_CODE'] : '';
        $structNo = ($dataItem['STRUCT_NO']) ? $dataItem['STRUCT_NO'] : '';
        $orgPartnerCode = ($dataItem['ORG_PARTNER_CODE']) ? $dataItem['ORG_PARTNER_CODE'] : '';
        $isActive = ($dataItem['IS_ACTIVE']) ? $dataItem['IS_ACTIVE'] : '';
        if (trim($orgCode) == '' || trim($structNo) == '' || trim($orgPartnerCode) == '')
            return $this->returnStatusError();
        try {
            $this->setUserAction();
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_OrgCode"] = $orgCode;
            $dataRequestDefault["p_OrgPartnerCode"] = $orgPartnerCode;
            $dataRequestDefault["p_StructNo"] = $structNo;
            $dataRequestDefault["p_IsActive"] = ($isActive) ? STATUS_INT_KHONG : STATUS_INT_MOT;
            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = ['ActionCode' => ACTION_DELETE_ORG_CONTRACT_BY_KEY];

            $resultApi = $this->postApiHD($dataRequest);
            $this->removeCacheRelationOrg($dataItem, 'C');
            return $this->returnResponse($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    /*Structs*/
    public function editOrgStructs($dataInput, $action = 'ADD')
    {
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table_org_structs, ACTION_EDIT_ORG_STRUCTS);
        $this->removeCacheRelationOrg($dataInput, 'S');
        return $item;
    }

    public function getOrgStructsByKey($orgCode = '', $orgType = '', $orgStruct = '')
    {
        if (trim($orgCode) == '' || trim($orgType) == '' || trim($orgStruct) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_ORG_STRUCT_BY_KEY . $orgCode . '_' . $orgType . '_' . $orgStruct;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_OrgCode"] = $orgCode;
                $dataRequestDefault["p_OrgType"] = $orgType;
                $dataRequestDefault["p_OrgStruct"] = $orgStruct;
                $dataRequest['Data'] = $dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_GET_DATA_ORG_STRUCTS_BY_KEY];

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

    public function deleteOrgStructsByKey($dataItem)
    {
        $orgCode = ($dataItem['ORG_CODE']) ? $dataItem['ORG_CODE'] : '';
        $orgType = ($dataItem['ORG_TYPE']) ? $dataItem['ORG_TYPE'] : '';
        $orgStruct = ($dataItem['ORG_STRUCT']) ? $dataItem['ORG_STRUCT'] : '';
        $isActive = ($dataItem['IS_ACTIVE']) ? $dataItem['IS_ACTIVE'] : '';
        if (trim($orgCode) == '' || trim($orgType) == '' || trim($orgStruct) == '')
            return $this->returnStatusError();
        try {
            $this->setUserAction();
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_OrgCode"] = $orgCode;
            $dataRequestDefault["p_OrgType"] = $orgType;
            $dataRequestDefault["p_OrgStruct"] = $orgStruct;
            $dataRequestDefault["p_IsActive"] = ($isActive) ? STATUS_INT_KHONG : STATUS_INT_MOT;
            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = ['ActionCode' => ACTION_DELETE_ORG_STRUCTS_BY_KEY];

            $resultApi = $this->postApiHD($dataRequest);
            $this->removeCacheRelationOrg($dataItem, 'S');
            return $this->returnResponse($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    /*Relationship*/
    public function editOrgRelationship($dataInput, $action = 'ADD')
    {
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table_org_relationship, ACTION_EDIT_ORG_RELATIONSHIP);
        $this->removeCacheRelationOrg($dataInput, 'R');
        return $item;
    }

    public function getOrgRelationshipByKey($orgCode = '', $orgCodeParent = '')
    {
        if (trim($orgCode) == '' || trim($orgCodeParent) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_ORG_RELATIONSHIP_BY_KEY . $orgCode . '_' . $orgCodeParent;
            $data = Memcache::getCache($key_cache);
            $data = false;
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_OrgCode"] = $orgCode;
                $dataRequestDefault["p_OrgCodeParent"] = $orgCodeParent;
                $dataRequest['Data'] = $dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_GET_DATA_ORG_RELATIONSHIP_BY_KEY];

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

    public function deleteOrgRelationshipByKey($dataItem)
    {
        $orgCode = ($dataItem['ORG_CODE']) ? $dataItem['ORG_CODE'] : '';
        $orgCodeParent = ($dataItem['ORG_CODE_PARENT']) ? $dataItem['ORG_CODE_PARENT'] : '';
        $isActive = ($dataItem['IS_ACTIVE']) ? $dataItem['IS_ACTIVE'] : '';
        if (trim($orgCode) == '' || trim($orgCodeParent) == '')
            return $this->returnStatusError();
        try {
            $this->setUserAction();
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_OrgCode"] = $orgCode;
            $dataRequestDefault["p_OrgCodeParent"] = $orgCodeParent;
            $dataRequestDefault["p_IsActive"] = ($isActive) ? STATUS_INT_KHONG : STATUS_INT_MOT;
            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = ['ActionCode' => ACTION_DELETE_ORG_RELATIONSHIP_BY_KEY];

            $resultApi = $this->postApiHD($dataRequest);
            $this->removeCacheRelationOrg($dataItem, 'R');
            return $this->returnResponse($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function removeCacheRelationOrg($data, $type)
    {
        Memcache::forgetCache(Memcache::CACHE_ORGANIZATION_DATA_RELATION_BY_ORG_CODE . $data['ORG_CODE'] . '_' . $type);
        if ($type == 'B') {
            Memcache::forgetCache(Memcache::CACHE_ORG_BANK_BY_KEY . $data['ORG_CODE'] . '_' . $data['BANK_CODE']);
        }
        if ($type == 'C') {
            Memcache::forgetCache(Memcache::CACHE_ORG_CONTRACT_BY_KEY . $data['ORG_CODE'] . '_' . $data['ORG_PARTNER_CODE'] . '_' . $data['STRUCT_NO']);
        }
        if ($type == 'S') {
            Memcache::forgetCache(Memcache::CACHE_ORG_STRUCT_BY_KEY . $data['ORG_CODE'] . '_' . $data['ORG_TYPE'] . '_' . $data['ORG_STRUCT']);
        }
        if ($type == 'R') {
            Memcache::forgetCache(Memcache::CACHE_ORG_RELATIONSHIP_BY_KEY . $data['ORG_CODE'] . '_' . $data['ORG_CODE_PARENT']);
        }
    }

    //Common
    public function getArrOptionOrg()
    {
        $data = $this->getOrganizationAll();
        $option = [];
        if ($data) {
            foreach ($data as $k => $org) {
                if ($org->IS_ACTIVE == STATUS_INT_MOT) {
                    $option[$org->ORG_CODE] = $org->ORG_NAME;
                }
            }
        }
        return $option;
    }

}
