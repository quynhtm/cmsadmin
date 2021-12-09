<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\BackendCms;

use App\Events\UserSystemEvent;
use App\Http\Controllers\BaseAdminController;
use App\Models\BackendCms\MenuSystem;
use App\Models\BackendCms\PermissionGroup;
use App\Models\BackendCms\PermissionUser;
use App\Models\BackendCms\PermissionUserGroup;
use App\Models\BackendCms\Users;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;
use App\Services\ServiceCommon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class BackendUserController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrIsActive = array();
    private $arrDefineCode = array();
    private $arrGender = array();
    private $arrUserType = array();
    private $arrPosition = array();
    private $arrActionExecute = array();
    private $arrTypeMenu = array();
    private $arrMenuSystem = array();

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    private $templateRoot = DIR_PRO_BACKEND . '.Users.';
    private $routerIndex = 'users.index';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new Users();

        $this->arrDefineCode = [];
        $this->arrIsActive = $this->getArrOptionTypeDefine(DEFINE_TRANG_THAI);
        $this->arrGender = $this->getArrOptionTypeDefine(DEFINE_GIOI_TINH);
        $this->arrUserType = $this->getArrOptionTypeDefine(DEFINE_USER_TYPE);
        $this->arrPosition = $this->getArrOptionTypeDefine(DEFINE_CHUC_VU);
        $this->arrActionExecute = $this->getArrOptionTypeDefine(DEFINE_PERMISSION_ACTION);
        $this->arrTypeMenu = $this->getArrOptionTypeDefine(DEFINE_TYPE_MENU);

        $this->arrMenuSystem = app(MenuSystem::class)->getListMenuPermission();
    }

    private function _outDataView($request, $data)
    {

        $optionIsActive = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrIsActive, isset($data['is_active']) ? $data['is_active'] : STATUS_INT_MOT);
        $optionGender = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrGender, isset($data['user_gender']) ? $data['user_gender'] : STATUS_INT_MOT);
        $optionUserType = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrUserType, isset($data['user_type']) ? $data['user_type'] : STATUS_INT_BA);
        $optionPosition = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrPosition, isset($data['user_position']) ? $data['user_position'] : DEFINE_NHAN_VIEN);
        $optionPartner = FunctionLib::getOption([DEFINE_NULL => '---Tất cả---'] + $this->arrPartner, isset($data['partner_id']) ? $data['partner_id'] : STATUS_INT_MOT);

        $projectCode = isset($data['project_code']) ? $data['project_code']: STATUS_INT_HAI;
        $optionTypeMenu = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrTypeMenu, $projectCode);

        $formId = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Users System';

        $this->shareListPermission($this->routerIndex);//lay quyen theo ajax
        return $this->dataOutCommon = [
            'optionGender' => $optionGender,
            'optionIsActive' => $optionIsActive,
            'optionUserType' => $optionUserType,
            'optionPosition' => $optionPosition,
            'optionTypeMenu' => $optionTypeMenu,
            'optionPartner' => $optionPartner,
            'arrActionExecute' => $this->arrActionExecute,

            'arrGender' => $this->arrGender,
            'arrUserType' => $this->arrUserType,
            'arrPosition' => $this->arrPosition,

            'form_id' => $formId,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'pageTitle' => $this->pageTitle,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route($this->routerIndex),
            'urlGetData' => URL::route('users.ajaxGetData'),
            'urlPostData' => URL::route('users.ajaxPostData'),
        ];
    }
    /*********************************************************************************************************
     * Danh mục tổ chức: USER
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $limit = CGlobal::number_show_20;
        $page_no = (int)Request::get('page_no', 1);
        $search['page_no'] = $page_no;
        $search['limit'] = $limit;
        $search['user_name'] = trim(addslashes(Request::get('user_name', '')));
        $search['full_name'] = trim(addslashes(Request::get('full_name', '')));

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
                $groupMenu = $chooseGroupMenu = $arrCheckPer = [];
                $arrMenuSystem = $this->arrMenuSystem[CGlobal::project_code];
                $arrChooseMenu = $arrCheckMenu = [];
                if($objectId > STATUS_INT_KHONG){
                    $dataDetail = $this->modelObj->getItemById($objectId);
                    $dataDetail = ($dataDetail) ? $dataDetail->toArray() : false;
                    //tab1: get data group permisss
                    $groupMenu =  app(PermissionGroup::class)->getDataAll();
                    $dataCheck = app(PermissionUserGroup::class)->getPermUserGroupByUserId($objectId);
                    $arrCheckPer = (isset($dataCheck->str_group_id) && trim($dataCheck->str_group_id) != '')? explode(',',trim($dataCheck->str_group_id)):[];
                    //tab2
                    $groupUser = app(PermissionUser::class)->getPermissUserWithUserId($dataDetail['id']);
                    if($groupUser){
                        foreach ($groupUser as $k =>$gdetail){
                            if (isset($arrMenuSystem[$gdetail->menu_id])){
                                $arrChooseMenu[$gdetail->menu_id] = $arrMenuSystem[$gdetail->menu_id];
                                $arrCheckMenu[$gdetail->menu_id][] = $gdetail->permiss_code;
                            }
                        }
                    }
                }

                $this->_outDataView($request, (array)$dataDetail);
                $htmlView = View::make($this->templateRoot . 'component.popupDetail')
                    ->with(array_merge($this->dataOutCommon,[
                        'dataDetail' => $dataDetail,
                        //tab1
                        'groupMenu' => $groupMenu,
                        'arrCheckPer' => $arrCheckPer,

                        //tab2
                        'arrMenuSystem' => $arrMenuSystem,
                        'arrCheckMenu' => $arrCheckMenu,
                        'arrChooseMenu' => $arrChooseMenu,

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

    /*
     * url update common
     * actionUpdate:
     * */
    public function ajaxPostData()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_ADD, PERMISS_EDIT],$this->routerIndex)) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $request = $_POST;
        $arrAjax = array('success' => 0, 'html' => '', 'message' => '');
        $actionUpdate = 'actionUpdate';
        $dataForm = isset($request['dataForm']) ? $request['dataForm'] : [];
        $actionUpdate = isset($dataForm['actionUpdate']) ? $dataForm['actionUpdate'] : (isset($request['actionUpdate']) ? $request['actionUpdate'] : $actionUpdate);

        switch ($actionUpdate) {
            case 'updateData':
                //myDebug($dataForm,false);
                $objectId = isset($dataForm['objectId'])? $dataForm['objectId']:STATUS_INT_KHONG;
                $isUpdate = 0;
                if($this->_validFormData($objectId,$dataForm) && empty($this->error)){
                    $isUpdate = $this->modelObj->editItem($dataForm,$objectId);
                }

                if ($isUpdate > 0) {
                    $dataDetail = $this->modelObj->getItemById($isUpdate);
                    $this->_outDataView($request, (array)$dataDetail);

                    $arrAjax['success'] = 1;
                    $arrAjax['html'] = '';
                    $arrAjax['loadPage'] = ($objectId >0) ? 0 : 1;
                    $arrAjax['divShowInfor'] = '';
                }else{
                    $arrAjax = returnError($this->error);
                    /*if(!empty($this->error)){
                        $str_error = '';
                        foreach ($this->error as $key=>$msg){
                            $str_error .= $msg.' <br/> ';
                        }
                    }
                    $arrAjax['message'] = $str_error;*/
                }
                //myDebug($arrAjax);
                break;
            case 'updatePermissUserGroup':
                $objectId = isset($dataForm['objectId'])? $dataForm['objectId']:STATUS_INT_KHONG;
                $str_group_id = isset($dataForm['str_group_id'])? $dataForm['str_group_id']:'';
                if($objectId > 0){
                    $this->modelPerUserGroup = new PermissionUserGroup();
                    $dataGroupUser = ['user_id'=> $objectId,'str_group_id'=> $str_group_id];
                    $editPerGroupUser = $this->modelPerUserGroup->updatePermUserGroup($dataGroupUser,$objectId);
                }

                //myDebug($idNew);
                if ($editPerGroupUser) {
                    $arrAjax['success'] = 1;
                    $arrAjax['html'] = '';
                    $arrAjax['loadPage'] = 0;
                }
                break;
            case 'updatePermissUser':
                $user_id = isset($dataForm['user_id'])? $dataForm['user_id']:STATUS_INT_KHONG;
                $project_code = isset($dataForm['s_project_code'])? $dataForm['s_project_code']: STATUS_INT_KHONG;
                $load_page = isset($dataForm['load_page'])? $dataForm['load_page']: STATUS_INT_KHONG;

                $arrMenuSystem = isset($this->arrMenuSystem[$project_code])?$this->arrMenuSystem[$project_code]: [];
                $arrPermissForm = app(PermissionGroup::class)->buildInforPermGroup($arrMenuSystem,$this->arrActionExecute,$dataForm);

                if(!empty($arrPermissForm) && $user_id >0 && $project_code >0 ){
                    $edit = app(PermissionUser::class)->updatePermissUser($arrPermissForm,$user_id, $project_code);
                }
                if ($edit) {
                    $arrAjax['success'] = 1;
                    $arrAjax['loadPage'] = $load_page;
                    $arrAjax['html'] = '';
                }
                break;
            default:
                break;
        }
        return Response::json($arrAjax);
    }

    public function ajaxGetData()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_VIEW, PERMISS_ADD, PERMISS_EDIT],$this->routerIndex)) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
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
            if (isset($data['user_type']) && trim($data['user_type']) == '') {
                $this->error[] = 'Kiểu người dùng không được bỏ trống';
            }
            if (isset($data['full_name']) && trim($data['full_name']) == '') {
                $this->error[] = 'Họ tên không được bỏ trống';
            }
            if (isset($data['user_name']) && trim($data['user_name']) == '') {
                $this->error[] = 'Tên đăng nhập không được bỏ trống';
            } else {
                $userExits = $this->modelObj->getUserByName(strtolower($data['user_name']));
                if(isset($userExits->id) && $id != $userExits->id){
                    $this->error[] = 'Tên đăng nhập đã tồn tại trên hệ thống';
                }else{
                    if($id == 0){
                        $data['user_name'] = strtolower($data['user_name']);
                    }else{
                        unset($data['user_name']);
                    }
                }
            }
            if ($id == 0 && isset($data['password'])) {
                $str_password = (trim($data['password']) == '')? DEFINE_PASSWORD_DEFAULT : $data['password'];
                $data['password'] = $this->modelObj->encode_password(trim($str_password).strtoupper(trim($data['user_name'])));
            }else{
                if(isset($data['password'])){
                    unset($data['password']);
                }
            }
            if (isset($data['user_email']) && trim($data['user_email']) != '') {
                if (!checkRegexEmail(trim(strtolower($data['user_email'])))) {
                    $this->error[] = 'EMAIL không đúng định dạng';
                }else{
                    $emailExits = $this->modelObj->getUserByEmail(strtolower($data['user_email']));
                    if(isset($emailExits->id) && $id != $emailExits->id){
                        $this->error[] = 'Email đã tồn tại trên hệ thống';
                    }
                }
                $data['user_email'] = strtolower($data['user_email']);
            }
            if (isset($data['user_phone']) && trim($data['user_phone']) != '') {
                if (!validatePhoneNumber(trim($data['user_phone']))) {
                    $this->error[] = 'PHONE không đúng định dạng';
                }
            }
        }
        return true;
    }



    //get profile
    public function getProfile($ids, $name)
    {
        $userCode = getStrVar($ids);
        CGlobal::$pageAdminTitle = "Thông tin cá nhân";
        $data = array();
        if ($userCode > 0) {
            $data = $this->modelObj->getInforUserByKey($userCode);
            if(isset($data->IS_CHANGE_PWD) && $data->IS_CHANGE_PWD == STATUS_INT_KHONG){
                $this->error[] = 'Bạn phải đổi lại mật khẩu.';
            }
        }
        if (empty($data)) {
            return Response::json(returnError(viewLanguage('Dữ liệu không đúng')));
        }
        $this->_outDataView($_GET, (array)$data);
        return view($this->templateRoot . 'profile', array_merge([
            'data' => $data,
            'id' => $userCode,
            'error' => $this->error,
            'pageTitle' => CGlobal::$pageAdminTitle,
        ], $this->dataOutCommon));
    }

    public function postProfile($ids, $name)
    {
        $userCode = getStrVar($ids);
        $data = $_POST;
        if ($userCode > 0) {
            $profileUser = $this->modelObj->getInforUserByKey($userCode);
        }
        if (empty($profileUser)) {
            return Response::json(returnError(viewLanguage('Dữ liệu không đúng')));
        }
        if ($this->_validFormData($userCode, $data) && empty($this->error)) {
            //Insert dữ liệu
            $dataUpdate['FULL_NAME'] = $data['FULL_NAME'];
            $dataUpdate['BIRTHDAY'] = $data['BIRTHDAY'];
            $dataUpdate['EMAIL'] = $data['EMAIL'];
            $dataUpdate['ID_CARD'] = $data['ID_CARD'];
            $dataUpdate['PHONE'] = $data['PHONE'];
            $dataUpdate['PASSPORT_NO'] = $data['PASSPORT_NO'];
            $dataUpdate['GENDER'] = $data['GENDER'];
            $dataUpdate['IMAGE'] = $data['IMAGE'];

            if (isset($_FILES['inputImage']) && count($_FILES['inputImage']) > 0 && $_FILES['inputImage']['name'] != '') {
                $folder = FOLDER_FILE_USER_ADMIN;;
                $fileName = app(Upload::class)->uploadFileHdi('inputImage', $folder);
                if (trim($fileName) != '') {
                    $pathFileUpload = getDirFile($fileName);
                    $image_id = app(ServiceCommon::class)->moveFileToServerStore($pathFileUpload,false);
                    $dataUpdate['IMAGE'] = $image_id;
                    app(Upload::class)->removeFile($folder, $fileName);
                }
            }
            if ($userCode > 0) {
                if ($this->modelObj->updateProfileUser($userCode, $dataUpdate)) {
                    showMessage('status', 'Cập nhật thành công');
                    return Redirect::route('userSystem.userProfile',['id' => setStrVar($userCode),'name'=>safe_title($data['FULL_NAME'])]);
                } else {
                    $this->error[] = 'Lỗi truy xuất dữ liệu';;
                }
            }
        }

        //gán lại khi có lỗi hiển thị
        $profileUser->FULL_NAME = $data['FULL_NAME'];
        $profileUser->BIRTHDAY = $data['BIRTHDAY'];
        $profileUser->EMAIL = $data['EMAIL'];
        $profileUser->ID_CARD = $data['ID_CARD'];
        $profileUser->PHONE = $data['PHONE'];
        $profileUser->PASSPORT_NO = $data['PASSPORT_NO'];
        $profileUser->GENDER = $data['GENDER'];
        $profileUser->IMAGE = $data['IMAGE'];
        $this->_outDataView($_POST, (array)$profileUser);
        return view($this->templateRoot . 'profile', array_merge([
            'data' => $profileUser,
            'error' => $this->error,
            'id' => $userCode,
            'pageTitle' => CGlobal::$pageAdminTitle,
        ], $this->dataOutCommon));
    }

    //popupChangePass
    public function ajaxGetChangePass()
    {
        $request = $_GET;
        $oject_id = getStrVar($request['objectId']) ?? 0;
        $user = $this->modelObj->userLogin();
        $userChange = $this->modelObj->getUserByKey($oject_id);
        if (!$this->is_root && !$this->checkMultiPermiss() && (int)$oject_id !== (int)$user['user_id'] && !$userChange) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }

        $this->_outDataView($request, (array)$userChange);
        $html = View::make($this->templateRoot . 'component.user.popupChangePass')
            ->with(array_merge([
                'data' => $userChange,
                'loadPage' => $request['loadPage'],
                'formChangePass' => 'formChangePass',
                'url_action_change_pass' => URL::route('userSystem.ajaxPostChangePass'),
            ], $this->dataOutCommon))->render();
        $arrAjax = array('success' => 1, 'html' => $html);
        return Response::json($arrAjax);
    }

    public function ajaxPostChangePass()
    {
        $dataForm = $_POST;
        $dataInput = $dataForm['dataForm'] ?? [];

        $oject_id = getStrVar($dataInput['objectId']) ?? 0;
        $user = $this->modelObj->userLogin();
        $userChange = $this->modelObj->getUserByKey($oject_id);
        if (!$this->is_root && !$this->checkMultiPermiss() && (int)$oject_id !== (int)$user['user_id'] && !$userChange) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }

        if (empty($dataInput)) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }
        //myDebug($userChange);
        $error = array();
        $new_password = $dataInput['NEW_PASSWORD'];
        $confirm_new_password = $dataInput['CONFIRM_NEW_PASSWORD'];

        if ($new_password == '') {
            $error[] = 'Bạn chưa nhập mật khẩu mới';
        } elseif (!validatePass($new_password)) {
            $error[] = 'Mật khẩu không đúng định dạng';
        }
        if ($confirm_new_password == '') {
            $error[] = 'Bạn chưa xác nhận mật khẩu mới';
        }
        if ($new_password != '' && $confirm_new_password != '' && $confirm_new_password !== $new_password) {
            $error[] = 'Mật khẩu xác nhận không chính xác';
        }
        $strPassNew = $this->modelObj->buildPassword(strtoupper($userChange->USER_NAME), $new_password);
        if (strcmp(trim($strPassNew), trim($userChange->PASSWORD)) === 0 && (int)$userChange->USER_CODE == (int)$user['user_id']) {
            $error[] = 'Mật khẩu mới trùng với mật khẩu cũ';
        }
        if (empty($error)) {
            $dataPass['PASSWORD'] = $strPassNew;
            $dataPass['OLD_PASSWORD'] = $userChange->PASSWORD;
            $dataPass['IS_CHANGE_PWD'] = ((int)$userChange->USER_CODE == (int)$user['user_id']) ? STATUS_INT_MOT : STATUS_INT_KHONG;
            if ($this->modelObj->updatePassword($userChange->USER_CODE, $dataPass)) {
                if ((int)$userChange->USER_CODE == (int)$user['user_id']) {
                    if (Session::has(SESSION_ADMIN_LOGIN)) {
                        Session::forget(SESSION_ADMIN_LOGIN);
                        return Response::json(['success'=>STATUS_INT_MOT, 'loadPage'=>1]);
                    }
                } else {
                    return Response::json(['success'=>STATUS_INT_MOT, 'loadPage'=>$dataInput['loadPage']]);
                }
            } else {
                $error[] = 'Không update được dữ liệu';
            }
        }
        return Response::json(returnError($error));
    }

}
