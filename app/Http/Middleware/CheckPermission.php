<?php

namespace App\Http\Middleware;

use App\Http\Models\Admin\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null)
    {
        $user = app('App\Http\Models\Admin\User')->user_login();
        if (empty($user)) {
            return Redirect::route('admin.login')->send();
        }
        return;
    }
}
