<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class Contact extends Eloquent
{
    protected $table = 'web_contact';
    protected $primaryKey = 'contact_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('contact_id','contact_title', 'contact_content','contact_content_reply','contact_user_id_send',
        'contact_user_name_send','contact_phone_send','contact_email_send',
        'contact_status','contact_time_creater','contact_user_id_update','contact_user_name_update',
        'contact_type', 'contact_reason', 'contact_time_update');

    public static function getByID($id) {
        $contact = Contact::where('contact_id', $id)->first();
        return $contact;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Contact::where('contact_id','>',0);
            if (isset($dataSearch['contact_title']) && $dataSearch['contact_title'] != '') {
                $query->where('contact_title','LIKE', '%' . $dataSearch['contact_title'] . '%');
            }
            if (isset($dataSearch['contact_user_name_send']) && $dataSearch['contact_user_name_send'] != '') {
                $query->where('contact_user_name_send','LIKE', '%' . $dataSearch['contact_user_name_send'] . '%');
            }
            $total = $query->count();
            $query->orderBy('contact_time_creater', 'desc');

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
            $data = new Contact();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                return $data->contact_id;
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
            $dataSave = Contact::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
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
            $dataSave = Contact::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @param int $id
     */
    public static function removeCache($id = 0){
        /*if($id > 0){
            Cache::forget(Memcache::CACHE_PROVIDER_ID.$id);
        }
        Cache::forget(Memcache::CACHE_ALL_PROVIDER);*/
    }

}