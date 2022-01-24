<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 10/17/2016
 * Time: 2:06 PM
 */

/**************************************************************************************************************
 * định nghĩa Table
 **************************************************************************************************************/
define('PREFIX_BACKEND', 'backend_');
define('PREFIX_WEB', 'web_');
define('PREFIX_SHOP', 'shop_');

//Backend
define('TABLE_PROVINCE',PREFIX_BACKEND.'pdw_province');
define('TABLE_DISTRICTS',PREFIX_BACKEND.'pdw_districts');
define('TABLE_WARDS',PREFIX_BACKEND.'pdw_wards');
define('TABLE_DEFINE_SYSTEM',PREFIX_BACKEND.'define');
define('TABLE_MENU_SYSTEM',PREFIX_BACKEND.'menu');
define('TABLE_PERMISSION_GROUP',PREFIX_BACKEND.'perm_group');
define('TABLE_PERMISSION_GROUP_DETAIL',PREFIX_BACKEND.'perm_group_detail');
define('TABLE_PERMISSION_USER_GROUP',PREFIX_BACKEND.'perm_user_group');
define('TABLE_PERMISSION_USER',PREFIX_BACKEND.'perm_user');
define('TABLE_USERS',PREFIX_BACKEND.'users');

//Shop
define('TABLE_PARTNER_REGISTRATION',PREFIX_SHOP.'partner_registration');
define('TABLE_CUSTOMER_ADVERTISEMENT',PREFIX_SHOP.'customer_advertisement');
define('TABLE_PRODUCT',PREFIX_SHOP.'product');
define('TABLE_ORDERS',PREFIX_SHOP.'orders');
define('TABLE_ORDERS_ITEM',PREFIX_SHOP.'orders_item');

//Web
define('TABLE_PARTNER',PREFIX_WEB.'partner');
define('TABLE_BANNER',PREFIX_WEB.'banner');
define('TABLE_NEWS',PREFIX_WEB.'news');
define('TABLE_CONTACT',PREFIX_WEB.'contact');
define('TABLE_RECRUITMENT',PREFIX_WEB.'recruitment');
define('TABLE_RECRUITMENT_APPLY',PREFIX_WEB.'recruitment_apply');
define('TABLE_CATEGORY',PREFIX_WEB.'category');
define('TABLE_REVIEWS_ITEM',PREFIX_WEB.'reviews_item');


/*********************************************************************************************************
 * list table API: HDI OPEN ID
 *********************************************************************************************************/
define('SCHEMA_OPEN_ID', 'C_OPENID');
define('SCHEMA_OPEN_API', 'C_OPENAPI');
define('SCHEMA_OPEN_MEDIA', 'C_MEDIA');
define('SCHEMA_OPEN_REPORT', 'C_REPORTS');
define('SCHEMA_DEVOPS', 'DEVOPS');

define('TABLE_SYS_ERRORS', 'SYS_ERRORS');
define('TABLE_SYS_GROUP_MENU', 'SYS_GROUP_MENU');
define('TABLE_SYS_MENU', 'SYS_MENU');
define('TABLE_SYS_BANK', 'SYS_BANK');
define('TABLE_SYS_STRUCT_COMPONENTS', 'SYS_STRUCT_COMPONENTS');//department
define('TABLE_SYS_TYPE_DEFINES', 'SYS_TYPE_DEFINES');

define('TABLE_SYS_PROVINCES', 'SYS_PROVINCES');
define('TABLE_SYS_DISTRICTS', 'SYS_DISTRICTS');
define('TABLE_SYS_WARDS', 'SYS_WARDS');

define('TABLE_SYS_ORG', 'SYS_ORG');
define('TABLE_SYS_ORG_BANK', 'SYS_ORG_BANK');
define('TABLE_SYS_ORG_CONTRACTS', 'SYS_ORG_CONTRACTS');
define('TABLE_SYS_ORG_DETAILS', 'SYS_ORG_DETAILS');
define('TABLE_SYS_ORG_POSITIONS', 'SYS_ORG_POSITIONS');
define('TABLE_SYS_ORG_RELATIONSHIP', 'SYS_ORG_RELATIONSHIP');
define('TABLE_SYS_ORG_STRUCTS', 'SYS_ORG_STRUCTS');

define('TABLE_SYS_USERS', 'SYS_USERS');
define('TABLE_SYS_USER_ABOUT', 'SYS_USER_ABOUT');
define('TABLE_SYS_USER_HISTORY', 'SYS_USER_HISTORY');
define('TABLE_SYS_USER_IDENTIFIER', 'SYS_USER_IDENTIFIER');
define('TABLE_SYS_USER_LOGS', 'SYS_USER_LOGS');
define('TABLE_SYS_USER_GROUP_MENU', 'SYS_USER_GROUP_MENU');
define('TABLE_SYS_USER_MENU', 'SYS_USER_MENU');
define('TABLE_SYS_USER_ROLES', 'SYS_USER_ROLES');
define('TABLE_SYS_USER_SETTINGS', 'SYS_USER_SETTINGS');
define('TABLE_SYS_USER_TOKENS', 'SYS_USER_TOKENS');

