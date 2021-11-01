<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 10/17/2016
 * Time: 2:06 PM
 */

//Action Execute HDI
define('PERMISS_FULL','FULL_PERMISS');
define('PERMISS_VIEW','VIEW');
define('PERMISS_ADD','ADD');
define('PERMISS_EDIT','EDIT');
define('PERMISS_REMOVE','REMOVE');
define('PERMISS_APPROVE','APPROVE');
define('PERMISS_CREATE_ORDER','CREATE_ORDER');
define('PERMISS_INSPECTION','INSPECTION');

define('ERROR_AUT_EXP_API', 'ERROR_2004');
define('ACTION_GET_FIELD_TABLE', 'HDI_27');

/*********************************************************************************************************
 * //HDI OPEN API
 *********************************************************************************************************/
define('ACTION_SEARCH_BANK', 'HDI_47');
define('ACTION_EDIT_BANK', 'HDI_49');
define('ACTION_DELETE_BANK', 'HDI_51');
define('ACTION_GET_BANK_BY_KEY', 'HDI_50');
define('ACTION_GET_BANK_ALL', 'HDI_48');

define('ACTION_SEARCH_PROVINCE_DISTRICT_WARD_ALL', 'APITHUG19J');//all data tỉnh thành

define('ACTION_SEARCH_ORG', 'HDI_23');
define('ACTION_EDIT_ORG', 'HDI_25');
define('ACTION_DELETE_ORG', 'HDI_26');
define('ACTION_GET_DATA_ORG_ALL', 'HDI_61');
define('ACTION_GET_DATA_ORG_BY_ID', 'HDI_42');
define('ACTION_GET_DATA_RELATION_BY_ORG_CODE', 'HDI_43');
//banks
define('ACTION_EDIT_ORG_BANK', 'HDI_45');
define('ACTION_DELETE_ORG_BANK', 'HDI_46');
define('ACTION_GET_DATA_ORG_BANK_BY_KEY', 'HDI_44');
//contracts
define('ACTION_EDIT_ORG_CONTRACT', 'HDI_52');
define('ACTION_GET_DATA_ORG_CONTRACT_BY_KEY', 'HDI_53');
define('ACTION_DELETE_ORG_CONTRACT_BY_KEY', 'HDI_54');
//structs
define('ACTION_EDIT_ORG_STRUCTS', 'HDI_55');
define('ACTION_GET_DATA_ORG_STRUCTS_BY_KEY', 'HDI_56');
define('ACTION_DELETE_ORG_STRUCTS_BY_KEY', 'HDI_57');
//relationship
define('ACTION_EDIT_ORG_RELATIONSHIP', 'HDI_58');
define('ACTION_GET_DATA_ORG_RELATIONSHIP_BY_KEY', 'HDI_59');
define('ACTION_DELETE_ORG_RELATIONSHIP_BY_KEY', 'HDI_60');

define('ACTION_SEARCH_DEPART', 'HDI_62');
define('ACTION_EDIT_DEPART', 'HDI_63');
define('ACTION_GET_DEPART_BY_KEY', 'HDI_64');
define('ACTION_DELETE_DEPART', 'HDI_65');
define('ACTION_SEARCH_STAFF_BY_DEPART', 'HDI_66');
define('ACTION_MOVE_STAFF_OF_DEPART', 'HDI_67');

define('ACTION_SEARCH_USER', 'HDI_68');
define('ACTION_EDIT_USER', 'HDI_69');
define('ACTION_GET_USER_BY_KEY', 'HDI_70');
define('ACTION_DELETE_USER', 'HDI_71');
define('ACTION_GET_SYSTEM_INFO_USER', 'APIW2OJKLF');
define('ACTION_CHANGE_PASS_USER', 'HDI_82');
//user about
define('ACTION_EDIT_USER_ABOUT', 'HDI_72');
define('ACTION_GET_USER_ABOUT_BY_KEY', 'HDI_73');
//user_group_menu
define('ACTION_EDIT_USER_GROUP_MENU', 'HDI_77');
define('ACTION_GET_USER_GROUP_MENU_BY_KEY', 'HDI_78');
//user about
define('ACTION_EDIT_USER_MENU', 'HDI_79');
define('ACTION_GET_USER_MENU_BY_KEY', 'HDI_80');
//common user
define('ACTION_GET_INFOR_USER', 'HDI_81');
define('ACTION_UPDATE_PROFILE_USER', 'HDI_83');
define('ACTION_UPDATE_USER_LOGIN', 'HDI_84');

