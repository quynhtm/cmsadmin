<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2018
* @Version   : 1.0
*/
namespace App\Http\Controllers;

use App\Http\Models\OpenId\DepartmentOrg;
use App\Http\Models\OpenId\MenuSystem;
use App\Http\Models\OpenId\Province;
use App\Http\Models\Selling\Campaigns;
use App\Library\AdminFunction\FunctionLib;
use Illuminate\Support\Facades\Response;

class AjaxCommonController extends BaseAdminController
{
    public function getOptionCommon(){
        $dataRequest = $_POST;
        $object = $dataRequest['object'] ?? '';
        $type = $dataRequest['type'] ?? '';
        $optionOut = '';
        $success = STATUS_INT_KHONG;
        if(trim($object) != '' && trim($type) != ''){
            switch ($type){
                case 'DEPART':
                    $data = app(DepartmentOrg::class)->getArrOptionDepartByOrgCode($object);
                    $optionOut = FunctionLib::getOption(['' => '---Chọn---'] + $data, '');
                    $success = STATUS_INT_MOT;
                    break;
                case 'ORG_BY_CAMPAIGN_CODE':
                    $data = app(Campaigns::class)->getArrOptionOrgByCampaignCode($object);
                    $optionOut = FunctionLib::getOption(['' => '---Chọn---'] + $data, '');
                    $success = STATUS_INT_MOT;
                    break;
                case 'OPTION_MENU_PARENT':
                    $data = app(MenuSystem::class)->getOptionMenuParent($object);
                    $optionOut = FunctionLib::getOption(['' => '---Chọn---'] + $data, '');
                    $success = STATUS_INT_MOT;
                    break;
                case 'OPTION_DISTRICT_CODE':
                    $data = app(Province::class)->getOptionDistrict($object);
                    $optionOut = FunctionLib::getOption(['' => '---Chọn---'] + $data, '');
                    $success = STATUS_INT_MOT;
                    break;
                case 'OPTION_WARD_CODE':
                    $data = app(Province::class)->getOptionWard($object);
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