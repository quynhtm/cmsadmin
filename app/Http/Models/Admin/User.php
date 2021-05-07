<?php

namespace App\Http\Models\Admin;

use App\Http\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Memcache;


class User extends BaseModel
{
    protected $table = TABLE_USER_ADMIN;
    protected $primaryKey = 'user_id';
   //public $timestamps = false;

    /*public function userCustomer(){
        return $this->hasOne(Customer::class,'user_id');
    }*/
    public function searchByCondition($data = array(), $limit = STATUS_INT_KHONG, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = User::where('user_id', '>', STATUS_INT_KHONG);

            if (isset($data['user_view']) && $data['user_view'] == STATUS_DEFAULT) {
                $query->whereIn('user_view', array(STATUS_INT_KHONG, STATUS_INT_MOT));
            }else{
                $query->whereIn('user_view', array(STATUS_INT_MOT));
            }
            if (isset($data['user_id'])) {
                if (!empty($data['user_id'])) {
                    $query->whereIn('user_id', $data['user_id']);
                } else {
                    $query->where('user_id', $data['user_id']);
                }
            }
            if (isset($data['user_name']) && $data['user_name'] != '') {
                $query->where('user_name', 'LIKE', '%' . $data['user_name'] . '%');
            }
            if (isset($data['user_phone']) && $data['user_phone'] != '') {
                $query->where('user_phone', 'LIKE', '%' . $data['user_phone'] . '%');
            }
            if (isset($data['user_email']) && $data['user_email'] != '') {
                $query->where('user_email', 'LIKE', '%' . $data['user_email'] . '%');
            }
            if (isset($data['user_full_name']) && $data['user_full_name'] != '') {
                $query->where('user_full_name', 'LIKE', '%' . $data['user_full_name'] . '%');
            }
            if (isset($data['user_status']) && $data['user_status'] != STATUS_INT_KHONG) {
                $query->where('user_status', $data['user_status']);
            }
            if (isset($data['position']) && $data['position'] > STATUS_INT_KHONG) {
                $query->where('position', $data['position']);
            }
            if (isset($data['auto_loan']) && $data['auto_loan'] != STATUS_DEFAULT) {
                $query->where('auto_loan', $data['auto_loan']);
            }
            if (isset($data['user_group']) && $data['user_group'] > STATUS_INT_KHONG) {
                $query->whereRaw('FIND_IN_SET(' . $data['user_group'] . ',' . 'user_group)');
            }
            if (isset($data['role_type']) && $data['role_type'] > STATUS_INT_KHONG) {
                $query->whereRaw('FIND_IN_SET(' . $data['role_type'] . ',' . 'role_type)');
            }
            //tìm theo user quản lý các NV của họ
            if (isset($data['managerEmployee']) && $data['managerEmployee'] > STATUS_INT_KHONG) {
                $query->where('user_manager_id', $data['managerEmployee']);
            }
            $total = ($is_total)? $query->count(): STATUS_INT_KHONG;
            $result = $query->orderBy('user_status', 'desc')
                ->orderBy('user_last_login', 'desc')
                ->orderBy('user_last_logout', 'desc')
                ->orderBy('user_id', 'desc')->take($limit)->skip($offset)->get();

            return ['data' => $result, 'total' => $total];
        } catch (\PDOException $e) {
            throw new \PDOException();
            return null;
        }
    }

    public function createNew($data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                $item = new User();
                if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                    foreach ($fieldInput as $k => $v) {
                        $item->$k = $v;
                    }
                }
                $item->user_password = self::encode_password($item->user_password);
                /*$item->user_id_creater = app(User::class)->user_id();
                $item->user_name_creater = app(User::class)->user_name();
                $item->created_at = getCurrentFull();*/
                $item->save();
                self::removeCache($item->user_id, $item);
                return $item->user_id;
            }
            return STATUS_INT_KHONG;

        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function updateUser($id, $data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                $item = $dataOld = self::getUserById($id);
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
                $item->user_id_update = app(User::class)->user_id();
                $item->user_name_update = app(User::class)->user_name();
                $item->updated_at = getCurrentFull();
                $item->update();
                self::removeCache($item->user_id, $item, $dataOld);
            }
            return true;
        } catch (\PDOException $e) {
            return $e->getMessage();
            throw new \PDOException($e->getMessage());
        }
    }

    public function getUserFull($user_id) {
        return false;
        $data = Memcache::getCache(Memcache::CACHE_FULL_USER_ID . $user_id);
        if (!$data) {
            $query = User::where(TABLE_USER_ADMIN.'.user_id',$user_id)->first();
            $query->join(TABLE_CUSTOMER, TABLE_CUSTOMER.'.user_id', '=', TABLE_USER_ADMIN.'.user_id');
            $data =  $query->first();
            if($data){
                Memcache::putCache(Memcache::CACHE_FULL_USER_ID . $user_id, $data);
            }
        }
        return $data;
    }
    /**
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        $data = Memcache::getCache(Memcache::CACHE_USER_ADMIN_ID . $id);
        if (!$data) {
            $data = User::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_USER_ADMIN_ID . $id, $data);
            }
        }
        return $data;
    }

    public function deleteItem($id)
    {
        if ($id <= STATUS_INT_KHONG) return false;
        try {
            $item = $dataOld = self::getUserById($id);;
            if ($item) {
                $item->delete();
                self::removeCache($item->user_id, $dataOld);
            }
            return true;
        } catch (\PDOException $e) {
            throw new \PDOException();
            return false;
        }
    }

    public function removeCache($id = STATUS_INT_KHONG, $dataOld, $dataNew = false)
    {
        if ($id > STATUS_INT_KHONG) {
            Memcache::forgetCache(Memcache::CACHE_USER_ADMIN_ID . $id);
        }
        Memcache::forgetCache(Memcache::CACHE_OPTION_USER);
        Memcache::forgetCache(Memcache::CACHE_INFO_USER);
        Memcache::forgetCache(Memcache::CACHE_ALL_USER_ADMIN);
        if($dataOld){
            Memcache::forgetCache(Memcache::CACHE_USER_BY_MANAGER.$dataOld->user_manager_id);
            Memcache::forgetCache(Memcache::CACHE_USER_BY_DEPART.$dataOld->user_depart_id.$dataOld->position);
            Memcache::forgetCache(Memcache::CACHE_USER_BY_DEPART_ONE.$dataOld->user_depart_id);
            Memcache::forgetCache(Memcache::CACHE_FULL_USER_ID.$dataOld->user_id);
        }
        if($dataNew){
            Memcache::forgetCache(Memcache::CACHE_USER_BY_MANAGER.$dataNew->user_manager_id);
            Memcache::forgetCache(Memcache::CACHE_USER_BY_DEPART.$dataNew->user_depart_id.$dataNew->position);
            Memcache::forgetCache(Memcache::CACHE_USER_BY_DEPART_ONE.$dataNew->user_depart_id);
            Memcache::forgetCache(Memcache::CACHE_FULL_USER_ID.$dataNew->user_id);
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getUserByName($name)
    {
        return User::where('user_name', $name)->first();
    }
    //user test
    public function getUserByNameByCacheFile($name)
    {
        $data = Memcache::getCache('user_login_by_file');
        if (!$data) {
            $data = User::where('user_name', $name)->first();
            if (!empty($data)) {
                Memcache::putCache('user_login_by_file', $data);
            }
        }
        return $data;
    }

    /**
     * @param $user_email
     * @return User|Model|null
     */
    public function getUserByEmail($user_email)
    {
        return User::where('user_email', $user_email)->first();
    }

    public static function updateUserPermissionWithRole($role)
    {
        if ($role) {
            $arrListUser = User::where('role_type', $role->role_id)->get();
            if ($arrListUser) {
                foreach ($arrListUser as $user) {
                    $dataUpdate['user_group'] = (isset($role->role_group_permission) && trim($role->role_group_permission) != '' && $role->role_status == Define::STATUS_SHOW) ? $role->role_group_permission : '';
                    $dataUpdate['user_group_menu'] = (isset($role->role_group_menu_id) && trim($role->role_group_menu_id) != '' && $role->role_status == Define::STATUS_SHOW) ? $role->role_group_menu_id : '';
                    $dataUpdate['role_type'] = $role->role_id;
                    $dataUpdate['role_name'] = $role->role_name;
                    $dataUpdate['role_code'] = $role->role_code;
                    app(User::class)->updateUser($user->user_id, $dataUpdate);
                }
            }
        }
    }

    public function getAllUser()
    {
        $data = Memcache::getCache(Memcache::CACHE_ALL_USER_ADMIN);
        if (!$data) {
            $data = User::where('user_id', '>',STATUS_INT_KHONG)->get();
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ALL_USER_ADMIN, $data);
            }
        }
        return $data;
    }

    public function getOptionUserManager(){
        $listUserActive = self::getAllUser();
        $data = [];
        if($listUserActive){
            foreach ($listUserActive as $u){
                if($u->user_status == STATUS_INT_MOT && $u->user_is_manager == STATUS_INT_MOT){
                    $data[$u->user_id] = (trim($u->user_full_name) != '')? $u->user_full_name: $u->user_email;
                }
            }
        }
        return $data;
    }

    /**
     * QuynhTM: lấy user có hoạt động hay không
     * @param bool $action
     * @return array
     */
    public function getOptionAllUser($action = true)
    {
        $listUserActive = self::getAllUser();
        $data = [];
        if($listUserActive){
            foreach ($listUserActive as $u){
                if($u->user_status == STATUS_INT_MOT && $action){
                    $data[$u->user_id] = (trim($u->user_name) != '')? $u->user_name: $u->user_email;
                }else{
                    $data[$u->user_id] = (trim($u->user_name) != '')? $u->user_name: $u->user_email;
                }
            }
        }
        return $data;
    }

    /**
     * @param $password
     * @return string
     */
    public function encode_password($password)
    {
        return password_hash(User::stringCode($password), PASSWORD_DEFAULT);
    }

    public function password_verify($password = '', $hash = '')
    {
        $check = password_verify(User::stringCode(trim($password)), trim($hash)) ? true : false;
        return $check;
    }

    public function stringCode($string)
    {
        return $string . env('project_name_hdi','mcredit.com.vn') . env('key_pass_hdi','-!@Hdi0938413368HDI!@');
    }

    public function updateLogin($user_id, $updateData = array())
    {
        if($user_id <= STATUS_INT_KHONG) return;
        $updateData['user_last_login'] = getCurrentDateTime();
        $updateData['user_last_ip'] = request()->ip();
        $updateData['user_status'] = STATUS_INT_MOT;
        self::updateUser($user_id, $updateData);
    }

    public function updateLogOut($user_id)
    {
        if($user_id <= STATUS_INT_KHONG) return;
        $updateData['user_last_logout'] = getCurrentDateTime();
        $updateData['user_last_ip'] = request()->ip();
        self::updateUser($user_id, $updateData);
    }

    public function user_login()
    {
        $user = array();
        if (Session::has(SESSION_ADMIN_LOGIN)) {
            $user = Session::get(SESSION_ADMIN_LOGIN);
        }
        return $user;
    }

    public function get_user_project()
    {
        $user_project = STATUS_INT_KHONG;
        if (Session::has(SESSION_ADMIN_LOGIN)) {
            $user = Session::get(SESSION_ADMIN_LOGIN);
            if (!empty($user)) {
                $user_project = (isset($user['user_project'])) ? $user['user_project'] : STATUS_INT_KHONG;
            }
        }
        return $user_project;
    }

    public function get_project_search()
    {
        $user_project = STATUS_INT_KHONG;
        if (Session::has(SESSION_ADMIN_LOGIN)) {
            $user = Session::get(SESSION_ADMIN_LOGIN);
            if (!empty($user)) {
                if (isset($user['user_view']) && $user['user_view'] == CGlobal::status_hide) {
                    $user_project = Define::STATUS_SEARCH_ALL;
                    return $user_project;
                }
                $user_project = (isset($user['user_project'])) ? $user['user_project'] : STATUS_INT_KHONG;
            }
        }
        return $user_project;
    }

    public function user_id()
    {
        $id = STATUS_INT_KHONG;
        if (Session::has(SESSION_ADMIN_LOGIN)) {
            $user = Session::get(SESSION_ADMIN_LOGIN);
            $id = $user['user_id'];
        }
        return $id;
    }

    public function user_name()
    {
        $user_name = '';
        if (Session::has(SESSION_ADMIN_LOGIN)) {
            $user = Session::get(SESSION_ADMIN_LOGIN);
            $user_name = $user['user_name'];
        }
        return $user_name;
    }

    public function updatePassWord($id, $pass)
    {
        try {
            $user = self::getUserById($id);
            $user->user_password = self::encode_password($pass);
            $user->change_pass = STATUS_INT_MOT;
            $user->update();
            self::removeCache($user->user_id, $user);
            return true;
        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function isLogin()
    {
        if (session()->has('user')) {
            return true;
        }
        return false;
    }

    public static function isCustomerLogin()
    {
        if (session()->has('customer')) {
            return true;
        }
        return false;
    }

    public function getList($role_type = STATUS_INT_KHONG)
    {
        if ($role_type == STATUS_INT_KHONG) {
            $user = User::where('user_status', '>', STATUS_INT_KHONG)->orderBy('user_id', 'desc')->get();
        } else {
            $user = User::where('user_status', '>', STATUS_INT_KHONG)->where('role_type', '=', $role_type)->orderBy('user_id', 'desc')->get();
        }
        return $user ? $user : array();
    }

    public function getOptionUserFullName($role_type = STATUS_INT_KHONG)
    {
        $arr = User::getList($role_type);
        foreach ($arr as $value) {
            $data[$value->user_id] = $value->user_name . ' - ' . $value->user_full_name;
        }
        return $data;
    }

    public function getListUserNameFullName()
    {
        $data = Memcache::getCache(Memcache::CACHE_INFO_USER);
        if (!$data) {
            $arr = User::getList();
            foreach ($arr as $value) {
                $data[$value->user_id] = $value->user_name . ' - ' . $value->user_full_name;
            }
            if (!empty($data)) {
                Memcache::putCache(Memcache::CACHE_INFO_USER, $data);
            }
        }
        return $data;
    }

    public function getOptionUserFullNameAndMail()
    {
        $data = Memcache::getCache(Memcache::CACHE_OPTION_USER);
        if (!$data) {
            $arr = User::getList();
            foreach ($arr as $value) {
                $data[$value->user_id] = $value->user_full_name . ' - ' . $value->user_email;
            }
            if (!empty($data)) {
                Memcache::putCache(Memcache::CACHE_OPTION_USER, $data);
            }
        }
        return $data;
    }

    public static function executesSQL($str_sql = '')
    {
        //return (trim($str_sql) != '') ? DB::statement(trim($str_sql)): array();
        return (trim($str_sql) != '') ? DB::select(trim($str_sql)) : array();
    }

    public static function getUserIdInArrPersonnelId($arrUserObjectId = array())
    {
        $person = array();
        if (sizeof($arrUserObjectId) > 0) {
            $result = User::whereIn('user_object_id', $arrUserObjectId)->get();
            if (sizeof($result) > 0) {
                foreach ($result as $item) {
                    $person[] = $item->user_object_id;
                }
            }
        }
        return $person;
    }

    public function getAllUserByArrRoleCode($arrRoleCode = array())
    {
        $data = array();
        if (!empty($arrRoleCode)) {
            $listUser = $this->getAllUser();
            if ($listUser) {
                foreach ($listUser as $item) {
                    if (in_array($item->role_code, $arrRoleCode)) {
                        $data[$item->user_id] = ($item->user_full_name != '') ? $item->user_full_name : $item->user_name;
                    }
                }
            }
        }
        return $data;
    }

    public static function getListUserByUserManagerId($user_manager_id){
        $data = Memcache::getCache(Memcache::CACHE_USER_BY_MANAGER.$user_manager_id);
        if(!$data) {
            $data = User::where('user_manager_id', $user_manager_id)->where('user_status', STATUS_SHOW)->get();
            if(!empty($data)) {
                Memcache::putCache(Memcache::CACHE_USER_BY_MANAGER.$user_manager_id, $data);
            }
        }
        return $data;
    }

    public static function getListUserByUserDepartIdPosition($user_depart_id, $position){
        $data = Memcache::getCache(Memcache::CACHE_USER_BY_DEPART.$user_depart_id.$position);
        if(!$data) {
            $data = User::where('user_depart_id', $user_depart_id)->where('position', $position)->where('user_status', STATUS_SHOW)->get();
            if(!empty($data)) {
                Memcache::putCache(Memcache::CACHE_USER_BY_DEPART.$user_depart_id.$position, $data);
            }
        }
        return $data;
    }

    public function getAllUserByUserDepartIdPosition(){
        $userLogin = app(User::class)->user_login();
        $user_current_id = isset($userLogin['user_id']) ? $userLogin['user_id'] : -1;
        $position = isset($userLogin['position']) ? $userLogin['position'] : 0;
        $user_depart_id = isset($userLogin['user_depart_id']) ? $userLogin['user_depart_id'] : 0;
        $user_manager_id = isset($userLogin['user_manager_id']) ? $userLogin['user_manager_id'] : 0;
        $result = [];
        if($user_manager_id == $user_current_id){
            $users = $this->getListUserByUserManagerId($user_manager_id);
            if($users->count() > 0){
                foreach($users as $item){
                    if($item->user_id != $user_current_id){
                        $result[$item->user_id] = $item->user_full_name;
                    }
                }
            }
            return $result;
        }

        if($user_depart_id > 0 && $position > 0){
            $users = $this->getListUserByUserDepartIdPosition($user_depart_id, $position);
            if($users->count() > 0){
                foreach($users as $item){
                    if($item->user_id != $user_current_id){
                        $result[$item->user_id] = $item->user_full_name;
                    }
                }
                return $result;
            }
        }
        return $result;
    }

    public function getArrUserByManager($user_manager_id = 0){
        $data = [];
        if($user_manager_id > 0){
            $dataUserByManager = $this->getListUserByUserManagerId($user_manager_id);
            if($dataUserByManager->count() > 0){
                foreach($dataUserByManager as $item){
                    $data[$item->user_id] = $item->user_name;
                }
            }
        }
        return $data;
    }

    public static function getListUserByUserDepartId($user_depart_id){
        $data = Memcache::getCache(Memcache::CACHE_USER_BY_DEPART_ONE.$user_depart_id);
        if(!$data) {
            $data = User::where('user_depart_id', $user_depart_id)->where('user_status', STATUS_SHOW)->get();
            if(!empty($data)) {
                Memcache::putCache(Memcache::CACHE_USER_BY_DEPART_ONE.$user_depart_id, $data);
            }
        }
        return $data;
    }
    public function getArrUserIdByDepart($user_depart_id = 0){
        $data = [];
        if($user_depart_id > 0){
            $dataUserByDepart = $this->getListUserByUserDepartId($user_depart_id);
            if($dataUserByDepart->count() > 0){
                foreach($dataUserByDepart as $item){
                    $data[$item->user_id] = $item->user_id;
                }
            }
        }
        return $data;
    }

    public function getPermit(){
        $user = app(User::class)->user_login();
        if(!empty($user)) {
            $permission = $user['user_permission'];
            if(!empty($permission) && (in_array('root', $permission) || in_array('is_tech', $permission))) {
                return true;
            }
        }
        return false;
    }
    /*
     * Dùng demo
     * */
    public function create_abc($data = array()){
        if(empty($data))
            return array();
        $site = FunctionLib::getUrlApi();
        $site .="api/admin/appendix/add";
        $curl = PlazaCurl::getInstance();
        $request = $curl->post($site,$data);
        return $dataResponse = json_decode($request,1);
    }

    public function update_abc($id,$data){
        if(empty($data))
            return array();
        if($id > 0){
            $site = FunctionLib::getUrlApi();
            $site .="api/admin/appendix/add/{$id}";
            $curl = PlazaCurl::getInstance();
            $request = $curl->post($site, $data);
            $dataResponse = json_decode($request,1);
            return $dataResponse;
        }
        return array();
    }
}
