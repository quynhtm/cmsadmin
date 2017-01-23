<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class Video extends Eloquent
{
    protected $table = 'w_video';
    protected $primaryKey = 'video_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('video_id','video_name','video_content', 'video_link',
        'video_file', 'video_status', 'video_time_creater',
        'type_language', 'video_time_update');

    public static function getByID($id) {
        $new = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_VIDEO_ID.$id) : array();
        if (sizeof($new) == 0) {
            $new = Video::where('video_id', $id)->first();
            if($new && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_VIDEO_ID.$id, $new, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $new;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Video::where('video_id','>',0);
            if (isset($dataSearch['video_name']) && $dataSearch['video_name'] != '') {
                $query->where('video_name','LIKE', '%' . $dataSearch['video_name'] . '%');
            }
            if (isset($dataSearch['video_status']) && $dataSearch['video_status'] != -1) {
                $query->where('video_status', $dataSearch['video_status']);
            }
            if (isset($dataSearch['type_language']) && $dataSearch['type_language'] > 0) {
                $query->where('type_language', $dataSearch['type_language']);
            }

            $total = $query->count();
            $query->orderBy('video_id', 'desc');

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
            $data = new Video();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->video_id) && $data->video_id > 0){
                    self::removeCache($data->video_id);
                }
                return $data->video_id;
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
            $dataSave = Video::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
                if(isset($dataSave->video_id) && $dataSave->video_id > 0){
                    self::removeCache($dataSave->video_id);
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
            $dataSave = Video::find($id);
            $dataSave->delete();
            if(isset($dataSave->video_id) && $dataSave->video_id > 0){
                self::removeCache($dataSave->video_id);
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
            Cache::forget(Memcache::CACHE_VIDEO_ID.$id);
        }
    }
    
    public static function getSameVideo($dataField='', $id=0, $limit=10, $lang){
    	try{
    		$result = array();
    
    		if($id>0 && $limit>0){
    			$query = Video::where('video_id','<>', $id);
    			$query->where('video_status', CGlobal::status_show);
    			if($lang > 0){
    				$query->where('type_language', $lang);
    			}
    			$query->orderBy('video_id', 'desc');
    
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
    
    public static function getNewVideo($dataField='', $limit=10, $lang){
    	try{
    		$result = array();
    
    		if($limit>0){
    			$query = Video::where('video_status', CGlobal::status_show);
    			if($lang > 0){
    				$query->where('type_language', $lang);
    			}
    			$query->orderBy('video_id', 'desc');
    
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