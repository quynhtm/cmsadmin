<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2017
* @Version   : 1.0
*/

namespace App\Http\Controllers\Sellings\CameraRecord;

use App\Http\Controllers\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\OpenId\Province;
use App\Models\OpenId\UserSystem;
use App\Models\Selling\CameraRecord;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Pagging;
use App\Services\ActionExcel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class CameraRecordController extends Controller
{
    private $error = array();
    private $dataOutCommon = array();
    private $dataOutItem = array();
    private $pageTitle = '';
    private $modelObj = false;

    private $templateRoot = DIR_PRO_SELLING . '/' . DIR_MODULE_CAMERA_RECORD;

    private $tabOtherItem1 = 'tabOtherItem1';
    private $tabOtherItem2 = 'tabOtherItem2';
    private $tabOtherItem3 = 'tabOtherItem3';
    private $tabOtherItem4 = 'tabOtherItem4';

    public function __construct()
    {
        $this->modelObj = new CameraRecord();
    }

    private function _outDataView($request, $data)
    {
        $formName = $request['formName'] ?? 'formPopup';
        $titlePopup = $request['titlePopup'] ?? 'Thông tin chung';
        $objectId = (isset($request['objectId']) && trim($request['objectId']) != '0') ? 1 : 0;

        return $this->dataOutCommon = [
            'org_code_user' => '',
            'user_name_login' => '',
            'formName' => $formName,
            'title_popup' => $titlePopup,
            'objectId' => $objectId,
            'tabOtherItem1' => $this->tabOtherItem1,
            'tabOtherItem2' => $this->tabOtherItem2,
            'tabOtherItem3' => $this->tabOtherItem3,
            'tabOtherItem4' => $this->tabOtherItem4,

            'urlIndex' => URL::route('inspectionHdi.indexMotorVehicle'),
            'urlGetItem' => '',
            'urlPostItem' => '',

            'userAction' => $this->user,
            'functionAction' => '_ajaxGetItemOther',
        ];
    }

    public function recordInspectionMotorVehicle()
    {
        $id = Request::get('id', 'xxxxx');
        return view($this->templateRoot . '.MotorVehicle.viewRecord', ['trans_id' => $id]);
    }
}
