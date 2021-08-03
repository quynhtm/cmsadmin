<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\Report;

use App\Http\Models\Selling\ClaimHdi;
use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Carbon;

class ReportProduct extends ModelService
{
    /********************************************************************************************
     * báo cáo theo sản phẩm
     ********************************************************************************************/
    public function searchReportOrderBuy($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';

        //arr parram
        $arrParam = $this->buildParamOrderBuy($dataRequest);
        $requestDefault["p_business"] = json_encode($arrParam, false);
        $dataRequest['Action'] = [
            'ActionCode' => ACTION_REPORT_ORDER_BUY,
        ];
        $dataRequest['Data'] = $requestDefault;
        $resultApi = $this->postApiHD($dataRequest);

        return $this->setDataResponce($resultApi);
    }

    private function buildParamOrderBuy($dataRequest = [])
    {
        $arrParam = [
            'R1' => (isset($dataRequest['p_org_seller']) && trim($dataRequest['p_org_seller']) !='') ? $dataRequest['p_org_seller'] : '',
            'R2' => (isset($dataRequest['p_product_code']) && trim($dataRequest['p_product_code']) !='') ? $dataRequest['p_product_code'] : '',
            'R3' => (isset($dataRequest['page_no']) && trim($dataRequest['page_no']) !='') ? $dataRequest['page_no'] : 1,//pageing
            'R4' => (isset($dataRequest['f_date']) && trim($dataRequest['f_date']) !='') ? $dataRequest['f_date'] : '',
            'R5' => (isset($dataRequest['t_date']) && trim($dataRequest['t_date']) !='') ? $dataRequest['t_date'] : '',
            'R6' => (isset($dataRequest['text_search']) && trim($dataRequest['text_search']) !='') ? $dataRequest['text_search'] : '',
        ];
        return $arrParam;
    }
    /********************************************************************************************
     * báo cáo theo sản phẩm
     ********************************************************************************************/
    public function searchReportProduct($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';

        //arr parram
        $arrParam = $this->buildParam($dataRequest);
        $requestDefault["p_business"] = json_encode($arrParam, false);
        $dataRequest['Action'] = [
            'ActionCode' => ACTION_REPORT_PRODUCT,
        ];
        $dataRequest['Data'] = $requestDefault;
        $resultApi = $this->postApiHD($dataRequest);
        return $this->setDataResponce($resultApi);
    }

    private function buildParam($dataRequest = [])
    {
        $arrParam = [
            'R1' => (isset($dataRequest['p_product_code']) && trim($dataRequest['p_product_code']) !='') ? $dataRequest['p_product_code'] : '',//PRODUCT_CODE
            'R2' => (isset($dataRequest['p_pack_code']) && trim($dataRequest['p_pack_code']) !='') ? $dataRequest['p_pack_code'] : 'GOI_1',//PACK_CODE
            'R3' => (isset($dataRequest['p_month']) && trim($dataRequest['p_month']) !='') ? $dataRequest['p_month'] : getTimeCurrent('m'),//MONTH
            'R4' => (isset($dataRequest['p_year']) && trim($dataRequest['p_year']) !='') ? $dataRequest['p_year'] : getTimeCurrent('y'),//YEAR
            'R5' => (isset($dataRequest['is_accumulated_defaul']) && trim($dataRequest['is_accumulated_defaul']) !='') ? $dataRequest['is_accumulated_defaul'] : 1,//IS_ACCUMULATE lũy quý
            'R6' => (isset($dataRequest['page_no']) && trim($dataRequest['page_no']) !='') ? $dataRequest['page_no'] : 1,//pageing
        ];
        return $arrParam;
    }

    /********************************************************************************************
     * báo cáo sản phẩm chi tiết
     ********************************************************************************************/
    public function searchReportProductDetail($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';

        //arr parram
        $arrParam = $this->buildParamDetail($dataRequest);
        $requestDefault["p_business"] = json_encode($arrParam, false);
        $dataRequest['Action'] = [
            'ActionCode' => ACTION_REPORT_DETAIL_PRODUCT,
        ];
        $dataRequest['Data'] = $requestDefault;
        $resultApi = $this->postApiHD($dataRequest);
        return $this->setDataResponce($resultApi);
    }

