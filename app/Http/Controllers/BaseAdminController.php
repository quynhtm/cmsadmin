<?php
/*
* @Created by: QuynhTM
* @Author    : QuynhTM
* @Date      : 01/2018
* @Version   : 1.0
*/

namespace App\Http\Controllers;

use App\Models\BackendCms\DefineSystem;
use App\Library\AdminFunction\CGlobal;
use App\Services\ServiceCommon;
use Illuminate\Support\Facades\Redirect;
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

    protected $arrPartner = array();
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

    protected $permission_full = false;
    protected $permission_view = false;
    protected $permission_add = false;
    protected $permission_edit = false;
    protected $permission_remove = false;
    protected $permission_approve = false;
    protected $permission_create_order = false;
    protected $permission_inspection = false;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!app('App\Models\BackendCms\Users')->isLogin()) {
                $url_encode = self::buildUrlEncode(URL::current());
                if ($request->ajax()) {
                    return Response::json(returnErrorSession());
                } else {
                    Redirect::route('backend.login', array('url' => $url_encode))->send();
                }
            }

            $this->tab_top = CGlobal::dms_portal;
            $this->project_code_menu = CGlobal::dms_portal;
            $this->user = app('App\Models\BackendCms\Users')->userLogin();

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
            $this->menuSystem = isset($this->user['user_tree_menu']) ? $this->user['user_tree_menu'] : [];

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
            ///View::share('menu', isset($this->menuSystem[$this->tab_top]) ? $this->menuSystem[$this->tab_top] : []);
            View::share('menu', $this->menuSystem);
            View::share('aryPermissionMenu', $this->user_group_menu);

            View::share('is_root', $this->is_root);
            View::share('is_boss', $this->is_boss);
            View::share('is_tech', $this->is_tech);
            View::share('user_id', $this->user_id);
            View::share('user_name', $this->user_name);
            View::share('user', $this->user);

            $this->arrPartner = app(ServiceCommon::class)->getOptionPartner();
            View::share('arrPartner', $this->arrPartner);

            View::share('arrMenuTabTop', CGlobal::$arrMenuTabTop);
            View::share('colorWithTab', CGlobal::$colorWithTab);
            View::share('user_tab_id', $this->user_tab_id);
            View::share('tab_top', $this->tab_top);
            View::share('project_code_menu', $this->project_code_menu);

            $this->shareListPermission();
            return $next($request);
        });
    }

    public function shareListPermission($pageCurrent = '')
    {
        //permission action
        $this->permission_full = $this->checkPermiss(PERMISS_FULL, $pageCurrent);
        $this->permission_view = $this->checkPermiss(PERMISS_VIEW, $pageCurrent);
        $this->permission_add = $this->checkPermiss(PERMISS_ADD, $pageCurrent);
        $this->permission_edit = $this->checkPermiss(PERMISS_EDIT, $pageCurrent);
        $this->permission_remove = $this->checkPermiss(PERMISS_REMOVE, $pageCurrent);
        $this->permission_approve = $this->checkPermiss(PERMISS_APPROVE, $pageCurrent);//duyệt

        View::share('permission_full', $this->permission_full);
        View::share('permission_view', $this->permission_view);
        View::share('permission_add', $this->permission_add);
        View::share('permission_edit', $this->permission_edit);
        View::share('permission_remove', $this->permission_remove);
        View::share('permission_approve', $this->permission_approve);

    }

    public function getArrOptionTypeDefine($define_code = '', $project_code = DEFINE_ALL, $language = DEFINE_LANGUAGE_VN)
    {
        return app(DefineSystem::class)->getOptionTypeDefine($define_code, $project_code, $language);
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
    public function checkPermiss($permiss = '', $pageCurrent = '')
    {
        if ($this->is_root) return true;
        $pageAction = (trim($pageCurrent) != '') ? $pageCurrent : $this->getRouteNameAction();
        return ($permiss != '') ? (in_array($pageAction, array_keys($this->permission)) && isset($this->permission[$pageAction][$permiss])) : false;
    }

    /**
     * @param array $arrPermiss
     * @return bool
     */
    public function checkMultiPermiss($arrPermiss = [], $pageCurrent = '')
    {
        /*if ($this->change_pass && isset($this->user['user_id'])) {
            Redirect::route('userSystem.userProfile', ['id' => setStrVar($this->user['user_id']), 'name' => safe_title($this->user['user_full_name'])])->send();
        }*/
        if (trim($pageCurrent) != '') {
            $this->shareListPermission($pageCurrent);
        }
        if ($this->is_root) return true;
        if (!$this->is_root) {
            if (!app(MenuSystem::class)->checkPageWithTab($this->getRouteNameAction(), $this->user_tab_id)) {
                return false;
            }
        }
        if (empty($arrPermiss)) return false;
        foreach ($arrPermiss as $permiss) {
            if ($this->checkPermiss($permiss, $pageCurrent)) {
                return true;
            }
        }
        return false;
    }
}
