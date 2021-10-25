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

class ReportReconciliationController extends BaseAdminController
{
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrOrgAll = array();
    private $arrOrg = array();
    private $arrProduct = array();
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
        $this->arrProduct = $this->getInforUser('product');
        $this->arrSeller = $this->getInforUser('org');
        $optionProduct = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProduct, isset($data['p_product_code']) ? $data['p_product_code'] : '');
        $optionSeller = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrSeller, isset($data['p_org_code']) ? $data['p_org_code'] : '');
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
     * Đối soát dữ liệu
     ********************************************************************************************/
    public function indexDataReconciliation()
    {
        return $this->_getDataReconciliation();
    }

    //bay an toàn
    public function indexReconciliationFlySafe()
    {
        return $this->_getDataReconciliation(PRODUCT_CODE_BAY_AT);
    }

    private function _getDataReconciliation($product_code = '')
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Báo cáo đối soát số liệu';
        CGlobal::$pageAdminTitle = $this->pageTitle . CGlobal::$arrTitleProject[$this->tab_top];

        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 1);
        $search = $this->_buildParamSearchReconciliation($product_code);

        $dataList = $dataTotal = [];
        $total = 0;
        $totalMoney = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchReportDataReconciliation($search);
        $this->_outDataView($_GET, $search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data'][0] ?? $dataList;
            $total = $result['Data'][0][0]->TOTAL ?? $total;
            $dataTotal = $result['Data'][1][0] ?? $dataTotal;
        }

        $pro_code = $search['p_product_code'];
        switch ($pro_code) {
            case PRODUCT_CODE_BAY_AT:
                $type_export = ActionExcel::EXPORT_RECONCILIATION_BAY_AT;
                $table_view = '_table_BAY_AT';
                break;
            default:
                $type_export = ActionExcel::EXPORT_RECONCILIATION_BAY_AT;
                $table_view = '_table_BAY_AT';
                break;
        }
        //export excel
        if ($submit == STATUS_INT_HAI && trim($type_export) != '') {
            $file_name = 'Báo cáo đối soát '.(isset($this->arrProduct[$pro_code])? $this->arrProduct[$pro_code]: '');
            $this->actionExcel = new ActionExcel();
            $dataExcel = ['data' => $dataList, 'dataTotal' => $dataTotal, 'total' => $total, 'file_name' => $file_name];
            $this->actionExcel->exportExcel($dataExcel, $type_export);
        }

        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        if ($product_code != PRODUCT_CODE_BAY_AT) {
            unset($this->arrProduct[PRODUCT_CODE_BAY_AT]);
        }
        $optionProduct = FunctionLib::getOption($this->arrProduct, isset($search['p_product_code']) ? $search['p_product_code'] : '');
        return view($this->templateRoot . 'indexDataReconciliation', array_merge($this->dataOutCommon, [
            'data' => $dataList,
            'product_code' => $product_code,
            'table_view' => $table_view,
            'dataTotal' => $dataTotal,
            'search' => $search,
            'total' => $total,
            'optionProduct' => $optionProduct,
            'totalMoney' => $totalMoney,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
            'urlIndex' => URL::route(Route::currentRouteName()),
        ]));
    }

    private function _buildParamSearchReconciliation($product_code = '')
    {
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 1);

        $search['p_from_date'] = trim(addslashes(Request::get('p_from_date', getDateStartOfMonth())));
        $search['p_to_date'] = trim(addslashes(Request::get('p_to_date', getDateNow())));
        $search['p_org_code'] = trim(addslashes(Request::get('p_org_code', $this->user['org_code'])));
        $search['p_product_code'] = trim(addslashes(Request::get('p_product_code', $product_code)));
        $search['p_pack_code'] = trim(addslashes(Request::get('p_pack_code', '')));
        $search['p_month'] = trim(addslashes(Request::get('p_month', getTimeCurrent('m'))));
        $search['p_year'] = trim(addslashes(Request::get('p_year', getTimeCurrent('y'))));
        $search['is_accumulated_defaul'] = trim(addslashes(Request::get('is_accumulated_defaul', STATUS_INT_KHONG)));
        $search['page_no'] = ($submit == STATUS_INT_MOT) ? $page_no : STATUS_INT_KHONG;
        return $search;
    }

}
