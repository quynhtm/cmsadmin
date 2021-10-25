<?php
/**
 * QuynhTM
 * 13/03/2020
 */

namespace App\Models\OpenId;

use App\Models\BaseModel;
use App\Library\AdminFunction\Memcache;

class CalendarWorking extends BaseModel
{
    protected $table = TABLE_CALENDAR_WORKING;
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static $arrTime = [STATUS_INT_MOT =>'Tuần này',
        STATUS_INT_HAI =>'Tháng này',
        STATUS_INT_BA =>'Tuần tới',
        STATUS_INT_BON =>'Tháng tới',
        ];
    public static $arrType = [STATUS_INT_MOT =>'Lịch họp',STATUS_INT_HAI =>'Lịch công tác'];
    public static $arrStatus = [STATUS_INT_MOT =>'Đã duyệt',STATUS_INT_KHONG =>'Chưa duyệt'];
    public static $arrWhose = [STATUS_INT_MOT =>'Của tôi',STATUS_INT_HAI =>'Phòng ban liên quan'];

    public function searchByCondition($dataSearch = array(), $limit = 0, $offset = 0, $is_total = true)
    {
        return ['data' => [], 'total' => 0];
        try {
            $query = self::where($this->primaryKey, '>', 0);
            if (isset($dataSearch['content']) && $dataSearch['content'] != '') {
                $query->where('content', 'LIKE', '%' . $dataSearch['content'] . '%');
            }
            if (isset($dataSearch['type_calendar']) && $dataSearch['type_calendar'] > STATUS_INT_AM_MOT) {
                $query->where('type_calendar', $dataSearch['type_calendar']);
            }
            if (isset($dataSearch['type_whose']) && $dataSearch['type_whose'] > STATUS_INT_AM_MOT) {
                $query->where('type_whose', $dataSearch['type_whose']);
            }
            if (isset($dataSearch['preside_id']) && $dataSearch['preside_id'] > STATUS_INT_AM_MOT) {
                $query->where('preside_id', $dataSearch['preside_id']);
            }
            if (isset($dataSearch['status']) && $dataSearch['status'] > STATUS_INT_AM_MOT) {
                $query->where('status', $dataSearch['status']);
            }
            $total = ($is_total) ? $query->count() : 0;
            $query->orderBy($this->primaryKey, 'DESC');

            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
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

    public function createItem($data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $item = new CalendarWorking();
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
            }
            $item->save();
            self::removeCache($item->id, $item);
            return $item->id;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function updateItem($id, $data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $item = self::getItemById($id);
            foreach ($fieldInput as $k => $v) {
                $item->$k = $v;
            }
            $item->update();
            self::removeCache($item->id, $item);
            return true;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function getItemById($id)
    {
        if ($id <= 0) return false;
        $data = Memcache::getCache(Memcache::CACHE_CALENDAR_WORKING_ID . $id);
        if (!$data) {
            $data = self::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_CALENDAR_WORKING_ID . $id, $data);
            }
        }
        return $data;
    }

    public function deleteItem($id)
    {
        if ($id <= 0) return false;
        try {
            $item = $dataOld = self::getItemById($id);
            if ($item) {
                $item->delete();
                self::removeCache($id, $dataOld);
            }
            return true;
        } catch (\PDOException $e) {
            throw new \PDOException();
            return false;
        }
    }

    public function removeCache($id = 0, $data)
    {
        if ($id > 0) {
            Memcache::forgetCache(Memcache::CACHE_CALENDAR_WORKING_ID . $id);
        }
        if ($data) {}
    }
}
