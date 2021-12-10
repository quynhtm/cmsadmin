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

    const CACHE_USER_ADMIN_ID = 'CACHE_USER_ADMIN_ID_';

    const CACHE_MENU_BY_ID = 'CACHE_MENU_BY_ID_';
    const CACHE_ALL_MENU = 'CACHE_ALL_MENU';

    const CACHE_PERMISSION_GROUP_ID = 'CACHE_PERMISSION_GROUP_ID_';
    const CACHE_PERMISSION_GROUP_ALL = 'CACHE_PERMISSION_GROUP_ALL';

    const CACHE_PERMISSION_GROUP_DETAIL_BY_GROUP_ID = 'CACHE_PERMISSION_GROUP_DETAIL_BY_GROUP_ID_';
    const CACHE_PERMISSION_GROUP_DETAIL_ID = 'CACHE_PERMISSION_GROUP_DETAIL_ID_';

    const CACHE_PERMISSION_USER_BY_USER_ID = 'CACHE_PERMISSION_USER_BY_USER_ID_';
    const CACHE_PERMISSION_USER_ID = 'CACHE_PERMISSION_USER_ID_';

    const CACHE_PERMISSION_USER_GROUP_BY_USER_ID = 'CACHE_PERMISSION_USER_GROUP_BY_USER_ID_';
    const CACHE_PERMISSION_GROUP_USER_ID = 'CACHE_PERMISSION_GROUP_USER_ID_';

    /************************************************************************************************
     * Cache Web
     ************************************************************************************************/
    const CACHE_PARTNER_ID = 'CACHE_PARTNER_ID_';
    const CACHE_ALL_PARTNER = 'CACHE_ALL_PARTNER';

    const CACHE_CONTACT_ID = 'CACHE_CONTACT_ID_';

    const CACHE_RECRUITMENT_ID = 'CACHE_RECRUITMENT_ID_';

    /************************************************************************************************
     * Cache Admin
     ************************************************************************************************/
    const CACHE_MENU_BY_TAB_ID = 'cache_menu_by_tab_id_';
    const CACHE_LIST_MENU_PERMISSION = 'cache_list_menu_permission';
    const CACHE_ALL_PARENT_MENU = 'cache_all_parent_menu_';
    const CACHE_TREE_MENU = 'cache_tree_menu_';

    const CACHE_ALL_USER_ADMIN = 'cache_all_user_admin';
    const CACHE_OPTION_USER = 'cache_option_user';
    const CACHE_INFO_USER = 'cache_info_user';
    const CACHE_FULL_USER_ID = 'cache_full_user_id_';
    const CACHE_USER_BY_MANAGER = 'cache_user_by_manager_';
    const CACHE_USER_BY_DEPART = 'cache_user_by_depart_';
    const CACHE_USER_BY_DEPART_ONE = 'cache_user_by_depart_one_';
    const CACHE_ROLE_MENU_ID = 'cache_role_menu_id_';

    //DMS
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
    const CACHE_DATABASES_ALL = 'cache_databases_all';
    const CACHE_CAMPAIGNS_ALL = 'cache_campaigns_all';

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
