<?php

namespace App\Models\BackendCms;

use App\Library\AdminFunction\CGlobal;
use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

class PermissionGroup extends BaseModel
{
    protected $table = TABLE_PERMISSION_GROUP;
    protected $primaryKey = 'group_id';
    public $timestamps = true;

    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = PermissionGroup::where($this->primaryKey, '>', STATUS_INT_KHONG);
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
                $item = ($id <= STATUS_INT_KHONG)? new PermissionGroup(): self::getItemById($id);
                if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                    foreach ($fieldInput as $k => $v) {
                        $item->$k = $v;
                    }
                }
                if($id <= STATUS_INT_KHONG){
                    $item->created_id = $this->getUserId();
                    $item->created_name = $this->getUserName();
                    $item->save();
                    $id = $item->group_id;
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
        $data = Memcache::getCache(Memcache::CACHE_PERMISSION_GROUP_ID.$id);
        if (!$data) {
            $data = PermissionGroup::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_PERMISSION_GROUP_ID.$id, $data);
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
            Memcache::forgetCache(Memcache::CACHE_PERMISSION_GROUP_ID.$id);
        }
        if($data){

        }
        Memcache::forgetCache(Memcache::CACHE_PERMISSION_GROUP_ALL);
    }

    //get perrin detail
    public function buildInforPermGroup($arrMenu = [],$arrPermiss = [],$arrInput = []){
        if(empty($arrMenu) || empty($arrPermiss) || empty($arrInput)  )
            return [];
        $arrInforPermiss = [];
        foreach ($arrPermiss as $permiss_code => $permiss_name){
            if(isset($arrInput[$permiss_code.'['])){
                $arrPermissInput = $arrInput[$permiss_code.'['];
                $arrTempMenu = [];
                foreach ($arrPermissInput as $obj_id => $obj_val){
                    if(isset($arrMenu[$obj_id])){
                        $arrTempMenu[] = $obj_id;
                    }
                }
                $arrInforPermiss[$permiss_code] = $arrTempMenu;
            }
        }
        return $arrInforPermiss;
    }
    public function getDataAll(){
        $data = Memcache::getCache(Memcache::CACHE_PERMISSION_GROUP_ALL);
        if (!$data) {
            $data = PermissionGroup::where('group_id', '>', STATUS_INT_KHONG)
                ->where('is_active', STATUS_SHOW)
                ->orderBy('sort_order', 'asc')->orderBy('group_id', 'asc')->get(['group_id','group_name','description','sort_order','is_active']);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_PERMISSION_GROUP_ALL, $data);
            }
        }
        return $data;
    }
}
