<?php
/**
 * QuynhTM
 */

namespace App\Http\Models\Admin;

use App\Http\Models\BaseModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Library\AdminFunction\Memcache;

class Province extends BaseModel
{
    protected $table = TABLE_PROVINCE;
    protected $primaryKey = 'province_id';
    public $timestamps = false;

    public function searchByCondition($dataSearch = array(), $limit = 0, $offset = 0, $is_total = true)
    {
        try {
            $query = self::where($this->primaryKey, '>', 0);
            if (isset($dataSearch['province_name']) && $dataSearch['province_name'] != '') {
                $query->where('province_name', 'LIKE', '%' . $dataSearch['province_name'] . '%');
            }
            if (isset($dataSearch['province_status']) && $dataSearch['province_status'] > -1) {
                $query->where('province_status', $dataSearch['province_status']);
            }
            $total = ($is_total) ? $query->count() : 0;
            $query->orderBy($this->primaryKey, 'desc');

            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            if (!empty($fields)) {
                $result = $query->take($limit)->skip($offset)->get($fields);
            } else {
                $result = $query->take($limit)->skip($offset)->get();
            }
            return ['data'=>$result,'total'=>$total];

        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function createItem($data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $item = new Province();
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
            }
            $item->save();
            self::removeCache($item->province_id, $item);
            return $item->province_id;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function updateItem($id, $data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $item = self::getItemById($id);
            foreach ($fieldInput as $k => $v) {
                $item->$k = $v;
            }
            $item->update();
            self::removeCache($item->province_id, $item);
            return true;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function getItemById($id)
    {
        if ($id <= 0) return false;
        $data = Memcache::getCache(Memcache::CACHE_PROVINCE_ID . $id);
        if (!$data) {
            $data = self::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_PROVINCE_ID . $id, $data);
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
                self::removeCache($id, $dataOld);
            }
            return true;
        } catch (PDOException $e) {
            throw new PDOException();
            return false;
        }
    }
    public function removeCache($id = 0, $data)
    {
        if ($id > 0) {
            Memcache::forgetCache(Memcache::CACHE_PROVINCE_ID . $id);
            Memcache::forgetCache(Memcache::CACHE_OPTION_PROVINCE);
        }
        if($data){

        }
    }

    public function getOptionProvince(){
        $data = Memcache::getCache(Memcache::CACHE_OPTION_PROVINCE);
        if (!$data) {
            $province = Province::where('province_status', STATUS_INT_MOT)->orderBy('province_position', 'asc')->get();
            if ($province) {
                foreach ($province as $pro){
                    $data[$pro->province_id] = $pro->province_name;
                }
                Memcache::putCache(Memcache::CACHE_OPTION_PROVINCE, $data);
            }
        }
        return $data;
    }

}