define('ACTION_SEARCH_TYPE_DEFINE', 'HDI_37');
define('ACTION_EDIT_TYPE_DEFINE', 'HDI_38');
define('ACTION_DELETE_TYPE_DEFINE', 'HDI_39');
define('ACTION_GET_DATA_BY_TYPE_DEFINE', 'HDI_40');
define('ACTION_ALL_TYPE_DEFINE', 'HDI_41');//24

define('ACTION_SEARCH_MENU', 'HDI_28');
define('ACTION_EDIT_MENU', 'HDI_29');
define('ACTION_DELETE_MENU', 'HDI_30');
define('ACTION_GET_DATA_MENU', 'HDI_31');

define('ACTION_SEARCH_GROUP_MENU', 'HDI_32');
define('ACTION_GET_ALL_GROUP_MENU', 'HDI_33');
define('ACTION_EDIT_GROUP_MENU', 'HDI_34');
define('ACTION_DELETE_GROUP_MENU', 'HDI_35');
define('ACTION_GET_DATA_BY_GROUP_MENU', 'HDI_36');
define('ACTION_GET_GROUP_MENU_BY_ORG_CODE', 'HDI_76');
//detail_group_menu
define('ACTION_EDIT_DETAIL_GROUP', 'HDI_75');
define('ACTION_GET_DETAIL_GROUP_MENU_BY_KEY', 'HDI_74');

/*********************************************************************************************************
 * //HDI OPEN API
 *********************************************************************************************************/
//versions: DB_PORTAL_API_1
define('ACTION_API_SEARCH_VERSIONS', 'HDI_API_01');
define('ACTION_API_EDIT_VERSIONS', 'HDI_API_02');
define('ACTION_API_GET_VERSIONS_BY_KEY', 'HDI_API_03');
define('ACTION_API_ALL_VERSIONS', 'HDI_API_04');
define('ACTION_API_GET_DETAIL_BY_VER', 'HDI_API_05');
define('ACTION_API_EDIT_DETAIL_VER', 'HDI_API_06');
define('ACTION_API_GET_DETAIL_VER_BY_KEY', 'HDI_API_07');

//DATABASES: DB_PORTAL_API_2
define('ACTION_SEARCH_DATABASES', 'HDI_API_08');
define('ACTION_EDIT_DATABASES', 'HDI_API_09');
define('ACTION_GET_DATABASES_BY_KEY', 'HDI_API_10');
define('ACTION_GET_DATABASES_ALL', 'HDI_API_11');

//DOMAINS: DB_PORTAL_API_3
define('ACTION_SEARCH_DOMAINS', 'HDI_API_12');
define('ACTION_EDIT_DOMAINS', 'HDI_API_13');
define('ACTION_GET_DOMAINS_BY_KEY', 'HDI_API_14');
define('ACTION_GET_DOMAINS_ALL', 'HDI_API_15');

//BLACK_LIST: DB_PORTAL_API_4
define('ACTION_SEARCH_BLACK_LIST', 'HDI_API_16');
define('ACTION_SEARCH_BLACK_LIST_DDOS', 'HDI_API_17');

//API: DB_PORTAL_API_5
define('ACTION_SEARCH_APIS', 'HDI_API_18');
define('ACTION_EDIT_APIS', 'HDI_API_19');
define('ACTION_GET_APIS_BY_KEY', 'HDI_API_20');
define('ACTION_GET_APIS_ALL', 'HDI_API_21');


//DATABASES
define('ACTION_EDIT_DATABASES_APIS', 'HDI_API_22');
define('ACTION_GET_DATABASES_APIS_BY_KEY', 'HDI_API_23');
//BEHAVIOURS
define('ACTION_EDIT_BEHAVIOURS_APIS', 'HDI_API_24');
define('ACTION_GET_BEHAVIOURS_APIS_BY_KEY', 'HDI_API_25');
//EVENTS
define('ACTION_EDIT_EVENTS_APIS', 'HDI_API_26');
define('ACTION_GET_EVENTS_APIS_BY_KEY', 'HDI_API_27');
define('ACTION_GET_ALL_EVENTS_APIS_BY_KEY', 'HDI_API_28');

/*********************************************************************************************************
 * //DB_DEVOPS_DEV
 *********************************************************************************************************/
define('ACTION_DEVOPS_SEARCH_DATABASES', 'APIB9HYKVF');//pkg_databases.search_databases
define('ACTION_DEVOPS_GET_DATABASES_BY_KEY', 'API0W6SA3T');//pkg_databases.get_databases_by_key
define('ACTION_DEVOPS_EDIT_DATABASES', 'APIPXAJCT7');//pkg_databases.edit_databases
define('ACTION_DEVOPS_GET_DATABASES_ALL', 'API3RRJJ8A');//pkg_databases.get_databases_all

