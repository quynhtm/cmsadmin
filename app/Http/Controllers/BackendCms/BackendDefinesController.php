<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\BackendCms;

use App\Http\Controllers\BaseAdminController;
use App\Models\BackendCms\DefineSystem;
use App\Models\OpenId\TypeDefine;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class BackendDefinesController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrProject = array();
    private $arrDefineCode = array();

    private $templateRoot = DIR_PRO_BACKEND. '.Defines.';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new DefineSystem();
        $this->arrDefineCode = [];
    }

    private function _outDataView($request, $data)
    {
        $this->arrStatus = CGlobal::$arrStatus;

        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['IS_ACTIVE']) ? $data['IS_ACTIVE'] : STATUS_INT_MOT);
        $optionProjectCode = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProject, isset($data['PROJECT_CODE']) ? $data['PROJECT_CODE'] : '');
        $optionSearchDefineCode = FunctionLib::getOption([DEFINE_ALL => '---Chọn---'] +$this->arrDefineCode, isset($data['s_define_code']) ? $data['s_define_code'] : DEFINE_ALL);

        $formId = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        return $this->dataOutCommon = [
            'optionSearchDefineCode' => $optionSearchDefineCode,
            'optionStatus' => $optionStatus,
            'arrStatus' => $this->arrStatus,
            'optionProjectCode' => $optionProjectCode,
            'arrProject' => $this->arrProject,

            'form_id' => $formId,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,

            'urlIndex' => URL::route('defines.index'),
            'urlGetItem' => URL::route('defines.ajaxGetItem'),
            'urlDeleteItem' => URL::route('defines.ajaxDeleteItem'),
            'url_action' => URL::route('defines.ajaxPostItem'),
        ];
    }

    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Defines system';
        $limit = CGlobal::number_show_20;
        $page_no = (int)Request::get('page_no', 1);
        $search['page_no'] = $page_no;
        $search['limit'] = $limit;
        $search['define_code'] = trim(addslashes(Request::get('define_code', '')));
        $search['define_name'] = trim(addslashes(Request::get('define_name', '')));

        $result = $this->modelObj->searchByCondition($search);
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
        ], $this->dataOutCommon));
    }

    public function ajaxGetItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_GET;
        $oject_id = $request['objectId'] ?? 0;
        $data = $arrSelectMenuCheck = [];
        $is_copy = STATUS_INT_KHONG;
        if ($oject_id > 0) {
            $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
            $data = isset($dataInput->item) ? $dataInput->item : false;
            $is_copy = isset($dataInput->is_copy) ? $dataInput->is_copy : STATUS_INT_KHONG;
            $arrSelectMenuCheck = (isset($data->MENU_CODE) && trim($data->MENU_CODE) != '') ? explode(',', $data->MENU_CODE) : [];
        }

        $this->_outDataView($request, (array)$data);
        $html = View::make($this->templateRoot . 'component.popupDetail')
            ->with(array_merge([
                'data' => $data,
                'is_copy' => $is_copy,
                'arrSelectMenuCheck' => $arrSelectMenuCheck,

            ], $this->dataOutCommon))->render();
        $arrAjax = array('success' => 1, 'html' => $html);
        return Response::json($arrAjax);
    }

    public function ajaxPostItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $dataRequest = $_POST;
        $dataForm = $dataRequest['dataForm'] ?? [];
        $id = (int)$dataForm['objectId'] ?? 0;
        if (empty($dataForm)) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }

        if ($this->_validFormData($dataForm) && empty($this->error)) {
            $dataForm['ID'] = ($id > 0) ? $id : '';// ID tự tăng
            $result = $this->modelObj->editItem($dataForm, ($id > 0) ? 'EDIT' : 'ADD');
            if ($result['Success'] == STATUS_INT_MOT) {
                return Response::json(['loadPage'=>STATUS_INT_MOT,'success'=>1]);
            } else {
                return Response::json(returnError($result['Message']));
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
        if (!$this->checkMultiPermiss([PERMISS_REMOVE])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_POST;
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
        $dataItem = isset($dataInput->item) ? (array)$dataInput->item : false;

        if (!empty($dataItem)) {
            $result = $this->modelObj->deleteItem($dataItem);
            if ($result['Success'] == STATUS_INT_MOT) {
                return Response::json(returnSuccess());
            } else {
                return Response::json(returnError($result['Message']));
            }
        } else {
            return Response::json(returnError('Dữ liệu không đúng'));
        }
    }
}
