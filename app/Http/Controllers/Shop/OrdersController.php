<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\BaseAdminController;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Pagging;
use App\Models\Shop\Orders;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class OrdersController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrIsActive = array();
    private $arrCodOrder = array();
    private $arrStatusOrder = array();
    private $arrTypeOrder = array();

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    private $routerIndex = 'orders.index';
    private $templateRoot = DIR_PRO_SHOP . '/' . 'Orders.';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new Orders();
        $this->arrCodOrder = $this->getArrOptionTypeDefine(DEFINE_ORDER_COD);
        $this->arrStatusOrder = $this->getArrOptionTypeDefine(DEFINE_ORDER_STATUS);
        $this->arrTypeOrder = $this->getArrOptionTypeDefine(DEFINE_ORDER_TYPE);
    }

    private function _outDataView($request, $data)
    {
        $optionPartner = FunctionLib::getOption([STATUS_INT_KHONG => '---Tất cả---'] + $this->arrPartner, isset($data['partner_id']) ? $data['partner_id'] : STATUS_INT_MOT);

        $optionStatusOrder = FunctionLib::getOption([STATUS_INT_AM_MOT => '---Chọn---'] + $this->arrStatusOrder, isset($data['order_status']) ? $data['order_status'] : STATUS_INT_AM_MOT);
        $optionCodOrder = FunctionLib::getOption([STATUS_INT_AM_MOT => '---Chọn---'] + $this->arrCodOrder, isset($data['order_is_cod']) ? $data['order_is_cod'] : STATUS_INT_AM_MOT);
        $optionTypeOrder = FunctionLib::getOption([STATUS_INT_AM_MOT => '---Chọn---'] + $this->arrTypeOrder, isset($data['order_type']) ? $data['order_type'] : STATUS_INT_AM_MOT);

        $formId = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Quản lý đơn hàng';

        $this->shareListPermission($this->routerIndex);//lay quyen theo ajax
        return $this->dataOutCommon = [
            'optionPartner' => $optionPartner,

            'optionStatusOrder' => $optionStatusOrder,
            'arrStatusOrder' => $this->arrStatusOrder,
            'optionCodOrder' => $optionCodOrder,
            'arrCodOrder' => $this->arrCodOrder,
            'optionTypeOrder' => $optionTypeOrder,
            'arrTypeOrder' => $this->arrTypeOrder,

            'form_id' => $formId,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'pageTitle' => $this->pageTitle,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route($this->routerIndex),
            'urlGetData' => URL::route('orders.ajaxGetData'),
            'urlPostData' => URL::route('orders.ajaxPostData'),
        ];
    }

    /*********************************************************************************************************
     * Quản lý đối tác web
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $limit = CGlobal::number_show_15;
        $page_no = (int)Request::get('page_no', 1);
        $offset = ($page_no - 1) * $limit;
        $search['page_no'] = $page_no;
        $search['limit'] = $limit;
        $search['order_status'] = trim(addslashes(Request::get('order_status', STATUS_INT_AM_MOT)));
        $search['order_is_cod'] = trim(addslashes(Request::get('order_is_cod', STATUS_INT_AM_MOT)));
        $search['order_type'] = trim(addslashes(Request::get('order_type', STATUS_INT_AM_MOT)));
        $search['order_product_id'] = trim(addslashes(Request::get('order_product_id', '')));
        $search['order_id'] = trim(addslashes(Request::get('order_id', '')));
        $search['partner_id'] = ($this->partner_id > 0)? $this->partner_id: trim(addslashes(Request::get('partner_id', STATUS_INT_AM_MOT)));
        $search['p_keyword'] = trim(addslashes(Request::get('p_keyword', '')));

        $result = $this->modelObj->searchByCondition($search, $limit,$offset);
        $dataList = $result['data'] ?? [];
        $total = $result['total'] ?? STATUS_INT_KHONG;
        if($total > 0){
            foreach ($dataList as $k => &$val){
                $val->list_pro = $this->modelObj->getItemById($val->id);
            }
        }

        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';
        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'viewIndex', array_merge([
            'data' => $dataList,
            'total' => $total,
            'search' => $search,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
        ], $this->dataOutCommon));
    }

    private function _functionGetData($request)
    {
        $formName = isset($request['formName']) ? $request['formName'] : 'formName';
        $titlePopup = isset($request['titlePopup']) ? $request['titlePopup'] : 'Thông tin chung';
        $objectId = isset($request['objectId']) ? (int)$request['objectId'] : STATUS_INT_KHONG;

        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'], true) : false;
        $funcAction = isset($dataInput['funcAction']) ? $dataInput['funcAction'] : (isset($request['funcAction']) ? $request['funcAction'] : '');
        $paramSearch = isset($dataInput['paramSearch']) ? $dataInput['paramSearch'] : [];

        $htmlView = '';
        switch ($funcAction) {
            case 'getDetailItem':
                $dataDetail = false;
                $dataListProOrder = false;
                if ($objectId > STATUS_INT_KHONG) {
                    $dataDetail = $this->modelObj->getItemById($objectId);
                    $dataListProOrder = isset($dataDetail->orders_item)? $dataDetail->orders_item: false;
                    $dataDetail = ($dataDetail) ? $dataDetail->toArray() : false;
                }
                $this->_outDataView($request, $dataDetail);
                $arrStatusOrderNotEdit = [STATUS_INT_BA, STATUS_INT_BON];//hoàn thành, hủy
                $htmlView = View::make($this->templateRoot . 'component.popupDetail')
                    ->with(array_merge($this->dataOutCommon, [
                        'dataDetail' => $dataDetail,
                        'dataListProOrder' => $dataListProOrder,
                        'arrStatusOrderNotEdit' => $arrStatusOrderNotEdit,

                        'paramSearch' => $paramSearch,
                        'objectId' => $objectId,
                        'formName' => $formName,
                        'titlePopup' => $titlePopup,
                    ]))->render();
                break;
            default:
                break;
        }
        return $htmlView;
    }

    public function ajaxPostData()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_ADD, PERMISS_EDIT], $this->routerIndex)) {
            return Response::json(returnError(MSG_PERMISSION_ERROR));
        }
        $request = $_POST;
        $arrAjax = array('success' => 0, 'html' => '', 'msg' => '');
        $actionUpdate = 'actionUpdate';
        $dataForm = isset($request['dataForm']) ? $request['dataForm'] : [];
        $actionUpdate = isset($dataForm['actionUpdate']) ? $dataForm['actionUpdate'] : (isset($request['actionUpdate']) ? $request['actionUpdate'] : $actionUpdate);

        switch ($actionUpdate) {
            case 'updateData':
                $objectId = isset($dataForm['objectId']) ? $dataForm['objectId'] : STATUS_INT_KHONG;
                $isEdit = 0;
                if ($this->_validFormData($objectId, $dataForm) && empty($this->error)) {
                    $isEdit = $this->modelObj->editItem($dataForm, $objectId);
                }
                if ($isEdit > 0) {
                    $dataDetail = $this->modelObj->getItemById($isEdit);
                    $this->_outDataView($request, (array)$dataDetail);

                    $arrAjax['success'] = 1;
                    $arrAjax['html'] = '';
                    $arrAjax['loadPage'] = ($objectId > 0) ? 0 : 1;
                    $arrAjax['divShowInfor'] = '';
                }else{
                    $arrAjax = returnError($this->error);
                }
                break;
            default:
                break;
        }
        return Response::json($arrAjax);
    }

    public function ajaxGetData()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_VIEW, PERMISS_ADD, PERMISS_EDIT], $this->routerIndex)) {
            return Response::json(returnError(MSG_PERMISSION_ERROR));
        }
        $dataRequest = $_POST;
        $functionAction = $dataRequest['functionAction'] ?? '';
        $html = '';
        $success = STATUS_INT_KHONG;
        if (trim($functionAction) != '') {
            $html = $this->$functionAction($dataRequest);
            if (is_array($html)) {
                return Response::json($html);
            } else {
                $success = STATUS_INT_MOT;
            }
        }
        $arrAjax = array('success' => $success, 'html' => $html);
        return Response::json($arrAjax);
    }

    private function _validFormData($id = 0, &$data = array())
    {
        if (!empty($data)) {
            if (isset($data['USER_TYPE']) && trim($data['USER_TYPE']) == '') {
                $this->error[] = 'Kiểu người dùng không được bỏ trống';
            }

            if (isset($data['PHONE']) && trim($data['PHONE']) != '') {
                if (!validatePhoneNumber(trim($data['PHONE']))) {
                    $this->error[] = 'PHONE không đúng định dạng';
                }
            }
        }
        return true;
    }
}
