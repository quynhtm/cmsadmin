<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2018
* @Version   : 1.0
*/
namespace App\Http\Controllers;

use App\Library\AdminFunction\FunctionLib;
use App\Models\BackendCms\Districts;
use App\Models\BackendCms\Province;
use App\Models\BackendCms\Wards;
use Illuminate\Support\Facades\Response;

class AjaxCommonController extends Controller
{
    public function getOptionCommon(){
        $dataRequest = $_POST;
        $object = $dataRequest['object'] ?? '';
        $type = $dataRequest['type'] ?? '';
        $optionOut = '';
        $success = STATUS_INT_KHONG;
        if(trim($object) != '' && trim($type) != ''){
            switch ($type){
                case 'OPTION_DISTRICT_CODE':
                    $data = app(Districts::class)->getOptionDistrict($object);
                    $optionOut = FunctionLib::getOption(['' => '---Chọn---'] + $data, '');
                    $success = STATUS_INT_MOT;
                    break;
                case 'OPTION_WARD_CODE':
                    $data = app(Wards::class)->getOptionWard($object);
                    $optionOut = FunctionLib::getOption(['' => '---Chọn---'] + $data, '');
                    $success = STATUS_INT_MOT;
                    break;
                default;
                    break;
            }
        }
        $arrAjax = array('success' => $success, 'optionOut' => $optionOut);
        return Response::json($arrAjax);
    }

    public function ajaxGetData(){
        $dataRequest = $_POST;
        $functionAction = $dataRequest['functionAction'] ?? '';
        $html = '';
        $success = STATUS_INT_KHONG;
        if(trim($functionAction) != '') {
            $html = $this->$functionAction($dataRequest);
            $success = STATUS_INT_MOT;
        }
        $arrAjax = array('success' => $success, 'html' => $html);
        return Response::json($arrAjax);
    }
}
