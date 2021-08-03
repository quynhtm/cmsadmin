<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 03/2020
* @Version   : 1.0
*/
/*********************************************************************************************************
 * Router Report
 * *******************************************************************************************************
 */

const ModuleReport = DIR_PRO_REPORT;

Route::group(array('prefix' => 'report'), function () {

    //ReportProductController
    //báo cáo sản phẩm
    Route::match(['GET', 'POST'],'indexReportProduct', array('as' => 'report.indexReportProduct', 'uses' => ModuleReport . '\ReportProductController@indexReportProduct'));
    Route::get('getSearchAjaxReportProduct', array('as' => 'report.getSearchAjaxReportProduct', 'uses' => ModuleReport . '\ReportProductController@getSearchAjaxReportProduct'));

    //ReportProductDetailController
    //báo cáo chi tiết
    Route::match(['GET', 'POST'],'indexReportProductDetail', array('as' => 'report.indexReportProductDetail', 'uses' => ModuleReport . '\ReportProductDetailController@indexReportDetailProduct'));
    Route::match(['GET', 'POST'],'indexProductDetailFlySafe', array('as' => 'report.indexProductDetailFlySafe', 'uses' => ModuleReport . '\ReportProductDetailController@indexProductDetailFlySafe'));//bay an toàn
    Route::match(['GET', 'POST'],'indexProductDetailLostBaggage', array('as' => 'report.indexProductDetailLostBaggage', 'uses' => ModuleReport . '\ReportProductDetailController@indexProductDetailLostBaggage'));//bảo hiểm hành lý

    //ReportReconciliationController
    //báo cáo đối soát
    Route::match(['GET', 'POST'],'indexDataReconciliation', array('as' => 'report.indexDataReconciliation', 'uses' => ModuleReport . '\ReportReconciliationController@indexDataReconciliation'));
    Route::match(['GET', 'POST'],'indexReconciliationFlySafe', array('as' => 'report.indexReconciliationFlySafe', 'uses' => ModuleReport . '\ReportReconciliationController@indexReconciliationFlySafe'));//bay an toàn

    //ReportOrderBuyInsuranceController
    //thông kê đăng ký mua bảo hiểm
    Route::match(['GET', 'POST'],'indexReportOrderBuyInsurance', array('as' => 'report.indexReportOrderBuyInsurance', 'uses' => ModuleReport . '\ReportOrderBuyInsuranceController@indexReportOrderBuyInsurance'));
    Route::get('getSearchAjaxReportOrderBuyInsurance', array('as' => 'report.getSearchAjaxReportOrderBuyInsurance', 'uses' => ModuleReport . '\ReportOrderBuyInsuranceController@getSearchAjaxReportOrderBuyInsurance'));
    Route::get('ajaxGetDetailFiles', array('as' => 'report.ajaxGetDetailFiles', 'uses' => ModuleReport . '\ReportOrderBuyInsuranceController@ajaxGetDetailFiles'));
});

/*********************************************************************************************************
 * Router Accoountant
 * *******************************************************************************************************
 */
Route::group(array('prefix' => 'accountant'), function () {
    //ReportAccountantController
    //bảo hiểm hành lý
    Route::match(['GET', 'POST'],'indexAccountantLostBaggage', array('as' => 'accountant.indexAccountantLostBaggage', 'uses' => ModuleReport . '\ReportAccountantController@indexAccountantLostBaggage'));//kế toán đối soát bảo hiểm hành lý
});

/*********************************************************************************************************
 * Router Claim
 * *******************************************************************************************************
 */
Route::group(array('prefix' => 'reportClaim'), function () {
    //ReportClaimController
    //báo cáo bồi thường
    Route::match(['GET', 'POST'],'indexClaimVietJet', array('as' => 'claimReport.indexClaimVietJet', 'uses' => ModuleReport . '\ReportClaimController@indexClaimVietJet'));//báo cáo bồi thường VietJet
});