define('ACTION_DEVOPS_SEARCH_APIS', 'APIU5OSFNX');//pkg_action_api.api_search
define('ACTION_DEVOPS_EDIT_APIS', 'APIW7OL3TA');//pkg_action_api.api_edit
define('ACTION_DEVOPS_GET_APIS_BY_KEY', 'APIBWHCFVC');//pkg_action_api.api_get_by_key

define('ACTION_DEVOPS_GET_DATABASES_BY_API_CODE', 'API2PZQKO5');// 	pkg_action_api.databases_get_by_key
define('ACTION_DEVOPS_GET_DATABASES_BY_ID', 'APIXHPRKPA');// 	pkg_action_api.databases_get_by_id
define('ACTION_DEVOPS_EDIT_DATABASES_BY_ID', 'APIL5XEJZ1');// pkg_action_api.databases_edit

/*********************************************************************************************************
 * //HDI OPEN MEDIA
 *********************************************************************************************************/
//gift_config_code: DB_PORTAL_MEDIA_1
define('ACTION_SEARCH_CONFIG_CODE', 'APIHSWHNKW');//search_code_config
define('ACTION_EDIT_CONFIG_CODE', 'APIKOKWJ3N');//edit_code_config
define('ACTION_GET_DATA_CONFIG_CODE_BY_KEY', 'APIP9471L8');//get_code_config_by_key
define('ACTION_GET_CAMPAIGN_INFO_BY_KEY', 'APIKDDNHB9');//get_campaign_info
define('ACTION_UPDATE_STATUS_CONFIG_VALUE', 'APIVHRI1WH');//update_status_values_config
define('ACTION_LIST_CONFIG_VALUE', 'APIRXDW315');//get_all_value_config_by_key
define('ACTION_EDIT_CONFIG_VALUE', 'APIUBRO772');//edit_values_config
define('ACTION_GET_DATA_CONFIG_VALUE_BY_KEY', 'APIRCODXG1');//get_value_config_by_key
define('ACTION_EXPORT_GIFT_DETAIL', 'APIETYFL7R');//export_gift_details
define('ACTION_UPDATE_STATUS_CONFIG_CODE', 'APIM7B5FLI');//gift_config_code

define('ACTION_GET_VALUES_PRESENT', 'APIEQJ9HE8');//get_config_values_present - lấy dữ liệu cấp phát theo đối tác
define('ACTION_UPDATE_VALUES_PRESENT', 'API6D8JSUB');//update_config_values_present - lấy dữ liệu cấp phát theo đối tác

//quản lý voucher detail
define('ACTION_SEARCH_DETAIL_GIFT', 'APIS04OJQQ');//search_details_gift

//gift_config_code: DB_PORTAL_MEDIA_2
define('ACTION_GET_ALL_MD_CAMPAIGNS', 'APIHVSNEPS');//get_campaigns_all

/*********************************************************************************************************
 * //HDI OPEN REPORT
 *********************************************************************************************************/
//PKG_GENERAL_REPORT: DB_PORTAL_REPORT
//chi tiet danh sach khach hang dang ky theo goi gold health gom can bo va nguoi nha (fees chi tiet)
define('ACTION_REPORT_VOUCHER', 'APIFPLLIOV');//get_customer_regis_pack

//chi tiet danh sach can bo HDI-VJ dang ky chuong trinh
define('ACTION_STAFF_REGIS_GHEALTH', 'APITOFBIC8');//get_staff_regis_ghealth

///báo cáo tổng hợp voucher
define('ACTION_AGG_SITUATION_VOUCHER', 'API2KKIQ0G');//agg_situation_voucher

//báo cáo dashbroad selling
define('ACTION_REPORT_DASHBROAD_SELLING', 'APIZMNRWRE');//get_data_present

//excel Insmart
define('ACTION_REPORT_INSMART', 'APINMA4WYD');//get_detail_cus_by_campaign

//report
define('ACTION_REPORT_PRODUCT', 'APIERE75JX');//Báo cáo sản phâm: PKG_RPT_CONTRACTS.rpt_insur_product_details
define('ACTION_REPORT_DETAIL_PRODUCT', 'APID68SREX');//Báo cáo chi tiết sản phâm: PKG_RPT_CONTRACTS.rpt_insur_product_details
define('ACTION_REPORT_DATA_RECONCILIATION', 'APIHZYO0KG');//Báo cáo đối soát: PKG_RPT_CROSSCHECK.rpt_crosscheck
define('ACTION_REPORT_CLAIM_VIETJET', 'APIBNKU7V8');//Báo cáo bồi thường VietJet: PKG_RPT_CLAIMS.rpt_general_claims
define('ACTION_REPORT_ORDER_BUY', 'APIGR1JRQO');//Báo cáo đăng ký mua BH thường VietJet: pkg_rpt_contracts.search_infor_customer

