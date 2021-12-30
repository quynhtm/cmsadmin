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
use App\Models\Web\News;
use App\Models\Web\Partner;
use App\Models\Web\Reviews;
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
    public function getSiteCategoryNew($partner = STATUS_INT_MOT){
        return app(Category::class)->getSiteCategoryByType(Category::categoryTypeNew,$partner);
    }

    public function getSiteProduct($product_is_hot = Products::productTypeNew, $limit = CGlobal::number_show_10,$partner = STATUS_INT_MOT){
        $offset = STATUS_INT_KHONG;
        $search['limit'] = $limit;
        $search['product_status'] = STATUS_INT_MOT;
        $search['product_is_hot'] = $product_is_hot;
        $search['partner_id'] = $partner;

        $result = app(Products::class)->searchByCondition($search, $limit, $offset);
        return $result['data'] ?? [];
    }

    public function getSiteNew($news_type = News::newsTypeCommon, $limit = CGlobal::number_show_4, $partner = STATUS_INT_MOT){
        $offset = STATUS_INT_KHONG;
        $search['limit'] = $limit;
        $search['news_status'] = STATUS_INT_MOT;
        $search['news_type'] = $news_type;
        $search['partner_id'] = $partner;

        $result = app(News::class)->searchByCondition($search, $limit, $offset);
        return $result['data'] ?? [];
    }

    public function getSiteCommentNew($object_id = 0, $limit = CGlobal::number_show_8, $partner = STATUS_INT_MOT){
        $offset = STATUS_INT_KHONG;
        $search['limit'] = $limit;
        $search['is_active'] = STATUS_INT_MOT;
        $search['object_id'] = $object_id;
        $search['type_review'] = Reviews::typeReviewNew;
        $search['partner_id'] = $partner;

        $result = app(Reviews::class)->searchByCondition($search, $limit, $offset);
        return $result['data'] ?? [];
    }
    public function getSeoSite($img = '', $meta_title = '', $meta_keywords = '', $meta_description = '', $url = '')
    {
        if ($img == '') {
            $img = Config::get('config.WEB_ROOT') . 'assets/frontend/shop/img/shopcuatui.png';
        }
        if ($meta_title == '') {
            $meta_title = env('PROJECT_NAME') . '-' . CGlobal::meta_title;
        }
        if ($meta_keywords == '') {
            $meta_keywords = env('PROJECT_NAME') . '-' . CGlobal::meta_keywords;
        }
        if ($meta_description == '') {
            $meta_description = env('PROJECT_NAME') . '-' . CGlobal::meta_description;
        }

        $str = '';
        $str .= '<title>' . $meta_title . '</title>';
        $str .= "\n" . '<meta name="robots" content="index,follow">';
        $str .= "\n" . '<meta http-equiv="REFRESH" content="1800">';
        $str .= "\n" . '<meta name="revisit-after" content="days">';
        $str .= "\n" . '<meta http-equiv="content-language" content="vi"/>';
        $str .= "\n" . '<meta name="copyright" content="' . CGlobal::site_name . '">';
        $str .= "\n" . '<meta name="author" content="' . CGlobal::site_name . '">';

        //Google
        $str .= "\n" . '<meta name="keywords" content="' . $meta_keywords . '">';
        $str .= "\n" . '<meta name="description" content="' . $meta_description . '">';

        //Facebook
        $str .= "\n" . '<meta property="og:type" content="article" >';
        $str .= "\n" . '<meta property="og:title" content="' . $meta_title . '" >';
        $str .= "\n" . '<meta property="og:description" content="' . $meta_description . '" >';
        $str .= "\n" . '<meta property="og:site_name" content="' . CGlobal::site_name . '" >';
        $str .= "\n" . '<meta itemprop="thumbnailUrl" property="og:image" content="' . $img . '" >';

        //Twitter
        $str .= "\n" . '<meta name="twitter:title" content="' . $meta_title . '">';
        $str .= "\n" . '<meta name="twitter:description" content="' . $meta_description . '">';
        $str .= "\n" . '<meta name="twitter:image" content="' . $img . '">';

        $url = (trim($url) == '') ? buildLinkHome() : $url;
        if ($url != '') {
            $str .= "\n" . '<link rel="canonical" href="' . $url . '">';
            $str .= "\n" . '<meta property="og:url" itemprop="url" content="' . $url . '">';
            $str .= "\n" . '<meta name="twitter:url" content="' . $url . '">';
        }
        CGlobal::$extraMeta = $str;
    }
}

