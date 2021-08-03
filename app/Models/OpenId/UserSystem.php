<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenId;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class UserSystem extends ModelService
{
    /*********************************************************************************************************
     * Danh mục tổ chức: TABLE_SYS_USERS
     *********************************************************************************************************/
    public $table = TABLE_SYS_USERS;
    public $table_user_about = TABLE_SYS_USER_ABOUT;
    public $table_user_group_menu = TABLE_SYS_USER_GROUP_MENU;

    public function searchUser($dataRequest = array())
    {
        $requestDefault = $this->dataRequestDefault;
        $requestDefault["p_keyword"] = (isset($dataRequest['p_keyword'])) ? $dataRequest['p_keyword'] : '';
        $requestDefault["p_org_code"] = (isset($dataRequest['p_org_code'])) ? $dataRequest['p_org_code'] : '';
        $requestDefault["p_struct_code"] = (isset($dataRequest['p_struct_code'])) ? $dataRequest['p_struct_code'] : '';
        $requestDefault["p_is_active"] = (isset($dataRequest['p_is_active'])) ? $dataRequest['p_is_active'] : '';
        $requestDefault["p_user_name"] = (isset($dataRequest['p_user_name'])) ? $dataRequest['p_user_name'] : '';
        $requestDefault["p_user_type"] = (isset($dataRequest['p_user_type'])) ? $dataRequest['p_user_type'] : '';
        $requestDefault["p_page"] = (isset($dataRequest['page_no'])) ? $dataRequest['page_no'] : STATUS_INT_MOT;

        return $this->searchDataCommon($requestDefault, ACTION_SEARCH_USER);
    }

    public function getUserByKey($org_code = '')
    {
        return $this->getDataCommonByOneKey($org_code, ACTION_GET_USER_BY_KEY, Memcache::CACHE_USERS_BY_KEY);
    }

    public function editUser($dataInput, $action = 'ADD')
    {
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table, ACTION_EDIT_USER, [$this->table_user_about]);
        $this->removeCache($dataInput);
        return $item;
    }

    public function deleteUser($dataInput = [])
    {
        if (!isset($dataInput['USER_CODE']))
            return $this->returnStatusError();
        $this->setUserAction();
        $dataDelete = $this->dataRequestDefault;
        $dataDelete['p_key'] = $dataInput['USER_CODE'];
        $dataDelete['p_isactive'] = STATUS_INT_KHONG;
        $dataRequest['Action'] = ['ActionCode' => ACTION_DELETE_USER];
        $dataRequest['Data'] = $dataDelete;

        $resultApi = $this->postApiHD($dataRequest);
        $this->removeCache($dataInput);
        return $this->returnResponse($resultApi);
    }

    public function updatePassword($userCode = 0, $dataInput = [])
    {
        if ($userCode <= 0)
            return $this->returnStatusError();
        $this->setUserAction();
        $dataUpdate = $this->dataRequestDefault;
        $dataUpdate['p_user_code'] = $userCode;
        $dataUpdate['p_password'] = $dataInput['PASSWORD'];
        $dataUpdate['p_old_password'] = $dataInput['OLD_PASSWORD'];
        $dataUpdate['p_is_change_pwd'] = $dataInput['IS_CHANGE_PWD'];

        $dataRequest['Action'] = ['ActionCode' => ACTION_CHANGE_PASS_USER];
        $dataRequest['Data'] = $dataUpdate;

        $resultApi = $this->postApiHD($dataRequest);
        $dataInput['USER_CODE'] = $userCode;
        $this->removeCache($dataInput);
        return $this->returnResponse($resultApi);
    }

    public function updateUserLogin($userCode = 0, $dataInput = [])
    {
        if ($userCode <= 0)
            return $this->returnStatusError();
        $this->setUserAction();
        $dataUpdate = $this->dataRequestDefault;
        $dataUpdate['p_user_code'] = $userCode;
        $dataUpdate['p_last_login'] = '';

        $dataRequest['Action'] = ['ActionCode' => ACTION_UPDATE_USER_LOGIN];
        $dataRequest['Data'] = $dataUpdate;

        $resultApi = $this->postApiHD($dataRequest);
        $dataInput['USER_CODE'] = $userCode;
        $this->removeCache($dataInput);
        return $this->returnResponse($resultApi);
    }

    public function updateProfileUser($userCode = 0, $dataInput = [])
    {
        if ($userCode <= 0)
            return $this->returnStatusError();
        $this->setUserAction();
        $dataUpdate = $this->dataRequestDefault;
        $dataUpdate['p_user_code'] = $userCode;
        $dataUpdate['p_full_name'] = $dataInput['FULL_NAME'];
        $dataUpdate['p_birthday'] = $dataInput['BIRTHDAY'];
        $dataUpdate['p_email'] = $dataInput['EMAIL'];
        $dataUpdate['p_id_card'] = $dataInput['ID_CARD'];
        $dataUpdate['p_phone'] = $dataInput['PHONE'];
        $dataUpdate['p_passport_no'] = $dataInput['PASSPORT_NO'];
        $dataUpdate['p_gender'] = $dataInput['GENDER'];
        $dataUpdate['p_image'] = $dataInput['IMAGE'];

        $dataRequest['Action'] = ['ActionCode' => ACTION_UPDATE_PROFILE_USER];
        $dataRequest['Data'] = $dataUpdate;
        $resultApi = $this->postApiHD($dataRequest);

        $dataInput['USER_CODE'] = $userCode;
        $this->removeCache($dataInput);
        return $this->returnResponse($resultApi);
    }

    public function removeCache($data)
    {
        if (!isset($data['USER_CODE']))
            return false;
        Memcache::forgetCache(Memcache::CACHE_INFOR_USERS_BY_KEY . $data['USER_CODE']);
        Memcache::forgetCache(Memcache::CACHE_USERS_BY_KEY . $data['USER_CODE']);
    }

    /**************************************************************************************
     * UserAbout
     **************************************************************************************/
    public function editUserAbout($dataInput, $action = 'ADD')
    {
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table_user_about, ACTION_EDIT_USER_ABOUT);
        $this->removeCacheRelation($dataInput, 'AB');
        return $item;
    }

    public function getUserAboutByKey($userCode = '')
    {
        return $this->getDataCommonByOneKey($userCode, ACTION_GET_USER_ABOUT_BY_KEY, Memcache::CACHE_USERS_ABOUT_BY_KEY);
    }

    /**************************************************************************************
     * UserGroupMenu
     **************************************************************************************/
    public function editUserGroupMenu($dataInput, $action = 'ADD')
    {
        $this->setUserAction();
        $item = $this->actionEditCommon($dataInput, $action, $this->table_user_group_menu, ACTION_EDIT_USER_GROUP_MENU);
        $this->removeCacheRelation($dataInput, 'GM');
        return $item;
    }

    public function getUserGroupMenuByKey($userCode = '')
    {
        return $this->getDataCommonByOneKey($userCode, ACTION_GET_USER_GROUP_MENU_BY_KEY, Memcache::CACHE_USER_GROUP_MENU_BY_KEY);
    }

    /**************************************************************************************
     * SYS_USER_MENU
     **************************************************************************************/
    public function updateUserMenu($dataInput)
    {
        $this->setUserAction();
        $dataRequestDefault = $this->dataRequestDefault;
        $dataRequestDefault["p_str_data_json"] = $dataInput['str_data_json'];

        $dataRequest['Action'] = ['ActionCode' => ACTION_EDIT_USER_MENU];
        $dataRequest['Data'] = $dataRequestDefault;

        $resultApi = $this->postApiHD($dataRequest);
        $this->removeCacheRelation($dataInput, 'UM');

        return $this->setDataFromApi($resultApi);
    }

    public function getDetailGroupMenuByKey($user_code = '', $org_code = '')
    {
        if (trim($user_code) == '' || trim($org_code) == '')
            return false;
        try {
            $key_cache = Memcache::CACHE_USER_MENU_BY_KEY . $user_code . '_' . $org_code;
            $data = Memcache::getCache($key_cache);
            if (!$data) {
                $dataRequestDefault = $this->dataRequestDefault;
                $dataRequestDefault["p_user_code"] = $user_code;
                $dataRequestDefault["p_org_code"] = $org_code;

                $dataRequest['Data'] = $dataRequestDefault;
                $dataRequest['Action'] = ['ActionCode' => ACTION_GET_USER_MENU_BY_KEY];

                $resultApi = $this->postApiHD($dataRequest);
                $dataGet = $this->setDataFromApi($resultApi);
                $dataSearch = isset($dataGet['Data']['data']) ? $dataGet['Data']['data'] : false;
                if ($dataSearch) {
                    $data = $this->_buildOptionCheckDetailGroup($dataSearch);
                    Memcache::putCache($key_cache, $data);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    private function _buildOptionCheckDetailGroup($data = [])
    {
        $result = [];
        if (!empty($data)) {
            foreach ($data as $k => $val) {
                $result[$val->MENU_CODE][$val->CRUD] = $val->CRUD_LIMIT;
            }
        }
        return $result;
    }

    public function removeCacheRelation($data, $type)
    {
        if (!isset($data['USER_CODE']))
            return;
        Memcache::forgetCache(Memcache::CACHE_USERS_ABOUT_BY_KEY . $data['USER_CODE'], Config::get('config.DOMAINS_PROJECT'));
        Memcache::forgetCache(Memcache::CACHE_INFOR_USERS_BY_KEY . $data['USER_CODE'], Config::get('config.DOMAINS_PROJECT'));
        if ($type = 'AB') {
            Memcache::forgetCache(Memcache::CACHE_USERS_ABOUT_BY_KEY . $data['USER_CODE'], Config::get('config.DOMAINS_PROJECT'));
        }

        if ($type = 'GM') {
            Memcache::forgetCache(Memcache::CACHE_USER_GROUP_MENU_BY_KEY . $data['USER_CODE'], Config::get('config.DOMAINS_PROJECT'));
        }

        if ($type = 'UM') {
            if (isset($data['USER_CODE']) && isset($data['ORG_CODE'])) {
                Memcache::forgetCache(Memcache::CACHE_USER_MENU_BY_KEY . $data['USER_CODE'] . '_' . $data['ORG_CODE'], Config::get('config.DOMAINS_PROJECT'));
            }
        }
    }

    /**************************************************************************************
     * FUNCTION COMMON USER
     **************************************************************************************/
    public function buildPassword($userName = 'Hdi.2020', $password = 'Hdi@2020!')
    {
        return strtolower(md5(strtolower(hash('sha256', $userName . env('KEY_PASS', '-!@Hdi0938413368HDI!@') . $password))));
    }

    public function comparePassword($userNameForm, $passForm, $password)
    {
        $passNew = $this->buildPassword($userNameForm, $passForm);
        if (strcmp(trim($passNew), trim($password)) === 0) {
            return true;
        }
        return false;
    }

    public function isLogin()
    {
        if (session()->has(SESSION_ADMIN_LOGIN)) {
            return true;
        }
        return false;
    }

    public function userLogin()
    {
        $user = array();
        if (Session::has(SESSION_ADMIN_LOGIN)) {
            $user = Session::get(SESSION_ADMIN_LOGIN);
        }
        return $user;
    }

    /**
     * Get thông tin user, quyền, menu
     * @param string $key_code
     * @param string $type_search : USER_CODE,USER_NAME,EMAIL,EMP_CODE
     * @return array|bool
     */
    public function getInforUserByKey($key_code = '', $type_search = 'USER_CODE')
    {
        if (trim($key_code) == '')
            return false;
        try {
            $dataRequestDefault = $this->dataRequestDefault;
            $dataRequestDefault["p_keyword"] = $key_code;
            $dataRequestDefault["p_type_search"] = $type_search;

            $dataRequest['Data'] = $dataRequestDefault;
            $dataRequest['Action'] = ['ActionCode' => ACTION_GET_INFOR_USER];

            $resultApi = $this->postApiHD($dataRequest);
            $dataGet = $this->setDataFromApi($resultApi);
            $data = isset($dataGet['Data']['data'][0]) ? $dataGet['Data']['data'][0] : false;

            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }
    public function getSystemInfoByUser($username = '', $org_code = '')
    {
        if (trim($username) == '' || trim($org_code) == '')
            return false;
        try {
            $dataDelete['p_channel'] = '';
            $dataDelete['p_username'] = $username;
            $dataDelete['p_org_code'] = $org_code;
            $dataRequest['Action'] = ['ActionCode' => ACTION_GET_SYSTEM_INFO_USER];
            $dataRequest['Data'] = $dataDelete;
            $data = $this->postApiHD($dataRequest);
            $arrOrg = $arrProduct = $arrPack = [];
            if ($data->Success == STATUS_INT_MOT) {
                $result_0 = isset($data->Data[0]) ? $data->Data[0] : [];
                if (!empty($result_0)) {
                    foreach ($result_0 as $key =>$val){
                        if(!empty($val->ORG_CODE) && !in_array($val->ORG_CODE,$arrOrg)){
                            $arrOrg[$val->ORG_CODE] = $val->ORG_NAME;
                        }
                        if(!empty($val->PRODUCT_CODE) && !in_array($val->PRODUCT_CODE,$arrProduct)){
                            $arrProduct[$val->PRODUCT_CODE] = $val->PRODUCT_NAME;
                        }
                        if(!empty($val->PACK_CODE) && !in_array($val->PACK_CODE,$arrPack)){
                            $arrPack[$val->PACK_CODE] = $val->PACK_NAME;
                        }
                    }
                }
            }
            $inforUser = ['arrOrg' => $arrOrg, 'arrProduct' => $arrProduct, 'arrPack' => $arrPack];
            return $inforUser;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }
}
