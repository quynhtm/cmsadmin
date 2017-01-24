<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class Province extends Eloquent
{
    protected $table = 'web_province';
    protected $primaryKey = 'province_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('province_id','province_name', 'province_position','province_status','province_area');

    public static function getAllProvince() {
        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_ALL_PROVINCE) : array();
        if (sizeof($data) == 0) {
            $shop = Province::where('province_id', '>', 0)->orderBy('province_position', 'asc')->get();
            foreach($shop as $itm) {
                $data[$itm['province_id']] = $itm['province_name'];
            }
            if(!empty($data) && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_ALL_PROVINCE, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $data;
    }
    
    public static function getByID($id) {
    	$result = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_PROVINCE_ID.$id) : array();
    	if (sizeof($result) == 0) {
    		$result = Province::where('province_id','=', $id)->first();
    		if($result && Memcache::CACHE_ON){
    			Cache::put(Memcache::CACHE_PROVINCE_ID.$id, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
    		}
    	}
    	return $result;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Province::where('province_id','>',0);
            if (isset($dataSearch['province_name']) && $dataSearch['province_name'] != '') {
                $query->where('province_name','LIKE', '%' . $dataSearch['province_name'] . '%');
            }
            if (isset($dataSearch['province_id']) && $dataSearch['province_id'] > 0) {
                $query->where('province_id', $dataSearch['province_id']);
            }
            if (isset($dataSearch['province_status']) && $dataSearch['province_status'] > -1) {
                $query->where('province_status', $dataSearch['province_status']);
            }

            $total = $query->count();
            $query->orderBy('province_position', 'asc');

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
            $data = new Province();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->province_id) && $data->province_id > 0){
                    self::removeCache($data->province_id);
                }
                return $data->province_id;
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
            $dataSave = Province::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
            }
            DB::connection()->getPdo()->commit();
            if(isset($dataSave->province_id) && $dataSave->province_id > 0){
                self::removeCache($dataSave->province_id);
            }
            return true;
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
            $dataSave = Province::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            if(isset($dataSave->province_id) && $dataSave->province_id > 0){
                self::removeCache($dataSave->province_id);
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
    public static function removeCache($id = 0){
        if($id > 0){
            Cache::forget(Memcache::CACHE_PROVINCE_ID.$id);
        }
        Cache::forget(Memcache::CACHE_ALL_PROVINCE);
    }

}