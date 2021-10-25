<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Sellings\PaymentContract;

use App\Http\Controllers\BaseAdminController;
use App\Models\OpenId\Organization;
use App\Models\OpenId\Province;
use App\Models\Selling\PaymentContract;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class PaymentContractController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrOrgAll = array();
    private $arrProvince = array();
    private $arrLoaiCapDon = array();
    private $arrProduct = array();

    private $templateRoot = DIR_PRO_SELLING . '/' . DIR_MODULE_PAYMENT_CONTRACT . '.';

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new PaymentContract();

        $this->arrLoaiCapDon = $this->getArrOptionTypeDefine(DEFINE_LOAI_CAP_DON);
        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_PAY_STATUS);
        $this->arrOrgAll = app(Organization::class)->getArrOptionOrg();

        $this->arrProvince = app(Province::class)->getOptionProvince();
    }

    private function _outDataView($request, $data)
    {
        $this->arrProduct = $this->getInforUser('product');
        $optionProduct = FunctionLib::getOption([''=>'--Chọn---']+$this->arrProduct, isset($data['p_product_code']) ? $data['p_product_code'] : '');
        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['p_status']) ? $data['p_status'] : '');
        $optionOrg = FunctionLib::getOption(['' => '---Chọn đơn vị cấp---'] + $this->arrOrgAll, isset($data['p_org_code']) ? $data['p_org_code'] : '');

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = (isset($request['objectId']) && trim($request['objectId']) != '0') ? 1 : 0;

        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'optionOrg' => $optionOrg,
            'optionProduct' => $optionProduct,
            'org_code_user' => $this->user['org_code'],

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route('paymentContract.index'),
            'urlGetItem' => URL::route('paymentContract.ajaxGetItem'),
            'urlPostItem' => URL::route('paymentContract.ajaxPostItem'),
            'urlAjaxGetData' => URL::route('paymentContract.ajaxGetData'),
            'urlApprovalOrder' => URL::route('paymentContract.ajaxApprovalOrder'),
            'urlMovePay' => URL::route('paymentContract.ajaxMovePay'),
            'urlSearchAdvanced' => URL::route('paymentContract.ajaxSearchAdvanced'),
            'urlActionOtherItem' => '',
            'urlSearchOtherItem' => '',
            'urlUpdateStatusOtherItem' => '',
            'urlUpdateStatusItem' => '',
            'functionAction' => '_ajaxGetItemOther',
        ];
    }

    private function _validformdata($id = 0, &$data = array())
    {
        if (!empty($data)) {
            if (isset($data['AMOUNT_ALLOCATE']) && trim($data['AMOUNT_ALLOCATE']) == '') {
                $this->error[] = 'SL cấp phát chưa được nhập';
            }
        }
        return true;
    }

    /*********************************************************************************************************
     * Danh sách thanh toán
     *********************************************************************************************************/
    public function index()
    {   if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Thanh toán hợp đồng';
        CGlobal::$pageAdminTitle = $this->pageTitle . ' - Cấp đơn ' . CGlobal::$arrTitleProject[$this->tab_top];
        $page_no = (int)Request::get('page_no', 1);

        $search['p_from_date'] = trim(addslashes(Request::get('p_from_date', '')));
        $search['p_to_date'] = trim(addslashes(Request::get('p_to_date', '')));

        $search['p_org_code'] = addslashes(Request::get('p_org_code', ''));
        $search['p_order_code'] = addslashes(Request::get('p_order_code', ''));
        $search['p_status'] = trim(addslashes(Request::get('p_status', '')));
        $search['p_from_date'] = ($search['p_from_date'] != '') ? $search['p_from_date'] : date('d/m/Y', strtotime(Carbon::now()->startOfMonth()));
        $search['p_to_date'] = ($search['p_to_date'] != '') ? $search['p_to_date'] : date('d/m/Y', strtotime(Carbon::now()));
        $search['p_search'] = trim(addslashes(Request::get('p_search', '')));
        $search['p_period_no'] = trim(addslashes(Request::get('p_period_no', '')));
        $search['p_order_trans_code'] = trim(addslashes(Request::get('p_order_trans_code', '')));
        $search['p_cusname'] = trim(addslashes(Request::get('p_cusname', '')));
        $search['p_phone'] = trim(addslashes(Request::get('p_phone', '')));
        $search['p_idcard'] = trim(addslashes(Request::get('p_idcard', '')));
        $search['p_amount_from'] = returnFormatMoney(trim(addslashes(Request::get('p_amount_from', ''))));
        $search['p_amount_to'] = returnFormatMoney(trim(addslashes(Request::get('p_amount_to', ''))));
        $search['page_no'] = $page_no;

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchPaymentContract($search);

        //myDebug($result);
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data']['data'] ?? $dataList;
            $total = $result['Data']['total'] ?? $total;
        }
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

    /**************************************************
     * Chi tiết hợp đồng thanh toán
     * ************************************************/
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
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'], true) : false;
        $arrKey = isset($dataInput['arrKey']) ? $dataInput['arrKey'] : [];
        $detailOrder = $listDonePayment = [];
        if (!empty($arrKey)) {
            $dataGet = $this->modelObj->getDettailPaymentContract($arrKey);
            if (isset($dataGet['Success']) && $dataGet['Success'] == STATUS_INT_MOT) {
                //Chi tiết hợp đồng vay
                $detailOrder = isset($dataGet['Data'][0][0]) ? $dataGet['Data'][0][0] : [];
                $listDonePayment = isset($dataGet['Data'][1]) ? $dataGet['Data'][1] : [];
            }
        }
        $this->_outDataView($request, (array)$detailOrder);
        $templateDetail = isset($request['templateDetailItem']) ? $request['templateDetailItem'] : 'popupDetail';
        $html = View::make($this->templateRoot . 'component.' . $templateDetail)
            ->with(array_merge([
                'data' => $detailOrder,
                'detailOrder' => $detailOrder,
                'listDonePayment' => $listDonePayment,
                'arrKeyDetail' => $arrKey,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $divShowInfor = isset($request['divShowInfor']) ? $request['divShowInfor'] : 'formShowEditSuccess';//div show infor item
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor);
        return $arrAjax;
    }

    public function ajaxPostItem()
    {
        return;
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
            $result = $this->modelObj->editOrderPolicy($dataForm, ($id > 0) ? 'EDIT' : 'ADD');
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

    /***************************************************
     * Phê duyệt đơn theo list
     * @return \Illuminate\Http\JsonResponse|void
     ***************************************************/
    public function ajaxApprovalOrder()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $arrAjax = array('success' => 0, 'message' => 'Có lỗi khi thao tác');
        $dataRequest = $_POST;
        if (empty($dataRequest['dataId']) && empty($dataRequest['dataAmount'])) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }

        $str_transfer_id = '';
        if (!empty($dataRequest['dataId'])) {
            $str_transfer_id = implode(';', $dataRequest['dataId']);
        }
        if (trim($str_transfer_id) != '') {
            $dataApprovel['p_order_trans_code'] = $str_transfer_id;
            $result = $this->modelObj->updateApprovalOrder($dataApprovel);
            if ($result['Success'] == STATUS_INT_MOT) {
                $arrAjax['success'] = 1;
                $arrAjax['message'] = 'Cập nhật thành công';
                return Response::json($arrAjax);
            } else {
                return Response::json($arrAjax);
            }
        }
        return Response::json($arrAjax);
    }

    /****************************************************
     * Move pay đơn sang thanh toán
     * @return \Illuminate\Http\JsonResponse
     ****************************************************/
    public function ajaxMovePay()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $dataRequest = $_POST;
        if (empty($dataRequest['dataId']) && (int)$dataRequest['dataTotalPay'] <= 0) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }
        $arrKey = json_decode($dataRequest['arrKey'], true);
        $str_transfer_id = '';
        if (!empty($dataRequest['dataId']) && (int)$dataRequest['dataTotalPay'] > 0) {
            $str_transfer_id = implode(';', $dataRequest['dataId']);
        }

        if (trim($str_transfer_id) != '') {
            $dataMove['p_trans_id'] = $str_transfer_id;
            $dataMove['p_order_code'] = $arrKey['ORDER_CODE'];
            $dataMove['p_order_transfer_code'] = $arrKey['ORDER_TRANS_CODE'];
            $update = $this->modelObj->updateMovePayment($dataMove);

            //load lại form detail
            $arrAjax = $this->_getInfoItem(['dataInput' => json_encode(['arrKey' => $arrKey]), 'divShowInfor' => 'content-page-right', 'objectId' => isset($update['Success']) ? $update['Success'] : 0]);
            return Response::json($arrAjax);
        }
        return Response::json(returnError());
    }

    /**************************************************
     * Get data tab
     * ************************************************/
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

    private function _ajaxGetDataOfTab($request)
    {
        $data = $inforItem = $listNotPayment = [];
        $formNameOther = isset($request['formName']) ? $request['formName'] : 'formName';
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'], true) : false;
        $typeTab = isset($dataInput['type']) ? $dataInput['type'] : '';
        $arrKey = isset($dataInput['arrKey']) ? $dataInput['arrKey'] : [];
        $data = isset($dataInput['dataItem']) ? $dataInput['dataItem'] : [];

        $actionEdit = STATUS_INT_KHONG;
        $objectId = $request['objectId'];
        $templateOut = $this->templateRoot . 'component._detailFormItem3';

        switch ($typeTab) {
            //Đã thanh toán
            case $this->tabOtherItem1:
                $templateOut = $this->templateRoot . 'component._detailFormItem3';
                break;
            //chưa thanh toán
            case $this->tabOtherItem2:
                $get = array
                (
                    'p_trans_id' => DEFINE_ALL,
                    'p_content' => DEFINE_ALL,
                    'p_amount' => -1,
                    'p_from_date' => DEFINE_ALL,
                    'p_to_date' => DEFINE_ALL,
                    'p_cardnum' => DEFINE_ALL,
                    'p_cardname' => DEFINE_ALL,
                    'p_page' => STATUS_INT_MOT
                );
                $dataGet = $this->modelObj->getListNotPaymentContract($get);
                $total_list = 0;
                if (isset($dataGet['Success']) && $dataGet['Success'] == 1) {
                    $listNotPayment = $dataGet['Data'];
                    $total_list = isset($listNotPayment[0]->TOTAL) ? $listNotPayment[0]->TOTAL : 0;
                }
                $page_no = (int)Request::get('page_no', STATUS_INT_MOT);
                $limit = CGlobal::number_show_10;
                $paging = $total_list > 0 ? Pagging::getNewPager(3, $page_no, $total_list, $limit, []) : '';
                $this->dataOutItem = [
                    'total_list' => $total_list,
                    'paging' => $paging,
                    'stt' => ($page_no - 1) * $limit,
                ];
                $templateOut = $this->templateRoot . 'component._detailFormItem2';
                break;
            default:
                break;
        }
        $this->_outDataView($request, (array)$data);
        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $data,
                'listNotPayment' => $listNotPayment,
                'actionEdit' => $actionEdit,//0: thêm mới, 1: edit
                'objectId' => $objectId,
                'formNameOther' => $formNameOther,
                'typeTab' => $typeTab,
                'divShowId' => $typeTab,
                'arrKeyTab' => $arrKey,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        return $html;
    }

    /**
     * Tìm kiếm ajax
     * @return string
     */
    public function ajaxSearchAdvanced()
    {
        $data = $inforItem = $listNotPayment = [];
        $total_list = 0;
        $request = $_GET;
        $dataForm = $request['dataForm'];
        $arrKey = isset($dataForm['arrKey']) ? json_decode($dataForm['arrKey'], true) : false;
        $div_show = (isset($dataForm['div_show']) && trim($dataForm['div_show']) != '') ? $dataForm['div_show'] : '';
        $page_no = (isset($dataForm['page_no']) && trim($dataForm['page_no']) != '') ? $dataForm['page_no'] : STATUS_INT_MOT;
        //lấy data chính
        $getParam = [
            'p_trans_id' => (isset($dataForm['p_trans_id']) && trim($dataForm['p_trans_id']) != '') ? $dataForm['p_trans_id'] : DEFINE_ALL,
            'p_content' => (isset($dataForm['p_content']) && trim($dataForm['p_content']) != '') ? $dataForm['p_content'] : DEFINE_ALL,
            'p_amount' => (isset($dataForm['p_amount']) && trim($dataForm['p_amount']) != '') ? returnFormatMoney($dataForm['p_amount']) : STATUS_INT_AM_MOT,
            'p_from_date' => (isset($dataForm['p_from_date']) && trim($dataForm['p_from_date']) != '') ? $dataForm['p_from_date'] : DEFINE_ALL,
            'p_to_date' => (isset($dataForm['p_to_date']) && trim($dataForm['p_to_date']) != '') ? $dataForm['p_to_date'] : DEFINE_ALL,
            'p_cardnum' => (isset($dataForm['p_cardnum']) && trim($dataForm['p_cardnum']) != '') ? $dataForm['p_cardnum'] : DEFINE_ALL,
            'p_cardname' => (isset($dataForm['p_cardname']) && trim($dataForm['p_cardname']) != '') ? $dataForm['p_cardname'] : DEFINE_ALL,
            'p_page' => $page_no
        ];
        $dataGet = $this->modelObj->getListNotPaymentContract($getParam);
        if (isset($dataGet['Success']) && $dataGet['Success'] == 1) {
            $listNotPayment = $dataGet['Data'];
            $total_list = isset($listNotPayment[0]->TOTAL) ? $listNotPayment[0]->TOTAL : 0;
        }
        $limit = CGlobal::number_show_10;
        $paging = $total_list > 0 ? Pagging::getNewPager(3, $page_no, $total_list, $limit, $dataForm) : '';
        $templateOut = $this->templateRoot . 'component._tableListNotPayment';
        $this->_outDataView($request, (array)$data);
        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $data,
                'listNotPayment' => $listNotPayment,
                'divShowId' => $div_show,
                'arrKeyTab' => $arrKey,
                'total_list' => $total_list,
                'paging' => $paging,
                'stt' => ($page_no - 1) * $limit,
            ], $this->dataOutCommon, $this->dataOutItem))->render();

        $arrAjax = array('success' => 1, 'html' => $html, 'divShowId' => $div_show, 'message' => '');
        return Response::json($arrAjax);
    }
}
