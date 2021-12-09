<?php

namespace App\Models\Web;

use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

class Partner extends BaseModel
{
    protected $table = TABLE_PARTNER;
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = Partner::where($this->primaryKey, '>', STATUS_INT_KHONG);
            if (isset($dataSearch['partner_name']) && $dataSearch['partner_name'] != '') {
                $query->where('partner_name', 'LIKE', '%' . $dataSearch['partner_name'] . '%');
            }
            if (isset($dataSearch['is_active']) && $dataSearch['is_active'] > STATUS_INT_AM_MOT) {
                $query->where('is_active', $dataSearch['is_active']);
            }
            $total = ($is_total) ? $query->count() : STATUS_INT_KHONG;

            $query->orderBy('partner_order', 'asc');

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
                $item = ($id <= STATUS_INT_KHONG)? new Partner(): self::getItemById($id);
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
        $data = Memcache::getCache(Memcache::CACHE_PARTNER_ID.$id);
        if (!$data) {
            $data = Partner::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_PARTNER_ID.$id,$data);
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
            Memcache::forgetCache(Memcache::CACHE_PARTNER_ID.$id);

        }
        Memcache::forgetCache(Memcache::CACHE_ALL_PARTNER);
        if($data){}
    }
    /**************************************************************************************************************************/
    public function getAllPartner(){
        $key_memcache = Memcache::CACHE_ALL_PARTNER;
        $data = Memcache::getCache($key_memcache);
        if (!$data) {
            $data = Partner::where($this->primaryKey, '>', STATUS_INT_KHONG)
                ->where('is_active', STATUS_INT_MOT)
                ->orderBy('partner_order', 'asc')->get();
            if($data){
                Memcache::putCache($key_memcache, $data);
            }
        }
        return $data;
    }
    public function getOptionPartner()
    {
        $option = [];
        $dataAll = self::getAllPartner();
        if ($dataAll) {
            foreach ($dataAll as $k => $val) {
                $option[$val->id] = $val->partner_name;
            }
        }
        return $option;
    }
}
