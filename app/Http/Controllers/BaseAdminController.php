<?php
/*
* @Created by: QuynhTM
* @Author    : QuynhTM
* @Date      : 01/2018
* @Version   : 1.0
*/

namespace App\Http\Controllers;

use App\Http\Models\OpenId\TypeDefine;
use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Models\OpenId\MenuSystem;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use View;

class  BaseAdminController extends Controller
{
    protected $permission = array();
    protected $user = array();
    protected $menuSystem = array();
    protected $user_group_menu = array();
    protected $user_tab_id = array();
    protected $is_root = false;
    protected $is_boss = false;
    protected $is_tech = false;
    protected $change_pass = false;
    protected $user_id = STATUS_INT_KHONG;
    protected $user_name = '';
    protected $tab_top = STATUS_INT_KHONG;

    protected $project_code_menu = '';
    protected $role_type = STATUS_INT_KHONG;
    protected $languageSite = VIETNAM_LANGUAGE;

    protected $permission_view = false;
    protected $permission_add = false;
    protected $permission_edit = false;
    protected $permission_remove = false;
    protected $permission_approve = false;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!app('App\Http\Models\OpenId\UserSystem')->isLogin()) {
                $url_encode = self::buildUrlEncode(URL::current());
                if ($request->ajax()) {
                    return Response::json(returnErrorSession());
                } else {
                    Redirect::route('admin.login', array('url' => $url_encode))->send();
                }
            }

            $this->tab_top = $this->getProjectCodeByRouter();
            $this->project_code_menu = $this->getMenuCodeByProjectCode($this->tab_top);
            $this->user = app('App\Http\Models\OpenId\UserSystem')->userLogin();
            if (!empty($this->user)) {
                $this->is_boss = $this->user['is_boss'];
                if (isset($this->user['change_pass']) && $this->user['change_pass'] == STATUS_INT_KHONG) {
                    $routerName = $this->getRouteNameAction();
                    if (!in_array($routerName, ['userSystem.ajaxGetChangePass', 'userSystem.ajaxPostChangePass'])) {
                        $this->change_pass = true;
                    }
                }
                if (!empty($this->user['user_permission'])) {
                    $this->permission = $this->user['user_permission'];
                }
                if (!empty($this->user['user_group_menu'])) {
                    $this->user_group_menu = $this->user['user_group_menu'];
                }
                if (!empty($this->user['user_tab_id'])) {
                    $this->user_tab_id = $this->user['user_tab_id'];
                }
                if (isset($this->user['user_id']) && (int)trim($this->user['user_id']) > 0) {
                    $this->user_id = $this->user['user_id'];
                    $this->user_name = $this->user['user_name'];
                }
                $this->is_tech = $this->is_boss;
                $this->is_root = in_array('root', $this->permission) ? false : $this->is_root;
            }
            $this->user_tab_id = ($this->is_boss) ? CGlobal::$menuWithTabTop : $this->user_tab_id;

            //project code menu
            $arrMenu = $this->getMenuSystem($this->project_code_menu);
            if (!empty($arrMenu)) {
                foreach ($arrMenu as $menu_id => $menu) {
                    if (isset($menu['show_menu']) && $menu['show_menu'] == STATUS_SHOW) {
                        $checkMenu = false;
                        if (isset($menu['sub']) && !empty($menu['sub'])) {
                            foreach ($menu['sub'] as $ks => $sub) {
                                if ($this->is_boss || (!empty($this->user_group_menu) && in_array($sub['menu_id'], $this->user_group_menu))) {
                                    $checkMenu = true;
                                }
                            }
                            if ($checkMenu) {
                                $this->menuSystem[$menu['menu_tab_top_id']][$menu_id] = $menu;
                            }
                        } else {
                            if ($this->is_boss || (!empty($this->user_group_menu) && in_array($menu['menu_id'], $this->user_group_menu))) {
                                $checkMenu = true;
                            }
                            if ($checkMenu) {
                                $this->menuSystem[$menu['menu_tab_top_id']][$menu['menu_id']] = $menu;
                            }
                        }
                    }
                }
            }

            $error = isset($_GET['error']) ? $_GET['error'] : STATUS_INT_KHONG;
            $msg = array();
            if ($error == ERROR_PERMISSION) {
                $msg[] = 'Bạn không có quyền truy cập';
                View::share('error', $msg);
            }

            if (isset($_GET['lang']) && (int)$_GET['lang'] > STATUS_INT_KHONG) {
                $get_lang = $_GET['lang'];
                $lang = (isset(CGlobal::$arrLanguage[$get_lang])) ? $get_lang : $this->languageSite;
                $request->session()->put('languageSite', $lang, CACHE_ONE_MONTH);
            }
            $this->languageSite = (Session::has('languageSite')) ? Session::get('languageSite') : $this->languageSite;
            $this->is_root = $this->is_boss ? $this->is_boss : $this->is_root;
            $this->is_tech = $this->is_boss ? $this->is_boss : $this->is_tech;

            View::share('languageSite', $this->languageSite);
            View::share('menu', isset($this->menuSystem[$this->tab_top]) ? $this->menuSystem[$this->tab_top] : []);
            View::share('aryPermissionMenu', $this->user_group_menu);

            View::share('is_root', $this->is_root);
            View::share('is_boss', $this->is_boss);
            View::share('is_tech', $this->is_tech);
            View::share('user_id', $this->user_id);
            View::share('user_name', $this->user_name);
            View::share('user', $this->user);

            View::share('arrMenuTabTop', CGlobal::$arrMenuTabTop);
            View::share('colorWithTab', CGlobal::$colorWithTab);
            View::share('user_tab_id', $this->user_tab_id);
            View::share('tab_top', $this->tab_top);
            View::share('project_code_menu', $this->project_code_menu);

            //permission action
            $this->permission_view = $this->checkPermiss(PERMISS_VIEW);
            $this->permission_add = $this->checkPermiss(PERMISS_ADD);
            $this->permission_edit = $this->checkPermiss(PERMISS_EDIT);
            $this->permission_remove = $this->checkPermiss(PERMISS_REMOVE);
            $this->permission_approve = $this->checkPermiss(PERMISS_APPROVE);
            View::share('permission_view', $this->permission_view);
            View::share('permission_add', $this->permission_add);
            View::share('permission_edit', $this->permission_edit);
            View::share('permission_remove', $this->permission_remove);
            View::share('permission_approve', $this->permission_approve);

            return $next($request);
        });
    }

    public function getInforUser($type = '')
    {
        $result = [];
        if (trim($type) != '') {
            switch (strtoupper($type)) {
                case 'ORG':
                    $result = isset($this->user['infor_system_user']['arrOrg']) ? $this->user['infor_system_user']['arrOrg'] : $result;
                    break;
                case 'PRODUCT':
                    $result = isset($this->user['infor_system_user']['arrProduct']) ? $this->user['infor_system_user']['arrProduct'] : $result;
                    break;
                case 'PACK':
                    $result = isset($this->user['infor_system_user']['arrPack']) ? $this->user['infor_system_user']['arrPack'] : $result;
                    break;
                default:
                    $result = isset($this->user['infor_system_user']) ? $this->user['infor_system_user']: $result;
                    break;
            }
        }
        return $result;
    }

    private function getProjectCodeByRouter()
    {
        $project_code = $project_code_new = Config::get('config.PROJECT_CODE');
        $pageCurrent = $this->getRouteNameAction();
        $allMenu = app(MenuSystem::class)->getAllMenuByProjectCode();
        foreach ($allMenu as $ky => $menu) {
            if ($menu->MENU_PATH == $pageCurrent) {
                $project_code_new = CGlobal::$projectMenuWithTabTop[trim($menu->PROJECT_CODE)];
                break;
            }
        }
        if (Config::get('config.IS_DEV')) {
            if ($pageCurrent != 'admin.dashboard') {
                Session::put(SESSION_PROJECT_MENU, $project_code_new, 60 * 24);
            } elseif (Session::has(SESSION_PROJECT_MENU)) {
                $project_code_new = Session::get(SESSION_PROJECT_MENU);
            }
            return $project_code_new;
        } else {
            if ($project_code != $project_code_new && $pageCurrent != 'admin.dashboard') {
                return $project_code_new;
            }
        }
        return $project_code;
    }

    private function getMenuCodeByProjectCode($projectCode = STATUS_INT_KHONG)
    {
        $menuCode = '';
        switch ($projectCode) {
            case CGlobal::dms_portal;
                $menuCode = MENU_HDI_OPEN_ID;
                CGlobal::$pageAdminTitle = 'HDI OpenID';
                break;
            case CGlobal::selling;
                $menuCode = MENU_HDI_SELLING;
                CGlobal::$pageAdminTitle = 'HDI Selling';
                break;
            default:
                break;
        }
        return $menuCode;
    }

    public function getArrOptionTypeDefine($define_code = '', $project_code = DEFINE_ALL)
    {
        return app(TypeDefine::class)->getOptionTypeDefine($define_code, $project_code);
    }

    public function getMenuSystem($type_menu = MENU_HDI_SELLING)
    {
        $menuTree = app(MenuSystem::class)->buildMenuAdmin($type_menu);
        return $menuTree;
    }

    public function getRouterNameSite()
    {
        $route_name = [];
        foreach (Route::getRoutes()->getRoutes() as $route) {
            $action = $route->getAction();
            if (array_key_exists('as', $action)) {
                $route_name[] = $action['as'];
            }
        }
        return $route_name;
    }

    //check router controller
    public function getControllerAction()
    {
        return substr(strrchr(Route::currentRouteAction(), '\\'), 1, strpos(strrchr(Route::currentRouteAction(), '\\'), '@') - 1);
    }

    //check router url
    public function getRouteNameAction()
    {
        return Route::currentRouteName();
    }

    /**
     * @param string $permiss
     * @return bool
     */
    public function checkPermiss($permiss = '')
    {
        if ($this->is_root) return true;
        $pageAction = $this->getRouteNameAction();
        return ($permiss != '') ? (in_array($pageAction, array_keys($this->permission)) && isset($this->permission[$pageAction][$permiss])) : false;
    }

    /**
     * @param array $arrPermiss
     * @return bool
     */
    public function checkMultiPermiss($arrPermiss = [])
    {
        if ($this->change_pass && isset($this->user['user_id'])) {
            Redirect::route('userSystem.userProfile', ['id' => setStrVar($this->user['user_id']), 'name' => safe_title($this->user['user_full_name'])])->send();
        }
        if ($this->is_root) return true;
        if (!$this->is_root) {
            if (!app(MenuSystem::class)->checkPageWithTab($this->getRouteNameAction(), $this->user_tab_id)) {
                return false;
            }
        }
        if (empty($arrPermiss)) return false;
        foreach ($arrPermiss as $permiss) {
            if ($this->checkPermiss($permiss)) {
                return true;
            }
        }
        return false;
    }
}