<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Systems\OpenId;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\OpenId\MenuSystem;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class MenuSystemController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrIsLink = array();
    private $arrProject = array();
    private $arrOptionMenuParent = array();
    private $templateRoot = DIR_PRO_SYSTEM.'/'.DIR_MODULE_OPENID . '.systemMenu.';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new MenuSystem();
        $this->arrProject = $this->getArrOptionTypeDefine(DEFINE_MENU_SYSTEM);
    }

    private function _outDataView($request, $data)
    {
        $this->arrStatus = CGlobal::$arrStatus;
        $this->arrIsLink = CGlobal::$arrIsTrueOrFalse;

        $projectCode = isset($data['PROJECT_CODE']) ? $data['PROJECT_CODE']: $this->project_code_menu;
        $this->arrOptionMenuParent = $this->modelObj->getOptionMenuParent($projectCode);

        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['IS_ACTIVE']) ? $data['IS_ACTIVE'] : STATUS_INT_MOT);
        $optionProjectCode = FunctionLib::getOption([STATUS_INT_KHONG => '---Chọn---'] + $this->arrProject, $projectCode);
        $optionIsLink = FunctionLib::getOption($this->arrIsLink, isset($data['IS_LINK']) ? $data['IS_LINK'] : STATUS_INT_MOT);
        $optionMenuParent = FunctionLib::getOption([STATUS_INT_KHONG => '---Chọn---'] + $this->arrOptionMenuParent, isset($data['PARENT_CODE']) ? $data['PARENT_CODE'] : STATUS_INT_KHONG);
        $optionSearchProjectCode = FunctionLib::getOption([DEFINE_ALL => '---Chọn---'] + $this->arrProject, isset($data['s_project_code']) ? $data['s_project_code'] : DEFINE_ALL);

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;

        return $this->dataOutCommon = [
            'optionSearchProjectCode' => $optionSearchProjectCode,
            'optionIsLink' => $optionIsLink,
            'optionMenuParent' => $optionMenuParent,
            'optionStatus' => $optionStatus,
            'arrStatus' => $this->arrStatus,
            'optionProjectCode' => $optionProjectCode,
            'arrProject' => $this->arrProject,

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,

            'permission_full' => false,
            'permission_create' => false,
            'permission_delete' => false,
        ];
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

    public function indexMenu()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Menu system';
        $limit = CGlobal::number_show_500;
        $page_no = (int)Request::get('page_no', 1);
        $search['page_no'] = $page_no;
        $search['limit'] = $limit;
        $search['s_project_code'] = addslashes(Request::get('s_project_code', MENU_HDI_SELLING));
        $search['s_search'] = trim(addslashes(Request::get('s_search', '')));

        $dataList = [];
        $total = 0;
        $result = $this->modelObj->searchMenuSystem($search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data']['data'] ?? $dataList;
            $total = $result['Data']['total'] ?? $total;
            $dataList = $this->modelObj->getTreeMenu($dataList);
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        $arrRouter = $this->getRouterNameSite();
        return view($this->templateRoot . 'viewMenu', array_merge([
            'data' => $dataList,
            'total' => $total,
            'search' => $search,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'arrRouter' => $arrRouter,

            'pageTitle' => $this->pageTitle,
            'urlIndex' => URL::route('menu.indexMenu'),
            'urlGetItem' => URL::route('menu.ajaxGetMenu'),
            'urlDeleteItem' => URL::route('menu.ajaxDeleteMenu'),
        ], $this->dataOutCommon));
    }

    public function ajaxGetMenu()
    {
        if (!$this->checkMultiPermiss()) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_GET;
        $objectId = $request['objectId'] ?? 0;
        $data = [];
        if ($objectId > 0) {
            $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
            $objectMenu = isset($dataInput->item) ? $dataInput->item : false;
            $data = isset($objectMenu->object_menu)?$objectMenu->object_menu: false;
        }
        $this->_outDataView($request, (array)$data);
        $html = View::make($this->templateRoot . 'component.popupDetail')
            ->with(array_merge([
                'data' => $data,
                'url_action' => URL::route('menu.ajaxPostMenu'),
            ], $this->dataOutCommon))->render();
        $arrAjax = array('success' => 1, 'html' => $html);
        return Response::json($arrAjax);
    }

    public function ajaxPostMenu()
    {
        if (!$this->checkMultiPermiss()) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $dataRequest = $_POST;
        $dataForm = $dataRequest['dataForm'] ?? [];
        $id = $dataForm['objectId'] ?? 0;
        if (empty($dataForm)) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }
        if ($this->_validFormData($dataForm) && empty($this->error)) {
            $dataForm['MENU_LEVEL'] = $this->modelObj->getLevelMenuById($dataForm['PARENT_CODE']);
            $dataForm['MENU_CODE'] = ($id > 0) ? $id : '';// ID tự tăng

            $result = $this->modelObj->editMenuSystem($dataForm, ($id > 0) ? 'EDIT' : 'ADD');
            if ($result['Success'] == STATUS_INT_MOT) {
                return Response::json(returnSuccess());
            } else {
                return Response::json(returnError($result['Message']));
            }
        } else {
            return Response::json(returnError($this->error));
        }
    }

    public function ajaxDeleteMenu()
    {
        if (!$this->checkMultiPermiss()) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_POST;
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
        $dataItem = isset($dataInput->item) ? (array)$dataInput->item : false;

        if (!empty($dataItem)) {
            $result = $this->modelObj->deleteItem($dataItem);
            if ($result['Success'] == STATUS_INT_MOT) {
                return Response::json(returnSuccess());
            } else {
                return Response::json(returnError($result['Message']));
            }
        } else {
            return Response::json(returnError('Dữ liệu không đúng'));
        }
    }

}
