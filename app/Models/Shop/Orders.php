<?php

namespace App\Models\Shop;

use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

class Orders extends BaseModel
{
    protected $table = TABLE_ORDERS;
    protected $primaryKey = 'id';
    public $timestamps = true;
    public function ordersItem(){
        return $this->hasMany(OrdersItem::class,'order_id');
    }
    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_MUOI, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = Orders::where($this->primaryKey, '>', STATUS_INT_KHONG);
            if (isset($dataSearch['order_product_id']) && trim($dataSearch['order_product_id']) != '') {
                $query->where('order_product_id', 'LIKE', '%' . $dataSearch['order_product_id'] . '%');
            }

            if (isset($dataSearch['p_keyword']) && $dataSearch['p_keyword'] != '') {
                $p_keyword = trim($dataSearch['p_keyword']);
                $query->where(function ($query) use ($p_keyword) {
                    $$query->where('order_note', 'LIKE', '%' . $p_keyword . '%')
                        ->orWhere('order_customer_name', 'LIKE', '%' . $p_keyword . '%')
                        ->orWhere('order_customer_note', 'LIKE', '%' . $p_keyword . '%')
                        ->orWhere('order_customer_phone', 'LIKE', '%' . $p_keyword . '%')
                        ->orWhere('order_customer_email', 'LIKE', '%' . $p_keyword . '%')
                        ->orWhere('order_customer_address', 'LIKE', '%' . $p_keyword . '%')
                        ->orWhere('order_user_shipper_name', 'LIKE', '%' . $p_keyword . '%');
                });
            }

            if (isset($dataSearch['order_type']) && $dataSearch['order_type'] != STATUS_INT_AM_MOT) {
                $query->where('order_type',  $dataSearch['order_type'] );
            }
            if (isset($dataSearch['order_is_cod']) && $dataSearch['order_is_cod'] != STATUS_INT_AM_MOT) {
                $query->where('order_is_cod', $dataSearch['order_is_cod']);
            }
            if (isset($dataSearch['order_status']) && $dataSearch['order_status'] != STATUS_INT_AM_MOT) {
                $query->where('order_status', $dataSearch['order_status']);
            }
            if (isset($dataSearch['order_id']) && trim($dataSearch['order_id']) != '') {
                $arrOrderId = explode(',',trim($dataSearch['order_id']));
                $query->whereIn('id', $arrOrderId);
            }

            $total = ($is_total) ? $query->count() : STATUS_INT_KHONG;
            $query->orderBy($this->primaryKey, 'desc');

            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            if (!empty($fields)) {
                $result = $query->take($limit)->skip($offset)->get($fields);
            } else {
                $result = $query->take($limit)->skip($offset)->get();
            }
            return ['data' => $result ,'total' => $total ];

        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function editItem($data, $id = 0)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                $item = ($id <= STATUS_INT_KHONG)? new Orders(): self::getItemByIdModel($id);
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
    public function getItemByIdModel($id)
    {
        return self::where($this->primaryKey,$id)->first();
    }
    //lấy thêm data orders item
    public function getItemById($id)
    {
        $data = Memcache::getCache(Memcache::CACHE_ORDER_ID.$id);
        if (!$data) {
            $data = Orders::find($id);
            $data->orders_item = $data->ordersitem;
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ORDER_ID.$id,$data);
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
            Memcache::forgetCache(Memcache::CACHE_ORDER_ID.$id);
        }
    }
    /**************************************************************************************************************************/
}
