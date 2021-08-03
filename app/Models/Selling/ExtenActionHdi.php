<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\Selling;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Facades\Config;

class ExtenActionHdi extends ModelService
{
    /*********************************************************************************************************
     * Cấp đơn theo lô
     *********************************************************************************************************/
    public function searchDataOrder($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';

        //arr parram
        $arrParam = $this->_buildParamSearch($dataRequest);
        $requestDefault["p_business"] = json_encode($arrParam, false);
        $dataRequest['Action'] = [
            'ActionCode' => ACTION_SEARCH_LIST_CREATE_ORDER,
        ];
        $dataRequest['Data'] = $requestDefault;

        $resultApi = $this->postApiHD($dataRequest);
        return $this->setDataPaging($resultApi);
    }
    public function removeDataOrder($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';

        //arr parram
        $arrParam = [
            'R1' => (isset($dataRequest['programme_id']) && trim($dataRequest['programme_id']) !='') ? $dataRequest['programme_id'] : '',//chương trình
            'R2' => (isset($dataRequest['product_id']) && trim($dataRequest['product_id']) !='') ? $dataRequest['product_id'] : '',//sản phẩm
            'R3' => (isset($dataRequest['contract_no']) && trim($dataRequest['contract_no']) !='') ? $dataRequest['contract_no'] :'',//số PLHĐ
        ];
        $requestDefault["p_business"] = json_encode($arrParam, false);
        $dataRequest['Action'] = [
            'ActionCode' => ACTION_REMOVE_LIST_CREATE_ORDER,
        ];
        $dataRequest['Data'] = $requestDefault;
        $resultApi = $this->postApiHD($dataRequest);
        return $this->setDataResponce($resultApi);
    }

    public function genTemplateEmailOrder($dataInput = array())
    {
        $this->setUserAction();

        $dataRequestDefault = $this->dataRequestDefault;
        $dataRequestDefault["ID"] = (isset($dataInput['programme_id'])) ? $dataInput['programme_id'] : '';;
        $dataRequest['Data'] = $dataRequestDefault;
        $dataRequest['Action'] = ['ActionCode' => 'KHOA_HAM'];

        $param_url = 'hdi/service/impTemplate';
        $resultApi = $this->postApiUrl($dataRequest,$param_url);
        return $this->checkReturnData($resultApi);
    }
    private function _buildParamSearch($dataRequest = [])
    {
        $arrParam = [
            'R1' => (isset($dataRequest['p_search_programme_id']) && trim($dataRequest['p_search_programme_id']) !='') ? $dataRequest['p_search_programme_id'] : '',//chương trình
            'R2' => (isset($dataRequest['p_search_product_id']) && trim($dataRequest['p_search_product_id']) !='') ? $dataRequest['p_search_product_id'] : '',//sản phẩm
            'R3' => (isset($dataRequest['p_search_contract_no']) && trim($dataRequest['p_search_contract_no']) !='') ? $dataRequest['p_search_contract_no'] :'',//số PLHĐ
            'R4' => (isset($dataRequest['p_search_certificate_no']) && trim($dataRequest['p_search_certificate_no']) !='') ? $dataRequest['p_search_certificate_no'] : '',//người được bảo hiểm
            'R6' => (isset($dataRequest['p_search_user_bh']) && trim($dataRequest['p_search_user_bh']) !='') ? $dataRequest['p_search_user_bh'] : '',
            'R5' => (isset($dataRequest['page_no']) && trim($dataRequest['page_no']) !='') ? $dataRequest['page_no'] : 1,//pageing
        ];
        return $arrParam;
    }
    public function getDataTabCreateOrder($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        $requestDefault["p_progid"] = (isset($dataRequest['p_progid'])) ? $dataRequest['p_progid'] : '';

        return $this->searchAllDataResponce($requestDefault, ACTION_GET_INFOR_PROGRAM_ALL);
    }

    public function getDetailProgrammeId($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        $requestDefault["p_programme_id"] = (isset($dataRequest['programme_id'])) ? $dataRequest['programme_id'] : '';

        return $this->searchDataOne($requestDefault, ACTION_GET_INFOR_PROGRAM_DETAILS);
    }

