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
use App\Http\Models\Report\ReportProduct;

use App\Http\Models\Selling\ClaimHdi;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use App\Services\ActionExcel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class ReportClaimController extends BaseAdminController
{
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrChannel = array();
    private $arrOrgAll = array();
    private $arrProduct = array();

    private $templateRoot = DIR_PRO_REPORT . '/';

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new ReportProduct();

        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_CLAIM_STATUS);
        $this->arrChannel = $this->getArrOptionTypeDefine(DEFINE_CHANNEL_HDI);
        $this->arrOrgAll = app(Organization::class)->getArrOptionOrg();
    }

    private function _outDataView($request, $data)
    {
        $this->arrProduct = $this->getInforUser('product');

        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['p_status']) ? $data['p_status'] : '');
        $optionChannel = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrChannel, isset($data['p_channel']) ? $data['p_channel'] : '');
        $optionProduct = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProductUser, isset($data['p_product_code']) ? $data['p_product_code'] : '');
        $optionOrg = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrOrgUser, isset($data['p_org_code']) ? $data['p_org_code'] : '');

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = (isset($request['objectId']) && trim($request['objectId']) != '0') ? 1 : 0;

        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'optionChannel' => $optionChannel,
            'optionOrg' => $optionOrg,
            'optionProduct' => $optionProduct,

            'arrStatus' => $this->arrStatus,
            'org_code_user' => $this->user['org_code'],

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route('claimHdi.index'),
            'urlGetItem' => URL::route('claimHdi.ajaxGetItem'),
            'urlPostItem' => URL::route('claimHdi.ajaxPostItem'),
            'urlAjaxGetData' => URL::route('claimHdi.ajaxGetData'),
            'urlChangeProcess' => URL::route('claimHdi.ajaxChangeProcess'),
            'userAction' => $this->user,
            'urlServiceFile' => Config::get('config.URL_HYPERSERVICES_' . Config::get('config.ENVIRONMENT')) . 'f/',
            'functionAction' => '_ajaxGetItemOther',
            'urlSearchAjax' => URL::route('claimHdi.getSearchAjax'),
            'formSeachIndex' => 'formSeachIndex',
        ];
    }

    /********************************************************************************************
     * Báo cáo VietJet
     *******************************************************************************************/
    public function indexClaimVietJet()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }

        $this->pageTitle = CGlobal::$pageAdminTitle = 'BC Bồi thường VietJet';
        CGlobal::$pageAdminTitle = $this->pageTitle . ' - Cấp đơn ' . CGlobal::$arrTitleProject[$this->tab_top];
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 0);
        if(in_array(PRODUCT_CODE_BAY_AT,$this->arrProductUser)){
            $product_code = trim(addslashes(Request::get('p_product_code', PRODUCT_CODE_BAY_AT)));
        }else{
            $product_code = !empty($this->arrProductUser)? array_key_first($this->arrProductUser): DATA_SEARCH_NULL;
        }

        $requestForm = $_GET;
        $search = app(ClaimHdi::class)->getParamSearch($requestForm, ORG_VIETJET_VN, $product_code);
        $pro_code = $search['p_product_code'];
        switch ($pro_code) {
            case PRODUCT_CODE_LOST_BAGGAGE:
            case PRODUCT_CODE_BAY_AT:
                $table_view = '_tableClaim_VIETJET';
                break;
            default:
                $table_view = '_tableClaim_VIETJET';
                break;
        }

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;

        $search['page_no'] = 1;
        $result = app(ClaimHdi::class)->searchClaimHdi($search);
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data'][0] ?? $dataList;
            $total = isset($dataList[0]->TOTAL) ? $dataList[0]->TOTAL : $total;
        }

        //xuất excel
        if ($submit == STATUS_INT_HAI) {
            $search['page_no'] = 0;
            $resultExcel = app(ReportProduct::class)->searchReportClaimVietjet($search);
            $dataListExcel = $resultExcel['Data'][0] ?? [];
            $totalExcel = count($dataListExcel);
            $dataExcel = ['data' => $dataListExcel, 'total' => $totalExcel];
            $this->actionExcel = new ActionExcel();
            $this->actionExcel->exportExcel($dataExcel, ActionExcel::EXPORT_EXCEL_CLAIM_VIETJET);
        }

        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';
        $this->_outDataView($_GET, $search);

        //option sản phẩm
        $arrProPage = [PRODUCT_CODE_BAY_AT, PRODUCT_CODE_LOST_BAGGAGE];
        $arrProductOption = getArrChild($this->arrProductUser, $arrProPage);
        $optionProduct = FunctionLib::getOption(['' => '---Chọn---'] + $arrProductOption, isset($search['p_product_code']) ? $search['p_product_code'] : '');
        $optionStatus = FunctionLib::getOptionMultil($this->arrStatus, (isset($search['p_status']) && trim($search['p_status'])) ? explode(';', $search['p_status']) : []);

        $this->dataOutItem = [
            'urlIndex' => URL::route('claimReport.indexClaimVietJet'),
            'optionProduct' => $optionProduct,
            'optionStatus' => $optionStatus,
        ];

        return view($this->templateRoot . 'indexReportClaim', array_merge([
            'data' => $dataList,
            'product_code' => $product_code,
            'table_view' => $table_view,
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,

        ], $this->dataOutCommon, $this->dataOutItem));
    }

}
