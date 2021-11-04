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
use App\Models\BackendCms\PermissionGroup;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class BackendPermissGroupController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrIsActive = array();
    private $arrDefineCode = array();
    private $arrTypeMenu = array();
    private $arrActionExecute = array();

    private $templateRoot = DIR_PRO_BACKEND . '.PermissGroup.';
    private $routerIndex = 'permissGroup.index';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new PermissionGroup();
        $this->arrDefineCode = [];
        $this->arrIsActive = $this->getArrOptionTypeDefine(DEFINE_TRANG_THAI);
        $this->arrTypeMenu = $this->getArrOptionTypeDefine(DEFINE_TYPE_MENU);
        $this->arrActionExecute = $this->getArrOptionTypeDefine(DEFINE_PERMISSION_ACTION);
    }

    private function _outDataView($request, $data)
    {
        $optionIsActive = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrIsActive, isset($data['is_active']) ? $data['is_active'] : STATUS_INT_MOT);
        $optionDefineCode = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrDefineCode, isset($data['define_code']) ? $data['define_code'] : DEFINE_NULL);
        $projectCode = isset($data['project_code']) ? $data['project_code']: STATUS_INT_HAI;
        $optionTypeMenu = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrTypeMenu, $projectCode);

        $formId = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        $this->shareListPermission($this->routerIndex);//lay quyen theo ajax
        return $this->dataOutCommon = [
            'optionDefineCode' => $optionDefineCode,
            'optionIsActive' => $optionIsActive,
            'optionTypeMenu' => $optionTypeMenu,

            'form_id' => $formId,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,

            'urlIndex' => URL::route($this->routerIndex),
            'urlGetData' => URL::route('permissGroup.ajaxGetData'),
            'urlPostData' => URL::route('permissGroup.ajaxPostData'),
        ];
    }

    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Permission group';
        $limit = CGlobal::number_show_20;
        $page_no = (int)Request::get('page_no', 1);
        $search['page_no'] = $page_no;
        $search['limit'] = $limit;
        $search['define_code'] = trim(addslashes(Request::get('define_code', '')));
        $search['define_name'] = trim(addslashes(Request::get('define_name', '')));

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
        ], $this->dataOutCommon));
    }

    public function ajaxGetData()
    {
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
        $request = $_POST;
        $arrAjax = array('success' => 0, 'html' => '', 'msg' => '');
        $actionUpdate = 'actionUpdate';
        $actionUpdate = isset($request['dataForm']['actionUpdate']) ? $request['dataForm']['actionUpdate'] : (isset($request['actionUpdate']) ? $request['actionUpdate'] : $actionUpdate);

        switch ($actionUpdate) {
            case 'updateData':
                $dataForm = isset($request['dataForm']) ? $request['dataForm'] : [];
                //myDebug($dataForm,false);
                $objectId = isset($dataForm['objectId'])? $dataForm['objectId']:STATUS_INT_KHONG;
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
            case 'uploadFilesClaim':
                $file_key = $request['FILE_KEY'];
                $relationship = $request['RELATIONSHIP'];
                $type_of_paper = isset($request['TYPE_OF_PAPER']) ? 1 : 0;
                $dataClaim = isset($request['detailClaim']) ? json_decode($request['detailClaim'], true) : false;
                $itemList = isset($request['itemList']) ? json_decode($request['itemList'], true) : false;

                $dataUpdateFile = [
                    'ORG_CODE' => isset($dataClaim['ORG_CODE']) ? $dataClaim['ORG_CODE'] : '',
                    'PRODUCT_CODE' => isset($dataClaim['PRODUCT_CODE']) ? $dataClaim['PRODUCT_CODE'] : '',
                    'CHANNEL' => isset($dataClaim['CHANNEL']) ? $dataClaim['CHANNEL'] : '',
                    'CLAIM_CODE' => isset($dataClaim['CLAIM_CODE']) ? $dataClaim['CLAIM_CODE'] : '',
                    'RELATIONSHIP' => $relationship,
                    'ARR_FILES' => [],
                ];

                $arrFilesUpdate = [];
                $folder = FOLDER_FILE_CLAIM;
                $ext_file = 'jfif,jpeg,png,tif,psd,pdf,eps,ai,heic,raw,svg';
                $max_file_size = 10000000;//10.000.000
                $arrFile = app(Upload::class)->uploadMultipleFile('filesClaim', $folder, $ext_file, $max_file_size);
                if (!empty($arrFile)) {
                    foreach ($arrFile as $ky => $fileName) {
                        if (trim($fileName) != '') {
                            $pathFileUpload = getDirFile($fileName);
                            $file_id = app(ServiceCommon::class)->moveFileToServerStore($pathFileUpload, false);
                            app(Upload::class)->removeFile('', $fileName);
                            $inforFiles = [
                                'FILE_KEY' => $file_key,
                                'FILE_NAME' => $fileName,
                                'FILE_ID' => $file_id,
                                'TYPE_OF_PAPER' => $type_of_paper,
                            ];
                            $arrFilesUpdate[$ky] = $inforFiles;
                        }
                        sleep(2);
                    }
                } else {
                    return Response::json(returnError(viewLanguage('Upload file ko đúng định dạng: ' . $ext_file)));
                }

                $dataUpdateFile['ARR_FILES'] = $arrFilesUpdate;
                $result = $this->modelObj->updateContactOrFilesAttack(2, $dataUpdateFile);

                if (isset($result['Success']) && $result['Success'] == 1) {
                    $p_org_code = isset($dataClaim['ORG_CODE']) ? $dataClaim['ORG_CODE'] : '';
                    $p_product_code = isset($dataClaim['PRODUCT_CODE']) ? $dataClaim['PRODUCT_CODE'] : '';
                    $p_claim_code = isset($dataClaim['CLAIM_CODE']) ? $dataClaim['CLAIM_CODE'] : '';

                    $inforClaim = $this->_getDataClaim($p_claim_code, $p_product_code, $p_org_code);
                    $detailClaim = $inforClaim['detailClaim'];
                    $listFileAttack = $inforClaim['listFileAttack'];

                    $this->_outDataView($request, (array)[]);
                    $templateOut = $this->templateRoot . 'component._tableFilesAttack';
                    $htmlView = View::make($templateOut)
                        ->with(array_merge([
                            'data' => $detailClaim,
                            'itemList' => $itemList,//data from list data
                            'listFileAttack' => $listFileAttack,
                        ], $this->dataOutCommon))->render();
                    $arrAjax['success'] = 1;
                    $arrAjax['html'] = $htmlView;
                    $arrAjax['divShowInfor'] = $request['divShowDataSuccess'];
                }
                break;
            case 'updateApproveStatus':
                $dataForm = isset($request['dataForm']) ? $request['dataForm'] : [];
                $actionApprove = isset($dataForm['actionApprove']) ? $dataForm['actionApprove'] : [];
                $reasonApprove = isset($dataForm['REASON_APPROVE']) ? $dataForm['REASON_APPROVE'] : [];
                $dataClaim = isset($dataForm['dataClaim']) ? json_decode($dataForm['dataClaim'], true) : false;
                $dataItem = isset($dataForm['dataItem']) ? json_decode($dataForm['dataItem'], false) : false;

                $claim_status_first = $claim_status = $dataClaim['STATUS'];
                switch ($actionApprove) {
                    /**
                     * Đồng ý bồi thường chờ LĐ ban duyệt
                     * Duyệt : DYCB => duyệt =>DYCC
                     * Từ chối: DYCB => từ chối =>TCBB
                     *
                     * Từ chối bồi thường chờ LĐ ban duyệt
                     * Duyệt : TCCB => duyệt =>TCCC
                     * Từ chối: TCCB => từ chối =>TCBB
                     */
                    case 'approveSuccessDepart':
                        $claim_status = ($claim_status_first == STATUS_CLAIM_DYCB) ? STATUS_CLAIM_DYCC : STATUS_CLAIM_TCCC;
                        break;
                    case 'approveCancelDepart':
                        $claim_status = STATUS_CLAIM_TCBB;
                        break;
                    /**
                     * Đồng ý bồi thường chờ LĐ Cty duyệt
                     * Duyệt : DYCC => duyệt =>DYKH
                     * Từ chối: DYCC => từ chối =>TCBC
                     *
                     * Từ chối bồi thường chờ LĐ Cty duyệt
                     * Duyệt : TCCC => duyệt =>TCKH
                     * Từ chối: TCCC => từ chối =>TCBC
                     */
                    case 'approveSuccessCompany':
                        $claim_status = ($claim_status_first == STATUS_CLAIM_DYCC) ? STATUS_CLAIM_DYKH : STATUS_CLAIM_TCKH;
                        break;
                    case 'approveCancelCompany':
                        $claim_status = STATUS_CLAIM_TCBC;
                        break;
                    default:
                        break;
                }

                $dataApprovel['p_org_code'] = $dataClaim['ORG_CODE'];
                $dataApprovel['p_prodcode'] = $dataClaim['PRODUCT_CODE'];
                $dataApprovel['p_claim_code'] = $dataClaim['CLAIM_CODE'];
                $dataApprovel['p_claim_status'] = $claim_status;
                $dataApprovel['p_staffcode'] = $this->user['user_id'];
                $dataApprovel['p_staffname'] = $this->user['user_full_name'];
                $dataApprovel['p_content'] = $reasonApprove;
                $dataApprovel['p_pay_date'] = '';
                $dataApprovel['p_pay_claim'] = '';

                $result = $this->modelObj->updateChangeProcess($dataApprovel);
                if (isset($result['Data'][0][0]->TYPE) && $result['Data'][0][0]->TYPE == 'SUCCESS') {

                    //gửi mail nếu có
                    $this->_sendEmailClaim($claim_status, $dataItem, ['note' => $reasonApprove]);

                    $arrAjax['success'] = 1;
                    $arrAjax['html'] = '';
                    $arrAjax['loadPage'] = 1;
                }
                break;
            default:
                break;
        }
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
