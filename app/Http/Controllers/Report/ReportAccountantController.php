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
use App\Models\Report\ReportProduct;

use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use App\Services\ActionExcel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class ReportAccountantController extends BaseAdminController
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
        $optionProduct = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProductUser, isset($data['p_product_code']) ? $data['p_product_code'] : '');
        $optionSeller = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrOrgUser, isset($data['p_org_code']) ? $data['p_org_code'] : '');

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = (isset($request['objectId']) && trim($request['objectId']) != '0') ? 1 : 0;

        return $this->dataOutCommon = [
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
     * đối soát: bảo hiểm hành lý
     ********************************************************************************************/
    //đối soát: bảo hiểm hành lý
    public function indexAccountantLostBaggage()
    {
        return $this->_getDataCommon(PRODUCT_CODE_LOST_BAGGAGE);
    }

    private function _getDataCommon($product_code = '')
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Đối soát kế toán';
        CGlobal::$pageAdminTitle = $this->pageTitle . ' - Thống kê ' . CGlobal::$arrTitleProject[$this->tab_top];
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', STATUS_INT_MOT);

        if(!in_array($product_code,array_keys($this->arrProductUser))){
            $product_code = !empty($this->arrProductUser)? array_key_first($this->arrProductUser): DATA_SEARCH_NULL;
        }
        $search = $this->_buildParamSearchDetail($product_code);

        $dataList = [];
        $total = $totalList = 0;
        $totalMoney = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchReportProductDetail($search);
        $this->_outDataView($_GET, $search);
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data'][0] ?? $dataList;
            $total = count($dataList);
            $totalList = !empty($dataList) ? array_key_last($dataList) + 1 : $total;
        }

        $pro_code = $search['p_product_code'];
        $file_name = 'Báo cáo đối soát '.(isset($this->arrProductUser[$pro_code])? $this->arrProductUser[$pro_code]: '');;
        switch ($pro_code) {
            case PRODUCT_CODE_LOST_BAGGAGE:
                $type_export = ActionExcel::EXPORT_ACCOUNTANT_LOST_BAGGAGE;
                $table_view = '_tableAccountant_LOST_BAGGAGE';
                break;
            default:
                $type_export = ActionExcel::EXPORT_ACCOUNTANT_LOST_BAGGAGE;
                $table_view = '_tableAccountant_LOST_BAGGAGE';
                break;
        }

        //export excel
        if ($submit == STATUS_INT_HAI && trim($type_export) != '') {
            $this->actionExcel = new ActionExcel();
            $dataExcel = ['data' => $dataList, 'total' => $total, 'file_name' => $file_name];
            $this->actionExcel->exportExcel($dataExcel, $type_export);
        }

        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $arrProPage = [PRODUCT_CODE_BAY_AT, PRODUCT_CODE_LOST_BAGGAGE];
        if (!in_array($product_code, $arrProPage)) {
            unset($this->arrProductUser[PRODUCT_CODE_BAY_AT]);
            unset($this->arrProductUser[PRODUCT_CODE_LOST_BAGGAGE]);
        }
        $optionProduct = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProductUser, isset($search['p_product_code']) ? $search['p_product_code'] : '');
        return view($this->templateRoot . 'indexReportAccountant', array_merge($this->dataOutCommon, [
            'data' => $dataList,
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

    private function _buildParamSearchDetail($product_code = '')
    {
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 1);
        $search['p_org_code'] = trim(addslashes(Request::get('p_org_code', ORG_VIETJET_VN)));
        $search['p_product_code'] = trim(addslashes(Request::get('p_product_code', $product_code)));
        $search['p_pack_code'] = trim(addslashes(Request::get('p_pack_code', 'GOI_1')));
        $search['p_month'] = trim(addslashes(Request::get('p_month', getTimeCurrent('m'))));
        $search['p_year'] = trim(addslashes(Request::get('p_year', getTimeCurrent('y'))));
        $search['is_accumulated_defaul'] = trim(addslashes(Request::get('is_accumulated_defaul', STATUS_INT_KHONG)));
        $search['p_from_date'] = trim(addslashes(Request::get('p_from_date', getDateStartOfMonth())));
        $search['p_to_date'] = trim(addslashes(Request::get('p_to_date', getDateNow())));
        $search['checkItems'] = Request::get('checkItems', []);
        $search['type_excel'] = 2;//dùng cho đối soát cho kế toán
        //dùng xuất excel
        if ($product_code == PRODUCT_CODE_LOST_BAGGAGE) {
            $search['page_no'] = STATUS_INT_KHONG;//dùng cho đối soát VietJet
            if ($submit == STATUS_INT_HAI) {
                $arrCheck = isset($search['checkItems']) && !empty($search['checkItems']) ? $search['checkItems'] : [];
                $search['str_id'] = '';
                if (!empty($arrCheck)) {
                    $search['str_id'] = implode(';', $arrCheck);
                }
            }
        } else {
            $search['page_no'] = ($submit == STATUS_INT_MOT) ? $page_no : STATUS_INT_KHONG;
        }

        return $search;
    }

}
