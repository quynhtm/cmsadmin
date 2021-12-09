<?php

namespace App\Models\BackendCms;

use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

class PermissionUser extends BaseModel
{
    protected $table = TABLE_PERMISSION_USER;
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = PermissionUser::where($this->primaryKey, '>', STATUS_INT_KHONG);
            if (isset($dataSearch['define_name']) && $dataSearch['define_name'] != '') {
                $query->where('define_name', 'LIKE', '%' . $dataSearch['define_name'] . '%');
            }
            if (isset($dataSearch['define_code']) && $dataSearch['define_code'] != '') {
                $query->where('define_code', $dataSearch['define_code']);
            }
            if (isset($dataSearch['define_status']) && $dataSearch['define_status'] > -1) {
                $query->where('define_status', $dataSearch['define_status']);
            }
            if (isset($dataSearch['define_type']) && $dataSearch['define_type'] > STATUS_INT_KHONG) {
                $query->where('define_type', $dataSearch['define_type']);
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
                $item = ($id <= STATUS_INT_KHONG)? new PermissionUser(): self::getItemById($id);
                if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                    foreach ($fieldInput as $k => $v) {
                        $item->$k = $v;
                    }
                }
                if($id <= STATUS_INT_KHONG){
                    $item->created_id = $this->getUserId();
                    $item->created_name = $this->getUserName();
                    $item->save();
                    $id = $item->id;
                }else{
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
        $data = Memcache::getCache(Memcache::CACHE_PERMISSION_USER_ID.$id);
        if (!$data) {
            $data = PermissionUser::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_PERMISSION_USER_ID.$id, $data);
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
            Memcache::forgetCache(Memcache::CACHE_PERMISSION_USER_ID.$id);
        }
        if($data){
            Memcache::forgetCache(Memcache::CACHE_PERMISSION_USER_BY_USER_ID.$data->user_id);
        }
    }

    public function updatePermissUser($arrPermissForm = [], $user_id = 0, $project_code = 0)
    {
        $edit = false;
        if ($user_id <= 0 || $project_code <= 0)
            return $edit;

        PermissionUser::where('user_id', $user_id)->where('project_code', $project_code)->delete();
        $edit = true;

        if(!empty($arrPermissForm)){
            foreach ($arrPermissForm as $permiss_code => $arrMenu) {
                foreach ($arrMenu as $k => $menu_id) {
                    $arrInsert['user_id'] = $user_id;
                    $arrInsert['project_code'] = $project_code;
                    $arrInsert['menu_id'] = $menu_id;
                    $arrInsert['permiss_code'] = $permiss_code;
                    $arrInsert['is_active'] = STATUS_INT_MOT;
                    if ($this->editItem($arrInsert)) {
                        $edit = true;
                    }
                }
            }
        }

        Memcache::forgetCache(Memcache::CACHE_PERMISSION_USER_BY_USER_ID . $user_id);
        return $edit;
    }

    public function getPermissUserWithUserId($user_id = 0)
    {
        $data = Memcache::getCache(Memcache::CACHE_PERMISSION_USER_BY_USER_ID . $user_id);
        if (!$data) {
            $data = PermissionUser::where('user_id', $user_id)->get();
            if ($data) {
                Memcache::putCache(Memcache::CACHE_PERMISSION_USER_BY_USER_ID . $user_id, $data);
            }
        }
        return $data;
    }
}
