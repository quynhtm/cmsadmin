<?php
/*
* @Created by: QuynhTM
* @Author    : manhquynh1984@gmail.com
* @Date      : 01/2018
* @Version   : 1.0
*/
namespace App\Http\Controllers;

use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\Upload;
use App\Library\PHPThumb\ThumbImg;
use App\Models\Shop\Products;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class AjaxUploadController extends BaseAdminController
{
    private  $sizeImageShowUpload = 100;

    public function removeImageCommon(){
        $request = $_POST;
        $item_id = (int)$request['id'];
        $type = (int)$request['type'];
        $nameImage = trim($request['nameImage']);
        $key = $request['key'];
        $aryData = array();
        $aryData['intIsOK'] = -1;
        if($item_id > 0 && $nameImage != '' && $key != ''){
            switch( $type ){
                case 2:
                    //img product
                    $inforProduct = app(Products::class)->getItemById($item_id);
                    //if(sizeof($inforProduct) >0){
                    if(!empty($inforProduct)){
                        $arrImagOther = unserialize($inforProduct->product_image_other);
                        if(!empty($arrImagOther)){
                            foreach($arrImagOther as $k=>$v){
                                if($v == $nameImage){
                                    unset($arrImagOther[$k]);
                                    //xoa anh upload
                                    FunctionLib::deleteFileUpload($nameImage,$item_id,FOLDER_PRODUCT);
                                }
                            }
                        }
                        $proUpdate['product_image_other'] = (!empty($arrImagOther))?serialize($arrImagOther):'';
                        app(Products::class)->editItem($proUpdate,$item_id);
                    }
                    $aryData['intIsOK'] = 1;
                    break;
                default:
                    break;
            }
        }
        return Response::json($aryData);
    }
    function uploadImage() {
        $id_hiden = Request::get('id', 0);
        $type = Request::get('type', 1);
        $dataImg = $_FILES["multipleFile"];
        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Data not exists!";
        switch( $type ){
            case 2://img product
                $aryData = $this->uploadImageToFolder($dataImg, $id_hiden, FOLDER_PRODUCT, $type);
                break;
            default:
                break;
        }
        echo json_encode($aryData);
        exit();
    }

    /**
     * move ảnh lên server ảnh
     * @param $dataImg
     * @param $id_hiden
     * @param $folder
     * @param $type
     */
    function moveImageToServerImage($dataImg, $id_hiden, $folder, $type){
        $link = Config::get('config.DIR_ROOT') . 'uploads/' . FOLDER_PRODUCT . '/1111/1615433042_123015319203603646862047047385511712892307n.jpg'  ;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://dev-hyperservices.hdinsurance.com.vn/upload",
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,

            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>array('files'=> new \CURLFile($link)) ,
            CURLOPT_HTTPHEADER => array(
                //"Content-Type:multipart/form-data",
                "ParentCode: HDI_UPLOAD",
                "Secret: HDI_UPLOAD_198282911FASE1239212",
                "UserName: HDI_UPLOAD",
                "environment: LIVE",
                "DeviceEnvironment: WEB",
                "ActionCode: UPLOAD_SIGN"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        //myDebug($response);
        echo $response;
    }
    function uploadImageToFolder($dataImg, $id_hiden, $folder, $type){
        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Upload Img!";

        if (!empty($dataImg)) {
            if($id_hiden > 0){
                $aryError = $tmpImg = array();

                $file_name = app(Upload::class)->uploadFile('multipleFile',
                    $_folder = $folder.'/'.$id_hiden,
                    '',
                    $_file_ext = 'jpg,jpeg,png,gif',
                    $_max_file_size = 10*1024*1024);

                if ($file_name != '' && empty($aryError)) {
                    $tmpImg['name_img'] = $file_name;
                    $tmpImg['id_key'] = rand(10000, 99999);
                    $url_thumb = ThumbImg::getImageThumb($folder, $id_hiden, $file_name);
                    $tmpImg['src'] = $url_thumb;
                }
                $aryData['intIsOK'] = 1;
                $aryData['id_item'] = $id_hiden;
                $aryData['info'] = $tmpImg;
                $aryData['file_name'] = $file_name;
            }elseif($id_hiden==0){
                $aryData['intIsOK'] = -1;
                $aryData['id_item'] = $id_hiden;
                $aryData['msg'] = "Shop đã hết lượt đăng sản phẩm";
            }
        }
        echo json_encode($aryData);
        die();
    }
}
