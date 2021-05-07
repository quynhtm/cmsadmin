<?php

namespace App\Exceptions;

use App\Events\HasExceptionEvent;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Services\NotificationViaSlack\NotificationViaSlackServices;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class Handler extends ExceptionHandler
{
    use Notifiable;

    private $exceptionName = '';


    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {

        $is_dev = env('IS_DEV', false);
        if(!$is_dev){
            $is_slack = env('IS_SLACK', 0);
            if($is_slack){
                event(new HasExceptionEvent($exception));
            }
        }
        return parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //die('Site đang bảo trì nâng cấp, vui lòng quay lại sau');
        $this->setDebug();
        $stringException = $exception->__toString();
        if (strpos($stringException,'ErrorException') == 0 && strpos($stringException,'Undefined variable') == 16){
            $this->exceptionName = 'PhpError';
        }
        elseif(strpos($stringException,'ErrorException') == 0 && strpos($stringException,'Undefined variable') != 16){
            $this->exceptionName = 'ViewError';
        }
        if (strpos($stringException,'PDOException') !== false) {
            $this->exceptionName = 'PhpError';
        }

        $is_dev = env('IS_DEV', false);
        $debug = Config::get('config.IS_DEBUG');
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
    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return redirect()->guest(route('login'));
    }

}
