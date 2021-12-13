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

    /* Quản lý đăng ký đối tác */
    Route::group(array('prefix' => 'partnerRegistration'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'partnerRegistration.index', 'uses' => DIR_PRO_SHOP . '\PartnerRegistrationController@index'));
        Route::post('ajaxGetData', array('as' => 'partnerRegistration.ajaxGetData', 'uses' => DIR_PRO_SHOP . '\PartnerRegistrationController@ajaxGetData'));
        Route::post('ajaxPostData', array('as' => 'partnerRegistration.ajaxPostData', 'uses' => DIR_PRO_SHOP . '\PartnerRegistrationController@ajaxPostData'));
    });

});

