<?php

namespace App\Http\Middleware;

use App\Http\Controllers\BaseApiController;
use Closure;
use Illuminate\Support\Facades\Config;

class AuthApi
{
    private $baseApi;

    /**
     * Create a new middleware instance.
     * @return void
     */
    public function __construct()
    {
        $this->baseApi = new BaseApiController();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token_api = $request->header('TokenApi');

        if($token_api == '' || $token_api !==  md5(date('Y-m-d-H-i',time()).Config::get('config.API_TOKEN'))){
            return $this->baseApi->returnResultError([],'Token hết thời hạn');
        }

        return $next($request);
    }
}
