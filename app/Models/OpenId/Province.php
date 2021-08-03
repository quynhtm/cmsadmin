<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenId;

use App\Library\AdminFunction\Memcache;
use App\Services\ModelService;
use Illuminate\Support\Facades\Config;

class Province extends ModelService
{
    public $table = TABLE_SYS_PROVINCES;
    public $table_d = TABLE_SYS_DISTRICTS;
    public $table_w = TABLE_SYS_WARDS;

    public function getAllProvinceDistrictWard()
    {
        try {
            $data = Memcache::getCache(Memcache::CACHE_PROVINCE_DISTRICT_WARD_ALL);
            if (!$data) {
                $requestDefault = $this->dataRequestDefault;
                $search = $this->searchAllDataResponce($requestDefault, ACTION_SEARCH_PROVINCE_DISTRICT_WARD_ALL);
                if ($search) {
                    if (isset($search['Success']) && $search['Success'] == STATUS_INT_MOT) {
                        $data = isset($search['Data']) ? $search['Data'] : false;
                    }
                    if($data){
                        Memcache::putCache(Memcache::CACHE_PROVINCE_DISTRICT_WARD_ALL, $data);
                    }
                }
            }
            return $data;
        } catch (\PDOException $e) {
            return returnError($e->getMessage());
        }
    }

    public function getOptionProvince()
    {
        $option = [];
        $dataAll = $this->getAllProvinceDistrictWard();
        if (isset($dataAll[0]) && !empty($dataAll[0])) {
            foreach ($dataAll[0] as $k => $val) {
                $option[$val->PROVINCE_CODE] = $val->PROVINCE_NAME;
            }
        }
        return $option;
    }

    public function getOptionDistrict($province_code = 0)
    {
        $option = [];
        $dataAll = $this->getAllProvinceDistrictWard();
        if (isset($dataAll[1]) && !empty($dataAll[1])) {
            foreach ($dataAll[1] as $k => $val) {
                if($province_code == 0){
                    $option[$val->DISTRICT_CODE] = $val->DISTRICT_NAME;
                }elseif ($province_code == $val->PROVINCE_CODE){
                    $option[$val->DISTRICT_CODE] = $val->DISTRICT_NAME;
                }
            }
        }
        return $option;
    }

    public function getOptionWard($district_code = 0)
    {
        $option = [];
        $dataAll = $this->getAllProvinceDistrictWard();
        if (isset($dataAll[2]) && !empty($dataAll[2])) {
            foreach ($dataAll[2] as $k => $val) {
                if($district_code == 0){
                    $option[$val->WARD_CODE] = $val->WARD_NAME;
                }elseif ($district_code == $val->DISTRICT_CODE){
                    $option[$val->WARD_CODE] = $val->WARD_NAME;
                }
            }
        }
        return $option;
    }
}
