<?php
/**
 * QuynhTM add
 */
namespace App\Library\AdminFunction;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class Memcache
{
    const CACHE_ON = STATUS_INT_MOT;// 0: khong dung qua cache, 1: dung qua cache
    /************************************************************************************************
     * Cache Backend
     ************************************************************************************************/
    const CACHE_DEFINE_SYSTEM_ID = 'CACHE_DEFINE_SYSTEM_ID_';
    const CACHE_DEFINE_BY_DEFINE_CODE = 'CACHE_DEFINE_BY_DEFINE_CODE_';

    const CACHE_MENU_BY_ID = 'cache_menu_by_id_';

    /************************************************************************************************
     * Cache Admin
     ************************************************************************************************/

    const CACHE_MENU_BY_TAB_ID = 'cache_menu_by_tab_id_';
    const CACHE_LIST_MENU_PERMISSION = 'cache_list_menu_permission';
    const CACHE_ALL_PARENT_MENU = 'cache_all_parent_menu_';
    const CACHE_TREE_MENU = 'cache_tree_menu_';

    const CACHE_USER_ADMIN_ID = 'cache_user_admin_id_';
    const CACHE_ALL_USER_ADMIN = 'cache_all_user_admin';
    const CACHE_OPTION_USER = 'cache_option_user';
    const CACHE_INFO_USER = 'cache_info_user';
    const CACHE_FULL_USER_ID = 'cache_full_user_id_';
    const CACHE_USER_BY_MANAGER = 'cache_user_by_manager_';
    const CACHE_USER_BY_DEPART = 'cache_user_by_depart_';
    const CACHE_USER_BY_DEPART_ONE = 'cache_user_by_depart_one_';
    const CACHE_ROLE_MENU_ID = 'cache_role_menu_id_';

    //DMS
    const CACHE_CALENDAR_WORKING_ID = 'cache_calendar_working_id_';
    const CACHE_STAFF_ID = 'cache_staff_id_';
    const CACHE_POST_ID = 'cache_posts_id_';
    const CACHE_DEPARTMENT_ID = 'cache_department_id_';
    const CACHE_All_DEPARTMENT = 'cache_all_department';

    const CACHE_PERMISSION_ID = 'cache_permission_id_';
    const CACHE_ROLE_ID = 'cache_role_id_';
    const CACHE_OPTION_ROLE = 'cache_option_role';
    const CACHE_ROLE_ALL = 'cache_option_all';

    const CACHE_PROVINCE_ID = 'cache_province_id_';
    const CACHE_OPTION_PROVINCE = 'cache_option_province';

    /************************************************************************************************
     * Cache HD Insurance
     ************************************************************************************************/
    const CACHE_API_TOKEN_HD = 'cache_api_token_hd';

    const CACHE_LIST_FIELD_TABLE_NAME = 'cache_list_field_table_';

    const CACHE_TYPE_DEFINE_ALL = 'cache_type_define_all';

    const CACHE_PROVINCE_DISTRICT_WARD_ALL = 'cache_province_district_ward_all';

    const CACHE_BANK_ALL = 'cache_bank_all';
    const CACHE_BANK_BY_KEY = 'cache_bank_by_key_';

    const CACHE_MENU_SYSTEM_BY_ID = 'cache_menu_system_by_id_';
    const CACHE_MENU_SYSTEM_BY_PROJECT_CODE = 'cache_menu_system_by_project_code_';
    const CACHE_TREE_MENU_SYSTEM_BY_PROJECT_CODE = 'cache_tree_menu_system_by_project_code_';

    const CACHE_USERS_BY_KEY = 'cache_users_by_key_';
    const CACHE_INFOR_USERS_BY_KEY = 'cache_infor_users_by_key_';
    const CACHE_USERS_ABOUT_BY_KEY = 'cache_users_about_by_key_';
    const CACHE_USER_GROUP_MENU_BY_KEY = 'user_group_menu_by_key_';
    const CACHE_USER_MENU_BY_KEY = 'cache_user_menu_by_key_';

    const CACHE_ORGANIZATION_BY_KEY = 'cache_organization_by_key_';
    const CACHE_ORGANIZATION_ALL = 'cache_organization_all';
    const CACHE_ORGANIZATION_DATA_RELATION_BY_ORG_CODE = 'cache_organization_data_relation_by_org_code_';

