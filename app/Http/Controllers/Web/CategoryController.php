<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseAdminController;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Pagging;
use App\Models\Web\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class CategoryController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrIsActive = array();
    private $arrIsLink = array();

    private $templateRoot = DIR_PRO_WEB . '.Category.';
    private $routerIndex = 'categoryProduct.index';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new Category();
        $this->arrIsLink = $this->getArrOptionTypeDefine(DEFINE_TRUE_FALSE);
        $this->arrIsActive = $this->getArrOptionTypeDefine(DEFINE_TRANG_THAI);
    }

    private function _outDataView($request, $data)
    {
        $optionPartner = FunctionLib::getOption([STATUS_INT_KHONG => '---Tất cả---'] + $this->arrPartner, isset($data['partner_id']) ? $data['partner_id'] : $this->partner_id);
        $optionActive = FunctionLib::getOption([STATUS_INT_AM_MOT => '---Chọn---'] + $this->arrIsActive, isset($data['is_active']) ? $data['is_active'] : STATUS_INT_MOT);
        $optionShowMenu = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrIsLink, isset($data['category_menu_right']) ? $data['category_menu_right'] : STATUS_INT_MOT);

        $formId = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        return $this->dataOutCommon = [
            'optionActive' => $optionActive,
            'optionShowMenu' => $optionShowMenu,
            'optionPartner' => $optionPartner,

            'form_id' => $formId,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,

            'urlGetItem' => URL::route('category.ajaxGetItem'),
            'urlPostItem' => URL::route('category.ajaxPostItem'),
            'urlDeleteItem' => URL::route('category.ajaxDeleteItem'),
        ];
    }

    public function indexCategoryProduct()
    {
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Danh mục sản phẩm';
        return $this->index('categoryProduct.index',Category::categoryTypeProduct);
    }

    public function indexCategoryNew()
    {
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Danh mục tin tức';
        return $this->index('categoryNew.index',Category::categoryTypeNew);
    }

    private function index($urlIndex,$categoryType = 1)
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_VIEW], $urlIndex)) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $limit = CGlobal::number_show_500;
        $page_no = (int)Request::get('page_no', 1);
        $search['page_no'] = $page_no;
        $search['limit'] = $limit;
        $search['is_active'] = trim(addslashes(Request::get('is_active', STATUS_INT_AM_MOT)));
        $search['partner_id'] = ($this->partner_id > 0)? $this->partner_id: trim(addslashes(Request::get('partner_id', STATUS_INT_KHONG)));
        $search['category_type'] = $categoryType;

        $search['project_code'] = trim(addslashes(Request::get('project_code', STATUS_INT_HAI)));
        $search['p_keyword'] = trim(addslashes(Request::get('p_keyword', '')));

        $result = $this->modelObj->searchByCondition($search, $limit);
        $dataList = $result['data'] ?? [];
        $total = $result['total'] ?? STATUS_INT_KHONG;
        if (!empty($dataList)) {
            $data = $this->modelObj->getTreeMenu($dataList);
        }

        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';
        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'viewIndex', array_merge([
            'data' => $data,
            'total' => $total,
            'search' => $search,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'strIndex' => $urlIndex,
            'urlIndex' => URL::route($urlIndex),
            'pageTitle' => $this->pageTitle,
            'arrRouter' => $this->getRouterNameSite(),
        ], $this->dataOutCommon));
    }

    public function ajaxGetItem()
    {
        $request = $_GET;
        $oject_id = $request['objectId'] ?? 0;
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'],true) : false;
        $strIndex = isset($dataInput['strIndex']) ? $dataInput['strIndex'] : $this->routerIndex;
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_ADD, PERMISS_EDIT], $strIndex)) {
            return Response::json(returnError(MSG_PERMISSION_ERROR));
        }
        $category_type = (trim($strIndex) == $this->routerIndex) ? Category::categoryTypeProduct : Category::categoryTypeNew;
        $data = [];
        $is_copy = STATUS_INT_KHONG;
        if ($oject_id > 0) {
            $data = $this->modelObj->getItemById($oject_id);
            $category_type = isset($data->category_type) ? $data->category_type : $category_type;
            $data = isset($data->id) ? $data->toArray() : false;
        }
        $this->_outDataView($request, (array)$data);

        $this->arrOptionMenuParent = $this->modelObj->getOptionCategoryParent($category_type);
        $optionParentMenu = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrOptionMenuParent, isset($data['category_parent_id']) ? $data['category_parent_id'] : DEFINE_NULL);
        $html = View::make($this->templateRoot . 'component.popupDetail')
            ->with(array_merge($this->dataOutCommon ,[
                'data' => $data,
                'is_copy' => $is_copy,
                'category_type' => $category_type,
                'strIndex' => $strIndex,
                'optionParentMenu' => $optionParentMenu,
            ]))->render();
        $arrAjax = array('success' => 1, 'html' => $html);
        return Response::json($arrAjax);
    }

    public function ajaxPostItem()
    {
        $dataRequest = $_POST;
        $dataForm = $dataRequest['dataForm'] ?? [];
        $strIndex = $dataForm['strIndex'] ?? $this->routerIndex;
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_ADD, PERMISS_EDIT], $strIndex)) {
            return Response::json(returnError(MSG_PERMISSION_ERROR));
        }
        $id = (int)$dataForm['objectId'] ?? 0;
        if (empty($dataForm)) {
            return Response::json(returnError(MSG_DATA_ERROR));
        }

        if ($this->_validFormData($dataForm) && empty($this->error)) {
            $idNew = $this->modelObj->editItem($dataForm, $id);
            if ((int)$idNew > STATUS_INT_KHONG) {
                return Response::json(['loadPage' => STATUS_INT_MOT, 'success' => 1]);
            } else {
                return Response::json(returnError(MSG_ERROR));
            }
        } else {
            return Response::json(returnError($this->error));
        }
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

    public function ajaxDeleteItem()
    {
        $request = $_POST;
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput']) : false;
        $urlIndex = isset($dataInput['urlIndex']) ? $dataInput['urlIndex'] : $this->routerIndex;
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_REMOVE],$urlIndex)) {
            return Response::json(returnError(MSG_PERMISSION_ERROR));
        }
        $dataItem = isset($dataInput->item) ? $dataInput->item : false;
        if (!empty($dataItem)) {
            $id = isset($dataItem->id) ? $dataItem->id : 0;
            $result = $this->modelObj->deleteItem($id);
            if ($result) {
                return Response::json(returnSuccess());
            } else {
                return Response::json(returnError(MSG_ERROR));
            }
        } else {
            return Response::json(returnError(MSG_DATA_ERROR));
        }
    }
}
