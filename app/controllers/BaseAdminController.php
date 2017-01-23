<?php
class BaseAdminController extends BaseController
{
    protected $layout = 'admin.AdminLayouts.index';
    protected $permission = array();
    protected $user = array();
    protected $is_boss = false;
    protected $is_root = false;
    protected $supper_admin = false;

    public function __construct()
    {
    	FunctionLib::link_css('lib/jAlert/jquery.alerts.css', CGlobal::$POS_HEAD);
    	FunctionLib::link_js('lib/jAlert/jquery.alerts.js', CGlobal::$POS_END);
    	
    	if (!User::isLogin()) {
            Redirect::route('admin.login',array('url'=>self::buildUrlEncode(URL::current())))->send();
        }

        $this->user = User::user_login();
        if($this->user && sizeof($this->user['user_permission']) > 0){
            $this->permission = $this->user['user_permission'];
        }
        ///admin
        if(in_array('is_boss',$this->permission)){
            $this->is_boss = true;
        }
        //quan tri vien
        if(in_array('supper_admin',$this->permission)){
            $this->supper_admin = true;
        }

        $this->is_root = ($this->supper_admin == true) ?$this->supper_admin: $this->is_boss;
        $menu = $this->menu();
        View::share('menu',$menu);
        View::share('aryPermission',$this->permission);
        View::share('user',$this->user);

        View::share('is_boss',$this->is_boss);
        View::share('is_root',$this->is_root);
        View::share('supper_admin',$this->supper_admin);
    }

    public function menu(){
        //user Admin
        $menu[] = array(
            'name'=>'QL user Admin',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-user',
            'arr_link_sub'=>array('admin.user_view','admin.permission_view','admin.groupUser_view',),//dung de check menu left action
            'sub'=>array(
                array('name'=>'User Admin', 'RouteName'=>'admin.user_view', 'icon'=>'fa fa-user icon-4x', 'showcontent'=>1, 'showMenu'=>1, 'permission'=>'user_view'),
                array('name'=>'Danh sách quyền', 'RouteName'=>'admin.permission_view', 'icon'=>'fa fa-user icon-4x', 'showcontent'=>0,'showMenu'=>0, 'permission'=>'root'),
                array('name'=>'Danh sách nhóm quyền', 'RouteName'=>'admin.groupUser_view', 'icon'=>'fa fa-user icon-4x', 'showcontent'=>0,'showMenu'=>0, 'permission'=>'root'),
            ),
        );

        //hệ thống site
        $menu[] = array(
            'name'=>'QL thông tin site',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-cogs',
            'arr_link_sub'=>array('admin.info','admin.contract','admin.category_list'),
            'sub'=>array(
                array('name'=>'Danh mục', 'RouteName'=>'admin.category_list', 'icon'=>'fa fa-indent icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'category_full'),
                array('name'=>'Thông tin site', 'RouteName'=>'admin.info', 'icon'=>'fa fa-cogs icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'infor_full'),
            	array('name'=>'Language static', 'RouteName'=>'admin.lang', 'icon'=>'fa fa-language icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'infor_full'),
            ),
        );

        //danh mục
        $menu[] = array(
            'name'=>'QL danh mục',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-indent',
            'arr_link_sub'=>array('admin.info','admin.contract','admin.category_list'),
            'sub'=>array(
                array('name'=>'Danh mục', 'RouteName'=>'admin.category_list', 'icon'=>'fa fa-indent icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'category_full'),
                array('name'=>'Thông tin site', 'RouteName'=>'admin.info', 'icon'=>'fa fa-cogs icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'infor_full'),
            	array('name'=>'Language static', 'RouteName'=>'admin.lang', 'icon'=>'fa fa-language icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'infor_full'),
            ),
        );

        //nội dung
        $menu[] = array(
            'name'=>'QL nội dung',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-book',
            'arr_link_sub'=>array('admin.newsView','admin.bannerView','admin.videoView','admin.libraryImageView',),
            'sub'=>array(
                array('name'=>'Tin tức', 'RouteName'=>'admin.newsView', 'icon'=>'fa fa-book icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'news_full'),
                array('name'=>'Quảng cáo', 'RouteName'=>'admin.bannerView', 'icon'=>'fa fa-globe icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'banner_full'),
                array('name'=>'Video', 'RouteName'=>'admin.videoView', 'icon'=>'fa fa-video-camera icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'video_full'),
                array('name'=>'Thư viện ảnh', 'RouteName'=>'admin.libraryImageView', 'icon'=>'fa fa-picture-o icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'libraryImage_full'),
            ),
        );

        //Sản phẩm
        /*$menu[] = array(
            'name'=>'QL Sản phẩm',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-gift',
            'arr_link_sub'=>array('admin.newsView','admin.bannerView','admin.videoView','admin.libraryImageView',),
            'sub'=>array(
                array('name'=>'Tin tức', 'RouteName'=>'admin.newsView', 'icon'=>'fa fa-book icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'news_full'),
                array('name'=>'Quảng cáo', 'RouteName'=>'admin.bannerView', 'icon'=>'fa fa-globe icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'banner_full'),
                array('name'=>'Video', 'RouteName'=>'admin.videoView', 'icon'=>'fa fa-video-camera icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'video_full'),
                array('name'=>'Thư viện ảnh', 'RouteName'=>'admin.libraryImageView', 'icon'=>'fa fa-picture-o icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'libraryImage_full'),
            ),
        );*/

        //Đơn hàng
        /*$menu[] = array(
            'name'=>'QL bán hàng',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-shopping-cart',
            'arr_link_sub'=>array('admin.newsView','admin.bannerView','admin.videoView','admin.libraryImageView',),
            'sub'=>array(
                array('name'=>'Tin tức', 'RouteName'=>'admin.newsView', 'icon'=>'fa fa-book icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'news_full'),
                array('name'=>'Quảng cáo', 'RouteName'=>'admin.bannerView', 'icon'=>'fa fa-globe icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'banner_full'),
                array('name'=>'Video', 'RouteName'=>'admin.videoView', 'icon'=>'fa fa-video-camera icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'video_full'),
                array('name'=>'Thư viện ảnh', 'RouteName'=>'admin.libraryImageView', 'icon'=>'fa fa-picture-o icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'libraryImage_full'),
            ),
        );*/
        return $menu;
    }

    public function getControllerAction(){
        return $routerName = Route::currentRouteName();
    }
}