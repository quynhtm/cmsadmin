<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Report;

use App\Http\Controllers\BaseAdminController;
use App\Models\OpenId\Organization;
use App\Models\OpenId\UserSystem;
use App\Models\Report\ReportProduct;
use App\Models\Selling\Campaigns;

use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use App\Services\ActionExcel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class ReportProductDetailController extends BaseAdminController
{
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrOrgAll = array();
    private $arrOrg = array();
    private $arrMonth = array();
    private $arrYear = array();
    private $arrHours = array();
    private $arrMinute = array();

    private $templateRoot = DIR_PRO_REPORT . '/';

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new ReportProduct();

        $this->arrHours = CGlobal::$arrHours;
        $this->arrMinute = CGlobal::$arrMinute;

        $this->arrMonth = CGlobal::$arrMonth;
        $this->arrYear = getArrYear();
        $this->arrOrgAll = app(Organization::class)->getArrOptionOrg();

    }

    private function _outDataView($request, $data)
    {
        $optionProduct = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProductUser, isset($data['p_product_code']) ? $data['p_product_code'] : '');
        $optionSeller = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrOrgUser, isset($data['p_org_code']) ? $data['p_org_code'] : '');

        $optionMonth = FunctionLib::getOption(['' => 'Tháng'] + $this->arrMonth, isset($data['p_month']) ? $data['p_month'] : '');
        $optionYear = FunctionLib::getOption(['' => 'Năm'] + $this->arrYear, isset($data['p_year']) ? $data['p_year'] : '');

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = (isset($request['objectId']) && trim($request['objectId']) != '0') ? 1 : 0;

        return $this->dataOutCommon = [
            'optionMonth' => $optionMonth,
            'optionYear' => $optionYear,
            'optionProduct' => $optionProduct,
            'optionSeller' => $optionSeller,

            'arrStatus' => $this->arrStatus,
            'arrOrg' => $this->arrOrg,

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlGetItem' => '',
            'urlPostItem' => '',
            'urlAjaxGetData' => '',
            'functionAction' => '_ajaxGetItemOther',
        ];
    }


    /********************************************************************************************
     * báo cáo sản phẩm chi tiết
     ********************************************************************************************/
    public function indexReportDetailProduct()
    {
        return $this->_getDataProductDetail();
    }

    //bay an toàn
    public function indexProductDetailFlySafe()
    {
        return $this->_getDataProductDetail(PRODUCT_CODE_BAY_AT,ORG_VIETJET_VN);
    }

    //bảo hiểm hành lý
    public function indexProductDetailLostBaggage()
    {
        return $this->_getDataProductDetail(PRODUCT_CODE_LOST_BAGGAGE,ORG_VIETJET_VN);
    }

    private function _getDataProductDetail($product_code = '',$org_code = '')
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Báo cáo chi tiết sản phẩm';
        CGlobal::$pageAdminTitle = $this->pageTitle . ' - Thống kê ' . CGlobal::$arrTitleProject[$this->tab_top];
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', STATUS_INT_MOT);

        if(!in_array($product_code,array_keys($this->arrProductUser))){
            $product_code = !empty($this->arrProductUser)? array_key_first($this->arrProductUser): DATA_SEARCH_NULL;
        }

        $search = $this->_buildParamSearchDetail($product_code,$org_code);
        $dataList = $inforTotal = [];
        $total = $totalList = 0;
        $totalMoney = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchReportProductDetail($search);
        //myDebug($result);
        $this->_outDataView($_GET, $search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data'][0] ?? $dataList;
            $inforTotal = $result['Data'][1][0] ?? $inforTotal;
            $total = $result['Data'][0][0]->TOTAL ?? $total;
            $totalList = !empty($dataList) ? array_key_last($dataList) + 1 : $total;
        }

        $pro_code = $search['p_product_code'];
        $file_name = 'Báo cáo chi tiết SP '.(isset($this->arrProductUser[$pro_code])? $this->arrProductUser[$pro_code]: '');
        switch ($pro_code) {
            case PRODUCT_CODE_XCG_TNDSBB:
                $type_export = ActionExcel::EXPORT_PRODUCT_DETAIL_XCG_TNDSBB;
                $table_view = '_tableDetail_XCG_TNDSBB';
                break;
            case PRODUCT_CODE_XCG_VCX:
                $type_export = ActionExcel::EXPORT_PRODUCT_DETAIL_XCG_VCX_NEW;
                $table_view = '_tableDetail_XCG_VCX_NEW';
                break;
            case PRODUCT_CODE_LOST_BAGGAGE:
                $type_export = ActionExcel::EXPORT_PRODUCT_DETAIL_LOST_BAGGAGE;
                $table_view = '_tableDetail_LOST_BAGGAGE';
                break;
            case PRODUCT_CODE_BAY_AT:
                $type_export = ActionExcel::EXPORT_PRODUCT_DETAIL_BAY_AT;
                $table_view = '_tableDetail_BAY_AT';
                break;
            case PRODUCT_CODE_CSSK_NV:
                $type_export = ActionExcel::EXPORT_PRODUCT_DETAIL_COMMON;
                $table_view = '_tableDetail_CSKH_NV';
                break;
            case PRODUCT_CODE_ATTD:
                $type_export = ActionExcel::EXPORT_PRODUCT_DETAIL_COMMON;
                $table_view = '_tableDetail_ATTD';
                break;
            case PRODUCT_CODE_CSVX:
                $type_export = ActionExcel::EXPORT_PRODUCT_DETAIL_COMMON;
                $table_view = '_tableDetail_CSVX';
                break;
            case PRODUCT_CODE_VISA_CARE:
                $type_export = ActionExcel::EXPORT_PRODUCT_DETAIL_COMMON;
                $table_view = '_tableDetail_VISA_CARE';
                break;
            case PRODUCT_CODE_TRAU:
                $type_export = ActionExcel::EXPORT_PRODUCT_DETAIL_COMMON;
                $table_view = '_tableDetail_TRAU';
                break;
            case PRODUCT_CODE_ATTD_NEW://bình an cá nhân
                $type_export = ActionExcel::EXPORT_PRODUCT_DETAIL_ATTD_NEW;
                $table_view = '_tableDetail_VISA_CARE';
                break;
            default:
                $type_export = ActionExcel::EXPORT_EXCEL_CUSTOMER_VOUCHER;
                $table_view = '_tableDetail_VISA_CARE';
                break;
        }
        //export excel
        if ($submit == STATUS_INT_HAI && trim($type_export) != '') {
            $this->actionExcel = new ActionExcel();
            $dataExcel = ['data' => $dataList, 'dataExten' => $inforTotal, 'total' => $total, 'file_name' => $file_name];
            $this->actionExcel->exportExcel($dataExcel, $type_export);
        }

        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $arrProPage = [PRODUCT_CODE_BAY_AT, PRODUCT_CODE_LOST_BAGGAGE];
        if (!in_array($product_code, $arrProPage)) {
            unset($this->arrProductUser[PRODUCT_CODE_BAY_AT]);
            unset($this->arrProductUser[PRODUCT_CODE_LOST_BAGGAGE]);
            $optionProduct = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProductUser, isset($search['p_product_code']) ? $search['p_product_code'] : '');
        }else{
            $arrProductOption = getArrChild($this->arrProductUser, $arrProPage);
            $optionProduct = FunctionLib::getOption(['' => '---Chọn---'] + $arrProductOption, isset($search['p_product_code']) ? $search['p_product_code'] : '');
        }

        return view($this->templateRoot . 'indexReportProductDetail', array_merge($this->dataOutCommon, [
            'data' => $dataList,
            'inforTotal' => $inforTotal,
            'product_code' => $product_code,
            'table_view' => $table_view,
            'search' => $search,
            'arrProPage' => $arrProPage,
            'total' => $total,
            'totalList' => $totalList,
            'optionProduct' => $optionProduct,
            'totalMoney' => $totalMoney,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
            'urlIndex' => URL::route(Route::currentRouteName()),
        ]));
    }

    private function _buildParamSearchDetail($product_code = '',$org_code = '')
    {
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 1);
        $search['p_org_code'] = trim(addslashes(Request::get('p_org_code', $org_code)));
        $product_form = trim(addslashes(Request::get('p_product_code', (trim($product_code) != '')?$product_code:'')));
        $search['p_product_code'] = trim($product_form) != ''? $product_form: (!empty($this->arrProductUser)? array_key_first($this->arrProductUser): DATA_SEARCH_NULL);
        $search['p_pack_code'] = trim(addslashes(Request::get('p_pack_code', 'GOI_1')));
        $search['p_month'] = trim(addslashes(Request::get('p_month', getTimeCurrent('m'))));
        $search['p_year'] = trim(addslashes(Request::get('p_year', getTimeCurrent('y'))));
        $search['is_accumulated_defaul'] = trim(addslashes(Request::get('is_accumulated_defaul', STATUS_INT_KHONG)));
        $search['type_excel'] = STATUS_INT_MOT;
        $search['page_no'] = ($submit == STATUS_INT_MOT) ? $page_no : STATUS_INT_KHONG;
        return $search;
    }

}
