<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 03/2020
* @Version   : 1.0
*/
/*********************************************************************************************************
 * Router shop
 * *******************************************************************************************************
 */
Route::group(array('prefix' => 'backend'), function () {

    /* Quản lý đơn hàng */
    Route::group(array('prefix' => 'orders'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'orders.index', 'uses' => DIR_PRO_SHOP . '\OrdersController@index'));
        Route::post('ajaxGetData', array('as' => 'orders.ajaxGetData', 'uses' => DIR_PRO_SHOP . '\OrdersController@ajaxGetData'));
        Route::post('ajaxPostData', array('as' => 'orders.ajaxPostData', 'uses' => DIR_PRO_SHOP . '\OrdersController@ajaxPostData'));
    });

    /* Quản lý sản phẩm */
    Route::group(array('prefix' => 'products'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'products.index', 'uses' => DIR_PRO_SHOP . '\ProductsController@index'));
        Route::post('ajaxGetData', array('as' => 'products.ajaxGetData', 'uses' => DIR_PRO_SHOP . '\ProductsController@ajaxGetData'));
        Route::post('ajaxPostData', array('as' => 'products.ajaxPostData', 'uses' => DIR_PRO_SHOP . '\ProductsController@ajaxPostData'));
    });

    /* Quản lý đăng ký đối tác */
    Route::group(array('prefix' => 'partnerRegistration'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'partnerRegistration.index', 'uses' => DIR_PRO_SHOP . '\PartnerRegistrationController@index'));
        Route::post('ajaxGetData', array('as' => 'partnerRegistration.ajaxGetData', 'uses' => DIR_PRO_SHOP . '\PartnerRegistrationController@ajaxGetData'));
        Route::post('ajaxPostData', array('as' => 'partnerRegistration.ajaxPostData', 'uses' => DIR_PRO_SHOP . '\PartnerRegistrationController@ajaxPostData'));
    });

});

