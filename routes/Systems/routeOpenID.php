<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 03/2020
* @Version   : 1.0
*/
/*********************************************************************************************************
 * Router các thành phần DMS Portal
 * *******************************************************************************************************
 */

const ModuleOpenID = DIR_PRO_SYSTEM."\\".DIR_MODULE_OPENID;

Route::group(array('prefix' => 'system'), function () {

    /* Quản lý Danh mục tổ chức */
    Route::group(array('prefix' => 'organization'), function () {
        Route::match(['GET', 'POST'],'indexOrganization', array('as' => 'organization.indexOrganization', 'uses' => ModuleOpenID . '\OrganizationController@indexOrganization'));
        Route::get('ajaxGetOrganization', array('as' => 'organization.ajaxGetOrganization', 'uses' => ModuleOpenID . '\OrganizationController@ajaxGetOrganization'));
        Route::post('ajaxPostOrganization', array('as' => 'organization.ajaxPostOrganization', 'uses' => ModuleOpenID . '\OrganizationController@ajaxPostOrganization'));
        Route::post('ajaxDeleteOrganization', array('as' => 'organization.ajaxDeleteOrganization', 'uses' => ModuleOpenID . '\OrganizationController@ajaxDeleteOrganization'));
        Route::post('ajaxGetData', array('as' => 'organization.ajaxGetData', 'uses' => ModuleOpenID . '\OrganizationController@ajaxGetData'));
        //thêm sửa xóa Org other
        Route::post('ajaxUpdateOrgRelation', array('as' => 'organization.ajaxUpdateOrgRelation', 'uses' => ModuleOpenID . '\OrganizationController@ajaxUpdateOrgRelation'));
        Route::post('ajaxDeleteOrgRelation', array('as' => 'organization.ajaxDeleteOrgRelation', 'uses' => ModuleOpenID . '\OrganizationController@ajaxDeleteOrgRelation'));
    });

    /* Quản lý User hệ thống */
    Route::group(array('prefix' => 'user'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'userSystem.indexUser', 'uses' => ModuleOpenID . '\UserSystemController@indexUser'));
        Route::get('ajaxGetUser', array('as' => 'userSystem.ajaxGetUser', 'uses' => ModuleOpenID . '\UserSystemController@ajaxGetUser'));
        Route::post('ajaxPostUser', array('as' => 'userSystem.ajaxPostUser', 'uses' => ModuleOpenID . '\UserSystemController@ajaxPostUser'));
        Route::post('ajaxDeleteUser', array('as' => 'userSystem.ajaxDeleteUser', 'uses' => ModuleOpenID . '\UserSystemController@ajaxDeleteUser'));
        Route::post('ajaxGetData', array('as' => 'userSystem.ajaxGetData', 'uses' => ModuleOpenID . '\UserSystemController@ajaxGetData'));
        //thêm sửa xóa tab other của user
        Route::post('ajaxUpdateUserRelation', array('as' => 'userSystem.ajaxUpdateUserRelation', 'uses' => ModuleOpenID . '\UserSystemController@ajaxUpdateUserRelation'));

        //setting product user
        Route::get('ajaxGetProductWithUser', array('as' => 'userSystem.ajaxGetProductWithUser', 'uses' => ModuleOpenID . '\UserSystemController@ajaxGetProductWithUser'));
        Route::post('ajaxPostProductWithUser', array('as' => 'userSystem.ajaxPostProductWithUser', 'uses' => ModuleOpenID . '\UserSystemController@ajaxPostProductWithUser'));

        //profile
        Route::get('profile/{id}/{name}.html', array('as' => 'userSystem.userProfile', 'uses' => ModuleOpenID . '\UserSystemController@getProfile'));
        Route::post('profile/{id}/{name}.html', array('as' => 'userSystem.userProfile', 'uses' => ModuleOpenID . '\UserSystemController@postProfile'));
        //change pass
        Route::get('ajaxGetChangePass', array('as' => 'userSystem.ajaxGetChangePass', 'uses' => ModuleOpenID . '\UserSystemController@ajaxGetChangePass'));
        Route::post('ajaxPostChangePass', array('as' => 'userSystem.ajaxPostChangePass', 'uses' => ModuleOpenID . '\UserSystemController@ajaxPostChangePass'));
    });

    // Phòng ban
    Route::group(array('prefix' => 'depart'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'depart.index', 'uses' => ModuleOpenID . '\DepartController@index'));
        Route::get('ajaxGetDepart', array('as' => 'depart.ajaxGetDepart', 'uses' => ModuleOpenID . '\DepartController@ajaxGetDepart'));
        Route::post('ajaxPostDepart', array('as' => 'depart.ajaxPostDepart', 'uses' => ModuleOpenID . '\DepartController@ajaxPostDepart'));
        Route::post('ajaxDeleteDepart', array('as' => 'depart.ajaxDeleteDepart', 'uses' => ModuleOpenID . '\DepartController@ajaxDeleteDepart'));
        Route::post('ajaxGetData', array('as' => 'depart.ajaxGetData', 'uses' => ModuleOpenID . '\DepartController@ajaxGetData'));
        //chuyển đổi phòng ban
        Route::post('ajaxPostMoveDepartOfStaff', array('as' => 'depart.ajaxPostMoveDepartOfStaff', 'uses' => ModuleOpenID . '\DepartController@ajaxPostMoveDepartOfStaff'));
    });

    // banks
    Route::group(array('prefix' => 'banks'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'banks.index', 'uses' => ModuleOpenID . '\BankController@index'));
        Route::get('ajaxGetItem', array('as' => 'banks.ajaxGetItem', 'uses' => ModuleOpenID . '\BankController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'banks.ajaxPostItem', 'uses' => ModuleOpenID . '\BankController@ajaxPostItem'));
        Route::post('ajaxDeleteItem', array('as' => 'banks.ajaxDeleteItem', 'uses' => ModuleOpenID . '\BankController@ajaxDeleteItem'));
    });

    /* Quản lý menu system */
    Route::group(array('prefix' => 'systemMenu'), function () {
        Route::match(['GET', 'POST'], 'indexMenu', array('as' => 'menu.indexMenu', 'uses' => ModuleOpenID . '\MenuSystemController@indexMenu'));
        Route::get('ajaxGetMenu', array('as' => 'menu.ajaxGetMenu', 'uses' => ModuleOpenID . '\MenuSystemController@ajaxGetMenu'));
        Route::post('ajaxPostMenu', array('as' => 'menu.ajaxPostMenu', 'uses' => ModuleOpenID . '\MenuSystemController@ajaxPostMenu'));
        Route::post('ajaxDeleteMenu', array('as' => 'menu.ajaxDeleteMenu', 'uses' => ModuleOpenID . '\MenuSystemController@ajaxDeleteMenu'));
    });

    /* Quản lý group menu */
    Route::group(array('prefix' => 'menuGroup'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'menuGroup.index', 'uses' => ModuleOpenID . '\MenuGroupController@index'));
        Route::get('ajaxGetGroupMenu', array('as' => 'menuGroup.ajaxGetGroupMenu', 'uses' => ModuleOpenID . '\MenuGroupController@ajaxGetGroupMenu'));
        Route::post('ajaxPostGroupMenu', array('as' => 'menuGroup.ajaxPostGroupMenu', 'uses' => ModuleOpenID . '\MenuGroupController@ajaxPostGroupMenu'));
        Route::post('ajaxDeleteGroupMenu', array('as' => 'menuGroup.ajaxDeleteGroupMenu', 'uses' => ModuleOpenID . '\MenuGroupController@ajaxDeleteGroupMenu'));
        Route::post('ajaxGetData', array('as' => 'menuGroup.ajaxGetData', 'uses' => ModuleOpenID . '\MenuGroupController@ajaxGetData'));
        //thêm sửa xóa tab other
        Route::post('ajaxUpdateRelation', array('as' => 'menuGroup.ajaxUpdateRelation', 'uses' => ModuleOpenID . '\MenuGroupController@ajaxUpdateRelation'));
        Route::post('ajaxGetListMenuPermission', array('as' => 'menuGroup.ajaxGetListMenuPermission', 'uses' => ModuleOpenID . '\MenuGroupController@ajaxGetListMenuPermission'));
    });

    /* Quản lý Type defines */
    Route::group(array('prefix' => 'typeDefines'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'typeDefines.index', 'uses' => ModuleOpenID . '\TypeDefinesController@index'));
        Route::get('ajaxGetItem', array('as' => 'typeDefines.ajaxGetItem', 'uses' => ModuleOpenID . '\TypeDefinesController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'typeDefines.ajaxPostItem', 'uses' => ModuleOpenID . '\TypeDefinesController@ajaxPostItem'));
        Route::post('ajaxDeleteItem', array('as' => 'typeDefines.ajaxDeleteItem', 'uses' => ModuleOpenID . '\TypeDefinesController@ajaxDeleteItem'));
    });

    /* Quản lý đơn vị hành chính: tỉnh thành quận huyện*/
    Route::group(array('prefix' => 'provincial'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'provincial.index', 'uses' => ModuleOpenID . '\ProvincialController@index'));
        Route::get('ajaxGetItem', array('as' => 'provincial.ajaxGetItem', 'uses' => ModuleOpenID . '\ProvincialController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'provincial.ajaxPostItem', 'uses' => ModuleOpenID . '\ProvincialController@ajaxPostItem'));
        Route::post('ajaxDeleteItem', array('as' => 'provincial.ajaxDeleteItem', 'uses' => ModuleOpenID . '\ProvincialController@ajaxDeleteItem'));
        Route::post('ajaxGetData', array('as' => 'provincial.ajaxGetData', 'uses' => ModuleOpenID . '\ProvincialController@ajaxGetData'));
        //thêm sửa xóa tab other của user
        Route::post('ajaxUpdateItemRelation', array('as' => 'provincial.ajaxUpdateItemRelation', 'uses' => ModuleOpenID . '\UserSystemController@ajaxUpdateItemRelation'));
    });

    /*********************************************************************************************
     * Chưa dùng tới
     *********************************************************************************************/

    /*Quản lý calendar working*/
    Route::group(array('prefix' => 'calendarWorking'), function () {
        Route::get('', array('as' => 'calendarWorking.index', 'uses' => ModuleOpenID . '\CalendarWorkingController@index'));
        Route::get('ajaxGetItem', array('as' => 'calendarWorking.ajaxGetItem', 'uses' => ModuleOpenID . '\CalendarWorkingController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'calendarWorking.ajaxPostItem', 'uses' => ModuleOpenID . '\CalendarWorkingController@ajaxPostItem'));
    });
});
