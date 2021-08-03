<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 03/2020
* @Version   : 1.0
*/
/*********************************************************************************************************
 * Router các thành phần DMS API
 * *******************************************************************************************************
 */
const ModuleOpenApi = DIR_PRO_SYSTEM."\\".DIR_MODULE_OPENAPI;

Route::group(array('prefix' => 'systemApi'), function () {

    /* Quản lý Api hệ thống */
    Route::group(array('prefix' => 'apiSystem'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'apiSystem.index', 'uses' => ModuleOpenApi . '\ApiSystemController@index'));
        Route::get('ajaxGetItem', array('as' => 'apiSystem.ajaxGetItem', 'uses' => ModuleOpenApi . '\ApiSystemController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'apiSystem.ajaxPostItem', 'uses' => ModuleOpenApi . '\ApiSystemController@ajaxPostItem'));
        Route::post('ajaxGetData', array('as' => 'apiSystem.ajaxGetData', 'uses' => ModuleOpenApi . '\ApiSystemController@ajaxGetData'));
        //thêm tab other của api
        Route::post('ajaxUpdateRelation', array('as' => 'apiSystem.ajaxUpdateRelation', 'uses' => ModuleOpenApi . '\ApiSystemController@ajaxUpdateRelation'));
    });

    /* Quản lý databases */
    Route::group(array('prefix' => 'databaseConnection'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'databaseConnection.index', 'uses' => ModuleOpenApi . '\DatabaseConnectionController@index'));
        Route::get('ajaxGetItem', array('as' => 'databaseConnection.ajaxGetItem', 'uses' => ModuleOpenApi . '\DatabaseConnectionController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'databaseConnection.ajaxPostItem', 'uses' => ModuleOpenApi . '\DatabaseConnectionController@ajaxPostItem'));
    });

    /* Quản lý DOMAINS */
    Route::group(array('prefix' => 'domains'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'domains.index', 'uses' => ModuleOpenApi . '\DomainsController@index'));
        Route::get('ajaxGetItem', array('as' => 'domains.ajaxGetItem', 'uses' => ModuleOpenApi . '\DomainsController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'domains.ajaxPostItem', 'uses' => ModuleOpenApi . '\DomainsController@ajaxPostItem'));
    });

    /* Quản lý BLACK_LIST */
    Route::group(array('prefix' => 'blackList'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'blackList.index', 'uses' => ModuleOpenApi . '\BlackListController@index'));
        Route::match(['GET', 'POST'],'indexDdos', array('as' => 'blackList.indexDdos', 'uses' => ModuleOpenApi . '\BlackListController@indexDdos'));
    });

    /* Quản lý versions Api */
    Route::group(array('prefix' => 'versionsApi'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'versionsApi.index', 'uses' => ModuleOpenApi . '\VersionsApiController@index'));
        Route::get('ajaxGetItem', array('as' => 'versionsApi.ajaxGetItem', 'uses' => ModuleOpenApi . '\VersionsApiController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'versionsApi.ajaxPostItem', 'uses' => ModuleOpenApi . '\VersionsApiController@ajaxPostItem'));
        Route::post('ajaxGetData', array('as' => 'versionsApi.ajaxGetData', 'uses' => ModuleOpenApi . '\VersionsApiController@ajaxGetData'));
        //thêm sửa tab other
        Route::post('ajaxUpdateRelation', array('as' => 'versionsApi.ajaxUpdateRelation', 'uses' => ModuleOpenApi . '\VersionsApiController@ajaxUpdateRelation'));
    });
});
