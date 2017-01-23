<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/
use Illuminate\Cache\MemcachedStore;

class Info extends Eloquent {
    
    protected $table = 'w_info';
    protected $primaryKey = 'info_id';
    public  $timestamps = false;

    protected $fillable = array(
	    		'info_id', 'info_title', 'info_type','type_language', 'info_keyword', 'info_intro', 'info_content',
	    		'info_img', 'info_created', 'info_order_no', 'info_status', 'meta_title', 'meta_keywords', 'meta_description');
	//ADMIN
    public static function searchByCondition($dataSearch=array(), $limit=0, $offset=0, &$total){
    	try{
    	  
    		$query = Info::where('info_id','>',0);
    	  
    		if (isset($dataSearch['info_title']) && $dataSearch['info_title'] != '') {
    			$query->where('info_title','LIKE', '%' . $dataSearch['info_title'] . '%');
    		}
    		if (isset($dataSearch['info_status']) && $dataSearch['info_status'] != -1) {
    			$query->where('info_status', $dataSearch['info_status']);
    		}
    	  
    		$total = $query->count();
    		$query->orderBy('info_id', 'desc');
    
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
     
    public static function getById($id=0){
    	$result = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_INFO_ID.$id) : array();
    	try {
    		if(empty($result)){
    			$result = Info::where('info_id', $id)->first();
    			if($result && Memcache::CACHE_ON){
    				Cache::put(Memcache::CACHE_INFO_ID.$id, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
    			}
    		}
    	} catch (PDOException $e) {
    		throw new PDOException();
    	}
    	
    	return $result;	
    }
     
    public static function updateData($id=0, $dataInput=array()){
    	try {
    		DB::connection()->getPdo()->beginTransaction();
    		$data = Info::find($id);
    		if($id > 0 && !empty($dataInput)){
    			$data->update($dataInput);
    			if(isset($data->info_id) && $data->info_id > 0){
    				self::removeCacheId($data->info_id);
    			}
    			if(isset($data->info_keyword) && $data->info_keyword != ''){
    				self::removeCacheKeyword($data->info_keyword);
    			}
    			if(isset($data->info_type) && isset($data->type_language)){
    				self::removeCacheByTypeInfoAndTypeLanguage($data->info_type, $data->type_language);
    			}
    		}
    		DB::connection()->getPdo()->commit();
    		return true;
    	} catch (PDOException $e) {
    		DB::connection()->getPdo()->rollBack();
    		throw new PDOException();
    	}
    }
     
    public static function addData($dataInput=array()){
    	try {
    		DB::connection()->getPdo()->beginTransaction();
    		$data = new Info();
    		if (is_array($dataInput) && count($dataInput) > 0) {
    			foreach ($dataInput as $k => $v) {
    				$data->$k = $v;
    			}
    		}
    		if ($data->save()) {
    			DB::connection()->getPdo()->commit();
    			if($data->info_id && Memcache::CACHE_ON){
    				Info::removeCacheId($data->info_id);
    			}
    			if(isset($data->info_type) && isset($data->type_language)){
    				self::removeCacheByTypeInfoAndTypeLanguage($data->info_type, $data->type_language);
    			}
    			
    			return $data->info_id;
    		}
    		DB::connection()->getPdo()->commit();
    		return false;
    	} catch (PDOException $e) {
    		DB::connection()->getPdo()->rollBack();
    		throw new PDOException();
    	}
    }
    
    public static function saveData($id=0, $data=array()){
    	$data_post = array();
    	if(!empty($data)){
    		foreach($data as $key=>$val){
    			$data_post[$key] = $val['value'];
    		}
    	}
    	if($id > 0){
    		Info::updateData($id, $data_post);
    	}else{
    		Info::addData($data_post);
    	}
    
    }
    
    public static function deleteId($id=0){
    	try {
    		DB::connection()->getPdo()->beginTransaction();
    		$data = Info::find($id);
    		if($data != null){
    			//Remove Img
    			$info_img = ($data->info_img != '') ? $data->info_img : '';
    			if($info_img != ''){
					//xoa anh upload
					FunctionLib::deleteFileUpload($data->info_img,$data->info_id,CGlobal::FOLDER_INFORSEO);
					//x�a anh thumb
					$arrSizeThumb = CGlobal::$arrBannerSizeImage;
					foreach($arrSizeThumb as $k=>$size){
						$sizeThumb = $size['w'].'x'.$size['h'];
						FunctionLib::deleteFileThumb($data->info_img,$data->info_id,CGlobal::FOLDER_INFORSEO,$sizeThumb);
					}
    			}
    			//End Remove Img
    			$data->delete();
    			if(isset($data->info_id) && $data->info_id > 0){
    				self::removeCacheId($data->info_id);
    			}
    			if(isset($data->info_keyword) && $data->info_keyword != ''){
    				self::removeCacheKeyword($data->info_keyword);
    			}
    			if(isset($data->info_type) && isset($data->type_language)){
    				self::removeCacheByTypeInfoAndTypeLanguage($data->info_type, $data->type_language);
    			}
    			DB::connection()->getPdo()->commit();
    		}
    		return true;
    	} catch (PDOException $e) {
    		DB::connection()->getPdo()->rollBack();
    		throw new PDOException();
    	}
    }
    
    public static function getItemByKeyword($keyword=''){
    	$result = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_INFO_KEYWORD.$keyword) : array();
    	try {
    		if(empty($result)){
    			$result = Info::where('info_keyword', $keyword)->where('info_status', CGlobal::status_show)->first();
    			if($result && Memcache::CACHE_ON){
    				Cache::put(Memcache::CACHE_INFO_KEYWORD.$keyword, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
    			}
    		}
    	} catch (PDOException $e) {
    		throw new PDOException();
    	}
    	return $result;
    }
    
    public static function removeCacheId($id=0){
    	if($id>0){
    		Cache::forget(Memcache::CACHE_INFO_ID.$id);
    	}
    }
    
    public static function removeCacheKeyword($keyword=''){
    	if($keyword != ''){
    		Cache::forget(Memcache::CACHE_INFO_KEYWORD.$keyword);
    	}
    }
    
    public static function removeCacheByTypeInfoAndTypeLanguage($typeInfo='', $lang=0){
    	if($typeInfo > 0 && $lang > 0){
    		Cache::forget(Memcache::CACHE_INFO_TYPEINFO_TYPELANGUAGE.$typeInfo.'_'.$lang);
    	}
    }
    
    //SITE
    public static function getItemByTypeInfoAndTypeLanguage($typeInfo=0, $typeLanguage=0){
    	$key_cache = Memcache::CACHE_INFO_TYPEINFO_TYPELANGUAGE.$typeInfo.'_'.$typeLanguage;
    	$result = (Memcache::CACHE_ON) ? Cache::get($key_cache) : array();
    	try {
    		if(empty($result)){
    			if($typeInfo != 0 && $typeLanguage != 0){
    				$result = Info::where('info_type', $typeInfo)->where('type_language', $typeLanguage)->where('info_status', CGlobal::status_show)->first();
    			}
    			if($result && Memcache::CACHE_ON){
    				Cache::put($key_cache, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
    			}
    		}
    	} catch (PDOException $e) {
    		throw new PDOException();
    	}
    	return $result;
    	
    }
}
