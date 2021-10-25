<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Systems\OpenApi;

use App\Http\Controllers\BaseAdminController;
use App\Models\OpenApi\ApiSystem;
use App\Models\OpenApi\DatabaseConnection;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class ApiSystemController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrActionType = array();
    private $arrCrud = array();
    private $arrYesOrNo = array();
    private $arrDatabase = array();

    private $templateRoot = DIR_PRO_SYSTEM . '/' . DIR_MODULE_OPENAPI . '.apiSystem.';

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new ApiSystem();
        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_STATUS);
        $this->arrActionType = $this->getArrOptionTypeDefine(DEFINE_ACTION_TYPE_API);
        $this->arrCrud = $this->getArrOptionTypeDefine(DEFINE_ACTION_EXECUTE);
        $this->arrYesOrNo = $this->getArrOptionTypeDefine(DEFINE_YES_OR_NO);
        $this->arrDatabase = app(DatabaseConnection::class)->getOptionDatabase();
    }

    private function _outDataView($request, $data)
    {
        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['IS_ACTIVE']) ? $data['IS_ACTIVE'] : STATUS_INT_MOT);
        $optionDatabase = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrDatabase, isset($data['DB_CODE']) ? $data['DB_CODE'] : '');
        $optionActionType = FunctionLib::getOption($this->arrActionType, isset($data['ACTION_TYPE']) ? $data['ACTION_TYPE'] : 'EXECUTE');
        $optionCrud = FunctionLib::getOption($this->arrActionType, isset($data['CRUD']) ? $data['CRUD'] : 'SELECT');
        $optionAutoCache = FunctionLib::getOption($this->arrYesOrNo, isset($data['AUTO_CACHE']) ? $data['AUTO_CACHE'] : STATUS_INT_KHONG);
        $optionBehavCache = FunctionLib::getOption($this->arrYesOrNo, isset($data['BEHAV_CACHE']) ? $data['BEHAV_CACHE'] : STATUS_INT_KHONG);
        $optionIsAsync = FunctionLib::getOption($this->arrYesOrNo, isset($data['IS_ASYNC']) ? $data['IS_ASYNC'] : STATUS_INT_KHONG);
        $optionIsEvent = FunctionLib::getOption($this->arrYesOrNo, isset($data['IS_EVENT']) ? $data['IS_EVENT'] : STATUS_INT_KHONG);

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = (isset($request['objectId']) && trim($request['objectId']) != '0') ? 1 : 0;

        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'optionDatabase' => $optionDatabase,
            'optionActionType' => $optionActionType,
            'optionCrud' => $optionCrud,
            'optionBehavCache' => $optionBehavCache,
            'optionAutoCache' => $optionAutoCache,
            'optionIsAsync' => $optionIsAsync,
            'optionIsEvent' => $optionIsEvent,

            'arrStatus' => $this->arrStatus,
            'arrActionType' => $this->arrActionType,
            'arrCrud' => $this->arrCrud,
            'arrYesOrNo' => $this->arrYesOrNo,
            'arrDatabase' => $this->arrDatabase,

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route('apiSystem.index'),
            'urlGetItem' => URL::route('apiSystem.ajaxGetItem'),
            'urlPostItem' => URL::route('apiSystem.ajaxPostItem'),
            'urlAjaxGetData' => URL::route('apiSystem.ajaxGetData'),
            'urlActionOtherItem' => URL::route('apiSystem.ajaxUpdateRelation'),
            'functionAction' => '_ajaxGetItemOther',
            'urlDeleteItem' => '',
            'urlAjaxChangePass' => '',
        ];
    }

    private function _validformdata($id = 0, &$data = array())
    {
        if (!empty($data)) {
            if (isset($data['user_type']) && trim($data['user_type']) == '') {
                $this->error[] = 'kiểu người dùng không được bỏ trống';
            }
            if (isset($data['full_name']) && trim($data['full_name']) == '') {
                $this->error[] = 'họ tên không được bỏ trống';
            }
            if (isset($data['user_name']) && trim($data['user_name']) == '') {
                $this->error[] = 'tên đăng nhập không được bỏ trống';
            } else {
                /*$userexits = $this->modelobj->getinforuserbykey(strtoupper($data['user_name']),'user_name');
                if(isset($userexits->user_code) && $id != $userexits->user_code){
                    $this->error[] = 'tên đăng nhập đã tồn tại trên hệ thống';
                }else{
                    $data['user_name'] = strtoupper($data['user_name']);
                }*/
            }

        }
        return true;
    }

    /*********************************************************************************************************
     * Danh mục tổ chức: APIS
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Quản lý Api';
        $page_no = (int)Request::get('page_no', 1);

        $search['IS_ACTIVE'] = addslashes(Request::get('IS_ACTIVE', STATUS_INT_MOT));
        $search['p_keyword'] = addslashes(Request::get('p_keyword', ''));
        $search['p_is_active'] = $search['IS_ACTIVE'];
        $search['page_no'] = $page_no;

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchApi($search);

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
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_GET;
        $arrAjax = $this->_getInfoItem($request);
        return Response::json($arrAjax);
    }
//pkg_action_api.api_get_by_key
//APIJZSVT9P
    private function _getInfoItem($request)
    {
        $objectId = $request['objectId'] ?? '';
        $data = $dataOther = [];
        if (trim($objectId) != '' || trim($objectId) != '0') {
            $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
            $item_code = isset($dataInput->item) ? $dataInput->item->GID : '';

            $data = $this->modelObj->getApiByKey($objectId);
            //lay dư liệu tab default
            if ($data) {
                ///dữ liệu data about
                if(isset($data->API_CODE)){
                    $dataOther = $this->modelObj->getDatabasesByKey(trim($data->API_CODE));
                }
                $this->dataOutItem = [
                    'actionEdit' => isset($dataOther->API_CODE) ? STATUS_INT_MOT : STATUS_INT_KHONG, //0: thêm mới, 1: edit
                    'formNameOther' => $this->tabOtherItem1,
                    'dataOther' => $dataOther,
                    'typeTab' => $this->tabOtherItem1,
                    'obj_id' => $item_code,
                    'divShowId' => $this->tabOtherItem1,
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
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $dataRequest = $_POST;
        $dataForm = $dataRequest['dataForm'] ?? [];
        $id = (isset($dataForm['objectId']) && trim($dataForm['objectId']) != '') ? 1 : 0;
        if (empty($dataForm)) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }
        if ($this->_validFormData($id, $dataForm) && empty($this->error)) {
            $dataUpdate = [
                'GID' => isset($dataForm['GID']) ? $dataForm['GID'] : '',
                'API_CODE' => isset($dataForm['API_CODE']) ? $dataForm['API_CODE'] : '',
                'API_NAME' => isset($dataForm['API_NAME']) ? $dataForm['API_NAME'] : '',
                'PRO_CODE' => isset($dataForm['PRO_CODE']) ? $dataForm['PRO_CODE'] : '',

                'DESCRIPTION' => isset($dataForm['DESCRIPTION']) ? $dataForm['DESCRIPTION'] : '',
                'AUTOCACHE' => isset($dataForm['AUTOCACHE']) ? $dataForm['AUTOCACHE'] : '',
                'BEHAVIOSCACHE' => isset($dataForm['BEHAVIOSCACHE']) ? $dataForm['BEHAVIOSCACHE'] : '',

                'EFFECTIVEDATE' => isset($dataForm['EFFECTIVEDATE']) ? $dataForm['EFFECTIVEDATE'] : '',
                'EXPIRATIONDATE' => isset($dataForm['EXPIRATIONDATE']) ? $dataForm['EXPIRATIONDATE'] : '',
                'EFFECTIVENUM' => isset($dataForm['EFFECTIVENUM']) ? $dataForm['EFFECTIVENUM'] : 20200914,

                'ISACTIVE' => isset($dataForm['ISACTIVE']) ? $dataForm['ISACTIVE'] : '',
                'ACTION_TYPE' => isset($dataForm['ACTION_TYPE']) ? $dataForm['ACTION_TYPE'] : '',
                'CRUD' => isset($dataForm['CRUD']) ? $dataForm['CRUD'] : '',

                'APIGROUP_CODE' => isset($dataForm['APIGROUP_CODE']) ? $dataForm['APIGROUP_CODE'] : '',
                'GROUP_NAME' => isset($dataForm['GROUP_NAME']) ? $dataForm['GROUP_NAME'] : '',
                'ACTIVE_GROUP' => isset($dataForm['ACTIVE_GROUP']) ? $dataForm['ACTIVE_GROUP'] : '',
            ];
            $result = $this->modelObj->editApi($dataUpdate, ($id > 0) ? 'EDIT' : 'ADD');
            if ($result['Success'] == STATUS_INT_MOT) {
                //EDIT: lấy lại dữ liệu đã cập nhật để hiển thị lại
                if ($id > 0) {
                    $request = $dataForm;
                    $request['formName'] = $dataForm['formName'];
                    $this->_outDataView($request, $dataUpdate);
                    $html = View::make($this->templateRoot . 'component._detailFormItem')
                        ->with(array_merge([
                            'data' => (object)$dataUpdate,
                            'objectId' => $id,
                        ], $this->dataOutCommon))->render();
                    $divShowInfor = isset($request['divShowInfor']) ? $request['divShowInfor'] : 'formShowEditSuccess';//div show infor item
                    $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor);
                } //ADD: thêm mới thì load lại dư liệu để nhập các thông tin khác
                else {
                    $item_code = isset($result['Data'][0]->GID) ? $result['Data'][0]->GID : '';
                    $api_code = isset($result['Data'][0]->API_CODE) ? $result['Data'][0]->API_CODE : '';
                    $dataForm['GID'] = $item_code;
                    $dataForm['API_CODE'] = $api_code;
                    $request['objectId'] = $item_code;
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

    /*********************************************************************************************************
     * Các quan hệ của APIS tab
     *********************************************************************************************************/
    private function _ajaxGetItemOther($request)
    {
        $data = $inforItem = [];
        $formNameOther = isset($request['formName']) ? $request['formName'] : 'formName';
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'], true) : false;
        $typeTab = isset($dataInput['type']) ? $dataInput['type'] : '';
        $itemId = isset($dataInput['itemId']) ? $dataInput['itemId'] : '';
        $isDetail = isset($dataInput['isDetail']) ? $dataInput['isDetail'] : STATUS_INT_KHONG;
        $arrKey = isset($dataInput['arrKey']) ? $dataInput['arrKey'] : [];

        $actionEdit = STATUS_INT_KHONG;
        $obj_id = $request['objectId'];
        $templateOut = $this->templateRoot . 'component._formApiDatabases';
        //data chính
        $data = isset($arrKey['DataApiCode'])? (object)$arrKey['DataApiCode']:false;
        switch ($typeTab) {
            case $this->tabOtherItem1:
                //myDebug($request);
                if ($isDetail == STATUS_INT_MOT) {//chi tiết item
                    $inforItem = $this->modelObj->getDatabasesById($itemId);
                    $templateOut = $this->templateRoot . 'component._formApiDatabases';
                } else {//get list danh sách item other
                    $inforItem = $this->modelObj->getDatabasesByKey($obj_id);

                    $templateOut = $this->templateRoot . 'component._listApiDatabases';
                    $data = (object)$dataInput['itemOther'];
                }
                $actionEdit = (trim($itemId) != '') ? STATUS_INT_MOT : STATUS_INT_KHONG;
                $this->dataOutItem = [];
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
                'itemId' => $itemId,
                'formNameOther' => $formNameOther,
                'typeTab' => $typeTab,
                'divShowId' => $typeTab,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        return $html;
    }

    private function _updateDataRelation($dataForm, $typeTabAction)
    {
        $active = (int)$dataForm['ACTION_FORM'];
        $result = returnError('Không đúng thao tác! Hãy thử lại');
        switch ($typeTabAction) {
            case $this->tabOtherItem1:
                $result = $this->modelObj->editDatabases($dataForm, ($active > 0) ? 'EDIT' : 'ADD');
                break;
            default:
                break;
        }

        if ($result['Success'] == STATUS_INT_MOT) {
            //lấy lại dữ liệu vừa sửa
            $dataInput['type'] = $dataForm['typeTabAction'];
            $dataInput['isDetail'] = STATUS_INT_KHONG;
            $dataInput['itemOther'] = $dataForm;
            $dataInput['arrKey']['DataApiCode'] = json_decode($dataForm['data_item']);//data cha
            $requestLoad['dataInput'] = json_encode($dataInput);

            $requestLoad['objectId'] = $dataForm['API_CODE'];
            $requestLoad['divShowId'] = $dataForm['divShowIdAction'];
            $requestLoad['formName'] = $dataForm['formName'];

            $html = $this->_ajaxGetItemOther($requestLoad);
            $arrAjax = array('success' => 1, 'message' => 'Successfully', 'divShowInfor' => $requestLoad['divShowId'], 'html' => $html);

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
