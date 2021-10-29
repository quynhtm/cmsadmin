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

            $query->orderBy('is_active', 'asc');
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
            }
            return true;
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function removeCache($id = STATUS_INT_KHONG, $data = [])
    {
        if ($id > STATUS_INT_KHONG) {
            Memcache::forgetCache(Memcache::CACHE_DEFINE_SYSTEM_ID.$id);
        }
    }

    public function getDataByType($define_type = STATUS_INT_KHONG)
    {
        if ($define_type == STATUS_INT_KHONG) return [];
        $data = false;
        if (!$data) {
            $data = DefineSystem::where('id', '>', STATUS_INT_KHONG)
                ->where('define_type', $define_type)
                ->orderBy('define_order', 'asc')->get();
            if ($data) {}
        }
        return $data;
    }

    public function getOptionNameByType($define_type = STATUS_INT_KHONG, $define_status = true)
    {
        if ($define_type == STATUS_INT_KHONG) return [];
        $arrOption = [];
        $data = self::getDataByType($define_type);
        if ($data || $data->count() > STATUS_INT_KHONG) {
            foreach ($data as $v) {
                if ($define_status && $v->define_status == STATUS_SHOW) {
                    $arrOption[$v->id] = $v->define_name;
                } else {
                    $arrOption[$v->id] = $v->define_name;
                }
            }
        }
        return $arrOption;
    }

    public function getOptionColorByType($define_type = STATUS_INT_KHONG, $define_status = true)
    {
        if ($define_type == STATUS_INT_KHONG) return [];
        $arrOption = [];
        $data = self::getDataByType($define_type);
        if ($data || $data->count() > STATUS_INT_KHONG) {
            foreach ($data as $v) {
                if ($define_status && $v->define_status == STATUS_SHOW) {
                    $arrOption[$v->id] = ['name'=>$v->define_name,'color'=>$v->define_color];
                } else {
                    $arrOption[$v->id] = ['name'=>$v->define_name,'color'=>$v->define_color];
                }
            }
        }
        return $arrOption;
    }

    public function getArrByType($define_type){
        $data = $this->getDataByType($define_type);
        $result = [];
        if($data->count() > STATUS_INT_KHONG){
            foreach($data as $item){
                $result[$item->id] = $item->define_name;
            }
        }
        return $result;
    }

    /**
     * @param $define_type
     * @param bool $define_status
     * @return array
     */
    public function getArrCodeByType($define_type,$define_status = true){
        $data = $this->getDataByType($define_type);
        $result = [];
        if($data->count() > STATUS_INT_KHONG){
            foreach($data as $item){
                if ($define_status && $item->define_status == STATUS_SHOW) {
                    $result[$item->define_code] = $item->define_name;
                }else{
                    $result[$item->define_code] = $item->define_name;
                }
            }
        }
        return $result;
    }
}
