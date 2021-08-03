<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/
namespace App\Http\Controllers\Sellings\ExtenActionHdi;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Selling\ExtenActionHdi;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class DigitallySignedController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $templateRoot = DIR_PRO_SELLING . '/' . DIR_MODULE_EXTEN_ACTION_HDI . '.DigitallySigned.';

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new ExtenActionHdi();
        $this->arrStatus = $this->getArrOptionTypeDefine(DEFINE_PAY_STATUS);
    }

    private function _outDataView($request, $data)
    {
        $optionStatus = FunctionLib::getOption(['' => '---Chọn---'] + $this->arrStatus, isset($data['p_status']) ? $data['p_status'] : '');

        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = (isset($request['objectId']) && trim($request['objectId']) != '0') ? 1 : 0;

        return $this->dataOutCommon = [
            'optionStatus' => $optionStatus,

            'formName' => $formName,
            'formCreateDigitally' => 'formCreateDigitally',
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route('extenHdi.indexDigitallySigned'),
            'urlCreateDigitallySigned' => URL::route('extenHdi.ajaxCreateDigitallySigned'),
            'urlAjaxGetData' => '',
            'functionAction' => '_ajaxGetItemOther',
        ];
    }

    /*********************************************************************************************************
     * Danh sách cấp ký số
     *********************************************************************************************************/
    public function indexDigitallySigned()
    {   if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'Danh sách ký số';
        CGlobal::$pageAdminTitle = $this->pageTitle . ' - Cấp đơn ' . CGlobal::$arrTitleProject[$this->tab_top];

        $error = (int)Request::get('error', -1);
        $page_no = (int)Request::get('page_no', 1);
        $search['p_from_date'] = trim(addslashes(Request::get('p_from_date', '')));
        $search['p_to_date'] = trim(addslashes(Request::get('p_to_date', '')));
        $search['p_file_code'] = addslashes(Request::get('p_file_code', 'ALL'));
        $search['p_from_date'] = ($search['p_from_date'] != '') ? $search['p_from_date'] : date('d/m/Y', strtotime(Carbon::now()->startOfMonth()));
        $search['p_to_date'] = ($search['p_to_date'] != '') ? $search['p_to_date'] : date('d/m/Y', strtotime(Carbon::now()));
        $search['page_no'] = $page_no;

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchDigitallySigned($search);
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
            'error' => $error,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,

        ], $this->dataOutCommon));
    }

    public function ajaxCreateDigitallySigned()
    {
        if (!$this->checkMultiPermiss([PERMISS_ADD, PERMISS_EDIT])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $dataRequest = $_POST;
        if (empty($dataRequest['FILE_REFF'])) {
            return Redirect::route('extenHdi.indexDigitallySigned', array('error' => STATUS_INT_KHONG));
        }
        $string_base64 = '';
        if (isset($_FILES['inputFile']) && count($_FILES['inputFile']) > 0 && $_FILES['inputFile']['name'] != '') {
            $folder = FOLDER_FILE_DIGITALLY_SIGNED;
            $fileName = app(Upload::class)->uploadFileHdi('inputFile', $folder,'','doc,docx');
            if($fileName != ''){
                $pathFileUpload = getDirFile($fileName);

                $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );
                $response = file_get_contents($pathFileUpload, false, stream_context_create($arrContextOptions));
                //$bin_string = file_get_contents($response);
                $string_base64 = base64_encode($response);
                app(Upload::class)->removeFile($folder, $fileName);
            }else{
                return Redirect::route('extenHdi.indexDigitallySigned', array('error' => STATUS_INT_KHONG));
            }
        }
        $dataApprovel['FILE_REFF'] = $dataRequest['FILE_REFF'];
        $dataApprovel['FILE'] = $string_base64;
        $result = $this->modelObj->createDigitallySigned($dataApprovel);
        if ($result['Success'] == STATUS_INT_MOT) {
            return Redirect::route('extenHdi.indexDigitallySigned', array('error' => STATUS_INT_MOT));
        } else {
            return Redirect::route('extenHdi.indexDigitallySigned', array('error' => STATUS_INT_KHONG));
        }
    }

}