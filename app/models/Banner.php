<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class Banner extends Eloquent
{
    protected $table = 'w_banner';
    protected $primaryKey = 'banner_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('banner_id','banner_name','banner_intro', 'banner_link',
        'banner_image', 'banner_image_temp', 'type_language',
        'banner_is_target', 'banner_is_rel', 'banner_type',
        //'banner_position','banner_parent_id',
        'banner_order',//thứ tụ hiển thị
        'banner_page',// thuoc page nao
        //'banner_province_id',//tỉnh thành
        'banner_category_id', //danh mục
        'banner_status', 'banner_is_run_time','banner_start_time','banner_end_time',
        'banner_time_click', 'banner_update_time', 'banner_create_time');

    public static function getBannerAdvanced($banner_type = 0, $lang = 0, $banner_category_id=0){
        $key_cache = Memcache::CACHE_BANNER_ADVANCED.'_'.$banner_type.'_'.$lang.'_'.$banner_category_id;
        $bannerAdvanced = (Memcache::CACHE_ON)? Cache::get($key_cache) : array();
        if (sizeof($bannerAdvanced) == 0) {
            $banner = Banner::where('banner_id' ,'>', 0);
            $banner->where('banner_status',CGlobal::status_show);
            $banner->where('banner_type',$banner_type);
            $banner->where('banner_category_id', $banner_category_id);
            if($lang > 0){
               $banner->where('type_language', $lang);
            }
           $result = $banner->orderBy('banner_order','asc')->orderBy('banner_order','asc')->get();
            if($result){
                foreach($result as $itm) {
                    $bannerAdvanced[$itm['banner_id']] = $itm;
                }
            }
            if($bannerAdvanced && Memcache::CACHE_ON){
                Cache::put($key_cache, $bannerAdvanced, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $bannerAdvanced;
    }
	
    public static function getBannerByID($id) {
        $new = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_BANNER_ID.$id) : array();
        if (sizeof($new) == 0) {
            $new = Banner::where('banner_id', $id)->first();
            if($new && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_BANNER_ID.$id, $new, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $new;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Banner::where('banner_id','>',0);
            if (isset($dataSearch['banner_name']) && $dataSearch['banner_name'] != '') {
                $query->where('banner_name','LIKE', '%' . $dataSearch['banner_name'] . '%');
            }
            if (isset($dataSearch['banner_status']) && $dataSearch['banner_status'] != -1) {
                $query->where('banner_status', $dataSearch['banner_status']);
            }
            if (isset($dataSearch['type_language']) && $dataSearch['type_language'] > 0) {
                $query->where('type_language', $dataSearch['type_language']);
            }
            if (isset($dataSearch['banner_category_id']) && $dataSearch['banner_category_id'] > 0) {
                $query->where('banner_category_id', $dataSearch['banner_category_id']);
            }

            $total = $query->count();
            $query->orderBy('banner_id', 'desc');

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
            $data = new Banner();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->banner_id) && $data->banner_id > 0){
                    //x�a cache banner show
                    $key_cache = Memcache::CACHE_BANNER_ADVANCED.'_'.$data->banner_type.'_'.$data->banner_page.'_'.$data->banner_category_id.'_'.$data->banner_province_id;
                    Cache::forget($key_cache);
                    self::removeCache($data->banner_id);
                    self::removeCacheLang($data->banner_type, $data->type_language, $data->banner_category_id);
                }
                return $data->banner_id;
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
            $dataSave = Banner::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
                if(isset($dataSave->banner_id) && $dataSave->banner_id > 0){
                    //x�a cache banner show
                    $key_cache = Memcache::CACHE_BANNER_ADVANCED.'_'.$dataSave->banner_type.'_'.$dataSave->banner_page.'_'.$dataSave->banner_category_id.'_'.$dataSave->banner_province_id;
                    Cache::forget($key_cache);
                    self::removeCache($dataSave->banner_id);
                    self::removeCacheLang($dataSave->banner_type, $dataSave->type_language, $dataSave->banner_category_id);
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
            $dataSave = Banner::find($id);
            $dataSave->delete();
            if(isset($dataSave->banner_id) && $dataSave->banner_id > 0){
                if($dataSave->banner_image != ''){//xoa anh c?
                    //xoa anh upload
                    FunctionLib::deleteFileUpload($dataSave->banner_image,$dataSave->banner_id,CGlobal::FOLDER_BANNER);
                    //xoa anh thumb
                    $arrSizeThumb = CGlobal::$arrBannerSizeImage;
                    foreach($arrSizeThumb as $k=>$size){
                        $sizeThumb = $size['w'].'x'.$size['h'];
                        FunctionLib::deleteFileThumb($dataSave->banner_image,$dataSave->banner_id,CGlobal::FOLDER_BANNER,$sizeThumb);
                    }
                }
                //x�a cache banner show
                $key_cache = Memcache::CACHE_BANNER_ADVANCED.'_'.$dataSave->banner_type.'_'.$dataSave->banner_page.'_'.$dataSave->banner_category_id.'_'.$dataSave->banner_province_id;
                Cache::forget($key_cache);
                self::removeCache($dataSave->banner_id);
                self::removeCacheLang($dataSave->banner_type, $dataSave->type_language, $dataSave->banner_category_id);
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
            Cache::forget(Memcache::CACHE_BANNER_ID.$id);
        }
    }
    public static function removeCacheLang($banner_type=0, $banner_lang=0, $banner_category_id=0){
    	if($banner_type > 0 && $banner_lang > 0){
    		Cache::forget(Memcache::CACHE_BANNER_ADVANCED.'_'.$banner_type.'_'.$banner_lang.'_'.$banner_category_id);
    	}
    }
}