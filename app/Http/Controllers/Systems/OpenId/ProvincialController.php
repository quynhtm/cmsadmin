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
use App\Library\AdminFunction\Upload;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class ProvincialController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrChucVu = array();
    private $arrStatus = array();
    private $arrGender = array();
    private $arrDepart = array();
    private $arrOrg = array();
    private $arrAuthType = array();
    private $arrUserType = array();

    private $templateRoot = DIR_PRO_SYSTEM.'/'.DIR_MODULE_OPENID . '.provincial.';

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new UserSystem();
        $this->arrChucVu = $this->getArrOptionTypeDefine(DEFINE_CHUC_VU);
        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_STATUS);
        $this->arrAuthType = $this->getArrOptionTypeDefine(DEFINE_AUT_TYPE);
        $this->arrUserType = $this->getArrOptionTypeDefine(DEFINE_USER_TYPE);
        $this->arrGender = CGlobal::$gender_option;
        $this->arrOrg = app(Organization::class)->getArrOptionOrg();
    }

    private function _outDataView($request, $data)
    {
        if (isset($data['ORG_CODE']) && trim($data['ORG_CODE']) != '') {
            $this->arrDepart = app(DepartmentOrg::class)->getArrOptionDepartByOrgCode($data['ORG_CODE']);
        }

        $optionDepart = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrDepart, isset($data['STRUCT_CODE']) ? $data['STRUCT_CODE'] : '');
        $optionOrg = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrOrg, isset($data['ORG_CODE']) ? $data['ORG_CODE'] : '');
        $optionChucVu = FunctionLib::getOption($this->arrChucVu, (isset($data['ORG_STRUCT']) ? $data['ORG_STRUCT'] : ''));
        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['IS_ACTIVE']) ? $data['IS_ACTIVE'] : STATUS_INT_MOT);
        $optionAuthType = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrAuthType, isset($data['AUTH_TYPE']) ? $data['AUTH_TYPE'] : '');
        $optionUserType = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrUserType, isset($data['USER_TYPE']) ? $data['USER_TYPE'] : '');

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'optionOrg' => $optionOrg,
            'optionDepart' => $optionDepart,
            'optionChucVu' => $optionChucVu,
            'optionAuthType' => $optionAuthType,
            'optionUserType' => $optionUserType,

            'arrStatus' => $this->arrStatus,
            'arrOrg' => $this->arrOrg,
            'arrDepart' => $this->arrDepart,
            'arrChucVu' => $this->arrChucVu,
            'arrAuthType' => $this->arrAuthType,
            'arrUserType' => $this->arrUserType,

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route('userSystem.indexUser'),
            'urlGetItem' => URL::route('userSystem.ajaxGetUser'),
            'urlDeleteItem' => URL::route('userSystem.ajaxDeleteUser'),
            'urlAjaxGetData' => URL::route('userSystem.ajaxGetData'),
            'url_action' => URL::route('userSystem.ajaxPostUser'),
            'url_action_other_item' => URL::route('userSystem.ajaxUpdateUserRelation'),
            'functionAction' => '_ajaxGetItem',
        ];
    }

    private function _validFormData($active = STATUS_INT_KHONG, &$data = array())
    {
        if (!empty($data)) {
            if (isset($data['USER_TYPE']) && trim($data['USER_TYPE']) == '') {
                $this->error[] = 'Kiểu người dùng không được bỏ trống';
            }
            if (isset($data['FULL_NAME']) && trim($data['FULL_NAME']) == '') {
                $this->error[] = 'Họ tên không được bỏ trống';
            }
            if (isset($data['USER_NAME']) && trim($data['USER_NAME']) == '') {
                $this->error[] = 'USER_NAME không được bỏ trống';
            }
            if (isset($data['ORG_CODE']) && trim($data['ORG_CODE']) == '') {
                $this->error[] = 'Tổ chức không được bỏ trống';
            }
            if (isset($data['STRUCT_CODE']) && trim($data['STRUCT_CODE']) == '') {
                $this->error[] = 'Phòng ban không được bỏ trống';
            }
            if (isset($data['EFFECTIVE_DATE']) && trim($data['EFFECTIVE_DATE']) == '') {
                $this->error[] = 'Ngày hiệu lực không được bỏ trống';
            }

            if (isset($data['AUTH_TYPE']) && trim($data['AUTH_TYPE']) != '') {
                if($data['AUTH_TYPE'] == 'E'){
                    if (isset($data['EMAIL']) && trim($data['EMAIL']) == '') {
                        $this->error[] = 'EMAIL không được bỏ trống';
                    }
                }elseif($data['AUTH_TYPE'] == 'O'){
                    if (isset($data['PHONE']) && trim($data['PHONE']) == '') {
                        $this->error[] = 'PHONE không được bỏ trống';
                    }
                }else{
                    $this->error[] = 'Kiểu xác thực sai định dạng';
                }
            }
            if (isset($data['EMAIL']) && trim($data['EMAIL']) != '') {
                if(!checkRegexEmail(trim($data['EMAIL']))){
                    $this->error[] = 'EMAIL không đúng định dạng';
                }
            }
            if (isset($data['PHONE']) && trim($data['PHONE']) != '') {
                if(!validatePhoneNumber(trim($data['PHONE']))){
                    $this->error[] = 'PHONE không đúng định dạng';
                }
            }
        }
        return true;
    }

    /*********************************************************************************************************
     * Danh mục tổ chức: USER
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Quản lý địa chính';
        $page_no = (int)Request::get('page_no', 1);

        $search['ORG_CODE'] = addslashes(Request::get('ORG_CODE', ''));
        $search['STRUCT_CODE'] = addslashes(Request::get('STRUCT_CODE', ''));
        $search['IS_ACTIVE'] = addslashes(Request::get('IS_ACTIVE', STATUS_INT_MOT));
        $search['p_keyword'] = addslashes(Request::get('p_keyword', ''));
        $search['p_is_active'] = $search['IS_ACTIVE'];
        $search['p_org_code'] = $search['ORG_CODE'];
        $search['p_struct_code'] = $search['STRUCT_CODE'];
        $search['page_no'] = $page_no;

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchUser($search);

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

    public function ajaxGetItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_GET;
        $arrAjax = $this->_getInfoItem($request);
        return Response::json($arrAjax);
    }

    private function _getInfoItem($request)
    {
        $objectId = $request['objectId'] ?? 0;
        $data = [];
        if ($objectId > 0) {
            $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
            $user_code = isset($dataInput->item) ? $dataInput->item->USER_CODE : '';
            $data = $this->modelObj->getUserByKey($user_code);
            //lay dư liệu tab default
            if ($data) {
                ///dữ liệu data about
                $dataOther = $this->modelObj->getUserAboutByKey($data->USER_CODE);
                $optionGender = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrGender, isset($dataOther->GENDER) ? $dataOther->GENDER : '');

                $this->dataOutItem = [
                    'actionEdit' => isset($dataOther->USER_CODE) ? STATUS_INT_MOT : STATUS_INT_KHONG, //0: thêm mới, 1: edit
                    'formNameOther' => $this->tabOtherItem1,
                    'dataOther' => $dataOther,
                    'typeTab' => $this->tabOtherItem1,
                    'obj_id' => $data->USER_CODE,
                    'USER_CODE' => $data->USER_CODE,
                    'USER_ORG_CODE' => $data->ORG_CODE,
                    'divShowId' => 'tab-content-1',
                    'optionGender' => $optionGender,
                ];
            }
        }
        $this->_outDataView($request, (array)$data);
        $html = View::make($this->templateRoot . 'component.popupDetail')
            ->with(array_merge([
                'data' => $data,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $divShowInfor = isset($request['divShowInfor']) ? $request['divShowInfor'] : 'formShowEditSuccess';//div show infor item
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor);
        return $arrAjax;
    }

    public function ajaxPostItem()
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
            $dataForm['MENU_CODE'] = '-1';
            $id = $dataForm['objectId'] ?? 0;
            $result = $this->modelObj->editUser($dataForm, ($id > 0) ? 'EDIT' : 'ADD');
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
                    $divShowInfor = isset($request['divShowInfor']) ? $request['divShowInfor'] : 'formShowEditSuccess';//div show infor item
                    $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor);
                } //ADD: thêm mới thì load lại dư liệu để nhập các thông tin khác
                else {
                    $user_code = isset($result['Data'][0]->USER_CODE) ? $result['Data'][0]->USER_CODE : 1;
                    $dataForm['USER_CODE'] = $user_code;
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

    public function ajaxDeleteItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_REMOVE])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_POST;
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
        $dataItem = isset($dataInput->item) ? (array)$dataInput->item : false;

        if (!empty($dataItem)) {
            $result = $this->modelObj->deleteUser($dataItem);
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
     * Các quan hệ của USER tab
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
        $templateOut = $this->templateRoot . 'component._formUserAbout';

        switch ($typeTab) {
            case $this->tabOtherItem1:
                if (trim($obj_id) != '') {
                    $data = $this->modelObj->getUserByKey($obj_id);
                    $inforItem = $this->modelObj->getUserAboutByKey($obj_id);
                }
                $actionEdit = STATUS_INT_MOT;
                $divShowId = 'tab-content-1';
                $optionGender = FunctionLib::getOption($this->arrGender, isset($inforItem->GENDER) ? $inforItem->GENDER : '');

                $this->dataOutItem = [
                    'optionGender' => $optionGender,
                ];
                $templateOut = $this->templateRoot . 'component._formUserAbout';
                break;
            case $this->tabOtherItem2:

                if (trim($obj_id) != '') {
                    $data = $this->modelObj->getUserByKey($obj_id);
                }
                $arrSelectGroupMenu = [];
                if (!empty($data)) {
                    $inforItem = $this->modelObj->getUserGroupMenuByKey($data->USER_CODE);
                    $arrSelectGroupMenu = isset($inforItem->GROUP_CODE) ? explode(',', $inforItem->GROUP_CODE) : [];
                }

                $actionEdit = ($inforItem) ? STATUS_INT_MOT : STATUS_INT_KHONG;
                $divShowId = 'tab-content-2';

                $groupMenu = ($data) ? app(GroupMenu::class)->getDataByOrgCode($data->ORG_CODE) : [];
                $this->dataOutItem = [
                    'arrSelectGroupMenu' => $arrSelectGroupMenu,
                    'groupMenu' => $groupMenu,
                ];
                $templateOut = $this->templateRoot . 'component._formUserPermissionWithGroup';
                break;
            case $this->tabOtherItem3:
                if (trim($obj_id) != '') {
                    $data = $this->modelObj->getUserByKey($obj_id);
                    if ($data) {
                        $userCode = isset($data->USER_CODE) ? $data->USER_CODE : '';
                        $orgCode = isset($data->ORG_CODE) ? $data->ORG_CODE : '';
                        $inforItem = $this->modelObj->getDetailGroupMenuByKey($userCode, $orgCode);
                    }
                }
                $actionEdit = STATUS_INT_MOT;
                $divShowId = 'tab-content-3';

                ///dữ liệu data about
                $this->arrCrudLimit = $this->getArrOptionTypeDefine(DEFINE_CRUD_LIMIT);
                $this->arrActionExecute = $this->getArrOptionTypeDefine(DEFINE_ACTION_EXECUTE);
                $this->arrMenuSystem = [];

                $this->dataOutItem = [
                    'arrCrudLimit' => $this->arrCrudLimit,
                    'arrActionExecute' => $this->arrActionExecute,
                    'arrMenuSystem' => $this->arrMenuSystem,
                ];
                $templateOut = $this->templateRoot . 'component._formUserPermissionWithMenu';
                break;
            default:
                break;
        }
        $this->_outDataView($request, (array)$data);
        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $data,
                'dataOther' => $inforItem,
                'actionEdit' => $actionEdit,//0: thêm mới, 1: edit
                'obj_id' => $obj_id,
                'formNameOther' => $formNameOther,
                'typeTab' => $typeTab,
                'divShowId' => $divShowId,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        return $html;
    }

    private function _updateDataUserRelation($dataForm, $typeTabAction)
    {
        $active = (int)$dataForm['ACTION_FORM'];
        $result = returnError('Không đúng thao tác! Hãy thử lại');
        switch ($typeTabAction) {
            case $this->tabOtherItem1:
                if (isset($_FILES['inputFile']) && count($_FILES['inputFile']) > 0 && $_FILES['inputFile']['name'] != '') {
                    $folder = FOLDER_FILE_USER_ABOUT;;
                    $pathFileUpload = app(Upload::class)->uploadFile('inputFile', $folder, $dataForm['USER_CODE']);
                    if (trim($pathFileUpload) != '') {
                        app(Upload::class)->removeFile($folder, $dataForm['IMAGE']);
                        $dataForm['IMAGE'] = $pathFileUpload;
                    }
                }
                $result = $this->modelObj->editUserAbout($dataForm, ($active > 0) ? 'EDIT' : 'ADD');
                break;
            case $this->tabOtherItem2:
                $result = $this->modelObj->editUserGroupMenu($dataForm, ($active > 0) ? 'EDIT' : 'ADD');
                break;
            case $this->tabOtherItem3:
                $this->arrActionExecute = $this->getArrOptionTypeDefine(DEFINE_ACTION_EXECUTE);
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
                $dataPermission['USER_CODE'] = $dataForm['USER_CODE'];
                $dataPermission['ORG_CODE'] = $dataForm['ORG_CODE'];
                $dataPermission['IS_ACTIVE'] = 1;

                $dataForm['str_data_json'] = json_encode($dataPermission, false);
                $result = $this->modelObj->updateUserMenu($dataForm);
                break;
            default:
                break;
        }

        if ($result['Success'] == STATUS_INT_MOT) {
            //lấy lại dữ liệu vừa sửa
            $dataInput['type'] = $dataForm['typeTabAction'];
            $requestLoad['dataInput'] = json_encode($dataInput);
            $requestLoad['objectId'] = $dataForm['USER_CODE'];
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

    public function ajaxUpdateItemRelation()
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

        if ($this->_validFormDataUserRelation($typeTabAction, $active, $dataForm) && empty($this->error)) {
            $actionUpdate = $this->_updateDataUserRelation($dataForm, $typeTabAction);
            return $actionUpdate;
        } else {
            return Response::json(returnError($this->error));
        }
    }

    private function _validFormDataUserRelation($typeTabAction = '', $active = STATUS_INT_KHONG, &$data = array())
    {
        switch ($typeTabAction) {
            case $this->tabOtherItem1:
                if (!empty($data)) {
                    if (isset($data['BIRTHDAY']) && trim($data['BIRTHDAY']) == '') {
                        $this->error[] = 'Ngày sinh không được bỏ trống';
                    }
                }
                break;
            default:
                break;
        }
        return true;
    }

}
