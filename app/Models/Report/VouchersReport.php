<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\Report;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Carbon;

class VouchersReport extends ModelService
{
    /*********************************************************************************************************
     * Danh mục: VouchersReport
     *********************************************************************************************************/
    //chi tiet danh sach khach hang dang ky theo goi gold health gom can bo va nguoi nha (fees chi tiet)
    public function searchRegisCustomer($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_campaign_code"] = (isset($dataRequest['p_campaign_code'])) ? $dataRequest['p_campaign_code'] : '';
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        $requestDefault["p_from_date"] = (isset($dataRequest['p_from_date']) && trim($dataRequest['p_from_date']) != '') ? $dataRequest['p_from_date'] : date('d/m/Y',strtotime(Carbon::now()->startOfMonth()));
        $requestDefault["p_to_date"] = (isset($dataRequest['p_to_date']) && trim($dataRequest['p_to_date']) != '') ? $dataRequest['p_to_date'] : date('d/m/Y',strtotime(Carbon::now()));
        $requestDefault["p_product_code"] = (isset($dataRequest['p_product_code'])) ? $dataRequest['p_product_code'] : '';
        $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_KHONG;
        $requestDefault["p_keyword"] = (isset($dataRequest['p_keyword'])) ? $dataRequest['p_keyword'] : '';
        $requestDefault["p_type_report"] = (isset($dataRequest['p_type_report'])) ? $dataRequest['p_type_report'] : STATUS_INT_MOT;// 1: cấp đơn, 0: đăng ký

        $dataRequest['Action'] = ['ActionCode' => ACTION_REPORT_VOUCHER];
        $dataRequest['Data'] = $requestDefault;
        $response = $this->postApiHD($dataRequest);

        $dataList = ['Success'=>0,'data'=>false,'total'=>0,'total_money'=>0];
        if (isset($response->Success) && $response->Success == STATUS_INT_MOT) {
            $dataList['Success'] = 1;
            $dataList['data'] = isset($response->Data[0]) ? $response->Data[0] : false;
            $dataList['total'] = isset($response->Data[0][0]->TOTAL) ? $response->Data[0][0]->TOTAL : STATUS_INT_KHONG;
            $dataList['total_money'] = isset($response->Data[1][0]->TOTAL_AMOUNT) ? $response->Data[1][0]->TOTAL_AMOUNT : STATUS_INT_KHONG;
        }
        return $dataList;
    }

    //chi tiet danh sach can bo HDI-VJ dang ky chuong trinh
    public function searchRegisStaff($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_campaign_code"] = (isset($dataRequest['p_campaign_code'])) ? $dataRequest['p_campaign_code'] : '';
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        $requestDefault["p_from_date"] = (isset($dataRequest['p_from_date']) && trim($dataRequest['p_from_date']) != '') ? $dataRequest['p_from_date'] : date('d/m/Y',strtotime(Carbon::now()->startOfMonth()));
        $requestDefault["p_to_date"] = (isset($dataRequest['p_to_date']) && trim($dataRequest['p_to_date']) != '') ? $dataRequest['p_to_date'] : date('d/m/Y',strtotime(Carbon::now()));
        $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_KHONG;
        $requestDefault["p_keyword"] = (isset($dataRequest['p_keyword'])) ? $dataRequest['p_keyword'] : '';

        $dataRequest['Action'] = ['ActionCode' => ACTION_STAFF_REGIS_GHEALTH];
        $dataRequest['Data'] = $requestDefault;
        $response = $this->postApiHD($dataRequest);

        $dataList = ['Success'=>0,'data'=>false,'total'=>0,'total_money'=>0];
        if (isset($response->Success) && $response->Success == STATUS_INT_MOT) {
            $dataList['Success'] = 1;
            $dataList['data'] = isset($response->Data[0]) ? $response->Data[0] : false;
            $dataList['total'] = isset($response->Data[0][0]->TOTAL) ? $response->Data[0][0]->TOTAL : STATUS_INT_KHONG;
            $dataList['total_money'] = isset($response->Data[1][0]->TOTAL_AMOUNT) ? $response->Data[1][0]->TOTAL_AMOUNT : STATUS_INT_KHONG;
        }
        return $dataList;
    }

    //báo cáo tổng hợp
    public function searchReporCommon($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;

        $requestDefault["p_campaign_code"] = (isset($dataRequest['p_campaign_code'])) ? $dataRequest['p_campaign_code'] : '';
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        $requestDefault["p_from_date"] = (isset($dataRequest['p_from_date']) && trim($dataRequest['p_from_date']) != '') ? $dataRequest['p_from_date'] : date('d/m/Y',strtotime(Carbon::now()->startOfMonth()));
        $requestDefault["p_to_date"] = (isset($dataRequest['p_to_date']) && trim($dataRequest['p_to_date']) != '') ? $dataRequest['p_to_date'] : date('d/m/Y',strtotime(Carbon::now()));
        $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_KHONG;

        return $this->searchDataCommon($requestDefault, ACTION_AGG_SITUATION_VOUCHER);
    }

    //báo cáo tổng hợp
    public function searchReportDashbroadSelling($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        $requestDefault["p_accumulate"] = (isset($dataRequest['p_accumulate'])) ? $dataRequest['p_accumulate'] : 0;//0 tháng,1 lũy kế

        return $this->searchDataCommon($requestDefault, ACTION_REPORT_DASHBROAD_SELLING);
    }

    //get data Insmart
    public function searchInsmart($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_campaign_code"] = (isset($dataRequest['p_campaign_code'])) ? $dataRequest['p_campaign_code'] : '';
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        $requestDefault["p_from_date"] = (isset($dataRequest['p_from_date']) && trim($dataRequest['p_from_date']) != '') ? $dataRequest['p_from_date'] : date('d/m/Y',strtotime(Carbon::now()->startOfMonth()));
        $requestDefault["p_to_date"] = (isset($dataRequest['p_to_date']) && trim($dataRequest['p_to_date']) != '') ? $dataRequest['p_to_date'] : date('d/m/Y',strtotime(Carbon::now()));
        $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_KHONG;
        $requestDefault["p_keyword"] = (isset($dataRequest['p_keyword'])) ? $dataRequest['p_keyword'] : '';

        $dataRequest['Action'] = ['ActionCode' => ACTION_REPORT_INSMART];
        $dataRequest['Data'] = $requestDefault;
        $response = $this->postApiHD($dataRequest);

        $dataList = ['Success'=>0,'data'=>false];
        if (isset($response->Success) && $response->Success == STATUS_INT_MOT) {
            $dataList['Success'] = 1;
            $dataList['data'] = isset($response->Data[0]) ? $response->Data[0] : false;
        }
        return $dataList;
    }
}
