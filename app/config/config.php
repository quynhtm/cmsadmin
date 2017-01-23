<?php
/**
 * Created by PhpStorm.
 * User: Vietlh
 * Date: 6/14/14
 * Time: 3:50 PM
 */
$webroot=str_replace('\\','/','http://'.$_SERVER['HTTP_HOST'].(dirname($_SERVER['SCRIPT_NAME'])?dirname($_SERVER['SCRIPT_NAME']):''));
$webroot.=$webroot[strlen($webroot)-1]!='/'?'/':'';
$strWebroot = $webroot;

$dir_root = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT'].(dirname($_SERVER['SCRIPT_NAME'])?dirname($_SERVER['SCRIPT_NAME']):''));
$dir_root.=$dir_root[strlen($dir_root)-1]!='/'?'/':'';


return array(
    'TIME_NOW'=> time(),
    'DEVMODE'=> true,//false: tren server, True: local
    'REDIS_ON'=> false,
    'WEB_ROOT' => $strWebroot,
    'DIR_ROOT' => $dir_root,
	'SECURE' => false,
	'DOMAIN_COOKIE_SERVER' => 'raovat30s.vn',
	'CACHE_QUERY' => false,
);

/*return array(
    'TIME_NOW'=> time(),
    'DEVMODE'=> true,
    'WEB_ROOT' => $strWebroot,
    'URL_API_LOCAL' => 'http://apiplaza.local/public/index.php/',
    'URL_CLIENT_LOCAL' => 'http://apiplaza.local/public/index.php/',
    'URL_API_LIVE' => '',
    'WEB_ROOT' => $strWebroot
);*/


//return array(
//    'TIME_NOW'=> time(),
//    'DEVMODE'=> true,
//    'WEB_ROOT' => $strWebroot,
//    'URL_API_LOCAL' => 'http://localhost/api_plaza/public/index.php/',
//    'URL_CLIENT_LOCAL' => '',
//    'URL_API_LIVE' => '',
//    'WEB_ROOT' => $strWebroot
//);