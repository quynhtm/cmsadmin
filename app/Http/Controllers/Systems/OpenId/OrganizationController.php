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
use App\Models\OpenId\Organization;
use App\Models\OpenId\Province;
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

class OrganizationController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrType = array();
    private $arrMode = array();
    private $arrOrg = array();

    private $arrProvince = array();
    private $arrDistrict = array();
    private $arrWard = array();

    private $templateRoot = DIR_PRO_SYSTEM.'/'.DIR_MODULE_OPENID . '.organization.';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new Organization();

        $this->arrMode = $this->getArrOptionTypeDefine(DEFINE_ORG_MODE);
        $this->arrType = $this->getArrOptionTypeDefine(DEFINE_ORG_TYPE);
        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_STATUS);

        $this->arrOrg = $this->modelObj->getArrOptionOrg();
        $this->arrProvince = app(Province::class)->getOptionProvince();
    }

    private function _outDataView($request, $data)
    {
        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['IS_ACTIVE']) ? $data['IS_ACTIVE'] : STATUS_INT_MOT);
        $optionType = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrType, isset($data['ORG_TYPE']) ? $data['ORG_TYPE'] : '');
        $optionMode = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrMode, isset($data['ORG_MODE']) ? $data['ORG_MODE'] : '');
        $optionOrg = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrOrg, isset($data['PARENT_CODE']) ? $data['PARENT_CODE'] : '');

        $provice_code = isset($data['PROVINCE_CODE']) ? $data['PROVINCE_CODE'] : '';
        $district_code = isset($data['DISTRICT_CODE']) ? $data['DISTRICT_CODE'] : '';
        $optionProvince = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProvince, $provice_code);
        $this->arrDistrict = trim($provice_code) != ''?app(Province::class)->getOptionDistrict($provice_code): $this->arrDistrict;
        $this->arrWard = trim($district_code) != ''?app(Province::class)->getOptionWard($district_code):$this->arrWard;
        $optionDistrict = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrDistrict, $district_code);
        $optionWard = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrWard, isset($data['WARD_CODE']) ? $data['WARD_CODE'] : '');

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'optionType' => $optionType,
            'optionMode' => $optionMode,
            'optionOrg' => $optionOrg,

            'optionProvince' => $optionProvince,
            'optionDistrict' => $optionDistrict,
            'optionWard' => $optionWard,

            'arrStatus' => $this->arrStatus,
            'arrMode' => $this->arrMode,
            'arrType' => $this->arrType,
            'arrOrg' => $this->arrOrg,

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'urlAjaxGetData' => URL::route('organization.ajaxGetData'),
            'urlDeleteOtherItem' => URL::route('organization.ajaxDeleteOrgRelation'),
            'url_action' => URL::route('organization.ajaxPostOrganization'),
            'url_action_other_item' => URL::route('organization.ajaxUpdateOrgRelation'),
            'functionAction' => '_ajaxGetOrgItem',
        ];
    }

    private function _validFormData($active = STATUS_INT_KHONG, &$data = array())
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
            $itemExits = $this->modelObj->getOrganizationByKey($data['ORG_CODE']);
            if ($itemExits) {
                if ($itemExits->IS_ACTIVE == STATUS_INT_MOT && $active == STATUS_INT_KHONG) {
                    $this->error[] = 'Đã tồn tại tổ chức này';
                } elseif ($itemExits->IS_ACTIVE == STATUS_INT_KHONG && $active == STATUS_INT_KHONG) {
                    $data['IS_ACTIVE'] = STATUS_INT_MOT;
                    $data['objectId'] = STATUS_INT_MOT;
                }
            }
        }
        return true;
    }

    /*********************************************************************************************************
     * Danh mục tổ chức: ORGANIZATION
     *********************************************************************************************************/
    public function indexOrganization()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Danh mục tổ chức';
        $page_no = (int)Request::get('page_no', 1);

        $search['ORG_TYPE'] = addslashes(Request::get('ORG_TYPE', ''));
        $search['IS_ACTIVE'] = addslashes(Request::get('IS_ACTIVE', STATUS_INT_MOT));
        $search['p_keyword'] = addslashes(Request::get('p_keyword', ''));
        $search['p_org_type'] = $search['ORG_TYPE'];
        $search['p_is_active'] = $search['IS_ACTIVE'];
        $search['page_no'] = $page_no;

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchOrganization($search);
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data']['data'] ?? $dataList;
            $total = $result['Data']['total'] ?? $total;
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'viewOrganization', array_merge([
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,

            'pageTitle' => $this->pageTitle,
            'urlIndex' => URL::route('organization.indexOrganization'),
            'urlGetItem' => URL::route('organization.ajaxGetOrganization'),
            'urlDeleteItem' => URL::route('organization.ajaxDeleteOrganization'),
        ], $this->dataOutCommon));
    }

    public function ajaxGetOrganization()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_GET;
        $arrAjax = $this->_getInfoOrg($request);
        return Response::json($arrAjax);
    }

    private function _getInfoOrg($request)
    {
        $objectId = $request['objectId'] ?? 0;
        $data = [];
        $listTabBank = false;
        if ($objectId > 0) {
            $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
            $org_code = isset($dataInput->item) ? $dataInput->item->ORG_CODE : '';
            $data = $this->modelObj->getOrganizationByKey($org_code);
            //lay dư liệu tab bank default
            if ($data) {
                $page_no = isset($request['page_no']) ? $request['page_no'] : STATUS_INT_MOT;
                $limit = CGlobal::number_show_10;
                $search = [];
                $pagingItem = '';
                $tabBank = $this->modelObj->getDataRelationByOrgCode($data->ORG_CODE, 'B', $page_no);
                if (isset($tabBank['Success']) && $tabBank['Success'] == STATUS_INT_MOT) {
                    $listTabBank = $tabBank['Data']['data'];
                    $tolalList = $tabBank['Data']['total'];
                    $pagingItem = $tolalList > 0 ? Pagging::getNewPager(3, $page_no, $tolalList, $limit, $search) : '';
                }

                $row_id = 'row_bank_id_';
                $buttonAdd = 'buttonAddBank';
                $listBank = app(Banks::class)->getArrOptionBank();
                $disabled = $arrBank = [];
                if ($listBank) {
                    foreach ($listBank as $parentBank => $bank) {
                        $disabled[] = $parentBank;
                        foreach ($bank as $bcode => $bname) {
                            $arrBank[$bcode] = $bname;
                        }
                    }
                }
                $optionBank = FunctionLib::getOption(['' => '---Chọn---'] + $arrBank, (isset($inforItem->BANK_CODE) ? $inforItem->BANK_CODE : ''), $disabled);
                $this->dataOutItem = [
                    'actionEdit' => 0,//0: thêm mới, 1: edit
                    'row_id' => $row_id,
                    'item_id' => '',
                    'obj_id' => $data->ORG_CODE,
                    'typeTab' => 'orgBank',
                    'divShowId' => 'tab-content-1',
                    'buttonAdd' => $buttonAdd,
                    'titleForm' => 'Thông tin tài khoản ngân hàng',
                    'optionBank' => $optionBank,
                    'arrBank' => $arrBank,
                    'listTabBank' => $listTabBank,
                    'pagingItem' => $pagingItem,
                ];
            }
        }
        $this->_outDataView($request, (array)$data);
        $html = View::make($this->templateRoot . 'component.organization.popupDetail')
            ->with(array_merge([
                'data' => $data,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $divShowInfor = isset($request['divShowInfor']) ? $request['divShowInfor'] : 'formShowEditSuccess';//div show infor item
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor);
        return $arrAjax;
    }

    public function ajaxPostOrganization()
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
            $dataForm['EFFECTIVE_DATE'] = '';
            $dataForm['EXPIRATION_DATE'] = '';
            $dataForm['IS_ACTIVE'] = STATUS_INT_MOT;
            $dataForm['DISPLAY_CODE'] = $dataForm['ORG_CODE'];
            $id = $dataForm['objectId'] ?? 0;
            $result = $this->modelObj->editOrganization($dataForm, ($id > 0) ? 'EDIT' : 'ADD');
            if ($result['Success'] == STATUS_INT_MOT) {

                //EDIT: lấy lại dữ liệu đã cập nhật để hiển thị lại
                if ($id > 0) {
                    $request = $dataForm;
                    $request['formName'] = $dataForm['formName'];
                    $this->_outDataView($request, $dataForm);
                    $html = View::make($this->templateRoot . 'component.organization._detailFormOrg')
                        ->with(array_merge([
                            'data' => (object)$dataForm,
                            'url_action' => URL::route('organization.ajaxPostOrganization'),
                        ], $this->dataOutCommon))->render();
                    $divShowInfor = isset($request['divShowInfor']) ? $request['divShowInfor'] : 'formShowEditSuccess';//div show infor item
                    $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor);
                } //ADD: thêm mới thì load lại dư liệu để nhập các thông tin khác
                else {
                    $request['objectId'] = 1;
                    $request['divShowInfor'] = 'divDetailItem';
                    $request['dataInput'] = json_encode(['item' => $dataForm]);
                    $arrAjax = $this->_getInfoOrg($request);
                }
                return Response::json($arrAjax);
            } else {
                return Response::json(returnError($result['Message']));
            }
        } else {
            return Response::json(returnError($this->error));
        }
    }

    public function ajaxDeleteOrganization()
    {
        if (!$this->checkMultiPermiss([PERMISS_REMOVE])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_POST;
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
        $dataItem = isset($dataInput->item) ? (array)$dataInput->item : false;

        if (!empty($dataItem)) {
            $result = $this->modelObj->deleteOrganization($dataItem);
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
     * Các quan hệ của tổ chức
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

    private function _ajaxGetOrgItem($request)
    {
        $data = $inforItem = [];
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'], true) : false;
        $formEdit = isset($dataInput['formEdit']) ? $dataInput['formEdit'] : STATUS_INT_KHONG;//1: get form edit, 0: list other with code
        $typeTab = isset($dataInput['type']) ? $dataInput['type'] : '';
        $item_obj = isset($dataInput['item_id']) ? $dataInput['item_id'] : '';
        $arrKey = isset($dataInput['arrKey']) ? $dataInput['arrKey'] : [];
        $actionEdit = STATUS_INT_KHONG;

        $obj_id = $request['objectId'];
        $divShowId = $request['divShowId'];
        $row_id = '';
        $functionAction = isset($request['functionAction']) ? $request['functionAction'] : '';
        $buttonAdd = '';
        $titleForm = 'Thông tin';
        $tolalList = 0;
        $pagingItem = '';
        $page_no = isset($request['page_no']) ? $request['page_no'] : STATUS_INT_MOT;
        $limit = CGlobal::number_show_10;
        $stt = ($page_no - 1) * $limit;

        switch ($typeTab) {
            case 'orgBank':
                $row_id = 'row_bank_id_';
                $buttonAdd = 'buttonAddBank';

                if ($formEdit == STATUS_INT_KHONG) {//get data list
                    $search['page_no'] = 1;
                    $banks = $this->modelObj->getDataRelationByOrgCode($obj_id, 'B', $page_no);
                    if (isset($banks['Success']) && $banks['Success'] == STATUS_INT_MOT) {
                        $data = $banks['Data']['data'];
                        $tolalList = $banks['Data']['total'];
                        $pagingItem = $tolalList > 0 ? Pagging::getNewPager(3, $page_no, $tolalList, $limit, $search) : '';
                    }

                    $titleForm = 'Thông tin tài khoản ngân hàng';
                } else {
                    if (trim($item_obj) != '' && trim($obj_id) != '') {
                        $inforItem = $this->modelObj->getOrgBankByKey($obj_id, $item_obj);
                    }
                    $actionEdit = STATUS_INT_MOT;
                    $divShowId = 'tab-content-1';
                    $titleForm = 'Sửa tài khoản ngân hàng';
                }
                $listBank = app(Banks::class)->getArrOptionBank();
                $disabled = $arrBank = [];
                if ($listBank) {
                    foreach ($listBank as $parentBank => $bank) {
                        $disabled[] = $parentBank;
                        foreach ($bank as $bcode => $bname) {
                            $arrBank[$bcode] = $bname;
                        }
                    }
                }
                $optionBank = FunctionLib::getOption(['' => '---Chọn---'] + $arrBank, (isset($inforItem->BANK_CODE) ? $inforItem->BANK_CODE : ''), $disabled);
                $this->dataOutItem = [
                    'optionBank' => $optionBank,
                    'arrBank' => $arrBank,
                ];
                break;
            case 'orgContract':
                $row_id = 'row_contract_id_';
                $buttonAdd = 'buttonAddContract';
                if ($formEdit == STATUS_INT_KHONG) {//get data list

                    $search['page_no'] = 1;
                    $contract = $this->modelObj->getDataRelationByOrgCode($obj_id, 'C', $page_no);
                    if (isset($contract['Success']) && $contract['Success'] == STATUS_INT_MOT) {
                        $data = $contract['Data']['data'];
                        $tolalList = $contract['Data']['total'];
                        $pagingItem = $tolalList > 0 ? Pagging::getNewPager(3, $page_no, $tolalList, $limit, $search) : '';
                    }
                    $titleForm = 'Thông tin hợp đồng';
                } else {
                    $orgPartnerCode = isset($arrKey['ORG_PARTNER_CODE']) ? $arrKey['ORG_PARTNER_CODE'] : '';
                    $structNo = isset($arrKey['STRUCT_NO']) ? $arrKey['STRUCT_NO'] : '';
                    if (trim($orgPartnerCode) != '' && trim($structNo) != '' && trim($obj_id) != '') {
                        $inforItem = $this->modelObj->getOrgContractsByKey($obj_id, $orgPartnerCode, $structNo);
                    }
                    $actionEdit = STATUS_INT_MOT;
                    $divShowId = 'tab-content-2';
                    $titleForm = 'Sửa hợp đồng';
                }
                $optionOrgParent = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrOrg, (isset($inforItem->ORG_PARTNER_CODE) ? $inforItem->ORG_PARTNER_CODE : ''));
                $this->dataOutItem = [
                    'optionOrgParent' => $optionOrgParent,
                    'arrOrgParent' => $this->arrOrg,
                ];
                break;
            case 'orgStructs':
                $row_id = 'row_structs_id_';
                $buttonAdd = 'buttonAddStructs';
                if ($formEdit == STATUS_INT_KHONG) {//get data list
                    $search['page_no'] = 1;
                    $structs = $this->modelObj->getDataRelationByOrgCode($obj_id, 'S', $page_no);
                    if (isset($structs['Success']) && $structs['Success'] == STATUS_INT_MOT) {
                        $data = $structs['Data']['data'];
                        $tolalList = $structs['Data']['total'];
                        $pagingItem = $tolalList > 0 ? Pagging::getNewPager(3, $page_no, $tolalList, $limit, $search) : '';
                    }
                    $titleForm = 'Thông tin mô hình tổ chức';
                } else {
                    $orgType = isset($arrKey['ORG_TYPE']) ? $arrKey['ORG_TYPE'] : '';
                    $orgStruct = isset($arrKey['ORG_STRUCT']) ? $arrKey['ORG_STRUCT'] : '';
                    if (trim($orgType) != '' && trim($orgStruct) != '' && trim($obj_id) != '') {
                        $inforItem = $this->modelObj->getOrgStructsByKey($obj_id, $orgType, $orgStruct);
                    }
                    $actionEdit = STATUS_INT_MOT;
                    $divShowId = 'tab-content-3';
                    $titleForm = 'Sửa mô hình tổ chức';
                }
                $dataOrg = $this->modelObj->getOrganizationByKey($obj_id);
                $arrOrgStruct = [];
                if ($dataOrg) {
                    $arrOrgStruct = $this->getArrOptionTypeDefine($dataOrg->ORG_TYPE, DEFINE_PORTAL);
                }
                $optionOrgStruct = FunctionLib::getOption(['' => '---Chọn---'] + $arrOrgStruct, (isset($inforItem->ORG_STRUCT) ? $inforItem->ORG_STRUCT : ''));
                $this->dataOutItem = [
                    'optionOrgStruct' => $optionOrgStruct,
                    'arrOrgStruct' => $arrOrgStruct,
                    'dataOrg' => $dataOrg,
                ];
                break;
            case 'orgRelationship':
                $row_id = 'row_relationship_id_';
                $buttonAdd = 'buttonAddRelationship';
                if ($formEdit == STATUS_INT_KHONG) {//get data list
                    $search['page_no'] = 1;
                    $relationship = $this->modelObj->getDataRelationByOrgCode($obj_id, 'R', $page_no);
                    if (isset($relationship['Success']) && $relationship['Success'] == STATUS_INT_MOT) {
                        $data = $relationship['Data']['data'];
                        $tolalList = $relationship['Data']['total'];
                        $pagingItem = $tolalList > 0 ? Pagging::getNewPager(3, $page_no, $tolalList, $limit, $search) : '';
                    }
                    $titleForm = 'Thông tin quan hệ với tổ chức khác';
                } else {
                    if (trim($item_obj) != '' && trim($obj_id) != '') {
                        //myDebug($obj_id.'====='.$item_obj);
                        $inforItem = $this->modelObj->getOrgRelationshipByKey($obj_id, $item_obj);

                    }
                    $actionEdit = STATUS_INT_MOT;
                    $divShowId = 'tab-content-4';
                    $titleForm = 'Sửa quan hệ với tổ chức khác';
                }
                //sys_org
                $optionOrgParent = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrOrg, (isset($inforItem->ORG_CODE) ? $inforItem->ORG_CODE : ''));
                $this->dataOutItem = [
                    'optionOrgParent' => $optionOrgParent,
                    'arrOrg' => $this->arrOrg,
                ];
                break;
            default:
                break;
        }

        $templateOut = ($formEdit == STATUS_INT_MOT) ? $this->templateRoot . 'component.organization._detailFormOtherItem' : $this->templateRoot . 'component.organization._listsOtherItem';
        $this->_outDataView($request, (array)$data);
        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $data,
                'pagingItem' => $pagingItem,
                'stt' => $stt,
                'inforItem' => $inforItem,
                'actionEdit' => $actionEdit,//0: thêm mới, 1: edit
                'row_id' => $row_id,
                'item_id' => $item_obj,
                'obj_id' => $obj_id,
                'typeTab' => $typeTab,
                'divShowId' => $divShowId,
                'buttonAdd' => $buttonAdd,
                'titleForm' => $titleForm,
                'functionAction' => $functionAction,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        return $html;
    }

    public function ajaxUpdateOrgRelation()
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
        if ($this->_validFormDataOrgRelation($typeTabAction, $active, $dataForm) && empty($this->error)) {
            $actionUpdate = $this->_updateDataOrgRelation($dataForm, $typeTabAction);
            return $actionUpdate;
        } else {
            return Response::json(returnError($this->error));
        }
    }

    private function _validFormDataOrgRelation($typeTabAction = '', $active = STATUS_INT_KHONG, &$data = array())
    {
        switch ($typeTabAction) {
            case 'orgBank': //danh mục tổ chức
                if (!empty($data)) {
                    if (isset($data['BANK_HOLDER']) && trim($data['BANK_HOLDER']) == '') {
                        $this->error[] = 'Chủ tài khoản không được bỏ trống';
                    }
                    if (isset($data['BANK_ACCOUNT']) && trim($data['BANK_ACCOUNT']) == '') {
                        $this->error[] = 'Số tài khoản không được bỏ trống';
                    }
                    $itemExits = $this->modelObj->getOrgBankByKey($data['ORG_CODE'], $data['BANK_CODE']);
                    if ($itemExits) {
                        if ($itemExits->IS_ACTIVE == STATUS_INT_MOT && $active == STATUS_INT_KHONG) {
                            $this->error[] = 'Đã tồn tại Ngân hàng này';
                        } elseif ($itemExits->IS_ACTIVE == STATUS_INT_KHONG && $active == STATUS_INT_KHONG) {
                            $data['IS_ACTIVE'] = STATUS_INT_MOT;
                            $data['ACTION_FORM'] = STATUS_INT_MOT;
                        }
                    }
                }
                break;
            case 'orgContract':
                if (!empty($data)) {
                    if (isset($data['EFFECTIVE_DATE']) && trim($data['EFFECTIVE_DATE']) == '') {
                        $this->error[] = 'Ngày hiệu lực không được bỏ trống';
                    }
                    if (isset($data['ORG_PARTNER_CODE']) && trim($data['ORG_PARTNER_CODE']) == '') {
                        $this->error[] = 'Đối tác không được bỏ trống';
                    }
                    if (isset($data['STRUCT_NO']) && trim($data['STRUCT_NO']) == '') {
                        $this->error[] = 'Số hợp đồng không được bỏ trống';
                    }
                    $itemExits = $this->modelObj->getOrgContractsByKey($data['ORG_CODE'], $data['ORG_PARTNER_CODE'], $data['STRUCT_NO']);
                    if ($itemExits) {
                        if ($itemExits->IS_ACTIVE == STATUS_INT_MOT && $active == STATUS_INT_KHONG) {
                            $this->error[] = 'Đã tồn tại hợp đồng này';
                        } elseif ($itemExits->IS_ACTIVE == STATUS_INT_KHONG && $active == STATUS_INT_KHONG) {
                            $data['IS_ACTIVE'] = STATUS_INT_MOT;
                            $data['ACTION_FORM'] = STATUS_INT_MOT;
                        }
                    }
                }
                break;
            case 'orgStructs':
                if (!empty($data)) {
                    if (isset($data['ORG_LEVEL']) && trim($data['ORG_LEVEL']) == '') {
                        $this->error[] = 'Cấp độ không được bỏ trống';
                    }
                    if (isset($data['ORG_STRUCT']) && trim($data['ORG_STRUCT']) == '') {
                        $this->error[] = 'Thành phần tổ chức không được bỏ trống';
                    }
                    $itemExits = $this->modelObj->getOrgStructsByKey($data['ORG_CODE'], $data['ORG_TYPE'], $data['ORG_STRUCT']);
                    if ($itemExits) {
                        if ($itemExits->IS_ACTIVE == STATUS_INT_MOT && $active == STATUS_INT_KHONG) {
                            $this->error[] = 'Đã tồn tại mô hình tổ chức này';
                        } elseif ($itemExits->IS_ACTIVE == STATUS_INT_KHONG && $active == STATUS_INT_KHONG) {
                            $data['IS_ACTIVE'] = STATUS_INT_MOT;
                            $data['ACTION_FORM'] = STATUS_INT_MOT;
                        }
                    }
                }
                break;
            case 'orgRelationship':
                if (!empty($data)) {
                    if (isset($data['RELATIONSHIP_NAME']) && trim($data['RELATIONSHIP_NAME']) == '') {
                        $this->error[] = 'Mối quan hệ không được bỏ trống';
                    }
                    if (isset($data['ORG_CODE_PARENT']) && trim($data['ORG_CODE_PARENT']) == '') {
                        $this->error[] = 'Tổ chức không được bỏ trống';
                    }
                    $itemExits = $this->modelObj->getOrgRelationshipByKey($data['ORG_CODE'], $data['ORG_CODE_PARENT']);
                    if ($itemExits) {
                        if ($itemExits->IS_ACTIVE == STATUS_INT_MOT && $active == STATUS_INT_KHONG) {
                            $this->error[] = 'Đã tồn tại mối quan hệ với tổ chức này';
                        } elseif ($itemExits->IS_ACTIVE == STATUS_INT_KHONG && $active == STATUS_INT_KHONG) {
                            $data['IS_ACTIVE'] = STATUS_INT_MOT;
                            $data['ACTION_FORM'] = STATUS_INT_MOT;
                        }
                    }
                }
                break;
            default:
                break;
        }
        return true;
    }

    private function _updateDataOrgRelation($dataForm, $typeTabAction)
    {
        $active = (int)$dataForm['ACTION_FORM'];
        $result = returnError('Không đúng thao tác! Hãy thử lại');
        switch ($typeTabAction) {
            case 'orgBank':
                $result = $this->modelObj->editOrgBank($dataForm, ($active > 0) ? 'EDIT' : 'ADD');
                break;
            case 'orgContract':
                if (isset($_FILES['inputFile']) && count($_FILES['inputFile']) > 0 && $_FILES['inputFile']['name'] != '') {
                    $folder = FOLDER_FILE_ORG_CONTRACTS;;
                    $pathFileUpload = app(Upload::class)->uploadFile('inputFile', $folder, $dataForm['ORG_CODE']);
                    if (trim($pathFileUpload) != '') {
                        app(Upload::class)->removeFile($folder, $dataForm['DIR_PATH']);
                        $dataForm['DIR_PATH'] = $pathFileUpload;
                    }
                }
                $result = $this->modelObj->editOrgContracts($dataForm, ($active > 0) ? 'EDIT' : 'ADD');
                break;
            case 'orgStructs':
                $dataOrg = $this->modelObj->getOrganizationByKey($dataForm['ORG_CODE']);
                $arrOrgStruct = [];
                if ($dataOrg) {
                    $arrOrgStruct = $this->getArrOptionTypeDefine($dataOrg->ORG_TYPE, DEFINE_PORTAL);
                }
                $dataForm['ORG_STRUCT_NAME'] = isset($arrOrgStruct[$dataForm['ORG_STRUCT']]) ? $arrOrgStruct[$dataForm['ORG_STRUCT']] : '';
                $result = $this->modelObj->editOrgStructs($dataForm, ($active > 0) ? 'EDIT' : 'ADD');
                break;
            case 'orgRelationship':
                $result = $this->modelObj->editOrgRelationship($dataForm, ($active > 0) ? 'EDIT' : 'ADD');
                $request['objectId'] = $dataForm['ORG_CODE_PARENT'];
                break;
            default:
                break;
        }

        if ($result['Success'] == STATUS_INT_MOT) {
            //lấy lại dữ liệu list danh sach bank
            $dataInput['type'] = $dataForm['typeTabAction'];
            $dataInput['item_id'] = 0;
            $dataInput['formEdit'] = 0;
            $request['dataInput'] = json_encode($dataInput);
            $request['objectId'] = isset($request['objectId'])? $request['objectId']: $dataForm['ORG_CODE'];
            $request['divShowId'] = $dataForm['divShowIdAction'];

            $html = $this->_ajaxGetOrgItem($request);
            $arrAjax = array('success' => 1, 'message' => 'Successfully', 'divShowAjax' => $request['divShowId'], 'html' => $html);

            return Response::json($arrAjax);
        } else {
            return Response::json(returnError($result['Message']));
        }
    }

    public function ajaxDeleteOrgRelation()
    {
        if (!$this->checkMultiPermiss([PERMISS_REMOVE])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_POST;
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
        $dataItem = isset($dataInput->item) ? (array)$dataInput->item : false;
        $typeTab = isset($dataInput->typeTab) ? $dataInput->typeTab : '';
        $divShowId = isset($dataInput->divShowId) ? $dataInput->divShowId : '';

        if (!empty($dataItem) && trim($typeTab) != '' && trim($divShowId) != '') {
            switch ($typeTab) {
                case 'orgBank':
                    $result = $this->modelObj->deleteOrgBankByKey($dataItem);
                    break;
                case 'orgContract':
                    $result = $this->modelObj->deleteOrgContractsByKey($dataItem);
                    break;
                case 'orgStructs':
                    $result = $this->modelObj->deleteOrgStructsByKey($dataItem);
                    break;
                case 'orgRelationship':
                    $result = $this->modelObj->deleteOrgRelationshipByKey($dataItem);
                    break;
                default:
                    break;
            }

            if ($result['Success'] == STATUS_INT_MOT) {
                //lấy lại dữ liệu list danh sach bank
                $dataInput2['type'] = $typeTab;
                $dataInput2['item_id'] = 0;
                $dataInput2['formEdit'] = 0;
                $request['dataInput'] = json_encode($dataInput2);
                $request['objectId'] = $dataItem['ORG_CODE'];
                $request['divShowId'] = $divShowId;

                $html = $this->_ajaxGetOrgItem($request);
                $arrAjax = array('success' => 1, 'message' => 'Successfully', 'divShowAjax' => $request['divShowId'], 'html' => $html);

                return Response::json($arrAjax);
                //return Response::json(returnSuccess());
            } else {
                return Response::json(returnError($result['Message']));
            }
        } else {
            return Response::json(returnError('Dữ liệu không đúng'));
        }
    }
}
