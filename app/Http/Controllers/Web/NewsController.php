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
use App\Library\AdminFunction\Upload;
use App\Models\Web\Category;
use App\Models\Web\News;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class NewsController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrIsActive = array();
    private $arrNewsType = array();
    private $arrIsTrueFalse = array();
    private $arrCategory = array();
    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    private $routerIndex = 'news.index';
    private $templateRoot = DIR_PRO_WEB . '/' . 'News.';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new News();
        $this->arrIsActive = $this->getArrOptionTypeDefine(DEFINE_TRANG_THAI);
        $this->arrNewsType = $this->getArrOptionTypeDefine(DEFINE_TYPE_NEWS);
        $this->arrIsTrueFalse = $this->getArrOptionTypeDefine(DEFINE_TRUE_FALSE);
        $this->arrCategory = app(Category::class)->getOptionCategoryByType(Category::categoryTypeNew);
    }

    private function _outDataView($request, $data)
    {
        $optionPartner = FunctionLib::getOption([STATUS_INT_KHONG => '---Tất cả---'] + $this->arrPartner, isset($data['partner_id']) ? $data['partner_id'] : $this->partner_id);
        $optionCategory = FunctionLib::getOption([STATUS_INT_KHONG => '---Tất cả---'] + $this->arrCategory, isset($data['news_category']) ? $data['news_category'] : STATUS_INT_KHONG);
        $optionIsActive = FunctionLib::getOption([STATUS_INT_AM_MOT => '---Chọn---'] + $this->arrIsActive, isset($data['is_active']) ? $data['is_active'] : STATUS_INT_MOT);
        $optionNewsType = FunctionLib::getOption([DEFINE_NULL => '---Chọn---'] + $this->arrNewsType, isset($data['news_type']) ? $data['news_type'] : DEFINE_NULL);

        $formId = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Quản lý tin bài';

        $this->shareListPermission($this->routerIndex);
        return $this->dataOutCommon = [
            'optionIsActive' => $optionIsActive,
            'optionNewsType' => $optionNewsType,
            'optionPartner' => $optionPartner,
            'optionCategory' => $optionCategory,
            'arrIsActive' => $this->arrIsActive,
            'arrIsTrueFalse' => $this->arrIsTrueFalse,
            'arrNewsType' => $this->arrNewsType,
            'arrCategory' => $this->arrCategory,

            'form_id' => $formId,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'pageTitle' => $this->pageTitle,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route($this->routerIndex),
            'urlGetData' => URL::route('news.ajaxGetData'),
            'urlPostData' => URL::route('news.ajaxPostData'),
        ];
    }

    /*********************************************************************************************************
     * Quản lý đối tác web
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $limit = CGlobal::number_show_20;
        $page_no = (int)Request::get('page_no', 1);
        $offset = ($page_no - 1) * $limit;
        $search['page_no'] = $page_no;
        $search['limit'] = $limit;
        $search['partner_id'] = ($this->partner_id > 0)? $this->partner_id: trim(addslashes(Request::get('partner_id', STATUS_INT_KHONG)));
        $search['is_active'] = trim(addslashes(Request::get('is_active', STATUS_INT_AM_MOT)));
        $search['p_keyword'] = trim(addslashes(Request::get('p_keyword', '')));

        $result = $this->modelObj->searchByCondition($search, $limit, $offset);
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
                if ($objectId > STATUS_INT_KHONG) {
                    $dataDetail = $this->modelObj->getItemById($objectId);
                   // $link = getLinkImageShow(FOLDER_NEWS.'/'.$dataDetail->id,$dataDetail->news_image);
                    $dataDetail = ($dataDetail) ? $dataDetail->toArray() : false;
                }
                $this->_outDataView($request, $dataDetail);
                $htmlView = View::make($this->templateRoot . 'component.popupDetail')
                    ->with(array_merge($this->dataOutCommon, [
                        'dataDetail' => $dataDetail,

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

    public function ajaxPostData()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_ADD, PERMISS_EDIT], $this->routerIndex)) {
            return Response::json(returnError(MSG_PERMISSION_ERROR));
        }
        $request = $_POST;
        $arrAjax = array('success' => 0, 'html' => '', 'msg' => '');
        $actionUpdate = 'actionUpdate';
        $dataForm = isset($request['dataForm']) ? $request['dataForm'] : [];
        $actionUpdate = isset($dataForm['actionUpdate']) ? $dataForm['actionUpdate'] : (isset($request['actionUpdate']) ? $request['actionUpdate'] : $actionUpdate);

        switch ($actionUpdate) {
            case 'updateData':
                $folder = FOLDER_NEWS;
                $objectId = isset($request['objectId']) ? $request['objectId'] : STATUS_INT_KHONG;
                $isEdit = 0;
                $image_old = isset($request['news_image']) ? $request['news_image'] : '';
                if ($this->_validFormData($objectId, $request) && empty($this->error)) {
                    if($objectId > STATUS_INT_KHONG && isset($_FILES['file_image_upload']) && !empty($_FILES['file_image_upload']) && $_FILES['file_image_upload']['name'] != ''){
                        $image_upload = app(Upload::class)->uploadOneImage('file_image_upload',$folder ,$objectId, $image_old);
                        $request['news_image'] = $image_upload;
                    }
                    $isEdit = $this->modelObj->editItem($request, $objectId);
                }

                if ($isEdit > 0) {
                    if($objectId == STATUS_INT_KHONG && isset($_FILES['file_image_upload']) && !empty($_FILES['file_image_upload']) && $_FILES['file_image_upload']['name'] != ''){
                        $image_upload = app(Upload::class)->uploadOneImage('file_image_upload',$folder ,$isEdit, $image_old);
                        $updateImage['news_image'] = $image_upload;
                        $isEdit = $this->modelObj->editItem($updateImage, $isEdit);
                    }

                    $dataDetail = $this->modelObj->getItemById($isEdit);
                    $this->_outDataView($request, (array)$dataDetail);

                    $arrAjax['success'] = 1;
                    $arrAjax['html'] = '';
                    $arrAjax['loadPage'] = 1;
                    $arrAjax['divShowInfor'] = '';
                }else{
                    $arrAjax = returnError($this->error);
                }
                break;
            default:
                break;
        }
        return Response::json($arrAjax);
    }


    public function ajaxGetData()
    {
        if (!$this->checkMultiPermiss([PERMISS_FULL, PERMISS_VIEW, PERMISS_ADD, PERMISS_EDIT], $this->routerIndex)) {
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

    private function _validFormData($id = 0, &$data = array())
    {
        if (!empty($data)) {
            if (isset($data['USER_TYPE']) && trim($data['USER_TYPE']) == '') {
                $this->error[] = 'Kiểu người dùng không được bỏ trống';
            }

            if (isset($data['PHONE']) && trim($data['PHONE']) != '') {
                if (!validatePhoneNumber(trim($data['PHONE']))) {
                    $this->error[] = 'PHONE không đúng định dạng';
                }
            }
        }
        return true;
    }
}
