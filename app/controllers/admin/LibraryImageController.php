<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class LibraryImageController extends BaseAdminController
{
    private $permission_view = 'libraryImage_view';
    private $permission_full = 'libraryImage_full';
    private $permission_delete = 'libraryImage_delete';
    private $permission_create = 'libraryImage_create';
    private $permission_edit = 'libraryImage_edit';
    private $arrStatus = array(-1 => '--Chọn trạng thái--', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');

    private $error = array();
    private $arrCategoryParent = array();

    public function __construct()
    {
        parent::__construct();
        //$this->arrCategoryParent = Category::getAllParentCategoryId();;
        //$this->arrProvince = Province::getAllProvince();
        //Include style.
        FunctionLib::link_css(array(
            'lib/upload/cssUpload.css',
        ));

        //Include javascript.
        FunctionLib::link_js(array(
            'lib/upload/jquery.uploadfile.js',
            'lib/ckeditor/ckeditor.js',
            'lib/ckeditor/config.js',
            'js/common.js',
        ));
    }

    public function view() {
        //Check phan quyen.
        if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $pageNo = (int) Request::get('page_no',1);
        $limit = CGlobal::number_limit_show;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['image_title'] = addslashes(Request::get('image_title',''));
        $search['image_status'] = (int)Request::get('image_status',-1);
        $search['type_language'] = (int)Request::get('type_language',0);

        $data = LibraryImage::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //FunctionLib::debug($search);
        $optionStatus = FunctionLib::getOption($this->arrStatus, $search['image_status']);
        $this->layout->content = View::make('admin.LibraryImage.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $data)
            ->with('search', $search)
            ->with('arrLanguage', CGlobal::$arrLanguage)
            ->with('optionStatus', $optionStatus)
            ->with('arrStatus', $this->arrStatus)

            ->with('is_root', $this->is_root)//dùng common
            ->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0);//dùng common
    }

    public function getItem($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $data = array();
        $arrViewImgOther = array();
        $imagePrimary = $urlImageOrigin = '';
        if($id > 0) {
            $data = LibraryImage::getById($id);
            if(sizeof($data) > 0){
                //lay ảnh khác của san phẩm
                $arrViewImgOther = array();
                if(!empty($data->image_image_other)){
                    $arrImagOther = unserialize($data->image_image_other);
                    if(sizeof($arrImagOther) > 0){
                        foreach($arrImagOther as $k=>$val){
                            $url_thumb = ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $id, $val, CGlobal::sizeImage_100,  '', true, CGlobal::type_thumb_image_banner, false);
                            $arrViewImgOther[] = array('img_other'=>$val,'src_img_other'=>$url_thumb);
                        }
                    }
                }
                //ảnh sản phẩm chính
                $imagePrimary = $data->image_image;
            }
        }

        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['news_status'])? $data['news_status'] : CGlobal::status_show);
        $optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($dataSave['type_language'])? $dataSave['type_language'] : CGlobal::TYPE_LANGUAGE_VIET);

        $this->layout->content = View::make('admin.LibraryImage.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('imagePrimary', $imagePrimary)
            ->with('urlImageOrigin', $urlImageOrigin)
            ->with('arrViewImgOther', $arrViewImgOther)
            ->with('optionStatus', $optionStatus)
            ->with('optionLanguage', $optionLanguage)
            ->with('arrStatus', $this->arrStatus);
    }
    public function postItem($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $dataSave['image_title'] = addslashes(Request::get('image_title'));
        $dataSave['image_content'] = FunctionLib::strReplace(Request::get('image_content'), '\r\n', '');
        $dataSave['image_status'] = (int)Request::get('image_status', 0);
        $dataSave['type_language'] = (int)Request::get('type_language', CGlobal::TYPE_LANGUAGE_VIET);
        $id_hiden = (int)Request::get('id_hiden', 0);

        //ảnh chính
        $image_primary = addslashes(Request::get('image_primary'));
        //ảnh khác
        $getImgOther = Request::get('img_other',array());
        if(!empty($getImgOther)){
            foreach($getImgOther as $k=>$val){
                if($val !=''){
                    $arrInputImgOther[] = $val;
                }
            }
        }
        if (!empty($arrInputImgOther) && count($arrInputImgOther) > 0) {
            //nếu không chọn ảnh chính, lấy ảnh chính là cái đầu tiên
            $dataSave['image_image'] = ($image_primary != '')? $image_primary: $arrInputImgOther[0];
            $dataSave['image_image_other'] = serialize($arrInputImgOther);
        }

        //FunctionLib::debug($dataSave);
        if($this->valid($dataSave) && empty($this->error)) {
            $id = ($id == 0)?$id_hiden: $id;
            if($id > 0) {
                //cap nhat
                if(LibraryImage::updateData($id, $dataSave)) {
                    return Redirect::route('admin.libraryImageView');
                }
            } else {
                $dataSave['image_create'] = time();
                //them moi
                if(LibraryImage::addData($dataSave)) {
                    return Redirect::route('admin.libraryImageView');
                }
            }
        }

        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['news_status'])? $dataSave['news_status'] : CGlobal::status_show);
        $optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($dataSave['type_language'])? $dataSave['type_language'] : CGlobal::TYPE_LANGUAGE_VIET);

        $this->layout->content =  View::make('admin.LibraryImage.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('optionStatus', $optionStatus)
            ->with('optionLanguage', $optionLanguage)
            ->with('error', $this->error)
            ->with('arrStatus', $this->arrStatus);
    }

    public function deleteLibraryImage()
    {
        $data = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && LibraryImage::deleteData($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }
    private function valid($data=array()) {
        if(!empty($data)) {
            if(isset($data['image_title']) && trim($data['image_title']) == '') {
                $this->error[] = 'Tên ảnh không được bỏ trống';
            }
            if(isset($data['image_image']) && trim($data['image_image']) == '') {
                $this->error[] = 'Chưa up ảnh ';
            }
        }
        return true;
    }
}