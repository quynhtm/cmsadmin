<?php


use Illuminate\Cache\MemcachedStore;

class User extends Eloquent {
    protected $table = 'cms_user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = array('user_name', 'user_password', 'user_full_name', 'user_email', 'user_phone',
        'user_status', 'user_group','user_last_login','user_last_ip','user_create_id','user_create_name',
        'user_service','user_time_work_start','user_time_work_end','user_group_depart',
        'user_edit_id','user_edit_name','user_created','user_updated');


    /**
     * @param $name
     * @return mixed
     */
    public static function getUserByName($name){
        $admin = User::where('user_name', $name)->first();
        return $admin;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getUserById($id){
        $admin = User::find($id);
        return $admin;
    }

    /**
     * @param $password
     * @return string
     */
    public static function encode_password($password){
        return md5($password.'-haianhem!@13368');
    }

    public static function updateLogin($user = array()){
        if($user){
            $user->user_last_login = time();
            $user->user_last_ip = Request::getClientIp();
            $user->save();
        }
    }

    public static function user_login(){
        $user = array();
        if(Session::has('user')){
            $user = Session::get('user');
        }
        return $user;
    }

    public static function user_id(){
        $id = 0;
        if(Session::has('user')){
            $user = Session::get('user');
            $id = $user['user_id'];
        }
        return $id;
    }

    public static function user_name(){
        $user_name = '';
        if(Session::has('user')){
            $user = Session::get('user');
            $user_name = $user['user_name'];
        }
        return $user_name;
    }

    public static function searchByCondition($data = array(), $limit = 0, $offset = 0, &$size)
    {
        try {
            $query = User::where('user_id', '>', 0);

            if (isset($data['user_id']) && $data['user_id'] > 0) {
                $query->where('user_id', $data['user_id']);
            }
            if (isset($data['user_name']) && $data['user_name'] != '') {
                $query->where('user_name', 'LIKE', '%' . $data['user_name'] . '%');
            }
            if (isset($data['user_email']) && $data['user_email'] != '') {
                $query->where('user_email', 'LIKE', '%' . $data['user_email'] . '%');
            }
            if (isset($data['user_full_name']) && $data['user_full_name'] != '') {
                $query->where('user_full_name', 'LIKE', '%' . $data['user_full_name'] . '%');
            }
            if (isset($data['user_status']) && $data['user_status'] != 0) {
                $query->where('user_status', $data['user_status']);
            }
            if (isset($data['user_group']) && $data['user_group'] > 0) {
                $query->whereRaw('FIND_IN_SET(' . $data['user_group'] . ',' . 'user_group)');
            }
            $size = $query->count();
            $data = $query->orderBy('user_id', 'desc')->take($limit)->skip($offset)->get();

            return $data;

        } catch (PDOException $e) {
            $size = 0;
            return null;
            throw new PDOException();
        }
    }

    public static function createNew($data)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $user = new User();
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $k => $v) {
                    $user->$k = $v;
                }
                $user->user_password = self::encode_password($user->user_password);
            }
            $user->save();

            DB::connection()->getPdo()->commit();
            return $user->user_id;
        } catch (PDOException $e) {
            //var_dump($e->getMessage());die;
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function updateUser($id,$data){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $user = User::find($id);
            foreach ($data as $k => $v) {
                $user->$k = $v;
            }
            $user->update();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            //var_dump($e->getMessage());
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function updatePassWord($id,$pass){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $user = User::find($id);
            $user->user_password = self::encode_password($pass);
            $user->update();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            //var_dump($e->getMessage());
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function isLogin()
    {
        $result = false;
        if (Session::has('user')) {
            $result = true;
        }
        return $result;
    }

    public static function getListAllUser() {
        $user = User::where('user_status', '>', 0)->lists('user_name','user_id');
        return $user ? $user : array();
    }

    public static function remove($user){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $user->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            //var_dump($e->getMessage());
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
            return false;
        }
    }


}
