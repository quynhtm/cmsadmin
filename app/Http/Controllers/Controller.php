<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController{

	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected static function buildUrlEncode($link = '') {
		return ($link != '')? rtrim(strtr(base64_encode($link), '+/', '-_'), '=') : '';
	}
	
	protected static function buildUrlDecode($str_link = '') {
		return ($str_link != '')? base64_decode(str_pad(strtr($str_link, '-_', '+/'), strlen($str_link) % 4, '=', STR_PAD_RIGHT)) : '';
	}
}
