<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 03/2020
* @Version   : 1.0
*/
/*********************************************************************************************************
 * Router web
 * *******************************************************************************************************
 */
Route::group(array('prefix' => 'backend'), function () {

    /* Quản lý đối tác */
    Route::group(array('prefix' => 'partner'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'partner.index', 'uses' => DIR_PRO_WEB . '\PartnerController@index'));
        Route::post('ajaxGetData', array('as' => 'partner.ajaxGetData', 'uses' => DIR_PRO_WEB . '\PartnerController@ajaxGetData'));
        Route::post('ajaxPostData', array('as' => 'partner.ajaxPostData', 'uses' => DIR_PRO_WEB . '\PartnerController@ajaxPostData'));
    });
});
