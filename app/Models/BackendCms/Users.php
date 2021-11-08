<?php

namespace App\Models\BackendCms;

use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

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
                $item = ($id <= STATUS_INT_KHONG)? new Users(): self::getItemById($id);
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
        $data = Memcache::getCache(Memcache::CACHE_DEFINE_SYSTEM_ID.$id);
        if (!$data) {
            $data = Users::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_DEFINE_SYSTEM_ID.$id, $data);
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
            Memcache::forgetCache(Memcache::CACHE_DEFINE_SYSTEM_ID.$id);
        }
        if($data){
            Memcache::forgetCache(Memcache::CACHE_DEFINE_BY_DEFINE_CODE.$data->define_code.'_'.$data->project_code);
        }
    }

}
