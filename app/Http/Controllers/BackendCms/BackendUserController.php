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
    }

    private function _outDataView($request, $data)
    {
        $optionIsActive = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrIsActive, isset($data['is_active']) ? $data['is_active'] : STATUS_INT_MOT);
        $optionGender = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrGender, isset($data['user_gender']) ? $data['user_gender'] : STATUS_INT_MOT);
        $optionUserType = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrUserType, isset($data['user_type']) ? $data['user_type'] : STATUS_INT_BA);
        $optionPosition = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrPosition, isset($data['user_position']) ? $data['user_position'] : DEFINE_NHAN_VIEN);

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

            'arrGender' => $this->arrGender,
            'arrUserType' => $this->arrUserType,
            'arrPosition' => $this->arrPosition,

            'form_id' => $formId,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'pageTitle' => $this->pageTitle,

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
                if($objectId > STATUS_INT_KHONG){
                    $dataDetail = (isset($dataInput['dataItem']) && !empty($dataInput['dataItem'])) ? $dataInput['dataItem'] : $this->modelObj->getItemById($objectId);
                }

                $this->_outDataView($request, (array)$dataDetail);
                $htmlView = View::make($this->templateRoot . 'component.popupDetail')
                    ->with(array_merge($this->dataOutCommon,[
                        'dataDetail' => $dataDetail,
                        //tab1
                        'arrActionExecute' => $this->arrActionExecute,
                        'arrMenuSystem' => [],

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
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_ADD, PERMISS_EDIT])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $request = $_POST;
        $arrAjax = array('success' => 0, 'html' => '', 'msg' => '');
        $actionUpdate = 'actionUpdate';
        $actionUpdate = isset($request['dataForm']['actionUpdate']) ? $request['dataForm']['actionUpdate'] : (isset($request['actionUpdate']) ? $request['actionUpdate'] : $actionUpdate);

        switch ($actionUpdate) {
            case 'updateData':
                $dataForm = isset($request['dataForm']) ? $request['dataForm'] : [];
                //myDebug($dataForm,false);
                $objectId = isset($dataForm['objectId'])? $dataForm['objectId']:STATUS_INT_KHONG;
                /*if($this->_validFormData($objectId,$dataForm)){

                }*/
                $idNew = $this->modelObj->editItem($dataForm,$objectId);
                //myDebug($idNew);
                if ($idNew > 0) {
                    $dataDetail = $this->modelObj->getItemById($idNew);
                    $this->_outDataView($request, (array)$dataDetail);
                    $htmlView = View::make($this->templateRoot . 'component.popupDetail')
                        ->with(array_merge($this->dataOutCommon,[
                            'dataDetail' => $dataDetail,
                            'paramSearch' => '',
                            'objectId' => $objectId,
                            'formName' => isset($dataForm['formName'])? $dataForm['formName']:'formName',
                            'titlePopup' => isset($dataForm['titlePopup'])? $dataForm['titlePopup']:'Thông tin chi tiết',
                        ]))->render();

                    $arrAjax['success'] = 1;
                    $arrAjax['html'] = $htmlView;
                    $arrAjax['divShowInfor'] = $dataForm['div_show_edit_success'];
                }
                break;
            default:
                break;
        }
        return Response::json($arrAjax);
    }

    public function ajaxGetData()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_VIEW, PERMISS_ADD, PERMISS_EDIT])) {
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
            if (isset($data['USER_TYPE']) && trim($data['USER_TYPE']) == '') {
                $this->error[] = 'Kiểu người dùng không được bỏ trống';
            }
            if (isset($data['FULL_NAME']) && trim($data['FULL_NAME']) == '') {
                $this->error[] = 'Họ tên không được bỏ trống';
            }
            if (isset($data['USER_NAME']) && trim($data['USER_NAME']) == '') {
                $this->error[] = 'Tên đăng nhập không được bỏ trống';
            } else {
                $userExits = $this->modelObj->getInforUserByKey(strtoupper($data['USER_NAME']),'USER_NAME');
                if(isset($userExits->USER_CODE) && $id != $userExits->USER_CODE){
                    $this->error[] = 'Tên đăng nhập đã tồn tại trên hệ thống';
                }else{
                    $data['USER_NAME'] = strtoupper($data['USER_NAME']);
                }
            }
            if (isset($data['PASSWORD']) && trim($data['PASSWORD']) == '') {
                $data['PASSWORD'] = DEFINE_PASSWORD_DEFAULT;
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
                if ($data['AUTH_TYPE'] == 'E') {
                    if (isset($data['EMAIL']) && trim($data['EMAIL']) == '') {
                        $this->error[] = 'EMAIL không được bỏ trống';
                    }
                } elseif ($data['AUTH_TYPE'] == 'O') {
                    if (isset($data['PHONE']) && trim($data['PHONE']) == '') {
                        $this->error[] = 'PHONE không được bỏ trống';
                    }
                } else {
                    $this->error[] = 'Kiểu xác thực sai định dạng';
                }
            }
            if (isset($data['EMAIL']) && trim($data['EMAIL']) != '') {
                if (!checkRegexEmail(trim(strtolower($data['EMAIL'])))) {
                    $this->error[] = 'EMAIL không đúng định dạng';
                }else{
                    $emailExits = $this->modelObj->getInforUserByKey(strtolower($data['EMAIL']),'EMAIL');
                    if(isset($emailExits->USER_CODE) && $id != $emailExits->USER_CODE){
                        $this->error[] = 'Email đã tồn tại trên hệ thống';
                    }
                }
                $data['EMAIL'] = strtolower($data['EMAIL']);
            }
            if (isset($data['PHONE']) && trim($data['PHONE']) != '') {
                if (!validatePhoneNumber(trim($data['PHONE']))) {
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
