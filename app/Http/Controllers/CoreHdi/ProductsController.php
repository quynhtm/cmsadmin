<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\CoreHdi;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\BContracts\Products;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class ProductsController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrBankParent = array();

    private $templateRoot = DIR_PRO_CORE_HDI.'/'. 'products.';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new Products();
        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_STATUS);
        $this->arrBankParent = [];
    }

    private function _outDataView($request, $data)
    {
        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['IS_ACTIVE']) ? $data['IS_ACTIVE'] : STATUS_INT_MOT);
        $optionBankParent = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrBankParent, isset($data['PARENT_CODE']) ? $data['PARENT_CODE'] : '');

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'optionBankParent' => $optionBankParent,
            'arrStatus' => $this->arrStatus,

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'urlAjaxGetData' => '',
            'urlIndex' => URL::route('products.index'),
            'urlGetItem' => URL::route('products.ajaxGetItem'),
        ];
    }

    private function _validFormData($type = STATUS_INT_MOT, $data = array())
    {
        switch ($type) {
            case STATUS_INT_MOT: //danh mục tổ chức
                if (!empty($data)) {
                    if (isset($data['depart_name']) && trim($data['depart_name']) == '') {
                        $this->error[] = 'Tên depart không được bỏ trống';
                    }
                    if (isset($data['depart_alias']) && trim($data['depart_alias']) == '') {
                        $this->error[] = 'Tên viết tắt không được bỏ trống';
                    }
                }
                break;
            default:
                break;
        }
        return true;
    }

    /*********************************************************************************************************
     * Danh mục: Banks
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Danh sách sản phẩm HDI';
        $page_no = (int)Request::get('page_no', 1);
        $search['page_no'] = $page_no;
        $search['p_status'] = addslashes(Request::get('p_status', ''));
        $search['p_keyword'] = addslashes(Request::get('p_keyword', ''));

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchProduct($search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data']['data'] ?? $dataList;
            $total = $result['Data']['total'] ?? $total;
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'view', array_merge([
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
        if (!$this->checkMultiPermiss([PERMISS_ADD,PERMISS_EDIT])) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_GET;
        $objectId = $request['objectId'] ?? 0;
        $data = ($objectId > 0) ? $this->modelObj->getItemByKey($objectId) : false;
        $this->_outDataView($request, (array)$data);

        $html = View::make($this->templateRoot . 'component.popupDetail')
            ->with(array_merge([
                'data' => $data,
                'url_action' => URL::route('products.ajaxPostItem'),
            ], $this->dataOutCommon))->render();
        $arrAjax = array('success' => 1, 'html' => $html);
        return Response::json($arrAjax);
    }

    public function ajaxPostItem()
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

        if ($this->_validFormData(STATUS_INT_MOT, $dataForm) && empty($this->error)) {
            $result = $this->modelObj->editItem($dataForm, ($id > 0) ? 'EDIT' : 'ADD');
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
