<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

class InfoController extends BaseAdminController{
	private $permission_view = 'infor_view';
	private $permission_full = 'infor_full';
	private $permission_delete = 'infor_delete';
	private $permission_create = 'infor_create';
	private $permission_edit = 'infor_edit';
	
	private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
	private $error = '';
	public function __construct(){
		parent::__construct();
		FunctionLib::link_css(array(
			'lib/upload/cssUpload.css',
		));

		//Include javascript.
		FunctionLib::link_js(array(
			'lib/upload/jquery.uploadfile.js',
			'lib/ckeditor/ckeditor.js',
			'lib/ckeditor/config.js',
			'lib/dragsort/jquery.dragsort.js',
			'js/common.js',
		));
	}
	public function listView(){
		if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}
		//Config Page
		$pageNo = (int) Request::get('page', 1);
		$pageScroll = CGlobal::num_scroll_page;
		$limit = CGlobal::number_limit_show;
		$offset = ($pageNo - 1) * $limit;
		$search = $data = array();
		$total = 0;
		
		$search['info_title'] = addslashes(Request::get('info_title', ''));
		$search['info_status'] = (int)Request::get('info_status', -1);
		$search['field_get'] = '';
		
		$data = Info::searchByCondition($search, $limit, $offset, $total);
		$paging = $total > 0 ? Pagging::getNewPager($pageScroll, $pageNo, $total, $limit, $search) : '';
		$optionStatus = FunctionLib::getOption($this->arrStatus, $search['info_status']);
		$messages = FunctionLib::messages('messages');
		
		$this->layout->content = View::make('admin.info.list')
								->with('data', $data)
								->with('total', $total)
								->with('paging', $paging)
								->with('arrStatus', $this->arrStatus)
								->with('optionStatus', $optionStatus)
								->with('arrLanguage', CGlobal::$arrLanguage)
								->with('arrInforSite', CGlobal::$arrInforSite)
								->with('search', $search)
								->with('is_root', $this->is_root)
								->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)
								->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
								->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)
								->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
								->with('messages', $messages);
	}
	public function getItem($id=0){
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}
		$data = array();
		if($id > 0) {
			$data = Info::getById($id);
		}

		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['info_status'])? $data['info_status'] : CGlobal::status_show);
		$optionInforSite = FunctionLib::getOption(array(''=>'---Chọn kiểu thông tin----')+CGlobal::$arrInforSite, isset($data['info_type'])? $data['info_type'] : '');
		$optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($data['type_language'])? $data['type_language'] : CGlobal::TYPE_LANGUAGE_VIET);
		$this->layout->content = View::make('admin.info.add')
		->with('id', $id)
		->with('data', $data)
		->with('optionStatus', $optionStatus)
		->with('optionInforSite', $optionInforSite)
		->with('optionLanguage', $optionLanguage)
		->with('is_root', $this->is_root)
		->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)
		->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
		->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)
		->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
		->with('error', $this->error);
	}

	public function postItem($id=0){
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}
		$id_hiden = (int)Request::get('id_hiden', 0);
		$data = array();
		
		$dataSave = array(
				'info_title'=>array('value'=>addslashes(Request::get('info_title')), 'require'=>1, 'messages'=>'Tiêu đề không được trống!'),
				'info_type'=>array('value'=>addslashes(Request::get('info_type')),'require'=>1, 'messages'=>'Chưa chọn kiểu thông tin!'),
				'type_language'=>array('value'=>addslashes(Request::get('type_language')),'require'=>0),
				'info_intro'=>array('value'=>addslashes(Request::get('info_intro')),'require'=>0),
				'info_content'=>array('value'=>addslashes(FunctionLib::strReplace(Request::get('info_content'), '\r\n', '')),'require'=>0),
				'info_order_no'=>array('value'=>(int)addslashes(Request::get('info_order_no')),'require'=>0),
				'info_created'=>array('value'=>time()),
				'info_status'=>array('value'=>(int)Request::get('info_status', -1),'require'=>0),
				
				'info_img'=>array('value'=>addslashes(Request::get('image_primary')),'require'=>0),
				'meta_title'=>array('value'=>addslashes(Request::get('meta_title')),'require'=>0),
				'meta_keywords'=>array('value'=>addslashes(Request::get('meta_keywords')),'require'=>0),
				'meta_description'=>array('value'=>addslashes(Request::get('meta_description')),'require'=>0),
		);
		
		if($id > 0){
			unset($dataSave['info_keyword']);
			unset($dataSave['info_created']);
		}
		
		$this->error = ValidForm::validInputData($dataSave);
		if($this->error == ''){
			$id = ($id == 0) ? $id_hiden : $id;
			Info::saveData($id, $dataSave);
			return Redirect::route('admin.info');
		}else{
			foreach($dataSave as $key=>$val){
				$data[$key] = $val['value'];
			}
		}
		
		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['info_status'])? $data['info_status'] : -1);
		$optionInforSite = FunctionLib::getOption(array(''=>'---Chọn kiểu thông tin----')+CGlobal::$arrInforSite, isset($data['info_type'])? $data['info_type'] : '');
		$optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($data['type_language'])? $data['type_language'] : CGlobal::TYPE_LANGUAGE_VIET);
		$this->layout->content = View::make('admin.info.add')
		->with('id', $id)
		->with('data', $data)
		->with('optionStatus', $optionStatus)
		->with('optionInforSite', $optionInforSite)
		->with('optionLanguage', $optionLanguage)
		->with('is_root', $this->is_root)
		->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)
		->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
		->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)
		->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
		->with('error', $this->error);
	}
	public function deleteInfor(){
		$data = array('isIntOk' => 0);
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
			return Response::json($data);
		}
		$id = (int)Request::get('id', 0);
		if ($id > 0 && Info::deleteId($id)) {
			$data['isIntOk'] = 1;
		}
		return Response::json($data);
	}
}