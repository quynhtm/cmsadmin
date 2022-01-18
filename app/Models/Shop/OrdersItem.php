<?php

namespace App\Models\Shop;

use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

class OrdersItem extends BaseModel
{
    protected $table = TABLE_ORDERS_ITEM;
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function orders()
    {
        return $this->belongsTo(Orders::class);
    }
    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = OrdersItem::where($this->primaryKey, '>', STATUS_INT_KHONG);
            if (isset($dataSearch['p_keyword']) && $dataSearch['p_keyword'] != '') {
                $str_like = trim($dataSearch['p_keyword']);
                $query->where('shop_name', 'LIKE', '%' . $str_like . '%')
                    ->orWhere('shop_representative', 'LIKE', '%' . $str_like. '%');
            }
            if (isset($dataSearch['partner_id']) && $dataSearch['partner_id'] > STATUS_INT_KHONG) {
                $query->where('partner_id', $dataSearch['partner_id']);
            }
            if (isset($dataSearch['is_active']) && $dataSearch['is_active'] > STATUS_INT_AM_MOT) {
                $query->where('is_active', $dataSearch['is_active']);
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
                $item = ($id <= STATUS_INT_KHONG)? new OrdersItem(): self::getItemById($id);
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
        $data = Memcache::getCache(Memcache::CACHE_ORDERS_ITEM_ID.$id);
        if (!$data) {
            $data = OrdersItem::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ORDERS_ITEM_ID.$id,$data);
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
            Memcache::forgetCache(Memcache::CACHE_ORDERS_ITEM_ID.$id);
        }
    }
    /**************************************************************************************************************************/

    public  function updateData($orderId = 0, $productId = 0, $dataOrderItem = array())
    {
        $order_item_id = 0;
        if($orderId > 0 && $productId > 0){
            $order_item_id = self::getIdByOrderIdAndProductId($orderId,$productId);
        }
        try {
            if($order_item_id > 0){
                if (!empty($dataOrderItem)){
                    self::editItem($dataOrderItem,$order_item_id);
                }
                return $order_item_id;
            }
            return $order_item_id;
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }
    public function getIdByOrderIdAndProductId($order_id,$productId) {
        $order_item_id = 0;
        if($order_id > 0 && $productId > 0){
            $orderItem = self::where('order_id', $order_id)->where('product_id', $productId)->first();
            if($orderItem){
                $order_item_id = isset($orderItem->id) ? $orderItem->id : 0;
            }
        }
        return $order_item_id;
    }
}
