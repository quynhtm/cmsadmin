<?php

use Illuminate\Support\Facades\Route;

const Admin = "Admin";

//Quan tri CMS cho admin
/*Route::get('/backend-cms.html', array('as' => 'admin.login', 'uses' => Admin . '\AdminLoginController@getLogin'));
Route::post('/backend-cms.html', array('as' => 'admin.login', 'uses' => Admin . '\AdminLoginController@postLogin'));*/
Route::get('/backend-cms.html', array('as' => 'backend.login', 'uses' => DIR_PRO_BACKEND . '\BackendLoginController@getLogin'));
Route::post('/backend-cms.html', array('as' => 'backend.login', 'uses' => DIR_PRO_BACKEND . '\BackendLoginController@postLogin'));

require __DIR__.'/frontend.php';

Route::group(array('prefix' => 'manager', 'before' => ''), function () {
    require __DIR__ . '/'.DIR_PRO_BACKEND.'/routeBackend.php';
    require __DIR__ . '/'.DIR_PRO_WEB.'/routeWeb.php';
    require __DIR__ . '/'.DIR_PRO_SHOP.'/routeShop.php';
});
require __DIR__ . '/api.php';

Route::group(array('prefix' => 'ajaxCommon'), function () {
    Route::post('buildOption', array('as' => 'ajaxCommon.buildOption', 'uses' => 'AjaxCommonController@getOptionCommon'));
});

Route::group(array('prefix' => 'ajax', 'before' => ''), function () {
    Route::post('uploadImage', array('as' => 'ajax.uploadImage', 'uses' => 'AjaxUploadController@uploadImage'));
    Route::post('removeImageCommon', array('as' => 'ajax.removeImageCommon', 'uses' => 'AjaxUploadController@removeImageCommon'));
    Route::post('getImageContentCommon', array('as' => 'ajax.getImageContentCommon', 'uses' => 'AjaxUploadController@getImageContentCommon'));
    Route::get('sendEmail', array('as' => 'ajax.sendEmail', 'uses' => 'AjaxUploadController@sendEmail'));

    Route::match(['GET', 'POST'], 'ajax-get-product-other-site', array('as' => 'ajax.getProductFromOther', 'uses' => 'AjaxUploadController@getProductFromOtherSite'));
});

Route::get('sentmail/mail', array('as' => 'admin.mail', 'uses' => 'MailSendController@sentEmail'));
Route::get('sentmail/sentEmailInsmart', array('as' => 'hdi.sentEmailInsmart', 'uses' => 'MailSendController@sentEmailInsmart'));

