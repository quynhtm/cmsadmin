<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

namespace App\Http\Controllers\BackendCms;

use App\Models\OpenId\MenuSystem;
use App\Models\OpenId\UserSystem;
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
    public $_user;
    public $_bg_login;

    //public function __construct(UserSystem $user)
    public function __construct(UserSystem $user)
    {
        $this->_user = $user;
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
            return view('admin.AdminLayouts.formLogin', ['url' => $url, 'bg_login' => $this->_bg_login]);
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
        $type_user = Request::get('type_user', 'USER_LOGIN');
        $error = '';
        if ((Session::token() == $token)) {
            if ($keyword != '' && $password != '') {
                if (strlen($keyword) < 3 || strlen($keyword) > 50 || preg_match('/[^A-Za-z0-9_\.@]/', $keyword) || strlen($password) < 5) {
                    $error = 'Không tồn tại tên đăng nhập!';
                } else {
                    $modelUser = new UserSystem();
                    $user = $modelUser->getInforUserByKey($keyword, $type_user);
                    if (isset($user->USER_CODE)) {
                        if ($user->IS_ACTIVE == STATUS_INT_KHONG) {
                            $error = 'Tài khoản của bạn hiện đang bị khóa!';
                        } elseif ($user->IS_ACTIVE == STATUS_INT_MOT) {
                            $username = $user->USER_NAME;
                            if ($modelUser->comparePassword(trim($username), trim($password), $user->PASSWORD)) {
                                return $this->_buildUserLogin($user,$url);
                            } else {
                                $error = 'User name hoặc mật khẩu không đúng!';
                            }
                        }
                    } else {
                        $error = 'Tài khoản của bạn chưa có trên hệ thống!';
                    }
                }
            } else {
                $error = 'Chưa nhập thông tin đăng nhập!';
            }
        } else {
            $error = 'Thông tin đăng nhập không đúng!';
        }
        return view('admin.AdminLayouts.formLogin', ['error' => $error, 'username' => $keyword, 'url' => $url, 'bg_login' => $this->_bg_login]);
    }

    public function loginAs($keyword = '')
    {
        $modelUser = new UserSystem();
        if (Session::has(SESSION_ADMIN_LOGIN)) {
            $userAction = $modelUser->userLogin();
            if(isset($userAction['is_boss']) && $userAction['is_boss'] == STATUS_INT_MOT){
                Session::forget(SESSION_ADMIN_LOGIN);
                $type_user = 'USER_LOGIN';
                $user = $modelUser->getInforUserByKey($keyword, $type_user);
                if (isset($user->USER_CODE)) {
                    return $this->_buildUserLogin($user);
                }
                return Redirect::route('admin.login');
            }else{
                return Redirect::route('admin.login');
            }
        }
        return Redirect::route('admin.login');
    }

    private function _buildUserLogin($user,$url = ''){
        $modelUser = new UserSystem();
        $dataUserMenu = json_decode($user->MENU_CODE, true);
        $userMenu = $this->_getMenuWithUserLogin($dataUserMenu);
        $inforSystemUser = $modelUser->getSystemInfoByUser($user->USER_NAME, $user->ORG_CODE);
        $data = array(
            'user_id' => $user->USER_CODE,
            'user_name' => $user->USER_NAME,
            'user_full_name' => $user->FULL_NAME,
            'user_depart_id' => $user->STRUCT_CODE,
            'user_depart_name' => $user->STRUCT_NAME,
            'user_email' => $user->EMAIL,
            'position' => $user->POSITION_CODE,
            'org_code' => $user->ORG_CODE,
            'user_type' => $user->USER_TYPE,
            'phone' => $user->PHONE,
            'birthday' => $user->BIRTHDAY,
            'user_image' => $user->IMAGE,
            'time_last_login' => $user->LAST_LOGIN,
            'is_boss' => ($user->USER_TYPE == USER_ROOT) ? STATUS_INT_MOT : STATUS_INT_KHONG,
            'change_pass' => $user->IS_CHANGE_PWD,
            'user_group_menu' => $userMenu['arrMenuId'],
            'user_permission' => $userMenu['userPermissionMenu'],
            'user_tab_id' => $userMenu['projectCode'],
            'infor_system_user' => $inforSystemUser,
        );
        $this->_getMenuWithUser($data);//menu của user login
        $modelUser->updateUserLogin($user->USER_CODE);
        Session::put(SESSION_ADMIN_LOGIN, $data, 60 * 24);

        if ($url === '' || $url === 'login') {
            if ($user->IS_CHANGE_PWD == STATUS_INT_KHONG || $user->USER_TYPE != USER_ROOT) {
                return Redirect::route('userSystem.userProfile', ['id' => setStrVar($user->USER_CODE), 'name' => safe_title($user->FULL_NAME)]);
            }
            return Redirect::route('admin.dashboard');
        } else {
            return Redirect::to(self::buildUrlDecode($url));
        }
    }
    /**
     * @param $dataUser
     * Build menu tree theo user login
     */
    private function _getMenuWithUser(&$dataUser)
    {
        $menuSystem = [];
        $arrProject = Config::get('config.IS_DEV') ? [MENU_HDI_OPEN_ID, MENU_HDI_SELLING] : [CGlobal::$menuWithTabTop[trim(Config::get('config.PROJECT_CODE'))]];

        foreach ($arrProject as $project_code_menu) {
            $arrMenu = app(MenuSystem::class)->buildMenuAdmin($project_code_menu);
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
                                $menuSystem[$menu['menu_tab_top_id']][$menu_id] = $menu;
                            }
                        } else {
                            if ($dataUser['is_boss'] == STATUS_INT_MOT || (!empty($dataUser['user_group_menu']) && in_array($menu['menu_id'], $dataUser['user_group_menu']))) {
                                $checkMenu = true;
                            }
                            if ($checkMenu) {
                                $menuSystem[$menu['menu_tab_top_id']][$menu['menu_id']] = $menu;
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
        }
        $dataUser['user_tree_menu'] = $menuSystem;
    }

    /**
     * get menu, quyền action của user
     * @param array $dataInput
     * @return array|array[]
     */
    private function _getMenuWithUserLogin($dataInput = [])
    {
        if (empty($dataInput))
            return ['userPermissionMenu' => [], 'arrMenuId' => [], 'projectCode' => []];

        $allMenu = app(MenuSystem::class)->getAllMenuByProjectCode();
        $arrProjectCode = $arrUserMenu = $arrMenuId = [];
        if ($allMenu) {
            $arrMenuId = array_keys($dataInput);
            foreach ($allMenu as $k => $menu) {
                if (in_array($menu->MENU_CODE, $arrMenuId) && $menu->IS_ACTIVE == STATUS_INT_MOT && trim($menu->CONTROL_NAME) != '') {
                    $tabId = isset(CGlobal::$projectMenuWithTabTop[trim($menu->PROJECT_CODE)]) ? CGlobal::$projectMenuWithTabTop[trim($menu->PROJECT_CODE)] : CGlobal::dms_portal;
                    $arrProjectCode[$tabId] = trim($menu->PROJECT_CODE);
                    $arrUserMenu[trim($menu->CONTROL_NAME)] = $dataInput[trim($menu->MENU_CODE)];
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
        return Redirect::route('admin.login');
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
            $modelUser = new UserSystem();
            $user = $modelUser->getInforUserByKey($user_name_forgot, 'USER_NAME');
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
                    $strPassNew = $modelUser->buildPassword(strtoupper($user->USER_NAME), $password_new);

                    $dataSend['PASSWORD'] = $strPassNew;
                    $dataSend['OLD_PASSWORD'] = $user->PASSWORD;
                    $dataSend['IS_CHANGE_PWD'] = STATUS_INT_KHONG;

                    $dataSend['EMAIL'] = $user->EMAIL;
                    $dataSend['USER_NAME'] = $user->USER_NAME;
                    $dataSend['FULL_NAME'] = $user->FULL_NAME;
                    $dataSend['PASSWORD_NEW'] = $password_new;
                    $dataSend['URL_LOGIN'] = Config::get('config.WEB_ROOT');

                    if ($modelUser->updatePassword($user->USER_CODE, $dataSend)) {
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
