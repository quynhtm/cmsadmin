<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class Category extends Eloquent
{
    protected $table = 'w_category';
    protected $primaryKey = 'category_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('category_id','category_name', 'category_parent_id',
        'category_name_alias', 'type_language','category_type', 'category_show_content','category_status',
        'category_created', 'category_meta_title', 'category_order', 'category_meta_keywords', 'category_meta_description');

    public static function getByID($id) {
        $category = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_CATEGORY_ID.$id) : array();
        if (sizeof($category) == 0) {
            $category = Category::where('category_id','=', $id)->first();
            if($category && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_CATEGORY_ID.$id, $category, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $category;
    }
    public static function getNameCategory($id) {
        $category_name = '';
        if($id > 0){
            $category = Category::getByID($id);
            if (sizeof($category) != 0) {
                $category_name = $category->category_name;
            }
        }
        return $category_name;
    }

    public static function getCateWithLanguage($type_language) {
        $category = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_CATEGORY_LANGUAGE.$type_language) : array();
        if (sizeof($category) == 0) {
            $arrCate = Category::where('type_language','=', $type_language)
                ->where('category_status','=', CGlobal::status_show)
                ->orderBy('category_order','asc')->get();
            if(!empty($arrCate)){
                foreach($arrCate as $itm) {
                    $category[$itm['category_id']] = $itm['category_name'];
                }
            }
            if($category && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_CATEGORY_LANGUAGE.$type_language, $category, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $category;
    }

    public static function getCategoryByArrayId($arrCate = array()) {
        $data = array();
        if(!empty($arrCate)){
            $category = Category::whereIn('category_id',$arrCate)->orderBy('category_id','asc')->get();
            foreach($category as $itm) {
                $data[$itm['category_id']] = $itm['category_name'];
            }
            return $data;
        }
        return $data;
    }

    public static function getAllParentCategoryId() {
        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_ALL_PARENT_CATEGORY) : array();
        if (sizeof($data) == 0) {
            $category = Category::where('category_id', '>', 0)
                ->where('category_parent_id',0)
                ->where('category_status',CGlobal::status_show)
                ->orderBy('category_order','asc')->get();
            if($category){
                foreach($category as $itm) {
                    $data[$itm['category_id']] = $itm['category_name'];
                }
            }
            if($data && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_ALL_PARENT_CATEGORY, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $data;
    }

    public static function getCategoryShowFrontSite() {
        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_ALL_SHOW_CATEGORY_FRONT) : array();
        if (sizeof($data) == 0) {
            $category = Category::where('category_id', '>', 0)
                ->where('category_parent_id',0)
                ->where('category_status',CGlobal::status_show)
                ->get();
            if($category){
                foreach($category as $itm) {
                    $data[$itm['category_id']] = array(
                        'category_name'=>$itm['category_name']);
                }
            }
            if($data && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_ALL_SHOW_CATEGORY_FRONT, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $data;
    }

    public static function getAllChildCategoryIdByParentId($parentId = 0) {
        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_ALL_CHILD_CATEGORY_BY_PARENT_ID.$parentId) : array();
        if (sizeof($data) == 0 && $parentId > 0) {
            $category = Category::where('category_id' ,'>', 0)
                ->where('category_parent_id','=',$parentId)
                ->where('category_status',CGlobal::status_show)
                ->orderBy('category_order','asc')->get();
            if($category){
                foreach($category as $itm) {
                    $data[$itm['category_id']] = $itm['category_name'];
                }
            }
            if($data && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_ALL_CHILD_CATEGORY_BY_PARENT_ID.$parentId, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $data;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Category::where('category_id','>',0);
            if (isset($dataSearch['category_name']) && $dataSearch['category_name'] != '') {
                $query->where('category_name','LIKE', '%' . $dataSearch['category_name'] . '%');
            }
            if (isset($dataSearch['category_status']) && $dataSearch['category_status'] != -1) {
                $query->where('category_status', $dataSearch['category_status']);
            }
            if (isset($dataSearch['type_language']) && $dataSearch['type_language'] != -1) {
                $query->where('type_language', $dataSearch['type_language']);
            }

            $total = $query->count();
            $query->orderBy('category_id', 'desc');

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
            $data = new Category();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->category_id) && $data->category_id > 0){
                    self::removeCache($data->category_id, $data);
                }
                return $data->category_id;
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
            $dataSave = Category::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
                if(isset($dataSave->category_id) && $dataSave->category_id > 0){
                    self::removeCache($dataSave->category_id,$dataSave);
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
            $dataSave = Category::find($id);
            $dataSave->delete();
            if(isset($dataSave->category_id) && $dataSave->category_id > 0){
                self::removeCache($dataSave->category_id,$dataSave);
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function removeCache($id = 0,$category = array()){
        if($id > 0){
            Cache::forget(Memcache::CACHE_CATEGORY_ID.$id);
            Cache::forget(Memcache::CACHE_ALL_CHILD_CATEGORY_BY_PARENT_ID.$id);

        }
        if(!empty($category)){
            Cache::forget(Memcache::CACHE_CATEGORY_LANGUAGE.$category->type_language);
        }
        Cache::forget(Memcache::CACHE_ALL_CATEGORY);
        Cache::forget(Memcache::CACHE_ALL_PARENT_CATEGORY);
        Cache::forget(Memcache::CACHE_ALL_SHOW_CATEGORY_FRONT);
    }

    public static function getCategoriessAll(){
        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_ALL_CATEGORY) : array();
        if (sizeof($data) == 0) {
            $categories = Category::where('category_id', '>', 0)->where('category_status', '=', CGlobal::status_show)->orderBy('category_order', 'asc')->get();
            if($categories){
                foreach($categories as $itm) {
                    $data[$itm->category_id] = array('category_id'=>$itm->category_id,
                        'category_name'=>$itm->category_name,
                        'category_parent_id'=>$itm->category_parent_id,
                        'type_language'=>$itm->type_language,
                    	'category_type'=>$itm->category_type,
                    	'category_show_content'=>$itm->category_show_content,
                        'category_status'=>$itm->category_status,
                        'category_icons'=>$itm->category_icons,
                        'category_order'=>$itm->category_order);
                }
                if(!empty($data) && Memcache::CACHE_ON){
                    Cache::put(Memcache::CACHE_ALL_CATEGORY, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
                }
            }
        }
        return $data;
    }

    public static function buildTreeCategory(){
        $categories = Category::where('category_id', '>', 0)->where('category_status', '=', CGlobal::status_show)->get();
        return $treeCategroy = self::getTreeCategory($categories);
    }
    /**
     * build c�y danh m?c
     * @param $data
     * @return array
     */
    public static function getTreeCategory($data){
        $max = 0;
        $aryCategoryProduct = $arrCategory = array();
        if(!empty($data)){
            foreach ($data as $k=>$value){
                $max = ($max < $value->category_parent_id)? $value->category_parent_id : $max;
                $arrCategory[$value->category_id] = array(
                    'category_id'=>$value->category_id,
                    'category_parent_id'=>$value->category_parent_id,
                    'type_language'=>$value->type_language,
                	'category_type'=>$itm->category_type,
                	'category_show_content'=>$itm->category_show_content,
                    'category_order'=>$value->category_order,
                    'category_status'=>$value->category_status,
                    'category_name'=>$value->category_name);
            }
        }

        if($max > 0){
            $aryCategoryProduct = self::showCategory($max, $arrCategory);
        }
        return $aryCategoryProduct;
    }
    public static function showCategory($max, $aryDataInput) {
        $aryData = array();
        if(is_array($aryDataInput) && count($aryDataInput) > 0) {
            foreach ($aryDataInput as $k => $val) {
                if((int)$val['category_parent_id'] == 0) {
                    $val['padding_left'] = '';
                    $val['category_parent_name'] = '';
                    $aryData[] = $val;
                    self::showSubCategory($val['category_id'],$val['category_name'], $max, $aryDataInput, $aryData);
                }
            }
        }
        return $aryData;
    }
    public static function showSubCategory($cat_id,$cat_name, $max, $aryDataInput, &$aryData) {
        if($cat_id <= $max) {
            foreach ($aryDataInput as $chk => $chval) {
                if($chval['category_parent_id'] == $cat_id) {
                    $chval['padding_left'] = '---------- ';
                    $chval['category_parent_name'] = $cat_name;
                    $aryData[] = $chval;
                    self::showSubCategory($chval['category_id'],$chval['category_name'], $max, $aryDataInput, $aryData);
                }
            }
        }
    }

}