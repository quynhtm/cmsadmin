<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Sellings\Inspection;

use App\Http\Controllers\BaseAdminController;
use App\Models\OpenId\Organization;
use App\Models\OpenId\Province;
use App\Models\OpenId\UserSystem;
use App\Models\Selling\Inspection;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use App\Services\ActionExcel;
use App\Services\ServiceCommon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class InspectionController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrProvince = array();
    private $arrHours = array();
    private $arrMinute = array();
    private $arrUser = array();
    private $arrSeller = array();

    private $arrOrgAll = array();
    private $arrProductType = array();
    private $arrProduct = array();

    private $templateRoot = DIR_PRO_SELLING . '/' . DIR_MODULE_INSPECTION . '.MotorVehicleInspection.';// giám định xe cơ giới

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';
    private $routerIndex = 'inspectionHdi.indexMotorVehicle';
    private $routerIndexApproval = 'inspectionHdi.indexApproval';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new Inspection();

        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_VEHICLE_INSPECTION_STATUS);
        $this->arrProvince = app(Province::class)->getOptionProvince();
        $this->arrMinute = getArrMinuteFull();
        $this->arrHours = CGlobal::$arrHours;
        $this->arrProduct = ['BAY_AT' => 'Bay an toàn'];
    }

    private function _outDataView($request, $data)
    {
        $arrPermissionInspection = app(ServiceCommon::class)->getGroupPermissonWithController(Route::currentRouteName());

        $this->arrSeller = $this->getInforUser('org');
        $optionSeller = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrSeller, isset($data['p_agency_code']) ? $data['p_agency_code'] : '');

        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['p_status']) ? $data['p_status'] : '');
        $optionProvince = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProvince, isset($data['p_provice_code']) ? $data['p_provice_code'] : '');

        $optionOrg = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrOrgAll, isset($data['p_org_code']) ? $data['p_org_code'] : '');
        $optionProduct = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProduct, isset($data['p_product_code']) ? $data['p_product_code'] : '');

        $optionStartHours = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrHours, isset($data['p_product_code']) ? $data['p_product_code'] : getTimeCurrent('h'));
        $optionStartMinute = FunctionLib::getOption($this->arrMinute, isset($data['p_product_code']) ? $data['p_product_code'] : '');
        $optionEndHours = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrHours, isset($data['p_product_code']) ? $data['p_product_code'] : getTimeCurrent('h'));
        $optionEndMinute = FunctionLib::getOption($this->arrMinute, isset($data['p_product_code']) ? $data['p_product_code'] : '');

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = (isset($request['objectId']) && trim($request['objectId']) != '0') ? 1 : 0;

        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'optionSeller' => $optionSeller,
            'optionProvince' => $optionProvince,
            'optionOrg' => $optionOrg,
            'optionProduct' => $optionProduct,
            'optionStartHours' => $optionStartHours,
            'optionStartMinute' => $optionStartMinute,
            'optionEndHours' => $optionEndHours,
            'optionEndMinute' => $optionEndMinute,

            'arrProductType' => $this->arrProductType,
            'arrStatus' => $this->arrStatus,
            'org_code_user' => $this->user['org_code'],
            'user_name_login' => $this->user['user_name'],
            'arrPermissionInspection' => json_encode($arrPermissionInspection,true),
            'product_code_vcx' => PRODUCT_CODE_XCG_VCX,

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route($this->routerIndex),
            'urlSearchAjax' => URL::route('inspectionHdi.getSearchAjax'),
            'formSeachIndex' => 'formSeachIndex',
            'urlGetItem' => URL::route('inspectionHdi.ajaxGetItem'),
            'urlPostItem' => URL::route('inspectionHdi.ajaxPostItem'),
            'urlAjaxGetData' => URL::route('inspectionHdi.ajaxGetData'),
            'urlUpdateCalendarInspection' => URL::route('inspectionHdi.ajaxUpdateCalendarInspection'),
            'userAction' => $this->user,
            'functionAction' => '_ajaxGetItemOther',
        ];
    }

    private function _buildParamSearch($arrDefault = [])
    {
        $search['p_org_code'] = (isset($arrDefault['p_org_code']) && trim($arrDefault['p_org_code']) != '') ? $arrDefault['p_org_code'] : trim(addslashes(Request::get('p_org_code', '')));
        $search['p_product_code'] = (isset($arrDefault['p_product_code']) && trim($arrDefault['p_product_code']) != '') ? $arrDefault['p_product_code'] : trim(addslashes(Request::get('p_product_code', 'XE')));

        $search['p_appointment_date'] = (isset($arrDefault['p_appointment_date']) && trim($arrDefault['p_appointment_date']) != '') ? $arrDefault['p_appointment_date'] : trim(addslashes(Request::get('p_appointment_date', '')));
        $search['p_number_plate'] = (isset($arrDefault['p_number_plate']) && trim($arrDefault['p_number_plate']) != '') ? $arrDefault['p_number_plate'] : trim(addslashes(Request::get('p_number_plate', '')));//số khung số máy
        $search['p_provice_code'] = (isset($arrDefault['p_provice_code']) && trim($arrDefault['p_provice_code']) != '') ? $arrDefault['p_provice_code'] : trim(addslashes(Request::get('p_provice_code', '')));//tỉnh thành
        $search['p_agency_code'] = (isset($arrDefault['p_agency_code']) && trim($arrDefault['p_agency_code']) != '') ? $arrDefault['p_agency_code'] : trim(addslashes(Request::get('p_agency_code', '')));//đại lý
        $search['p_status'] = (isset($arrDefault['p_status']) && trim($arrDefault['p_status']) != '') ? $arrDefault['p_status'] :trim(addslashes(Request::get('p_status', '')));//đại lý
        $page_no = (isset($arrDefault['page_no']) && trim($arrDefault['page_no']) != '') ? $arrDefault['page_no'] : (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 1);
        $search['page_no'] = ($submit == STATUS_INT_MOT) ? $page_no : STATUS_INT_KHONG;
        return $search;
    }

    /**
     * @return array
     * Lấy danh sách nhân viên giám định
     */
    private function _getStaffInspection()
    {
        $search['p_is_active'] = 1;
        $search['p_org_code'] = isset($this->user['org_code']) ? $this->user['org_code'] : 'ALL';//$search['ORG_CODE'];
        $search['p_struct_code'] = isset($this->user['user_depart_id']) ? $this->user['user_depart_id'] : 'ALL';
        $search['p_user_type'] = '';
        $search['page_no'] = 0;
        $result = app(UserSystem::class)->searchUser($search);
        $dataList = $arrUser = [];
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data']['data'] ?? [];
        }
        if (!empty($dataList)) {
            foreach ($dataList as $key => $use) {
                $arrUser[$use->USER_CODE] = $use->FULL_NAME;
            }
        }
        return $arrUser;
    }

    /*********************************************************************************************************
     * Danh sách Giám định xe cơ giới
     *********************************************************************************************************/
    public function indexMotorVehicle()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }

        $this->pageTitle = CGlobal::$pageAdminTitle = 'Giám định xe cơ giới';
        CGlobal::$pageAdminTitle = $this->pageTitle . ' - Cấp đơn ' . CGlobal::$arrTitleProject[$this->tab_top];
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 0);

        $search = $this->_buildParamSearch();
        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchInspectionHdi($search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data'][0] ?? $dataList;
            $total = isset($dataList[0]->TOTAL) ? $dataList[0]->TOTAL : $total;
        }

        if ($submit == STATUS_INT_HAI) {
            $dataExcel = ['data' => $dataList, 'total' => $total];
            $this->actionExcel = new ActionExcel();
            $this->actionExcel->exportExcel($dataExcel, ActionExcel::EXPORT_EXCEL_CLAIM_HDI);
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
            'routerName' => $this->routerIndex,
        ], $this->dataOutCommon));
    }
    public function getSearchAjax()
    {
        $request = $_GET;
        $dataForm = $request['dataForm'];
        $routerIndex = (isset($dataForm['routerIndex']) && trim($dataForm['routerIndex']) != '') ? $dataForm['routerIndex'] : $this->routerIndex;
        if (!$this->checkMultiPermiss([PERMISS_VIEW, PERMISS_EDIT],$routerIndex)) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }

        $div_show = (isset($dataForm['div_show']) && trim($dataForm['div_show']) != '') ? $dataForm['div_show'] : '';
        $_tableView = (isset($dataForm['_tableView']) && trim($dataForm['_tableView']) != '') ? $dataForm['_tableView'] : '_tableData';
        $page_no = (isset($dataForm['page_no']) && trim($dataForm['page_no']) != '') ? $dataForm['page_no'] : STATUS_INT_MOT;
        $search = $this->_buildParamSearch($dataForm);

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchInspectionHdi($search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data'][0] ?? $dataList;
            $total = isset($dataList[0]->TOTAL) ? $dataList[0]->TOTAL : $total;
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        $templateOut = $this->templateRoot . 'component.'.$_tableView;

        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $dataList,
                'search' => $search,
                'total' => $total,
                'stt' => ($page_no - 1) * $limit,
                'paging' => $paging,
                'pageTitle' => $this->pageTitle,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowId' => $div_show, 'message' => '');
        return Response::json($arrAjax);
    }

    /*********************************************************************************************************
     * Danh sách giám định Đang chờ phê duyệt
     *********************************************************************************************************/
    public function indexApproval()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }

        $this->pageTitle = CGlobal::$pageAdminTitle = 'Phê duyệt giám định';
        CGlobal::$pageAdminTitle = $this->pageTitle . CGlobal::$arrTitleProject[$this->tab_top];
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 0);

        $arrDefault['p_status'] = 'DGD';//Đã giám định
        $search = $this->_buildParamSearch($arrDefault);

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchInspectionHdi($search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data'][0] ?? $dataList;
            $total = isset($dataList[0]->TOTAL) ? $dataList[0]->TOTAL : $total;
        }

        if ($submit == STATUS_INT_HAI) {
            $dataExcel = ['data' => $dataList, 'total' => $total];
            $this->actionExcel = new ActionExcel();
            $this->actionExcel->exportExcel($dataExcel, ActionExcel::EXPORT_EXCEL_CLAIM_HDI);
        }

        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';
        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'viewApproval', array_merge($this->dataOutCommon,[
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
            'urlIndex' => URL::route('inspectionHdi.indexApproval'),
            'routerName' => $this->routerIndexApproval,
        ]));
    }

    /**************************************************
     * Get data
     * ************************************************/
    public function ajaxGetData()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW],$this->routerIndex)) {
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

    /*
     * Function action Ọther
     * */
    private function _ajaxActionOther($request)
    {
        $data = $inforItem = $listNotPayment = [];
        $formNameOther = isset($request['formName']) ? $request['formName'] : 'formName';
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'], true) : false;
        $typeTab = isset($dataInput['type']) ? $dataInput['type'] : '';
        $dataItem = isset($dataInput['dataItem']) ? $dataInput['dataItem'] : [];
        $objectId = $request['objectId'];
        $templateOut = $this->templateRoot . 'component._popupChangeStatus';
        $this->_outDataView($request, (array)$dataItem);

        switch ($typeTab) {
            //get popup chuyển đổi  trạng thái
            case 'getCalendarInspection':
                $arrStart = (isset($dataItem['TIME_F']) && trim($dataItem['TIME_F']) != '') ? explode(':', trim($dataItem['TIME_F'])) : [];
                $optionStartHours = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrHours, isset($arrStart[0]) ? $arrStart[0] : getTimeCurrent('h'));
                $optionStartMinute = FunctionLib::getOption($this->arrMinute, isset($arrStart[1]) ? $arrStart[1] : '');

                $arrEnd = (isset($dataItem['TIME_T']) && trim($dataItem['TIME_T']) != '') ? explode(':', trim($dataItem['TIME_T'])) : [];
                $optionEndHours = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrHours, isset($arrEnd[0]) ? $arrEnd[0] : getTimeCurrent('h'));
                $optionEndMinute = FunctionLib::getOption($this->arrMinute, isset($arrEnd[1]) ? $arrEnd[1] : '');

                $provice_code = isset($dataItem['PROV']) ? $dataItem['PROV'] : '';
                $district_code = isset($dataItem['DIST']) ? $dataItem['DIST'] : '';
                $this->arrDistrict = trim($provice_code) != '' ? app(Province::class)->getOptionDistrict($provice_code) : [];
                $this->arrWard = trim($district_code) != '' ? app(Province::class)->getOptionWard($district_code) : [];
                $optionProvince = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProvince, $provice_code);
                $optionDistrict = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrDistrict, $district_code);
                $optionWard = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrWard, isset($dataItem['WARDS']) ? $dataItem['WARDS'] : '');

                $this->arrUser = $this->_getStaffInspection();
                $optionUser = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrUser, isset($dataItem['STAFF_CODE']) ? $dataItem['STAFF_CODE'] : $this->user['user_id']);

                $this->dataOutItem = [
                    'optionStartHours' => $optionStartHours,
                    'optionStartMinute' => $optionStartMinute,
                    'optionEndHours' => $optionEndHours,
                    'optionEndMinute' => $optionEndMinute,
                    'optionProvince' => $optionProvince,
                    'optionDistrict' => $optionDistrict,
                    'optionWard' => $optionWard,
                    'optionUser' => $optionUser,
                ];
                $templateOut = $this->templateRoot . 'component._popupCalendar';
                break;
            case 'getReason':
                $templateOut = $this->templateRoot . 'component._popupReason';
                break;
            default:
                break;
        }

        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $data,
                'objectId' => $objectId,
                'formNameOther' => $formNameOther,
                'typeTab' => $typeTab,
                'divShowId' => $typeTab,
                'dataItem' => (object)$dataItem,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        return $html;
    }

    /***************************************************
     * Đổi trạng thái của đơn
     * @return \Illuminate\Http\JsonResponse|void
     ***************************************************/
    public function ajaxUpdateCalendarInspection()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT],$this->routerIndex)) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $arrAjax = array('success' => 0, 'message' => 'Có lỗi khi thao tác');
        $dataRequest = $_POST;

        $dataForm = isset($dataRequest['dataForm']) ? $dataRequest['dataForm'] : [];
        $dataItem = isset($dataForm['dataItem']) ? json_decode($dataForm['dataItem']) : [];
        //myDebug($dataItem,false);
        //myDebug($dataForm);
        if (isset($dataItem->STATUS) && $dataItem->STATUS == 'DGD') {
            return Response::json(returnError(viewLanguage('Trạng thái: Đã giám định không cập nhật lịch hẹn')));
        }
        if (trim($dataForm['p_provice_id']) == '') {
            return Response::json(returnError(viewLanguage('Tỉnh thành không được bỏ trống')));
        }
        if (trim($dataForm['p_staff']) == '') {
            return Response::json(returnError(viewLanguage('Nhân viên giám định không được bỏ trống')));
        }
        if (trim($dataForm['p_appointment_date_calen']) == '') {
            return Response::json(returnError(viewLanguage('Ngày hẹn không được bỏ trống')));
        }
        if (trim($dataForm['p_phone']) == '') {
            return Response::json(returnError(viewLanguage('Số điện thoại không được bỏ trống')));
        }elseif (!validatePhoneNumber(trim($dataForm['p_phone']))){
            return Response::json(returnError(viewLanguage('Số điện thoại không đúng định dạng')));
        }
        if (trim($dataForm['p_start_hours']) != '' && trim($dataForm['p_end_hours']) != '') {
            $hoursStart = (int)trim($dataForm['p_start_hours']);
            $hoursEnd = (int)trim($dataForm['p_end_hours']);
            if ($hoursStart > $hoursEnd) {
                return Response::json(returnError(viewLanguage('Giờ hẹn bắt đầu phải nhỏ hơn Giờ hẹn sau')));
            } elseif ($hoursStart == $hoursEnd && (int)trim($dataForm['p_start_minute']) > (int)trim($dataForm['p_end_minute'])) {
                return Response::json(returnError(viewLanguage('Phút hẹn bắt đầu phải nhỏ hơn Phút hẹn sau')));
            }
        }
        $this->arrUser = $this->_getStaffInspection();
        $dataUpdate['p_org_code'] = isset($this->user['org_code']) ? $this->user['org_code'] : '';
        $dataUpdate['contract_code'] = isset($dataItem->CONTRACT_CODE) ? $dataItem->CONTRACT_CODE : '';
        $dataUpdate['detail_code'] = isset($dataItem->DETAIL_CODE) ? $dataItem->DETAIL_CODE : '';
        $dataUpdate['eff'] = isset($dataForm['p_appointment_date_calen']) ? $dataForm['p_appointment_date_calen'] : '';
        $dataUpdate['time_f'] = $dataForm['p_start_hours'] . ':' . $dataForm['p_start_minute'];
        $dataUpdate['time_t'] = $dataForm['p_end_hours'] . ':' . $dataForm['p_end_minute'];
        $dataUpdate['contact'] = isset($dataForm['p_customer_name']) ? $dataForm['p_customer_name'] : '';
        $dataUpdate['phone'] = isset($dataForm['p_phone']) ? $dataForm['p_phone'] : '';
        $dataUpdate['wards'] = isset($dataForm['p_ward_id']) ? $dataForm['p_ward_id'] : '';
        $dataUpdate['dist'] = isset($dataForm['p_district_id']) ? $dataForm['p_district_id'] : '';
        $dataUpdate['prov'] = isset($dataForm['p_provice_id']) ? $dataForm['p_provice_id'] : '';
        $dataUpdate['address'] = isset($dataForm['p_address']) ? $dataForm['p_address'] : '';
        $dataUpdate['staff_code'] = isset($dataForm['p_staff']) ? $dataForm['p_staff'] : '';
        $dataUpdate['staff_name'] = isset($this->arrUser[$dataUpdate['staff_code']]) ? $this->arrUser[$dataUpdate['staff_code']] : '';
        $dataUpdate['status'] = 'XNLH';

        $result = $this->modelObj->updateCalendarInspection($dataUpdate);
        if ($result['Success'] == STATUS_INT_MOT  && isset($result['Data'][0][0]->TYPE) && $result['Data'][0][0]->TYPE == 'SUCCESS') {
            $arrAjax['success'] = 1;
            $arrAjax['loadPage'] = 1;//load lai page
            $arrAjax['message'] = 'Cập nhật thành công';
            return Response::json($arrAjax);
        } else {
            $arrAjax['success'] = 0;
            $arrAjax['loadPage'] = 0;//load lai page
            $arrAjax['message'] = isset($result['Data'][0][0]->RESULT) ? $result['Data'][0][0]->RESULT : 'Có lỗi cập nhật';
            return Response::json($arrAjax);
        }
    }

}
