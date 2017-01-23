<?php
/**
 * Created by JetBrains PhpStorm.
 * User: TuanNguyenAnh
 * Date: 6/21/14
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */
class GroupUser extends Eloquent
{

    protected $table = 'cms_group_user';

    public $timestamps = false;

    protected $primaryKey = 'group_user_id';

    protected $fillable = array('group_user_name','group_user_status');

    public function permission()
    {
        return $this->belongsToMany('Permission', 'group_user_permission', 'group_user_id', 'permission_id');
    }

    public static function createGroup($data, $arr_permission = array())
    {
        try {
            // tạo 1 nhóm
            $group_user = new GroupUser();
            DB::connection()->getPdo()->beginTransaction();
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $k => $v) {
                    $group_user->$k = $v;
                }
            }
            $group_user->save();
            // tạo môi quan hê nhóm quyên
            if (is_array($arr_permission) && count($arr_permission) > 0) {
                $group_user_id = $group_user->group_user_id;
                $i = 0;
                foreach ($arr_permission as  $permission) {
                    $dataEx[$i]['group_user_id'] = $group_user_id;
                    $dataEx[$i]['permission_id'] = $permission;
                    $i++;
                }
                if(!empty($dataEx)) {
                    GroupUserPermission::insert($dataEx);
                }
            }
            DB::connection()->getPdo()->commit();

            return $group_user->group_user_id;
        } catch (\PDOException $e) {

            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }

    }

    public static function updateGroup($id, $data, $arr_permission = array())
    {
        try {
            // sua nhóm
            $group_user = GroupUser::find($id);
            DB::connection()->getPdo()->beginTransaction();
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $k => $v) {
                    $group_user->$k = $v;
                }
                $group_user->save();
            }

            // tạo môi quan hê nhóm quyên
            if (is_array($arr_permission)) {
                DB::table('group_user_permission')->where('group_user_id', $id)->delete();
                $dataEx = array();
                $group_user_id = $group_user->group_user_id;
                if(count($arr_permission) > 0){
                    $i = 0;
                    foreach ($arr_permission as $k => $permission) {
                        $dataEx[$i]['group_user_id'] = $group_user_id;
                        $dataEx[$i]['permission_id'] = $permission;
                        $i++;
                    }
                    if(!empty($dataEx)) {
                        GroupUserPermission::insert($dataEx);
                    }
                }
            }

            DB::connection()->getPdo()->commit();
            return true;
        } catch (\PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }


    /**
     * Check group name
     *
     * @param $name
     * @param int $id
     * @return mixed
     */
    public static function checkExitsGroupName($name, $id = 0){
        if($id == 0) {
            return GroupUser::where('group_user_name', '=', $name)->first();
        }
        else {
            return GroupUser::where('group_user_name', '=', $name)->where('group_user_id', '!=', $id)->first();
        }
    }

    public static function getListPermissionOfGroup($arr_id = array())
    {
        $data = array();
        if ($arr_id) {
            $group_user = GroupUser::whereIn('group_user_id', $arr_id)->get();
        } else {
            $group_user = GroupUser::all();
        }
        foreach ($group_user as $group) {
            $group->permission;
            $data[] = $group;
        }
        return $data;
    }

    public static function getListGroupUser($is_boos = true){
        if($is_boos){
            return GroupUser::where('group_user_status', '=', 1)->lists('group_user_name','group_user_id');
        }else{
            return GroupUser::where('group_user_id', '>', 1)->where('group_user_status', '=', 1)->lists('group_user_name','group_user_id');
        }
    }


    /**
     * Search group data user
     *
     * @param array $data
     * @param int $limit
     * @param int $offset
     * @param int $total
     */
    public static function searchGroupUser($data, $limit = 1, $offset = 0, &$total) {
        $query = GroupUser::select('*');
        if(isset($data['group_user_id'])) {
            $query->whereIn('group_user_id', $data['group_user_id']);
        }
        if(isset($data['group_user_name']) && $data['group_user_name'] != '') {
            $query->where('group_user_name', 'LIKE', '%'.$data['group_user_name'].'%');
        }
        if(isset($data['group_user_status']) && $data['group_user_status'] != 0) {
            $query->where('group_user_status', '=', $data['group_user_status']);
        }
        $total = $query->count();
        $query->orderBy('group_user_id', 'desc');
        return $query->take($limit)->skip($offset)->get();
    }

}