/*********************************************************************************************************
 * list table API: HDI DEVOPS
 *********************************************************************************************************/
define('TABLE_SYS_DATABASE_DATA', 'SYS_DATABASE_DATA');
define('TABLE_SYS_ACTION_API', 'SYS_ACTION_API');
define('TABLE_SYS_API_GROUP', 'SYS_API_GROUP');
define('TABLE_SYS_API_DATABASE', 'SYS_API_DATABASE');

/*********************************************************************************************************
 * list table API: HDI OPEN API
 *********************************************************************************************************/
define('TABLE_SYS_APIS', 'SYS_APIS');
define('TABLE_SYS_API_BEHAVIOURS', 'SYS_API_BEHAVIOURS');
define('TABLE_SYS_API_DATABASES', 'SYS_API_DATABASES');
define('TABLE_SYS_API_EVENTS', 'SYS_API_EVENTS');
define('TABLE_SYS_BLACK_LIST', 'SYS_BLACK_LIST');
define('TABLE_SYS_BLACK_LIST_DDOS', 'SYS_BLACK_LIST_DDOS');
define('TABLE_SYS_DATABASES', 'SYS_DATABASES');
define('TABLE_SYS_DOMAINS', 'SYS_DOMAINS');
define('TABLE_SYS_ERRORS_API', 'SYS_ERRORS');
define('TABLE_SYS_GROUPS', 'SYS_GROUPS');
define('TABLE_SYS_GROUP_APIS', 'SYS_GROUP_APIS');
define('TABLE_SYS_VERSIONS', 'SYS_VERSIONS');
define('TABLE_SYS_VERSION_DETAILS', 'SYS_VERSION_DETAILS');

define('TABLE_SYS_ORG_CALLBACK', 'SYS_ORG_CALLBACK');
define('TABLE_SYS_ORG_CERTIFICATES', 'SYS_ORG_CERTIFICATES');
define('TABLE_SYS_ORG_CONFIG', 'SYS_ORG_CONFIG');
define('TABLE_SYS_ORG_GROUP_API', 'SYS_ORG_GROUP_API');
define('TABLE_SYS_ORG_LIMIT', 'SYS_ORG_LIMIT');
define('TABLE_SYS_ORG_PAY', 'SYS_ORG_PAY');
define('TABLE_SYS_ORG_PAY_FUNC', 'SYS_ORG_PAY_FUNC');
define('TABLE_SYS_ORG_SECRET', 'SYS_ORG_SECRET');
define('TABLE_SYS_ORG_SERVICES', 'SYS_ORG_SERVICES');
define('TABLE_SYS_ORG_SERVICE_FUNC', 'SYS_ORG_SERVICE_FUNC');
define('TABLE_SYS_ORG_WHITE_LIST', 'SYS_ORG_WHITE_LIST');

/*********************************************************************************************************
 * list table API: HDI OPEN MEDIA
 *********************************************************************************************************/
define('TABLE_BLOCK_GIFT_CODE', 'BLOCK_GIFT_CODE');
define('TABLE_GIFT_CONFIG_CODE', 'GIFT_CONFIG_CODE');
define('TABLE_GIFT_CONFIG_VALUES', 'GIFT_CONFIG_VALUES');
define('TABLE_MD_ACTIVATION_GIFTS', 'MD_ACTIVATION_GIFTS');
define('TABLE_MD_CAMPAIGNS', 'MD_CAMPAIGNS');
define('TABLE_MD_CAMPAIGN_EMAILS', 'MD_CAMPAIGN_EMAILS');
define('TABLE_MD_CAMPAIGN_GIFTS', 'MD_CAMPAIGN_GIFTS');
define('TABLE_MD_CAMPAIGN_NOTIFICATIONS', 'MD_CAMPAIGN_NOTIFICATIONS');
define('TABLE_MD_CAMPAIGN_SETTINGS', 'MD_CAMPAIGN_SETTINGS');
define('TABLE_MD_CAMPAIGN_SMS', 'MD_CAMPAIGN_SMS');
define('TABLE_MD_CAMPAIGN_TEMPLATES', 'MD_CAMPAIGN_TEMPLATES');
define('TABLE_MD_CAM_ERROR', 'MD_CAM_ERROR');
define('TABLE_MD_FILES', 'MD_FILES');
define('TABLE_MD_GIFT_DETAILS', 'MD_GIFT_DETAILS');
define('TABLE_MD_TEMPLATES', 'MD_TEMPLATES');

/*********************************************************************************************************
 * list table Contracts: HDI B_CONTRACTS
 *********************************************************************************************************/
define('TABLE_B_CONTRACTS_PRODUCTS', 'B_PRODUCTS');
