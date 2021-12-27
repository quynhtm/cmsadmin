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

    public function getBannerHeaderBig($partner = STATUS_INT_MOT){
        return app(Banner::class)->getBannerByType(Banner::bannerLeftBig,$partner);
    }
    public function getBannerHeaderSmall($partner = STATUS_INT_MOT){
        return app(Banner::class)->getBannerByType(Banner::bannerRightSmall,$partner);
    }
    public function getBannerContentProduct($partner = STATUS_INT_MOT){
        return app(Banner::class)->getBannerByType(Banner::bannerPageProduct,$partner);
    }

    public function getCategoryProduct($partner = STATUS_INT_MOT){
        return app(Category::class)->getSiteCategoryByType(Category::categoryTypeProduct,$partner);
    }
}

