<?php

namespace App\Http\Controllers;

use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class BaseSiteController extends Controller
{
    private $is_debug = false;

    public function __construct()
    {
        CGlobal::$is_debug = false;
    }

    public function header($action = STATUS_INT_KHONG)
    {
        $title_search = Request::get('title_search', '');
        $depart_search = (int)Request::get('depart_search', STATUS_INT_KHONG);

        $arrDepart = app(Department::class)->getMenuDepart();
        $dataCart = $this->countNumCart();

        //banner
        //$commonService = new ShopCuaTuiService();
        //$bannerBig = $commonService->getBannerAdvanced(STATUS_INT_MOT,STATUS_INT_MOT);
        $bannerBig = [
            //1=>['url'=>buildLinkProductWithDepart(1,'Hàng nhập khẩu Đức'),'title'=>'Hàng nhập khẩu Đức','image'=> \Illuminate\Support\Facades\Config::get('config.WEB_ROOT') .'/assets/frontend/shop/cuatui/bannerShop/Duc.jpeg'],
            //2=>['url'=>buildLinkProductWithDepart(8,'Hàng nhập khẩu Mỹ'),'title'=>'Hàng nhập khẩu Mỹ','image'=>\Illuminate\Support\Facades\Config::get('config.WEB_ROOT').'/assets/frontend/shop/cuatui/bannerShop/My.jpg'],
            //3=>['url'=>buildLinkProductWithDepart(3,'Hàng nhập khẩu Nga'),'title'=>'Hàng nhập khẩu Nga','image'=>\Illuminate\Support\Facades\Config::get('config.WEB_ROOT').'/assets/frontend/shop/cuatui/bannerShop/Nga.jpg'],
            //4=>['url'=>buildLinkProductWithDepart(6,'Hàng nhập khẩu Nhật'),'title'=>'Hàng nhập khẩu Nhật','image'=>\Illuminate\Support\Facades\Config::get('config.WEB_ROOT').'/assets/frontend/shop/cuatui/bannerShop/Nhat.jpg'],
            //5=>['url'=>'#','title'=>'Hàng nhập khẩu Nhật','image'=>\Illuminate\Support\Facades\Config::get('config.WEB_ROOT').'/assets/frontend/shop/cuatui/bannerShop/Nhat2.jpg'],
            //5=>['url'=>buildLinkProductWithDepart(4,'Hàng nhập khẩu Úc'),'title'=>'Hàng nhập khẩu Úc','image'=>\Illuminate\Support\Facades\Config::get('config.WEB_ROOT').'/assets/frontend/shop/cuatui/bannerShop/Uc.png'],
            //6=>['url'=>buildLinkProductWithDepart(4,'Hàng nhập khẩu Úc'),'title'=>'Hàng nhập khẩu Úc','image'=>\Illuminate\Support\Facades\Config::get('config.WEB_ROOT').'/assets/frontend/shop/cuatui/bannerShop/Uc2.jpg'],
            7 => ['url' => 'https://shp.ee/gtqm3kr', 'title' => 'Shoppe voucher', 'image' => \Illuminate\Support\Facades\Config::get('config.WEB_ROOT') . '/assets/frontend/shop/cuatui/bannerShop/shopee.jpg'],
        ];
        $key_banner = 7;
        //$key_banner = rand(1,6);
        //vmDebug($bannerBig);

        return View::make('site.SiteLayouts.header', [
            'action' => $action,
            'title_search' => $title_search,
            'depart_search' => $depart_search,
            'bannerBig' => $bannerBig[$key_banner],
            'arrDepart' => $arrDepart,
            'dataCart' => $dataCart['data'],
            'totalItemCart' => $dataCart['total_cart'],
            'totalMoneyCart' => $dataCart['total_money'],
        ]);
    }

    public function footer($action = STATUS_INT_KHONG)
    {
        return View::make('site.SiteLayouts.footer', [
            'action' => $action,
        ]);
    }

    public function countNumCart()
    {
        $dataCart = [];
        $total_cart = $total_money = 0;
        if (Session::has(SESSION_SHOP_CART)) {
            $dataCart = Session::get(SESSION_SHOP_CART);
            if(isset($dataCart['cartProducts'])){
                foreach ($dataCart['cartProducts'] as $pro => $v) {
                    if (isset($v['number']) && $v['number'] > 0) {
                        $total_cart += $v['number'];
                        $total_money += ($v['product_price_sell'] * $v['number']);
                    }
                }
            }
        }
        return ['data' => $dataCart, 'total_cart' => $total_cart, 'total_money' => $total_money];
    }

    public function page403()
    {
        echo '403';
    }

    public function page404()
    {
        echo '404';
    }
}
