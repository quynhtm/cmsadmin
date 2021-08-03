<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Sellings\Vouchers;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\OpenId\Organization;
use App\Http\Models\Selling\Campaigns;
use App\Http\Models\Report\VouchersReport;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use App\Services\ActionExcel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class VouchersReportController extends BaseAdminController
{
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrStatusValue = array();
    private $arrTypeGenerate = array();
    private $arrCurrency = array();
    private $arrYesOrNo = array();
    private $arrGiftType = array();
    private $arrOrgAll = array();
    private $arrOrg= array();
    private $arrProduct= array();
    private $arrCampaigns = array();
    private $arrDiscountUnit = array();
    private $arrHours = array();
    private $arrMinute = array();

    private $templateRoot = DIR_PRO_SELLING.'/'.DIR_MODULE_VOUCHERS . '.vouchersReport.';

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new VouchersReport();

        $this->arrHours = CGlobal::$arrHours;
        $this->arrMinute = CGlobal::$arrMinute;
        $this->arrOrgAll = app(Organization::class)->getArrOptionOrg();
    }

    private function _outDataView($request, $data)
    {
        if($this->user['user_type'] == USER_ROOT){
            $this->arrOrg = $this->arrOrgAll;
            $this->arrCampaigns = app(Campaigns::class)->getArrOptionCampaigns('VOUCHER');
        }else{
            if(isset($this->user['org_code'])){
                $this->arrOrg[$this->user['org_code']] = $this->arrOrgAll[$this->user['org_code']];
                $this->arrCampaigns = app(Campaigns::class)->getArrOptionCampaigns('VOUCHER',$this->user['org_code']);
            }
        }
        $this->arrProduct = app(Campaigns::class)->getArrOptionProduct();

        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['STATUS']) ? $data['STATUS'] : '');
        $optionStatusSearch = FunctionLib::getOption(['' => '---Chọn---'] + [STATUS_VOUCHER_WAIT=>'Chờ duyệt',STATUS_VOUCHER_APPROVE=>'Duyệt'], isset($data['STATUS']) ? $data['STATUS'] : '');
        $optionTypeGenerate = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrTypeGenerate, isset($data['TYPE_GENERATE']) ? $data['TYPE_GENERATE'] : '');
        $optionCurrency = FunctionLib::getOption($this->arrCurrency, isset($data['CURRENCY']) ? $data['CURRENCY'] : '');
        $optionIsCombined = FunctionLib::getOption($this->arrYesOrNo, isset($data['IS_COMBINED']) ? $data['IS_COMBINED'] : '');
        $optionOrg = FunctionLib::getOption(['' => '---Chọn---'] +$this->arrOrg, isset($data['ORG_CODE']) ? $data['ORG_CODE'] : '');
        $optionCampaigns = FunctionLib::getOption(['' => '---Chọn---'] +$this->arrCampaigns, isset($data['CAMPAIGN_CODE']) ? $data['CAMPAIGN_CODE'] : '');
        $optionGiftType = FunctionLib::getOption(['' => '---Chọn---'] +$this->arrGiftType, isset($data['GIFT_TYPE']) ? $data['GIFT_TYPE'] : '');
        $optionProduct = FunctionLib::getOption(['' => '---Chọn---'] +$this->arrProduct, isset($data['PRODUCT_CODE']) ? $data['PRODUCT_CODE'] : '');

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = (isset($request['objectId']) && trim($request['objectId']) != '0') ? 1 : 0;

        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'optionStatusSearch' => $optionStatusSearch,
            'optionTypeGenerate' => $optionTypeGenerate,
            'optionCurrency' => $optionCurrency,
            'optionIsCombined' => $optionIsCombined,
            'optionOrg' => $optionOrg,
            'optionCampaigns' => $optionCampaigns,
            'optionGiftType' => $optionGiftType,
            'optionProduct' => $optionProduct,

            'arrStatus' => $this->arrStatus,
            'arrStatusValue' => $this->arrStatusValue,
            'arrTypeGenerate' => $this->arrTypeGenerate,
            'arrCurrency' => $this->arrCurrency,
            'arrYesOrNo' => $this->arrYesOrNo,
            'arrOrg' => $this->arrOrg,
            'arrCampaigns' => $this->arrCampaigns,
            'arrGiftType' => $this->arrGiftType,
            'arrDiscountUnit' => $this->arrDiscountUnit,
            'arrHours' => $this->arrHours,
            'arrMinute' => $this->arrMinute,

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route('vouchersGift.index'),
            'urlGetItem' => URL::route('vouchersGift.ajaxGetItem'),
            'urlPostItem' => URL::route('vouchersGift.ajaxPostItem'),
            'urlAjaxGetData' => URL::route('vouchersGift.ajaxGetData'),
            'urlActionOtherItem' => URL::route('vouchersGift.ajaxUpdateRelation'),
            'urlSearchOtherItem' => URL::route('vouchersGift.ajaxSearchOtherItem'),
            'urlUpdateStatusOtherItem' => URL::route('vouchersGift.ajaxUpdateStatusValue'),
            'urlUpdateStatusItem' => URL::route('vouchersGift.ajaxUpdateStatusCode'),
            'functionAction' => '_ajaxGetItemOther',
        ];
    }

    /*********************************************************************************************************
     * chi tiet danh sach khach hang dang ky Voucher
     *********************************************************************************************************/
    public function indexRegisCustomerVoucher()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Báo cáo KH đã cấp đơn';
        CGlobal::$pageAdminTitle = $this->pageTitle.' - Thống kê '.CGlobal::$arrTitleProject[$this->tab_top];

        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 0);

        $search['ORG_CODE'] = addslashes(Request::get('ORG_CODE', ''));
        $search['PRODUCT_CODE'] = addslashes(Request::get('PRODUCT_CODE', ''));
        $search['CAMPAIGN_CODE'] = addslashes(Request::get('CAMPAIGN_CODE', ''));
        $search['p_keyword'] = trim(addslashes(Request::get('p_keyword', '')));

        $search['p_from_date'] = trim(addslashes(Request::get('p_from_date', '')));
        $search['p_to_date'] = trim(addslashes(Request::get('p_to_date', '')));
        $search['p_from_date'] = ($search['p_from_date'] != '')? $search['p_from_date'] : date('d/m/Y',strtotime(Carbon::now()->startOfMonth()));
        $search['p_to_date'] = ($search['p_to_date'] != '')? $search['p_to_date'] : date('d/m/Y',strtotime(Carbon::now()));

        $search['p_org_code'] = $search['ORG_CODE'];
        $search['p_product_code'] = $search['PRODUCT_CODE'];
        $search['p_campaign_code'] = $search['CAMPAIGN_CODE'];
        $search['p_type_report'] = STATUS_INT_MOT;
        $search['submit'] = $submit;
        $search['page_no'] = ($submit== STATUS_INT_MOT)? $page_no: STATUS_INT_KHONG;

        $dataList = [];
        $total = $totalMoney = 0;
        $limit = CGlobal::number_show_10;
        if($submit != STATUS_INT_KHONG){
            $result = $this->modelObj->searchRegisCustomer($search);
            if ($result['Success'] == STATUS_INT_MOT) {
                $dataList = $result['data'] ?? $dataList;
                $total = $result['total'] ?? $total;
                $totalMoney = $result['total_money'] ?? $totalMoney;
            }
        }
        if($submit == STATUS_INT_HAI){
            $dataExcel = ['data'=>$dataList, 'total'=>$total];
            $this->exportExcelReport($dataExcel,ActionExcel::EXPORT_EXCEL_CUSTOMER_VOUCHER);
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'indexRegisCustomerVoucher', array_merge( $this->dataOutCommon,[
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'totalMoney' => $totalMoney,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
            'urlIndex' => URL::route('vouchersGift.indexRegisCustomerVoucher')
        ]));
    }

    /*********************************************************************************************************
     * chi tiet danh sach khach hang dang ky Sức khỏe
     *********************************************************************************************************/
    public function indexRegisCustomerHealth()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Báo cáo KH đăng ký Sức khỏe';
        CGlobal::$pageAdminTitle = $this->pageTitle.' - Thống kê '.CGlobal::$arrTitleProject[$this->tab_top];

        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 0);

        $search['ORG_CODE'] = addslashes(Request::get('ORG_CODE', ''));
        $search['PRODUCT_CODE'] = addslashes(Request::get('PRODUCT_CODE', ''));
        $search['CAMPAIGN_CODE'] = addslashes(Request::get('CAMPAIGN_CODE', ''));
        $search['p_keyword'] = trim(addslashes(Request::get('p_keyword', '')));

        $search['p_from_date'] = trim(addslashes(Request::get('p_from_date', '')));
        $search['p_to_date'] = trim(addslashes(Request::get('p_to_date', '')));
        $search['p_from_date'] = ($search['p_from_date'] != '')? $search['p_from_date'] : date('d/m/Y',strtotime(Carbon::now()->startOfMonth()));
        $search['p_to_date'] = ($search['p_to_date'] != '')? $search['p_to_date'] : date('d/m/Y',strtotime(Carbon::now()));

        $search['p_org_code'] = $search['ORG_CODE'];
        $search['p_product_code'] = $search['PRODUCT_CODE'];
        $search['p_campaign_code'] = $search['CAMPAIGN_CODE'];
        $search['p_type_report'] = STATUS_INT_KHONG;
        $search['submit'] = $submit;
        $search['page_no'] = ($submit== STATUS_INT_MOT)? $page_no: STATUS_INT_KHONG;

        $dataList = [];
        $total = $totalMoney = 0;
        $limit = CGlobal::number_show_10;
        if($submit != STATUS_INT_KHONG) {
            $result = $this->modelObj->searchRegisCustomer($search);
            if ($result['Success'] == STATUS_INT_MOT) {
                $dataList = $result['data'] ?? $dataList;
                $total = $result['total'] ?? $total;
                $totalMoney = $result['total_money'] ?? $totalMoney;
            }
        }
        if($submit == STATUS_INT_HAI){
            $dataExcel = ['data'=>$dataList, 'total'=>$total];
            $this->exportExcelReport($dataExcel,ActionExcel::EXPORT_EXCEL_CUSTOMER_HEALTH);
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'indexRegisCustomerHealth', array_merge( $this->dataOutCommon,[
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'totalMoney' => $totalMoney,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
            'urlIndex' => URL::route('vouchersGift.indexRegisCustomerHealth')
        ]));
    }

    /*********************************************************************************************************
     * chi tiet danh sach can bo HDI-VJ dang ky chuong trinh
     *********************************************************************************************************/
    public function indexReportRegisStaff()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Báo cáo cán bộ đăng ký';
        CGlobal::$pageAdminTitle = $this->pageTitle.' - Thống kê '.CGlobal::$arrTitleProject[$this->tab_top];
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 0);

        $search['ORG_CODE'] = addslashes(Request::get('ORG_CODE', ''));
        $search['CAMPAIGN_CODE'] = addslashes(Request::get('CAMPAIGN_CODE', ''));
        $search['p_keyword'] = trim(addslashes(Request::get('p_keyword', '')));

        $search['p_from_date'] = trim(addslashes(Request::get('p_from_date', '')));
        $search['p_to_date'] = trim(addslashes(Request::get('p_to_date', '')));
        $search['p_from_date'] = ($search['p_from_date'] != '')? $search['p_from_date'] : date('d/m/Y',strtotime(Carbon::now()->startOfMonth()));
        $search['p_to_date'] = ($search['p_to_date'] != '')? $search['p_to_date'] : date('d/m/Y',strtotime(Carbon::now()));

        $search['p_org_code'] = $search['ORG_CODE'];
        $search['p_campaign_code'] = $search['CAMPAIGN_CODE'];
        $search['submit'] = $submit;
        $search['page_no'] = ($submit== STATUS_INT_MOT)? $page_no: STATUS_INT_KHONG;

        $dataList = [];
        $total = $totalMoney = 0;
        $limit = CGlobal::number_show_10;
        if($submit != STATUS_INT_KHONG) {
            $result = $this->modelObj->searchRegisStaff($search);

            if ($result['Success'] == STATUS_INT_MOT) {
                $dataList = $result['data'] ?? $dataList;
                $total = $result['total'] ?? $total;
                $totalMoney = $result['total_money'] ?? $totalMoney;
            }
        }
        if($submit == STATUS_INT_HAI){
            $dataExcel = ['data'=>$dataList, 'total'=>$total];
            $this->exportExcelReport($dataExcel,ActionExcel::EXPORT_EXCEL_CUSTOMER_HEALTH);
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'indexRegisStaff', array_merge( $this->dataOutCommon,[
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'totalMoney' => $totalMoney,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
            'urlIndex' => URL::route('vouchersGift.indexRegisStaff')
        ]));
    }

    /*********************************************************************************************************
     * Báo cáo tổng hợp
     *********************************************************************************************************/
    public function indexReporCommon()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Báo cáo tổng hợp';
        CGlobal::$pageAdminTitle = $this->pageTitle.' - Thống kê '.CGlobal::$arrTitleProject[$this->tab_top];
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 0);

        $search['ORG_CODE'] = addslashes(Request::get('ORG_CODE', ''));
        $search['CAMPAIGN_CODE'] = addslashes(Request::get('CAMPAIGN_CODE', ''));
        $search['p_keyword'] = trim(addslashes(Request::get('p_keyword', '')));

        $search['p_from_date'] = trim(addslashes(Request::get('p_from_date', '')));
        $search['p_to_date'] = trim(addslashes(Request::get('p_to_date', '')));
        $search['p_from_date'] = ($search['p_from_date'] != '')? $search['p_from_date'] : date('d/m/Y',strtotime(Carbon::now()->startOfMonth()));
        $search['p_to_date'] = ($search['p_to_date'] != '')? $search['p_to_date'] : date('d/m/Y',strtotime(Carbon::now()));

        $search['p_org_code'] = $search['ORG_CODE'];
        $search['p_campaign_code'] = $search['CAMPAIGN_CODE'];
        $search['submit'] = $submit;
        $search['page_no'] = ($submit== STATUS_INT_MOT)? $page_no: STATUS_INT_KHONG;

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        if($submit != STATUS_INT_KHONG) {
            $result = $this->modelObj->searchReporCommon($search);
            if ($result['Success'] == STATUS_INT_MOT) {
                $dataList = $result['Data']['data'] ?? $dataList;
                $total = $result['Data']['total'] ?? $total;
            }
        }
        if($submit == STATUS_INT_HAI){
            $dataExcel = ['data'=>$dataList, 'total'=>$total];
            $this->exportExcelReport($dataExcel,ActionExcel::EXPORT_EXCEL_VOUCHER_COMMON);
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'indexReportCommon', array_merge( $this->dataOutCommon,[
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
            'urlIndex' => URL::route('vouchersGift.indexReporCommon')
        ]));
    }

    public function exportExcelReport($dataInput = [], $type = '', $dataOther = []){
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        if(!empty($dataInput)){
            $this->actionExcel = new ActionExcel();
            $this->actionExcel->exportExcel($dataInput,$type,$dataOther);
        }
        return [];
    }
}
