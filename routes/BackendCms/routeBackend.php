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

    /* Quản lý Menu system */
    Route::group(array('prefix' => 'menu'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'menu.index', 'uses' => DIR_PRO_BACKEND . '\BackendMenuController@index'));
        Route::get('ajaxGetItem', array('as' => 'menu.ajaxGetItem', 'uses' => DIR_PRO_BACKEND . '\BackendMenuController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'menu.ajaxPostItem', 'uses' => DIR_PRO_BACKEND . '\BackendMenuController@ajaxPostItem'));
        Route::post('ajaxDeleteItem', array('as' => 'menu.ajaxDeleteItem', 'uses' => DIR_PRO_BACKEND . '\BackendMenuController@ajaxDeleteItem'));
    });

    /* Quản lý Permission Group */
    Route::group(array('prefix' => 'permissGroup'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'permissGroup.index', 'uses' => DIR_PRO_BACKEND . '\BackendPermissGroupController@index'));
        Route::get('ajaxGetData', array('as' => 'permissGroup.ajaxGetData', 'uses' => DIR_PRO_BACKEND . '\BackendPermissGroupController@ajaxGetData'));
        Route::post('ajaxPostData', array('as' => 'permissGroup.ajaxPostData', 'uses' => DIR_PRO_BACKEND . '\BackendPermissGroupController@ajaxPostData'));
    });
});

