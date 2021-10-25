<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Systems\OpenApi;

use App\Http\Controllers\BaseAdminController;
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

class DatabaseConnectionController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $templateRoot = DIR_PRO_SYSTEM.'/'.DIR_MODULE_OPENAPI . '.databaseConnection.';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new DatabaseConnection();
        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_STATUS);
    }

    private function _outDataView($request, $data)
    {
        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['IS_ACTIVE']) ? $data['IS_ACTIVE'] : STATUS_INT_MOT);

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'arrStatus' => $this->arrStatus,

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,

            'urlIndex' => URL::route('databaseConnection.index'),
            'urlGetItem' => URL::route('databaseConnection.ajaxGetItem'),
            'urlActionPostItem' => URL::route('databaseConnection.ajaxPostItem'),
            'urlDeleteItem' => '',
            'urlAjaxGetData' => '',
            'urlActionOtherItem' => ''
        ];
    }

    private function _validFormData($type = STATUS_INT_MOT, $data = array())
    {
        switch ($type) {
            case STATUS_INT_MOT: //danh mục tổ chức
                if (!empty($data)) {
                    if (isset($data['DB_CODE']) && trim($data['DB_CODE']) == '') {
                        $this->error[] = 'DB_CODE không được bỏ trống';
                    }
                    if (isset($data['DB_NAME']) && trim($data['DB_NAME']) == '') {
                        $this->error[] = 'DB_NAME không được bỏ trống';
                    }
                    if (isset($data['DB_TYPE']) && trim($data['DB_TYPE']) == '') {
                        $this->error[] = 'DB_TYPE không được bỏ trống';
                    }
                    if (isset($data['IS_ACTIVE']) && trim($data['IS_ACTIVE']) == '') {
                        $this->error[] = 'IS_ACTIVE không được bỏ trống';
                    }
                    if (isset($data['ENV_CODE']) && trim($data['ENV_CODE']) == '') {
                        $this->error[] = 'ENV_CODE không được bỏ trống';
                    }
                    if (isset($data['SRV_ADDRESS']) && trim($data['SRV_ADDRESS']) == '') {
                        $this->error[] = 'SRV_ADDRESS không được bỏ trống';
                    }
                    if (isset($data['USERNAME']) && trim($data['USERNAME']) == '') {
                        $this->error[] = 'USERNAME không được bỏ trống';
                    }
                    if (isset($data['PASSWORD']) && trim($data['PASSWORD']) == '') {
                        $this->error[] = 'PASSWORD không được bỏ trống';
                    }
                    if (isset($data['CONN_STR']) && trim($data['CONN_STR']) == '') {
                        $this->error[] = 'CONN_STR không được bỏ trống';
                    }
                }
                break;
            default:
                break;
        }
        return true;
    }

    /*********************************************************************************************************
     * Danh mục: Database
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Quản lý Database Connection';
        $page_no = (int)Request::get('page_no', 1);
        $search['page_no'] = $page_no;
        $search['IS_ACTIVE'] = addslashes(Request::get('IS_ACTIVE', ''));
        $search['p_is_active'] = $search['IS_ACTIVE'];
        $search['p_search'] = addslashes(Request::get('p_search', ''));

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchItem($search);
        //myDebug($result);

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
        $objectId = $request['objectId'] ?? '';
        $data = (trim($objectId) != '') ? $this->modelObj->getItemByKey($objectId) : false;

        $this->_outDataView($request, (array)$data);
        $html = View::make($this->templateRoot . 'component.popupDetail')
            ->with(array_merge([
                'data' => $data,
            ], $this->dataOutCommon))->render();
        $arrAjax = array('success' => 1, 'html' => $html);
        return Response::json($arrAjax);
    }

    public function ajaxPostItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $dataRequest = $_POST;
        $dataForm = $dataRequest['dataForm'] ?? [];

        if (empty($dataForm)) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }
        $id = $dataForm['GID'] ?? '';
        if ($this->_validFormData(STATUS_INT_MOT, $dataForm) && empty($this->error)) {
            $result = $this->modelObj->editItem($dataForm, (trim($id) == '') ? 'ADD' : 'EDIT');
            if ($result['Success'] == STATUS_INT_MOT) {
                return Response::json(returnSuccess());
            } else {
                return Response::json(returnError($result['Message']));
            }
        } else {
            return Response::json(returnError($this->error));
        }
    }
}
