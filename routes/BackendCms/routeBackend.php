<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 03/2020
* @Version   : 1.0
*/
/*********************************************************************************************************
 * Router Backend
 * *******************************************************************************************************
 */
Route::group(array('prefix' => 'backend'), function () {

    /* Quản lý Type defines */
    Route::group(array('prefix' => 'defines'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'defines.index', 'uses' => DIR_PRO_BACKEND . '\BackendDefinesController@index'));
        Route::get('ajaxGetItem', array('as' => 'defines.ajaxGetItem', 'uses' => DIR_PRO_BACKEND . '\BackendDefinesController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'defines.ajaxPostItem', 'uses' => DIR_PRO_BACKEND . '\BackendDefinesController@ajaxPostItem'));
        Route::post('ajaxDeleteItem', array('as' => 'defines.ajaxDeleteItem', 'uses' => DIR_PRO_BACKEND . '\BackendDefinesController@ajaxDeleteItem'));
    });
});
