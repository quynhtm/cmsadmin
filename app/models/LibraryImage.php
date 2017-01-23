<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class LibraryImage extends Eloquent
{
    protected $table = 'w_images';
    protected $primaryKey = 'image_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('image_id','image_title','image_title_alias', 'image_desc_sort',
        'image_content', 'image_image', 'image_image_other',
        'image_category', 'image_status', 'image_hot',
        'image_meta_keyword','banner_parent_id','image_create',
        'type_language','image_meta_description','image_meta_title');

    public static function getById($id) {
        $new = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_IMAGE_ID.$id) : array();
        if (sizeof($new) == 0) {
            $new = LibraryImage::where('image_id', $id)->first();
            if($new && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_IMAGE_ID.$id, $new, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $new;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = LibraryImage::where('image_id','>',0);
            if (isset($dataSearch['image_title']) && $dataSearch['image_title'] != '') {
                $query->where('image_title','LIKE', '%' . $dataSearch['image_title'] . '%');
            }
            if (isset($dataSearch['image_status']) && $dataSearch['image_status'] != -1) {
                $query->where('image_status', $dataSearch['image_status']);
            }
            if (isset($dataSearch['type_language']) && $dataSearch['type_language'] > 0) {
                $query->where('type_language', $dataSearch['type_language']);
            }
            $total = $query->count();
            $query->orderBy('image_id', 'desc');

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
            $data = new LibraryImage();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->image_id) && $data->image_id > 0){
                    self::removeCache($data->image_id);
                }
                return $data->image_id;
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
            $dataSave = LibraryImage::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
                if(isset($dataSave->image_id) && $dataSave->image_id > 0){
                    //x�a cache banner show
                    $key_cache = Memcache::CACHE_BANNER_ADVANCED.'_'.$dataSave->banner_type.'_'.$dataSave->banner_page.'_'.$dataSave->banner_category_id.'_'.$dataSave->banner_province_id;
                    Cache::forget($key_cache);
                    self::removeCache($dataSave->image_id);
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
            $dataSave = LibraryImage::find($id);
            $dataSave->delete();
            if(isset($dataSave->image_id) && $dataSave->image_id > 0){
                if($dataSave->image_image != ''){//xoa anh c?
                    //xoa anh upload
                    FunctionLib::deleteFileUpload($dataSave->image_image,$dataSave->image_id,CGlobal::FOLDER_LIBRARY_IMAGE);
                    //x�a anh thumb
                    $arrSizeThumb = CGlobal::$arrSizeImage;
                    foreach($arrSizeThumb as $k=>$size){
                        $sizeThumb = $size['w'].'x'.$size['h'];
                        FunctionLib::deleteFileThumb($dataSave->image_image,$dataSave->image_id,CGlobal::FOLDER_LIBRARY_IMAGE,$sizeThumb);
                    }
                }
                //xóa ảnh khác
                if(!empty($dataSave->image_image_other)){
                    $arrImagOther = unserialize($dataSave->image_image_other);
                    if(sizeof($arrImagOther) > 0){
                        foreach($arrImagOther as $k=>$val){
                            //xoa anh upload
                            FunctionLib::deleteFileUpload($val,$id,CGlobal::FOLDER_LIBRARY_IMAGE);
                            //x�a anh thumb
                            $arrSizeThumb = CGlobal::$arrSizeImage;
                            foreach($arrSizeThumb as $k=>$size){
                                $sizeThumb = $size['w'].'x'.$size['h'];
                                FunctionLib::deleteFileThumb($val,$id,CGlobal::FOLDER_LIBRARY_IMAGE,$sizeThumb);
                            }

                        }
                    }
                }
                self::removeCache($dataSave->image_id);
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
            Cache::forget(Memcache::CACHE_IMAGE_ID.$id);
        }
    }
    
    public static function getSameNews($dataField='', $id=0, $limit=10, $lang){
    	try{
    		$result = array();
    
    		if($id>0 && $limit>0){
    			$query = LibraryImage::where('image_id','<>', $id);
    			$query->where('image_status', CGlobal::status_show);
    			if($lang > 0){
    				$query->where('type_language', $lang);
    			}
    			$query->orderBy('image_id', 'desc');
    			 
    			$fields = (isset($dataField['field_get']) && trim($dataField['field_get']) != '') ? explode(',',trim($dataField['field_get'])): array();
    			if(!empty($fields)){
    				$result = $query->take($limit)->get($fields);
    			}else{
    				$result = $query->take($limit)->get();
    			}
    		}
    		return $result;
    
    	}catch (PDOException $e){
    		throw new PDOException();
    	}
    }
    
    public static function getNewImages($dataField='', $limit=10, $lang){
    	try{
    		$result = array();
    
    		if($limit>0){
    			$query = LibraryImage::where('image_status', CGlobal::status_show);
    			if($lang > 0){
    				$query->where('type_language', $lang);
    			}
    			$query->orderBy('image_id', 'desc');
    
    			$fields = (isset($dataField['field_get']) && trim($dataField['field_get']) != '') ? explode(',',trim($dataField['field_get'])): array();
    			if(!empty($fields)){
    				$result = $query->take($limit)->get($fields);
    			}else{
    				$result = $query->take($limit)->get();
    			}
    		}
    		return $result;
    
    	}catch (PDOException $e){
    		throw new PDOException();
    	}
    }
}