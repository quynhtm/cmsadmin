<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 03/2020
* @Version   : 1.0
*/
/*********************************************************************************************************
 * Router các thành phần Core HDi
 * *******************************************************************************************************
 */

const ModuleProducts = DIR_PRO_CORE_HDI;

Route::group(array('prefix' => 'coreHdi'), function () {
    // products
    Route::group(array('prefix' => 'products'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'products.index', 'uses' => ModuleProducts . '\ProductsController@index'));
        Route::get('ajaxGetItem', array('as' => 'products.ajaxGetItem', 'uses' => ModuleProducts . '\ProductsController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'products.ajaxPostItem', 'uses' => ModuleProducts . '\ProductsController@ajaxPostItem'));
    });

});
