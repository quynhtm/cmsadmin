<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Systems\OpenApi;

use App\Http\Controllers\BaseAdminController;
use App\Models\OpenApi\VersionsApi;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class VersionsApiController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrActive = array();

    private $templateRoot = DIR_PRO_SYSTEM.'/'.DIR_MODULE_OPENAPI . '.versionsApi.';
    private $divShowInfor = '';
    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new VersionsApi();
        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_STATUS_VERSION);
        $this->arrActive = $this->getArrOptionTypeDefine(DEFINE_STATUS);
    }

    private function _outDataView($request, $data)
    {
        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['STATUS']) ? $data['STATUS'] : 'OPEN');
        $optionActive = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrActive, isset($data['IS_ACTIVE']) ? $data['IS_ACTIVE'] : STATUS_INT_MOT);

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        $this->divShowInfor = isset($request['divShowInfor']) ? $request['divShowInfor'] : 'formShowEditSuccess';//div show infor item
        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'optionActive' => $optionActive,

            'arrStatus' => $this->arrStatus,
            'arrActive' => $this->arrActive,

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'divShowInfor' => $this->divShowInfor,

            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route('versionsApi.index'),
            'urlGetItem' => URL::route('versionsApi.ajaxGetItem'),
            'urlActionPostItem' => URL::route('versionsApi.ajaxPostItem'),
            'urlDeleteItem' => '',
            'urlAjaxGetData' => URL::route('versionsApi.ajaxGetData'),
            'urlActionOtherItem' => URL::route('versionsApi.ajaxUpdateRelation'),
            'functionAction' => '_ajaxGetItem',
        ];
    }

    private function _validFormData($active = STATUS_INT_KHONG, &$data = array())
    {
        if (!empty($data)) {
            if (isset($data['VERSION_CODE']) && trim($data['VERSION_CODE']) == '') {
                $this->error[] = 'VERSION_CODE không được bỏ trống';
            }else{
                if($active == 0){
                    $allVer = $this->modelObj->getAllVersion();
                    if($allVer){
                        foreach ($allVer as $k=>$ver){
                            if(strcmp(trim($data['VERSION_CODE']),$ver->VERSION_CODE) == 1){
                                $this->error[] = 'VERSION_CODE đang bị trùng,hãy nhập lại';
                                break;
                            }
                        }
                    }
                }
            }
            if (isset($data['STATUS']) && trim($data['STATUS']) == '') {
                $this->error[] = 'Tình trạng không được bỏ trống';
            }
            if (isset($data['IS_ACTIVE']) && trim($data['IS_ACTIVE']) == '') {
                $this->error[] = 'Trạng thái không được bỏ trống';
            }
        }
        return true;
    }

    /*********************************************************************************************************
     * Danh mục: VERSION
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Quản lý versions';
        $page_no = (int)Request::get('page_no', 1);

        $search['IS_ACTIVE'] = addslashes(Request::get('IS_ACTIVE', STATUS_INT_MOT));
        $search['p_keyword'] = addslashes(Request::get('p_keyword', ''));
        $search['p_is_active'] = $search['IS_ACTIVE'];
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

    public function ajaxPostItem()
    {
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
                    $itemCode = isset($result['Data'][0]->VER_ID) ? $result['Data'][0]->VER_ID : 1;
                    $dataForm['VER_ID'] = $itemCode;
                    $request['objectId'] = $itemCode;
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

    private function _getInfoItem($request)
    {
        $objectId = $request['objectId'] ?? 0;
        $data = $dataOther = [];
        if ($objectId > 0) {
            $data = $this->modelObj->getItemById($objectId);
            //lay dư liệu tab default
            if ($data) {
                ///dữ liệu data about
                $dataOther = $this->modelObj->getDataDetailByVerCode($data->VERSION_CODE);
            }
        }
        $this->_outDataView($request, (array)$data);
        $html = View::make($this->templateRoot . 'component.popupDetail')
            ->with(array_merge([
                'data' => $data,
                'dataOther' => $dataOther,
                'typeTab' => $this->tabOtherItem1,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $this->divShowInfor);
        return $arrAjax;
    }

    /*********************************************************************************************************
     * Các quan hệ của VERSION DETAIL
     *********************************************************************************************************/
    private function _ajaxGetItemOther($request)
    {
        $inforItem = [];
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'], true) : false;
        $typeTab = isset($dataInput['type']) ? $dataInput['type'] : '';

        //lay thông tin version cha
        $arrKey = isset($dataInput['arrKey']) ? $dataInput['arrKey'] : [];
        $verId = isset($arrKey['VER_ID'])? trim($arrKey['VER_ID']) :0;
        $dataParent = $this->modelObj->getItemById($verId);

        $objectId = $request['objectId'];
        $templateOut = $this->templateRoot . 'component._formDetail';
        switch ($typeTab) {
            case $this->tabOtherItem1:
                if($objectId > 0){
                    $inforItem = $this->modelObj->getDetailVerById($objectId);
                }
                break;
            default:
                break;
        }

        $this->_outDataView($request, (array)$inforItem);
        $html = View::make($templateOut)
            ->with(array_merge([
                'dataParent' => $dataParent,
                'inforItem' => $inforItem,
                'objectId' => $objectId,
                'typeTab' => $typeTab,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        return $html;
    }

    private function _updateDataRelation($dataForm, $typeTabAction)
    {
        $result = returnError('Không đúng thao tác! Hãy thử lại');
        switch ($typeTabAction) {
            case $this->tabOtherItem1:
                $id = $dataForm['objectId'];
                $result = $this->modelObj->editDetailVer($dataForm, ($id > 0) ? 'EDIT' : 'ADD');
                break;
            default:
                break;
        }
        if ($result['Success'] == STATUS_INT_MOT) {
            //lấy lại dữ liệu vừa sửa
            if(isset($dataForm['VER_ID']) > 0){
                $dataVer = $this->modelObj->getItemById($dataForm['VER_ID']);
                //lay dư liệu tab default
                if ($dataVer) {
                    ///dữ liệu data liên quan
                    $dataOther = $this->modelObj->getDataDetailByVerCode($dataVer->VERSION_CODE);
                }
            }
            $this->_outDataView($dataForm, (array)$dataVer);
            $html = View::make($this->templateRoot . 'component._listDetailVersion')
                ->with(array_merge([
                    'data' => $dataVer,
                    'dataOther' => $dataOther,
                ], $this->dataOutCommon, $this->dataOutItem))->render();
            $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $dataForm['typeTab']);

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
        $typeTabAction = (int)$dataForm['typeTab'];
        $active = (int)$dataForm['objectId'];
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
                    if (isset($data['SERVER']) && trim($data['SERVER']) == '') {
                        $this->error[] = 'SERVER không được bỏ trống';
                    }
                    if (isset($data['SCHEMA']) && trim($data['SCHEMA']) == '') {
                        $this->error[] = 'SCHEMA không được bỏ trống';
                    }
                    if (isset($data['PACKAGES']) && trim($data['PACKAGES']) == '') {
                        $this->error[] = 'PACKAGES không được bỏ trống';
                    }
                    if (isset($data['SERVER']) && trim($data['SERVER']) == '') {
                        $this->error[] = 'SERVER không được bỏ trống';
                    }
                }
                break;
            default:
                break;
        }
        return true;
    }
}
