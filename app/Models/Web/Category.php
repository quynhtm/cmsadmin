<?php
/**
 * QuynhTM
 */

namespace App\Models\Web;

use App\Models\BaseModel;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Memcache;


class Category extends BaseModel
{
    protected $table = TABLE_CATEGORY;
    protected $primaryKey = 'id';
    public $timestamps = false;
    const  categoryTypeProduct = STATUS_INT_MOT;
    const  categoryTypeNew = STATUS_INT_HAI;

    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = Category::where($this->primaryKey, '>', STATUS_INT_KHONG);
            if (isset($dataSearch['p_keyword']) && $dataSearch['p_keyword'] != '') {
                $str_like = trim($dataSearch['p_keyword']);
                $query->where('category_name', 'LIKE', '%' . $str_like . '%');
            }
            if (isset($dataSearch['partner_id']) && $dataSearch['partner_id'] > STATUS_INT_KHONG) {
                $query->where('partner_id', $dataSearch['partner_id']);
            }
            if (isset($dataSearch['category_type']) && $dataSearch['category_type'] > STATUS_INT_KHONG) {
                $query->where('category_type', $dataSearch['category_type']);
            }
            if (isset($dataSearch['is_active']) && $dataSearch['is_active'] > STATUS_INT_AM_MOT) {
                $query->where('news_status', $dataSearch['is_active']);
            }
            $total = ($is_total) ? $query->count() : STATUS_INT_KHONG;
            $query->orderBy('is_active', 'desc');
            $query->orderBy('category_order', 'asc');

            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            if (!empty($fields)) {
                $result = $query->take($limit)->skip($offset)->get($fields);
            } else {
                $result = $query->take($limit)->skip($offset)->get();
            }
            return ['data' => $result, 'total' => $total];
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function editItem($data, $id = 0)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                $item = ($id <= STATUS_INT_KHONG) ? new Category() : self::getItemById($id);
                if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                    foreach ($fieldInput as $k => $v) {
                        $item->$k = $v;
                    }
                }
                if ($id <= STATUS_INT_KHONG) {
                    $item->created_id = $this->getUserId();
                    $item->created_name = $this->getUserName();
                    $item->save();
                    $id = $item->id;
                } else {
                    $item->updated_id = $this->getUserId();
                    $item->updated_name = $this->getUserName();
                    $item->update();
                }
                self::removeCache($id, $item);
                return $id;
            }
            return STATUS_INT_KHONG;
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function getItemById($id)
    {
        $data = Memcache::getCache(Memcache::CACHE_CATEGORY_BY_ID . $id);
        if (!$data) {
            $data = Category::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_CATEGORY_BY_ID . $id, $data);
            }
        }
        return $data;
    }

    public function deleteItem($id)
    {
        if ($id <= STATUS_INT_KHONG) return false;
        try {
            $item = $dataOld = self::getItemById($id);;
            if ($item) {
                $item->delete();
                self::removeCache($item->id, $dataOld);
            }
            return true;
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function removeCache($id = STATUS_INT_KHONG, $data)
    {
        Memcache::forgetCache(Memcache::CACHE_CATEGORY_BY_ID . $id);
        Memcache::forgetCache(Memcache::CACHE_CATEGORY_TREE);
        if(isset($data->id)){
            Memcache::forgetCache(Memcache::CACHE_CATEGORY_BY_TYPE.$data->category_type);
            Memcache::forgetCache(Memcache::CACHE_ALL_CATEGORY_BY_PARTNER.$data->partner_id);
        }
    }
    /***************************************************************************************************************************************************/
    public function getAllData($partner = STATUS_INT_MOT)
    {
        $data = Memcache::getCache(Memcache::CACHE_ALL_CATEGORY_BY_PARTNER.$partner);
        if (!$data) {
            $data = Category::where($this->primaryKey, '>', STATUS_INT_KHONG)
                ->where('partner_id', $partner)
                ->orderBy('category_order', 'asc')->get();
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ALL_CATEGORY_BY_PARTNER.$partner, $data);
            }
        }
        return $data;
    }

    public function getSiteCategoryByType($categoryType = self::categoryTypeProduct, $partner = STATUS_INT_MOT){
        $dataAll = self::getAllData($partner);
        $dataOut = [];
        if($dataAll){
            foreach ($dataAll as $k => $val){
                if($val->is_active == STATUS_INT_MOT && $val->category_type == $categoryType){
                    $dataOut[] = $val;
                }
            }
        }
        return $dataOut;
    }

    public function getCategoryByType($category_type = self::categoryTypeNew){
        $data = Memcache::getCache(Memcache::CACHE_CATEGORY_BY_TYPE . $category_type);
        if (!$data) {
            $data = Category::where('id', '>', STATUS_INT_KHONG)
                ->where('is_active', STATUS_INT_MOT)
                ->where('category_type', $category_type)
                ->orderBy('category_order', 'asc')->get();
            if ($data) {
                Memcache::putCache(Memcache::CACHE_CATEGORY_BY_TYPE . $category_type, $data);
            }
        }
        return $data;
    }
    public function getOptionCategoryByType($category_type = self::categoryTypeNew){
        $data = self::getCategoryByType($category_type);
        $option = [];
        if($data){
            foreach ($data as $ky=>$val){
                $option[$val->id] = $val->category_name;
            }
        }
        return $option;
    }
    public function getOptionCategoryParent($category_type = 1)
    {
        $dataMenu = Category::where('id', '>', STATUS_INT_KHONG)
            ->where('is_active', STATUS_INT_MOT)
            ->where('is_parent', STATUS_INT_MOT)
            ->where('category_type', $category_type)
            ->orderBy('category_order', 'asc')->get();
        $arrOption = [];
        if ($dataMenu) {
            foreach ($dataMenu as $item) {
                $arrOption[$item->id] = $item->category_name;
            }
        }
        return $arrOption;
    }

    public function getAllParentCategory($categoryType = 1)
    {
        $data = false;
        if (!$data || sizeof($data) == STATUS_INT_KHONG) {
            $menu = Category::where('id', '>', STATUS_INT_KHONG)
                ->where('category_type', $categoryType)
                ->where('is_parent', STATUS_INT_MOT)
                ->where('is_active', STATUS_SHOW)
                ->orderBy('category_order', 'asc')->get();
            if ($menu) {
                foreach ($menu as $itm) {
                    $data[$itm['id']] = $itm['category_name'];
                }
            }
        }
        return $data;
    }
    public function getTreeMenu($data)
    {
        $max = STATUS_INT_KHONG;
        $aryCategoryProduct = $arrCategory = array();
        if (!empty($data)) {
            foreach ($data as $k => $value) {
                $max = ($max < $value->category_parent_id) ? $value->category_parent_id : $max;
                $arrCategory[$value->id] = array(
                    'id' => $value->id,
                    'category_level' => $value->category_level,
                    'category_parent_id' => $value->category_parent_id,
                    'partner_id' => $value->partner_id,
                    'is_parent' => $value->is_parent,
                    'controller_name' => $value->controller_name,
                    'category_type' => $value->category_type,
                    'category_order' => $value->category_order,
                    'category_icons' => $value->category_icons,
                    'category_menu_status' => $value->category_menu_status,
                    'category_menu_right' => $value->category_menu_right,
                    'is_active' => $value->is_active,
                    'category_name_en' => $value->category_name,
                    'category_name' => $value->category_name);
            }
        }

        if ($max > STATUS_INT_KHONG) {
            $aryCategoryProduct = self::showMenu($max, $arrCategory);
        }
        return $aryCategoryProduct;
    }

    public function showMenu($max, $aryDataInput)
    {
        $aryData = array();
        if (is_array($aryDataInput) && count($aryDataInput) > STATUS_INT_KHONG) {
            foreach ($aryDataInput as $k => $val) {
                if ((int)$val['category_parent_id'] == STATUS_INT_KHONG) {
                    $val['padding_left'] = '';
                    $val['category_name_parent'] = '';
                    $val['category_name_parent_en'] = '';
                    $aryData[] = $val;
                    self::showSubMenu($val['id'], $val['category_name'], $val['category_name_en'], $max, $aryDataInput, $aryData);
                }
            }
        }
        return $aryData;
    }

    public function showSubMenu($cat_id, $cat_name, $cat_name_en, $max, $aryDataInput, &$aryData)
    {
        if ($cat_id <= $max) {
            foreach ($aryDataInput as $chk => $chval) {
                if ($chval['category_parent_id'] == $cat_id) {
                    $chval['padding_left'] = '--- ';
                    $chval['category_name_parent'] = $cat_name;
                    $chval['category_name_parent_en'] = $cat_name_en;
                    $aryData[] = $chval;
                    self::showSubMenu($chval['id'], $chval['category_name'], $chval['category_name_en'], $max, $aryDataInput, $aryData);
                }
            }
        }
    }
}
