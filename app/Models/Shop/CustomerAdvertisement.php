<?php

namespace App\Models\Shop;

use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

class CustomerAdvertisement extends BaseModel
{
    protected $table = TABLE_CUSTOMER_ADVERTISEMENT;
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = CustomerAdvertisement::where($this->primaryKey, '>', STATUS_INT_KHONG);
            if (isset($dataSearch['p_keyword']) && $dataSearch['p_keyword'] != '') {
                $str_like = trim($dataSearch['p_keyword']);

                $query->where(function ($query) use ($str_like) {
                    $query->where('customer_alias', 'LIKE', '%' . $str_like . '%')
                        ->orWhere('customer_phone', 'LIKE', '%' . $str_like. '%')
                        ->orWhere('customer_full_name', 'LIKE', '%' . $str_like. '%');
                });
            }
            if (isset($dataSearch['is_active']) && $dataSearch['is_active'] > STATUS_INT_AM_MOT) {
                $query->where('is_active', $dataSearch['is_active']);
            }
            if (isset($dataSearch['customer_city_id']) && $dataSearch['customer_city_id'] > STATUS_INT_AM_MOT) {
                $query->where('customer_city_id', $dataSearch['customer_city_id']);
            }

            $total = ($is_total) ? $query->count() : STATUS_INT_KHONG;
            $query->orderBy($this->primaryKey, 'desc');
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
                $item = ($id <= STATUS_INT_KHONG)? new CustomerAdvertisement(): self::getItemById($id);
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
        //$data = Memcache::getCache(Memcache::CACHE_PARTNER_REGISTRATION_ID.$id);
        $data = false;
        if (!$data) {
            $data = CustomerAdvertisement::find($id);
            if ($data) {
                //Memcache::putCache(Memcache::CACHE_PARTNER_REGISTRATION_ID.$id,$data);
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
            //Memcache::forgetCache(Memcache::CACHE_PARTNER_REGISTRATION_ID.$id);
        }
    }
    /**************************************************************************************************************************/
    public function updateStatusByArrId($arrId = [], $status = STATUS_INT_MOT)
    {
        if (!empty($arrId)) {
            $updated_id = $this->getUserId();
            $updated_name = $this->getUserName();
            $update = self::whereIn($this->primaryKey, $arrId)
                ->update(['is_active' => $status, 'updated_id' => $updated_id, 'updated_name' => $updated_name]);

            return $update;
        }
        return false;
    }
    public function getDataEmailByArrId($arrId = [])
    {
        if (!empty($arrId)) {
            $data = self::whereIn($this->primaryKey, $arrId)->where('is_active',STATUS_INT_MOT)->get([$this->primaryKey,'customer_master_email']);
            return $data;
        }
        return false;
    }
}
