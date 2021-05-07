<?php

Route::get('logout', array('as' => 'admin.logout','uses' => Admin.'\AdminLoginController@logout'));
Route::post('forgot_password', array('as' => 'admin.forgot_password','uses' => Admin.'\AdminLoginController@forgot_password'));
Route::get('dashboard.hdi', array('as' => 'admin.dashboard','uses' => Admin.'\AdminDashBoardController@dashboard'));

//testData
Route::get('runCronjob',array('as' => 'admin.runCronjob','uses' => Admin.'\TestDataController@runCronjob'));
Route::get('clear',array('as' => 'admin.clear','uses' => 'BaseCronjobController@clearCache'));

    /*thông tin tài khoản*/
Route::group(array('prefix' => 'user'), function () {
    Route::match(['GET', 'POST'], 'view', array('as' => 'admin.user_view', 'uses' => Admin . '\AdminUserController@view'));
    Route::get('edit/{id}', array('as' => 'admin.user_edit', 'uses' => Admin . '\AdminUserController@editInfo'));
    Route::post('edit/{id}', array('as' => 'admin.user_edit', 'uses' => Admin . '\AdminUserController@edit'));
    Route::get('profile', array('as' => 'admin.user_profile', 'uses' => Admin . '\AdminUserController@getProfile'));
    Route::post('profile', array('as' => 'admin.user_profile', 'uses' => Admin . '\AdminUserController@postProfile'));

    //change pass
    Route::get('ajaxGetChangePass', array('as' => 'user.ajaxGetChangePass', 'uses' => Admin . '\AdminUserController@ajaxGetChangePass'));
    Route::post('ajaxPostChangePass', array('as' => 'user.ajaxPostChangePass', 'uses' => Admin . '\AdminUserController@ajaxPostChangePass'));
    Route::post('remove/{id}', array('as' => 'admin.user_remove', 'uses' => Admin . '\AdminUserController@remove'));

    //quan lý nhân viên cấp dưới
    Route::match(['GET','POST'],'employee/view', array('as' => 'admin.viewEmployee','uses' => Admin.'\AdminUserController@viewEmployee'));
    Route::get('employee/edit/{id}',array('as' => 'admin.employeeEdit','uses' => Admin.'\AdminUserController@getEmployee'));
    Route::post('employee/edit/{id}',array('as' => 'admin.employeeEdit','uses' => Admin.'\AdminUserController@postEmployee'));
});

    /*thông tin quyền*/
Route::group(array('prefix' => 'permission'), function () {
    Route::match(['GET', 'POST'], 'view', array('as' => 'admin.permission_view', 'uses' => Admin . '\AdminPermissionController@view'));
    Route::get('ajaxGetItem', array('as' => 'permission.ajaxGetItem', 'uses' => Admin . '\AdminPermissionController@ajaxGetItem'));
    Route::post('ajaxPostItem', array('as' => 'permission.ajaxPostItem', 'uses' => Admin . '\AdminPermissionController@ajaxPostItem'));
    Route::post('deletePermission', array('as' => 'admin.deletePermission', 'uses' => Admin . '\AdminPermissionController@deletePermission'));//ajax
});

    /*thông tin nhóm quyền*/
Route::group(array('prefix' => 'groupUser'), function () {
    Route::match(['GET', 'POST'], 'view', array('as' => 'admin.groupUserView', 'uses' => Admin . '\AdminGroupUserController@view'));
    Route::get('edit/{id?}', array('as' => 'admin.groupUserEdit', 'uses' => Admin . '\AdminGroupUserController@getItem'))->where('id', '[0-9]+');
    Route::post('edit/{id?}', array('as' => 'admin.groupUserEdit', 'uses' => Admin . '\AdminGroupUserController@postItem'))->where('id', '[0-9]+');
    Route::get('delete', array('as' => 'admin.groupUserRemove', 'uses' => Admin . '\AdminGroupUserController@deleteGroupUser'));

    /*thông tin quyền theo role */
    Route::get('viewRole', array('as' => 'admin.viewRole', 'uses' => Admin . '\AdminGroupUserController@viewRole'));
    Route::get('editRole/{id?}', array('as' => 'admin.editRole', 'uses' => Admin . '\AdminGroupUserController@getRole'));
    Route::post('editRole/{id?}', array('as' => 'admin.editRole', 'uses' => Admin . '\AdminGroupUserController@postRole'));
    Route::post('deleteGroupRole', array('as' => 'admin.deleteGroupRole', 'uses' => Admin . '\AdminGroupUserController@deleteGroupRole'));
});

/*thông tin role */
Route::group(array('prefix' => 'role'), function () {
    Route::get('view', array('as' => 'admin.roleView', 'uses' => Admin . '\AdminRoleController@view'));
    Route::get('ajaxGetItem', array('as' => 'role.ajaxGetItem', 'uses' => Admin . '\AdminRoleController@ajaxGetItem'));
    Route::post('ajaxPostItem', array('as' => 'role.ajaxPostItem', 'uses' => Admin . '\AdminRoleController@ajaxPostItem'));
    Route::get('deleteRole', array('as' => 'admin.deleteRole', 'uses' => Admin . '\AdminRoleController@deleteRole'));
});

/*thông tin menu */
Route::group(array('prefix' => 'menu'), function () {
    Route::get('view', array('as' => 'admin.menuView', 'uses' => Admin . '\AdminManageMenuController@view'));
    Route::get('edit/{id?}', array('as' => 'admin.menuEdit', 'uses' => Admin . '\AdminManageMenuController@getItem'));
    Route::post('edit/{id?}', array('as' => 'admin.menuEdit', 'uses' => Admin . '\AdminManageMenuController@postItem'));
    Route::post('deleteMenu', array('as' => 'admin.deleteMenu', 'uses' => Admin . '\AdminManageMenuController@deleteMenu'));//ajax/
    Route::post('ajaxGetOptionParent', array('as' => 'admin.ajaxGetOptionParent', 'uses' => Admin . '\AdminManageMenuController@ajaxGetOptionParent'));//ajax
});

//Define common item
Route::group(array('prefix' => 'defineCommon'), function () {
    Route::match(['GET', 'POST'], 'position', array('as' => 'admin.definePosition', 'uses' => Admin . '\AdminDefineController@definePosition'));//chức vụ
    Route::match(['GET', 'POST'], 'departMeeting', array('as' => 'admin.defineTypeDepartMeeting', 'uses' => Admin . '\AdminDefineController@defineTypeDepartMeeting'));//phòng họp

    //common
    Route::get('ajaxGetItem', array('as' => 'defineCommon.ajaxGetItem', 'uses' => Admin . '\AdminDefineController@ajaxGetItem'));
    Route::post('ajaxPostItem', array('as' => 'defineCommon.ajaxPostItem', 'uses' => Admin . '\AdminDefineController@ajaxPostItem'));
    Route::get('delete', array('as' => 'admin.deleteDefineCommon', 'uses' => Admin . '\AdminDefineController@deleteDefineCommon'));
});

