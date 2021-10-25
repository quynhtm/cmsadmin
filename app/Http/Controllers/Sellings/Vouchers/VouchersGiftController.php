<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Sellings\Vouchers;

use App\Http\Controllers\BaseAdminController;
use App\Models\OpenId\Organization;
use App\Models\Selling\Campaigns;
use App\Models\Selling\VouchersGift;
use App\Models\Report\VouchersReport;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use App\Services\ActionExcel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class VouchersGiftController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrStatusValue = array();
    private $arrTypeGenerate = array();
    private $arrCurrency = array();
    private $arrYesOrNo = array();
    private $arrGiftType = array();
    private $arrOrg = array();
    private $arrCampaigns = array();
    private $arrDiscountUnit = array();
    private $arrHours = array();
    private $arrMinute = array();

    private $templateRoot = DIR_PRO_SELLING.'/'.DIR_MODULE_VOUCHERS . '.vouchersGift.';

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new VouchersGift();

        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_VOUCHER_VALUE_STATUS);
        $this->arrStatusValue = $this->getArrOptionTypeDefine(DEFINE_VOUCHER_VALUE_STATUS);
        $this->arrTypeGenerate = $this->getArrOptionTypeDefine(DEFINE_TYPE_GENERATE);
        $this->arrCurrency = $this->getArrOptionTypeDefine(DEFINE_CURRENCY);
        $this->arrYesOrNo = $this->getArrOptionTypeDefine(DEFINE_YES_OR_NO);
        $this->arrGiftType = $this->getArrOptionTypeDefine(DEFINE_VOUCHER_GIFT_TYPE);
        $this->arrDiscountUnit = $this->getArrOptionTypeDefine(DEFINE_VOUCHER_DISCOUNT_UNIT);

        $this->arrOrg = app(Organization::class)->getArrOptionOrg();
        $this->arrCampaigns = app(Campaigns::class)->getArrOptionCampaigns('VOUCHER');

        $this->arrHours = CGlobal::$arrHours;
        $this->arrMinute = CGlobal::$arrMinute;
    }

    private function _outDataView($request, $data)
    {
        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['STATUS']) ? $data['STATUS'] : '');
        $optionStatusSearch = FunctionLib::getOption(['' => '---Chọn---'] + [STATUS_VOUCHER_WAIT=>'Chờ duyệt',STATUS_VOUCHER_APPROVE=>'Duyệt'], isset($data['STATUS']) ? $data['STATUS'] : '');
        $optionTypeGenerate = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrTypeGenerate, isset($data['TYPE_GENERATE']) ? $data['TYPE_GENERATE'] : '');
        $optionCurrency = FunctionLib::getOption($this->arrCurrency, isset($data['CURRENCY']) ? $data['CURRENCY'] : '');
        $optionIsCombined = FunctionLib::getOption($this->arrYesOrNo, isset($data['IS_COMBINED']) ? $data['IS_COMBINED'] : '');
        $optionOrg = FunctionLib::getOption(['' => '---Chọn---'] +$this->arrOrg, isset($data['ORG_CODE']) ? $data['ORG_CODE'] : '');
        $optionCampaigns = FunctionLib::getOption(['' => '---Chọn---'] +$this->arrCampaigns, isset($data['CAMPAIGN_CODE']) ? $data['CAMPAIGN_CODE'] : '');
        $optionGiftType = FunctionLib::getOption(['' => '---Chọn---'] +$this->arrGiftType, isset($data['GIFT_TYPE']) ? $data['GIFT_TYPE'] : '');

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

    private function _validformdata($id = 0, &$data = array())
    {
        if (!empty($data)) {

            if (isset($data['TYPE_GENERATE']) && trim($data['TYPE_GENERATE']) == 'BYO') {
                $data['AMOUNT_ALLOCATE'] = STATUS_INT_MOT;
            }

            if (isset($data['AMOUNT_ALLOCATE']) && trim($data['AMOUNT_ALLOCATE']) == '') {
                $this->error[] = 'SL cấp phát chưa được nhập';
            }elseif(strpos(trim($data['AMOUNT_ALLOCATE']),'.') > 0){
                $this->error[] = 'SL cấp phát phải là số nguyên';
            }elseif((int)trim($data['AMOUNT_ALLOCATE']) <= 0){
                $this->error[] = 'SL cấp phát phải lớn hơn 0';
            }
            if (isset($data['MIN_VALUE']) && trim($data['MIN_VALUE']) != '' && strpos(trim($data['MIN_VALUE']),'.') > 0) {
                $this->error[] = 'Áp dụng cho ĐH phải là số nguyên';
            }elseif(isset($data['MIN_VALUE']) && trim($data['MIN_VALUE']) != '' && (int)trim($data['MIN_VALUE']) <= 0){
                $this->error[] = 'Áp dụng cho ĐH lớn hơn 0';
            }

            if (isset($data['USE_LIMIT']) && trim($data['USE_LIMIT']) == '') {
                $this->error[] = 'Số lần sử dụng cho 1 mã voucher chưa được nhập';
            }elseif(strpos(trim($data['USE_LIMIT']),'.') > 0){
                $this->error[] = 'Số lần sử dụng cho 1 mã voucher phải là số nguyên';
            }elseif((int)trim($data['USE_LIMIT']) <= 0){
                $this->error[] = 'Số lần sử dụng cho 1 mã voucher phải lớn hơn 0';
            }

            if (isset($data['EFFECTIVE_DATE']) && trim($data['EFFECTIVE_DATE']) == '') {
                $this->error[] = 'Ngày áp dụng phải được nhập';
            }elseif(!isValidDateTime(trim($data['EFFECTIVE_DATE']))){
                $this->error[] = 'Ngày áp dụng không đúng định dạng';
            }
           if (isset($data['EXPIRATION_DATE']) && trim($data['EXPIRATION_DATE']) != '') {
                if(!isValidDateTime(trim($data['EXPIRATION_DATE']))){
                    $this->error[] = 'Ngày hết hạn không đúng định dạng';
                }
            }
            if (!isset($data['DISCOUNT_UNIT'])) {
                $this->error[] = 'Loại voucher chưa được chọn';
            }

            if (isset($data['DISCOUNT_UNIT']) && trim($data['DISCOUNT_UNIT']) == '') {
                $this->error[] = 'Loại voucher chưa được chọn';
            } else {
                if (isset($data['DISCOUNT_UNIT']) && trim($data['DISCOUNT_UNIT']) == 'M') {
                    if (isset($data['DISCOUNT_M']) && trim($data['DISCOUNT_M']) == '') {
                        $this->error[] = 'Số tiền giảm giá không được bỏ trống';
                    }elseif (isset($data['DISCOUNT_M']) && (int)returnFormatMoney(trim($data['DISCOUNT_M'])) <= 0) {
                        $this->error[] = 'Số tiền giảm giá không được nhỏ hơn 0';
                    }/*elseif(strpos(trim($data['DISCOUNT_M']),'.') > 0){
                        $this->error[] = 'Số tiền giảm giá phải là số nguyên';
                    }*/  else {
                        $data['MAX_DISCOUNT_VALUE'] = '';
                        $data['DESCRIPTION'] = '';
                        $data['DISCOUNT'] = returnFormatMoney($data['DISCOUNT_M']);
                    }
                }
                if (isset($data['DISCOUNT_UNIT']) && trim($data['DISCOUNT_UNIT']) == 'P') {
                    if (isset($data['DISCOUNT_P']) && trim($data['DISCOUNT_P']) == '') {
                        $this->error[] = '% giảm giá không được bỏ trống';
                    }elseif (trim($data['MAX_DISCOUNT_VALUE']) != '' && (strpos(trim($data['MAX_DISCOUNT_VALUE']),'.') > 0 || (int)trim($data['MAX_DISCOUNT_VALUE']) <= 0)) {
                        $this->error[] = 'Giảm tối đa phải là số nguyên > 0';
                    }elseif ((float)trim($data['DISCOUNT_P']) <= 0 || (float)trim($data['DISCOUNT_P']) > 100) {
                        $this->error[] = '% giảm giá trong khoảng lớn hơn 0 và nhỏ hơn 100';
                    }else {
                        $data['MAX_DISCOUNT_VALUE'] = $data['MAX_DISCOUNT_VALUE'];
                        $data['DISCOUNT'] = $data['DISCOUNT_P'];
                        $data['DESCRIPTION'] = '';
                    }
                }
                if (isset($data['DISCOUNT_UNIT']) && trim($data['DISCOUNT_UNIT']) == 'G') {
                    if (isset($data['DESCRIPTION']) && trim($data['DESCRIPTION']) == '') {
                        $this->error[] = 'Mô tả quà tặng không được bỏ trống';
                    }elseif (isset($data['DISCOUNT_G']) && trim($data['DISCOUNT_G']) == '') {
                        $this->error[] = 'Giá trị quà tặng không được bỏ trống';
                    }elseif (isset($data['DISCOUNT_G']) && (int)trim($data['DISCOUNT_G']) <= 0) {
                        $this->error[] = 'Giá trị quà tặng không được nhỏ hơn 0';
                    }elseif(strpos(trim($data['DISCOUNT_G']),'.') > 0){
                        $this->error[] = 'Giá trị quà tặng phải là số nguyên';
                    }
                    else {
                        $data['MAX_DISCOUNT_VALUE'] = '';
                        $data['DISCOUNT'] = $data['DISCOUNT_G'];
                    }
                }
            }
            if (isset($data['CAMPAIGN_CODE']) && trim($data['CAMPAIGN_CODE']) == '') {
                $this->error[] = 'Chiến dịch chưa được chọn';
            } elseif (isset($data['GIFT_CODE']) && trim($data['GIFT_CODE']) == '') {
                $this->error[] = 'Mã tiền tố không được bỏ trống';
            } elseif (isset($data['GIFT_TYPE']) && trim($data['GIFT_TYPE']) == '') {
                $this->error[] = 'Voucher dành cho chưa được chọn';
            } else {
                if ($id == 0) {
                    $itemExits = $this->modelObj->getVoucherCodeByKey($data['CAMPAIGN_CODE'], $data['GIFT_CODE'], $data['GIFT_TYPE']);
                    if ($itemExits) {
                        $this->error[] = 'Đã tồn tại cấu trúc mã voucher này.';
                    }
                }
            }

        }
        return true;
    }

    /*********************************************************************************************************
     * Danh mục: Voucher
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = 'Cấp phát Voucher';
        CGlobal::$pageAdminTitle = $this->pageTitle.' - Quản lý Voucher '.CGlobal::$arrTitleProject[$this->tab_top];
        $page_no = (int)Request::get('page_no', 1);

        $search['ORG_CODE'] = addslashes(Request::get('ORG_CODE', ''));
        $search['GIFT_TYPE'] = addslashes(Request::get('GIFT_TYPE', ''));
        $search['STATUS'] = addslashes(Request::get('STATUS', ''));
        $search['p_keyword'] = trim(addslashes(Request::get('p_keyword', '')));
        $search['p_org_code'] = $search['ORG_CODE'];
        $search['p_gift_type'] = $search['GIFT_TYPE'];
        $search['p_is_active'] = $search['STATUS'];
        $search['page_no'] = $page_no;

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchVoucherCode($search);
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data']['data'] ?? $dataList;
            $total = $result['Data']['total'] ?? $total;
        }
        //myDebug($dataList);
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'viewIndex', array_merge([
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,

        ], $this->dataOutCommon));
    }

    /*********************************************************************************************************
     * Danh mục: VouchersReport
     *********************************************************************************************************/
    public function indexReport()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Báo cáo Vouchers';
        $page_no = (int)Request::get('page_no', 1);

        $search['ORG_CODE'] = addslashes(Request::get('ORG_CODE', ''));
        $search['CAMPAIGN_CODE'] = addslashes(Request::get('CAMPAIGN_CODE', ''));
        $search['p_keyword'] = trim(addslashes(Request::get('p_keyword', '')));
        $search['p_from_date'] = trim(addslashes(Request::get('p_from_date', date('d/m/Y',strtotime(Carbon::now()->startOfMonth())))));
        $search['p_to_date'] = trim(addslashes(Request::get('p_to_date', date('d/m/Y',strtotime(Carbon::now())))));
        $search['p_org_code'] = $search['ORG_CODE'];
        $search['p_campaign_code'] = $search['CAMPAIGN_CODE'];
        $search['page_no'] = $page_no;

        $dataList = [];
        $total = $totalMoney = 0;
        $limit = CGlobal::number_show_10;
        $result = app(VouchersReport::class)->searchVouchersReport($search);
        //$result = app(VouchersReport::class)->searchVouchersReportStaffRegisGhealth($search);
        //myDebug($result);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['data'] ?? $dataList;
            $total = $result['total'] ?? $total;
            $totalMoney = $result['total_money'] ?? $totalMoney;
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'viewIndexReport', array_merge( $this->dataOutCommon,[
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'totalMoney' => $totalMoney,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
            'urlIndex' => URL::route('vouchersGift.indexReport')
        ]));
    }

    /*********************************************************************************************************
     * Danh mục: VouchersDetails
     *********************************************************************************************************/
    public function indexDetails()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Quản lý Vouchers Details';
        $page_no = (int)Request::get('page_no', 1);

        $search['ORG_CODE'] = addslashes(Request::get('ORG_CODE', ''));
        $search['CAMPAIGN_CODE'] = addslashes(Request::get('CAMPAIGN_CODE', ''));
        $search['p_status'] = addslashes(Request::get('p_status', ''));
        $search['p_keyword'] = trim(addslashes(Request::get('p_keyword', '')));
        $search['p_block_code'] = trim(addslashes(Request::get('p_block_code', '')));
        $search['p_sort_order'] = trim(addslashes(Request::get('p_sort_order', '')));
        $search['p_campaign_code'] = $search['CAMPAIGN_CODE'];
        $search['p_org_code'] = $search['ORG_CODE'];
        $search['p_gift_code'] = '';
        $search['page_no'] = $page_no;

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchVoucherDetails($search);
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data']['data'] ?? $dataList;
            $total = $result['Data']['total'] ?? $total;
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $arrStatusDetail = [STATUS_INT_MOT => 'Chưa gán đối tác',
            STATUS_INT_HAI => 'Gán đối tác và đã được sử dụng hết',
            STATUS_INT_BA => 'Gán cho đối tác',
            STATUS_INT_BON => 'Đã được activate bởi người dùng'];
        $optionStatusDetail = FunctionLib::getOption(['' => '---Chọn---'] + $arrStatusDetail, isset($search['p_status']) ? $search['p_status'] : '');

        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'viewIndexDetails', array_merge( $this->dataOutCommon,[
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
            'optionStatusDetail' => $optionStatusDetail,
            'urlIndex' => URL::route('vouchersGift.indexDetails')
        ]));
    }

    public function ajaxGetItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_GET;
        $arrAjax = $this->_getInfoItem($request);
        return Response::json($arrAjax);
    }

    private function _getInfoItem($request)
    {
        $objectId = $request['objectId'] ?? '';
        $data = $arrOrgByCampCode = [];
        if (trim($objectId) != '' || trim($objectId) != '0') {
            $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
            $campaign_code = isset($dataInput->item) ? $dataInput->item->CAMPAIGN_CODE : '';
            $gift_code = isset($dataInput->item) ? $dataInput->item->GIFT_CODE : '';
            $gift_type = isset($dataInput->item) ? $dataInput->item->GIFT_TYPE : '';

            $data = $this->modelObj->getVoucherCodeByKey($campaign_code, $gift_code, $gift_type);
            $arrOrgByCampCode = app(Campaigns::class)->getArrOptionOrgByCampaignCode($campaign_code);

            //lay dư liệu tab default
            if ($data) {
                $dataOther = $this->modelObj->getListVoucherValueByKey($campaign_code, $gift_code, $gift_type);
                //lấy tổng số cấp phát
                $amountAllocateCode = isset($data->AMOUNT_ALLOCATE)?$data->AMOUNT_ALLOCATE:0;
                $amountAllocateValue = $amountAllocateCode;
                if($dataOther){
                    foreach ($dataOther as $ky =>$gift_value){
                        if(in_array($gift_value->STATUS,[STATUS_VOUCHER_APPROVE,STATUS_VOUCHER_WAIT])){
                            $amountAllocateValue = $amountAllocateValue-$gift_value->AMOUNT_ALLOCATE;
                        }
                    }
                }
                $this->dataOutItem = [
                    'formNameOther' => $this->tabOtherItem1,
                    'dataOther' => $dataOther,
                    'typeTab' => $this->tabOtherItem1,
                    'obj_id' => 1,
                    'divShowId' => $this->tabOtherItem1,
                    'amountAllocateValue' => $amountAllocateValue,
                ];
            }
        }
        $this->_outDataView($request, (array)$data);
        $optionOrgByCampCode = FunctionLib::getOption(['' => '---Chọn---'] + $arrOrgByCampCode, isset($data->ORG_CODE) ? $data->ORG_CODE : '');

        $templateDetail = isset($request['templateDetailItem'])? $request['templateDetailItem']: 'popupDetail';
        $html = View::make($this->templateRoot . 'component.'.$templateDetail)
            ->with(array_merge([
                'data' => $data,
                'optionOrgByCampCode' => $optionOrgByCampCode,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $divShowInfor = isset($request['divShowInfor']) ? $request['divShowInfor'] : 'formShowEditSuccess';//div show infor item
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor);
        return $arrAjax;
    }

    public function ajaxPostItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $dataRequest = $_POST;
        $dataForm = $dataRequest['dataForm'] ?? [];

        $id = $dataForm['objectId'] ?? 0;
        if (empty($dataForm)) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }
        if ($this->_validFormData($id, $dataForm) && empty($this->error)) {
            $result = $this->modelObj->editVoucherCode($dataForm, ($id > 0) ? 'EDIT' : 'ADD');
            if ($result['Success'] == STATUS_INT_MOT) {
                //EDIT: lấy lại dữ liệu đã cập nhật để hiển thị lại
                if ($id > 0) {
                    $request['objectId'] = $id;
                    $request['formName'] = $dataForm['formName'];
                    $request['divShowInfor'] = 'formShowEditSuccess';
                    $request['templateDetailItem'] = '_detailFormItem';
                    $request['dataInput'] = json_encode(['item' => $dataForm]);
                    $arrAjax = $this->_getInfoItem($request);

                } //ADD: thêm mới thì load lại dư liệu để nhập các thông tin khác
                else {
                    $request['objectId'] = 1;
                    $request['divShowInfor'] = 'divDetailItem';
                    $request['dataInput'] = json_encode(['item' => $dataForm]);
                    $arrAjax = $this->_getInfoItem($request);
                }
                return Response::json($arrAjax);
            } else {
                return Response::json(returnError($result['Message']));
            }
        } else {
            return Response::json(returnError($this->error));
        }
    }

    public function ajaxUpdateStatusCode()
    {
        $request = $_POST;
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
        $campaign_code = isset($dataInput->item) ? $dataInput->item->CAMPAIGN_CODE : '';
        $gift_code = isset($dataInput->item) ? $dataInput->item->GIFT_CODE : '';
        $gift_type = isset($dataInput->item) ? $dataInput->item->GIFT_TYPE : '';

        $data = $this->modelObj->getVoucherCodeByKey($campaign_code, $gift_code, $gift_type);

        if($data){
            $statusActive = $data->STATUS;
            if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT]) && !in_array($statusActive,[STATUS_VOUCHER_WAIT])) {
                return Response::json(returnError(viewLanguage('Trạng thái này không được xóa.')));
            }
            $result = $this->modelObj->updateStatusVoucherCode((array)$data, STATUS_VOUCHER_CANCEL);
            if ($result['Success'] == STATUS_INT_MOT) {
                return Response::json(returnSuccess());
            } else {
                return Response::json(returnError($result['Message']));
            }
        }
        return Response::json(returnError(viewLanguage('Không đúng thao tác! Hãy thử lại')));
    }

    /*********************************************************************************************************
     * Các quan hệ của APIS tab
     *********************************************************************************************************/
    private function _ajaxGetItemOther($request)
    {
        $data = $inforItem = [];
        $formNameOther = isset($request['formName']) ? $request['formName'] : 'formName';
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'], true) : false;
        $typeTab = isset($dataInput['type']) ? $dataInput['type'] : '';
        $action = isset($dataInput['action']) ? $dataInput['action'] : 'getDetailItemOther';
        $isDetail = isset($dataInput['isDetail']) ? $dataInput['isDetail'] : STATUS_INT_KHONG;
        $arrOtherForm = isset($dataInput['itemOther']) ? $dataInput['itemOther'] : [];
        $arrKey = isset($dataInput['arrKey']) ? $dataInput['arrKey'] : [];

        $actionEdit = STATUS_INT_KHONG;
        $objectId = $request['objectId'];
        $templateOut = $this->templateRoot . 'component._formVoucherValue';

        $campaign_code = isset($arrKey['CAMPAIGN_CODE']) ? $arrKey['CAMPAIGN_CODE'] : '';
        $gift_code = isset($arrKey['GIFT_CODE']) ? $arrKey['GIFT_CODE'] : '';
        $gift_type = isset($arrKey['GIFT_TYPE']) ? $arrKey['GIFT_TYPE'] : '';
        //data chính
        if (trim($campaign_code) != '' && trim($gift_code) != '' && trim($gift_type) != '') {
            $data = $this->modelObj->getVoucherCodeByKey($campaign_code, $gift_code, $gift_type);
        }
        $amountAllocateCode = isset($data->AMOUNT_ALLOCATE)?$data->AMOUNT_ALLOCATE:0;
        $amountAllocateValue = $amountAllocateCode;
        $optionProduct = $optionPack = $optionStatusValue = [];
        switch ($action) {
            case 'getDetailItemOther':
                //detail other
                if (trim($objectId) != '' && $isDetail == STATUS_INT_MOT) {
                    $inforItem = $this->modelObj->getVoucherValueByKey($objectId);
                    $arrOption = $this->modelObj->getOptionDataByCampaignCode($data->CAMPAIGN_CODE);
                    $arrProduct = $arrOption['optionProduct'];
                    $arrPack = $arrOption['optionPack'];
                    $optionStatusValue = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatusValue, isset($inforItem->STATUS) ? $inforItem->STATUS : '');
                    $optionProduct = FunctionLib::getOption($arrProduct, isset($inforItem->REF_CODE) ? $inforItem->REF_CODE : '');
                    $optionPack = FunctionLib::getOption($arrPack, isset($inforItem->REF_DETAIL_CODE) ? $inforItem->REF_DETAIL_CODE : '');
                    //lấy tổng số cấp phát
                    $listValue = $this->modelObj->getListVoucherValueByKey($campaign_code, $gift_code, $gift_type);
                    if($listValue){
                        foreach ($listValue as $ky =>$gift_value){
                            if(in_array($gift_value->STATUS,[STATUS_VOUCHER_APPROVE,STATUS_VOUCHER_WAIT])){
                                $amountAllocateValue = $amountAllocateValue-$gift_value->AMOUNT_ALLOCATE;
                            }
                        }
                    }
                }// list other
                else {
                    $inforItem = $this->modelObj->getListVoucherValueByKey($campaign_code, $gift_code, $gift_type);
                    if($inforItem){
                        foreach ($inforItem as $ky =>$gift_value){
                            if(in_array($gift_value->STATUS,[STATUS_VOUCHER_APPROVE,STATUS_VOUCHER_WAIT])){
                                $amountAllocateValue = $amountAllocateValue-$gift_value->AMOUNT_ALLOCATE;
                            }
                        }
                    }
                    $templateOut = $this->templateRoot . 'component._listVoucherValue';
                }
                break;
            case 'getAllocateToPartners':
                $inforItem = $this->modelObj->getVoucherValuesPresentByKey($campaign_code, $gift_code, $gift_type);
                $arrOption = $this->modelObj->getOptionDataByCampaignCode($data->CAMPAIGN_CODE);
                $arrProduct = $arrOption['optionProduct'];
                $arrPack = $arrOption['optionPack'];
                $this->dataOutItem = [
                    'arrProductOther' => $arrProduct,
                    'arrPackOther' => $arrPack,
                ];
                $templateOut = $this->templateRoot . 'component._formAllocateToPartners';
                break;
            default:
                break;
        }
        $this->_outDataView($request, (array)$data);
        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $data,
                'optionProduct' => $optionProduct,
                'optionPack' => $optionPack,
                'optionStatusValue' => $optionStatusValue,
                'dataOther' => $inforItem,
                'actionEdit' => $actionEdit,//0: thêm mới, 1: edit
                'objectId' => $objectId,
                'amountAllocateValue' => $amountAllocateValue,
                'formNameOther' => $formNameOther,
                'typeTab' => $typeTab,
                'divShowId' => $typeTab,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        return $html;
    }

    private function _updateDataRelation($dataForm)
    {
        $objectId = (int)$dataForm['objectId'];
        $actionForm = $dataForm['actionForm'];
        $result = ['Success' => 0, 'Data' => [], 'Message' => 'Không đúng thao tác! Hãy thử lại'];
        switch ($actionForm) {
            case 'voucherValue':
                $result = $this->modelObj->editVoucherValue($dataForm, ($objectId > 0) ? 'EDIT' : 'ADD');
                break;
            case 'voucherAllocateToParter':
                $dataSent = $this->_builDataPresent($dataForm);
                if(!empty($dataSent)){
                    $result = $this->modelObj->editVoucherValuePresent($dataSent);
                    if ($result['Success'] != STATUS_INT_MOT) {
                        return Response::json(returnError('Lỗi chưa cấp phát thành công'));
                    }
                }
                break;
            default:
                break;
        }
       if ($result['Success'] == STATUS_INT_MOT) {
            //lấy lại dữ liệu vừa sửa
            $dataInput['type'] = $dataForm['typeTabAction'];
            $dataInput['isDetail'] = STATUS_INT_KHONG;
            $dataInput['arrKey'] = ['CAMPAIGN_CODE'=>$dataForm['CAMPAIGN_CODE'],'GIFT_CODE'=>$dataForm['GIFT_CODE'],'GIFT_TYPE'=>$dataForm['GIFT_TYPE']];
            $dataInput['itemOther'] = $dataForm;
            $requestLoad['dataInput'] = json_encode($dataInput);

            $requestLoad['objectId'] = $objectId;
            $requestLoad['divShowId'] = $dataForm['typeTabAction'];
            $requestLoad['formName'] = $dataForm['formName'];

            $html = $this->_ajaxGetItemOther($requestLoad);
            $arrAjax = array('success' => 1, 'message' => 'Successfully', 'divShowAjax' => $requestLoad['divShowId'], 'html' => $html);

            return Response::json($arrAjax);
        } else {
            return Response::json(returnError($result['Message']));
        }
    }

    private function _builDataPresent($dataForm){
        $result = [];
        if(!empty($dataForm)){
            $campaign_code = isset($dataForm['CAMPAIGN_CODE']) ? $dataForm['CAMPAIGN_CODE'] : '';
            $gift_code = isset($dataForm['GIFT_CODE']) ? $dataForm['GIFT_CODE'] : '';
            $gift_type = isset($dataForm['GIFT_TYPE']) ? $dataForm['GIFT_TYPE'] : '';
            if(trim($campaign_code) != '' && trim($gift_code) != '' && trim($gift_type) != ''){
                $listValue = $this->modelObj->getVoucherValuesPresentByKey($campaign_code, $gift_code, $gift_type);
                if($listValue){
                    foreach ($listValue as $kk =>$other){
                        $soluongcapphatchophep = (int)($other->AMOUNT_ALLOCATE-$other->COUNT_ACTIVATION_CODE);
                        $soLuongCapPhat = (int)trim($dataForm[$other->BLOCK_CODE.'_AMOUNT_ALLOCATE']);
                        if($soLuongCapPhat > 0 && $soluongcapphatchophep >0 && trim($dataForm['ORG_CODE']) != ''){
                            $other->AMOUNT_ALLOCATE = $soLuongCapPhat;
                            $other->ORG_CODE = $dataForm['ORG_CODE'];
                            $result[] = (array)$other;
                        }
                    }
                }
            }
            return $result;
        }
    }
    public function ajaxGetData()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $dataRequest = $_POST;
        $functionAction = $dataRequest['functionAction'] ?? '';
        $html = '';
        $success = STATUS_INT_KHONG;
        if (trim($functionAction) != '') {
            $html = $this->$functionAction($dataRequest);
            $success = STATUS_INT_MOT;
        }
        $arrAjax = array('success' => $success, 'html' => $html);
        return Response::json($arrAjax);
    }

    public function ajaxUpdateRelation()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $dataRequest = $_POST;
        $dataForm = $dataRequest['dataForm'] ?? [];

        if (empty($dataRequest)) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }
        //check form with file upload
        $typeTabAction = isset($dataRequest['typeTabAction']) ? $dataRequest['typeTabAction'] : $dataForm['typeTabAction'];
        $dataForm = isset($dataRequest['typeTabAction']) ? $dataRequest : $dataForm;
        $objectId = (int)$dataForm['objectId'];
        if ($this->_validFormDataRelation($typeTabAction, $objectId, $dataForm) && empty($this->error)) {
            $actionUpdate = $this->_updateDataRelation($dataForm);
            return $actionUpdate;
        } else {
            return Response::json(returnError($this->error));
        }
    }

    private function _validFormDataRelation($typeTabAction = '', $objectId = STATUS_INT_KHONG, &$data = array())
    {
        switch ($typeTabAction) {
            case $this->tabOtherItem1:
                if (!empty($data)) {
                    if($objectId == 0){
                        if (isset($data['AMOUNT_ALLOCATE']) && trim($data['AMOUNT_ALLOCATE']) == '') {
                            $this->error[] = 'Số lượng cấp phát';
                        }elseif (isset($data['amountAllocateValue']) && isset($data['AMOUNT_ALLOCATE'])) {
                            if($data['amountAllocateValue'] < $data['AMOUNT_ALLOCATE']){
                                $this->error[] = 'Số lượng cấp phát vượt quá giới hạn';
                            }
                        }
                    }

                    if (isset($data['EFFECTIVE_DATE']) && trim($data['EFFECTIVE_DATE']) == '') {
                        $this->error[] = 'Ngày áp dụng phải được nhập';
                    }elseif(isset($data['EFFECTIVE_DATE']) && !isValidDateTime(trim($data['EFFECTIVE_DATE']))){
                        $this->error[] = 'Ngày áp dụng không đúng định dạng';
                    }else{
                        if (isset($data['EFFECTIVE_HOURS']) && isset($data['EFFECTIVE_MINUTE'])) {
                            $data['EFFECTIVE_DATE'] = $data['EFFECTIVE_DATE'].' '.$data['EFFECTIVE_HOURS'].':'.$data['EFFECTIVE_MINUTE'];
                        }
                    }

                    if (isset($data['EXPIRATION_DATE']) && trim($data['EXPIRATION_DATE']) != '') {
                        if(!isValidDateTime(trim($data['EXPIRATION_DATE']))){
                            $this->error[] = 'Ngày hết hạn không đúng định dạng';
                        }else{
                            if (((int)$data['EFFECTIVE_HOURS'] > (int)$data['EXPIRATION_HOURS'])){
                                $this->error[] = 'Giờ hiệu lực đang lớn hơn giờ hết hiệu lực';
                            }elseif (((int)$data['EFFECTIVE_HOURS'] == (int)$data['EXPIRATION_HOURS']) && ((int)$data['EFFECTIVE_MINUTE'] > (int)$data['EXPIRATION_MINUTE'])){
                                $this->error[] = 'Phút hiệu lực đang nhỏ hơn Phút hết hiệu lực';
                            }elseif (isset($data['EXPIRATION_HOURS']) && isset($data['EXPIRATION_MINUTE'])) {
                                $data['EXPIRATION_DATE'] = $data['EXPIRATION_DATE'].' '.$data['EXPIRATION_HOURS'].':'.$data['EXPIRATION_MINUTE'];
                            }
                        }
                    }
                }
                break;
            default:
                break;
        }
        return true;
    }

    public function ajaxSearchOtherItem()
    {
        $request = $_POST;
        $key_search = isset($request['key_search']) ? trim($request['key_search']) : '';
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'], true) : false;
        $divShowId = isset($dataInput['divShowId']) ? $dataInput['divShowId'] : '';

        $arrKey = isset($dataInput['arrKey']) ? $dataInput['arrKey'] : [];
        $campaign_code = isset($arrKey['CAMPAIGN_CODE']) ? $arrKey['CAMPAIGN_CODE'] : '';
        $gift_code = isset($arrKey['GIFT_CODE']) ? $arrKey['GIFT_CODE'] : '';
        $gift_type = isset($arrKey['GIFT_TYPE']) ? $arrKey['GIFT_TYPE'] : '';

        if(trim($key_search) != ''){
            $inforItem = $this->modelObj->getListVoucherValueByKey($campaign_code, $gift_code, $gift_type, $key_search);
            $templateOut = $this->templateRoot . 'component._listVoucherValue';
            $this->_outDataView($request, []);
            $html = View::make($templateOut)
                ->with(array_merge([
                    'dataOther' => $inforItem,
                ], $this->dataOutCommon, $this->dataOutItem))->render();
            $arrAjax = array('success' => 1, 'divShowId' => $divShowId, 'html' => $html);
            return Response::json($arrAjax);
        }
    }

    public function ajaxUpdateStatusValue()
    {
        $dataForm = $_POST;
        $objectId = (int)$dataForm['objectId'];
        $statusActive = strtoupper(trim($dataForm['typeActive']));
        $noteCancel = trim($dataForm['noteCancel']);

        $result = returnError('Không đúng thao tác! Hãy thử lại');
        if (!in_array($statusActive,[STATUS_VOUCHER_APPROVE,STATUS_VOUCHER_CANCEL,STATUS_VOUCHER_REFUSE])) {
            return Response::json(returnError(viewLanguage('Thao tác không đúng định dạng.')));
        }
        if (!$this->checkMultiPermiss([PERMISS_APPROVE]) && in_array($statusActive,[STATUS_VOUCHER_APPROVE,STATUS_VOUCHER_REFUSE])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT]) && in_array($statusActive,[STATUS_VOUCHER_CANCEL])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $dataValue = $this->modelObj->getVoucherValueByKey($objectId);
        if(isset($dataValue->GCV_ID) && $dataValue->GCV_ID > 0){
            if($dataValue->GCV_ID == $statusActive){
                $result['Success'] == STATUS_INT_MOT;
            }else{
                switch ($statusActive) {
                    case STATUS_VOUCHER_APPROVE://duyệt
                    case STATUS_VOUCHER_CANCEL://Hủy
                        $result = $this->modelObj->updateStatusVoucherValue((array)$dataValue, $dataValue->GCV_ID, $statusActive);
                        break;
                    case STATUS_VOUCHER_REFUSE://từ chối
                        $result = $this->modelObj->updateStatusVoucherValue((array)$dataValue, $dataValue->GCV_ID, $statusActive,$noteCancel);
                        break;
                    default:
                        break;
                }
            }
            if ($result['Success'] == STATUS_INT_MOT) {
                //lấy lại dữ liệu vừa sửa
                $dataInput['type'] = $this->tabOtherItem1;
                $dataInput['isDetail'] = STATUS_INT_KHONG;
                $dataInput['arrKey'] = ['CAMPAIGN_CODE'=>$dataValue->CAMPAIGN_CODE,'GIFT_CODE'=>$dataValue->GIFT_CODE,'GIFT_TYPE'=>$dataValue->GIFT_TYPE];
                $dataInput['itemOther'] = $dataValue;
                $requestLoad['dataInput'] = json_encode($dataInput);

                $requestLoad['objectId'] = $objectId;
                $requestLoad['divShowId'] = $dataForm['divShow'];
                $requestLoad['formName'] = $dataForm['formName'];

                $html = $this->_ajaxGetItemOther($requestLoad);
                $arrAjax = array('success' => 1, 'message' => 'Successfully', 'divShowAjax' => $requestLoad['divShowId'], 'html' => $html);

                return Response::json($arrAjax);
            } else {
                return Response::json(returnError($result['Message']));
            }
        }
        return Response::json(returnError(viewLanguage('Không đúng thao tác! Hãy thử lại')));
    }

    public function getExportExcel($sId){
        if (!$this->checkMultiPermiss([PERMISS_APPROVE])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $id = getStrVar($sId);
        $this->actionExcel = new ActionExcel();
        if($id > 0){
            $dataVoucherValue = $this->modelObj->getVoucherValueByKey($id);
            if($dataVoucherValue){
                $dataRequest["p_campaign_code"] = $dataVoucherValue->CAMPAIGN_CODE;
                $dataRequest["p_org_code"] = $dataVoucherValue->ORG_CODE;
                $dataRequest["p_gift_code"] = $dataVoucherValue->GIFT_CODE;
                $dataRequest["p_block_code"] = $dataVoucherValue->BLOCK_CODE;
                $dataDetail = $this->modelObj->searchListVoucherDetail($dataRequest);
                if(!empty($dataDetail['Data']['data'])){
                    $dataExport = $dataDetail['Data']['data'];
                    $this->actionExcel->exportExcel($dataExport,'VOUCHER_DETAIL');
                }
            }
        }
        return Response::json(returnError(viewLanguage('Khong co du lieu de xuat excel')));
    }
}
