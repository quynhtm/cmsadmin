<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 13/03/2020
* @Version   : 1.0
*/

namespace App\Services;

use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Curl;
use App\Library\AdminFunction\Memcache;
use App\Models\Shop\Products;
use App\Models\Web\Banner;
use App\Models\Web\Category;
use App\Models\Web\Partner;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class ServiceCommon
{
    public function getOptionPartner(){
        return app(Partner::class)->getOptionPartner();
    }

    public function getSiteBannerHeaderBig($partner = STATUS_INT_MOT){
        return app(Banner::class)->getBannerByType(Banner::bannerLeftBig,$partner);
    }
    public function getSiteBannerHeaderSmall($partner = STATUS_INT_MOT){
        return app(Banner::class)->getBannerByType(Banner::bannerRightSmall,$partner);
    }
    public function getSiteBannerContentProduct($partner = STATUS_INT_MOT){
        return app(Banner::class)->getBannerByType(Banner::bannerPageContent,$partner);
    }

    public function getSiteCategoryProduct($partner = STATUS_INT_MOT){
        return app(Category::class)->getSiteCategoryByType(Category::categoryTypeProduct,$partner);
    }

    public function getSiteProduct($product_is_hot = Products::productTypeNew, $limit = CGlobal::number_show_10,$partner = STATUS_INT_MOT){
        $offset = STATUS_INT_KHONG;
        $search['limit'] = $limit;
        $search['product_status'] = STATUS_INT_AM_MOT;
        $search['product_is_hot'] = $product_is_hot;
        $search['partner_id'] = $partner;
        $search['p_keyword'] = trim(addslashes(Request::get('p_keyword', '')));

        $result = app(Products::class)->searchByCondition($search, $limit, $offset);
        return $result['data'] ?? [];
    }
}

