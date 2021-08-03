<?php

namespace App\Models\Admin;

use App\Http\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

class Role extends BaseModel
{
    protected $table = TABLE_ROLE;
    protected $primaryKey = 'role_id';
    //public $timestamps = true;

    public function searchByCondition($dataSearch = array(), $limit = 0, $offset = 0, $is_total = true)
    {
        try {
            $query = Role::where('role_id', '>', 0);
            if (isset($dataSearch['role_name']) && $dataSearch['role_name'] != '') {
                $query->where('role_name', 'LIKE', '%' . $dataSearch['role_name'] . '%');
            }
            if (isset($dataSearch['role_status']) && $dataSearch['role_status'] != STATUS_INT_AM_HAI) {
                $query->where('role_status', $dataSearch['role_status'] );
            }
            $total = ($is_total)? $query->count(): STATUS_INT_KHONG;
            $query->orderBy('role_project', 'asc');
            $query->orderBy('role_order', 'asc');

            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            if ($limit > 0) {
                $query->take($limit);
            }
            if ($offset > 0) {
                $query->skip($offset);
            }
            if (!empty($fields)) {
                $result = $query->get($fields);
            } else {
                $result = $query->get();
            }
            return ['data' => $result, 'total' => $total];
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function createItem($data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                $item = new Role();
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
                $item->user_id_creater = app(User::class)->user_id();
                $item->user_name_creater = app(User::class)->user_name();
                $item->save();

                self::removeCache($item->role_id, $item);
                if($item->role_id > 0){
                    $dataRoleMenu['role_id'] = $item->role_id;
                    $dataRoleMenu['role_name'] = $item->role_name;
                    $dataRoleMenu['role_status'] = $item->role_status;
                    $dataRoleMenu['role_order'] = $item->role_order;
                    $dataRoleMenu['role_code'] = $item->role_code;
                    app(RoleMenu::class)->createItem($dataRoleMenu);
                }
                return $item->role_id;
            }
            return 0;
        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function updateItem($id, $data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                $item = self::getItemById($id);
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
                $item->user_id_update = app(User::class)->user_id();
                $item->user_name_update = app(User::class)->user_name();
                $item->update();
                if ($item->role_id > 0) {
                    $dataRoleMenu['role_id'] = $item->role_id;
                    $dataRoleMenu['role_name'] = $item->role_name;
                    $dataRoleMenu['role_status'] = $item->role_status;
                    $dataRoleMenu['role_order'] = $item->role_order;
                    $dataRoleMenu['role_code'] = $item->role_code;
                    app(RoleMenu::class)->updateDataWithRoleId($item->role_id, $dataRoleMenu);
                }
                self::removeCache($item->role_id, $item);
            }
            return true;
        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function getItemById($id)
    {
        if ($id <= 0) return false;
        $data = Memcache::getCache(Memcache::CACHE_ROLE_ID . $id);
        if (!$data) {
            $data = Role::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ROLE_ID . $id, $data);
            }
        }
        return $data;
    }

    public function deleteItem($id)
    {
        if ($id <= 0) return false;
        try {
            $item = $dataOld = self::getItemById($id);
            if ($item) {
                $item->delete();
            }
            self::removeCache($item->role_id, $dataOld);
            return true;
        } catch (PDOException $e) {
            throw new PDOException();
            return false;
        }
    }

    public function removeCache($id = 0, $data)
    {
        if ($id > 0) {
            Memcache::forgetCache(Memcache::CACHE_ROLE_ID . $id);
        }
        Memcache::forgetCache(Memcache::CACHE_OPTION_ROLE);
        Memcache::forgetCache(Memcache::CACHE_ROLE_ALL);
    }

    public static function getListAll()
    {
        $data = Memcache::getCache(Memcache::CACHE_ROLE_ALL);
        if (!$data) {
            $query = Role::where('role_id', '>', 0);
            $query->where('role_status', '=', STATUS_SHOW);
            $data = $query->orderBy('role_order', 'ASC')->get();
            if (!empty($data)) {
                Memcache::putCache(Memcache::CACHE_ROLE_ALL, $data);
            }
        }
        return $data;
    }

    public function getDataByArrayRoleId($arrRoleId = [])
    {
        if (!empty($arrRoleId)) {
            $query = Role::whereIn('role_id',$arrRoleId);
            $query->where('role_status', '=', STATUS_SHOW);
            $data = $query->orderBy('role_order', 'ASC')->get();
            return $data;
        }
        return false;
    }

    public function getOptionRole($project = 0)
    {
        $data = Memcache::getCache(Memcache::CACHE_OPTION_ROLE);
        if (!$data || empty($data)) {
            $arr = Role::getListAll();
            foreach ($arr as $value) {
                $data[$value->role_id] = $value->role_name;
            }
            if (!empty($data)) {
                Memcache::putCache(Memcache::CACHE_OPTION_ROLE, $data);
            }
        }
        return $data;
    }
}
