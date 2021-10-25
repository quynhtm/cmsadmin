<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 * Date: 6/24/14
 * Time: 11:32 PM
 * To change this template use File | Settings | File Templates.
 */
namespace App\Models\Admin;
use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;

use App\Library\AdminFunction\Memcache;

class Permission extends BaseModel{

    protected $table = TABLE_PERMISSION;
    public $timestamps = false;
    protected $primaryKey = 'permission_id';
    protected $fillable = array('permission_code','permission_name','permission_status','permission_group_name','permission_index');

    public function groupuser()
    {
        return $this->belongsToMany(TABLE_GROUP_USER, TABLE_GROUP_USER_PERMISSION);
    }

    public function createItem($data)
    {
        try {
            // tạo 1 quyen
            $fieldInput = $this->checkFieldInTable($data);
            DB::connection()->getPdo()->beginTransaction();
            $permission = new Permission();
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                foreach ($fieldInput as $k => $v) {
                    $permission->$k = $v;
                }
            }
            $permission->save();
            DB::connection()->getPdo()->commit();
            return $permission->permission_id;
        }  catch (PDOException $e) {
            //var_dump($e->getMessage());die;
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public function updateItem($id, $data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $permission = Permission::find($id);
            DB::connection()->getPdo()->beginTransaction();
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                foreach ($fieldInput as $k => $v) {
                    $permission->$k = $v;
                }
            }
            $permission->save();
            DB::connection()->getPdo()->commit();
            return true;
        }  catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public function getItemById($id)
    {
        if ($id <= 0) return false;
        $data = Memcache::getCache(Memcache::CACHE_PERMISSION_ID . $id);
        if (!$data) {
            $data = Permission::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_PERMISSION_ID . $id, $data);
            }
        }
        return $data;
    }

    public function removeCache($id = 0, $data)
    {
        if ($id > 0) {
            Memcache::forgetCache(Memcache::CACHE_PERMISSION_ID . $id);
        }
    }
    public static function getListGroupOfPermission($arr_id = array())
    {
        $data = array();
        if ($arr_id) {
            $permission = Permission::whereIn('permission_id', $arr_id)->get();
        } else {
            $permission = Permission::all();
        }
        foreach ($permission as $permit) {
            $permit->groupuser;
            $data[] = $permit;
        }
        return $data;
    }
    public static function getPermissionByCode($permission_code){
        $data = Permission::where('permission_code', $permission_code)->get();
        return $data;
    }

    public static function getListPermission()
    {
        return Permission::where('permission_status', '=', 1)->orderBy('permission_index','ASC')->get();
    }

    /**
     * Search permission data
     *
     * @param array $data
     * @param int $limit
     * @param int $offset
     * @param int $total
     */
    public static  function searchPermission($data, $limit = 1, $offset = 0, &$total) {
        $query = Permission::select('*');
        if(isset($data['permission_id'])) {
            $query->whereIn('permission_id', $data['permission_id']);
        }
        if(isset($data['permission_name'])) {
            $query->where('permission_name', 'LIKE', '%'.$data['permission_name'].'%');
        }
        if(isset($data['permission_code']) && $data['permission_code'] != '') {
            $query->where('permission_code', 'LIKE', '%'.$data['permission_code'].'%');
        }
        if(isset($data['permission_status']) && $data['permission_status'] != 0) {
            $query->where('permission_status', '=', $data['permission_status']);
        }
        if(isset($data['permission_group_name'])) {
            $query->where('permission_group_name', 'LIKE', '%'.$data['permission_group_name'].'%');
        }
        $total = $query->count();
        $query->orderBy('permission_group_name', 'asc');
        $query->orderBy('permission_id', 'desc');
        return $query->take($limit)->skip($offset)->get();
    }

    /**
     * checkExitsPermissionName
     *
     * @param $name
     * @param int $id
     * @return mixed
     */
    public static function checkExitsPermissionName($name, $id = 0){
        if($id == 0) {
            return Permission::where('permission_name', '=', $name)->first();
        }
        else {
            return Permission::where('permission_name', '=', $name)->where('permission_id', '!=', $id)->first();
        }
    }

    /**
     * checkExitsPermissionCode
     *
     * @param $name
     * @param int $id
     * @return mixed
     */
    public static function checkExitsPermissionCode($name, $id = 0){
        if($id == 0) {
            return Permission::where('permission_code', '=', $name)->first();
        }
        else {
            return Permission::where('permission_code', '=', $name)->where('permission_id', '!=', $id)->first();
        }
    }

    public static function deleteData($id){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Permission::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }
}
