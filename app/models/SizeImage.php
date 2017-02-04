<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class SizeImage extends Eloquent
{
    protected $table = 'cms_size_image';
    protected $primaryKey = 'size_img_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('size_img_id','size_img_name','size_img_width', 'size_img_height','size_img_status');

    public static function getSizeImage(){
        $key_cache = Memcache::CACHE_SIZE_IMAGE;
        $data = (Memcache::CACHE_ON)? Cache::get($key_cache) : array();
        if (sizeof($data) == 0) {
            $search = SizeImage::where('size_img_id' ,'>', 0);
            $search->where('size_img_status',CGlobal::status_show);
            $result = $search->orderBy('size_img_id','desc')->get();
            if($result){
                foreach($result as $itm) {
                    $key = $itm->size_img_width.'x'.$itm->size_img_height;
                    $data[$key]['w'] = $itm->size_img_width;
                    $data[$key]['h'] = $itm->size_img_height;
                }
            }
            if($data && Memcache::CACHE_ON){
                Cache::put($key_cache, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $data;
    }
	
    public static function getByID($id) {
        $new = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_SIZE_IMAGE_ID.$id) : array();
        if (sizeof($new) == 0) {
            $new = SizeImage::where('size_img_id', $id)->first();
            if($new && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_SIZE_IMAGE_ID.$id, $new, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $new;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = SizeImage::where('size_img_id','>',0);
            if (isset($dataSearch['size_img_name']) && $dataSearch['size_img_name'] != '') {
                $query->where('size_img_name','LIKE', '%' . $dataSearch['size_img_name'] . '%');
            }
            if (isset($dataSearch['size_img_status']) && $dataSearch['size_img_status'] != -1) {
                $query->where('size_img_status', $dataSearch['size_img_status']);
            }

            $total = $query->count();
            $query->orderBy('size_img_id', 'desc');

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
            $data = new SizeImage();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->size_img_id) && $data->size_img_id > 0){
                    self::removeCache($data->size_img_id);
                }
                return $data->size_img_id;
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
            $dataSave = SizeImage::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
                if(isset($dataSave->size_img_id) && $dataSave->size_img_id > 0){
                    self::removeCache($dataSave->size_img_id);
                }
            }
            DB::connection()->getPdo()->commit();
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
            $dataSave = SizeImage::find($id);
            $dataSave->delete();
            if(isset($dataSave->size_img_id) && $dataSave->size_img_id > 0){
                self::removeCache($dataSave->size_img_id);
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function removeCache($id = 0){
        if($id > 0){
            Cache::forget(Memcache::CACHE_SIZE_IMAGE_ID.$id);
            Cache::forget(Memcache::CACHE_SIZE_IMAGE);
        }
    }
}