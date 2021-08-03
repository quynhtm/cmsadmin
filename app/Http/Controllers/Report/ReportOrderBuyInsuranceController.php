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

class ReportOrderBuyInsuranceController extends BaseAdminController
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

            'formSeachIndex' => 'formSeachIndex',
            'urlSearchAjax' => URL::route('report.getSearchAjaxReportOrderBuyInsurance'),
            'urlIndex' => URL::route('report.indexReportOrderBuyInsurance'),
            'urlGetItem' => URL::route('report.ajaxGetDetailFiles'),
            'functionAction' => '_ajaxGetItemOther',

        ];
    }

    /********************************************************************************************
     * Thông kê đăng ký mua bảo hiểm
     ********************************************************************************************/
    public function indexReportOrderBuyInsurance()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Thông kê đăng ký mua bảo hiểm';
        CGlobal::$pageAdminTitle = $this->pageTitle . ' - Thống kê ' . CGlobal::$arrTitleProject[$this->tab_top];
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', STATUS_INT_MOT);

        $search = $this->_buildParamSearch();
        $dataList = $dataInforFile = $listFile = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchReportOrderBuy($search);

        $this->_outDataView($_GET, $search);
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data'][0] ?? $dataList;
            $total = $result['Data'][0][0]->TOTAL ?? $total;
            $dataInforFile = $result['Data'][1] ?? [];
        }

        if(!empty($dataList) && !empty($dataInforFile)){
            foreach ($dataList as $k => $val_item){
                foreach ($dataInforFile as $kk => $val_file){
                    if($val_item->REGISTER_ID == $val_file->REGISTER_ID && trim($val_file->FILE_NAME) != ''){
                        $listFile[$val_file->REGISTER_ID][] = $val_file;
                    }
                }
            }
        }
        //myDebug($listFile);
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';
        return view($this->templateRoot . 'indexReportOrderBuyInsurance', array_merge($this->dataOutCommon, [
            'data' => $dataList,
            'listFile' => $listFile,
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,

        ]));
    }

    public function getSearchAjaxReportOrderBuyInsurance()
    {
        $search = $this->_buildParamSearch();
        $dataList = $dataInforFile = $listFile = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchReportOrderBuy($search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data'][0] ?? $dataList;
            $total = $result['Data'][0][0]->TOTAL ?? $total;
            $dataInforFile = $result['Data'][1] ?? [];
        }

        if(!empty($dataList) && !empty($dataInforFile)){
            foreach ($dataList as $k => $val_item){
                foreach ($dataInforFile as $kk => $val_file){
                    if($val_item->REGISTER_ID == $val_file->REGISTER_ID && trim($val_file->FILE_NAME) != ''){
                        $listFile[$val_file->REGISTER_ID][] = $val_file;
                    }
                }
            }
        }
        $page_no = (isset($search['page_no']) && trim($search['page_no']) != '') ? $search['page_no'] : STATUS_INT_MOT;
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        $templateOut = $this->templateRoot . '.orderBuyInsurance._tableOrderBuy';
        $div_show = (isset($search['div_show']) && trim($search['div_show']) != '') ? $search['div_show'] : '';
        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $dataList,
                'listFile' => $listFile,
                'search' => $search,
                'total' => $total,
                'stt' => ($page_no - 1) * $limit,
                'paging' => $paging,
            ], $this->dataOutCommon))->render();
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowId' => $div_show, 'message' => '');
        return Response::json($arrAjax);

    }

    public function ajaxGetDetailFiles()
    {
        $request = $_GET;
        $data = isset($request['dataInput'])? json_decode($request['dataInput']):[];
        $this->_outDataView($request, (array)$data);
        $html = View::make($this->templateRoot . 'orderBuyInsurance._popupListFiles')
            ->with(array_merge([
                'data' => isset($data->item)?$data->item:[],
            ], $this->dataOutCommon))->render();
        $arrAjax = array('success' => 1, 'html' => $html);
        return Response::json($arrAjax);
    }

    private function _buildParamSearch()
    {
        $request = $_GET;
        $dataForm = isset($request['dataForm']) ? $request['dataForm'] : [];

        $page_no = (isset($dataForm['page_no']) && trim($dataForm['page_no']) != '') ? $dataForm['page_no'] : STATUS_INT_MOT;
        $submit = (int)Request::get('submit', 1);
        $search['div_show'] = (isset($dataForm['div_show']) && trim($dataForm['div_show']) != '') ? $dataForm['div_show'] : '';

        $search['p_org_seller'] = (isset($dataForm['p_org_seller']) && trim($dataForm['p_org_seller']) != '') ? $dataForm['p_org_seller'] : trim(addslashes(Request::get('p_org_seller', '')));
        $search['p_product_code'] = (isset($dataForm['p_product_code']) && trim($dataForm['p_product_code']) != '') ? $dataForm['p_product_code'] : (!empty($this->arrProductUser)? array_key_first($this->arrProductUser): DATA_SEARCH_NULL);
        $search['f_date'] = (isset($dataForm['f_date']) && trim($dataForm['f_date']) != '') ? $dataForm['f_date'] : date('d/m/Y', strtotime(Carbon::now()->startOfMonth()));
        $search['t_date'] = (isset($dataForm['t_date']) && trim($dataForm['t_date']) != '') ? $dataForm['t_date'] : date('d/m/Y', strtotime(Carbon::now()));
        $search['text_search'] = (isset($dataForm['text_search']) && trim($dataForm['text_search']) != '') ? $dataForm['text_search'] : '';
        $search['page_no'] = ($submit == STATUS_INT_MOT) ? $page_no : STATUS_INT_KHONG;

        return $search;
    }

}
