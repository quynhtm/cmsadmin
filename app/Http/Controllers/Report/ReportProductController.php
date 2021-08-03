<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Report;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\OpenId\Organization;
use App\Http\Models\OpenId\UserSystem;
use App\Http\Models\Report\ReportProduct;
use App\Http\Models\Selling\Campaigns;

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

class ReportProductController extends BaseAdminController
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
     * báo cáo theo sản phẩm
     ********************************************************************************************/
    public function indexReportProduct()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Báo cáo theo sản phẩm';
        CGlobal::$pageAdminTitle = $this->pageTitle . ' - Thống kê ' . CGlobal::$arrTitleProject[$this->tab_top];
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', STATUS_INT_MOT);
        $product_code = trim(addslashes(Request::get('p_product_code', '')));

        if(!in_array($product_code,array_keys($this->arrProductUser))){
            $product_code = !empty($this->arrProductUser)? array_key_first($this->arrProductUser): DATA_SEARCH_NULL;
        }
        $dataForm['p_product_code'] = $product_code;
        $search = $this->_buildParamSearch($dataForm);

        $dataList = $dataTotalInfor = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchReportProduct($search);
        $this->_outDataView($_GET, $search);

        $pro_code = $search['p_product_code'];
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data'][0] ?? $dataList;
            $total = $result['Data'][0][0]->TOTAL ?? $total;
            $dataTotalInfor = $result['Data'][1][0] ?? [];
        }
        if ($submit == STATUS_INT_HAI) {
            $file_name = 'Báo cáo sản phẩm '.(isset($this->arrProductUser[$pro_code])? $this->arrProductUser[$pro_code]: '');
            $dataExcel = ['data' => $dataList, 'total' => $total, 'file_name' => $file_name];
            $this->actionExcel = new ActionExcel();
            $this->actionExcel->exportExcel($dataExcel, ActionExcel::EXPORT_PRODUCT_REPORT);
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        return view($this->templateRoot . 'indexReportProduct', array_merge($this->dataOutCommon, [
            'data' => $dataList,
            'dataTotalInfor' => $dataTotalInfor,//tổng tiền tổng bản ghi
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
            'formSeachIndex' => 'formSeachIndex',
            'urlSearchAjax' => URL::route('report.getSearchAjaxReportProduct'),
            'urlIndex' => URL::route('report.indexReportProduct'),
        ]));
    }

    public function getSearchAjaxReportProduct()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT], 'report.indexReportProduct')) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }

        $request = $_GET;
        $dataForm = isset($request['dataForm']) ? $request['dataForm'] : [];
        $product_code = trim($dataForm['p_product_code']);
        if(!in_array($product_code,array_keys($this->arrProductUser))){
            $product_code = !empty($this->arrProductUser)? array_key_first($this->arrProductUser): DATA_SEARCH_NULL;
        }
        $dataForm['p_product_code'] = $product_code;
        $search = $this->_buildParamSearch($dataForm);

        $dataList = $dataTotalInfor = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchReportProduct($search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data'][0] ?? $dataList;
            $total = $result['Data'][0][0]->TOTAL ?? $total;
            $dataTotalInfor = $result['Data'][1][0] ?? [];
        }
        $page_no = (isset($search['page_no']) && trim($search['page_no']) != '') ? $search['page_no'] : STATUS_INT_MOT;
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        $templateOut = $this->templateRoot . '.product._tableProduct';
        $div_show = (isset($search['div_show']) && trim($search['div_show']) != '') ? $search['div_show'] : '';
        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $dataList,
                'dataTotalInfor' => $dataTotalInfor,
                'search' => $search,
                'total' => $total,
                'stt' => ($page_no - 1) * $limit,
                'paging' => $paging,
                'formSeachIndex' => 'formSeachIndex',
                'urlSearchAjax' => URL::route('report.getSearchAjaxReportProduct'),
            ], $this->dataOutCommon))->render();
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowId' => $div_show, 'message' => '');
        return Response::json($arrAjax);

    }

    private function _buildParamSearch($dataForm = [])
    {
        $page_no = (isset($dataForm['page_no']) && trim($dataForm['page_no']) != '') ? $dataForm['page_no'] : STATUS_INT_MOT;
        $submit = (int)Request::get('submit', 1);
        $search['div_show'] = (isset($dataForm['div_show']) && trim($dataForm['div_show']) != '') ? $dataForm['div_show'] : '';

        $search['p_org_code'] = (isset($dataForm['p_org_code']) && trim($dataForm['p_org_code']) != '') ? $dataForm['p_org_code'] : trim(addslashes(Request::get('p_org_code', '')));
        $search['p_product_code'] = (isset($dataForm['p_product_code']) && trim($dataForm['p_product_code']) != '') ? $dataForm['p_product_code'] : trim(addslashes(Request::get('p_product_code', '')));
        $search['p_pack_code'] = (isset($dataForm['p_pack_code']) && trim($dataForm['p_pack_code']) != '') ? $dataForm['p_pack_code'] : trim(addslashes(Request::get('p_pack_code', 'GOI_1')));
        $search['p_month'] = (isset($dataForm['p_month']) && trim($dataForm['p_month']) != '') ? $dataForm['p_month'] : trim(addslashes(Request::get('p_month', getTimeCurrent('m'))));
        $search['p_year'] = (isset($dataForm['p_year']) && trim($dataForm['p_year']) != '') ? $dataForm['p_year'] : trim(addslashes(Request::get('p_year', getTimeCurrent('y'))));
        $search['is_accumulated_defaul'] = (isset($dataForm['is_accumulated_defaul']) && trim($dataForm['is_accumulated_defaul']) != '') ? $dataForm['is_accumulated_defaul'] : trim(addslashes(Request::get('is_accumulated_defaul', STATUS_INT_KHONG)));
        $search['page_no'] = ($submit == STATUS_INT_MOT) ? $page_no : STATUS_INT_KHONG;
        return $search;
    }

}
