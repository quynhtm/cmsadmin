<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;

class ApiSendSuccessController extends BaseApiController{
	
	public function __construct(){
		parent::__construct();
	}
     public function index(){
	    return $this->returnResultSuccess(array());
     }
}
