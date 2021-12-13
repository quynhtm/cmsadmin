<?php

namespace App\Models\Web;

use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

class Reviews extends BaseModel
{
    protected $table = TABLE_REVIEWS_ITEM;
    protected $primaryKey = 'id';
    public $timestamps = true;

    const  typeReviewProduct = STATUS_INT_MOT;
    const  typeReviewNew = STATUS_INT_HAI;

    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = Reviews::where($this->primaryKey, '>', STATUS_INT_KHONG);
            if (isset($dataSearch['p_keyword']) && $dataSearch['p_keyword'] != '') {
                $str_like = trim($dataSearch['p_keyword']);
                $query->where('object_name', 'LIKE', '%' . $str_like . '%')
                    ->orWhere('assessor', 'LIKE', '%' . $str_like. '%');
            }
            if (isset($dataSearch['partner_id']) && $dataSearch['partner_id'] > STATUS_INT_KHONG) {
                $query->where('partner_id', $dataSearch['partner_id']);
            }
            if (isset($dataSearch['type_review']) && $dataSearch['type_review'] > STATUS_INT_KHONG) {
                $query->where('type_review', $dataSearch['type_review']);
            }
            if (isset($dataSearch['is_active']) && $dataSearch['is_active'] > STATUS_INT_AM_MOT) {
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
                $item = ($id <= STATUS_INT_KHONG)? new Reviews(): self::getItemById($id);
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
        $data = Memcache::getCache(Memcache::CACHE_REVIEWS_ID.$id);
        if (!$data) {
            $data = Reviews::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_REVIEWS_ID.$id,$data);
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
            Memcache::forgetCache(Memcache::CACHE_REVIEWS_ID.$id);
        }
    }
    /**************************************************************************************************************************/
}
