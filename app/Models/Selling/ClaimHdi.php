<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\Selling;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class ClaimHdi extends ModelService
{
    /*********************************************************************************************************
     * Thanh toán hợp đồng
     *********************************************************************************************************/
    public $table = TABLE_GIFT_CONFIG_CODE;

    public function searchClaimHdi($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        //arr parram
        $arrParam = $this->buildParam($dataRequest);
        $requestDefault["p_business"] = json_encode($arrParam, false);

        $dataRequest['Action'] = [
            'ParentCode' => Config::get('config.API_PARENT_CODE'),
            'UserName' => Config::get('config.API_USER_NAME'),
            'Secret' => Config::get('config.API_SECRET'),
            'ActionCode' => ACTION_SEARCH_CLAIM_HDI,
        ];
        $dataRequest['Data'] = $requestDefault;
        $resultApi = $this->postApiHD($dataRequest);
        return $this->setDataResponce($resultApi);
    }

    public function getParamSearch($dataForm = [], $p_org_code = '', $p_product_code = '')
    {
        $page_no = (isset($dataForm['page_no']) && trim($dataForm['page_no']) != '') ? $dataForm['page_no'] : (int)Request::get('page_no', 1);

        $p_org_code_form = (isset($dataForm['p_org_code']) && trim($dataForm['p_org_code']) != '') ? $dataForm['p_org_code'] : trim(addslashes(Request::get('p_org_code', ORG_VIETJET_VN)));
        $p_product_code_form = (isset($dataForm['p_product_code']) && trim($dataForm['p_product_code']) != '') ? $dataForm['p_product_code'] : trim(addslashes(Request::get('p_product_code', PRODUCT_CODE_BAY_AT)));
        $search['p_org_code'] = trim($p_org_code) != '' ? $p_org_code : $p_org_code_form;
        $search['p_product_code'] = trim($p_product_code) != '' ? $p_product_code : $p_product_code_form;
        $search['p_type'] = 'LIST';

        $search["p_channel"] = (isset($dataForm['p_channel']) && trim($dataForm['p_channel']) != '') ? $dataForm['p_channel'] : trim(addslashes(Request::get('p_channel', '')));
        $search["p_from_date"] = (isset($dataForm['p_from_date']) && trim($dataForm['p_from_date']) != '') ? $dataForm['p_from_date'] : trim(addslashes(Request::get('p_from_date', '')));
        $search["p_to_date"] = (isset($dataForm['p_to_date']) && trim($dataForm['p_to_date']) != '') ? $dataForm['p_to_date'] : trim(addslashes(Request::get('p_to_date', '')));

        $search["p_str_status"] = (isset($dataForm['p_str_status']) && trim($dataForm['p_str_status']) != '') ? $dataForm['p_str_status'] : '';
        $search['p_status'] = (trim($search["p_str_status"]) !='') ? implode(';', explode(',',trim($search["p_str_status"]))) : '';

        $submit = (isset($dataForm['submit']) && trim($dataForm['submit']) != '') ? $dataForm['submit'] : (int)Request::get('submit', 1);
        $search['page_no'] = ($submit == STATUS_INT_MOT) ? $page_no : STATUS_INT_KHONG;

        return $search;
    }

    public function buildParam($dataRequest = [])
    {
        $arrParam = [
            'A1' => (isset($dataRequest['p_product_code'])) ? $dataRequest['p_product_code'] : PRODUCT_CODE_BAY_AT,//PRODUCT_CODE
            'A2' => (isset($dataRequest['p_channel'])) ? $dataRequest['p_channel'] : '',//CHANNEL
            'A3' => (isset($dataRequest['p_status'])) ? $dataRequest['p_status'] : '',//STATE
            'A4' => (isset($dataRequest['p_from_date'])) ? $dataRequest['p_from_date'] : '',//FROM_DATE
            'A5' => (isset($dataRequest['p_to_date'])) ? $dataRequest['p_to_date'] : '',//TO_DATE
            'A6' => (isset($dataRequest['p_ins_name'])) ? $dataRequest['p_ins_name'] : '',//INS_NAME
            'A7' => (isset($dataRequest['p_req_name'])) ? $dataRequest['p_req_name'] : '',//REQ_NAME
            'A8' => (isset($dataRequest['p_cardid'])) ? $dataRequest['p_cardid'] : '',//CARDID
            'A9' => (isset($dataRequest['p_certificate_no'])) ? $dataRequest['p_certificate_no'] : '',//CERTIFICATE_NO
            'A10' => (isset($dataRequest['p_phone'])) ? $dataRequest['p_phone'] : '',//PHONE

            'A11' => (isset($dataRequest['p_type'])) ? $dataRequest['p_type'] : 'LIST',//TYPE:  LIST: Để lấy cho HDI, LIST_AIR: để lấy cho màn hình VJ, DETAIL: chi tiết

            'A12' => (isset($dataRequest['p_claim_code'])) ? $dataRequest['p_claim_code'] : '',//CLAIM_CODE
            'A13' => (isset($dataRequest['p_month'])) ? $dataRequest['p_month'] : '',//MONTH
            'A14' => (isset($dataRequest['p_year'])) ? $dataRequest['p_year'] : '',//YEAR
            'A15' => (isset($dataRequest['p_flight_no'])) ? $dataRequest['p_flight_no'] : '',//FLIGHT_NO: Nếu nhập số hiệu chuyến bay
            'A16' => (isset($dataRequest['p_booking_id'])) ? $dataRequest['p_booking_id'] : '',//BOOKING_ID: Nếu nhập mã đặt chỗ
            'A17' => (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : 1,//pageing
        ];
        return $arrParam;
    }

    public function updateChangeProcess($dataInput = array())
    {
        $this->setUserAction();
        $dataRequestDefault = $this->dataRequestDefault;
        $dataRequestDefault['p_org_code'] = (isset($dataInput['p_org_code'])) ? $dataInput['p_org_code'] : '';
        $dataRequestDefault['p_prodcode'] = (isset($dataInput['p_prodcode'])) ? $dataInput['p_prodcode'] : '';
        $dataRequestDefault['p_claimtrans'] = (isset($dataInput['p_claim_code'])) ? $dataInput['p_claim_code'] : '';
        $dataRequestDefault['p_workid'] = (isset($dataInput['p_claim_status'])) ? $dataInput['p_claim_status'] : '';
        $dataRequestDefault['p_staffcode'] = (isset($dataInput['p_staffcode'])) ? $dataInput['p_staffcode'] : '';
        $dataRequestDefault['p_staffname'] = (isset($dataInput['p_staffname'])) ? $dataInput['p_staffname'] : '';
        $dataRequestDefault['p_content'] = (isset($dataInput['p_content'])) ? $dataInput['p_content'] : '';
        $dataRequestDefault['p_pay_date'] = (isset($dataInput['p_pay_date'])) ? $dataInput['p_pay_date'] : '';
        $dataRequestDefault['p_pay_claim'] = (isset($dataInput['p_pay_claim'])) ? $dataInput['p_pay_claim'] : '';

        $dataRequest['Data'] = $dataRequestDefault;
        $dataRequest['Action'] = ['ActionCode' => ACTION_CHANGE_PROCESS];

        //myDebug($dataRequest);
        $resultApi = $this->postApiHD($dataRequest);
        return $this->setDataResponce($resultApi);
    }

    public function sendMailClaim($dataInput = array())
    {
        $dataRequest['Data'] = $dataInput;
        $dataRequest['Action'] = [
            'ParentCode' => Config::get('config.API_PARENT_CODE'),
            'UserName' => Config::get('config.API_USER_NAME'),
            'Secret' => Config::get('config.API_SECRET'),
            "ActionCode" => "HDI_EMAIL_JSON"];
        $param_url = Config::get('config.MAIL_SERVICE');
        $resultApi = $this->postApiUrl($dataRequest, $param_url);
        return $this->setDataResponce($resultApi);
    }
}
