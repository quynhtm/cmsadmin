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

    /* Quản lý liên hệ */
    Route::group(array('prefix' => 'contact'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'contact.index', 'uses' => DIR_PRO_WEB . '\ContactController@index'));
        Route::post('ajaxGetData', array('as' => 'contact.ajaxGetData', 'uses' => DIR_PRO_WEB . '\ContactController@ajaxGetData'));
        Route::post('ajaxPostData', array('as' => 'contact.ajaxPostData', 'uses' => DIR_PRO_WEB . '\ContactController@ajaxPostData'));
    });

    /* Quản lý tuyển dụng */
    Route::group(array('prefix' => 'recruitment'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'recruitment.index', 'uses' => DIR_PRO_WEB . '\RecruitmentController@index'));
        Route::post('ajaxGetData', array('as' => 'recruitment.ajaxGetData', 'uses' => DIR_PRO_WEB . '\RecruitmentController@ajaxGetData'));
        Route::post('ajaxPostData', array('as' => 'recruitment.ajaxPostData', 'uses' => DIR_PRO_WEB . '\RecruitmentController@ajaxPostData'));
    });

    /* Quản lý ứng tuyển của tuyển dụng */
    Route::group(array('prefix' => 'recruitmentApply'), function () {
        Route::match(['GET', 'POST'], 'index', array('as' => 'recruitmentApply.index', 'uses' => DIR_PRO_WEB . '\RecruitmentApplyController@index'));
        Route::post('ajaxGetData', array('as' => 'recruitmentApply.ajaxGetData', 'uses' => DIR_PRO_WEB . '\RecruitmentApplyController@ajaxGetData'));
        Route::post('ajaxPostData', array('as' => 'recruitmentApply.ajaxPostData', 'uses' => DIR_PRO_WEB . '\RecruitmentApplyController@ajaxPostData'));
    });

    /* Quản lý Danh mục */
    Route::group(array('prefix' => 'category'), function () {
        Route::match(['GET', 'POST'], 'indexProduct', array('as' => 'categoryProduct.index', 'uses' => DIR_PRO_WEB . '\CategoryController@indexCategoryProduct'));
        Route::match(['GET', 'POST'], 'indexNew', array('as' => 'categoryNew.index', 'uses' => DIR_PRO_WEB . '\CategoryController@indexCategoryNew'));
        Route::get('ajaxGetItem', array('as' => 'category.ajaxGetItem', 'uses' => DIR_PRO_WEB . '\CategoryController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'category.ajaxPostItem', 'uses' => DIR_PRO_WEB . '\CategoryController@ajaxPostItem'));
        Route::post('ajaxDeleteItem', array('as' => 'category.ajaxDeleteItem', 'uses' => DIR_PRO_WEB . '\CategoryController@ajaxDeleteItem'));
    });
});

