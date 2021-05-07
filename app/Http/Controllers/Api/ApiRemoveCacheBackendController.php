<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Http\Models\Admin\Products;
use Illuminate\Http\Request;
//use App\Http\Models\Admin\Products;

class ApiRemoveCacheBackendController extends BaseApiController{
	
	public function __construct(){
		parent::__construct();
	}
     public function index(Request $request){
         $object_name = $request->object_name;
         $key = $request->key;
         if($key !== '' && $key == hash('sha256',KEY_API_REMOVE_CACHE)){
             if(is_array($object_name)){
                 foreach ($object_name as $key=>$value){
                     $string_object = '\App\Http\Models\Admin\\' . $key;
                     $new_object = new $string_object();

                     $item = $new_object->getItemById($value);

                     $new_object->removeCache($value,$item);
                 }
             }
             else{
                 echo 'Xoá cache không thành công';
             }
             echo 'Xoá cache thành công';
         }
         else{
             echo 'Xoá cache không thành công';
         }
        exit;

     }
     private function testApiRemoveCache(){
         $post = [
             'object_name' => ['Products'=>1,'Lenders'=>1], // key la Model, value la ID can xoa cache
             'key' => hash('sha256','vaymuon_ver_4')
         ];
         $ch = curl_init();

         curl_setopt($ch, CURLOPT_URL, 'http://localhost:8888/vaymuon4/manager/api/remove-cache-by-api');
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
         $response = curl_exec($ch);

         return $response;
     }
}
