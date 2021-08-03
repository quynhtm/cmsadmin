<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Systems\OpenId;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\OpenId\DepartmentOrg;
use App\Http\Models\OpenId\GroupMenu;
use App\Http\Models\OpenId\MenuSystem;
use App\Http\Models\OpenId\Organization;
use App\Http\Models\OpenId\UserSystem;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class MenuGroupController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrProject = array();
    private $arrDepart = array();
    private $arrMenuSystem = array();
    private $arrChooseMenu = array();
    private $arrActionExecute = array();
    private $arrCrudLimit = array();
    private $arrOrg = array();

    private $templateRoot = DIR_PRO_SYSTEM.'/'.DIR_MODULE_OPENID . '.menuGroup.';

    private $divShowInfor = '';
    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new GroupMenu();

        $this->arrCrudLimit = $this->getArrOptionTypeDefine(DEFINE_CRUD_LIMIT);
        $this->arrActionExecute = $this->getArrOptionTypeDefine(DEFINE_ACTION_EXECUTE);
        $this->arrProject = $this->getArrOptionTypeDefine(DEFINE_MENU_SYSTEM);
        $this->arrMenuSystem = app(MenuSystem::class)->getListMenuWithPermission($this->project_code_menu);

        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_STATUS);
        $this->arrOrg = app(Organization::class)->getArrOptionOrg();
    }

    private function _outDataView($request, $data)
    {
        if (isset($data['ORG_CODE']) && trim($data['ORG_CODE']) != '') {
            $this->arrDepart = app(DepartmentOrg::class)->getArrOptionDepartByOrgCode($data['ORG_CODE']);
        }

        $optionOrg = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrOrg, isset($data['ORG_CODE']) ? $data['ORG_CODE'] : '');
        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['IS_ACTIVE']) ? $data['IS_ACTIVE'] : STATUS_INT_MOT);
        $optionSearchProjectCode = FunctionLib::getOption($this->arrProject, $this->project_code_menu);

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        $this->divShowInfor = isset($request['divShowInfor']) ? $request['divShowInfor'] : 'formShowEditSuccess';//div show infor item
        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'optionOrg' => $optionOrg,
            'optionSearchProjectCode' => $optionSearchProjectCode,

            'arrStatus' => $this->arrStatus,
            'arrOrg' => $this->arrOrg,

            'arrCrudLimit' => $this->arrCrudLimit,
            'arrActionExecute' => $this->arrActionExecute,
            'arrMenuSystem' => $this->arrMenuSystem,
            'arrChooseMenu' => $this->arrChooseMenu,//menu da đc chon

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'divShowInfor' => $this->divShowInfor,

            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route('menuGroup.index'),
            'urlGetItem' => URL::route('menuGroup.ajaxGetGroupMenu'),
            'urlDeleteItem' => URL::route('menuGroup.ajaxDeleteGroupMenu'),
            'urlAjaxGetData' => URL::route('menuGroup.ajaxGetData'),
            'url_action' => URL::route('menuGroup.ajaxPostGroupMenu'),
            'url_action_other_item' => URL::route('menuGroup.ajaxUpdateRelation'),
            'functionAction' => '_ajaxGetItem',
        ];
    }

    private function _validFormData($active = STATUS_INT_KHONG, &$data = array())
    {
        if (!empty($data)) {
            if (isset($data['ADDRESS_SHORT']) && trim($data['ADDRESS_SHORT']) == '') {
                $this->error[] = 'Địa chỉ không được bỏ trống';
            }
        }
        return true;
    }

    /*********************************************************************************************************
     * Danh mục tổ chức: GROUP MENU
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Quản lý nhóm chức năng';
        $page_no = (int)Request::get('page_no', 1);

        $search['ORG_CODE'] = addslashes(Request::get('ORG_CODE', ''));
        $search['IS_ACTIVE'] = addslashes(Request::get('IS_ACTIVE', STATUS_INT_MOT));
        $search['p_keyword'] = addslashes(Request::get('p_keyword', ''));
        $search['p_is_active'] = $search['IS_ACTIVE'];
        $search['p_org_code'] = $search['ORG_CODE'];
        $search['page_no'] = $page_no;

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchData($search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data']['data'] ?? $dataList;
            $total = $result['Data']['total'] ?? $total;
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'viewMenuGroup', array_merge([
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,

        ], $this->dataOutCommon));
    }

    public function ajaxGetGroupMenu()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_GET;
        $arrAjax = $this->_getInfoGroupMenu($request);
        return Response::json($arrAjax);
    }

    private function _getInfoGroupMenu($request)
    {
        $objectId = $request['objectId'] ?? 0;
        $data = $dataOther = [];
        if ($objectId > 0) {
            $data = $this->modelObj->getItemById($objectId);
            //lay dư liệu tab default
            if ($data) {
                ///dữ liệu data about
                $dataOther = $this->modelObj->getDetailGroupMenuByKey($data->GROUP_CODE, $data->ORG_CODE);
                $this->arrChooseMenu = $this->_pushArrMenuChoose($this->arrMenuSystem,$this->arrActionExecute,$this->arrCrudLimit,$dataOther);
                $this->dataOutItem = [
                    'dataOther' => $dataOther,
                ];
            }
        }
        $this->_outDataView($request, (array)$data);
        $html = View::make($this->templateRoot . 'component.popupDetail')
            ->with(array_merge([
                'data' => $data,
                'actionEdit' => isset($dataOther->GROUP_CODE) ? STATUS_INT_MOT : STATUS_INT_KHONG, //0: thêm mới, 1: edit
                'formNameOther' => $this->tabOtherItem1,
                'dataOther' => $dataOther,
                'typeTab' => $this->tabOtherItem1,
                'obj_id' => $objectId,
                'divShowId' => 'tab-content-1',
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $this->divShowInfor);
        return $arrAjax;
    }
    private function _pushArrMenuChoose(&$arrMenu,$arrAction,$arrCrudLimit, $arrChecked = []){
        if(!empty($arrChecked)){
            $result = [];
            foreach ($arrMenu as $menu_id => $va){
                foreach ($arrAction as $keyAction => $namea2){
                    foreach ($arrCrudLimit as $kCrudLimit => $nameCrudLimit){
                        if(isset($arrChecked[$menu_id][$keyAction]) && $arrChecked[$menu_id][$keyAction] == $kCrudLimit && $kCrudLimit != 'NONE'){
                            $result[$menu_id] = $va;
                            unset($arrMenu[$menu_id]);
                            break;
                        }
                    }
                }
            }
            return $result;
        }
        return  [];
    }
    public function ajaxPostGroupMenu()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $dataRequest = $_POST;
        $dataForm = $dataRequest['dataForm'] ?? [];
        $id = $dataForm['objectId'] ?? 0;
        if (empty($dataForm)) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }
        if ($this->_validFormData($id, $dataForm) && empty($this->error)) {
            $id = $dataForm['objectId'] ?? 0;
            $result = $this->modelObj->editItem($dataForm, ($id > 0) ? 'EDIT' : 'ADD');

            if ($result['Success'] == STATUS_INT_MOT) {
                //EDIT: lấy lại dữ liệu đã cập nhật để hiển thị lại
                if ($id > 0) {
                    $request = $dataForm;
                    $request['formName'] = $dataForm['formName'];
                    $this->_outDataView($request, $dataForm);
                    $html = View::make($this->templateRoot . 'component._detailFormItem')
                        ->with(array_merge([
                            'data' => (object)$dataForm,
                        ], $this->dataOutCommon))->render();
                    $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $this->divShowInfor);
                } //ADD: thêm mới thì load lại dư liệu để nhập các thông tin khác
                else {
                    $itemCode = isset($result['Data'][0]->GROUP_CODE) ? $result['Data'][0]->GROUP_CODE : 1;
                    $dataForm['GROUP_CODE'] = $itemCode;
                    $request['objectId'] = $itemCode;
                    $request['divShowInfor'] = 'divDetailItem';
                    $request['dataInput'] = json_encode(['item' => $dataForm]);
                    $arrAjax = $this->_getInfoGroupMenu($request);
                }
                return Response::json($arrAjax);
            } else {
                return Response::json(returnError($result['Message']));
            }
        } else {
            return Response::json(returnError($this->error));
        }
    }

    public function ajaxDeleteGroupMenu()
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
     * Các quan hệ của Group user
     *********************************************************************************************************/
    private function _ajaxGetItem($request)
    {
        $data = $inforItem = [];
        $formNameOther = isset($request['formName']) ? $request['formName'] : 'formName';
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'], true) : false;

        $typeTab = isset($dataInput['type']) ? $dataInput['type'] : '';
        $arrKey = isset($dataInput['arrKey']) ? $dataInput['arrKey'] : [];
        $actionEdit = STATUS_INT_KHONG;

        $obj_id = $request['objectId'];
        $divShowId = $request['divShowId'];
        $templateOut = $this->templateRoot . 'component._formDetailPermission';

        switch ($typeTab) {
            case $this->tabOtherItem1:
                $data = $this->modelObj->getItemById($obj_id);
                if ($data) {
                    $groupCode = isset($arrKey['GROUP_CODE']) ? $arrKey['GROUP_CODE'] : '';
                    $orgCode = isset($arrKey['ORG_CODE']) ? $arrKey['ORG_CODE'] : '';
                    $inforItem = $this->modelObj->getDetailGroupMenuByKey($groupCode, $orgCode);
                    $this->arrChooseMenu = $this->_pushArrMenuChoose($this->arrMenuSystem,$this->arrActionExecute,$this->arrCrudLimit,$inforItem);
                }
                $this->dataOutItem = [
                    'actionEdit' => STATUS_INT_KHONG, //0: thêm mới, 1: edit
                    'formNameOther' => $this->tabOtherItem1,
                    'dataOther' => $inforItem,
                ];
                $templateOut = $this->templateRoot . 'component._formDetailPermission';
                break;
            default:
                break;
        }
        $this->_outDataView($request, (array)$data);
        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $data,
                'actionEdit' => $actionEdit,//0: thêm mới, 1: edit
                'obj_id' => $obj_id,
                'formNameOther' => $formNameOther,
                'typeTab' => $typeTab,
                'divShowId' => $divShowId,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        return $html;
    }

    private function _updateDataRelation($dataForm, $typeTabAction)
    {
        $result = returnError('Không đúng thao tác! Hãy thử lại');
        switch ($typeTabAction) {
            case $this->tabOtherItem1:
                $arrPermission = [];
                foreach ($this->arrActionExecute as $key_action => $name_action) {
                    foreach ($dataForm as $key => $val_form) {
                        if ($key == $key_action . '[')
                            $arrPermission[$key_action] = $val_form;
                    }
                }
                $dataPermission = [];
                if (!empty($arrPermission)) {
                    foreach ($arrPermission as $crud => $arrVal) {
                        foreach ($arrVal as $menuId => $crudLimit) {
                            $dataPermission['DATA'][] = [
                                'MENU_CODE' => $menuId,
                                'CRUD' => trim($crud),
                                'CRUD_LIMIT' => trim($crudLimit)
                            ];
                        }
                    }
                }
                $dataPermission['GROUP_CODE'] = $dataForm['GROUP_CODE'];
                $dataPermission['ORG_CODE'] = $dataForm['ORG_CODE'];
                $dataPermission['IS_ACTIVE'] = 1;

                $dataForm['str_data_json'] = json_encode($dataPermission, false);
                $result = $this->modelObj->updateDataDetailGroup($dataForm);
                break;
            default:
                break;
        }

        if ($result['Success'] == STATUS_INT_MOT) {
            //lấy lại dữ liệu vừa sửa
            $dataInput = $dataForm;
            $dataInput['type'] = $typeTabAction;
            $dataInput['arrKey'] = ['GROUP_CODE' => $dataForm['GROUP_CODE'], 'ORG_CODE' => $dataForm['ORG_CODE']];

            $requestLoad['dataInput'] = json_encode($dataInput);
            $requestLoad['objectId'] = $dataForm['GROUP_CODE'];
            $requestLoad['divShowId'] = $dataForm['divShowIdAction'];
            $requestLoad['formName'] = $dataForm['formName'];

            $html = $this->_ajaxGetItem($requestLoad);
            $arrAjax = array('success' => 1, 'message' => 'Successfully', 'divShowAjax' => $requestLoad['divShowId'], 'html' => $html);

            return Response::json($arrAjax);
        } else {
            return Response::json(returnError($result['Message']));
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
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT])) {
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
        $active = (int)$dataForm['ACTION_FORM'];

        if ($this->_validFormDataRelation($typeTabAction, $active, $dataForm) && empty($this->error)) {
            $actionUpdate = $this->_updateDataRelation($dataForm, $typeTabAction);
            return $actionUpdate;
        } else {
            return Response::json(returnError($this->error));
        }
    }

    private function _validFormDataRelation($typeTabAction = '', $active = STATUS_INT_KHONG, &$data = array())
    {
        switch ($typeTabAction) {
            case 'orgBank': //danh mục tổ chức
                if (!empty($data)) {
                    if (isset($data['BANK_HOLDER']) && trim($data['BANK_HOLDER']) == '') {
                        $this->error[] = 'Chủ tài khoản không được bỏ trống';
                    }
                }
                break;
            default:
                break;
        }
        return true;
    }

    /**
     * get list menut permission theo project_code
     * @return array
     */
    public function ajaxGetListMenuPermission()
    {
        $request = $_POST;
        $objectCode = $request['objectCode'] ?? '';
        $orgCode = $request['orgCode'] ?? '';
        $projectCodeMenu = $request['projectCodeMenu'] ?? '';
        $typeSearch = $request['typeSearch'] ?? '';
        $data = $dataOther = [];
        if (trim($objectCode)!= '' && trim($orgCode)!= ''&& trim($projectCodeMenu)!= '') {
            if(trim($typeSearch) == 'groupMenu'){
                $dataOther = $this->modelObj->getDetailGroupMenuByKey($objectCode, $orgCode);
            }elseif(trim($typeSearch) == 'userMenu'){
                $dataOther = app(UserSystem::class)->getDetailGroupMenuByKey($objectCode, $orgCode);
            }
            $this->arrMenuSystem = app(MenuSystem::class)->getListMenuWithPermission($projectCodeMenu);
            $this->arrChooseMenu = $this->_pushArrMenuChoose($this->arrMenuSystem,$this->arrActionExecute,$this->arrCrudLimit,$dataOther);
            $this->dataOutItem = [
                'dataOther' => $dataOther,
                'arrChooseMenu' => $this->arrChooseMenu,
            ];
        }
        $this->_outDataView($request, (array)$data);
        $html = View::make($this->templateRoot . 'component._listPermission')
            ->with(array_merge([
                'data' => $data,
                'dataOther' => $dataOther,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $arrAjax = array('success' => 1, 'html' => $html);
        return $arrAjax;
    }
}
