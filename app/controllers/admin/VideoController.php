<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class VideoController extends BaseAdminController
{
    private $permission_view = 'video_view';
    private $permission_full = 'video_full';
    private $permission_delete = 'video_delete';
    private $permission_create = 'video_create';
    private $permission_edit = 'video_edit';
    private $arrStatus = array(-1 => '--Chọn trạng thái--', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
    private $error = array();
    public function __construct()
    {
        parent::__construct();
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

        $search['video_name'] = addslashes(Request::get('video_name',''));
        $search['video_status'] = (int)Request::get('video_status',-1);
        $search['type_language'] = (int)Request::get('type_language',0);

        $dataSearch = Video::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //FunctionLib::debug($dataSearch);
        $optionStatus = FunctionLib::getOption($this->arrStatus, $search['video_status']);
        $optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, $search['type_language']);
        $this->layout->content = View::make('admin.Video.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('optionStatus', $optionStatus)
            ->with('optionLanguage', $optionLanguage)
            ->with('arrLanguage', CGlobal::$arrLanguage)
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
        if($id > 0) {
            $data = Video::getByID($id);
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['banner_status'])? $data['banner_status']: CGlobal::status_show);
        $optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($data['type_language'])? $data['type_language'] : CGlobal::TYPE_LANGUAGE_VIET);

        $this->layout->content = View::make('admin.Video.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('optionLanguage', $optionLanguage)
            ->with('arrStatus', $this->arrStatus);
    }

    public function postItem($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }

        $data['video_name'] = addslashes(Request::get('video_name'));
        $data['video_content'] = FunctionLib::strReplace(Request::get('video_content'), '\r\n', '');
        $data['video_link'] = addslashes(Request::get('video_link'));//ảnh chính
        $data['type_language'] = (int)Request::get('type_language', 1);
        $data['video_status'] = (int)Request::get('video_status', 0);
        $id_hiden = (int)Request::get('id_hiden', 0);

        //FunctionLib::debug($data);
        if($this->valid($data) && empty($this->error)) {
            $id = ($id == 0)?$id_hiden: $id;
            if($id > 0) {
                //cap nhat
                $data['video_time_update'] = time();
                if(Video::updateData($id, $data)) {
                    return Redirect::route('admin.videoView');
                }
            }else{
                //thêm mới
                $data['video_time_creater'] = time();
                if(Video::addData($data)) {
                    return Redirect::route('admin.videoView');
                }
            }
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['video_status'])? $data['video_status']: CGlobal::status_show);
        $optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($data['type_language'])? $data['type_language'] : CGlobal::TYPE_LANGUAGE_VIET);
        $this->layout->content =  View::make('admin.Video.add')
            ->with('id', $id)
            ->with('error', $this->error)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('optionLanguage', $optionLanguage)
            ->with('arrStatus', $this->arrStatus);
    }

    public function deleteVideo()
    {
        $data = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && Video::deleteData($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }
    private function valid($data=array()) {
        if(!empty($data)) {
            if(isset($data['video_name']) && trim($data['video_name']) == '') {
                $this->error[] = 'Tên tên video không được bỏ trống';
            }
            if(isset($data['video_link']) && trim($data['video_link']) == '') {
                $this->error[] = 'Tên Link nguồn Video không được bỏ trống';
            }
        }
        return true;
    }
}