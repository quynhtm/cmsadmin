<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 13/03/2020
* @Version   : 1.0
*/

namespace App\Services;

use App\Models\OpenId\UserSystem;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Curl;
use App\Library\AdminFunction\Memcache;
use App\Models\Web\Partner;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class ServiceCommon
{
    public function getOptionPartner(){
        return app(Partner::class)->getOptionPartner();
    }

}

