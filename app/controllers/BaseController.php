<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    protected static function buildUrlEncode($link = '') {
        return ($link != '')? rtrim(strtr(base64_encode($link), '+/', '-_'), '=') : '';
    }

    protected static function buildUrlDecode($str_link = '') {
        return ($str_link != '')? base64_decode(str_pad(strtr($str_link, '-_', '+/'), strlen($str_link) % 4, '=', STR_PAD_RIGHT)) : '';
    }

}
