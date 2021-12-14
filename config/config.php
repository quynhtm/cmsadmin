<?php
/**
 * Created by PhpStorm.
 * User: Quynhtm
 * Date: 6/14/20
 * Time: 3:50 PM
 */

use App\Library\AdminFunction\CGlobal;

return array(
    'ENVIRONMENT' => env('ENVIRONMENT','DEV'),
    'IS_SCHEDULE' => env('IS_SCHEDULE',false),
    //user system
    'API_PARENT_CODE' => env('API_PARENT_CODE','HDI_PORTAL'),
    'API_USER_NAME' => env('API_USER_NAME','ADMIN_PORTAL'),
    'API_PASSWORD' => env('API_PASSWORD','123456'),
    'API_SECRET' => env('API_SECRET','AF20654256AF1885E0551F6E21B40329'),

    //user Selling
    'SELLING_PARENT_CODE' => env('SELLING_PARENT_CODE','HDI_PORTAL'),
    'SELLING_USER_NAME' => env('SELLING_USER_NAME','ADMIN_PORTAL'),
    'SELLING_PASSWORD' => env('SELLING_PASSWORD','123456'),
    'SELLING_SECRET' => env('SELLING_SECRET','AF20654256AF1885E0551F6E21B40329'),

    'URL_API_DEV' => env('URL_API_DEV','https://testhdiapinew.hdinsurance.com.vn/'),
    'URL_API_TEST' => env('URL_API_TEST','https://testhdiapinew.hdinsurance.com.vn/'),
    'URL_API_UAT' => env('URL_API_UAT','https://testhdiapinew.hdinsurance.com.vn/'),
    'URL_API_LIVE' => env('URL_API_LIVE','https://testhdiapinew.hdinsurance.com.vn/'),

    'URL_SDK_DEV' => env('URL_SDK_DEV','https://beta-sdk.hdinsurance.com.vn/'),
    'URL_SDK_LIVE' => env('URL_SDK_LIVE','https://beta-sdk.hdinsurance.com.vn/'),

    'URL_HYPERSERVICES_DEV' => env('URL_HYPERSERVICES_DEV','https://dev-hyperservices.hdinsurance.com.vn/f/'),
    'URL_HYPERSERVICES_LIVE' => env('URL_HYPERSERVICES_LIVE','https://dev-hyperservices.hdinsurance.com.vn/f/'),

    'PROJECT_CODE' => env('PROJECT_CODE'),
    'DOMAINS_PROJECT' => CGlobal::$arrDomainProject[env('ENVIRONMENT','DEV')],

    'PATH_FOLDER_UPLOAD' => env('IS_LIVE') ? env('APP_PATH_UPLOAD') . env('DIR_UPLOAD', 'uploads/filesUpload/') : dirname(__DIR__).DIRECTORY_SEPARATOR . env('DIR_UPLOAD', 'uploads/filesUpload/'),
    'DIR_UPLOAD'=> env('DIR_UPLOAD','/uploads'),
    'PATH_UPLOAD'=> env('PATH_UPLOAD','/uploads'),

    'MAIL_USERNAME'=> env('MAIL_USERNAME','info@hdinsurance.vn'),
    'MAIL_SERVICE'=> env('MAIL_SERVICE','/hdi/service/sendMailWithJson'),
    'SEND_MAIL_ADMIN'=> env('SEND_MAIL_ADMIN','/hdi/service/sendMailAdmin'),

    'TIME_NOW'=> time(),
    'API_TOKEN' => env('API_TOKEN','API_TOKEN@!1303'),
    'WEB_ROOT' => env('APP_URL'),
    'DIR_ROOT' => dirname(__DIR__).DIRECTORY_SEPARATOR,
    'SECURE' => env('IS_LIVE', false),
    'IS_DEV' => env('IS_DEV', false),
    'IS_LIVE' => env('IS_LIVE', false),
    'IS_DEBUG' => false,
    'DOMAIN_COOKIE_SERVER' => '',
    'CACHE_QUERY' => false,
);
