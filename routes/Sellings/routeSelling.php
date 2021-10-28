<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 03/2020
* @Version   : 1.0
*/
/*********************************************************************************************************
 * Router Selling
 * *******************************************************************************************************
 */
const ModuleExtenActionHdi = DIR_PRO_SELLING."\\".DIR_MODULE_EXTEN_ACTION_HDI;//nghiệp vụ
const ModuleVouchers = DIR_PRO_SELLING."\\".DIR_MODULE_VOUCHERS;//voucher
const ModuleInsurancePolicy = DIR_PRO_SELLING."\\".DIR_MODULE_INSURANCE_POLICY;//cấp đơn
const ModulePaymentContract = DIR_PRO_SELLING."\\".DIR_MODULE_PAYMENT_CONTRACT;//thanh toán
const ModuleClaimIndemnify = DIR_PRO_SELLING."\\".DIR_MODULE_CLAIM_INDEMNIFY;//bồi thường
const ModuleInspection = DIR_PRO_SELLING."\\".DIR_MODULE_INSPECTION;//giám định
const ModuleCameraRecord = DIR_PRO_SELLING."\\".DIR_MODULE_CAMERA_RECORD;//quay video giám định

Route::group(array('prefix' => 'selling'), function () {

    /* List các page, chức năng khác */
    Route::group(array('prefix' => 'extenHdi'), function () {
        //ký số GCN
        Route::match(['GET', 'POST'],'indexDigitallySigned', array('as' => 'extenHdi.indexDigitallySigned', 'uses' => ModuleExtenActionHdi . '\DigitallySignedController@indexDigitallySigned'));
        Route::post('ajaxCreateDigitallySigned', array('as' => 'extenHdi.ajaxCreateDigitallySigned', 'uses' => ModuleExtenActionHdi . '\DigitallySignedController@ajaxCreateDigitallySigned'));

        //Quản lý cấp đơn theo file excel
        Route::match(['GET', 'POST'],'indexOrdersInBatches', array('as' => 'extenHdi.indexOrdersInBatches', 'uses' => ModuleExtenActionHdi . '\OrdersInBatchesController@indexOrdersInBatches'));
        Route::post('ajaxActionFunction', array('as' => 'extenHdi.ajaxActionFunction', 'uses' => ModuleExtenActionHdi . '\OrdersInBatchesController@ajaxActionFunction'));//điều hướng các action khách nhau của page
        Route::post('ajaxUpdateProgramme', array('as' => 'extenHdi.ajaxUpdateProgramme', 'uses' => ModuleExtenActionHdi . '\OrdersInBatchesController@ajaxUpdateProgramme'));
        Route::post('ajaxCreateOrderInBatches', array('as' => 'extenHdi.ajaxCreateOrderInBatches', 'uses' => ModuleExtenActionHdi . '\OrdersInBatchesController@ajaxCreateOrderInBatches'));
        Route::post('ajaxPostAddInforPacks', array('as' => 'extenHdi.ajaxPostAddInforPacks', 'uses' => ModuleExtenActionHdi . '\OrdersInBatchesController@ajaxPostAddInforPacks'));

        //get form immport
        Route::get('ajaxGetFormImport', array('as' => 'extenHdi.ajaxGetFormImport', 'uses' => ModuleExtenActionHdi . '\OrdersInBatchesController@ajaxGetFormImport'));
        Route::post('ajaxPostFormImport', array('as' => 'extenHdi.ajaxPostFormImport', 'uses' => ModuleExtenActionHdi . '\OrdersInBatchesController@ajaxPostFormImport'));
        Route::post('ajaxPostGenCode', array('as' => 'extenHdi.ajaxPostGenCode', 'uses' => ModuleExtenActionHdi . '\OrdersInBatchesController@ajaxPostGenCode'));//upload file gen code
        Route::get('getSearchGenGcnAjax', array('as' => 'extenHdi.getSearchGenGcnAjax', 'uses' => ModuleExtenActionHdi . '\OrdersInBatchesController@getSearchGenGcnAjax'));

        Route::get('ajaxGetOrdersInBatches', array('as' => 'extenHdi.ajaxGetOrdersInBatches', 'uses' => ModuleExtenActionHdi . '\OrdersInBatchesController@ajaxGetOrdersInBatches'));
        Route::post('ajaxPostOrdersInBatches', array('as' => 'extenHdi.ajaxPostOrdersInBatches', 'uses' => ModuleExtenActionHdi . '\OrdersInBatchesController@ajaxPostOrdersInBatches'));

        /* Danh sách ký số Centech*/
        Route::match(['GET', 'POST'],'indexDigitallyCentech', array('as' => 'digitallyCentech.index', 'uses' => ModuleExtenActionHdi . '\DigitallyCentechController@index'));
        Route::post('ajaxCancelOrder', array('as' => 'digitallyCentech.ajaxCancelOrder', 'uses' => ModuleExtenActionHdi . '\DigitallyCentechController@ajaxCancelOrder'));

        //Quản lý Đồng bộ dữ liệu sang bên Core
        Route::match(['GET', 'POST'],'indexSyncDataCore', array('as' => 'extenHdi.indexSyncDataCore', 'uses' => ModuleExtenActionHdi . '\SyncDataCoreController@indexSyncDataCore'));
        Route::post('ajaxGetAction', array('as' => 'syncDataCore.ajaxGetAction', 'uses' => ModuleExtenActionHdi . '\SyncDataCoreController@ajaxGetAction'));
        Route::post('ajaxPostAction', array('as' => 'syncDataCore.ajaxPostAction', 'uses' => ModuleExtenActionHdi . '\SyncDataCoreController@ajaxPostAction'));

    });

    /* Quản lý vouchersGift */
    Route::group(array('prefix' => 'vouchersGift'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'vouchersGift.index', 'uses' => ModuleVouchers . '\VouchersGiftController@index'));
        Route::get('ajaxGetItem', array('as' => 'vouchersGift.ajaxGetItem', 'uses' => ModuleVouchers . '\VouchersGiftController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'vouchersGift.ajaxPostItem', 'uses' => ModuleVouchers . '\VouchersGiftController@ajaxPostItem'));
        Route::post('ajaxGetData', array('as' => 'vouchersGift.ajaxGetData', 'uses' => ModuleVouchers . '\VouchersGiftController@ajaxGetData'));
        Route::post('ajaxUpdateStatusCode', array('as' => 'vouchersGift.ajaxUpdateStatusCode', 'uses' => ModuleVouchers . '\VouchersGiftController@ajaxUpdateStatusCode'));
        //thêm tab other của vouchersGift
        Route::post('ajaxUpdateRelation', array('as' => 'vouchersGift.ajaxUpdateRelation', 'uses' => ModuleVouchers . '\VouchersGiftController@ajaxUpdateRelation'));
        Route::post('ajaxSearchOtherItem', array('as' => 'vouchersGift.ajaxSearchOtherItem', 'uses' => ModuleVouchers . '\VouchersGiftController@ajaxSearchOtherItem'));
        //VouchersDetails
        Route::match(['GET', 'POST'],'indexDetails', array('as' => 'vouchersGift.indexDetails', 'uses' => ModuleVouchers . '\VouchersGiftController@indexDetails'));
        Route::post('ajaxUpdateStatusValue', array('as' => 'vouchersGift.ajaxUpdateStatusValue', 'uses' => ModuleVouchers . '\VouchersGiftController@ajaxUpdateStatusValue'));
        Route::get('getExportExcel/{id}', array('as' => 'vouchersGift.getExportExcel', 'uses' => ModuleVouchers . '\VouchersGiftController@getExportExcel'));

        //report
        Route::match(['GET', 'POST'],'indexRegisCustomerVoucher', array('as' => 'vouchersGift.indexRegisCustomerVoucher', 'uses' => ModuleVouchers . '\VouchersReportController@indexRegisCustomerVoucher'));
        Route::match(['GET', 'POST'],'indexRegisCustomerHealth', array('as' => 'vouchersGift.indexRegisCustomerHealth', 'uses' => ModuleVouchers . '\VouchersReportController@indexRegisCustomerHealth'));
        Route::match(['GET', 'POST'],'indexRegisStaff', array('as' => 'vouchersGift.indexRegisStaff', 'uses' => ModuleVouchers . '\VouchersReportController@indexReportRegisStaff'));
        Route::match(['GET', 'POST'],'indexReporCommon', array('as' => 'vouchersGift.indexReporCommon', 'uses' => ModuleVouchers . '\VouchersReportController@indexReporCommon'));
    });

    /* Cấp đơn bảo hiểm */
    Route::group(array('prefix' => 'insurancePolicy'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'insurancePolicy.index', 'uses' => ModuleInsurancePolicy . '\InsurancePolicyController@index'));
        Route::get('getSearchAjax', array('as' => 'insurancePolicy.getSearchAjax', 'uses' => ModuleInsurancePolicy . '\InsurancePolicyController@getSearchAjax'));
        Route::get('pageCreateOrderPolicy', array('as' => 'insurancePolicy.pageCreateOrderPolicy', 'uses' => ModuleInsurancePolicy . '\InsurancePolicyController@pageCreateOrderPolicy'));
        Route::get('ajaxGetItem', array('as' => 'insurancePolicy.ajaxGetItem', 'uses' => ModuleInsurancePolicy . '\InsurancePolicyController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'insurancePolicy.ajaxPostItem', 'uses' => ModuleInsurancePolicy . '\InsurancePolicyController@ajaxPostItem'));
        Route::post('ajaxGetData', array('as' => 'insurancePolicy.ajaxGetData', 'uses' => ModuleInsurancePolicy . '\InsurancePolicyController@ajaxGetData'));
        Route::post('ajaxGetDetailContract', array('as' => 'insurancePolicy.ajaxGetDetailContract', 'uses' => ModuleInsurancePolicy . '\InsurancePolicyController@ajaxGetDetailContract'));
        //get infor product
        Route::get('ajaxGetInforPro', array('as' => 'insurancePolicy.ajaxGetInforPro', 'uses' => ModuleInsurancePolicy . '\InsurancePolicyController@ajaxGetInforPro'));
    });

    /* Thanh toán hợp đồng */
    Route::group(array('prefix' => 'paymentContract'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'paymentContract.index', 'uses' => ModulePaymentContract . '\PaymentContractController@index'));
        Route::get('ajaxGetItem', array('as' => 'paymentContract.ajaxGetItem', 'uses' => ModulePaymentContract . '\PaymentContractController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'paymentContract.ajaxPostItem', 'uses' => ModulePaymentContract . '\PaymentContractController@ajaxPostItem'));
        Route::post('ajaxGetData', array('as' => 'paymentContract.ajaxGetData', 'uses' => ModulePaymentContract . '\PaymentContractController@ajaxGetData'));
        Route::post('ajaxApprovalOrder', array('as' => 'paymentContract.ajaxApprovalOrder', 'uses' => ModulePaymentContract . '\PaymentContractController@ajaxApprovalOrder'));
        Route::post('ajaxMovePay', array('as' => 'paymentContract.ajaxMovePay', 'uses' => ModulePaymentContract . '\PaymentContractController@ajaxMovePay'));
        Route::get('ajaxSearchAdvanced', array('as' => 'paymentContract.ajaxSearchAdvanced', 'uses' => ModulePaymentContract . '\PaymentContractController@ajaxSearchAdvanced'));
    });

    /* Bồi thường HDI */
    Route::group(array('prefix' => 'claimHdi'), function () {
        Route::match(['GET', 'POST'],'index', array('as' => 'claimHdi.index', 'uses' => ModuleClaimIndemnify . '\ClaimHdiController@index'));
        Route::get('getSearchAjax', array('as' => 'claimHdi.getSearchAjax', 'uses' => ModuleClaimIndemnify . '\ClaimHdiController@getSearchAjax'));
        Route::get('ajaxGetItem', array('as' => 'claimHdi.ajaxGetItem', 'uses' => ModuleClaimIndemnify . '\ClaimHdiController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'claimHdi.ajaxPostItem', 'uses' => ModuleClaimIndemnify . '\ClaimHdiController@ajaxPostItem'));
        Route::post('ajaxUpdateData', array('as' => 'claimHdi.ajaxUpdateData', 'uses' => ModuleClaimIndemnify . '\ClaimHdiController@ajaxUpdateData'));
        Route::post('ajaxGetData', array('as' => 'claimHdi.ajaxGetData', 'uses' => ModuleClaimIndemnify . '\ClaimHdiController@ajaxGetData'));
        Route::post('ajaxChangeProcess', array('as' => 'claimHdi.ajaxChangeProcess', 'uses' => ModuleClaimIndemnify . '\ClaimHdiController@ajaxChangeProcess'));


        //Duyệt bồi thường ban
        Route::match(['GET', 'POST'],'indexClaimDepart', array('as' => 'claimDepart.indexClaimDepart', 'uses' => ModuleClaimIndemnify . '\ClaimHdiController@indexClaimDepart'));

        //Duyệt bồi thường công ty
        Route::match(['GET', 'POST'],'indexClaimCompany', array('as' => 'claimCompany.indexClaimCompany', 'uses' => ModuleClaimIndemnify . '\ClaimHdiController@indexClaimCompany'));

        //Thanh toán bồi thường
        Route::match(['GET', 'POST'],'indexClaimAccountant', array('as' => 'claimAccountant.indexClaimAccountant', 'uses' => ModuleClaimIndemnify . '\ClaimHdiController@indexClaimAccountant'));

        //bồi thường VietJet
        Route::match(['GET', 'POST'],'indexVietJet', array('as' => 'claimHdi.indexVietJet', 'uses' => ModuleClaimIndemnify . '\ClaimHdiController@indexVietJet'));

    });

    /* Giám định HDI */
    Route::group(array('prefix' => 'inspectionHdi'), function () {
        Route::match(['GET', 'POST'],'indexMotorVehicle', array('as' => 'inspectionHdi.indexMotorVehicle', 'uses' => ModuleInspection . '\InspectionController@indexMotorVehicle'));
        Route::get('getSearchAjax', array('as' => 'inspectionHdi.getSearchAjax', 'uses' => ModuleInspection . '\InspectionController@getSearchAjax'));
        Route::get('ajaxGetItem', array('as' => 'inspectionHdi.ajaxGetItem', 'uses' => ModuleInspection . '\InspectionController@ajaxGetItem'));
        Route::post('ajaxPostItem', array('as' => 'inspectionHdi.ajaxPostItem', 'uses' => ModuleInspection . '\InspectionController@ajaxPostItem'));
        Route::post('ajaxGetData', array('as' => 'inspectionHdi.ajaxGetData', 'uses' => ModuleInspection . '\InspectionController@ajaxGetData'));
        Route::post('ajaxUpdateCalendarInspection', array('as' => 'inspectionHdi.ajaxUpdateCalendarInspection', 'uses' => ModuleInspection . '\InspectionController@ajaxUpdateCalendarInspection'));

        Route::match(['GET', 'POST'],'indexApproval', array('as' => 'inspectionHdi.indexApproval', 'uses' => ModuleInspection . '\InspectionController@indexApproval'));
    });
});

/* CameraRecord */
Route::group(array('prefix' => 'record'), function () {
    Route::match(['GET', 'POST'],'vehicle', array('as' => 'cameraRecord.recordInspectionMotorVehicle', 'uses' => ModuleCameraRecord . '\CameraRecordController@recordInspectionMotorVehicle'));
});
