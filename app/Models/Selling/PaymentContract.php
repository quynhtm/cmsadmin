<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\Selling;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Facades\Config;

class PaymentContract extends ModelService
{
    /*********************************************************************************************************
     * Thanh toán hợp đồng
     *********************************************************************************************************/
    public $table = TABLE_GIFT_CONFIG_CODE;

    //danh sách an tâm tín dụng
    public function searchPaymentContract($dataRequest = array())
    {
        $this->setUserAction();
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        $requestDefault["p_order_code"] = (isset($dataRequest['p_order_code'])) ? $dataRequest['p_order_code'] : '';
        $requestDefault["p_status"] = (isset($dataRequest['p_status'])) ? $dataRequest['p_status'] : '';
        $requestDefault["p_from_date"] = (isset($dataRequest['p_from_date'])) ? $dataRequest['p_from_date'] : '';
        $requestDefault["p_to_date"] = (isset($dataRequest['p_to_date'])) ? $dataRequest['p_to_date'] : '';
        $requestDefault["p_search"] = (isset($dataRequest['p_search'])) ? $dataRequest['p_search'] : '';
        $requestDefault["p_period_no"] = (isset($dataRequest['p_period_no'])) ? $dataRequest['p_period_no'] : '';
        $requestDefault["p_order_trans_code"] = (isset($dataRequest['p_order_trans_code'])) ? $dataRequest['p_order_trans_code'] : '';
        $requestDefault["p_cusname"] = (isset($dataRequest['p_cusname'])) ? $dataRequest['p_cusname'] : '';
        $requestDefault["p_phone"] = (isset($dataRequest['p_phone'])) ? $dataRequest['p_phone'] : '';
        $requestDefault["p_idcard"] = (isset($dataRequest['p_idcard'])) ? $dataRequest['p_idcard'] : '';
        $requestDefault["p_amount_from"] = (isset($dataRequest['p_amount_from'])) ? $dataRequest['p_amount_from'] : '';
        $requestDefault["p_amount_to"] = (isset($dataRequest['p_amount_to'])) ? $dataRequest['p_amount_to'] : '';
        $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;

        $dataRequest['Action'] = [
            'ParentCode' => Config::get('config.API_PARENT_CODE'),
            'UserName' => Config::get('config.API_USER_NAME'),
            'Secret' => Config::get('config.API_SECRET'),
            'ActionCode' => ACTION_SEARCH_PAYMENT_CONTRACT,
        ];
        $dataRequest['Data'] = $requestDefault;
        $resultApi = $this->postApiHD($dataRequest);
        return $this->setDataPaging($resultApi);
    }

    public function getDettailPaymentContract($dataInput = array())
    {
        if (empty($dataInput))
            return false;
        try {
            $this->setUserAction();
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_org_code"] = (isset($dataInput['ORG_CODE'])) ? $dataInput['ORG_CODE'] : '';;
            $dataRequestDefault["p_action"] = '';
            $dataRequestDefault["p_order_code"] = (isset($dataInput['ORDER_CODE'])) ? $dataInput['ORDER_CODE'] : '';;
            $dataRequestDefault["p_period_no"] = STATUS_INT_AM_MOT;
            $dataRequestDefault["p_order_trans_code"] = (isset($dataInput['ORDER_TRANS_CODE'])) ? $dataInput['ORDER_TRANS_CODE'] : '';;

            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = ['ActionCode' => ACTION_DETTAIL_PAYMENT_CONTRACT];

            $resultApi = $this->postApiHD($dataRequest);
            return $this->setDataResponce($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function getListNotPaymentContract($dataInput = array())
    {
        if (empty($dataInput))
            return false;
        try {
            /*$this->setUserAction();
            $dataRequestDefault = $this->dataRequestDefault;*/
            $dataRequestDefault["p_trans_id"] = (isset($dataInput['p_trans_id'])) ? $dataInput['p_trans_id'] : '';;
            $dataRequestDefault["p_content"] = (isset($dataInput['p_content'])) ? $dataInput['p_content'] : '';;
            $dataRequestDefault["p_amount"] = (isset($dataInput['p_amount'])) ? $dataInput['p_amount'] : '';;

            $dataRequestDefault["p_from_date"] = (isset($dataInput['p_from_date'])) ? $dataInput['p_from_date'] : '';
            $dataRequestDefault["p_to_date"] = (isset($dataInput['p_to_date'])) ? $dataInput['p_to_date'] : '';
            $dataRequestDefault["p_cardnum"] = (isset($dataInput['p_cardnum'])) ? $dataInput['p_cardnum'] : '';
            $dataRequestDefault["p_cardname"] = (isset($dataInput['p_cardname'])) ? $dataInput['p_cardname'] : '';
            $dataRequestDefault["p_page"] = (isset($dataInput['p_page'])) ? $dataInput['p_page'] : STATUS_INT_MOT;

            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = ['ActionCode' => ACTION_LIST_NOT_PAYMENT_CONTRACT];
            //myDebug($dataRequest);
            $resultApi = $this->postApiHD($dataRequest);
            return $this->setDataOneResponce($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function updateApprovalOrder($dataInput = array())
    {
        $this->setUserAction();
        $dataRequestDefault = $this->dataRequestDefault;
        $dataRequestDefault["p_order_trans_code"] = (isset($dataInput['p_order_trans_code'])) ? $dataInput['p_order_trans_code'] : '';;

        $dataRequest['Data'] = $dataRequestDefault;
        $dataRequest['Action'] = ['ActionCode' => ACTION_APPROVAL_ORDER_PAYMENT_CONTRACT];

        $param_url = 'OpenApi/orders/transfer/approve';
        $resultApi = $this->postApiUrl($dataRequest,$param_url);
        return $this->setDataResponce($resultApi);
    }

    public function updateMovePayment($dataInput = array())
    {
        if (empty($dataInput))
            return false;
        try {
            $this->setUserAction();
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_trans_id"] = (isset($dataInput['p_trans_id'])) ? $dataInput['p_trans_id'] : '';;
            $dataRequestDefault["p_order_code"] = (isset($dataInput['p_order_code'])) ? $dataInput['p_order_code'] : '';;
            $dataRequestDefault["p_order_transfer_code"] = (isset($dataInput['p_order_transfer_code'])) ? $dataInput['p_order_transfer_code'] : '';;

            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = ['ActionCode' => ACTION_MOVE_ORDER_PAYMENT_CONTRACT];
            //myDebug($dataRequest);
            $resultApi = $this->postApiHD($dataRequest);
            return $this->setDataResponce($resultApi);
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }
}
