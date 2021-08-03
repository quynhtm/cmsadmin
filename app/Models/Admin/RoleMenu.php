<?php

namespace App\Models\Admin;
use App\Http\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

class RoleMenu extends BaseModel
{
    protected $table = TABLE_ROLE_MENU;
    protected $primaryKey = 'role_menu_id';
    public $timestamps = false;

    public function searchByCondition($dataSearch = array(), $limit =0, $offset=0, $is_total = true){
        try{
            $query = RoleMenu::where('role_menu_id','>',0);
            if (isset($dataSearch['role_name']) && $dataSearch['role_name'] != '') {
                $query->where('role_name','LIKE', '%' . $dataSearch['role_name'] . '%');
            }

            $total = ($is_total)? $query->count(): STATUS_INT_KHONG;
            $query->orderBy('role_status', 'desc');
            $query->orderBy('role_order', 'asc');

            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
            if(!empty($fields)){
                $result = $query->take($limit)->skip($offset)->get($fields);
            }else{
                $result = $query->take($limit)->skip($offset)->get();
            }

            return ['data' => $result, 'total' => $total];
        }catch (\PDOException $e){
            throw new \PDOException();
        }
    }

    public function getInfoByRoleId($role_id){
        $infor = RoleMenu::where('role_id', $role_id)->first();
        return $infor;
    }

    public function createItem($data){
        try {
            $fieldInput = $this->checkFieldInTable($data);
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                $item = new RoleMenu();
                if (is_array($fieldInput) && count($fieldInput) > 0) {
                    foreach ($fieldInput as $k => $v) {
                        $item->$k = $v;
                    }
                }
                $item->user_id_creater = app(User::class)->user_id();
                $item->user_name_creater = app(User::class)->user_name();
                $item->save();
                self::removeCache($item->role_menu_id, $item);
                return $item->role_menu_id;
            }
            return 0;
        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function updateItem($id,$data){
        try {
            $fieldInput = $this->checkFieldInTable($data);
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                $item = self::getItemById($id);
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
                $item->user_id_update = app(User::class)->user_id();
                $item->user_name_update = app(User::class)->user_name();
                $item->update();
                User::updateUserPermissionWithRole($item);
                self::removeCache($item->role_menu_id, $item);
            }
            return true;
        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function getItemById($id)
    {
        if ($id <= 0) return false;
        $data = Memcache::getCache(Memcache::CACHE_ROLE_MENU_ID . $id);
        if (!$data) {
            $data = RoleMenu::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ROLE_MENU_ID . $id, $data);
            }
        }
        return $data;
    }

    public function getDataByMenuId($role_id){
        return RoleMenu::where('role_id',$role_id)->first();
    }

    public function updateDataWithRoleId($role_id, $dataUpdate){
        if($role_id > 0){
            $fieldInput = $this->checkFieldInTable($dataUpdate);
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                $item = self::getInfoByRoleId($role_id);
                if ($item) {
                    foreach ($fieldInput as $k => $v) {
                        $item->$k = $v;
                    }
                    $item->user_id_update = app(User::class)->user_id();
                    $item->user_name_update = app(User::class)->user_name();
                    $item->update();
                    self::removeCache($item->role_menu_id, $item);
                }
            }
            return true;
        }
    }

    public function deleteItem($id){
        if($id <= 0) return false;
        try {
            $item = $dataOld = self::getItemById($id);
            if($item){
                $item->delete();
            }
            self::removeCache($item->role_menu_id,$dataOld);
            return true;
        } catch (\PDOException $e) {
            throw new \PDOException();
            return false;
        }
    }

    public static function removeCache($id = 0,$data){
        if($id > 0){
            Memcache::forgetCache(Memcache::CACHE_ROLE_MENU_ID . $id);
        }
    }
}
