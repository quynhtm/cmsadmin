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
use App\Models\BackendCms\PermissionGroup;
use App\Models\BackendCms\PermissionGroupDetail;
use App\Models\BackendCms\PermissionUser;
use App\Models\BackendCms\Province;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class BackendProviceDistrictController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;
    private $modelDetail = false;

    private $arrIsActive = array();
    private $arrDefineCode = array();
    private $arrTypeMenu = array();
    private $arrActionExecute = array();
    private $arrMenuSystem = array();

    private $templateRoot = DIR_PRO_BACKEND . '.ProviceDistrict.';
    private $routerIndex = 'proviceDistrict.index';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new Province();
        $this->modelDetail = new PermissionGroupDetail();
        $this->arrDefineCode = [];
        $this->arrIsActive = $this->getArrOptionTypeDefine(DEFINE_TRANG_THAI);
        $this->arrTypeMenu = $this->getArrOptionTypeDefine(DEFINE_TYPE_MENU);
        $this->arrActionExecute = $this->getArrOptionTypeDefine(DEFINE_PERMISSION_ACTION);
        $this->arrMenuSystem = app(MenuSystem::class)->getListMenuPermission();
    }

    private function _outDataView($request, $data)
    {
        $optionIsActive = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrIsActive, isset($data['status']) ? $data['status'] : STATUS_INT_MOT);

        $formId = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        $this->shareListPermission($this->routerIndex);//lay quyen theo ajax
        return $this->dataOutCommon = [
            'optionIsActive' => $optionIsActive,
            'arrActionExecute' => $this->arrActionExecute,

            'form_id' => $formId,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,

            'urlIndex' => URL::route($this->routerIndex),
            'urlGetData' => URL::route('proviceDistrict.ajaxGetData'),
            'urlPostData' => URL::route('proviceDistrict.ajaxPostData'),
        ];
    }

    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'QL tỉnh thành, quận huyện';
        $limit = CGlobal::number_show_20;
        $page_no = (int)Request::get('page_no', 1);
        $offset = ($page_no - 1) * $limit;

        $search['page_no'] = $page_no;
        $search['limit'] = $limit;
        $search['status'] = trim(addslashes(Request::get('status', STATUS_INT_MOT)));
        $search['p_keyword'] = trim(addslashes(Request::get('p_keyword', '')));

        $result = $this->modelObj->searchByCondition($search, $limit,$offset);
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
                $arrMenuSystem = $this->arrMenuSystem[CGlobal::project_code];
                $arrChooseMenu = $arrCheckMenu = [];
                if($objectId > STATUS_INT_KHONG){
                    $dataDetail = $this->modelObj->getItemById($objectId);
                    $dataDetail = ($dataDetail) ? $dataDetail->toArray() : false;

                    $groupDetail = $this->modelDetail->getPermissDetailWithGroupId($dataDetail['group_id']);
                    if($groupDetail){
                        foreach ($groupDetail as $k =>$gdetail){
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
            return Response::json(returnError(MSG_PERMISSION_ERROR));
        }
        $request = $_POST;
        $arrAjax = array('success' => 0, 'html' => '', 'msg' => '');
        $actionUpdate = 'actionUpdate';
        $actionUpdate = isset($request['dataForm']['actionUpdate']) ? $request['dataForm']['actionUpdate'] : (isset($request['actionUpdate']) ? $request['actionUpdate'] : $actionUpdate);

        switch ($actionUpdate) {
            case 'updateData':
                $dataForm = isset($request['dataForm']) ? $request['dataForm'] : [];
                $objectId = isset($dataForm['objectId'])? $dataForm['objectId']:STATUS_INT_KHONG;
                $idNew = $this->modelObj->editItem($dataForm,$objectId);
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
            case 'getDistrictByProviceId':
                $object_id = isset($request['object_id']) ? $request['object_id'] : STATUS_INT_KHONG;
                $dataDistrict = $this->modelObj->getDistrictByProviceId($object_id);
                $divShowChild = 'groupListDistrict'.$object_id;

                $this->_outDataView($request, []);
                $htmlView = View::make($this->templateRoot . 'component._listChildDistrict')
                    ->with(array_merge($this->dataOutCommon,[
                        'dataDistrict' => $dataDistrict,
                        'object_id' => $object_id,
                    ]))->render();

                $arrAjax['success'] = 1;
                $arrAjax['divShowChild'] = $divShowChild;
                $arrAjax['html'] = $htmlView;
                break;

            case 'getWardsByDistrictId':
                $object_id = isset($request['object_id']) ? $request['object_id'] : STATUS_INT_KHONG;
                $dataWards = $this->modelObj->getWardsByDistrictsId($object_id);
                $divShowChild = 'groupListWards'.$object_id;

                $this->_outDataView($request, []);
                $htmlView = View::make($this->templateRoot . 'component._listChildWards')
                    ->with(array_merge($this->dataOutCommon,[
                        'dataWards' => $dataWards,
                        'object_id' => $object_id,
                    ]))->render();

                $arrAjax['success'] = 1;
                $arrAjax['divShowChild'] = $divShowChild;
                $arrAjax['html'] = $htmlView;
                break;
            default:
                break;
        }
        return Response::json($arrAjax);
    }

    public function ajaxGetData()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_VIEW, PERMISS_ADD, PERMISS_EDIT],$this->routerIndex)) {
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
}
