<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class Districts extends Eloquent
{
    protected $table = 'web_districts';
    protected $primaryKey = 'district_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('district_id','district_name', 'district_status','district_province_id','district_position');

    public static function getDistrictByProvinceId($province_id) {
        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_DISTRICT_WITH_PROVINCE_ID.$province_id) : array();
        if (sizeof($data) == 0) {
            $district = Districts::where('district_id', '>', 0)
                ->where('district_province_id', '=',$province_id)
                ->where('district_status', '=',CGlobal::status_show)
                ->orderBy('district_position', 'asc')->get();
            foreach($district as $itm) {
                $data[$itm['district_id']] = $itm['district_name'];
            }
            if(!empty($data) && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_DISTRICT_WITH_PROVINCE_ID.$province_id, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $data;
    }

    public static function getInforDistrictWithProvinceId($province_id) {
        $district = array();
        if($province_id > 0){
            $district = Districts::where('district_id', '>', 0)
                ->where('district_province_id', '=',$province_id)
                ->orderBy('district_position', 'asc')->get();
        }
        return $district;
    }
    
    public static function getByID($id) {
    	$result = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_DISTRICT_ID.$id) : array();
    	if (sizeof($result) == 0) {
    		$result = Districts::where('district_id','=', $id)->first();
    		if($result && Memcache::CACHE_ON){
    			Cache::put(Memcache::CACHE_DISTRICT_ID.$id, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
    		}
    	}
    	return $result;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Districts::where('district_id','>',0);
            if (isset($dataSearch['district_name']) && $dataSearch['district_name'] != '') {
                $query->where('district_name','LIKE', '%' . $dataSearch['district_name'] . '%');
            }
            if (isset($dataSearch['district_id']) && $dataSearch['district_id'] > 0) {
                $query->where('district_id', $dataSearch['district_id']);
            }
            if (isset($dataSearch['district_city_id']) && $dataSearch['district_city_id'] > 0) {
                $query->where('district_city_id', $dataSearch['district_city_id']);
            }
            if (isset($dataSearch['district_status']) && $dataSearch['district_status'] > -1) {
                $query->where('district_status', $dataSearch['district_status']);
            }

            $total = $query->count();
            $query->orderBy('district_city_id', 'asc');

            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
            if(!empty($fields)){
                $result = $query->take($limit)->skip($offset)->get($fields);
            }else{
                $result = $query->take($limit)->skip($offset)->get();
            }
            return $result;

        }catch (PDOException $e){
            throw new PDOException();
        }
    }
    /**
     * @desc: Tao Data.
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static function addData($dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = new Districts();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->district_id) && $data->district_id > 0){
                    self::removeCache($data->district_id,$data->district_province_id);
                }
                return $data->district_id;
            }
            DB::connection()->getPdo()->commit();
            return false;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @desc: Update du lieu
     * @param $id
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static  function updateData($id, $dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Districts::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
            }
            DB::connection()->getPdo()->commit();
            if(isset($dataSave->district_id) && $dataSave->district_id > 0){
                self::removeCache($dataSave->district_id,$dataSave->district_province_id);
            }
            return $dataSave->district_id;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }


    /**
     * @desc: Update Data.
     * @param $id
     * @param $status
     * @return bool
     * @throws PDOException
     */
    public static function deleteData($id){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Districts::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            if(isset($dataSave->district_id) && $dataSave->district_id > 0){
                self::removeCache($dataSave->district_id,$dataSave->district_province_id);
            }
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @param int $id
     */
    public static function removeCache($id = 0,$province_id = 0){
        if($id > 0){
            Cache::forget(Memcache::CACHE_DISTRICT_ID.$id);
        }
        Cache::forget(Memcache::CACHE_DISTRICT_WITH_PROVINCE_ID.$province_id);
    }

}