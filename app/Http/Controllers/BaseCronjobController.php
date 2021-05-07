<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;

class BaseCronjobController extends Controller{

	public function __construct(){}

    public function returnResultSuccess($dataOutPut, $message = 'Success'){
        return Response::json(
            array(
                'intIsOK'=> 1,
                'data' => $dataOutPut,
                'message' => $message,
                'code'=>  200
            )
        );
    }

    public function returnResultError($dataOutPut, $message = 'No action'){
        $dataLog['data'] = $dataOutPut;
        $dataLog['message'] = $message;
        return Response::json(
            array(
                'intIsOK'=> -1,
                'data' => $dataOutPut,
                'message' => $message,
                'code'=>  202
            )
        );
    }
    public function clearCache(){
        Artisan::call('cache:clear');
        echo Artisan::output();
    }
}  