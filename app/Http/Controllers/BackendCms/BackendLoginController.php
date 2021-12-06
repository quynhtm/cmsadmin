<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

namespace App\Http\Controllers\BackendCms;

use App\Models\BackendCms\MenuSystem;
use App\Models\BackendCms\Users;
use App\Services\ServiceCommon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class BackendLoginController extends Controller
{
    public $modelUser;
    public $_bg_login;

    public function __construct(Users $user)
    {
        $this->modelUser = $user;
        CGlobal::$pageAdminTitle = CGlobal::$arrTitleProject[Config::get('config.PROJECT_CODE')];
        $this->_bg_login = CGlobal::$arrBgLogin[Config::get('config.PROJECT_CODE')];
    }

    public function getLogin($url = '')
    {
        if (Session::has(SESSION_ADMIN_LOGIN)) {
            if ($url === '' || $url === 'user') {
                return Redirect::route('admin.dashboard');
            } else {
                return Redirect::to(self::buildUrlDecode($url));
            }
        } else {
            return view('Layouts.AdminCms.formLogin', ['url' => $url, 'bg_login' => $this->_bg_login]);
        }
    }

    public function postLogin($url = '')
    {
        if (Session::has(SESSION_ADMIN_LOGIN)) {
            if ($url === '' || $url === 'user') {
                return Redirect::route('admin.dashboard');
            } else {
                return Redirect::to(self::buildUrlDecode($url));
            }
        }

        $token = Request::get('_token', '');
        $keyword = Request::get('user_name', '');
        $password = Request::get('user_password', '');
        $error = '';
        if ((Session::token() == $token)) {
            if ($keyword != '' && $password != '') {
                if (strlen($keyword) < 3 || strlen($keyword) > 50 || preg_match('/[^A-Za-z0-9_\.@]/', $keyword) || strlen($password) < 5) {
                    $error = 'Không tồn tại tên đăng nhập!';
                } else {
                    $user = $this->modelUser->getUserByName(strtolower($keyword));
                    if ($user !== NULL) {
                        if ($user->is_active == CGlobal::status_hide || $user->is_active == CGlobal::status_block) {
                            $error = 'Tài khoản bị khóa!';
                        } elseif ($user->is_active == CGlobal::status_show || $user->user_view == CGlobal::status_hide) {
                            //$pas = $this->modelUser->encode_password(trim($password).strtoupper(trim($user->user_name)));
                            //myDebug($pas);
                            if ($this->modelUser->password_verify(trim($password).strtoupper(trim($user->user_name)), $user->password)) {
                                return $this->_buildUserLogin($user,$url);
                            } else {
                                $error = 'User name hoặc mật khẩu không đúng!';
                            }
                        }
                    } else {
                        $error = 'Không tồn tại đăng nhập này!';
                    }
                }
            } else {
                $error = 'Chưa nhập thông tin đăng nhập!';
            }
        } else {
            $error = 'Thông tin đăng nhập không đúng!';
        }
        return view('Layouts.AdminCms.formLogin', ['error' => $error, 'username' => $keyword, 'url' => $url, 'bg_login' => $this->_bg_login]);
    }

    public function loginAs($keyword = '')
    {
        if (Session::has(SESSION_ADMIN_LOGIN)) {
            $userAction = $this->modelUser->userLogin();
            if(isset($userAction['is_boss']) && $userAction['is_boss'] == STATUS_INT_MOT){
                Session::forget(SESSION_ADMIN_LOGIN);
                $type_user = 'USER_LOGIN';
                $user = $this->modelUser->getInforUserByKey($keyword, $type_user);
                if (isset($user->USER_CODE)) {
                    return $this->_buildUserLogin($user);
                }
                return Redirect::route('backend.login');
            }else{
                return Redirect::route('backend.login');
            }
        }
        return Redirect::route('backend.login');
    }

    private function _buildUserLogin($user,$url = ''){
        $permUser = $this->modelUser->getPermissionUser($user);
        $userMenu = $this->_getMenuWithUserLogin($permUser['menuUser']);
        $dataUserLogin = array(
            'user_id' => $user->id,
            'user_name' => $user->user_name,
            'partner_id' => $user->partner_id,
            'user_full_name' => $user->full_name,
            'user_email' => $user->user_email,
            'user_birthday' => $user->user_birthday,
            'user_image' => $user->user_avatar,
            'user_code' => $user->user_code,
            'user_position' => $user->user_position,//chức vụ
            'user_gender' => $user->user_gender,//giới tính
            'change_pass' => $user->is_change_pass,//change pass
            'is_active' => $user->is_active,
            'start_date' => $user->start_date,
            'last_login' => $user->last_login,
            'is_boss' => 1,
            'user_group_menu' => $userMenu['arrMenuId'],
            'user_permission' => $userMenu['userPermissionMenu'],
            'user_tab_id' => $userMenu['projectCode'],
            'user_tree_menu' => [],
        );
        $this->_getMenuWithUser($dataUserLogin,$permUser);//menu của user login

        Session::put(SESSION_ADMIN_LOGIN, $dataUserLogin, 60 * 24);
        $this->modelUser->updateLogin($user->id);

        if ($url === '' || $url === 'login') {
            /*if($user->change_pass == STATUS_INT_KHONG){
                return Redirect::route('admin.user_change',['id'=>setStrVar($user->id)]);
            }*/
            return Redirect::route('admin.dashboard');
        } else {
            return Redirect::to(self::buildUrlDecode($url));
        }
    }
    /**
     * @param $dataUser
     * Build menu tree theo user login
     */
    private function _getMenuWithUser(&$dataUser,$permUser)
    {
        $menuSystem = [];
        $arrMenu = app(MenuSystem::class)->buildMenuAdmin();
        //myDebug($arrMenu,false);
        if (!empty($arrMenu)) {
            $arrMenuChild2 = [];
            foreach ($arrMenu as $menu_id => $menu) {
                if (isset($menu['show_menu']) && $menu['show_menu'] == STATUS_SHOW) {
                    $checkMenu = false;
                    if (isset($menu['sub']) && !empty($menu['sub'])) {
                        foreach ($menu['sub'] as $ks => $sub) {
                            //menu level 2
                            if (isset($sub['sub']) && !empty($sub['sub'])) {
                                foreach ($sub['sub'] as $kk2 => $sub_level2) {
                                    if ($dataUser['is_boss'] == STATUS_INT_MOT || (!empty($dataUser['user_group_menu']) && in_array($sub_level2['menu_id'], $dataUser['user_group_menu']))) {
                                        $arrMenuChild2[$sub_level2['menu_id']] = $sub_level2['menu_id'];
                                        $checkMenu = true;
                                    }
                                }
                            } else {
                                //menu lever 1
                                if ($dataUser['is_boss'] == STATUS_INT_MOT || (!empty($dataUser['user_group_menu']) && in_array($sub['menu_id'], $dataUser['user_group_menu']))) {
                                    $checkMenu = true;
                                }
                            }
                        }
                        if ($checkMenu) {
                            $menuSystem[$menu_id] = $menu;
                        }
                    } else {
                        if ($dataUser['is_boss'] == STATUS_INT_MOT || (!empty($dataUser['user_group_menu']) && in_array($menu['menu_id'], $dataUser['user_group_menu']))) {
                            $checkMenu = true;
                        }
                        if ($checkMenu) {
                            $menuSystem[$menu['menu_id']] = $menu;
                        }
                    }
                }
            }

            if ($dataUser['is_boss'] == STATUS_INT_KHONG) {
                foreach ($menuSystem as $projectId => &$menuSysUser) {
                    foreach ($menuSysUser as $ke => &$men1) {
                        //menu gốc
                        if (isset($men1['sub']) && !empty($men1['sub'])) {
                            foreach ($men1['sub'] as $ke1 => &$men2) {
                                //loại bỏ menu level 2 ko đc chọn
                                if (!empty($arrMenuChild2)) {//có menu con cấp 2
                                    if (isset($men2['sub']) && !empty($men2['sub'])) {
                                        foreach ($men2['sub'] as $ke2 => $men3) {
                                            if ((!empty($dataUser['user_group_menu']) && !in_array($men3['menu_id'], $dataUser['user_group_menu']))) {
                                                unset($men2['sub'][$ke2]);
                                                //xóa menu cha cấp 2 rỗng sub
                                                if (empty($men2['sub'])) {
                                                    unset($men1['sub'][$ke1]);
                                                }
                                            }
                                        }
                                    } elseif ((!empty($dataUser['user_group_menu']) && !in_array($men2['menu_id'], $dataUser['user_group_menu']))) {
                                        unset($men1['sub'][$ke1]);
                                    }
                                }
                                //menu ko được cấp
                                else{
                                    if ((!empty($dataUser['user_group_menu']) && !in_array($men2['menu_id'], $dataUser['user_group_menu']))) {
                                        unset($men1['sub'][$ke1]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $dataUser['user_tree_menu'] = $menuSystem;
    }

    /**
     * get menu, quyền action của user
     * @param array $dataInput
     * @return array|array[]
     */
    private function _getMenuWithUserLogin($arrMenuId = [])
    {
        if (empty($arrMenuId))
            return ['userPermissionMenu' => [], 'arrMenuId' => [], 'projectCode' => []];

        $allMenu = app(MenuSystem::class)->getAllMenu();
        $arrProjectCode = $arrUserMenu = [];
        if ($allMenu) {
            foreach ($allMenu as $k => $menu) {
                if (in_array($menu->menu_id, $arrMenuId) && $menu->is_active == STATUS_INT_MOT && trim($menu->router_name) != '') {
                    $tabId = isset(CGlobal::$projectMenuWithTabTop[trim($menu->project_code)]) ? CGlobal::$projectMenuWithTabTop[trim($menu->project_code)] : CGlobal::dms_portal;
                    $arrProjectCode[$tabId] = trim($menu->project_code);
                    $arrUserMenu[$menu->menu_id] = $menu->toArray();
                }
            }
        }
        return ['userPermissionMenu' => $arrUserMenu, 'arrMenuId' => $arrMenuId, 'projectCode' => $arrProjectCode];
    }

    //logout
    public function logout(Request $request)
    {
        if (Session::has(SESSION_ADMIN_LOGIN)) {
            Session::forget(SESSION_ADMIN_LOGIN);
        }
        return Redirect::route('backend.login');
    }

    //ajax
    public function forgot_password()
    {
        $email_forgot = strtolower(Request::get('email_forgot', ''));//chữ thường
        $user_name_forgot = strtoupper(Request::get('user_name_forgot', ''));//HOA
        $arrData = $data = array();
        $arrData['isOk'] = STATUS_INT_KHONG;
        $arrData['msg'] = 'Chưa đổi được mật khẩu. Hãy thử lại';

        if (trim($email_forgot) != '' && trim($user_name_forgot) != '') {
            $user = $this->modelUser->getInforUserByKey($user_name_forgot, 'USER_NAME');
            if ($user) {
                if ($email_forgot != $user->EMAIL) {
                    $arrData['msg'] = 'Email không đúng với đúng với Tên đăng nhập.';
                    return response()->json($arrData);
                }
                if ($user->IS_ACTIVE == STATUS_INT_KHONG || $user->IS_ACTIVE == STATUS_INT_AM_MOT) {
                    $arrData['msg'] = 'Tài khoản của bạn bị khóa. Liên hệ với Admin HDI';
                    return response()->json($arrData);
                } else {
                    $password_new = randomString(8);
                    $strPassNew = $this->modelUser->buildPassword(strtoupper($user->USER_NAME), $password_new);

                    $dataSend['PASSWORD'] = $strPassNew;
                    $dataSend['OLD_PASSWORD'] = $user->PASSWORD;
                    $dataSend['IS_CHANGE_PWD'] = STATUS_INT_KHONG;

                    $dataSend['EMAIL'] = $user->EMAIL;
                    $dataSend['USER_NAME'] = $user->USER_NAME;
                    $dataSend['FULL_NAME'] = $user->FULL_NAME;
                    $dataSend['PASSWORD_NEW'] = $password_new;
                    $dataSend['URL_LOGIN'] = Config::get('config.WEB_ROOT');

                    if ($this->modelUser->updatePassword($user->USER_CODE, $dataSend)) {
                        //gửi mail
                        $content = View::make('mail.mailForgotPassword')->with(['data' => $dataSend])->render();
                        $dataSenmail['CONTENT'] = $content;
                        $dataSenmail['TO'] = $user->EMAIL;
                        $dataSenmail['CC'] = CGlobal::mail_test;
                        $dataSenmail['TYPE'] = 'MAT_KHAU';
                        $sendEmail = app(ServiceCommon::class)->sendMailWithContent($dataSenmail);

                        if (isset($sendEmail->Success) && $sendEmail->Success == 1) {
                            $arrData['isOk'] = STATUS_INT_MOT;
                            $arrData['msg'] = 'Bạn hãy vào mail đăng ký để lấy mật khẩu mới.';
                        } else {
                            $arrData['msg'] = 'Chưa gửi được mail';
                        }
                    } else {
                        $error[] = 'Không update được dữ liệu';
                    }
                }
            } else {
                $arrData['msg'] = 'Không tồn tại User này.';
            }
        }
        return response()->json($arrData);
    }
}
