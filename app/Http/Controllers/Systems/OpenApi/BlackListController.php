<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Systems\OpenApi;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\OpenApi\BlackList;
use App\Http\Models\OpenApi\Domains;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class BlackListController extends BaseAdminController
{
    private $error = array();
    private $dataOutCommon = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $arrStatus = array();
    private $templateRoot = DIR_PRO_SYSTEM.'/'.DIR_MODULE_OPENAPI . '.blackList.';

    public function __construct()
    {
        parent::__construct();
        $this->modelObj = new BlackList();
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

            'urlIndex' => URL::route('domains.index'),
            'urlGetItem' => URL::route('domains.ajaxGetItem'),
            'urlActionPostItem' => URL::route('domains.ajaxPostItem'),
            'urlDeleteItem' => '',
            'urlAjaxGetData' => '',
            'urlActionOtherItem' => ''
        ];
    }

    /*********************************************************************************************************
     * Danh mục: Black List
     *********************************************************************************************************/
    public function index()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'QL Black List';
        $page_no = (int)Request::get('page_no', 1);
        $search['page_no'] = $page_no;
        $search['IS_ACTIVE'] = addslashes(Request::get('IS_ACTIVE', ''));
        $search['p_is_active'] = $search['IS_ACTIVE'];
        $search['p_search'] = addslashes(Request::get('p_search', ''));

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchBlackList($search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data']['data'] ?? $dataList;
            $total = $result['Data']['total'] ?? $total;
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'viewBlackList', array_merge([
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
        ], $this->dataOutCommon));
    }

    /*********************************************************************************************************
     * Danh mục: Black List Ddos
     *********************************************************************************************************/
    public function indexDdos()
    {
        if (!$this->checkMultiPermiss([PERMISS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $this->pageTitle = CGlobal::$pageAdminTitle = 'QL Black List Ddos';
        $page_no = (int)Request::get('page_no', 1);
        $search['page_no'] = $page_no;
        $search['IS_ACTIVE'] = addslashes(Request::get('IS_ACTIVE', ''));
        $search['p_is_active'] = $search['IS_ACTIVE'];
        $search['p_search'] = addslashes(Request::get('p_search', ''));

        $dataList = [];
        $total = 0;
        $limit = CGlobal::number_show_10;
        $result = $this->modelObj->searchBlackListDdos($search);

        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['Data']['data'] ?? $dataList;
            $total = $result['Data']['total'] ?? $total;
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $search) : '';

        $this->_outDataView($_GET, $search);
        return view($this->templateRoot . 'viewBlackListDdos', array_merge([
            'data' => $dataList,
            'search' => $search,
            'total' => $total,
            'stt' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'pageTitle' => $this->pageTitle,
        ], $this->dataOutCommon));
    }
}
