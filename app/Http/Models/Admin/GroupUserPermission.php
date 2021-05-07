<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 * Date: 6/21/14
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */
namespace App\Http\Models\Admin;
use App\Http\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;
use App\Library\AdminFunction\Memcache;
use Illuminate\Support\Facades\DB;
use App\Library\AdminFunction\Define;

class GroupUserPermission extends BaseModel
{
    protected $table = TABLE_GROUP_USER_PERMISSION;

    public $timestamps = false;

    protected $primaryKey = 'group_user_permission_id';

    protected $fillable = array('group_user_id', 'permission_id');


    /**
     * Get list permission by group id
     *
     * @param $aryGroupId
     * @return mixed
     */
    public static function getListPermissionByGroupId($aryGroupId)
    {

        $tbl_permission = with(new Permission())->getTable();
        $tbl_group_user_permission = with(new GroupUserPermission())->getTable();
        $query = DB::table($tbl_group_user_permission);
        $query->join($tbl_permission, function ($join) use ($tbl_permission, $tbl_group_user_permission) {
            $join->on($tbl_group_user_permission . '.permission_id', '=', $tbl_permission . '.permission_id');
        });
        $query->where($tbl_permission . '.permission_status', '=', 1);
        $query->whereIn($tbl_group_user_permission . '.group_user_id', $aryGroupId);
        $query->select($tbl_group_user_permission . '.group_user_id', $tbl_permission . '.*');
        return $query->get();
    }

    /**
     * Get list Group by permission
     *
     * @param $aryPermissionId
     * @return mixed
     */
    public static function getListGroupByPermissionId($aryPermissionId)
    {
        $tbl_group = with(new GroupUser())->getTable();
        $tbl_group_user_permission = with(new GroupUserPermission())->getTable();
        $query = DB::table($tbl_group_user_permission);
        $query->join($tbl_group, function ($join) use ($tbl_group, $tbl_group_user_permission) {
            $join->on($tbl_group_user_permission . '.group_user_id', '=', $tbl_group . '.group_user_id');
        });
        $query->where($tbl_group . '.group_user_status', '=', 1);
        $query->whereIn($tbl_group_user_permission . '.permission_id', $aryPermissionId);
        $query->select($tbl_group_user_permission . '.permission_id', $tbl_group . '.*');
        return $query->get();
    }
}