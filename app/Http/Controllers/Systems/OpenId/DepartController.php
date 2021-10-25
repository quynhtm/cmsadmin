<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Systems\OpenId;

use App\Http\Controllers\BaseAdminController;
use App\Models\OpenId\Banks;
use App\Models\OpenId\DepartmentOrg;
use App\Models\OpenId\Organization;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class DepartController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;
    private $organization = false;

    private $arrStatus = array();
    private $arrOrgStruct = array();
    private $arrDepart = array();
    private $arrOrg = array();

    private $templateRoot = DIR_PRO_SYSTEM.'/'.DIR_MODULE_OPENID . '.depart.';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new DepartmentOrg();
        $this->organization = new Organization();

        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_STATUS);
        $this->arrOrg = $this->organization->getArrOptionOrg();
    }

    private function _outDataView($request, $data)
    {
        if (isset($data['ORG_CODE'])) {
            $this->arrDepart = $this->modelObj->getArrOptionDepartByOrgCode($data['ORG_CODE']);
            //get tổ chức
            $dataOrg = $this->organization->getOrganizationByKey($data['ORG_CODE']);
            if ($dataOrg) {
                $this->arrOrgStruct = $this->getArrOptionTypeDefine($dataOrg->ORG_TYPE, DEFINE_PORTAL);
            }
        }
        $optionDepart = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrDepart, isset($data['PARENT_STRUCT']) ? $data['PARENT_STRUCT'] : '');
        $optionOrg = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrOrg, isset($data['ORG_CODE']) ? $data['ORG_CODE'] : '');
        $optionOrgStruct = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrOrgStruct, (isset($data['ORG_STRUCT']) ? $data['ORG_STRUCT'] : ''));
        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['IS_ACTIVE']) ? $data['IS_ACTIVE'] : STATUS_INT_MOT);

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = isset($request['objectId']) ? $request['objectId'] : '';
        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'optionOrg' => $optionOrg,
            'optionDepart' => $optionDepart,
            'optionOrgStruct' => $optionOrgStruct,

            'arrStatus' => $this->arrStatus,
            'arrOrgStruct' => $this->arrOrgStruct,
            'arrOrg' => $this->arrOrg,
            'arrDepart' => $this->arrDepart,

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => !empty($objectId) ? STATUS_INT_MOT : STATUS_INT_KHONG,
            'urlAjaxGetData' => URL::route('depart.ajaxGetData'),
            'urlMoveDepartStaff' => URL::route('depart.ajaxPostMoveDepartOfStaff'),
        ];
    }

    private function _validFormData($active = STATUS_INT_MOT, &$data = array())
    {
        if (!empty($data)) {
            if (isset($data['ADDRESS_SHORT']) && trim($data['ADDRESS_SHORT']) == '') {
                $this->error[] = 'Địa chỉ không được bỏ trống';
            }
            if (isset($data['EMAIL']) && trim($data['EMAIL']) == '') {
                $this->error[] = 'EMAIL không được bỏ trống';
            }
            if (isset($data['PHONE']) && trim($data['PHONE']) == '') {
                $this->error[] = 'PHONE không được bỏ trống';
            }
            if (isset($data['TAX_CODE']) && trim($data['TAX_CODE']) == '') {
                $this->error[] = 'Mã số thuế không được bỏ trống';
            }
            if (isset($data['ORG_MODE']) && trim($data['ORG_MODE']) == '') {
                $this->error[] = 'Loại tổ chức không được bỏ trống';
            }
            if (isset($data['PARENT_CODE']) && trim($data['PARENT_CODE']) == '') {
                $this->error[] = 'Tổ chức cha không được bỏ trống';
            }
            if (isset($data['CEO_NAME']) && trim($data['CEO_NAME']) == '') {
                $this->error[] = 'Người đại diện không được bỏ trống';
            }
            if (isset($data['ORG_TYPE']) && trim($data['ORG_TYPE']) == '') {
                $this->error[] = 'Kiểu tổ chức không được bỏ trống';
            }
            if (isset($data['ORG_NAME']) && trim($data['ORG_NAME']) == '') {
                $this->error[] = 'Tên tổ chức không được bỏ trống';
            }
            if (isset($data['ORG_CODE']) && trim($data['ORG_CODE']) == '') {
                $this->error[] = 'Mã tổ chức không được bỏ trống';
            }

            $itemExits = $this->modelObj->getItemByKey($data['STRUCT_CODE'], $data['ORG_STRUCT'], $data['ORG_CODE']);
            if ($itemExits) {
                if ($itemExits->IS_ACTIVE == STATUS_INT_MOT && $active == STATUS_INT_KHONG) {
                    $this->error[] = 'Đã tồn tại phòng ban này';
                } elseif ($itemExits->IS_ACTIVE == STATUS_INT_KHONG && $active == STATUS_INT_KHONG) {
                    $data['IS_ACTIVE'] = STATUS_INT_MOT;
                    $data['objectId'] = STATUS_INT_MOT;
                }
            }
        }
        return true;
    }

    /*********************************************************************************************************
     * Department
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $orgCodeDefault = 'HDI';
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Quản lý phòng ban';
        $page_no = (int)Request::get('page_no', 1);

        $search['ORG_CODE'] = addslashes(Request::get('ORG_CODE', $orgCodeDefault));
        $search['IS_ACTIVE'] = addslashes(Request::get('IS_ACTIVE', STATUS_INT_MOT));
        $search['p_keyword'] = addslashes(Request::get('p_keyword', ''));
        $search['p_org_code'] = $search['ORG_CODE'];
        $search['p_is_active'] = $search['IS_ACTIVE'];
        $search['page_no'] = $page_no;

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchItem($search);
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data']['data'] ?? $dataList;
            $total = count($dataList);
        }
        //$paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';
        $paging = '';
        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'viewDepart', array_merge([
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'orgCodeDefault' => $orgCodeDefault,

            'pageTitle' => $this->pageTitle,
            'urlIndex' => URL::route('depart.index'),
            'urlGetItem' => URL::route('depart.ajaxGetDepart'),
            'urlDeleteItem' => URL::route('depart.ajaxDeleteDepart'),
        ], $this->dataOutCommon));
    }

    public function ajaxGetDepart()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_GET;
        $objectId = isset($request['objectId']) ? $request['objectId'] : '';
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
        $data = [];

        $listStaff = $searchStaff = [];
        $page_no = (int)Request::get('page_no', 1);
        $limit = CGlobal::number_show_10;
        $totalStaff = 0;
        $pagingStaff = '';
        if (trim($objectId) != '') {
            if (isset($dataInput->item)) {
                $item = $dataInput->item;
                $data = $this->modelObj->getItemByKey($item->STRUCT_CODE, $item->ORG_STRUCT, $item->ORG_CODE);

                //danh sách nhân viên của phòng
                if (trim($item->ORG_CODE) != '' && trim($item->STRUCT_CODE) != '') {
                    $searchStaff['ORG_CODE'] = $item->ORG_CODE;
                    $searchStaff['STRUCT_CODE'] = $item->STRUCT_CODE;
                    $searchStaff['NAME_STAFF'] = '';
                    $searchStaff['IS_ACTIVE'] = '';
                    $searchStaff['page_no'] = 1;
                    $dataStaffDepart = $this->modelObj->searchStaffByDepart($searchStaff);
                    if (isset($dataStaffDepart['Success']) && $dataStaffDepart['Success'] == STATUS_INT_MOT) {
                        $listStaff = $dataStaffDepart['Data']['data'];
                        $totalStaff = $dataStaffDepart['Data']['total'];
                        $pagingStaff = $totalStaff > 0 ? Pagging::getNewPager(3, $page_no, $totalStaff, $limit, $searchStaff) : '';
                    }
                }
            }
        }
        if (isset($dataInput->orgCodeDefault)) {
            $data['ORG_CODE'] = $dataInput->orgCodeDefault;
        }

        $this->_outDataView($request, (array)$data);
        $html = View::make($this->templateRoot . 'component.popupDetail')
            ->with(array_merge([
                'data' => $data,
                'url_action' => URL::route('depart.ajaxPostDepart'),

                //list thông tin nhân viên của phòng
                'listStaff' => $listStaff,
                'searchStaff' => $searchStaff,
                'totalStaff' => $totalStaff,
                'sttStaff' => ($page_no - 1) * $limit,
                'pagingStaff' => $pagingStaff,
            ], $this->dataOutCommon))->render();
        $arrAjax = array('success' => 1, 'html' => $html);
        return Response::json($arrAjax);
    }

    public function ajaxPostDepart()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $dataRequest = $_POST;

        $dataForm = $dataRequest['dataForm'] ?? [];
        $id = isset($dataForm['objectId']) ? $dataForm['objectId'] :0;
        if (empty($dataForm)) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }

        if ($this->_validFormData($id, $dataForm) && empty($this->error)) {
            $dataForm['MENU_CODE'] = 1;

            $id = isset($dataForm['objectId']) ? $dataForm['objectId'] : '';
            $result = $this->modelObj->editItem($dataForm, ($id > 0) ? 'EDIT' : 'ADD');
            if ($result['Success'] == STATUS_INT_MOT) {
                //lấy lại dữ liệu đã cập nhật để hiển thị lại
                $request = $dataForm;
                $request['formName'] = $dataForm['formName'];
                $this->_outDataView($request, $dataForm);
                $html = View::make($this->templateRoot . 'component._detailFormItem')
                    ->with(array_merge([
                        'data' => (object)$dataForm,
                        'url_action' => URL::route('depart.ajaxPostDepart'),
                    ], $this->dataOutCommon))->render();
                $divShowInfor = isset($request['divShowInfor']) ? $request['divShowInfor'] : 'formShowEditSuccess';//div show infor item
                $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor);
                return Response::json($arrAjax);
                //return Response::json(returnSuccess());
            } else {
                return Response::json(returnError($result['Message']));
            }
        } else {
            return Response::json(returnError($this->error));
        }
    }

    public function ajaxDeleteDepart()
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

    /*********************************************************************************************************
     * List danh sách nhân sự của phòng ban đó
     *********************************************************************************************************/

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

    private function _ajaxGetPopupMove($request)
    {
        $strUserCode = '';
        $dataInput = $data = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
        if ($dataInput) {
            if (isset($request['dataUserCode']) && !empty($request['dataUserCode'])) {
                $strUserCode = implode(',', $request['dataUserCode']);
            }
            $data = isset($dataInput->item) ? $dataInput->item : false;
        }
        $templateOut = $this->templateRoot . 'component._popupMoveStaffDepart';
        $depart =(array)$data;
        $depart['PARENT_STRUCT'] = '';
        $this->_outDataView($request,$depart );
        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $data,
                'titlePopup' => isset($request['titlePopup']) ? $request['titlePopup'] : 'Chuyển depart',
                'strUserCode' => $strUserCode,
                'divLoadHtml' => isset($request['divShow']) ? $request['divShow'] : 'sys_show_infor_small',
                'urlMoveDepart' => URL::route('depart.ajaxPostMoveDepartOfStaff'),
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        return $html;
    }

    public function ajaxPostMoveDepartOfStaff()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        if (!$this->checkMultiPermiss()) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_POST;
        $dataInput = isset($request['dataForm']) ? $request['dataForm'] : [];
        if(empty($dataInput)){
            $this->error[] = 'Dữ liệu không đúng';
        }
        if($dataInput['STRUCT_CODE_NEW'] == $dataInput['STRUCT_CODE_OLD']){
            $this->error[] = 'Depart mới và cũ đang trùng nhau! Hãy chọn lại';
        }

        if(empty($this->error)){
            if (!empty($dataInput) && trim($dataInput['strUserCode']) != '' && trim($dataInput['STRUCT_CODE_NEW']) != '') {
                $result = $this->modelObj->moveDepartOfStaff(trim($dataInput['strUserCode']),trim($dataInput['STRUCT_CODE_NEW']));
                if ($result['Success'] == STATUS_INT_MOT) {
                    return Response::json(returnSuccess());
                } else {
                    return Response::json(returnError($result['Message']));
                }
            }
        }
         else {
            return Response::json(returnError($this->error));
        }
    }
}
