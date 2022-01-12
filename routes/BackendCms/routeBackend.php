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
Route::get('logout', array('as' => 'backend.logout','uses' => DIR_PRO_BACKEND.'\BackendLoginController@logout'));
Route::post('forgot_password', array('as' => 'backend.forgot_password','uses' => DIR_PRO_BACKEND.'\BackendLoginController@forgot_password'));
Route::get('loginas/{username}', array('as' => 'admin.loginas', 'uses' => DIR_PRO_BACKEND . '\BackendLoginController@loginAs'));
Route::match(['GET', 'POST'], 'dashboard.hdi', array('as' => 'admin.dashboard','uses' => DIR_PRO_BACKEND.'\BackendDashBoardController@dashboard'));

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
        Route::post('ajaxGetData', array('as' => 'permissGroup.ajaxGetData', 'uses' => DIR_PRO_BACKEND . '\BackendPermissGroupController@ajaxGetData'));
        Route::post('ajaxPostData', array('as' => 'permissGroup.ajaxPostData', 'uses' => DIR_PRO_BACKEND . '\BackendPermissGroupController@ajaxPostData'));
    });

    /* Quản lý tỉnh thành, quận huyện, phường xã */
    Route::group(array('prefix' => 'proviceDistrict'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'proviceDistrict.index', 'uses' => DIR_PRO_BACKEND . '\BackendProviceDistrictController@index'));
        Route::post('ajaxGetData', array('as' => 'proviceDistrict.ajaxGetData', 'uses' => DIR_PRO_BACKEND . '\BackendProviceDistrictController@ajaxGetData'));
        Route::post('ajaxPostData', array('as' => 'proviceDistrict.ajaxPostData', 'uses' => DIR_PRO_BACKEND . '\BackendProviceDistrictController@ajaxPostData'));
    });

    /* Quản lý User admin */
    Route::group(array('prefix' => 'users'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'users.index', 'uses' => DIR_PRO_BACKEND . '\BackendUserController@index'));
        Route::post('ajaxGetData', array('as' => 'users.ajaxGetData', 'uses' => DIR_PRO_BACKEND . '\BackendUserController@ajaxGetData'));
        Route::post('ajaxPostData', array('as' => 'users.ajaxPostData', 'uses' => DIR_PRO_BACKEND . '\BackendUserController@ajaxPostData'));

        Route::get('profile', array('as' => 'users.user_profile', 'uses' => DIR_PRO_BACKEND . '\BackendUserController@getProfile'));
        Route::post('profile', array('as' => 'users.user_profile', 'uses' => DIR_PRO_BACKEND . '\BackendUserController@postProfile'));

        //change pass
        Route::get('ajaxGetChangePass', array('as' => 'users.ajaxGetChangePass', 'uses' => DIR_PRO_BACKEND . '\BackendUserController@ajaxGetChangePass'));
        Route::post('ajaxPostChangePass', array('as' => 'users.ajaxPostChangePass', 'uses' => DIR_PRO_BACKEND . '\BackendUserController@ajaxPostChangePass'));
        Route::post('remove/{id}', array('as' => 'users.user_remove', 'uses' => DIR_PRO_BACKEND . '\BackendUserController@remove'));

        //quan lý nhân viên cấp dưới
        Route::match(['GET','POST'],'employee/view', array('as' => 'admin.viewEmployee','uses' => DIR_PRO_BACKEND.'\BackendUserController@viewEmployee'));
        Route::get('employee/edit/{id}',array('as' => 'users.employeeEdit','uses' => DIR_PRO_BACKEND.'\BackendUserController@getEmployee'));
        Route::post('employee/edit/{id}',array('as' => 'users.employeeEdit','uses' => DIR_PRO_BACKEND.'\BackendUserController@postEmployee'));
    });
});

