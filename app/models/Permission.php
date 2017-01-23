<?php
/**
 * Created by JetBrains PhpStorm.
 * User: TuanNguyenAnh
 * Date: 6/24/14
 * Time: 11:32 PM
 * To change this template use File | Settings | File Templates.
 */
class Permission extends Eloquent{

    protected $table = 'cms_permission';

    public $timestamps = false;

    protected $primaryKey = 'permission_id';

    protected $fillable = array('permission_code','permission_name','permission_status','permission_group_name');

    public function groupuser()
    {
        return $this->belongsToMany('GroupUser', 'group_user_permission');
    }


    public static function createPermission($data)
    {
        try {
            // tạo 1 quyen
            $permission = new Permission();
            DB::connection()->getPdo()->beginTransaction();
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $k => $v) {
                    $permission->$k = $v;
                }
            }
            $permission->save();

            // tạo môi quan hê nhóm quyên
            if ($permission->permission_id == 1) {
                $dataEx = array();
                $permission_id = $permission->permission_id;
                $dataEx['group_user_id'] = 1;
                $dataEx['permission_id'] = $permission_id;
                DB::table('group_user_permission')->insert($dataEx);

                $dataEx2['group_user_id'] = 1;
                $dataEx2['group_user_name'] = $permission->permission_name;
                $dataEx2['group_user_status'] = 1;
                $dataEx2['group_user_type'] = 1;
                DB::table('group_user')->insert($dataEx2);
            }

            DB::connection()->getPdo()->commit();

            return $permission->permission_id;
        } catch (\PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }

    }

    public static function updatePermission($id, $data,  $arr_group = array())
    {
        try {
            // sua nhóm
            $permission = Permission::find($id);

            DB::connection()->getPdo()->beginTransaction();
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $k => $v) {
                    $permission->$k = $v;
                }
            }
            $permission->save();
            // tạo môi quan hê nhóm quyên

            if (is_array($arr_group)) {
                DB::table('group_user_permission')->where('permission_id', $id)->delete();
                $dataEx = array();
                $permission_id = $permission->permission_id;
                if(count($arr_group) > 0){
                    foreach ($arr_group as $k => $group) {
                        $dataEx[$k]['group_user_id'] = $group;
                        $dataEx[$k]['permission_id'] = $permission_id;
                    }
                    DB::table('group_user_permission')->insert($dataEx);
                }
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (\PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
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
        return Permission::where('permission_status', '=', 1)->get();
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