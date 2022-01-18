<?php

namespace App\Models\Shop;

use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;
use App\Models\Web\Category;
use Illuminate\Support\Facades\DB;

class Products extends BaseModel
{
    protected $table = TABLE_PRODUCT;
    protected $primaryKey = 'id';
    public $timestamps = true;

    const productTypeNew = 1;//sp mới
    const productTypeHighlights = 2; //nổi bật
    const productTypeDiscount = 3;//giảm giá

    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = Products::where($this->primaryKey, '>', STATUS_INT_KHONG);
            if (isset($dataSearch['p_keyword']) && $dataSearch['p_keyword'] != '') {
                $str_like = trim($dataSearch['p_keyword']);
                $query->where('product_name', 'LIKE', '%' . $str_like . '%')
                    ->orWhere('created_name', 'LIKE', '%' . $str_like . '%');
            }
            if (isset($dataSearch['partner_id']) && $dataSearch['partner_id'] > STATUS_INT_KHONG) {
                $query->where('partner_id', $dataSearch['partner_id']);
            }
            if (isset($dataSearch['product_is_hot']) && $dataSearch['product_is_hot'] > STATUS_INT_KHONG) {
                $query->where('product_is_hot', $dataSearch['product_is_hot']);
            }
            if (isset($dataSearch['category_id']) && $dataSearch['category_id'] > STATUS_INT_KHONG) {
                $query->where('category_id', $dataSearch['category_id']);
            }
            if (isset($dataSearch['product_status']) && $dataSearch['product_status'] > STATUS_INT_AM_MOT) {
                $query->where('product_status', $dataSearch['product_status']);
            }

