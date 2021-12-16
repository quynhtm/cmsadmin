<?php

namespace App\Models\BackendCms;

use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

class DefineSystem extends BaseModel
{
    protected $table = TABLE_DEFINE_SYSTEM;
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = DefineSystem::where($this->primaryKey, '>', STATUS_INT_KHONG);
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
            $query->orderBy('define_code', 'asc');
            $query->orderBy('sort_order', 'asc');


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
                $item = ($id <= STATUS_INT_KHONG)? new DefineSystem(): self::getItemById($id);
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
            $data = DefineSystem::find($id);
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

    public function getOptionTypeDefine($define_code = '', $project_code = DEFINE_ALL, $language = DEFINE_LANGUAGE_VN)
    {
        if (trim($define_code) == '') return [];
        $key_memcache = Memcache::CACHE_DEFINE_BY_DEFINE_CODE.$define_code.'_'.$project_code;
        $option = Memcache::getCache($key_memcache);
        if (!$option) {
            $dataSearch = DefineSystem::where($this->primaryKey, '>', STATUS_INT_KHONG)
                ->where('project_code', $project_code)
                ->where('define_code', $define_code)
                ->where('is_active', STATUS_INT_MOT)
                ->orderBy('sort_order', 'asc')->get();
            if ($dataSearch) {
                foreach ($dataSearch as $k => $val) {
                    if($language == $val->language || $language == ''){
                        $option[$val->type_code] = $val->type_name;
                    }
                }
                if(!empty($option)){
                    Memcache::putCache($key_memcache, $option);
                }
            }
        }
        return $option;
    }
}
