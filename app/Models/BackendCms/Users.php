<?php

namespace App\Models\BackendCms;

use App\Library\AdminFunction\CGlobal;
use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;
use Illuminate\Support\Facades\Session;

class Users extends BaseModel
{
    protected $table = TABLE_USERS;
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = Users::where($this->primaryKey, '>', STATUS_INT_KHONG);
            if (isset($dataSearch['user_name']) && $dataSearch['user_name'] != '') {
                $query->where('user_name', 'LIKE', '%' . $dataSearch['user_name'] . '%');
            }
            if (isset($dataSearch['full_name']) && $dataSearch['full_name'] != '') {
                $query->where('full_name', 'LIKE', '%' . $dataSearch['full_name'] . '%');
            }
            if (isset($dataSearch['user_email']) && $dataSearch['user_email'] != '') {
                $query->where('user_email', 'LIKE', '%' . $dataSearch['user_email'] . '%');
            }
            if (isset($dataSearch['user_code']) && $dataSearch['user_code'] != '') {
                $query->where('user_code', 'LIKE', '%' . $dataSearch['user_code'] . '%');
            }

            if (isset($dataSearch['is_active']) && $dataSearch['is_active'] > -1) {
                $query->where('is_active', $dataSearch['is_active']);
            }
            if (isset($dataSearch['user_type']) && $dataSearch['user_type'] != '') {
                $query->where('user_type', $dataSearch['user_type']);
            }

            $total = ($is_total) ? $query->count() : STATUS_INT_KHONG;
            $query->orderBy('created_at', 'desc');

            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            if (!empty($fields)) {
                $result = $query->take($limit)->skip($offset)->get($fields);
            } else {
                $result = $query->take($limit)->skip($offset)->get();
            }
            return ['data' => $result, 'total' => $total];

        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function editItem($data, $id = 0)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                $item = ($id <= STATUS_INT_KHONG) ? new Users() : self::getItemById($id);
                if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                    foreach ($fieldInput as $k => $v) {
                        $item->$k = $v;
                    }
                }
                if ($id <= STATUS_INT_KHONG) {
                    $item->created_id = $this->getUserId();
                    $item->created_name = $this->getUserName();
                    $item->save();
                    $id = $item->id;
                } else {
                    $item->updated_id = $this->getUserId();
                    $item->updated_name = $this->getUserName();
                    $item->update();
                }
                self::removeCache($id, $item);
                return $id;
            }
            return STATUS_INT_KHONG;
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function getItemById($id)
    {
        $data = Memcache::getCache(Memcache::CACHE_USER_ADMIN_ID . $id);
        if (!$data) {
            $data = Users::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_USER_ADMIN_ID . $id, $data);
            }
        }
        return $data;
    }

    public function deleteItem($id)
    {
        if ($id <= STATUS_INT_KHONG) return false;
        try {
            $item = $dataOld = self::getItemById($id);
            if ($item) {
                $item->delete();
                self::removeCache($id, $dataOld);
                return true;
            }
            return false;
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function removeCache($id = STATUS_INT_KHONG, $data = [])
    {
        if ($id > STATUS_INT_KHONG) {
            Memcache::forgetCache(Memcache::CACHE_USER_ADMIN_ID . $id);
        }
        if ($data) {
            Memcache::forgetCache(Memcache::CACHE_DEFINE_BY_DEFINE_CODE . $data->define_code . '_' . $data->project_code);
        }
    }

    /**********************************************************************************************************************/
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
    public function getUserByName($name)
    {
        return Users::where('user_name', $name)->first();
    }

    public function getUserByEmail($user_email)
    {
        return Users::where('user_email', $user_email)->first();
    }

    public function encode_password($password)
    {
        return password_hash(Users::stringCode($password), PASSWORD_DEFAULT);
    }

    public function password_verify($password = '', $hash = '')
    {
        return password_verify(Users::stringCode(trim($password)), trim($hash)) ? true : false;
    }

    public function stringCode($string)
    {
        return $string . CGlobal::authorWeb . env('KEY_PASS', '-!@0938413368!@');
    }
    public function updateLogin($user_id)
    {
        if($user_id <= STATUS_INT_KHONG) return;
        $updateData['last_login'] = getCurrentDateTime();
        self::editItem( $updateData , $user_id);
    }
    public function getPermissionUser($user = false)
    {
        $arrPermiss = ['permUserGroup'=>[],'permUser'=>[],'menuUser'=>[]];
        if (isset($user->id) && $user->id > STATUS_INT_KHONG) {
            $arrMenu = [];
            //perm user group
            $strGroup = PermissionUserGroup::where('user_id', $user->id)->first(['str_group_id']);
            if (isset($strGroup->str_group_id) && trim($strGroup->str_group_id) != '') {
                $strGroupDetail = PermissionGroupDetail::whereIn('group_id', explode(',', trim($strGroup->str_group_id)))->get(['group_id', 'project_code', 'menu_id', 'permiss_code', 'is_active']);
                $groupDetail = ($strGroupDetail) ? $strGroupDetail->toArray() : [];
                if(!empty($groupDetail)){
                    $arrPermiss['permUserGroup'] = $groupDetail;
                    foreach ($groupDetail as $k=>$val){
                        $arrMenu[$val['menu_id']] = $val['menu_id'];
                    }
                }
            }
            //perm user
            $permUser = PermissionUser::where('user_id', $user->id)->get(['user_id','project_code','menu_id','permiss_code','is_active']);
            if($permUser){
                $arrPermiss['permUser'] = $permUser->toArray();
                foreach ($permUser->toArray() as $kk=>$val2){
                    $arrMenu[$val2['menu_id']] = $val2['menu_id'];
                }
            }
            $arrPermiss['menuUser'] = $arrMenu;
        }
        return $arrPermiss;
    }
}
