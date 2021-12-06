<?php
/**
 * Created by PhpStorm.
 * User: Quynhtm
 * Date: 29/05/2015
 * Time: 8:24 CH
 */

namespace App\Http\Controllers\BackendCms;

use App\Http\Controllers\BaseAdminController;
use App\Models\Report\VouchersReport;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\FunctionLib;
use App\Services\ServiceCommon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class BackendDashBoardController extends BaseAdminController
{
    public $dataOut = [];
    public $template = 'index';

    public function __construct()
    {
        parent::__construct();
        /*FunctionLib::link_js(array(
            'HDInsurance/admin/lib/highcharts/highcharts.js',
            'HDInsurance/admin/lib/highcharts/highcharts-3d.js',
            'HDInsurance/admin/lib/highcharts/exporting.js',
        ));*/
    }

    public function dashboard()
    {   //thuộc báo cáo
        //$this->tab_top = 4;//test
        //myDebug($this->testData());
        switch ($this->tab_top) {
            case CGlobal::dms_portal:
                $this->dashboardSystem();
                break;
            case CGlobal::selling:
                $this->dashboardSelling();
                break;
            default:
                $this->template = 'index_default';
                $today = Carbon::now();
                $weekDay = getWeekDay($today);
                $this->dataOut = [
                    'weekDay' => $weekDay,
                    'today' => date('d-m-Y'),
                ];
                break;
        }

        return view('BackendCms.DashBoard.' . $this->template, array_merge([
            'title_dashboard' => CGlobal::web_title_dashboard,
            'lang' => $this->languageSite,
        ], $this->dataOut));
    }

    private function dashboardSystem()
    {
        $this->template = 'index_system';
        $today = Carbon::now();
        $weekDay = getWeekDay($today);
        $this->dataOut = [
            'weekDay' => $weekDay,
            'today' => date('d-m-Y'),
        ];
    }

    private function dashboardSelling()
    {
        CGlobal::$pageAdminTitle = 'Trang chủ/Dashboard ' . CGlobal::$arrTitleProject[$this->tab_top];
        $modelReport = new VouchersReport();
        $dataRequest['p_org_code'] = isset($this->user['org_code']) ? $this->user['org_code'] : '';
        $dataRequest['p_accumulate'] = addslashes(Request::get('p_accumulate', STATUS_INT_KHONG));//mặc định 0 all,1: lũy kế
        $dataReport = $modelReport->searchReportDashbroadSelling($dataRequest);

        $arrDate = $arrMoney = $arrContract = $arrContractTemp = $dataTableInfor = [];
        $tongDoanhThu = $tongContract = $tongHoSoChoDuyet = $tongTaiTuc = 0;
        $totalReport = 0;
        if ($dataReport['Success'] == STATUS_INT_MOT) {
            if (!empty($dataReport['Data']['data'])) {
                foreach ($dataReport['Data']['data'] as $key => $report) {
                    $name_date = date('d/m', strtotime($report->DATE_OF_MONTH));
                    if($report->REVENUE > 0){
                        $arrDate[$name_date] = $name_date;
                        $arrMoney[$name_date] = isset($arrMoney[$name_date])? ($arrMoney[$name_date] + $report->REVENUE): $report->REVENUE;
                    }
                    if($report->TOTAL_CONTRACT > 0){
                        $arrContractTemp[$name_date]= isset($arrContractTemp[$name_date])?($arrContractTemp[$name_date]+$report->TOTAL_CONTRACT): $report->TOTAL_CONTRACT;

                    }

                    $tongDoanhThu = $tongDoanhThu + $report->REVENUE;
                    $tongContract = $tongContract + $report->TOTAL_CONTRACT;
                    $tongHoSoChoDuyet = $tongHoSoChoDuyet + $report->TOTAL_WAITS;
                    $tongTaiTuc = $tongTaiTuc + $report->TOTAL_REINSURENCE;
                    $totalReport = $key;

                    //table báo cáo:
                    if(trim($report->PRODUCT_CODE) != ''){
                        $key_infor = $report->PRODUCT_CODE.'_'.$report->ORG_CODE;
                        if (isset($dataTableInfor[$key_infor])) {
                            $dataTableInfor[$key_infor]['TOTAL_CONTRACT'] =  $dataTableInfor[$key_infor]['TOTAL_CONTRACT'] + $report->TOTAL_CONTRACT;//tổng đơn
                            $dataTableInfor[$key_infor]['TOTAL_REVENUE'] = $dataTableInfor[$key_infor]['TOTAL_REVENUE'] + $report->REVENUE;//doanh thu
                            $dataTableInfor[$key_infor]['TOTAL_WAITS'] = $dataTableInfor[$key_infor]['TOTAL_WAITS'] + $report->TOTAL_WAITS;//chờ duyệt
                            $dataTableInfor[$key_infor]['TOTAL_REINSURENCE'] = $dataTableInfor[$key_infor]['TOTAL_REINSURENCE'] + $report->TOTAL_REINSURENCE;//tái tục
                        } else {
                            $dataTableInfor[$key_infor] = [
                                'ORG_CODE' => $report->ORG_CODE,
                                'ORG_NAME' => $report->ORG_NAME,
                                'PRODUCT_CODE' => $report->PRODUCT_CODE,
                                'PRODUCT_NAME' => $report->PRODUCT_NAME,

                                'TOTAL_CONTRACT' => $report->TOTAL_CONTRACT,//tổng đơn
                                'TOTAL_REVENUE' => $report->REVENUE,//doanh thu
                                'TOTAL_WAITS' => $report->TOTAL_WAITS,//chờ duyệt
                                'TOTAL_REINSURENCE' => $report->TOTAL_REINSURENCE,//tái tục
                            ];
                        }
                    }
                }

                //gán lại tổng hợp đồng theo ngày
                if(!empty($arrContractTemp)){
                    foreach ($arrContractTemp as $date_ => $total_){
                        $arrContract[] = ['name' => $date_, 'total_contract' =>$total_];
                    }
                }
            }
        }
        //check quyền view chi tiết báo cáo detail
        $permiss_view_detail = STATUS_INT_KHONG;
        if($this->user['user_type'] != USER_ROOT){
            $routeName = 'report.indexReportProduct';
            if(isset($this->user['user_permission'][$routeName][PERMISS_VIEW])){
                $permiss_view_detail = STATUS_INT_MOT;
            }
        }else{
            $permiss_view_detail = STATUS_INT_MOT;
        }
        //myDebug($this->user);
        //myDebug($arrContractTemp,false);
        //myDebug($dataTableInfor);
        $this->template = 'index_selling';
        $this->dataOut = [
            'dataTableInfor' => $dataTableInfor,
            'search' => $dataRequest,
            'arrDate' => $arrDate,
            'arrMoney' => $arrMoney,
            'arrContract' => $arrContract,

            'tongDoanhThu' => $tongDoanhThu,
            'tongContract' => $tongContract,
            'tongHoSoChoDuyet' => $tongHoSoChoDuyet,
            'tongTaiTuc' => $tongTaiTuc,

            'totalReport' => $totalReport,
            'permiss_view_detail' => $permiss_view_detail,
        ];
    }
}