            $total = ($is_total) ? $query->count() : STATUS_INT_KHONG;
            $query->orderBy($this->primaryKey, 'desc');
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
                $item = ($id <= STATUS_INT_KHONG)? new Products(): self::getItemById($id);
                if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                    foreach ($fieldInput as $k => $v) {
                        $item->$k = $v;
                    }
                }
                if($id <= STATUS_INT_KHONG){
                    $item->created_id = $this->getUserId();
                    $item->created_name = $this->getUserName();
                    $item->save();
                    $id = $item->id;
                }else{
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
        $data = Memcache::getCache(Memcache::CACHE_PRODUCTS_ID.$id);
        if (!$data) {
            $data = Products::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_PRODUCTS_ID.$id,$data);
            }
        }
        return $data;
    }

    public function deleteItem($id)
    {
        if ($id <= STATUS_INT_KHONG) return false;
        try {
            $item = $dataOld = self::getItemById($id);
            if ($item) {
                $item->delete();
                self::removeCache($id, $dataOld);
                return true;
            }
            return false;
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function removeCache($id = STATUS_INT_KHONG, $data = [])
    {
        if ($id > STATUS_INT_KHONG) {
            Memcache::forgetCache(Memcache::CACHE_PRODUCTS_ID.$id);
        }
    }
    /**************************************************************************************************************************/
    public function getProductByArrayProId($arrProId = array(), $field_get = array())
    {
        if (!empty($arrProId)) {
            $query = self::where($this->primaryKey, '>', 0);
            $query->where('product_status', '=', STATUS_INT_MOT);
            $query->where('is_block', '=', STATUS_INT_MOT);
            $query->whereIn($this->primaryKey, $arrProId);
            return $result = (!empty($field_get)) ? $query->get($field_get) : $query->get();
        }
        return [];
    }
    public function getProductForSite($dataSearch = array(), $limit = 0, $offset = 0, $is_total = true)
    {
        try {
            $query = Products::where($this->primaryKey, '>', 0);
            $query->where('product_status', '=', STATUS_INT_MOT);
            $query->where('is_block', '=', STATUS_INT_MOT);

            if (isset($dataSearch['product_id'])) {
                if (is_array($dataSearch['product_id'])) {
                    $query->whereIn($this->primaryKey, $dataSearch['product_id']);
                } elseif ((int)$dataSearch['product_id'] > 0) {
                    $query->where($this->primaryKey, '=', (int)$dataSearch['product_id']);
                }
            }

            if (isset($dataSearch['not_product_id']) && $dataSearch['not_product_id'] > 0) {
                $query->whereNotIn($this->primaryKey, array($dataSearch['not_product_id']));
            }

            if (isset($dataSearch['product_name']) && $dataSearch['product_name'] != '') {
                $query->where('product_name', 'LIKE', '%' . $dataSearch['product_name'] . '%');
            }
            if (isset($dataSearch['category_id'])) {
                if (is_array($dataSearch['category_id'])) {//tim theo mảng id danh muc
                    $query->whereIn('category_id', $dataSearch['category_id']);
                } elseif ((int)$dataSearch['category_id'] > 0) {//theo id danh muc
                    $query->where('category_id', '=', (int)$dataSearch['category_id']);
                }
            }

            if (isset($dataSearch['category_parent_id']) && $dataSearch['category_parent_id'] > 0) {
                $arrCatId = array();
                $arrChildCate = Category::getAllChildCategoryIdByParentId($dataSearch['category_parent_id']);
                if (!empty($arrChildCate)) {
                    $arrCatId = array_keys($arrChildCate);
                }
                $query->whereIn('category_id', $arrCatId);
            }

            if (isset($dataSearch['user_shop_id']) && $dataSearch['user_shop_id'] != 0) {
                $query->where('user_shop_id', '=', $dataSearch['user_shop_id']);
            }

            if (isset($dataSearch['depart_id']) && $dataSearch['depart_id'] > 0) {
                $query->where('depart_id', '=', $dataSearch['depart_id']);
            }
            if (isset($dataSearch['product_is_hot']) && $dataSearch['product_is_hot'] != -1) {
                $query->where('product_is_hot', '=', $dataSearch['product_is_hot']);
            }

            if (isset($dataSearch['shop_province']) && $dataSearch['shop_province'] != -1) {
                $query->where('shop_province', '=', $dataSearch['shop_province']);
            }
            //lấy khác shop_id này
            if (isset($dataSearch['shop_id_other']) && $dataSearch['shop_id_other'] > 0) {
                $query->where('user_shop_id', '<>', $dataSearch['shop_id_other']);
            }

            //1: shop free, 2: shop thuong: 3 shop VIP
            if (isset($dataSearch['is_shop'])) {
                if (is_array($dataSearch['is_shop'])) {
                    $query->whereIn('is_shop', $dataSearch['is_shop']);
                } elseif ((int)$dataSearch['is_shop'] > 0) {
                    $query->where('is_shop', (int)$dataSearch['is_shop']);
                }
            }
            $total = ($is_total) ? $query->count() : 0;

            if (isset($dataSearch['str_product_id']) && $dataSearch['str_product_id'] != '') {
                $arrProductId = explode(',', trim($dataSearch['str_product_id']));
                $query->whereIn($this->primaryKey, $arrProductId);
                $query->orderByRaw(DB::raw("FIELD(".$this->primaryKey.", " . trim($dataSearch['str_product_id']) . " )"));
            } else {
                $orderBy = 'desc';
                if (isset($dataSearch['orderBy']) && $dataSearch['orderBy'] != '') {
                    $orderBy = $dataSearch['orderBy'];
                }
                if (isset($dataSearch['field_order']) && $dataSearch['field_order'] != '') {
                    $query->orderBy($dataSearch['field_order'], $orderBy);
                }
                $query->orderBy('time_update', $orderBy);
            }

            //get field can lay du lieu
            $str_field_product_get = 'id,partner_id,product_name,depart_id,category_id,category_name,product_image,product_image_hover,product_status,product_price_sell,product_price_market,product_type_price,is_shop,is_block';//cac truong can lay
            $fields_get = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? trim($dataSearch['field_get']) : $str_field_product_get;
            $fields = (trim($fields_get) != '') ? explode(',', trim($fields_get)) : array();
            if (!empty($fields)) {
                $result = $query->take($limit)->skip($offset)->get($fields);
            } else {
                $result = $query->take($limit)->skip($offset)->get();
            }
            return ['data' => $result, 'total' => $total];
        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }
}
