<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\Selling;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Facades\Config;

class Inspection extends ModelService
{
    /*********************************************************************************************************
     * Thanh toán hợp đồng
     *********************************************************************************************************/
    public $table = TABLE_GIFT_CONFIG_CODE;

    public function searchInspectionHdi($dataInput = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataInput['p_org_code'])) ? $dataInput['p_org_code'] : '';
        $requestDefault["p_product_code"] = (isset($dataInput['p_product_code'])) ? $dataInput['p_product_code'] : '';
        //arr parram
        $arrParam = $this->buildParam($dataInput);
        $requestDefault["p_business"] = json_encode($arrParam, false);

        $dataRequest['Action'] = [
            'ActionCode' => ACTION_SEARCH_INSPECTION_HDI,
        ];
        $dataRequest['Data'] = $requestDefault;

        $resultApi = $this->postApiHD($dataRequest);
        return $this->setDataResponce($resultApi);
    }

    private function buildParam($dataRequest = [])
    {
        $arrParam = [
            'A1' => (isset($dataRequest['p_contract_code'])) ? $dataRequest['p_contract_code'] : '',//CONTRACT_CODE, LANGUAGE
            'A2' => (isset($dataRequest['p_certificate_no'])) ? $dataRequest['p_certificate_no'] : '',//CERTIFICATE_NO, ACCESSVISA_CODE
            'A3' => (isset($dataRequest['p_number_plate'])) ? $dataRequest['p_number_plate'] : '',//CUS_NAME, NUMBER_PLATE, CHASSIS_NO, ENGINE_NO
            'A4' => (isset($dataRequest['p_staff_email'])) ? $dataRequest['p_staff_email'] : '',//STAFF_EMAIL, EMAIL, PHONE
            'A5' => (isset($dataRequest['p_agency_code'])) ? $dataRequest['p_agency_code'] : '',//STAFF_CODE, AGENT_CODE
            'A6' => (isset($dataRequest['p_staff_cardid'])) ? $dataRequest['p_staff_cardid'] : '',//STAFF_CARDID
            'A7' => (isset($dataRequest['p_appointment_date'])) ? $dataRequest['p_appointment_date'] : '',//START_DATE, APPOINTMENT_DATE
            'A8' => (isset($dataRequest['p_booking_code'])) ? $dataRequest['p_booking_code'] : '',//BOOKING_CODE
            'A9' => (isset($dataRequest['p_seat_no'])) ? $dataRequest['p_seat_no'] : '',//SEAT_NO
            'A10' => (isset($dataRequest['p_provice_code'])) ? $dataRequest['p_provice_code'] : '',//PLACE_FROM, PLACE_OF_ASSESSMENT,địa điểm đánh giá
            'A11' => (isset($dataRequest['p_place_to'])) ? $dataRequest['p_place_to'] : '',//PLACE_TO
            'A12' => (isset($dataRequest['p_fli_no'])) ? $dataRequest['p_fli_no'] : '',//FLI_NO
            'A13' => (isset($dataRequest['p_detail_code'])) ? $dataRequest['p_detail_code'] : '',//DETAIL_CODE
            'A14' => (isset($dataRequest['p_detail'])) ? $dataRequest['p_detail'] : '',//DETAIL
            'A15' => (isset($dataRequest['p_status'])) ? $dataRequest['p_status'] : '',//STATUS
            'A16' => (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : 1,//pageing
        ];
        return $arrParam;
    }

    public function updateCalendarInspection($dataInput = array())
    {
        //arr parram
        $arrParam['contract_code'] = (isset($dataInput['contract_code'])) ? $dataInput['contract_code'] : '';
        $arrParam['detail_code'] = (isset($dataInput['detail_code'])) ? $dataInput['detail_code'] : '';
        $arrParam['eff'] = (isset($dataInput['eff'])) ? $dataInput['eff'] : '';
        $arrParam['time_f'] = (isset($dataInput['time_f'])) ? $dataInput['time_f'] : '';
        $arrParam['time_t'] = (isset($dataInput['time_t'])) ? $dataInput['time_t'] : '';
        $arrParam['contact'] = (isset($dataInput['contact'])) ? $dataInput['contact'] : '';
        $arrParam['phone'] = (isset($dataInput['phone'])) ? $dataInput['phone'] : '';
        $arrParam['wards'] = (isset($dataInput['wards'])) ? $dataInput['wards'] : '';
        $arrParam['dist'] = (isset($dataInput['dist'])) ? $dataInput['dist'] : '';
        $arrParam['prov'] = (isset($dataInput['prov'])) ? $dataInput['prov'] : '';
        $arrParam['address'] = (isset($dataInput['address'])) ? $dataInput['address'] : '';
        $arrParam['staff_code'] = (isset($dataInput['staff_code'])) ? $dataInput['staff_code'] : '';
        $arrParam['staff_name'] = (isset($dataInput['staff_name'])) ? $dataInput['staff_name'] : '';
        $arrParam['status'] = (isset($dataInput['status'])) ? $dataInput['status'] : '';

        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataInput['p_org_code'])) ? $dataInput['p_org_code'] : '';
        $requestDefault["p_business"] = json_encode($arrParam, false);

        $dataRequest['Data'] = $requestDefault;
        $dataRequest['Action'] = ['ActionCode' => ACTION_UPDATE_CALENDAR_INSPECTION];

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
        $param_url = '/hdi/service/sendMailWithJson';
        $resultApi = $this->postApiUrl($dataRequest, $param_url);
        return $this->setDataResponce($resultApi);
    }
}
