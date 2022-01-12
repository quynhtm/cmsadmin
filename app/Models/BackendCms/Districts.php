<?php

namespace App\Models\BackendCms;

use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

class Districts extends BaseModel
{
    protected $table = TABLE_DISTRICTS;
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = Districts::where($this->primaryKey, '>', STATUS_INT_KHONG);
            if (isset($dataSearch['define_name']) && $dataSearch['define_name'] != '') {
                $query->where('define_name', 'LIKE', '%' . $dataSearch['define_name'] . '%');
            }
            if (isset($dataSearch['define_code']) && $dataSearch['define_code'] != '') {
                $query->where('define_code', $dataSearch['define_code']);
            }
            $total = ($is_total) ? $query->count() : STATUS_INT_KHONG;
            $query->orderBy('position', 'asc');
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
                $item = ($id <= STATUS_INT_KHONG)? new Districts(): self::getItemById($id);
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
        //$data = Memcache::getCache(Memcache::CACHE_DEFINE_SYSTEM_ID.$id);
        $data = false;
        if (!$data) {
            $data = Districts::find($id);
            if ($data) {
                //Memcache::putCache(Memcache::CACHE_DEFINE_SYSTEM_ID.$id, $data);
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
            //Memcache::forgetCache(Memcache::CACHE_DEFINE_SYSTEM_ID.$id);
        }
        Memcache::forgetCache(Memcache::CACHE_DISTRICT_ALL);
        if($data){}
    }

    /********************************************************************************************************************************************************************************/
    public function getDataAll(){
        $data = Memcache::getCache(Memcache::CACHE_DISTRICT_ALL);
        if (!$data) {
            $data = self::where($this->primaryKey, '>', STATUS_INT_KHONG)
                ->orderBy('position', 'asc')
                ->get([$this->primaryKey,'title','status']);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_DISTRICT_ALL, $data);
            }
        }
        return $data;
    }
    public function getOptionDistrict($province_id = 0)
    {
        $option = [];
        $dataAll = self::getDataAll();
        if (isset($dataAll) && !empty($dataAll)) {
            foreach ($dataAll as $k => $val) {
                if($province_id == 0){
                    $option[$val->id] = $val->title;
                }elseif ($province_id == $val->city_id){
                    $option[$val->id] = $val->title;
                }
            }
        }
        return $option;
    }

}
