<?php

namespace App\Models\Web;

use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

class Contact extends BaseModel
{
    protected $table = TABLE_CONTACT;
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = Contact::where($this->primaryKey, '>', STATUS_INT_KHONG);
            if (isset($dataSearch['contact_title']) && $dataSearch['contact_title'] != '') {
                $query->where('contact_title', 'LIKE', '%' . $dataSearch['contact_title'] . '%');
            }
            if (isset($dataSearch['partner_id']) && $dataSearch['partner_id'] > STATUS_INT_KHONG) {
                $query->where('partner_id', $dataSearch['partner_id']);
            }
            if (isset($dataSearch['contact_status']) && $dataSearch['is_active'] > STATUS_INT_AM_MOT) {
                $query->where('contact_status', $dataSearch['is_active']);
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
                $item = ($id <= STATUS_INT_KHONG)? new Contact(): self::getItemById($id);
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
        $data = Memcache::getCache(Memcache::CACHE_CONTACT_ID.$id);
        if (!$data) {
            $data = Contact::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_CONTACT_ID.$id,$data);
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
            Memcache::forgetCache(Memcache::CACHE_CONTACT_ID.$id);
        }
    }
    /**************************************************************************************************************************/
}
