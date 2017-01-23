<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/
class Langs extends Eloquent {
    
    protected $table = 'w_language';
    protected $primaryKey = 'language_id';
    public  $timestamps = false;

    protected $fillable = array('language_id', 'language_keyword', 'language_content','language_lang', 'language_status');
	//ADMIN
    public static function searchByCondition($dataSearch=array(), $limit=0, $offset=0, &$total){
    	try{
    		$query = Langs::where('language_id','>',0);
    	  
    		if (isset($dataSearch['language_keyword']) && $dataSearch['language_keyword'] != '') {
    			$query->where('language_keyword','LIKE', '%' . $dataSearch['language_keyword'] . '%');
    		}
    		if (isset($dataSearch['language_status']) && $dataSearch['language_status'] != -1) {
    			$query->where('language_status', $dataSearch['language_status']);
    		}
    	  
    		$total = $query->count();
    		$query->orderBy('language_id', 'desc');
    
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
    	$result = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_LANG_ID.$id) : array();
    	try {
    		if(empty($result)){
    			$result = Langs::where('language_id', $id)->first();
    			if($result && Memcache::CACHE_ON){
    				Cache::put(Memcache::CACHE_LANG_ID.$id, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
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
    		$data = Langs::find($id);
    		if($id > 0 && !empty($dataInput)){
    			$data->update($dataInput);
    			if(isset($data->language_id) && $data->language_id > 0){
    				self::removeCacheId($data->language_id);
    			}
    			if(isset($data->language_keyword) && $data->language_keyword != ''){
    				self::removeCacheKeyword($data->language_keyword, $data->language_lang);
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
    		$data = new Langs();
    		if (is_array($dataInput) && count($dataInput) > 0) {
    			foreach ($dataInput as $k => $v) {
    				$data->$k = $v;
    			}
    		}
    		if ($data->save()) {
    			DB::connection()->getPdo()->commit();
    			if($data->language_id && Memcache::CACHE_ON){
    				Info::removeCacheId($data->language_id);
    			}
    			return $data->language_id;
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
    		Langs::updateData($id, $data_post);
    	}else{
    		Langs::addData($data_post);
    	}
    
    }
    
    public static function deleteId($id=0){
    	try {
    		DB::connection()->getPdo()->beginTransaction();
    		$data = Langs::find($id);
    		if($data != null){
    			if(isset($data->language_id) && $data->language_id > 0){
    				self::removeCacheId($data->language_id);
    			}
    			if(isset($data->language_keyword) && $data->language_keyword != ''){
    				self::removeCacheKeyword($data->language_keyword, $data->language_lang);
    			}
    			
    			$data->delete();
    			
    			DB::connection()->getPdo()->commit();
    		}
    		return true;
    	} catch (PDOException $e) {
    		DB::connection()->getPdo()->rollBack();
    		throw new PDOException();
    	}
    }
    
    public static function getItemByKeywordLang($keyword='', $lang=0){
    	$key_cache = Memcache::CACHE_LANG_KEYWORD_LANGUAGE.$keyword.'_'.$lang;
    	$result = (Memcache::CACHE_ON) ? Cache::get($key_cache) : array();
    	try {
    		if(empty($result)){
    			$result = Langs::where('language_keyword', $keyword)->where('language_lang', $lang)->where('language_status', CGlobal::status_show)->first();
    			if($result && Memcache::CACHE_ON){
    				Cache::put($key_cache, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
    			}
    		}
    	} catch (PDOException $e) {
    		throw new PDOException();
    	}
    	if(sizeof($result) > 0){
    		$result = strip_tags(stripslashes($result->language_content));
    	}
    	return $result;
    }
    
    public static function removeCacheId($id=0){
    	if($id>0){
    		Cache::forget(Memcache::CACHE_LANG_ID.$id);
    	}
    }
    
    public static function removeCacheKeyword($keyword='', $lang=0){
    	if($keyword != ''){
    		Cache::forget(Memcache::CACHE_LANG_KEYWORD_LANGUAGE.$keyword.'_'.$lang);
    	}
    }
}
