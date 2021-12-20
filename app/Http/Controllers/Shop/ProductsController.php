<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\BaseAdminController;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;
use App\Models\Shop\Products;
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

    private $arrIsActive = array();
    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    private $routerIndex = 'products.index';
    private $templateRoot = DIR_PRO_SHOP . '/' . 'Products.';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new Products();
        $this->arrIsActive = $this->getArrOptionTypeDefine(DEFINE_TRANG_THAI_TIN);
    }

    private function _outDataView($request, $data)
    {
        $optionPartner = FunctionLib::getOption([STATUS_INT_KHONG => '---Tất cả---'] + $this->arrPartner, isset($data['partner_id']) ? $data['partner_id'] : STATUS_INT_MOT);
        $optionIsActive = FunctionLib::getOption([STATUS_INT_AM_MOT => '---Chọn---'] + $this->arrIsActive, isset($data['is_active']) ? $data['is_active'] : STATUS_INT_AM_MOT);

        $formId = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = $request['objectId'] ?? 0;
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Sản phẩm';

        $this->shareListPermission($this->routerIndex);//lay quyen theo ajax
        return $this->dataOutCommon = [
            'optionPartner' => $optionPartner,
            'optionIsActive' => $optionIsActive,
            'arrIsActive' => $this->arrIsActive,

            'form_id' => $formId,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'pageTitle' => $this->pageTitle,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route($this->routerIndex),
            'urlGetData' => URL::route('products.ajaxGetData'),
            'urlPostData' => URL::route('products.ajaxPostData'),
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
        $search['is_active'] = trim(addslashes(Request::get('is_active', STATUS_INT_AM_MOT)));
        $search['partner_id'] = ($this->partner_id > 0)? $this->partner_id: trim(addslashes(Request::get('partner_id', STATUS_INT_AM_MOT)));
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
                    /*$link = getLinkImageShow(FOLDER_PRODUCT.'/'.$dataDetail->id,$dataDetail->product_image);
                    myDebug($link);*/
                }
                $arrViewImgOther = [];
                $imagePrimary = $imageHover = '';
                if(isset($dataDetail->id)){
                    //lay ảnh khác của san phẩm
                    if (!empty($dataDetail->product_image_other)) {
                        $arrImagOther = unserialize($dataDetail->product_image_other);
                        if (!empty($arrImagOther)) {
                            foreach ($arrImagOther as $k => $val) {
                                $url_thumb = getLinkImageShow(FOLDER_PRODUCT.'/'. $dataDetail->id, $val);
                                $arrViewImgOther[] = array('img_other' => $val, 'src_img_other' => $url_thumb);
                            }
                        }
                    }
                    //ảnh sản phẩm chính
                    $imagePrimary = $dataDetail->product_image;
                    $imageHover = $dataDetail->product_image_hover;

                    //check hash tag null
                    /*if(empty($product->list_tag_id)){
                        $product->list_tag_id = app(Product::class)->getTagIdWithCate($product->category_id);
                    }*/
                }
                $dataDetail = ($dataDetail) ? $dataDetail->toArray() : false;
                $this->_outDataView($request, $dataDetail);
                $htmlView = View::make($this->templateRoot . 'component.popupDetail')
                    ->with(array_merge($this->dataOutCommon, [
                        'dataDetail' => $dataDetail,
                        'arrViewImgOther' => $arrViewImgOther,
                        'imagePrimary' => $imagePrimary,
                        'imageHover' => $imageHover,

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
                $objectId = isset($request['objectId']) ? $request['objectId'] : STATUS_INT_KHONG;
                $isEdit = 0;
                $folder = FOLDER_PRODUCT;
                $arrImagOther = unserialize($request['product_image_other']);
                if ($this->_validFormData($objectId, $request) && empty($this->error)) {
                    if($objectId > STATUS_INT_KHONG && isset($_FILES['file_image_upload']['name']) &&  !empty($_FILES['file_image_upload']['name'])){
                        $arUpload = app(Upload::class)->uploadMultipleFile('file_image_upload',$folder ,$objectId);
                        if(!empty($arUpload) && !empty($arrImagOther)){
                            $arrImagUpdate = array_merge($arUpload,$arrImagOther);
                        }else{
                            $arrImagUpdate = !empty($arUpload)? $arUpload: $arrImagOther;
                        }
                        $request['product_image_other'] = !empty($arrImagUpdate) ? serialize($arrImagUpdate): '';
                    }
                    $isEdit = $this->modelObj->editItem($request, $objectId);
                }
                if ($isEdit > 0) {

                    if($objectId == STATUS_INT_KHONG && isset($_FILES['file_image_upload']['name'])  && !empty($_FILES['file_image_upload']['name'])){
                        $arUpload = app(Upload::class)->uploadMultipleFile('file_image_upload',$folder ,$objectId);
                        if(!empty($arUpload) && !empty($arrImagOther)){
                            $arrImagUpdate = array_merge($arUpload,$arrImagOther);
                        }else{
                            $arrImagUpdate = !empty($arUpload)? $arUpload: $arrImagOther;
                        }
                        $updateImage['product_image_other'] = !empty($arrImagUpdate) ? serialize($arrImagUpdate): '';
                        $isEdit = $this->modelObj->editItem($updateImage, $isEdit);
                    }

                    $dataDetail = $this->modelObj->getItemById($isEdit);
                    $this->_outDataView($request, (array)$dataDetail);

                    $arrAjax['success'] = 1;
                    $arrAjax['html'] = '';
                    $arrAjax['loadPage'] = ($objectId > 0) ? 0 : 1;
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
            if (isset($data['product_price_sell']) && trim($data['product_price_sell']) == '') {
                $this->error[] = 'Giá bán không được bỏ trống';
            }else{
                $data['product_price_sell'] = (int)str_replace('.', '', trim($data['product_price_sell']));
            }
            if (isset($data['product_price_market']) && trim($data['product_price_market']) !== '') {
                $data['product_price_market'] = (int)str_replace('.', '', trim($data['product_price_market']));
            }
            if (isset($data['product_price_input']) && trim($data['product_price_input']) !== '') {
                $data['product_price_input'] = (int)str_replace('.', '', trim($data['product_price_input']));
            }
            if (isset($data['product_price_provider_sell']) && trim($data['product_price_provider_sell']) !== '') {
                $data['product_price_provider_sell'] = (int)str_replace('.', '', trim($data['product_price_provider_sell']));
            }
        }
        return true;
    }
}