/*********************************************************************************************************
 * //HDI An tâm tín dụng
 *********************************************************************************************************/
define('ACTION_SEARCH_INSURANCE_POLICY', 'APIVR2B6AL');// danh sách an tâm tín dụng theo sản phẩm

define('ACTION_DETTAIL_ORDER_INSURANCE', 'API9JOC36Z');// Chi tiết cấp đơn
define('ACTION_EDIT_ORDER_INSURANCE', 'API0OVG3B1');// Edit Chi tiết cấp đơn
define('ACTION_DETTAIL_CONTRACT_CERTIFICATE', 'API4CQ0Z1U');// Chi tiết hợp đồng: get_detail_certificate
define('ACTION_ALL_DEFINE_POLICY', 'APISZ0XSJ1');// get dinh nghia cap don

//PaymentContract
define('ACTION_SEARCH_PAYMENT_CONTRACT', 'APIFRD2JVT');// get_data_trans: get danh sách thanh toán HĐ
define('ACTION_DETTAIL_PAYMENT_CONTRACT', 'APIUP37TNB');// get_order_trans: get danh sách thanh toán HĐ
define('ACTION_LIST_NOT_PAYMENT_CONTRACT', 'APIC9ZDK5F');// pkg_c_payment.get_transfer_trust: get danh sách chưa thanh toán, chưa map
define('ACTION_CHANGE_DONE_PAYMENT_CONTRACT', 'APIK4VDVXY');// pkg_c_payment.update_transfer: gán tran vào thanh toán
define('ACTION_MOVE_ORDER_PAYMENT_CONTRACT', 'APIK37X0HC');// pkg_c_payment.update_transfer: move payment cho KH
define('ACTION_APPROVAL_ORDER_PAYMENT_CONTRACT', 'APIWMPKDJV');// phê duyệt đơn ở màn hình list

//Claim HDI
define('ACTION_SEARCH_CLAIM_HDI', 'APIHHKFEBW');// get_claims: get danh sách
define('ACTION_CHANGE_PROCESS', 'APIBGIH3HN');// save_process: cập nhật trạng thái
//Giám định
define('ACTION_SEARCH_INSPECTION_HDI', 'API5VTJXSH');// pkg_insur_info.search_info_insur: list giám định xe cơ giới
define('ACTION_UPDATE_CALENDAR_INSPECTION', 'APIP8TN47Q');// pkg_inspection_vehicle.update_appointment: cập nhật lịch hẹn

//ExtenActionHdi
define('ACTION_SEARCH_DIGITALLY_SIGNED', 'APIAH1T1B3');// search
define('ACTION_CREATE_DIGITALLY_SIGNED', 'HDI_SIGN');// ký số

/*********************************************************************************************************
 * //HDI B_CONTRACTS
 *********************************************************************************************************/
define('ACTION_B_CONTRACTS_SEARCH_PRODUCT', 'API6ERHTCJ');// list sản phẩm pkg_define_bussiness.search_product
define('ACTION_B_CONTRACTS_ADD_PRODUCT_USER', 'APIILV2534');// add sản phẩm cho user: pkg_define_bussiness.edit_product_with_user
define('ACTION_B_CONTRACTS_GET_PRODUCT_BY_USER_CODE', 'APIH47JH13');// get sản phẩm by user code: pkg_define_bussiness.get_product_by_user_code

//ExtenActionHdi: cấp đơn
define('ACTION_SEARCH_LIST_CREATE_ORDER', 'API0DBOCAH');//pkg_insur_batch.search_prog_batch_detail
define('ACTION_REMOVE_LIST_CREATE_ORDER', 'APIBP79YU6');// pkg_insur_batch.del_prog_batch_by_contract
define('ACTION_GET_INFOR_PROGRAM_ALL', 'APIQRALIE1');// pkg_define_bussiness.get_infor_program_all
define('ACTION_GET_INFOR_PROGRAM_DETAILS', 'APIV2F0ZHS');// pkg_define_bussiness.get_infor_program_details
define('ACTION_UPDATE_PROGRAM_DETAILS', 'APIC8Y7APR');// pkg_define_bussiness.save_infor_program_details














