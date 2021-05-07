<?php
/*
* @Created by: HSS
* @Author	 : manhquynh1984@gmail.com
* @Date 	 : 08/2016
* @Version	 : 1.0
*/
namespace App\Library\AdminFunction;

use Illuminate\Support\Facades\Config;

class Loader{
	//Load css to header or footer
	public static function loadCSS($file_name, $position=1){
		if(is_array($file_name)){
			foreach($file_name as $v){
				Loader::loadCSS($v);
			}
			return;
		}
		if(strpos($file_name, 'http://') !== false){
			$html = '<link rel="stylesheet" href="' . $file_name . ((CGlobal::$css_ver) ? '?ver=' . CGlobal::$css_ver : '') . '" type="text/css">' . "\n";
			if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderCSS, $html) === false)
				CGlobal::$extraHeaderCSS .= $html . "\n";
			elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterCSS, $html) === false)
				CGlobal::$extraFooterCSS .= $html . "\n";
		}else{
			$html = '<link type="text/css" rel="stylesheet" href="' . url('', array(), Config::get('config.SECURE')) . '/assets/' . $file_name . ((CGlobal::$css_ver) ? '?ver=' . CGlobal::$css_ver : '') . '" />' . "\n";
			if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderCSS, $html) === false)
				CGlobal::$extraHeaderCSS .= $html . "\n";
			elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterCSS, $html) === false)
				CGlobal::$extraFooterCSS .= $html . "\n";
		}
	}
	//Load js to header or footer
	public static function loadJS($file_name, $position=1){
		if(is_array($file_name)){
			foreach($file_name as $v){
				Loader::loadJS($v);
			}
			return;
		}
		
		if(strpos($file_name, 'http://') !== false){
			$html = '<script type="text/javascript" src="' . $file_name . ((CGlobal::$js_ver) ? '?ver=' . CGlobal::$js_ver : '') . '"></script>';
			if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderJS, $html) === false)
				CGlobal::$extraHeaderJS .= $html . "\n";
			elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterJS, $html) === false)
				CGlobal::$extraFooterJS .= $html . "\n";
		}else{
			$html = '<script type="text/javascript" src="' . url('', array(), Config::get('config.SECURE')) . '/assets/' . $file_name . ((CGlobal::$js_ver) ? '?ver=' . CGlobal::$js_ver : '') . '"></script>';
			if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderJS, $html) === false)
				CGlobal::$extraHeaderJS .= $html . "\n";
			elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterJS, $html) === false)
				CGlobal::$extraFooterJS .= $html . "\n";
		}
	}
}