    const CACHE_ORG_BANK_BY_KEY = 'cache_org_bank_by_key_';
    const CACHE_ORG_CONTRACT_BY_KEY = 'cache_org_contract_by_key_';
    const CACHE_ORG_RELATIONSHIP_BY_KEY = 'cache_org_relationship_by_key_';
    const CACHE_ORG_STRUCT_BY_KEY = 'cache_org_struct_by_key_';

    const CACHE_ALL_DEPARTMENT_BY_KEY_CODE = 'cache_all_department_by_key_code_';
    const CACHE_ALL_DEPARTMENT = 'cache_all_department';
    const CACHE_DEPARTMENT_BY_KEY = 'cache_department_by_key_';

    const CACHE_GROUP_MENU_BY_ID = 'cache_group_menu_by_id_';
    const CACHE_DETAIL_GROUP_MENU_BY_KEY = 'cache_detail_group_menu_by_key_';
    const CACHE_DETAIL_GROUP_MENU_BY_ORG_CODE = 'cache_detail_group_menu_by_org_code_';

    const CACHE_TYPE_DEFINE_BY_ID = 'cache_type_define_by_id_';

    const CACHE_VERSIONS_BY_ID = 'cache_versions_by_id_';
    const CACHE_VERSIONS_ALL = 'cache_versions_all';
    const CACHE_LIST_DETAIL_BY_VERSIONS_CODE = 'cache_list_detail_by_versions_code_';
    const CACHE_DETAIL_VERSIONS_BY_ID = 'cache_detail_versions_by_id_';

    const CACHE_DATABASES_BY_KEY = 'cache_databases_by_key_';
    const CACHE_DATABASES_ALL = 'cache_databases_all';

    const CACHE_DOMAINS_BY_KEY = 'cache_domains_by_key_';
    const CACHE_DOMAINS_ALL = 'cache_domains_all';

    //API
    const CACHE_APIS_ALL = 'cache_apis_all';
    const CACHE_APIS_BY_KEY = 'cache_apis_by_key_';
    const CACHE_DATABASES_APIS_BY_ID = 'cache_databases_apis_by_id_';
    const CACHE_DATABASES_APIS_BY_KEY = 'cache_databases_apis_by_key_';
    const CACHE_BEHAVIOURS_APIS_BY_KEY = 'cache_behaviours_apis_by_key_';
    const CACHE_EVENTS_APIS_BY_KEY = 'cache_events_apis_by_key_';
    const CACHE_ALL_EVENTS_APIS_BY_KEY = 'cache_all_events_apis_by_key_';

    //MEDIA
    const CACHE_DATA_CONFIG_CODE_BY_KEY = 'cache_data_config_code_by_key_';
    const CACHE_ALL_VOUCHER_VALUE_BY_KEY = 'cache_all_voucher_value_by_key_';
    const CACHE_VOUCHER_VALUE_BY_KEY = 'cache_voucher_value_by_key_';
    const CACHE_CAMPAIGN_INFO_BY_CAMPAIGN_CODE = 'cache_campaign_info_by_campaign_code_';

    const CACHE_CAMPAIGNS_ALL = 'cache_campaigns_all';
    const CACHE_ALL_DEFINE_POLICY = 'cache_all_define_policy';
    /**
     * @param string $key_cache
     * @return bool
     */
    public static function getCache($key_cache = ''){
        return (trim($key_cache) != '' && Memcache::CACHE_ON) ? Cache::get($key_cache) : false;
    }

    /**
     * @param string $key_cache
     * @param array $data
     * @param int $time
     * @return bool
     */
    public static function putCache($key_cache = '', $data = [] , $time = CACHE_ONE_YEAR){
        return (trim($key_cache) != ''  && !empty($data) && Memcache::CACHE_ON) ? Cache::put($key_cache, $data, $time) : false;
    }

    /**
     * @param string $key_cache
     * @return bool
     */
    public static function forgetCache($key_cache = '',$arrDomain = []){
        if(!empty($arrDomain)){
            if(!empty($arrDomain)){
                $curl = Curl::getInstance();
                foreach ($arrDomain as $domain){
                    $curl->execUrlOnsite($domain.'manager/clear');
                }
            }
        }
        return (trim($key_cache) != '' && Memcache::CACHE_ON) ? Cache::forget($key_cache) : false;
    }
}
