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

    /* Quản lý Type product */
    Route::group(array('prefix' => 'product'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'product.index', 'uses' => DIR_PRO_BACKEND . '\BackendDefinesController@index'));
        Route::get('ajaxGetItem', array('as' => 'product.ajaxGetItem', 'uses' => DIR_PRO_BACKEND . '\BackendDefinesController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'product.ajaxPostItem', 'uses' => DIR_PRO_BACKEND . '\BackendDefinesController@ajaxPostItem'));
        Route::post('ajaxDeleteItem', array('as' => 'product.ajaxDeleteItem', 'uses' => DIR_PRO_BACKEND . '\BackendDefinesController@ajaxDeleteItem'));
    });

});