    public function updateProgramme($dataInput, $action = 'ADD')
    {
        $arrParam = [
            'R1' => (isset($dataInput['p_progid'])) ? $dataInput['p_progid'] : 0,
            'R2' => (isset($dataInput['p_programme_name'])) ? $dataInput['p_programme_name'] : '',
            'R3' => (isset($dataInput['p_org_buyer'])) ? $dataInput['p_org_buyer'] : '',

            'R4' => (isset($dataInput['p_product'])) ? $dataInput['p_product'] : '',
            'R5' => (isset($dataInput['p_struct_code'])) ? $dataInput['p_struct_code'] : '',
            'R6' => (isset($dataInput['p_contract_no'])) ? $dataInput['p_contract_no'] : '',

            'R7' => (isset($dataInput['p_effective_date'])) ? $dataInput['p_effective_date'] : '',
            'R8' => (isset($dataInput['p_expiration_date'])) ? $dataInput['p_expiration_date'] : '',
            'R9' => (isset($dataInput['p_temp_email'])) ? $dataInput['p_temp_email'] : '',

            'R10' => (isset($dataInput['file_id_contract'])) ? $dataInput['file_id_contract'] : '',//dùng cho update
            'R11' => (isset($dataInput['p_certificate_temp'])) ? $dataInput['p_certificate_temp'] : '',
            'R12' => (isset($dataInput['p_email_subject'])) ? $dataInput['p_email_subject'] : '',
        ];

        try {
            $this->setUserAction();
            $requestDefault = $this->dataRequestDefault;
            $requestDefault["p_org_code"] = 'HDI';
            $requestDefault["p_action"] = $action;
            $requestDefault["p_pack_obj"] = (isset($dataInput['p_package_json']))?json_encode($dataInput['p_package_json'], false):'';
            $requestDefault["p_prog_obj"] = json_encode($arrParam, false);

            $dataRequest['Action'] = ['ActionCode' => ACTION_UPDATE_PROGRAM_DETAILS];
            $dataRequest['Data'] = $requestDefault;

            $resultApi = $this->postApiHD($dataRequest);
            return $this->setDataOneResponce($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }
    /*********************************************************************************************************
     * Cấp ký số
     *********************************************************************************************************/
    public function searchDigitallySigned($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = Config::get('config.API_PARENT_CODE');
        $requestDefault["p_temp_code"] = (isset($dataRequest['p_temp_code'])) ? $dataRequest['p_temp_code'] : 'CSSK_SVC';
        $requestDefault["p_from_date"] = (isset($dataRequest['p_from_date'])) ? $dataRequest['p_from_date'] : '';
        $requestDefault["p_to_date"] = (isset($dataRequest['p_to_date'])) ? $dataRequest['p_to_date'] : '';
        $requestDefault["p_file_code"] = (isset($dataRequest['p_file_code'])) ? $dataRequest['p_file_code'] : '';
        $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;

        $dataRequest['Action'] = [
            'ParentCode' => Config::get('config.API_PARENT_CODE'),
            'UserName' => Config::get('config.API_USER_NAME'),
            'Secret' => Config::get('config.API_SECRET'),
            'ActionCode' => ACTION_SEARCH_DIGITALLY_SIGNED,
        ];
        $dataRequest['Data'] = $requestDefault;

        $resultApi = $this->postApiHD($dataRequest);
        return $this->setDataPaging($resultApi);
    }

    public function createDigitallySigned($dataInput = array())
    {
        if (empty($dataInput))
            return false;
        try {
            $this->setUserAction();

            $dataRequestDefault["USER_NAME"] = $this->dataRequestDefault['p_username'];// $this->dataRequestDefault['p_username'];
            $dataRequestDefault["TEMP_CODE"] = 'CSSK_SVC';
            $dataRequestDefault["TYPE_FILE"] = 'BASE64';
            $dataRequestDefault["EXT_FILE"] = 'doc';
            $dataRequestDefault["FILE"] = $dataInput['FILE'];//base64
            $dataRequestDefault["LOCATION"] = "Hà Nội";
            $dataRequestDefault["REASON"] = "Cấp giấy chứng nhận Bảo hiểm";
            $dataRequestDefault["TypeResponse"] = 'BASE64';
            $dataRequestDefault["TextNote"] = '';
            $dataRequestDefault["Alert"] = '';
            $dataRequestDefault["TEXT_CA"] ="CÔNG TY TNHH BẢO HIỂM HD";
            $dataRequestDefault["FILE_REFF"] = $dataInput['FILE_REFF'];//aaa
            $dataRequestDefault["FILE_CODE"] = '';
            $dataRequestDefault["MAIL_BUYER"] = '';
            $dataRequestDefault["MAIL_INSURED"] = '';
            $dataRequestDefault["MAIL_BENEFICIARY"] = '';
            $dataRequestDefault["MAIL_USER"] = '';
            $dataRequestDefault["MAIL_CC"] = '';
            $dataRequestDefault["MAIL_BCC"] = '';
            $dataRequestDefault["DATA_EXT"] = '';

            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = [
                'ParentCode' => Config::get('config.API_PARENT_CODE'),
                'UserName' => $this->dataRequestDefault['p_username'],
                'Secret' => Config::get('config.API_SECRET'),
                'ActionCode' => ACTION_CREATE_DIGITALLY_SIGNED,
            ];
            $param_url = 'hdi/service/sign';
            $resultApi = $this->postApiUrl($dataRequest, $param_url);

            /*if(Config::get('config.ENVIRONMENT') == 'DEV'){
                $url = 'https://test-apipayment.hdinsurance.com.vn/hdi/service/sign';
                $resultApi = $this->postApiByUrl($dataRequest, $url);
            }
            else{
                $param_url = 'hdi/service/sign';
                $resultApi = $this->postApiUrl($dataRequest, $param_url);
            }*/
            return $this->setDataResponce($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }
}