    private function buildParamDetail($dataRequest = [])
    {
        $arrParam = [
            'R1' => (isset($dataRequest['p_product_code']) && trim($dataRequest['p_product_code']) !='') ? $dataRequest['p_product_code'] : '',//PRODUCT_CODE
            'R2' => (isset($dataRequest['p_pack_code']) && trim($dataRequest['p_pack_code']) !='') ? $dataRequest['p_pack_code'] : '',//PACK_CODE
            'R3' => (isset($dataRequest['p_month']) && trim($dataRequest['p_month']) !='') ? $dataRequest['p_month'] : getTimeCurrent('m'),//MONTH
            'R4' => (isset($dataRequest['p_year']) && trim($dataRequest['p_year']) !='') ? $dataRequest['p_year'] : getTimeCurrent('y'),//YEAR
            'R5' => (isset($dataRequest['is_accumulated_defaul']) && trim($dataRequest['is_accumulated_defaul']) !='') ? $dataRequest['is_accumulated_defaul'] : 1,//IS_ACCUMULATE lũy quý
            'R6' => (isset($dataRequest['page_no']) && trim($dataRequest['page_no']) !='') ? $dataRequest['page_no'] : 1,//pageing
            'R7' => (isset($dataRequest['type_excel']) && trim($dataRequest['type_excel']) !='') ? $dataRequest['type_excel'] : 1,//1: tìm kiếm, 2; Xuất excel cho đối soát kế toán
            'R8' => (isset($dataRequest['str_id']) && trim($dataRequest['str_id']) !='') ? $dataRequest['str_id'] : '',//All: xuất all, A;B;C cập nhật theo id A, B, C
            'R9' => (isset($dataRequest['p_from_date']) && trim($dataRequest['p_from_date']) !='') ? $dataRequest['p_from_date'] : '',//ngày bắt đầu
            'R10' => (isset($dataRequest['p_to_date']) && trim($dataRequest['p_to_date']) !='') ? $dataRequest['p_to_date'] : '',//ngày cuối
        ];
        return $arrParam;
    }

    /********************************************************************************************
     * báo cáo đối soát
     ********************************************************************************************/
    public function searchReportDataReconciliation($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';

        //arr parram
        $arrParam = $this->buildParamDataReconciliation($dataRequest);
        $requestDefault["p_business"] = json_encode($arrParam, false);
        $dataRequest['Action'] = [
            'ActionCode' => ACTION_REPORT_DATA_RECONCILIATION,
        ];
        $dataRequest['Data'] = $requestDefault;
        $resultApi = $this->postApiHD($dataRequest);

        return $this->setDataResponce($resultApi);
    }

    private function buildParamDataReconciliation($dataRequest = [])
    {
        $arrParam = [
            'R1' => (isset($dataRequest['p_product_code']) && trim($dataRequest['p_product_code']) !='') ? $dataRequest['p_product_code'] : 'BAY_AT',//PRODUCT_CODE
            'R2' => (isset($dataRequest['p_pack_code']) && trim($dataRequest['p_pack_code']) !='') ? $dataRequest['p_pack_code'] : 'GOI_1',//PACK_CODE
            'R3' => '',//MONTH
            'R4' => '',//YEAR
            'R5' => (isset($dataRequest['is_accumulated_defaul']) && trim($dataRequest['is_accumulated_defaul']) !='') ? $dataRequest['is_accumulated_defaul'] : 1,//IS_ACCUMULATE lũy quý
            'R6' => (isset($dataRequest['page_no']) && trim($dataRequest['page_no']) !='') ? $dataRequest['page_no'] : 1,//pageing
            'R7' => (isset($dataRequest['p_from_date']) && trim($dataRequest['p_from_date']) !='') ? $dataRequest['p_from_date'] : '',//ngày bắt đầu
            'R8' => (isset($dataRequest['p_to_date']) && trim($dataRequest['p_to_date']) !='') ? $dataRequest['p_to_date'] : '',//ngày đến
        ];
        return $arrParam;
    }

    /********************************************************************************************
     * báo cáo bồi thường VietJet
     ********************************************************************************************/
    public function searchReportClaimVietjet($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';

        //arr parram
        $arrParam = app(ClaimHdi::class)->buildParam($dataRequest);
        $requestDefault["p_business"] = json_encode($arrParam, false);
        $dataRequest['Action'] = [
            'ActionCode' => ACTION_REPORT_CLAIM_VIETJET,
        ];

        $dataRequest['Data'] = $requestDefault;
        $resultApi = $this->postApiHD($dataRequest);
        return $this->setDataResponce($resultApi);
    }
}
