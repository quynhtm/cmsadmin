<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class UserController extends BaseAdminController
{
    private $permission_full = 'user_full';
    private $permission_view = 'user_view';
    private $permission_create = 'user_create';
    private $permission_edit = 'user_edit';
    private $permission_change_pass = 'user_change_pass';
    private $permission_remove = 'user_remove';
    private $arrStatus = array(0 => 'Tất cả', CGlobal::status_show => 'Hoạt động', CGlobal::status_block => "Khóa");
    private $error = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function view()
    {
        CGlobal::$pageAdminTitle  = "Quản trị User | Admin CMS";
        //check permission
        if (!$this->is_root && !in_array($this->permission_view, $this->permission)) {
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $page_no = Request::get('page_no', 1);
        $dataSearch['user_status'] = Request::get('user_status', 0);
        $dataSearch['user_email'] = Request::get('user_email', '');
        $dataSearch['user_full_name'] = Request::get('user_full_name', '');
        $dataSearch['user_name'] = Request::get('user_name', '');
        $dataSearch['user_group'] = Request::get('user_group', 0);

        $limit = CGlobal::number_limit_show;
        $total = 0;
        $offset = ($page_no - 1) * $limit;
        $data = User::searchByCondition($dataSearch, $limit, $offset, $total);
        $arrGroupUser = GroupUser::getListGroupUser();

        $paging = $total > 0 ? Pagging::getNewPager(3,$page_no,$total,$limit,$dataSearch) : '';
        $this->layout->content = View::make('admin.User.view')
            ->with('arrStatus', $this->arrStatus)
            ->with('arrGroupUser', $arrGroupUser)
            ->with('data', $data)
            ->with('dataSearch', $dataSearch)
            ->with('size', $total)
            ->with('start', ($page_no - 1) * $limit)
            ->with('paging', $paging)
            ->with('is_root', $this->is_root)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
            ->with('permission_change_pass', in_array($this->permission_change_pass, $this->permission) ? 1 : 0)
            ->with('permission_remove', in_array($this->permission_remove, $this->permission) ? 1 : 0);
    }

    public function getUser($id=0) {
        CGlobal::$pageAdminTitle = "Cập nhật thông tin User | Admin CMS";
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $data = array();
        if($id > 0) {
            $data = User::getUserById($id);
            $data['user_group'] = explode(',', $data['user_group']);
        }
        $arrGroupUser = GroupUser::getListGroupUser();
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['user_status'])? $data['user_status'] : 1);
        $this->layout->content = View::make('admin.User.addUser')
            ->with('id', $id)
            ->with('arrGroupUser', $arrGroupUser)
            ->with('is_root', $this->is_root)
            ->with('error', $this->error)
            ->with('optionStatus', $optionStatus)
            ->with('data', $data);
    }
    public function postUser($id=0) {
        CGlobal::$pageAdminTitle = "Cập nhật thông tin User | Admin CMS";
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $dataSave['user_name'] = htmlspecialchars(trim(Request::get('user_name', '')));
        $dataSave['user_full_name'] = htmlspecialchars(trim(Request::get('user_full_name', '')));
        $dataSave['user_email'] = htmlspecialchars(trim(Request::get('user_email', '')));
        $dataSave['user_phone'] = htmlspecialchars(trim(Request::get('user_phone', '')));
        $dataSave['user_service'] = htmlspecialchars(trim(Request::get('user_service', '')));
        $dataSave['user_status'] = trim(Request::get('user_status', 1));

        $user_time_work_start = trim(Request::get('user_time_work_start', ''));
        $user_time_work_end = trim(Request::get('user_time_work_end', ''));
        $dataSave['user_time_work_start'] = ($user_time_work_start != '')? strtotime($user_time_work_start):0;
        $dataSave['user_time_work_end'] = ($user_time_work_end != '')? strtotime($user_time_work_end): 0;

        $groupUser = Request::get('user_group', array());
        if ($groupUser) {
            $strGroupUser = implode(',', $groupUser);
            $dataSave['user_group'] = $strGroupUser;
        }

        //FunctionLib::debug($dataSave);
        if($this->validUser($dataSave) && empty($this->error)) {
            if($id > 0) {
                //cap nhat
                if(User::updateUser($id, $dataSave)) {
                    return Redirect::route('admin.user_view');
                }
            } else {
                //them moi
                if(User::createNew($dataSave)) {
                    return Redirect::route('admin.user_view');
                }
            }
        }

        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['user_status'])? $dataSave['user_status'] : 1);
        $arrGroupUser = GroupUser::getListGroupUser();
        $this->layout->content = View::make('admin.User.addUser')
            ->with('id', $id)
            ->with('arrGroupUser', $arrGroupUser)
            ->with('is_root', $this->is_root)
            ->with('error', $this->error)
            ->with('optionStatus', $optionStatus)
            ->with('data', $dataSave);
    }
    private function validUser($data=array()) {
        if(!empty($data)) {
            if(isset($data['user_name']) && trim($data['user_name']) == '') {
                $this->error[] = 'Tài khoản đăng nhập không được bỏ trống';
            }
            if(isset($data['user_full_name']) && trim($data['user_full_name']) == '') {
                $this->error[] = 'Tài nhân viên không được bỏ trống';
            }
        }
        return true;
    }

    public function changePassInfo($ids){
        $id = base64_decode($ids);
        $user = User::user_login();
        if (!$this->is_root && !in_array($this->permission_change_pass, $this->permission) && (int)$id !== (int)$user['user_id']) {
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $this->layout->content = View::make('admin.User.change')
            ->with('id', $id)
            ->with('is_root', $this->is_root)
            ->with('permission_change_pass', in_array($this->permission_change_pass, $this->permission) ? 1 : 0);
    }
    public function changePass($ids){
        $id = base64_decode($ids);
        $user = User::user_login();
        //check permission
        if (!$this->is_root && !in_array($this->permission_change_pass, $this->permission) && (int)$id !== (int)$user['user_id']) {
            return Redirect::route('admin.dashboard',array('error'=>1));
        }

        $error = array();
        $old_password = Request::get('old_password', '');
        $new_password = Request::get('new_password', '');
        $confirm_new_password = Request::get('confirm_new_password', '');
        if(!$this->is_root && !in_array($this->permission_change_pass, $this->permission)){
            $user_byId = User::getUserById($id);
            if($old_password == ''){
                $error[] = 'Bạn chưa nhập mật khẩu hiện tại';
            }
            if(User::encode_password($old_password) !== $user_byId->user_password ){
                $error[] = 'Mật khẩu hiện tại không chính xác';
            }
        }

        if ($new_password == '') {
            $error[] = 'Bạn chưa nhập mật khẩu mới';
        } elseif (strlen($new_password) < 5) {
            $error[] = 'Mật khẩu quá ngắn';
        }
        if ($confirm_new_password == '') {
            $error[] = 'Bạn chưa xác nhận mật khẩu mới';
        }
        if ($new_password != '' && $confirm_new_password != '' && $confirm_new_password !== $new_password) {
            $error[] = 'Mật khẩu xác nhận không chính xác';
        }
        if (empty($error)) {
            //Insert dữ liệu
            if (User::updatePassword($id, $new_password)) {
                if((int)$id !== (int)$user['user_id']){
                    return Redirect::route('admin.dashboard');
                }else{
                    return Redirect::route('admin.user_view');
                }
            } else {
                $error[] = 'Không update được dữ liệu';
            }
        }

        $this->layout->content = View::make('admin.User.change')
            ->with('id', $id)
            ->with('is_root', $this->is_root)
            ->with('error', $error);
    }
    public function remove($id){
        $data['success'] = 0;
        if(!$this->is_root && !in_array($this->permission_remove, $this->permission)){
            return Response::json($data);
        }
        $user = User::find($id);
        if($user){
            if(User::remove($user)){
                $data['success'] = 1;
            }
        }
        return Response::json($data);
    }

}