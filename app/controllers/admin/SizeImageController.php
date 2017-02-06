<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class SizeImageController extends BaseAdminController
{
    private $permission_view = 'sizeImage_view';
    private $permission_full = 'sizeImage_full';
    private $permission_delete = 'sizeImage_delete';
    private $permission_create = 'sizeImage_create';
    private $permission_edit = 'sizeImage_edit';
    private $arrStatus = array(-1 => '--Chọn trạng thái--', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
    private $error = array();

    public function __construct()
    {
        parent::__construct();
        FunctionLib::link_css(array(
            'lib/upload/cssUpload.css',
        ));

        //Include javascript.
        FunctionLib::link_js(array(
            'lib/number/autoNumeric.js',
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

        $search['size_img_name'] = addslashes(Request::get('size_img_name',''));
        $search['size_img_status'] = (int)Request::get('size_img_status',-1);
        $search['size_img_width'] = (int)Request::get('size_img_width',-1);
        $search['size_img_height'] = (int)Request::get('size_img_height',0);

        $dataSearch = SizeImage::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //FunctionLib::debug($dataSearch);
        $optionStatus = FunctionLib::getOption($this->arrStatus, $search['size_img_status']);
        $this->layout->content = View::make('admin.SizeImage.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('optionStatus', $optionStatus)

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
        $action = $this->getControllerAction();
        if(strcmp($action,'admin.sizeImageCopy') == 0 && $id <= 0){
            return Redirect::route('admin.sizeImageView');
        }
        $data = array();
        if($id > 0) {
            $data = SizeImage::getByID($id);
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['size_img_status'])? $data['size_img_status']: CGlobal::status_show);
        $this->layout->content = View::make('admin.SizeImage.add')
            ->with('id', (strcmp($action,'admin.sizeImageCopy') == 0)? 0: $id)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('arrStatus', $this->arrStatus);
    }

    public function postItem($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $data['size_img_name'] = Request::get('size_img_name');
        $data['size_img_width'] = (int)str_replace('.','',Request::get('size_img_width'));
        $data['size_img_height'] = (int)str_replace('.','',Request::get('size_img_height'));
        $data['size_img_status'] = (int)Request::get('size_img_status', CGlobal::status_show);
        $id_hiden = (int)Request::get('id_hiden', 0);

        $action = $this->getControllerAction();
        if(strcmp($action,'admin.sizeImageCopy') == 0){
            $id = 0;
        }
        if($this->valid($data) && empty($this->error)) {
            $id = ($id == 0)?$id_hiden: $id;
            if($id > 0) {
                if(SizeImage::updateData($id, $data)) {
                    return Redirect::route('admin.sizeImageView');
                }
            }else{
                if(SizeImage::addData($data)) {
                    return Redirect::route('admin.sizeImageView');
                }
            }
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['size_img_status'])? $data['size_img_status']: CGlobal::STASTUS_HIDE);
        $this->layout->content =  View::make('admin.SizeImage.add')
            ->with('id', $id)
            ->with('error', $this->error)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('arrStatus', $this->arrStatus);
    }

    public function deleteSizeImage()
    {
        $data = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && SizeImage::deleteData($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }
    private function valid($data=array()) {
        if(!empty($data)) {
            if(isset($data['size_img_name']) && trim($data['size_img_name']) == '') {
                $this->error[] = 'Tên Size không được bỏ trống';
            }
            if(isset($data['size_img_width']) && trim($data['size_img_width']) > -1 && isset($data['size_img_height']) && trim($data['size_img_height']) > -1) {
                $checkSize = SizeImage::checkSize((int)$data['size_img_width'],(int)$data['size_img_height']);
                if($checkSize){
                    $this->error[] = 'Trùng Width hoặc Height đã tồn tại';
                }
            }else{
                $this->error[] = 'Tên Size không được bỏ trống';
            }
        }
        return true;
    }
}