<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Sellings\ClaimIndemnify;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\OpenId\Organization;
use App\Http\Models\Report\ReportProduct;
use App\Http\Models\Selling\ClaimHdi;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use App\Services\ActionExcel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class ClaimHdiController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $arrOrgAll = array();
    private $arrChannel = array();
    private $arrProductType = array();
    private $arrProduct = array();
    public $arrProCodeVietJet = [PRODUCT_CODE_BAY_AT, PRODUCT_CODE_LOST_BAGGAGE];

    private $templateRoot = DIR_PRO_SELLING . '/' . DIR_MODULE_CLAIM_INDEMNIFY . '.ClaimHdi.';
    private $templateVietJet = DIR_PRO_SELLING . '/' . DIR_MODULE_CLAIM_INDEMNIFY . '.ClaimVietJet.';

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';
    private $routerIndex = 'claimHdi.index';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new ClaimHdi();

        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_CLAIM_STATUS);
        $this->arrChannel = $this->getArrOptionTypeDefine(DEFINE_CHANNEL_HDI);
        $this->arrOrgAll = app(Organization::class)->getArrOptionOrg();

    }

    private function _outDataView($request, $data)
    {
        $request['p_status_form'] = Request::get('p_status', []);//ko dùng cho param
        $request['p_status'] = Request::get('p_status','');//ko dùng cho param
        if (is_array($request['p_status_form'])){
            $request['p_status'] = !empty($request['p_status_form']) ? implode(';', $request['p_status_form']) : '';
        }

        $optionStatus = FunctionLib::getOptionMultil($this->arrStatus, (isset($request['p_status']) && trim($request['p_status'])) ? explode(';', $request['p_status']) : []);
        $optionChannel = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrChannel, isset($data['p_channel']) ? $data['p_channel'] : '');
        $optionOrg = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrOrgAll, isset($data['p_org_code']) ? $data['p_org_code'] : '');
        $optionProduct = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrProductUser, (isset($data['p_product_code']) && trim($data['p_product_code']) != '') ? $data['p_product_code'] : array_key_first($this->arrProductUser));

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = (isset($request['objectId']) && trim($request['objectId']) != '0') ? 1 : 0;

        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'optionChannel' => $optionChannel,
            'optionOrg' => $optionOrg,
            'optionProduct' => $optionProduct,

            'arrProductType' => $this->arrProductType,
            'arrStatus' => $this->arrStatus,
            'org_code_user' => $this->user['org_code'],

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route('claimHdi.index'),
            'urlGetItem' => URL::route('claimHdi.ajaxGetItem'),
            'urlPostItem' => URL::route('claimHdi.ajaxPostItem'),
            'urlAjaxGetData' => URL::route('claimHdi.ajaxGetData'),
            'urlChangeProcess' => URL::route('claimHdi.ajaxChangeProcess'),
            'userAction' => $this->user,
            'urlServiceFile' => Config::get('config.URL_HYPERSERVICES_' . Config::get('config.ENVIRONMENT')) . 'f/',
            'functionAction' => '_ajaxGetItemOther',
            'urlSearchAjax' => URL::route('claimHdi.getSearchAjax'),
            'formSeachIndex' => 'formSeachIndex',
        ];
    }

    /*********************************************************************************************************
     * Danh sách bồi thường
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }

        $this->pageTitle = CGlobal::$pageAdminTitle = 'Danh sách bồi thường HDI';
        CGlobal::$pageAdminTitle = $this->pageTitle . ' - Cấp đơn ' . CGlobal::$arrTitleProject[$this->tab_top];
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 0);
        $dataForm['p_product_code'] =!empty($this->arrProductUser)? addslashes(Request::get('p_product_code', array_key_last($this->arrProductUser))):DATA_SEARCH_NULL;
        $search = $this->modelObj->getParamSearch($dataForm);

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchClaimHdi($search);

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

        ], $this->dataOutCommon));
    }

    public function getSearchAjax()
    {
        $request = $_GET;
        $dataForm = $request['dataForm'];

        $product_code = trim(addslashes(Request::get('p_product_code', '')));
        if(!in_array($product_code,array_keys($this->arrProductUser))){
            $product_code = !empty($this->arrProductUser)? array_key_first($this->arrProductUser): DATA_SEARCH_NULL;
        }
        $dataForm['p_product_code'] = $product_code;
        $div_show = (isset($dataForm['div_show']) && trim($dataForm['div_show']) != '') ? $dataForm['div_show'] : '';
        $template_out = (isset($dataForm['template_out']) && trim($dataForm['template_out']) != '') ? $dataForm['template_out'] : 'ClaimHDI';
        $page_no = (isset($dataForm['page_no']) && trim($dataForm['page_no']) != '') ? $dataForm['page_no']: (int)Request::get('page_no', 1);

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $search = $this->modelObj->getParamSearch($dataForm);
        $result = $this->modelObj->searchClaimHdi($search);
        /*myDebug($dataForm,false);
        myDebug($search,false);
        myDebug($result,true);*/
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data'][0] ?? $dataList;
            $total = isset($dataList[0]->TOTAL) ? $dataList[0]->TOTAL : $total;
        }

        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';
        $this->_outDataView($_GET, $search);

        switch ($template_out){
            case 'ClaimVietJet':
                $templateOut = $this->templateVietJet . 'component._tableClaimVietJet';
                break;
            case 'ReportClaimVietJet':
                $templateOut = DIR_PRO_REPORT . '.claim._tableClaim_VIETJET';//report
                break;
            default:
                $templateOut = $this->templateRoot . 'component._tableClaim';
                break;
        }


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

    /**************************************************
     * Chi tiết hợp đồng thanh toán
     * ************************************************/
    public function ajaxGetItem()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT],$this->routerIndex)) {
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
        $dataItem = isset($dataInput['item']) ? $dataInput['item'] : [];
        $detailClaim = $inforDetailExten = $desRequestClaim = $listFileAttach = $listTimeLine = $listDuocBoiThuong = [];
        if (!empty($arrKey)) {
            $search['p_org_code'] = isset($arrKey['ORG_CODE']) ? $arrKey['ORG_CODE'] : '';
            $search['p_product_code'] = isset($arrKey['PRODUCT_CODE']) ? $arrKey['PRODUCT_CODE'] : '';
            $search['p_claim_code'] = isset($arrKey['CLAIM_CODE']) ? $arrKey['CLAIM_CODE'] : '';
            $search['p_type'] = 'DETAIL';
            $dataGet = $this->modelObj->searchClaimHdi($search);

            if (isset($dataGet['Success']) && $dataGet['Success'] == STATUS_INT_MOT) {
                //0--Thong tin claim chi tiet
                $detailClaim = isset($dataGet['Data'][0][0]) ? $dataGet['Data'][0][0] : [];

                //1--Thong tin claim chi tiet exten
                $inforDetailExten = isset($dataGet['Data'][1]) ? $dataGet['Data'][1] : [];

                //2--Thong tin mo ta yeu cau boi thuong
                $resultRequest = isset($dataGet['Data'][2]) ? $dataGet['Data'][2] : [];
                foreach ($resultRequest as $key => $valu) {
                    if (isset($desRequestClaim[$valu->BEN_CODE]['ARR_LIST'])) {
                        $desRequestClaim[$valu->BEN_CODE]['ARR_LIST'][] = ['DEC_DESC' => $valu->DEC_DESC, 'DEC_VALUE' => $valu->DEC_VALUE];
                    } else {
                        $desRequestClaim[$valu->BEN_CODE]['BEN_NAME'] = $valu->BEN_NAME;
                        $desRequestClaim[$valu->BEN_CODE]['ARR_LIST'][] = ['DEC_DESC' => $valu->DEC_DESC, 'DEC_VALUE' => $valu->DEC_VALUE];
                    }
                }

                //3--Thong tin giay to di kem
                $resultFiles = isset($dataGet['Data'][3]) ? $dataGet['Data'][3] : [];
                foreach ($resultFiles as $key2 => $valu2) {
                    if (isset($listFileAttach[$valu2->GROUP_ID]['ARR_LIST'])) {
                        $listFileAttach[$valu2->GROUP_ID]['ARR_LIST'][] = (array)$valu2;
                    } else {
                        $listFileAttach[$valu2->GROUP_ID]['GROUP_NAME'] = $valu2->GROUP_NAME;
                        $listFileAttach[$valu2->GROUP_ID]['ARR_LIST'][] = (array)$valu2;
                    }
                }

                //4--Thong tin tien trinh xu ly
                $listTimeLine = isset($dataGet['Data'][4]) ? $dataGet['Data'][4] : [];

                //5--list danh sách bồi thường nếu có
                $listDuocBoiThuong = isset($dataGet['Data'][5]) ? $dataGet['Data'][5] : [];
            }
        }
        $this->_outDataView($request, (array)$detailClaim);
        $templateDetail = isset($request['templateDetailItem']) ? $request['templateDetailItem'] : 'popupDetail';
        $html = View::make($this->templateRoot . 'component.' . $templateDetail)
            ->with(array_merge([
                'data' => $detailClaim,
                'dataItem' => $dataItem,
                'inforDetailExten' => $inforDetailExten,
                'desRequestClaim' => $desRequestClaim,
                'listFileAttach' => $listFileAttach,
                'listTimeLine' => $listTimeLine,
                'listDuocBoiThuong' => $listDuocBoiThuong,
                'arrKeyDetail' => $arrKey,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $divShowInfor = isset($request['divShowInfor']) ? $request['divShowInfor'] : 'formShowEditSuccess';//div show infor item
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor);
        return $arrAjax;
    }

    /**************************************************
     * Get data tab
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
            if (is_array($html)) {
                return Response::json($html);
            } else {
                $success = STATUS_INT_MOT;
            }
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
        $listBoiThuongChose = isset($dataInput['listDuocBoiThuong']) ? $dataInput['listDuocBoiThuong'] : [];
        $typeTab = isset($dataInput['type']) ? $dataInput['type'] : (isset($request['type']) ? $request['type'] : '');
        $dataClaim = isset($dataInput['dataClaim']) ? $dataInput['dataClaim'] : [];
        $dataItem = isset($dataInput['dataItem']) ? $dataInput['dataItem'] : [];
        $objectId = isset($request['objectId']) ? $request['objectId'] : '';
        $templateOut = $this->templateRoot . 'component._popupChangeStatus';

        switch ($typeTab) {
            //get popup chuyển đổi  trạng thái
            case 'getChangeStatus':
                $search['p_org_code'] = isset($dataClaim['ORG_CODE']) ? $dataClaim['ORG_CODE'] : '';
                $search['p_product_code'] = isset($dataClaim['PRODUCT_CODE']) ? $dataClaim['PRODUCT_CODE'] : '';
                $search['p_claim_code'] = isset($dataClaim['CLAIM_CODE']) ? $dataClaim['CLAIM_CODE'] : '';
                $search['p_type'] = 'LIST_BEN';
                $dataGet = $this->modelObj->searchClaimHdi($search);

                $listBoiThuong = $arrOptionBoiThuong = [];
                if (isset($dataGet['Success']) && $dataGet['Success'] == STATUS_INT_MOT) {
                    //get list bồi thường table
                    foreach ($dataGet['Data'][0] as $kk => $val_option) {
                        $arrOptionBoiThuong[$val_option->BEN_CODE] = $val_option->BEN_NAME;
                    }
                    $listBoiThuong = isset($dataGet['Data'][0]) ? $dataGet['Data'][0] : [];
                }
                $optionStatusPopup = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($dataClaim['STATUS']) ? $dataClaim['STATUS'] : '');
                $optionBoiThuong = FunctionLib::getOption(['' => '---Chọn---'] + $arrOptionBoiThuong, '');
                $this->dataOutItem = [
                    'listBoiThuongChose' => $listBoiThuongChose,
                    'listBoiThuong' => $listBoiThuong,
                    'optionBoiThuong' => $optionBoiThuong,
                    'optionStatusPopup' => $optionStatusPopup,
                    'urlAddInforClaim' => URL::route('claimHdi.ajaxChangeProcess'),
                ];
                $templateOut = $this->templateRoot . 'component._popupChangeStatus';
                break;
            case 'addInforClaim':
                $listBoiThuong = [];
                $dataClaimChose = isset($request['dataClaimChose']) ? $request['dataClaimChose'] : [];
                $valu_claim_chose = $request['valu_claim_chose'];
                if ($valu_claim_chose == 'KHAC') {
                    $inforClaim = [];
                    $inforClaim['BEN_CODE'] = 'KHAC_' . count($dataClaimChose);
                    $inforClaim['BEN_NAME'] = '';
                    $listBoiThuong[] = (object)$inforClaim;
                } else {
                    if (!empty($dataClaimChose) && in_array($valu_claim_chose, $dataClaimChose)) {
                        $arrAjax = array('success' => 0, 'message' => 'Quyền lợi bồi thường này đã tồn tại');
                        return $arrAjax;
                    }

                    $listBoiThuongInput = isset($request['listBoiThuong']) ? json_decode($request['listBoiThuong'], false) : false;
                    //myDebug($listBoiThuongInput);
                    if (!empty($listBoiThuongInput)) {
                        foreach ($listBoiThuongInput as $kk => $inforClaim) {
                            if ($inforClaim->BEN_CODE == $valu_claim_chose) {
                                $listBoiThuong[] = $inforClaim;
                            }
                        }
                    }
                }

                $this->dataOutItem = [
                    'listBoiThuong' => $listBoiThuong,
                ];
                $templateOut = $this->templateRoot . 'component._tr_infor_claim';
                break;
            case 'getHistory':
                $templateOut = $this->templateRoot . 'component._popupHistoryTimeLine';
                break;
            case 'getTimeLine':
                $arrKey = isset($dataInput['arrKey']) ? $dataInput['arrKey'] : [];
                $listTimeLine = [];
                if (!empty($arrKey)) {
                    $search['p_org_code'] = isset($arrKey['ORG_CODE']) ? $arrKey['ORG_CODE'] : '';
                    $search['p_product_code'] = isset($arrKey['PRODUCT_CODE']) ? $arrKey['PRODUCT_CODE'] : '';
                    $search['p_claim_code'] = isset($arrKey['CLAIM_CODE']) ? $arrKey['CLAIM_CODE'] : '';
                    $search['p_type'] = 'DETAIL';
                    $dataGet = $this->modelObj->searchClaimHdi($search);
                    if (isset($dataGet['Success']) && $dataGet['Success'] == STATUS_INT_MOT) {
                        //4--Thong tin tien trinh xu ly
                        $resultTimeLine = isset($dataGet['Data'][4]) ? $dataGet['Data'][4] : [];
                        foreach ($resultTimeLine as $key => $valu) {
                            $arrDate = explode(' ', $valu->PROCESSING_DATE);
                            $dateTime = $arrDate[0];
                            $valu->HOURS = $arrDate[1];
                            $valu->WORK_NAME = isset($this->arrStatus[$valu->WORK_ID]) ? $this->arrStatus[$valu->WORK_ID] : $valu->WORK_ID;
                            $listTimeLine[$dateTime][] = $valu;
                        }
                    }
                }
                $this->dataOutItem = [
                    'listTimeLine' => $listTimeLine,
                ];
                $templateOut = $this->templateVietJet . 'component._popupHistoryTimeLine';
                break;
            default:
                break;
        }
        $this->_outDataView($request, (array)$dataClaim);
        $html = View::make($templateOut)
            ->with(array_merge([
                'data' => $data,
                'objectId' => $objectId,
                'formNameOther' => $formNameOther,
                'typeTab' => $typeTab,
                'divShowId' => $typeTab,
                'dataClaim' => $dataClaim,
                'dataItem' => $dataItem,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        return $html;
    }

    /***************************************************
     * Đổi trạng thái của đơn
     * @return \Illuminate\Http\JsonResponse|void
     ***************************************************/
    public function ajaxChangeProcess()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT],$this->routerIndex)) {
            return Response::json(returnError(viewLanguage('Bạn không có quyền thao tác.')));
        }
        $arrAjax = array('success' => 0, 'message' => 'Có lỗi khi thao tác');
        $dataRequest = $_POST;

        $dataForm = isset($dataRequest['dataForm']) ? $dataRequest['dataForm'] : [];
        //quyền lợi bồi thường add thêm
        $arrClaimDiff = [];
        foreach ($dataForm as $ki => $val_i) {
            $k_name = 'name_ben_code_' . $ki;
            if (isset($dataForm[$k_name]) && isset($dataForm[$ki]) && $dataForm[$ki] > 0) {
                $arrClaimDiff[] = ['BEN_CODE' => $ki, 'BEN_NAME' => $dataForm[$k_name], 'SORT' => 1, 'AMOUNT' => $dataForm[$ki]];
            }
        }

        $listBoiThuong = isset($dataForm['listBoiThuong']) ? json_decode($dataForm['listBoiThuong']) : [];
        if (empty($dataForm)) {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không đúng')));
        }
        $dataItem = isset($dataForm['dataItem']) ? json_decode($dataForm['dataItem'], false) : false;
        $dataClaim = isset($dataForm['dataClaim']) ? json_decode($dataForm['dataClaim'], false) : false;

        $claim_status = isset($dataForm['CLAIM_STATUS']) ? $dataForm['CLAIM_STATUS'] : '';
        $note_status = isset($dataForm['NOTE_STATUS']) ? $dataForm['NOTE_STATUS'] : '';
        $pay_date = isset($dataForm['PAY_DATE']) ? $dataForm['PAY_DATE'] : '';

        if (trim($claim_status) == '' || trim($note_status) == '') {
            return Response::json(returnError(viewLanguage('Dữ liệu đầu vào không chính xác! Hãy nhập lại')));
        }
        if ($claim_status == $dataClaim->STATUS) {
            return Response::json(returnError(viewLanguage('Trạng thái trùng với trạng thái hiện tại!')));
        }
        if ($claim_status == 'TTBT' && $pay_date == '') {
            return Response::json(returnError(viewLanguage('Ngày thanh toán phải được chọn!')));
        }
        //list bồi thường
        $dataBoiThuong = [];
        $inforSendMail = [];
        $totalBoiThuong = 0;
        $arrStatusSendMail = ['TCBT', 'TTBT', 'TCKH', 'DYKH'];
        if (in_array($claim_status, $arrStatusSendMail)) {
            if (!empty($listBoiThuong)) {
                foreach ($listBoiThuong as $keybt => $boithuong) {
                    if (in_array($claim_status, ['TTBT'])) {
                        $money = (isset($dataForm['money_' . $boithuong->BEN_CODE]) && trim($dataForm['money_' . $boithuong->BEN_CODE]) != '') ? returnFormatMoney($dataForm['money_' . $boithuong->BEN_CODE]) : 0;
                    } else {
                        $money = (isset($dataForm[$boithuong->BEN_CODE]) && trim($dataForm[$boithuong->BEN_CODE]) != '') ? returnFormatMoney($dataForm[$boithuong->BEN_CODE]) : 0;
                    }
                    $totalBoiThuong = $totalBoiThuong + $money;
                    if ($money > 0) {
                        $arrTem = ['SORT' => $boithuong->SORT,
                            'BEN_CODE' => $boithuong->BEN_CODE,
                            'BEN_NAME' => $boithuong->BEN_NAME,
                            'AMOUNT' => returnFormatMoney($money)
                        ];
                        $arrTemEmail = [
                            'NAME' => $boithuong->BEN_NAME,
                            'VALUE' => numberFormat($money) . MONEY_VND
                        ];
                        $inforSendMail[] = $arrTemEmail;
                        $dataBoiThuong[] = $arrTem;
                    }
                }
            }
        }
        //quyền lợi khác
        if (!empty($arrClaimDiff)) {
            foreach ($arrClaimDiff as $kkk => $val_clai) {
                $money = $val_clai['AMOUNT'];
                $totalBoiThuong = $totalBoiThuong + $money;
                if ($money > 0) {
                    $arrTem = ['SORT' => $val_clai['SORT'],
                        'BEN_CODE' => $val_clai['BEN_CODE'],
                        'BEN_NAME' => $val_clai['BEN_NAME'],
                        'AMOUNT' => returnFormatMoney($money)
                    ];
                    $arrTemEmail = [
                        'NAME' => $val_clai['BEN_NAME'],
                        'VALUE' => numberFormat($money) . MONEY_VND
                    ];
                    $inforSendMail[] = $arrTemEmail;
                    $dataBoiThuong[] = $arrTem;
                }
            }
        }

        $dataApprovel['p_org_code'] = $dataClaim->ORG_CODE;
        $dataApprovel['p_prodcode'] = $dataClaim->PRODUCT_CODE;
        $dataApprovel['p_claim_code'] = $dataClaim->CLAIM_CODE;
        $dataApprovel['p_claim_status'] = $claim_status;
        $dataApprovel['p_staffcode'] = $this->user['user_id'];
        $dataApprovel['p_staffname'] = $this->user['user_full_name'];
        $dataApprovel['p_content'] = $note_status;
        $dataApprovel['p_pay_date'] = (in_array($claim_status, ['TCBT', 'TTBT'])) ? $pay_date : '';
        $dataApprovel['p_pay_claim'] = !empty($dataBoiThuong) ? json_encode($dataBoiThuong) : '';

        $result = $this->modelObj->updateChangeProcess($dataApprovel);
        if ($result['Success'] == STATUS_INT_MOT && isset($result['Data'][0][0]->TYPE) && $result['Data'][0][0]->TYPE == 'SUCCESS') {
            //Gửi mail cho KH nếu có
            //1:có gửi mail: 0: không gửi
            if ($dataForm['IS_SEND_MAIL_ACTION'] == 1 && in_array($claim_status, $arrStatusSendMail)) {
                $so_tien_tu_choi = (in_array($claim_status, ['TCBT', 'TCKH'])) ? $dataItem->REQUIRED_AMOUNT : abs($dataItem->REQUIRED_AMOUNT - $totalBoiThuong);
                $so_tien_tu_choi = ($so_tien_tu_choi > $dataItem->REQUIRED_AMOUNT) ? STATUS_INT_KHONG : $so_tien_tu_choi;
                $dataSendMail = [
                    "DATE" => $pay_date,
                    "CONTRACT_NO" => isset($dataItem->CONTRACT_NO) ? $dataItem->CONTRACT_NO : '',
                    "NAME" => isset($dataItem->NAME) ? $dataItem->NAME : '',
                    "INSURED_NAME" => isset($dataItem->INSURED_NAME) ? $dataItem->INSURED_NAME : '',
                    "REQUIRED_AMOUNT" => isset($dataItem->REQUIRED_AMOUNT) ? numberFormat($dataItem->REQUIRED_AMOUNT) : '',
                    "AMOUNT" => numberFormat($totalBoiThuong),
                    "REFUSED_AMOUNT" => ($so_tien_tu_choi >= 0) ? numberFormat($so_tien_tu_choi) : 0,//số tiền từ chối
                    "REFUSED_CONTENT" => $note_status,//lý do từ chối
                    "ACCOUNT_NAME" => isset($dataItem->ACCOUNT_NAME) ? $dataItem->ACCOUNT_NAME : '',
                    "BANK_ACCOUNT" => isset($dataItem->ACCOUNT_NO) ? $dataItem->ACCOUNT_NO : '',
                    "BANK_NAME" => isset($dataItem->ACCOUNT_BANK) ? $dataItem->ACCOUNT_BANK : '',
                    "DS_DK" => $inforSendMail
                ];
                //myDebug($dataSendMail);
                $emailSend = isset($dataItem->EMAIL) ? $dataItem->EMAIL : '';
                $emailCC = isset($dataClaim->EMAIL) ? $dataClaim->EMAIL : '';
                if (trim($emailSend) != '') {
                    $dataSendMail['TEMP'][] = [
                        "TEMP_CODE" => $claim_status,
                        "PRODUCT_CODE" => $claim_status,
                        "ORG_CODE" => ORG_VIETJET_VN,
                        "TYPE" => "EMAIL",
                        "TO" => $emailSend,//$emailSend,
                        "CC" => $emailCC,
                        "BCC" => CGlobal::mail_test];
                    $this->modelObj->sendMailClaim($dataSendMail);
                }
            }
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

    /*********************************************************************************************************
     * Danh sách bồi thường VietJet
     *********************************************************************************************************/
    public function indexVietJet()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Bồi thường VietJet';
        CGlobal::$pageAdminTitle = $this->pageTitle . ' - Cấp đơn ' . CGlobal::$arrTitleProject[$this->tab_top];
        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 0);

        if(in_array(PRODUCT_CODE_BAY_AT,$this->arrProductUser)){
            $product_code = trim(addslashes(Request::get('p_product_code', PRODUCT_CODE_BAY_AT)));

        }else{
            $product_code = !empty($this->arrProductUser)? array_key_first($this->arrProductUser): DATA_SEARCH_NULL;
        }
        $search = $this->modelObj->getParamSearch([],ORG_VIETJET_VN, $product_code);

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchClaimHdi($search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data'][0] ?? $dataList;
            $total = isset($dataList[0]->TOTAL) ? $dataList[0]->TOTAL : $total;
        }

        if ($submit == STATUS_INT_HAI && !empty($dataList)) {
            $total = count($dataList);
            $dataExcel = ['data' => $dataList, 'total' => $total];
            $this->actionExcel = new ActionExcel();
            $this->actionExcel->exportExcel($dataExcel, ActionExcel::EXPORT_EXCEL_CLAIM_VIETJET);
        }

        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';
        $this->_outDataView($_GET, $search);

        //option sản phẩm
        $arrProductOption = getArrChild($this->arrProduct, $this->arrProCodeVietJet);
        $optionProduct = FunctionLib::getOption(['' => '---Chọn---'] + $arrProductOption, isset($search['p_product_code']) ? $search['p_product_code'] : '');

        $this->dataOutItem = [
            'urlIndex' => URL::route('claimHdi.indexVietJet'),
            'optionProduct' => $optionProduct,
        ];
        return view($this->templateVietJet . 'viewIndex', array_merge([
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
        ], $this->dataOutCommon, $this->dataOutItem));
    }
}