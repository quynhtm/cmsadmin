<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\BackendCms;

use App\Http\Controllers\BaseAdminController;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Pagging;
use App\Models\BackendCms\MenuSystem;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class BackendMenuController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrIsActive = array();
    private $arrIsLink = array();
    private $arrTypeMenu = array();

    private $templateRoot = DIR_PRO_BACKEND . '.Menu.';
    private $routerIndex = 'menu.index';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new MenuSystem();
        $this->arrIsLink = $this->getArrOptionTypeDefine(DEFINE_TRUE_FALSE);
        $this->arrTypeMenu = $this->getArrOptionTypeDefine(DEFINE_TYPE_MENU);
        $this->arrIsActive = $this->getArrOptionTypeDefine(DEFINE_TRANG_THAI);
    }

    private function _outDataView($request, $data)
    {
        $optionActive = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrIsActive, isset($data['is_active']) ? $data['is_active'] : STATUS_INT_MOT);
        $optionIsLink = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrIsLink, isset($data['define_code']) ? $data['define_code'] : STATUS_INT_MOT);

        $projectCode = isset($data['project_code']) ? $data['project_code']: STATUS_INT_HAI;
        $optionTypeMenu = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrTypeMenu, $projectCode);
        $this->arrOptionMenuParent = $this->modelObj->getOptionMenuParent($projectCode);
        $optionParentMenu = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrOptionMenuParent, isset($data['menu_parent']) ? $data['menu_parent'] : DEFINE_NULL);

        $formId = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        return $this->dataOutCommon = [
            'optionIsLink' => $optionIsLink,
            'optionActive' => $optionActive,
            'optionParentMenu' => $optionParentMenu,
            'optionTypeMenu' => $optionTypeMenu,

            'form_id' => $formId,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,

            'urlIndex' => URL::route($this->routerIndex),
            'urlGetItem' => URL::route('menu.ajaxGetItem'),
            'urlPostItem' => URL::route('menu.ajaxPostItem'),
            'urlDeleteItem' => URL::route('menu.ajaxDeleteItem'),
        ];
    }

    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Menu system';
        $limit = CGlobal::number_show_500;
        $page_no = (int)Request::get('page_no', 1);
        $search['page_no'] = $page_no;
        $search['limit'] = $limit;
        $search['project_code'] = trim(addslashes(Request::get('project_code', STATUS_INT_HAI)));
        $search['menu_name'] = trim(addslashes(Request::get('menu_name', '')));

        $result = $this->modelObj->searchByCondition($search, $limit);
        $dataList = $result['data'] ?? [];
        $total = $result['total'] ?? STATUS_INT_KHONG;

        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';
        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'viewIndex', array_merge([
            'data' => $dataList,
            'total' => $total,
            'search' => $search,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
            'arrRouter' => $this->getRouterNameSite(),
        ], $this->dataOutCommon));
    }

    public function ajaxGetItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_ADD, PERMISS_EDIT], $this->routerIndex)) {
            return Response::json(returnError(MSG_PERMISSION_ERROR));
        }
        $request = $_GET;
        $oject_id = $request['objectId'] ?? 0;
        $data = [];
        $is_copy = STATUS_INT_KHONG;
        if ($oject_id > 0) {
            $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
            $data = isset($dataInput->item) ? $dataInput->item : false;
            $is_copy = isset($dataInput->is_copy) ? $dataInput->is_copy : STATUS_INT_KHONG;
        }

        $this->_outDataView($request, (array)$data);
        $html = View::make($this->templateRoot . 'component.popupDetail')
            ->with(array_merge([
                'data' => $data,
                'is_copy' => $is_copy,
            ], $this->dataOutCommon))->render();
        $arrAjax = array('success' => 1, 'html' => $html);
        return Response::json($arrAjax);
    }

    public function ajaxPostItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_ADD, PERMISS_EDIT], $this->routerIndex)) {
            return Response::json(returnError(MSG_PERMISSION_ERROR));
        }
        $dataRequest = $_POST;
        $dataForm = $dataRequest['dataForm'] ?? [];
        $id = (int)$dataForm['objectId'] ?? 0;
        if (empty($dataForm)) {
            return Response::json(returnError(MSG_DATA_ERROR));
        }

        if ($this->_validFormData($dataForm) && empty($this->error)) {
            $idNew = $this->modelObj->editItem($dataForm, $id);
            if ((int)$idNew > STATUS_INT_KHONG) {
                return Response::json(['loadPage' => STATUS_INT_MOT, 'success' => 1]);
            } else {
                return Response::json(returnError(MSG_ERROR));
            }
        } else {
            return Response::json(returnError($this->error));
        }
    }

    private function _validFormData($data = array())
    {
        if (!empty($data)) {
            if (isset($data['depart_name']) && trim($data['depart_name']) == '') {
                $this->error[] = 'Tên depart không được bỏ trống';
            }
            if (isset($data['depart_alias']) && trim($data['depart_alias']) == '') {
                $this->error[] = 'Tên viết tắt không được bỏ trống';
            }
        }
        return true;
    }

    public function ajaxDeleteItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_REMOVE], $this->routerIndex)) {
            return Response::json(returnError(MSG_PERMISSION_ERROR));
        }
        $request = $_POST;
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
        $dataItem = isset($dataInput->item) ? $dataInput->item : false;
        if (!empty($dataItem)) {
            $id = isset($dataItem->id) ? $dataItem->id : 0;
            $result = $this->modelObj->deleteItem($id);
            if ($result) {
                return Response::json(returnSuccess());
            } else {
                return Response::json(returnError(MSG_ERROR));
            }
        } else {
            return Response::json(returnError(MSG_DATA_ERROR));
        }
    }
}
