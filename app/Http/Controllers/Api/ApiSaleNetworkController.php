<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Http\Models\SalesNetwork\SaleDepartment;
use App\Services\SalesNetworkService;


class ApiSaleNetworkController extends BaseApiController{
    private $salesNetworkService = false;
    private $objDepartment = false;
	public function __construct(){
		parent::__construct();
        $this->salesNetworkService = new SalesNetworkService();
        $this->objDepartment = new SaleDepartment();
	}

	public function getDepartments($businessLine, $positionCode){
	    if(trim($businessLine) != '' && trim($positionCode) != ''){
            $businessLine = strtoupper(trim($businessLine));
            $positionCode = strtoupper(trim($positionCode));
            $paramSearch = $_GET;
            $data = $this->objDepartment->getDataDepartments($businessLine, $positionCode, $paramSearch);
            return !empty($data)? $data :['count' => 0,'departments'=>[]];
        }else{
            $dataError= ['businessLine'=>trim($businessLine),'position_code'=>trim($positionCode)];
            $message = viewLanguage('API_INVALID_PARAMETERS');
            $this->returnResultError($dataError,$message);
        }

    }
}
