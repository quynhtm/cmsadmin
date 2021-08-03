<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\Selling;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use App\Services\ServiceCommon;
use Illuminate\Support\Facades\Config;

class InsurancePolicy extends ModelService
{
    /*********************************************************************************************************
     * Danh mục: An tâm tín dụng
     *********************************************************************************************************/
    public $table = TABLE_GIFT_CONFIG_CODE;

    public function buildParamDataEdit()
    {
        $receiver = $pay_info = $loan = $flight = $health_care = null;
        $seller = [
            "SELLER_CODE" => null,
            "SELLER_NAME" => null,
            "SELLER_EMAIL" => null,
            "SELLER_PHONE" => null,
            "SELLER_GENDER" =>null,
            "STRUCT_CODE" => null,
            "ORG_CODE" => "HDBANK_VN",
            "BRANCH_CODE" => null,
            "ORG_TRAFFIC" => null,
            "TRAFFIC_LINK" => null,
            "ENVIROMENT" => "SDK_HD_BANK"
        ];
        $buyer = [
            "ID" => null,
            "TYPE" => "CN",
            "NAME" => "tuvm",
            "DOB" => "11/03/1992",
            "GENDER" => "M",
            "PROV" => "01",
            "DIST" => "01001",
            "WARDS" => "0100100001",
            "ADD" => "NKT",
            "IDCARD" => "163186442",
            "IDCARD_D" => "11/03/1992",
            "IDCARD_P" => "HN",
            "EMAIL" => "tuvm@gmail.com",
            "PHONE" => "0354503704",
            "FAX" => null,
            "TAXCODE" => null
        ];
        $order = [
            "FIELD" => null,
            "ORDER_CODE" => null,
            "TYPE" => null,
            "TITLE" => null,
            "SUMMARY" => null,
            "DISCOUNT" => 0,
            "DISCOUNT_UNIT" => null,
            "VAT" => 0,
            "TOTAL_AMOUNT" => null,
            "CURRENCY" => "VND",
            "GIF_CODE" => null,
            "STATUS" => null,
            "PAY_METHOD" => null,
        ];
        $order_detail = [
            0=>[
                "FIELD" => null,
                "PRODUCT_MODE" => null,
                "PRODUCT_TYPE" => "CN.04",
                "REF_ID" => null,
                "ORG_STORE" => null,
                "WEIGHT" => null,
                "COUNT" => null,
                "DISCOUNT" => 0,
                "DISCOUNT_UNIT" => null,
                "VAT" => 0,
                "TOTAL_AMOUNT" => null,
                "DESCRIPTION" => null,
                "EFFECTIVE_DATE" => null,
                "EXPIRATION_DATE" => null,
                ]
        ];
        $insured = [
            "BANK_CODE" => "HDBANK_VN",
            "BRANCH_CODE" => "HDBANK_VN",
            "LO_CONTRACT" => "",
            "LO_TYPE" => null,
            "LO_MODE" => null,
            "PAYER" => null,
            "CURRENCY" => "VND",
            "LO_TOTAL_AMOUNT" =>null,
            "LO_EFFECTIVE_DATE" => "",
            "LO_EXPIRATION_DATE" => "",
            "LO_DATE" => "",
            "INTEREST_RATE" => null,
            "DURATION" => 1,
            "DURATION_UNIT" => "Y",
            "INSUR_TOTAL_AMOUNT" => null,
            "DISBUR" => [
                "BRANCH_CODE" => "",
                "DISBUR_CODE" => "",
                "DISBUR_NUM" => "",
                "DISBUR_DATE" => "",
                "DISBUR_AMOUNT" => 0,
                "INSUR_TOTAL" => null,
            ],
            "ID_COMMON" => null,
            "RELATIONSHIP" => null,
            "DETAIL_CODE" => null,
            "CERTIFICATE_NO" => null,
            "PRODUCT_CODE" => null,
            "PACK_CODE" => null,
            "REGION" => null,
            "EFFECTIVE_DATE" => null,
            "EXPIRATION_DATE" => null,
            "ADDIITIONAL" => null,
            "ADDITIONAL_FEES" => 0,
            "DISCOUNT" => 0,
            "DISCOUNT_UNIT" => null,
            "VAT" => 0,
            "TOTAL_AMOUNT" => null,
            "ID" => "",
            "TYPE" => null,
            "NAME" => null,
            "DOB" => null,
            "GENDER" => null,
            "PROV" => null,
            "DIST" => null,
            "WARDS" => null,
            "ADD" => null,
            "IDCARD" => null,
            "IDCARD_D" => null,
            "IDCARD_P" => null,
            "EMAIL" => null,
            "PHONE" => null,
            "FAX" => null,
            "TAXCODE" => null,
            "DURATION_PAYMENT" => null,
            "PERIOD" => [
                ["CODE" => "",
                    "NAME" => null,
                    "EFFECTIVE_DATE" => null,
                    "EXPIRATION_DATE" => "",
                    "CURRENCY" => "VND",
                    "AMOUNT" => null,
                ]],
            "BENEFICIARY" => [
                [
                    "ORG_CODE" => null,
                    "TYPE" => null,
                ]],
            "FILES" => [
                [   "FILE_TYPE" => "GYC",
                    "FILE_NAME" => "GYC_0",
                    "FILE_ID" => "f27ee822218d928a2ac030e5f53281a3",
                    "IS_DEL" => "0",
                    "FILE_EXTENSION" => ""
                ],
                [   "FILE_TYPE" => "GYC",
                    "FILE_NAME" => "GYC_0",
                    "FILE_ID" => "f27ee822218d928a2ac030e5f53281a3",
                    "IS_DEL" => "0",
                    "FILE_EXTENSION" => ""
                ]
            ]
        ];

        return $dataEdit = [
            'Channel'=>'HDBANK_VN',
            'UserName'=>'',
            'COMMON' => [
                'SELLER' => $seller,
                'BUYER' => $buyer,
                'RECEIVER' => $receiver,
                'ORDER' => $order,
                'ORDER_DETAIL' => $order_detail,//mảng nhiều phần tử
                'PAY_INFO' => $pay_info
            ],
            'BUSINESS' => [
                'LOAN' => $loan,
                'FLIGHT' => $flight,
                'HEALTH_CARE' => $health_care,
                'LO' => [
                    'INSURED' => [$insured]
                ]
            ],
        ];
    }
    //edit editOrderPolicy
    public function editOrderPolicy($dataInput, $action = 'ADD'){
        $this->setUserAction();
        try {
            $dataRequest['Action'] = [
                'ParentCode' => 'HDI_WEB',
                'UserName' => 'HDI_WEB',
                'Secret' => 'B72088C7067CJF9FE0551F6E21B40329',
                'ActionCode' => ACTION_EDIT_ORDER_INSURANCE,
            ];
            $dataUpdate = $this->buildParamDataEdit();
            $dataRequest['Data'] = $dataUpdate;

            $str_data_json = json_encode($dataRequest, false);
            myDebug($str_data_json);

            $resultApi = $this->postApiHD($dataRequest);
            return $this->setDataOneResponce($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }
    //danh sách an tâm tín dụng
    public function searchInsurancePolicy($dataRequest = array())
    {
        $requestDefault["channel"] = USER_CHANNEL_WEB_B2B;
        $requestDefault["username"] = Config::get('config.API_USER_NAME');
        $requestDefault["language"] = 'VN';
        $requestDefault["is_success"] = isset($dataRequest['p_is_success'])&& trim($dataRequest['p_is_success']) != '' ? $dataRequest['p_is_success'] : STATUS_INT_AM_MOT;
        $requestDefault["month"] = isset($dataRequest['p_month'])&& trim($dataRequest['p_month']) != '' ? $dataRequest['p_month'] : STATUS_INT_AM_MOT;
        $requestDefault["year"] = isset($dataRequest['p_year'])&& trim($dataRequest['p_year']) != '' ? $dataRequest['p_year'] : STATUS_INT_AM_MOT;
        $requestDefault["status"] = isset($dataRequest['p_status']) && !empty($dataRequest['p_status']) ? $dataRequest['p_status'] : '';
        $requestDefault["eff_date"] = isset($dataRequest['p_eff_date'])&& trim($dataRequest['p_eff_date']) != '' ? $dataRequest['p_eff_date'] : '';
        $requestDefault["exp_date"] = isset($dataRequest['p_exp_date'])&& trim($dataRequest['p_exp_date']) != '' ? $dataRequest['p_exp_date'] : '';
        $requestDefault["category"] = isset($dataRequest['p_category_code'])&& trim($dataRequest['p_category_code']) != '' ? $dataRequest['p_category_code'] : CATEGORY_ATTD;
        $requestDefault["product_code"] = isset($dataRequest['p_product_code'])&& trim($dataRequest['p_product_code']) != '' ? $dataRequest['p_product_code'] : '';
        $requestDefault["name_insured"] = isset($dataRequest['p_name_insured'])&& trim($dataRequest['p_name_insured']) != '' ? $dataRequest['p_name_insured'] : '';
        $requestDefault["idcard"] = (isset($dataRequest['p_idcard']) && trim($dataRequest['p_idcard']) != '') ? $dataRequest['p_idcard'] : '';
        $requestDefault["cer_no"] = isset($dataRequest['p_cer_no'])&& trim($dataRequest['p_cer_no']) != '' ? $dataRequest['p_cer_no'] : '';
        $requestDefault["org_seller"] = isset($dataRequest['p_org_seller'])&& trim($dataRequest['p_org_seller']) != '' ? $dataRequest['p_org_seller'] : '';
        $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;

        $dataRequest['Action'] = [
            'ParentCode' => Config::get('config.API_PARENT_CODE'),
            'UserName' => Config::get('config.API_USER_NAME'),
            'Secret' => Config::get('config.API_SECRET'),
            'ActionCode' => ACTION_SEARCH_INSURANCE_POLICY,
        ];
        $dataRequest['Data'] = $requestDefault;
        $resultApi = $this->postApiHD($dataRequest);
        return $this->setDataPaging($resultApi);
    }

    //detail đơn
    public function getDettailOrderInsurance($dataRequest = array())
    {
        $requestDefault["channel"] = USER_CHANNEL_WEB_B2B;
        $requestDefault["username"] = Config::get('config.API_USER_NAME');
        $requestDefault["language"] = 'VN';
        $requestDefault["category"] = isset($dataRequest['CATEGORY']) ? $dataRequest['CATEGORY'] : CATEGORY_ATTD;
        $requestDefault["product_code"] = isset($dataRequest['PRODUCT_CODE']) ? $dataRequest['PRODUCT_CODE'] : PRODUCT_CODE_ATTD;
        $requestDefault["contract_code"] = isset($dataRequest['CONTRACT_CODE']) ? $dataRequest['CONTRACT_CODE'] : '';

        $dataRequest['Action'] = [
            'ParentCode' => Config::get('config.API_PARENT_CODE'),
            'UserName' => Config::get('config.API_USER_NAME'),
            'Secret' => Config::get('config.API_SECRET'),
            'ActionCode' => ACTION_DETTAIL_ORDER_INSURANCE,
        ];
        $dataRequest['Data'] = $requestDefault;

        //myDebug($dataRequest);
        $resultApi = $this->postApiHD($dataRequest);
        return $this->setDataResponce($resultApi);
    }

    //data của hợp đồng
    public function getDettailContractInsurance($dataRequest = array())
    {
        $requestDefault["channel"] = USER_CHANNEL_WEB_B2B;
        $requestDefault["username"] = Config::get('config.API_USER_NAME');
        $requestDefault["language"] = 'VN';
        $requestDefault["category"] = isset($dataRequest['CATEGORY']) ? $dataRequest['CATEGORY'] : CATEGORY_ATTD;
        $requestDefault["product_code"] = isset($dataRequest['PRODUCT_CODE']) ? $dataRequest['PRODUCT_CODE'] : PRODUCT_CODE_ATTD;
        $requestDefault["contract_code"] = isset($dataRequest['CONTRACT_CODE']) ? $dataRequest['CONTRACT_CODE'] : '';
        $requestDefault["detail_code"] = isset($dataRequest['DETAIL_CODE']) ? $dataRequest['DETAIL_CODE'] : '';

        $dataRequest['Action'] = [
            'ParentCode' => Config::get('config.API_PARENT_CODE'),
            'UserName' => Config::get('config.API_USER_NAME'),
            'Secret' => Config::get('config.API_SECRET'),
            'ActionCode' => ACTION_DETTAIL_CONTRACT_CERTIFICATE,
        ];
        $dataRequest['Data'] = $requestDefault;

        //myDebug($dataRequest);
        $resultApi = $this->postApiHD($dataRequest);
        return $this->setDataResponce($resultApi);
    }

    //get define all của cấp đơn
    public function getAllDefinePolicy($dataRequest = array())
    {
        try {
            $key_cache = Memcache::CACHE_ALL_DEFINE_POLICY;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $requestDefault["channel"] = USER_CHANNEL_SDK_LO;
                $requestDefault["username"] = '';
                $requestDefault["org_code"] = 'HDBANK_VN';
                $requestDefault["product_code"] = PRODUCT_CODE_ATTD;
                $requestDefault["language"] = '';

                $dataRequest['Action'] = [
                    'ParentCode' => 'HDI_WEB',
                    'UserName' => 'HDI_WEB',
                    'Secret' => 'B72088C7067CJF9FE0551F6E21B40329',
                    'ActionCode' => ACTION_ALL_DEFINE_POLICY,
                ];
                $dataRequest['Data'] = $requestDefault;
                $resultApi = $this->postApiHD($dataRequest);
                $dataGet = $this->setDataResponce($resultApi);
                if (isset($dataGet['Success']) && $dataGet['Success'] == 1) {
                    $data = isset($dataGet['Data']) ? $dataGet['Data'] : false;
                    Memcache::putCache($key_cache, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }
}
