<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Systems\OpenId;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\OpenId\CalendarWorking;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class CalendarWorkingController extends BaseAdminController
{
    private $error = array();
    private $viewPermission = array();
    private $viewOptionData = array();
    private $pageTitle = '';

    private $arrStatus = array();
    private $arrTime = array();
    private $arrType = array();
    private $arrWhose = array();
    private $arrParticipants = array();
    private $arrCity = array();

    private $templateRoot = DIR_PRO_SYSTEM.'/'.DIR_MODULE_OPENID . '.banks.';

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Lịch làm việc';
    }

    private function _getDataDefault()
    {
        $this->arrType = CalendarWorking::$arrType;
        $this->arrTime = CalendarWorking::$arrTime;
        $this->arrStatus = CalendarWorking::$arrStatus;
        $this->arrWhose = CalendarWorking::$arrWhose;
        $this->arrCity = CGlobal::$arrCity;

    }

    private function _outDataView($request,$data)
    {
        $optionStatus = FunctionLib::getOption($this->arrStatus, STATUS_INT_KHONG);
        $optionTime = FunctionLib::getOption([STATUS_DEFAULT => '---Chọn---'] + $this->arrTime, STATUS_DEFAULT);
        $optionType = FunctionLib::getOption([STATUS_DEFAULT => '---Chọn---'] + $this->arrType, STATUS_INT_MOT);
        $optionWhose = FunctionLib::getOption([STATUS_DEFAULT => '---Chọn---'] + $this->arrWhose, STATUS_DEFAULT);
        $optionCity = FunctionLib::getOption([STATUS_DEFAULT => '---Chọn---'] + $this->arrCity, HA_NOI);
        //danh sách các phòng ban liên quan
        $optionParticipants = FunctionLib::getOption([STATUS_DEFAULT => '---Chọn---'] + $this->arrParticipants, STATUS_DEFAULT);

        $formId = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $ojectId = $request['objectId'] ?? 0;

        return $this->viewOptionData = [
            'optionCity' => $optionCity,
            'optionStatus' => $optionStatus,
            'optionTime' => $optionTime,
            'optionType' => $optionType,
            'optionWhose' => $optionWhose,//của ai
            'optionParticipants' => $optionParticipants,//thành phần tham gia
            'pageTitle' => $this->pageTitle,

            'form_id' => $formId,
            'title_popup' => $titlePopup,
            'oject_id' => $ojectId,
        ];
    }

    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $page_no = (int)Request::get('page_no', 1);
        $search['start_date'] = addslashes(Request::get('start_date_', ''));
        $search['end_date'] = addslashes(Request::get('end_date_', ''));
        $search['status'] = Request::get('status_', STATUS_DEFAULT);//kiểu lịch
        $search['type_calendar'] = Request::get('type_calendar_', STATUS_DEFAULT);//kiểu lịch
        $search['type_whose'] = Request::get('type_whose_', STATUS_DEFAULT);//lịch của ai
        $search['preside_id'] = Request::get('preside_id_', STATUS_DEFAULT);//thành phần tham dự
        $search['are_time_'] = Request::get('are_time_', STATUS_DEFAULT);//khoảng thời gian tìm kiếm

        $limit = CGlobal::number_show_30;
        $offset = ($page_no - 1) * $limit;
        $data = app(CalendarWorking::class)->searchByCondition($search, $limit, $offset, true);
        $paging = $data['total'] > 0 ? Pagging::getNewPager(3, $page_no, $data['total'], $limit, $search) : '';

        $this->_getDataDefault();
        $this->_outDataView($_GET, $data['data']);
        return view('dmsPortal.calendarWorking.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $data['total'],
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'urlIndex' => URL::route('calendarWorking.index'),
            'urlGetItem' => URL::route('calendarWorking.ajaxGetItem'),
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function ajaxGetItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_GET;
        $oject_id = $request['objectId'] ?? 0;
        $data = [];
        if ($oject_id > 0) {
            $data = app(CalendarWorking::class)->getItemById($oject_id);
        }
        $this->_getDataDefault();
        $this->_outDataView($request, $data);
        $html = View::make('dmsPortal.calendarWorking.component.popupDetail')
            ->with(array_merge([
                'data' => [],
                'url_action' => URL::route('calendarWorking.ajaxPostItem'),
            ], $this->viewPermission, $this->viewOptionData))->render();
        $arrAjax = array('success' => 1, 'html' => $html);
        return Response::json($arrAjax);
    }

    public function ajaxPostItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $dataForm = $_POST;
        $dataInput = $dataForm['dataForm'] ?? [];
        $id = $dataInput['oject_id'] ?? 0;
        if (empty($dataInput)) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }
        if ($this->_validItem($dataInput) && empty($this->error)) {
            if ($id > 0) {
                app(CalendarWorking::class)->updateItem($id, $dataInput);
            } else {
                app(CalendarWorking::class)->createItem($dataInput);
            }
            return Response::json(returnSuccess());
        }else{
            return Response::json(returnError($this->error));
        }
    }
    //ajax
    public function deleteItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_REMOVE])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $data = array('isIntOk' => 0);
        $id = (int)Request::get('id', 0);
        if ($id > 0 && app(CalendarWorking::class)->deleteItem($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    private function _validItem($data = array())
    {
        if (!empty($data)) {
            if (isset($data['name']) && trim($data['name']) == '') {
                $this->error[] = 'Tên lịch không được bỏ trống';
            }
        }
        return true;
    }
}
