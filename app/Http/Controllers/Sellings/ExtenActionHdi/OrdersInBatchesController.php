<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Sellings\ExtenActionHdi;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\OpenId\Organization;
use App\Http\Models\OpenId\Province;
use App\Http\Models\Selling\ExtenActionHdi;
use App\Http\Models\Selling\PaymentContract;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;
use App\Services\ActionExcel;
use App\Services\ImportExcel;
use App\Services\ServiceCommon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class OrdersInBatchesController extends BaseAdminController
{

    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;
    private $extenHdi = false;

    private $arrStatus = array();
    private $arrProduct = array();

    private $templateRoot = DIR_PRO_SELLING . '/' . DIR_MODULE_EXTEN_ACTION_HDI . '.OrdersInBatches.';

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';
    private $max_file_size = 10000000;//10.000.000

    public function __construct()
    {
        parent::__construct();
        $this->extenHdi = new ExtenActionHdi();
        $this->modelObj = new PaymentContract();
        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_PAY_STATUS);
    }

    private function _outDataView($request, $data)
    {
        $this->arrProduct = $this->getInforUser('product');
        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['p_status']) ? $data['p_status'] : '');

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = (isset($request['objectId']) && trim($request['objectId']) != '0') ? 1 : 0;

        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,
            'org_code_user' => $this->user['org_code'],

            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route('extenHdi.indexOrdersInBatches'),
            'urlActionFunction' => URL::route('extenHdi.ajaxActionFunction'),
            'urlCreateOrder' => URL::route('extenHdi.ajaxCreateOrderInBatches'),
            'urlUpdateProgramme' => URL::route('extenHdi.ajaxUpdateProgramme'),
            'urlPostAddInforPacks' => URL::route('extenHdi.ajaxPostAddInforPacks'),

            'urlGetFormExcel' => URL::route('extenHdi.ajaxGetOrdersInBatches'),
            'urlPostFormExcel' => URL::route('extenHdi.ajaxPostOrdersInBatches'),
            'urlServiceFile' => Config::get('config.URL_HYPERSERVICES_' . Config::get('config.ENVIRONMENT')) . 'f/',
            'functionAction' => '_ajaxGetItemOther',
        ];
    }

    /*********************************************************************************************************
     * Danh sách cấp đơn theo lô
     *********************************************************************************************************/
    public function indexOrdersInBatches()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Cấp đơn theo lô';
        CGlobal::$pageAdminTitle = $this->pageTitle . ' - Cấp đơn ' . CGlobal::$arrTitleProject[$this->tab_top];

        $page_no = (int)Request::get('page_no', 1);
        $submit = (int)Request::get('submit', 1);
        $arrExport = [STATUS_INT_HAI,STATUS_INT_BA];
        $search['p_search_programme_id'] = trim(addslashes(Request::get('p_search_programme_id', '')));
        $search['p_search_product_id'] = trim(addslashes(Request::get('p_search_product_id', '')));
        $search['p_search_contract_no'] = trim(addslashes(Request::get('p_search_contract_no', '')));
        $search['p_search_user_bh'] = trim(addslashes(Request::get('p_search_user_bh', '')));
        $search['p_search_certificate_no'] = trim(addslashes(Request::get('p_search_certificate_no', '')));
        $search['page_no'] = in_array($submit,$arrExport) ? STATUS_INT_KHONG: $page_no;

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->extenHdi->searchDataOrder($search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data']['data'] ?? $dataList;
            $total = $result['Data']['total'] ?? $total;
        }

        if (in_array($submit,$arrExport) && !empty($dataList)) {
            $this->actionExcel = new ActionExcel();
            if($submit == STATUS_INT_HAI){
                $type_export = ActionExcel::EXPORT_ORDERS_IN_BATCHES;
                $file_name = 'Danh sách cấp đơn thu gọn';
            }else{
                $type_export = ActionExcel::EXPORT_ORDERS_IN_BATCHES_DETAIL;
                $file_name = 'Danh sách cấp đơn chi tiết';
            }
            $dataExcel = ['data' => $dataList, 'total' => $total, 'file_name' => $file_name];
            $this->actionExcel->exportExcel($dataExcel, $type_export);
        }

        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';
        $this->_buildDefaultOrder($search);
        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'viewIndex', array_merge([
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,

        ], $this->dataOutCommon, $this->dataOutItem));
    }

    /**************************************************
     * Cập nhật chương trình cấp đơn theo lô
     * ************************************************/
    public function ajaxUpdateProgramme()
    {
        $arrAjax = array('success' => STATUS_INT_KHONG, 'message' => 'Có lỗi khi thao tác');
        $dataForm = $_POST;
        $arrJsonPack = (isset($dataForm['p_package_obj'])) ? json_decode($dataForm['p_package_obj']) : [];
        //nếu sửa chương trình
        $actionUpdate = 'ADD';
        $programme_id = 0;
        $inforProgram = (isset($dataForm['data_infor_program'])) ? json_decode($dataForm['data_infor_program']) : [];
        if (isset($dataForm['p_chose_program_id']) && $dataForm['p_chose_program_id'] > 0) {
            $programme_id = (int)$dataForm['p_chose_program_id'];

            $dataForm['p_progid'] = $programme_id;
            $dataForm['p_programme_name'] = isset($inforProgram->PROG_NAME) ? $inforProgram->PROG_NAME : '';
            $actionUpdate = 'EDIT';
        }
        //Thông tin gói

        $checkPack = isset($dataForm['checkPack']) ? $dataForm['checkPack'] : [];
        if (empty($checkPack)) {
            return Response::json(returnError(viewLanguage('Chưa chọn gói nào để cập nhật')));
        }
        $listPacks = [];
        if (!empty($arrJsonPack)) {
            foreach ($arrJsonPack as $key => $val_pac) {
                if (in_array($val_pac->PACK_CODE, $checkPack)) {
                    //upload file lấy id file
                    $nameFile = 'inputInterest_' . $val_pac->PACK_CODE;
                    $file_id = $val_pac->BENEFIT_URL;
                    $folder = FOLDER_FILE_CREATE_ORDER;
                    if (isset($_FILES[$nameFile]) && count($_FILES[$nameFile]) > 0 && $_FILES[$nameFile]['name'] != '') {
                        $ext_file = 'pdf,PDF';
                        $fileName = app(Upload::class)->uploadFileHdi($nameFile, $folder, $ext_file, $this->max_file_size);
                        if (trim($fileName) != '') {
                            $pathFileUpload = getDirFile($fileName);
                            $file_id = app(ServiceCommon::class)->moveFileToServerStore($pathFileUpload, false);
                            app(Upload::class)->removeFile($folder, $fileName);
                        } else {
                            return Response::json(returnError(viewLanguage('Upload file ko đúng định dạng: ' . $ext_file)));
                        }
                        sleep(3);
                    }
                    $listPacks[] = [
                        'PACK_CODE' => $val_pac->PACK_CODE,
                        'PACK_NAME' => $val_pac->PACK_NAME,
                        'FEES' => $val_pac->FEES,
                        'BENEFIT_URL' => $file_id,
                        'IS_USED' => 1,
                    ];
                }
            }
        }

        if (!empty($listPacks)) {
            $dataForm['p_package_json'] = $listPacks;
        } else {
            return Response::json(returnError(viewLanguage('Chưa có thông tin của gói')));
        }

        //template mail
        $folder = FOLDER_FILE_CREATE_ORDER;
        if (isset($_FILES['inputImageTemplate']) && count($_FILES['inputImageTemplate']) > 0 && $_FILES['inputImageTemplate']['name'] != '') {
            $ext_file = 'html';
            $fileName = app(Upload::class)->uploadFileHdi('inputImageTemplate', $folder, $ext_file, $this->max_file_size);
            if (trim($fileName) != '') {
                $pathFileUpload = getDirFile($fileName);
                $image_id = app(ServiceCommon::class)->moveFileToServerStore($pathFileUpload, false);
                $dataForm['p_temp_email'] = $image_id;
                app(Upload::class)->removeFile($folder, $fileName);
            } else {
                return Response::json(returnError(viewLanguage('Upfile không đính dạng: ' . $ext_file)));
            }
        } else {
            if ($dataForm['p_temp_email'] == '') {
                return Response::json(returnError(viewLanguage('Bạn chưa Upload template email')));
            }
        }

        //template giấy chứng nhận
        if (isset($_FILES['inputImageTemplateCertificate']) && count($_FILES['inputImageTemplateCertificate']) > 0 && $_FILES['inputImageTemplateCertificate']['name'] != '') {
            $ext_file = 'html';
            $fileName2 = app(Upload::class)->uploadFileHdi('inputImageTemplateCertificate', $folder, 'html');
            if (trim($fileName2) != '') {
                $pathFileUpload = getDirFile($fileName2);
                $image_id = app(ServiceCommon::class)->moveFileToServerStore($pathFileUpload, false);
                $dataForm['p_certificate_temp'] = $image_id;
                app(Upload::class)->removeFile($folder, $fileName2);
            } else {
                return Response::json(returnError(viewLanguage('Upfile không đính dạng: ' . $ext_file)));
            }
        } else {
            if ($dataForm['p_certificate_temp'] == '') {
                return Response::json(returnError(viewLanguage('Bạn chưa Upload giấy chứng nhận')));
            }
        }

        if ($this->_validateFormProgramme($dataForm) && empty($this->error)) {
            $result = $this->extenHdi->updateProgramme($dataForm, $actionUpdate);

            if ($result['Success'] == STATUS_INT_MOT) {
                $dataFormProgram = isset($result['Data'][0]) ? $result['Data'][0] : [];
                if (empty($dataFormProgram)) {
                    $responProgramme = $this->extenHdi->getDetailProgrammeId(['programme_id' => $programme_id]);
                    $dataFormProgram = isset($responProgramme['Data'][0]) ? $responProgramme['Data'][0] : [];
                }

                if (!empty($dataFormProgram)) {
                    $title_create_order = $dataFormProgram->PROG_NAME . '- Thời gian từ ' . $dataFormProgram->EFFECTIVE_DATE . ' đến ' . $dataFormProgram->EXPIRATION_DATE;
                    $arrAjax['success'] = 1;
                    $arrAjax['inforProgram'] = (array)$dataFormProgram;
                    $arrAjax['title_create_order'] = $title_create_order;
                    $arrAjax['data_infor_program'] = json_encode($arrAjax['inforProgram']);
                    $arrAjax['chose_program_id'] = $dataFormProgram->PROGID;

                    return Response::json($arrAjax);
                }
                return Response::json($arrAjax);
            } else {
                return Response::json(returnError($result['Message']));
            }
        } else {
            return Response::json(returnError($this->error));
        }
    }

    private function _validateFormProgramme($data = array())
    {
        if (!empty($data)) {
            if (isset($data['check_create_programme']) && $data['check_create_programme'] == 1) {//thêm mới
                if (isset($data['p_programme_name']) && trim($data['p_programme_name']) == '') {
                    $this->error[] = 'Chưa nhập tên Chương trình';
                }
            } else {
                if (isset($data['p_programme_code']) && trim($data['p_programme_code']) == '') {
                    $this->error[] = 'Chưa chọn Chương trình cấp đơn';
                }
            }
            if (isset($data['p_org_buyer']) && trim($data['p_org_buyer']) == '') {
                $this->error[] = 'Chưa chọn Tên khách hàng';
            }
            if (isset($data['p_product']) && trim($data['p_product']) == '') {
                $this->error[] = 'Chưa chọn Sản phẩm';
            }
            if (isset($data['p_contract_no']) && trim($data['p_contract_no']) == '') {
                $this->error[] = 'Chưa nhập Số hợp đồng';
            }
            if (isset($data['p_email_subject']) && trim($data['p_email_subject']) == '') {
                $this->error[] = 'Chưa nhập Tiêu đề Email';
            }
            if (isset($data['p_struct_code']) && trim($data['p_struct_code']) == '') {
                $this->error[] = 'Chưa chọn Phòng ban';
            }
            if (isset($data['p_effective_date']) && trim($data['p_effective_date']) == '') {
                $this->error[] = 'Chưa nhập ngày bắt đầu hiệu lực';
            }
            if (isset($data['p_expiration_date']) && trim($data['p_expiration_date']) == '') {
                $this->error[] = 'Chưa nhập ngày kết thúc hiệu lực';
            }
        }
        return true;
    }

    /***************************************************
     * Cấp đơn theo lô
     ***************************************************/
    public function ajaxCreateOrderInBatches()
    {
        $arrAjax = array('success' => 0, 'message' => 'Có lỗi khi thao tác');
        $dataRequest = $_POST;

        if (isset($dataRequest['p_chose_program_id']) && (int)$dataRequest['p_chose_program_id'] <= 0) {
            return Response::json(returnError(viewLanguage('Chưa chọn chương trình để cấp đơn')));
        }
        if (isset($dataRequest['p_contract_addendum']) && $dataRequest['p_contract_addendum'] == '') {
            return Response::json(returnError(viewLanguage('Số phụ lục hợp động chưa được nhập')));
        }

        $dataForm = $this->_buildDataUpdate($dataRequest);
        $folder = FOLDER_FILE_CREATE_ORDER;
        if (isset($_FILES['inputFilePLHD']) && count($_FILES['inputFilePLHD']) > 0 && $_FILES['inputFilePLHD']['name'] != '') {
            $ext_file = 'pdf,PDF';
            $fileName = app(Upload::class)->uploadFileHdi('inputFilePLHD', $folder, $ext_file, $this->max_file_size*3);
            if (trim($fileName) != '') {
                $pathFileUpload = getDirFile($fileName);
                $image_id = app(ServiceCommon::class)->moveFileToServerStore($pathFileUpload, false);
                $dataForm['file_id_contract'] = $image_id;
                app(Upload::class)->removeFile($folder, $fileName);
            } else {
                return Response::json(returnError(viewLanguage('Upfile không đính dạng: ' . $ext_file)));
            }
        } else {
            $arrAjax['message'] = 'Chưa up file PLHĐ';
            return Response::json(returnError(viewLanguage('Bạn chưa upload file PLHĐ')));
        }

        $result = $this->extenHdi->updateProgramme($dataForm, 'EDIT');
        if (isset($result['Success']) && $result['Success'] == 1) {
            $dataCreateOrder = [
                'urlFile' => '',
                'programme_id' => isset($dataRequest['p_chose_program_id']) ? $dataRequest['p_chose_program_id'] : 0,
                'check_send_sms' => isset($dataRequest['check_send_sms']) ? $dataRequest['check_send_sms'] : 0,
                'check_send_email' => isset($dataRequest['check_send_email']) ? $dataRequest['check_send_email'] : 0,
                'check_create_test' => isset($dataRequest['check_create_test']) ? $dataRequest['check_create_test'] : 0,
                'check_creat_certification' => isset($dataRequest['check_creat_certification']) ? $dataRequest['check_creat_certification'] : 0,
            ];
            //file excel import
            if (isset($_FILES['inputFileExcelOrder']) && count($_FILES['inputFileExcelOrder']) > 0 && $_FILES['inputFileExcelOrder']['name'] != '') {
                $ext_file = 'xlsx,xls';
                $fileName = app(Upload::class)->uploadFileHdi('inputFileExcelOrder', $folder, $ext_file, $this->max_file_size*3);
                if (trim($fileName) != '') {
                    $dataCreateOrder['urlFile'] = getDirFile($fileName);
                    $dataCreateOrder['FileRoot'] = $_FILES;
                } else {
                    return Response::json(returnError(viewLanguage('Upfile không đính dạng: ' . $ext_file)));
                }
            }

            $createrOrder = app(ServiceCommon::class)->moveFileCreateOrder($dataCreateOrder, false);
            if (isset($createrOrder->Success) && $createrOrder->Success) {
                $arrAjax['success'] = 1;
                $arrAjax['urlIndex'] = URL::route('extenHdi.indexOrdersInBatches');
                $arrAjax['message'] = 'Đã nhận được dữ liệu, hệ thống đang xử lý cấp đơn';
                return Response::json($arrAjax);
            } else {
                $arrAjax = array('message' => $createrOrder->ErrorMessage);
                return Response::json($arrAjax);
            }
        }

        return Response::json($arrAjax);
    }

    private function _buildDataUpdate($dataRequest)
    {
        $infor_program = isset($dataRequest['data_infor_program']) ? json_decode($dataRequest['data_infor_program'], true) : [];
        $arrParam = [
            'p_progid' => (isset($infor_program['PROGID'])) ? $infor_program['PROGID'] : 0,
            'p_programme_name' => (isset($infor_program['PROG_NAME'])) ? $infor_program['PROG_NAME'] : '',
            'p_org_buyer' => (isset($infor_program['ORG_BUYER'])) ? $infor_program['ORG_BUYER'] : '',

            'p_product' => (isset($infor_program['PRODUCT_CODE'])) ? $infor_program['PRODUCT_CODE'] : '',
            'p_struct_code' => (isset($infor_program['STRUCT_CODE'])) ? $infor_program['STRUCT_CODE'] : '',
            'p_contract_no' => (isset($dataRequest['p_contract_addendum'])) ? $dataRequest['p_contract_addendum'] : '',

            'p_effective_date' => (isset($infor_program['EFFECTIVE_DATE'])) ? $infor_program['EFFECTIVE_DATE'] : '',
            'p_expiration_date' => (isset($infor_program['EXPIRATION_DATE'])) ? $infor_program['EXPIRATION_DATE'] : '',
            'p_temp_email' => (isset($infor_program['EMAIL_TEMP'])) ? $infor_program['EMAIL_TEMP'] : '',
            'p_certificate_temp' => (isset($infor_program['CERTIFICATE_TEMP'])) ? $infor_program['CERTIFICATE_TEMP'] : '',
            'p_email_subject' => (isset($infor_program['EMAIL_SUBJECT'])) ? $infor_program['EMAIL_SUBJECT'] : '',

            'p_package_json' => (isset($infor_program['PACK_OBJ'])) ? json_decode($infor_program['PACK_OBJ'], true) : [],
            'file_id_contract' => (isset($dataRequest['file_id_contract'])) ? $dataRequest['file_id_contract'] : '',
        ];
        return $arrParam;
    }

    /******************************************************************
     * Hàm điều hướng các action trên page
     ******************************************************************/
    public function ajaxActionFunction()
    {
        $dataRequest = $_POST;
        $functionAction = $dataRequest['functionAction'] ?? '';
        $html = '';
        $success = STATUS_INT_KHONG;
        if (trim($functionAction) != '') {
            return $this->$functionAction($dataRequest);
        }
        $arrAjax = array('success' => $success, 'html' => $html);
        return Response::json($arrAjax);
    }

    /******************************************************************
     * Các hàm Ajax thực thi
     ******************************************************************/
    public function _ajaxTabCreateOrder($request)
    {
        $this->_buildDefaultOrder();
        $this->_outDataView($request, []);
        $templateDetail = 'tabCreateOrder';
        $html = View::make($this->templateRoot . 'component.' . $templateDetail)
            ->with(array_merge([
                'data' => [],
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $divShowInfor = isset($request['divShowId']) ? $request['divShowId'] : 'formShowEditSuccess';//div show infor item
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor);
        return Response::json($arrAjax);
    }

    private function _buildDefaultOrder($dataCheck = [])
    {
        $extenHdi = new ExtenActionHdi();
        $dataInfor = $extenHdi->getDataTabCreateOrder();
        $dataOption = $this->_buildArrayData($dataInfor);

        $optionProgrammes = FunctionLib::getOption(['' => '--Chọn---'] + $dataOption['arrProgrammes'], isset($dataCheck['p_search_programme_id']) ? $dataCheck['p_search_programme_id'] : '');
        $optionProducts = FunctionLib::getOption(['' => '--Chọn---'] + $dataOption['arrProducts'], isset($dataCheck['p_search_product_id']) ? $dataCheck['p_search_product_id'] : '');
        $optionPacks = FunctionLib::getOption(['' => '--Chọn---'] + $dataOption['arrPacks'], '');
        $optionOrg = FunctionLib::getOption(['' => '--Chọn---'] + $dataOption['arrOrg'], '');
        $optionDeparts = FunctionLib::getOption(['' => '--Chọn---'] + $dataOption['arrDeparts'], '');
        $this->dataOutItem = [
            'optionProgrammes' => $optionProgrammes,
            'optionProducts' => $optionProducts,
            'optionPacks' => $optionPacks,
            'optionOrg' => $optionOrg,
            'optionDeparts' => $optionDeparts,
            'dataOption' => $dataOption,
            'dataInfor' => $dataInfor,
        ];
    }

    public function ajaxGetInforProgramme($request)
    {
        $dataOption = isset($request['dataOption']) ? json_decode($request['dataOption'], true) : [];
        $listPacks = [];
        $dataFormProgram = [];
        $title_create_order = 'Chương trình cấp đơn';
        $programme_id = isset($request['programme_id']) ? $request['programme_id'] : '';
        if ($programme_id > 0) {
            $responProgramme = $this->extenHdi->getDetailProgrammeId(['programme_id' => (int)$request['programme_id']]);
            $dataFormProgram = isset($responProgramme['Data'][0]) ? $responProgramme['Data'][0] : [];

            $listPacks = isset($dataFormProgram->PACK_OBJ) ? json_decode($dataFormProgram->PACK_OBJ, true) : [];
            $title_create_order = $dataFormProgram->PROG_NAME . '- Thời gian từ ' . $dataFormProgram->EFFECTIVE_DATE . ' đến ' . $dataFormProgram->EXPIRATION_DATE;
        }

        $arrProgrammes = isset($dataOption['arrProgrammes']) ? $dataOption['arrProgrammes'] : [];
        $arrProducts = isset($dataOption['arrProducts']) ? $dataOption['arrProducts'] : [];
        $arrOrg = isset($dataOption['arrOrg']) ? $dataOption['arrOrg'] : [];
        $arrDeparts = isset($dataOption['arrDeparts']) ? $dataOption['arrDeparts'] : [];

        $optionProgrammes = FunctionLib::getOption(['' => '--Chọn---'] + $arrProgrammes, isset($dataFormProgram->PROGID) ? $dataFormProgram->PROGID : '');
        $optionProducts = FunctionLib::getOption(['' => '--Chọn---'] + $arrProducts, isset($dataFormProgram->PRODUCT_CODE) ? $dataFormProgram->PRODUCT_CODE : '');
        $optionOrg = FunctionLib::getOption(['' => '--Chọn---'] + $arrOrg, isset($dataFormProgram->ORG_BUYER) ? $dataFormProgram->ORG_BUYER : '');//khách hàng
        $optionDeparts = FunctionLib::getOption(['' => '--Chọn---'] + $arrDeparts, isset($dataFormProgram->STRUCT_CODE) ? $dataFormProgram->STRUCT_CODE : '');

        $this->dataOutItem = [
            'optionProgrammes' => $optionProgrammes,
            'optionProducts' => $optionProducts,
            'optionOrg' => $optionOrg,
            'optionDeparts' => $optionDeparts,
            'programme_id' => $programme_id,
            'dataOption' => $dataOption,
            'listPacks' => $listPacks,
            'strPacksJson' => json_encode($listPacks, false),
            'dataFormProgram' => $dataFormProgram,

            'inforProgram' => (array)$dataFormProgram,
            'title_create_order' => $title_create_order,
        ];

        //myDebug($dataFormProgram);
        $this->_outDataView($request, []);
        $templateView = isset($request['templateView']) ? $request['templateView'] : '._inforProgramme';
        $html = View::make($this->templateRoot . 'component.' . $templateView)
            ->with(array_merge([
                'data' => [],
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $divShowInfor = isset($request['divShowId']) ? $request['divShowId'] : 'formShowEditSuccess';//div show infor item
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor, 'dataCreate' => $this->dataOutItem);
        return Response::json($arrAjax);
    }

    //thêm mới pack
    public function ajaxChangeParamPack($request)
    {
        $p_product = isset($request['p_product']) ? $request['p_product'] : '';
        $p_org_buyer = isset($request['p_org_buyer']) ? $request['p_org_buyer'] : '';
        $dataInforCreatOrder = isset($request['dataInforCreatOrder']) ? json_decode($request['dataInforCreatOrder'], false) : [];
        $dataAllPacks = isset($dataInforCreatOrder->Data[2]) ? $dataInforCreatOrder->Data[2] : [];
        $listPacks = [];

        if (!empty($dataAllPacks)) {
            foreach ($dataAllPacks as $key => $val_pac) {
                //if ($p_product == $val_pac->PRODUCT_CODE && $p_org_buyer == $val_pac->ORG_CODE) {
                if ($p_product == $val_pac->PRODUCT_CODE) {
                    $listPacks[] = [
                        'PACK_CODE' => $val_pac->PACK_CODE,
                        'PACK_NAME' => $val_pac->PACK_NAME,
                        'FEES' => $val_pac->FEES,
                        'BENEFIT_URL' => $val_pac->BENEFIT_URL,
                        'IS_USED' => 0,
                    ];
                }
            }
        }

        $this->dataOutItem = [
            'listPacks' => $listPacks,
            'strPacksJson' => json_encode($listPacks, false),
        ];

        $this->_outDataView($request, []);
        $templateView = isset($request['templateView']) ? $request['templateView'] : '._inforProgramme';
        $html = View::make($this->templateRoot . 'component.' . $templateView)
            ->with(array_merge([
                'data' => [],
                'product_code' => $p_product,
                'org_buyer' => $p_org_buyer,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $divShowInfor = isset($request['divShowId']) ? $request['divShowId'] : 'formShowEditSuccess';//div show infor item
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor);
        return Response::json($arrAjax);
    }

    public function ajaxRemoveOrder($request)
    {
        $arrAjax = array('success' => 0, 'message' => 'Có lỗi khi thao tác');
        $programme_id = isset($request['programme_id']) ? $request['programme_id'] : '';
        $product_id = isset($request['product_id']) ? $request['product_id'] : '';
        $contract_no = isset($request['contract_no']) ? $request['contract_no'] : '';
        if (trim($programme_id) != '' && trim($product_id) != '' && trim($contract_no) != '') {
            $paramRemove['programme_id'] = $programme_id;
            $paramRemove['product_id'] = $product_id;
            $paramRemove['contract_no'] = $contract_no;
            $result = $this->extenHdi->removeDataOrder($paramRemove);
            if ($result['Success'] == STATUS_INT_MOT) {
                $arrAjax = array('success' => 1);
                return Response::json($arrAjax);
            }
        } else {
            $arrAjax = array('message' => 'Các tham số chưa có dữ liệu');
            return Response::json($arrAjax);
        }
        return Response::json($arrAjax);
    }

    public function ajaxGenTemplateEmail($request)
    {
        $arrAjax = array('success' => 0, 'message' => 'Có lỗi khi thao tác');
        $programme_id = isset($request['programme_id']) ? $request['programme_id'] : '';
        if ((int)trim($programme_id) > 0) {
            $paramRemove['programme_id'] = $programme_id;
            $result = $this->extenHdi->genTemplateEmailOrder($paramRemove);
            if (isset($result['Success']) && $result['Success'] == 1) {
                $arrAjax['success'] = 1;
                return Response::json($arrAjax);
            } else {
                $arrAjax = array('message' => $result['Message']);
                return Response::json($arrAjax);
            }
        } else {
            $arrAjax = array('message' => 'Các tham số chưa có dữ liệu');
            return Response::json($arrAjax);
        }
    }

    //bổ xung thêm pack
    public function ajaxAddInforPacks($request)
    {
        $p_product = isset($request['p_product']) ? $request['p_product'] : '';
        $p_org_buyer = isset($request['p_org_buyer']) ? $request['p_org_buyer'] : '';
        $p_package_obj = isset($request['p_package_obj']) ? $request['p_package_obj'] : '';// data pack cũ của chương trình
        $dataInforCreatOrder = isset($request['dataInforCreatOrder']) ? json_decode($request['dataInforCreatOrder'], false) : [];
        $dataAllPacks = isset($dataInforCreatOrder->Data[2]) ? $dataInforCreatOrder->Data[2] : [];
        $listPacks = [];

        //lấy thông tin của chương trình nếu có
        $packCheck = [];
        if (trim($p_package_obj) != '') {
            $listPacks = json_decode($p_package_obj, true);
            if (!empty($listPacks)) {
                foreach ($listPacks as $kk => $val_c) {
                    $packCheck[$val_c['PACK_CODE']] = $val_c['PACK_CODE'];
                }
            }
        }

        if (!empty($dataAllPacks)) {
            foreach ($dataAllPacks as $key => $val_pac) {
                if ($p_product == $val_pac->PRODUCT_CODE) {
                    if (!empty($packCheck)) {
                        if (!in_array($val_pac->PACK_CODE, $packCheck)) {
                            $listPacks[] = [
                                'PACK_CODE' => $val_pac->PACK_CODE,
                                'PACK_NAME' => $val_pac->PACK_NAME,
                                'FEES' => $val_pac->FEES,
                                'BENEFIT_URL' => $val_pac->BENEFIT_URL,
                                'IS_USED' => 0,
                            ];
                        }
                    } else {
                        $listPacks[] = [
                            'PACK_CODE' => $val_pac->PACK_CODE,
                            'PACK_NAME' => $val_pac->PACK_NAME,
                            'FEES' => $val_pac->FEES,
                            'BENEFIT_URL' => $val_pac->BENEFIT_URL,
                            'IS_USED' => 0,
                        ];
                    }
                }
            }
        }

        $programme_id = isset($request['programme_id']) ? $request['programme_id'] : '';
        $this->dataOutItem = [
            'programme_id' => $programme_id,
            'listPacks' => $listPacks,
        ];

        $this->_outDataView($request, []);
        $templateView = isset($request['templateView']) ? $request['templateView'] : '._inforProgramme';
        $html = View::make($this->templateRoot . 'component.' . $templateView)
            ->with(array_merge([
                'data' => [],
                'form_id' => 'formUpdatePacks',
                'product_code' => $p_product,
                'org_buyer' => $p_org_buyer,
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $divShowInfor = isset($request['divShowId']) ? $request['divShowId'] : 'formShowEditSuccess';//div show infor item
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => $divShowInfor);
        return Response::json($arrAjax);
    }

    public function ajaxPostAddInforPacks()
    {
        $request = $_POST;
        $arrJsonPack = json_decode($request['str_json_pack']);
        //list gói đã chọn
        $checkPack = isset($request['checkPack']) ? $request['checkPack'] : [];
        if (empty($checkPack)) {
            return Response::json(returnError(viewLanguage('Chưa chọn gói nào để cập nhật')));
        }
        $listPacks = [];
        if (!empty($arrJsonPack)) {
            foreach ($arrJsonPack as $key => $val_pac) {
                if (in_array($val_pac->PACK_CODE, $checkPack)) {
                    //upload file lấy id file
                    $nameFile = 'inputInterest_' . $val_pac->PACK_CODE;
                    $file_id = $val_pac->BENEFIT_URL;
                    $folder = FOLDER_FILE_CREATE_ORDER;
                    if (isset($_FILES[$nameFile]) && count($_FILES[$nameFile]) > 0 && $_FILES[$nameFile]['name'] != '') {
                        $ext_file = 'pdf,PDF';
                        $fileName = app(Upload::class)->uploadFileHdi($nameFile, $folder, $ext_file, $this->max_file_size);
                        if (trim($fileName) != '') {
                            $pathFileUpload = getDirFile($fileName);
                            $file_id = app(ServiceCommon::class)->moveFileToServerStore($pathFileUpload, false);
                            app(Upload::class)->removeFile($folder, $fileName);
                        } else {
                            return Response::json(returnError(viewLanguage('Upfile không đính dạng: ' . $ext_file)));
                        }
                    }

                    $listPacks[] = [
                        'PACK_CODE' => $val_pac->PACK_CODE,
                        'PACK_NAME' => $val_pac->PACK_NAME,
                        'FEES' => $val_pac->FEES,
                        'BENEFIT_URL' => $file_id,
                        'IS_USED' => 1,
                    ];
                }
            }
        }

        $this->dataOutItem = [
            'listPacks' => $listPacks,
            'strPacksJson' => json_encode($listPacks, false),
        ];

        $this->_outDataView($request, []);
        $templateView = '_table_list_packs';
        $html = View::make($this->templateRoot . 'component.' . $templateView)
            ->with(array_merge([
                'data' => [],
            ], $this->dataOutCommon, $this->dataOutItem))->render();
        $arrAjax = array('success' => 1, 'html' => $html, 'divShowInfor' => 'table_list_packs');
        return Response::json($arrAjax);
    }

    private function _buildArrayData($dataInfor)
    {
        $arrProgrammes = $arrProducts = $arrPacks = $arrOrg = $arrDeparts = [];
        $dataProgrammes = isset($dataInfor['Data'][0]) ? $dataInfor['Data'][0] : [];//chương trình
        if (!empty($dataProgrammes)) {
            foreach ($dataProgrammes as $kp => $vp) {
                $arrProgrammes[$vp->PROGID] = $vp->PROG_NAME;
            }
        }
        $dataProducts = isset($dataInfor['Data'][1]) ? $dataInfor['Data'][1] : [];//sản phẩm
        if (!empty($dataProducts)) {
            foreach ($dataProducts as $kpr => $vpr) {
                $arrProducts[$vpr->PRODUCT_CODE] = $vpr->PRODUCT_NAME;
            }
        }
        $dataPack = isset($dataInfor['Data'][2]) ? $dataInfor['Data'][2] : [];//gói
        if (!empty($dataPack)) {
            foreach ($dataPack as $kpa => $vpa) {
                $arrPacks[$vpa->PACK_CODE] = $vpa->PACK_NAME;
            }
        }
        $dataOrg = isset($dataInfor['Data'][3]) ? $dataInfor['Data'][3] : [];//Org
        if (!empty($dataOrg)) {
            foreach ($dataOrg as $ko => $vo) {
                $arrOrg[$vo->ORG_CODE] = $vo->ORG_NAME;
            }
        }
        $dataDepart = isset($dataInfor['Data'][4]) ? $dataInfor['Data'][4] : [];//Phòng ban
        if (!empty($dataDepart)) {
            foreach ($dataDepart as $kd => $vd) {
                $arrDeparts[$vd->STRUCT_CODE] = $vd->STRUCT_NAME;
            }
        }
        return [
            'arrProgrammes' => $arrProgrammes,
            'arrProducts' => $arrProducts,
            'arrPacks' => $arrPacks,
            'arrOrg' => $arrOrg,
            'arrDeparts' => $arrDeparts];
    }

    public function ajaxImportOrderInBatches()
    {
        $request = $_POST;
        if (!isset($_FILES['import']) || empty($_FILES['import'])) {
            return $this->salesNetworkService->returnError(viewLanguage('API_INVALID_PARAMETERS'));
        }
        $importExcel = new ImportExcel();
        $data = $importExcel->importOrderInBatches($request, $_FILES);
        return Response::json($data);
    }
}