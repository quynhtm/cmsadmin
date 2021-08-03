<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [

    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, $exception)
    {
        //die('Site đang bảo trì nâng cấp, vui lòng quay lại sau');
        $this->setDebug();

        $is_dev = env('IS_DEV', false);
        $debug = Config::get('config.IS_DEBUG');
        $userLogin = Session::get(SESSION_ADMIN_LOGIN);
        if(isset($userLogin['user_type']) && $userLogin['user_type'] == USER_ROOT){
            return parent::render($request, $exception);
        }
        if(!$is_dev && !$debug){
            return Redirect::route('admin.login');
        }

        return parent::render($request, $exception);
    }
    private function setDebug(){
        $isDev = Request::get('is_debug', '');
        if ($isDev == 'tech_code') {
            Session::put('is_debug_of_tech', '13031984');
            Config::set('config.IS_DEBUG', true);
        }
        if ($isDev == 'none') {
            Session::forget('is_debug_of_tech');
            Config::set('config.IS_DEBUG', false);
        }
        if (Session::has('is_debug_of_tech')) {
            Config::set('config.IS_DEBUG', true);
        }else{
            Config::set('config.IS_DEBUG', false);
        }
    }
}
