<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Sellings\InsurancePolicy;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\OpenId\Province;
use App\Http\Models\Selling\InsurancePolicy;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use App\Services\ServiceCommon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class InsurancePolicyController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrGender = array();
    private $arrDanhXung = array();
    private $arrProvince = array();
    private $arrMonth = array();
    private $arrYear = array();
    private $arrDonViThoiGian = array();
    private $arrHinhThucThanhToan = array();
    private $arrPhamViDiaLy = array();
    private $arrDonViGiamGia = array();
    private $arrDonViThuHuong = array();
    private $arrPhamViBaoHiem = array();
    private $arrThoiHanThanhToan = array();
    private $arrKieuFile = array();
    private $arrProductType = array();
    private $arrProductShow = array();
    private $arrProductHide = array();
    private $arrCategoryCode = array();
    private $arrProduct = array();
    private $arrOrg = array();
    private $arrLoaiCapDon = array();

    private $arrUserXeCoGioi = [421, 262, 284, 293, 303, 242, 286, 287, 289, 295, 296, 297, 299, 308, 309, 124/*khanhpt*/];
    private $arrUserATTD = [421];
    private $p_category_default = CATEGORY_ATTD;
    private $p_product_code_default = PRODUCT_CODE_ATTD;

    private $templateRoot = DIR_PRO_SELLING . '/' . DIR_MODULE_INSURANCE_POLICY . '.';
    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';
    private $routerIndex = 'insurancePolicy.index';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new InsurancePolicy();

        //get defile cấp đơn
        $this->_getAllDefinePolicy();

        $this->arrLoaiCapDon = $this->getArrOptionTypeDefine(DEFINE_LOAI_CAP_DON);
        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_CONTRACT_STATUS);
        $this->arrGender = $this->getArrOptionTypeDefine(DEFINE_GENDER);
        $this->arrMonth = CGlobal::$arrMonth;
        $this->arrYear = getArrYear();
        $this->arrCategoryCode = [CATEGORY_VISA_CARE => CATEGORY_ATTD];

        $this->arrProductType = [
            PRODUCT_CODE_ATTD => [
                'pro_code' => PRODUCT_CODE_ATTD,
                'pro_name' => 'An tâm tín dụng',
                'pro_id' => 'attd',
                'templateView' => '_tableListATTD',
                'category' => CATEGORY_ATTD,
                'channel' => CHANNEL_SELLING,
                'is_open' => STATUS_INT_MOT,
                //'isShow' => (Config::get('config.ENVIRONMENT') == 'DEV') ? 1 : 0,
                'isShow' => STATUS_INT_KHONG],
            PRODUCT_CODE_VISA_CARE => [
                'pro_code' => PRODUCT_CODE_VISA_CARE,
                'pro_name' => 'Visa Care',
                'pro_id' => 'visa_care',
                'templateView' => '_tableListVisaCare',
                'category' => CATEGORY_VISA_CARE,
                'channel' => CHANNEL_SELLING,
                'is_open' => STATUS_INT_MOT,
                'isShow' => STATUS_INT_KHONG],
            PRODUCT_CODE_XCG_TNDS => [
                'pro_code' => PRODUCT_CODE_XCG_TNDS,
                'pro_name' => 'TNDS BB Xe',
                'pro_id' => 'tnds',
                'templateView' => '_tableListTNDS',
                'category' => CATEGORY_XCG,
                'channel' => CHANNEL_SELLING,
                'is_open' => STATUS_INT_MOT,
                'isShow' => STATUS_INT_KHONG],
            PRODUCT_CODE_XCG_VCX => [
                'pro_code' => PRODUCT_CODE_XCG_VCX,
                'pro_name' => 'Vật chất xe',
                'pro_id' => 'vcx',
                'templateView' => '_tableListVCX',
                'category' => CATEGORY_XCG_2,
                'channel' => CHANNEL_SELLING,
                'is_open' => STATUS_INT_MOT,
                'isShow' => STATUS_INT_KHONG],
            PRODUCT_CODE_SUCKHOE365 => [
                'pro_code' => PRODUCT_CODE_SUCKHOE365,
                'pro_name' => 'Sức khỏe 365',
                'pro_id' => 'suckhoe365',
                'templateView' => '_tableListSUCKHOE',
                'category' => CATEGORY_SUCKHOE365,
                'channel' => CHANNEL_SUCKHOE365,
                'is_open' => STATUS_INT_MOT,
                'isShow' => STATUS_INT_KHONG],
            PRODUCT_CODE_TAINAN365 => [
                'pro_code' => PRODUCT_CODE_TAINAN365,
                'pro_name' => 'Tai nạn 365',
                'pro_id' => 'tainan365',
                'templateView' => '_tableListTAINAN',
                'category' => CATEGORY_TAINAN365,
                'channel' => CHANNEL_TAINAN365,
                'is_open' => STATUS_INT_MOT,
                'isShow' => STATUS_INT_KHONG],
            PRODUCT_CODE_NHA365 => [
                'pro_code' => PRODUCT_CODE_NHA365,
                'pro_name' => 'Nhà 365',
                'pro_id' => 'nha365',
                'templateView' => '_tableListNHA',
                'category' => CATEGORY_NHA365,
                'channel' => CHANNEL_NHA365,
                'is_open' => STATUS_INT_MOT,
                'isShow' => STATUS_INT_KHONG],

        ];

        foreach ($this->arrProductType as $key_c => $valu_c) {
            $this->arrProduct[$valu_c['pro_code']] = $valu_c['pro_name'];
        }
        $this->arrProvince = app(Province::class)->getOptionProvince();
    }

    private function _setDefaultProduct()
    {
        $this->_checkViewProduct($this->arrProductType);
    }

    private function _checkViewProduct(&$arrayInfor)
    {
        $listProductWithUser = $this->getInforUser('product');
        foreach ($arrayInfor as $key_pro => &$valu_category) {
            if (!empty($listProductWithUser) && in_array($key_pro, array_keys($listProductWithUser))) {
                $valu_category['isShow'] = 1;
                $arrUserPro[$key_pro] = $key_pro;
            }
        }
        if (!empty($arrUserPro)) {
            $pro_first_value = reset($arrUserPro);
            $this->p_category_default = $arrayInfor[$pro_first_value]['category'];
            $this->p_product_code_default = $pro_first_value;
        }
    }

    private function _getAllDefinePolicy()
    {
        $dataDefine = $this->modelObj->getAllDefinePolicy();
        //myDebug($dataDefine);
        if ($dataDefine) {
            //1: pham vi dia lý
            if (isset($dataDefine[1])) {
                foreach ($dataDefine[1] as $k1 => $value1) {
                    $this->arrPhamViDiaLy[$value1->TYPE_CODE] = $value1->TYPE_NAME;
                }
            }
            //2: dơn vi giảm giá
            if (isset($dataDefine[2])) {
                foreach ($dataDefine[2] as $k2 => $value2) {
                    $this->arrDonViGiamGia[$value2->TYPE_CODE] = $value2->TYPE_NAME;
                }
            }
            //3: Đơn vị thời hạn
            if (isset($dataDefine[3])) {
                foreach ($dataDefine[3] as $k3 => $value3) {
                    $this->arrDonViThoiGian[$value3->TYPE_CODE] = $value3->TYPE_NAME;
                }
            }
            //4: Danh xưng
            if (isset($dataDefine[4])) {
                foreach ($dataDefine[4] as $k4 => $value4) {
                    $this->arrDanhXung[$value4->TYPE_CODE] = $value4->TYPE_NAME;
                }
            }
            //6:đơn vị thụ hưởng
            if (isset($dataDefine[6])) {
                foreach ($dataDefine[6] as $k6 => $value6) {
                    $this->arrDonViThuHuong[$value6->TYPE_CODE] = $value6->TYPE_NAME;
                }
            }
            //7:Phạm vi bảo hiểm
            if (isset($dataDefine[7])) {
                foreach ($dataDefine[7] as $k7 => $value7) {
                    $this->arrPhamViBaoHiem[$value7->TYPE_CODE] = $value7->TYPE_NAME;
                }
            }
            //8:Thời hạn thanh toán
            if (isset($dataDefine[8])) {
                foreach ($dataDefine[8] as $k8 => $value8) {
                    $this->arrThoiHanThanhToan[$value8->TYPE_CODE] = $value8->TYPE_NAME;
                    $this->arrHinhThucThanhToan[$value8->TYPE_CODE] = $value8->TYPE_NAME;
                }
            }
            //9:Kiểu file
            if (isset($dataDefine[9])) {
                foreach ($dataDefine[9] as $k9 => $value9) {
                    $this->arrKieuFile[$value9->TYPE_CODE] = $value9->TYPE_NAME;
                }
            }
            //10:Tháng của năm
            if (isset($dataDefine[10])) {
                foreach ($dataDefine[10] as $k10 => $value10) {
                    $this->arrKieuFile[$value10->TYPE_CODE] = $value10->TYPE_NAME;
                }
            }
        }
    }

    private function _outDataView($request, $data)
    {
        $this->_setDefaultProduct();
        //tach 2 mảng show sản phẩm khi có nhiều
        foreach ($this->arrProductType as $kpro => $pro){
            if($pro['isShow']){
                if(count($this->arrProductShow) <= 6){
                    $this->arrProductShow[$kpro] = $pro;
                }else{
                    $this->arrProductHide[$kpro] = $pro;
                }
            }
        }

        $this->arrOrg = $this->getInforUser('org');
        $arrPermissionInspection = app(ServiceCommon::class)->getGroupPermissonWithController(Route::currentRouteName());

        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['p_status']) ? $data['p_status'] : '');
        $optionMonth = FunctionLib::getOption(['' => 'Tháng'] + $this->arrMonth, isset($data['p_month']) ? $data['p_month'] : '');
        $optionYear = FunctionLib::getOption(['' => 'Năm'] + $this->arrYear, isset($data['p_year']) ? $data['p_year'] : '');
        $optionProductType = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProduct, isset($data['p_product_code']) ? $data['p_product_code'] : '');

        $optionDanhXung = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrDanhXung, isset($data['GENDER']) ? $data['GENDER'] : '');
        $optionDonViThoiGian = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrDonViThoiGian, isset($data['GENDER']) ? $data['GENDER'] : '');
        $optionHinhThucThanhToan = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrHinhThucThanhToan, isset($data['GENDER']) ? $data['GENDER'] : '');
        $optionPhamViDiaLy = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrPhamViDiaLy, isset($data['GENDER']) ? $data['GENDER'] : '');
        $optionDonViGiamGia = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrDonViGiamGia, isset($data['GENDER']) ? $data['GENDER'] : '');
        $optionDonViThuHuong = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrDonViThuHuong, isset($data['BEN_ORG_CODE']) ? $data['BEN_ORG_CODE'] : '');
        $optionPhamViBaoHiem = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrPhamViBaoHiem, isset($data['GENDER']) ? $data['GENDER'] : '');
        $optionThoiHanThanhToan = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrThoiHanThanhToan, isset($data['DURATION_PAYMENT']) ? $data['DURATION_PAYMENT'] : '');
        $optionKieuFile = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrKieuFile, isset($data['GENDER']) ? $data['GENDER'] : '');
        $optionOrg = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrOrg, isset($data['LO_TYPE']) ? $data['LO_TYPE'] : '');

        //tỉnh thành quận huyện
        $provinceChecked = (isset($data['PROVINCE']) && !empty($data['PROVINCE'])) ? $data['PROVINCE'] : '';
        $districtChecked = (isset($data['DISTRICT']) && !empty($data['DISTRICT'])) ? $data['DISTRICT'] : '';
        $wardsChecked = (isset($data['WARDS']) && !empty($data['WARDS'])) ? $data['WARDS'] : '';
        $arrDistrictChecked = app(Province::class)->getOptionDistrict($provinceChecked);
        $arrWardChecked = app(Province::class)->getOptionWard($districtChecked);

        $optionProvince = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProvince, $provinceChecked);
        $optionDistrict = FunctionLib::getOption(['' => '---Chọn---'] + $arrDistrictChecked, $districtChecked);
        $optionWard = FunctionLib::getOption(['' => '---Chọn---'] + $arrWardChecked, $wardsChecked);

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = (isset($request['objectId']) && trim($request['objectId']) != '0') ? 1 : 0;

        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'optionMonth' => $optionMonth,
            'optionYear' => $optionYear,

            'optionDanhXung' => $optionDanhXung,
            'optionDonViThoiGian' => $optionDonViThoiGian,
            'optionHinhThucThanhToan' => $optionHinhThucThanhToan,
            'optionPhamViDiaLy' => $optionPhamViDiaLy,
            'optionDonViGiamGia' => $optionDonViGiamGia,
            'optionDonViThuHuong' => $optionDonViThuHuong,
            'optionPhamViBaoHiem' => $optionPhamViBaoHiem,
            'optionThoiHanThanhToan' => $optionThoiHanThanhToan,
            'optionKieuFile' => $optionKieuFile,
            'optionProductType' => $optionProductType,
            'optionOrg' => $optionOrg,

            'optionProvince' => $optionProvince,
            'optionDistrict' => $optionDistrict,
            'optionWard' => $optionWard,

            //arr product cấp đơn
            'arrProductType' => $this->arrProductType,
            'arrProductShow' => $this->arrProductShow,
            'arrProductHide' => $this->arrProductHide,

            'arrGender' => $this->arrGender,
            'arrDanhXung' => $this->arrDanhXung,

            'org_code_user' => $this->user['org_code'],
            'user_name_login' => $this->user['user_name'],
            'arrPermissionInspection' => json_encode($arrPermissionInspection, true),

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route($this->routerIndex),
            'urlSearchAjax' => URL::route('insurancePolicy.getSearchAjax'),
            'formSeachIndex' => 'formSeachIndex',
            'urlGetItem' => URL::route('insurancePolicy.ajaxGetItem'),
            'urlPostItem' => URL::route('insurancePolicy.ajaxPostItem'),
            'urlAjaxGetData' => URL::route('insurancePolicy.ajaxGetData'),
            'urlActionOtherItem' => '',
            'urlSearchOtherItem' => '',
            'urlUpdateStatusOtherItem' => '',
            'urlUpdateStatusItem' => '',
            'functionAction' => '_ajaxGetItemOther',
        ];
    }

    /*********************************************************************************************************
     * Danh mục: Cấp đơn bảo hiểm
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Cấp đơn bảo hiểm';
        CGlobal::$pageAdminTitle = $this->pageTitle . ' - Cấp đơn ' . CGlobal::$arrTitleProject[$this->tab_top];

        $page_no = (int)Request::get('page_no', 1);
        $this->_setDefaultProduct();

        $category = addslashes(Request::get('p_category', $this->p_category_default));
        $search["p_category"] = $category;
        $search["p_category_code"] = isset($this->arrCategoryCode[$category]) ? $this->arrCategoryCode[$category] : $category;

        if(in_array($this->p_product_code_default,$this->arrProductUser)){
            $product_code = trim(addslashes(Request::get('p_product_code', $this->p_product_code_default)));
        }else{
            $product_code = !empty($this->arrProductUser)? array_key_first($this->arrProductUser): DATA_SEARCH_NULL;
        }
        $search["p_product_code"] = addslashes(Request::get('p_product_code', $product_code));

        $search['is_success_defaul'] = addslashes(Request::get('is_success_defaul', STATUS_INT_KHONG));//mặc định 0 all,1: chưa hoàn thành
        $search["p_is_success"] = $search['is_success_defaul'];
        $search["p_month"] = addslashes(Request::get('p_month', getTimeCurrent('m')));
        $search["p_year"] = addslashes(Request::get('p_year', getTimeCurrent('y')));
        $search["p_status"] = addslashes(Request::get('p_status', ''));
        $search["p_eff_date"] = addslashes(Request::get('p_eff_date', ''));
        $search["p_exp_date"] = addslashes(Request::get('p_exp_date', ''));

        $search["p_name_insured"] = addslashes(Request::get('p_name_insured', ''));
        $search["p_idcard"] = addslashes(Request::get('p_idcard', ''));
        $search["p_cer_no"] = addslashes(Request::get('p_cer_no', ''));
        $search["p_org_seller"] = addslashes(Request::get('p_org_seller', ''));
        $search['page_no'] = $page_no;

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchInsurancePolicy($search);
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
            'category' => $category,
            'product_code' => $search["p_product_code"],
            'pageTitle' => $this->pageTitle,
        ], $this->dataOutCommon));
    }

    public function getSearchAjax()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT], $this->routerIndex)) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_GET;
        $dataForm = $request['dataForm'];
        $this->_setDefaultProduct();
        $div_show = (isset($dataForm['div_show']) && trim($dataForm['div_show']) != '') ? $dataForm['div_show'] : '';
        $page_no = (isset($dataForm['page_no']) && trim($dataForm['page_no']) != '') ? $dataForm['page_no'] : STATUS_INT_MOT;
        $category = (isset($dataForm['p_category']) && trim($dataForm['p_category']) != '') ? $dataForm['p_category'] : $this->p_category_default;
        $product_code = (isset($dataForm['p_product_code']) && trim($dataForm['p_product_code']) != '') ? $dataForm['p_product_code'] : $this->p_product_code_default;
        $search["p_category"] = $category;
        $search["p_category_code"] = isset($this->arrCategoryCode[$category]) ? $this->arrCategoryCode[$category] : $category;
        $search["p_product_code"] = $product_code;

        //$search["p_category_code"] = CATEGORY_ATTD;
        $search['is_success_defaul'] = (isset($dataForm['is_success_defaul']) && trim($dataForm['is_success_defaul']) != '') ? $dataForm['is_success_defaul'] : STATUS_INT_KHONG;
        $search["p_is_success"] = $search['is_success_defaul'];
        $search["p_month"] = (isset($dataForm['p_month']) && trim($dataForm['p_month']) != '') ? $dataForm['p_month'] : getTimeCurrent('m');
        $search["p_year"] = (isset($dataForm['p_year']) && trim($dataForm['p_year']) != '') ? $dataForm['p_year'] : getTimeCurrent('y');
        $search["p_status"] = (isset($dataForm['p_status']) && trim($dataForm['p_status']) != '') ? $dataForm['p_status'] : '';
        $search["p_eff_date"] = (isset($dataForm['p_eff_date']) && trim($dataForm['p_eff_date']) != '') ? $dataForm['p_eff_date'] : '';
        $search["p_exp_date"] = (isset($dataForm['p_exp_date']) && trim($dataForm['p_exp_date']) != '') ? $dataForm['p_exp_date'] : '';

        $search["p_name_insured"] = (isset($dataForm['p_name_insured']) && trim($dataForm['p_name_insured']) != '') ? $dataForm['p_name_insured'] : '';
        $search["p_idcard"] = (isset($dataForm['p_idcard']) && trim($dataForm['p_idcard']) != '') ? $dataForm['p_idcard'] : '';
        $search["p_cer_no"] = (isset($dataForm['p_cer_no']) && trim($dataForm['p_cer_no']) != '') ? $dataForm['p_cer_no'] : '';
        $search["p_org_seller"] = (isset($dataForm['p_org_seller']) && trim($dataForm['p_org_seller']) != '') ? $dataForm['p_org_seller'] : '';
        $search['page_no'] = $page_no;

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchInsurancePolicy($search);
        //myDebug($result);
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data']['data'] ?? $dataList;
            $total = $result['Data']['total'] ?? $total;
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);

        $tableTemplateView = isset($this->arrProductType[$product_code]['templateView']) ? $this->arrProductType[$product_code]['templateView'] : '_tableListATTD';
        $templateOut = $this->templateRoot . 'component.tableList.' . $tableTemplateView;

        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $dataList,
                'search' => $search,
                'total' => $total,
                'stt' => ($page_no - 1) * $limit,
                'paging' => $paging,
                'category' => $category,
                'product_code' => $product_code,
                'pageTitle' => $this->pageTitle,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowId' => $div_show, 'message' => '');
        return Response::json($arrAjax);
    }

    /*********************************************************************************************************************
     * Đang không dùng phần này
     *********************************************************************************************************************/
    /**************************************************
     * Chi tiết đơn
     * ************************************************/
    public function ajaxGetItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT], $this->routerIndex)) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $request = $_GET;
        $arrAjax = $this->_getInfoItem($request);
        return Response::json($arrAjax);
    }

    private function _getInfoItem($request)
    {
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'], true) : false;
        $arrKey = isset($dataInput['arrKey']) ? $dataInput['arrKey'] : [];
        $detailOrder = $listContracts = $detailInforDetail = $listInforContract = [];

        if (!empty($arrKey)) {
            $dataGet = $this->modelObj->getDettailOrderInsurance($arrKey);
            if (isset($dataGet['Success']) && $dataGet['Success'] == STATUS_INT_MOT) {
                //Chi tiết hợp đồng vay
                $detailOrder = isset($dataGet['Data'][0][0]) ? $dataGet['Data'][0][0] : [];
                $listContracts = isset($dataGet['Data'][1]) ? $dataGet['Data'][1] : [];

                //tab: thông tin hợp đồng vay
                $detailInforDetail = isset($dataGet['Data'][2][0]) ? $dataGet['Data'][2][0] : [];
                $listInforContract = isset($dataGet['Data'][3]) ? $dataGet['Data'][3] : [];
            }
        }
        $this->_outDataView($request, (array)$detailOrder);
        $templateDetail = isset($request['templateDetailItem']) ? $request['templateDetailItem'] : 'popupDetail';

        $html = View::make($this->templateRoot . 'component.' . $templateDetail)
            ->with(array_merge([
                'data' => $detailOrder,
                'detailOrder' => $detailOrder,
                'listContracts' => $listContracts,
                'detailInforDetail' => $detailInforDetail,
                'listInforContract' => $listInforContract,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $divShowInfor = isset($request['divShowInfor']) ? $request['divShowInfor'] : 'formShowEditSuccess';//div show infor item
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor);
        return $arrAjax;
    }

    public function ajaxPostItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT], $this->routerIndex)) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $dataRequest = $_POST;
        $dataForm = $dataRequest['dataForm'] ?? [];
        $id = $dataForm['objectId'] ?? 0;
        if (empty($dataForm)) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }
        if ($this->_validFormData($id, $dataForm) && empty($this->error)) {
            $result = $this->modelObj->editOrderPolicy($dataForm, ($id > 0) ? 'EDIT' : 'ADD');
            if ($result['Success'] == STATUS_INT_MOT) {
                //EDIT: lấy lại dữ liệu đã cập nhật để hiển thị lại
                if ($id > 0) {
                    $request['objectId'] = $id;
                    $request['formName'] = $dataForm['formName'];
                    $request['divShowInfor'] = 'formShowEditSuccess';
                    $request['templateDetailItem'] = '_detailFormItem';
                    $request['dataInput'] = json_encode(['item' => $dataForm]);
                    $arrAjax = $this->_getInfoItem($request);

                } //ADD: thêm mới thì load lại dư liệu để nhập các thông tin khác
                else {
                    $request['objectId'] = 1;
                    $request['divShowInfor'] = 'divDetailItem';
                    $request['dataInput'] = json_encode(['item' => $dataForm]);
                    $arrAjax = $this->_getInfoItem($request);
                }
                return Response::json($arrAjax);
            } else {
                return Response::json(returnError($result['Message']));
            }
        } else {
            return Response::json(returnError($this->error));
        }
    }

    /**
     * Get data tab
     */
    public function ajaxGetData()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW], $this->routerIndex)) {
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

    private function _ajaxGetDataOfTab($request)
    {
        $data = $inforItem = [];
        $formNameOther = isset($request['formName']) ? $request['formName'] : 'formName';
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'], true) : false;
        $typeTab = isset($dataInput['type']) ? $dataInput['type'] : '';
        $action = isset($dataInput['action']) ? $dataInput['action'] : 'getDetailItemOther';
        $isDetail = isset($dataInput['isDetail']) ? $dataInput['isDetail'] : STATUS_INT_KHONG;
        $arrOtherForm = isset($dataInput['itemOther']) ? $dataInput['itemOther'] : [];
        $arrKey = isset($dataInput['arrKey']) ? $dataInput['arrKey'] : [];

        //myDebug($request);
        $actionEdit = STATUS_INT_KHONG;
        $objectId = $request['objectId'];
        $templateOut = $this->templateRoot . 'component._contractList';

        switch ($typeTab) {
            case $this->tabOtherItem1:
                //Chi tiết hợp đồng
                $templateOut = $this->templateRoot . 'component._contractList';
                break;
            case $this->tabOtherItem2:
                $this->dataOutItem = [
                    'arrProductOther' => []
                ];
                $templateOut = $this->templateRoot . 'component._inforListLoan';
                break;
            default:
                break;
        }
        $this->_outDataView($request, (array)$data);
        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $data,
                'dataOther' => $inforItem,
                'actionEdit' => $actionEdit,//0: thêm mới, 1: edit
                'objectId' => $objectId,
                'formNameOther' => $formNameOther,
                'typeTab' => $typeTab,
                'divShowId' => $typeTab,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        return $html;
    }

    /**
     * Get data Other Item
     */
    private function _getDetailContract($request)
    {
        $data = $inforItem = [];
        $formNameOther = isset($request['formName']) ? $request['formName'] : 'formName';
        $dataInput = isset($request['dataInput']) ? json_decode($request['dataInput'], true) : false;
        $arrKey = isset($dataInput['arrKey']) ? $dataInput['arrKey'] : [];

        //myDebug($arrKey);
        $templateOut = $this->templateRoot . 'component._inforDetailLoan';

        $inforFormBlock1 = $inforFormBlock2 = $inforFormBlock3 = $historyPayment4 = [];
        if (!empty($arrKey)) {
            $dataGet = $this->modelObj->getDettailContractInsurance($arrKey);
            if (isset($dataGet['Success']) && $dataGet['Success'] == STATUS_INT_MOT) {
                //Thông tin gói
                $inforFormBlock1 = isset($dataGet['Data'][0][0]) ? $dataGet['Data'][0][0] : [];

                //Thông tin vay, NĐBH, cán bộ ngân hàng
                $inforFormBlock2 = isset($dataGet['Data'][1][0]) ? $dataGet['Data'][1][0] : [];

                //tỉnh thành quận huyện
                $data2 = (array)$inforFormBlock2;
                $provinceChecked = (isset($data2['PROVINCE']) && !empty($data2['PROVINCE'])) ? $data2['PROVINCE'] : '';
                $districtChecked = (isset($data2['DISTRICT']) && !empty($data2['DISTRICT'])) ? $data2['DISTRICT'] : '';
                $wardsChecked = (isset($data2['WARDS']) && !empty($data2['WARDS'])) ? $data2['WARDS'] : '';

                $arrDistrictChecked = app(Province::class)->getOptionDistrict($provinceChecked);
                $arrWardChecked = app(Province::class)->getOptionWard($districtChecked);

                $optionProvinceContract = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProvince, $provinceChecked);
                $optionDistrictContract = FunctionLib::getOption(['' => '---Chọn---'] + $arrDistrictChecked, $districtChecked);
                $optionWardContract = FunctionLib::getOption(['' => '---Chọn---'] + $arrWardChecked, $wardsChecked);
                $optionDonViThuHuongContract = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrDonViThuHuong, isset($data2['BEN_ORG_CODE']) ? $data2['BEN_ORG_CODE'] : '');
                $optionDonViThoiGianContract = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrDonViThoiGian, isset($data['GENDER']) ? $data['GENDER'] : '');
                $optionDanhXungContract = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrDanhXung, isset($data2['GENDER']) ? $data2['GENDER'] : '');

                //danh sách file upload
                $listFile = isset($dataGet['Data'][2]) ? $dataGet['Data'][2] : [];
                if (!empty($listFile)) {
                    $arrTypeFile = ['GYC', 'CMND', 'KHAC'];
                    foreach ($listFile as $kf => $valFile) {
                        if (in_array($valFile->FILE_TYPE, $arrTypeFile))
                            $inforFormBlock3[$valFile->FILE_TYPE][] = $valFile;
                    }
                }

                //Thông tin vay, NĐBH, cán bộ ngân hàng
                $historyPayment4 = isset($dataGet['Data'][3]) ? $dataGet['Data'][3] : [];
            }
        }
        $this->_outDataView($request, (array)$data);
        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $data,
                'inforFormBlock1' => $inforFormBlock1,
                'inforFormBlock2' => $inforFormBlock2,
                'inforFormBlock3' => $inforFormBlock3,
                'historyPayment4' => $historyPayment4,
                'objectId' => 1,

                'optionProvinceContract' => $optionProvinceContract,
                'optionDistrictContract' => $optionDistrictContract,
                'optionWardContract' => $optionWardContract,
                'optionDonViThuHuongContract' => $optionDonViThuHuongContract,
                'optionDonViThoiGianContract' => $optionDonViThoiGianContract,
                'optionDanhXungContract' => $optionDanhXungContract,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        return $html;
    }

    public function ajaxGetDetailContract()
    {
        $param = $_POST;
        $arrKey = ['CONTRACT_CODE' => $param['contract_code'], 'CATEGORY' => $param['category'], 'PRODUCT_CODE' => $param['product_code']];
        $detail_code = '';
        $arrAjax = array('success' => 0, 'detail_code' => $detail_code);
        if (!empty($arrKey)) {
            $dataGet = $this->modelObj->getDettailOrderInsurance($arrKey);
            if (isset($dataGet['Success']) && $dataGet['Success'] == STATUS_INT_MOT) {
                //Chi tiết hợp đồng vay
                $listContracts = isset($dataGet['Data'][1]) ? $dataGet['Data'][1] : [];
                if (!empty($listContracts)) {
                    foreach ($listContracts as $key => $contracts) {
                        $detail_code = $contracts->DETAIL_CODE;
                        break; // lấy phần tử đầu tiên
                    }
                }
                $arrAjax = array('success' => 1, 'detail_code' => $detail_code);
            }
        }
        return Response::json($arrAjax);
    }

}
