<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

class LangsController extends BaseAdminController{
	private $permission_view = 'lang_view';
	private $permission_full = 'lang_full';
	private $permission_delete = 'lang_delete';
	private $permission_create = 'lang_create';
	private $permission_edit = 'lang_edit';
	
	private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
	private $error = '';
	public function __construct(){
		parent::__construct();
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
		
		$search['language_keyword'] = addslashes(Request::get('language_keyword', ''));
		$search['language_status'] = (int)Request::get('language_status', -1);
		$search['field_get'] = '';
		
		$data = Langs::searchByCondition($search, $limit, $offset, $total);
		$paging = $total > 0 ? Pagging::getNewPager($pageScroll, $pageNo, $total, $limit, $search) : '';
		$optionStatus = FunctionLib::getOption($this->arrStatus, $search['language_status']);
		$messages = FunctionLib::messages('messages');
		
		$this->layout->content = View::make('admin.lang.list')
								->with('data', $data)
								->with('total', $total)
								->with('paging', $paging)
								->with('arrStatus', $this->arrStatus)
								->with('optionStatus', $optionStatus)
								->with('arrLanguage', CGlobal::$arrLanguage)
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
			$data = Langs::getById($id);
		}

		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['language_status'])? $data['language_status'] : CGlobal::status_show);
		$optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($data['language_lang'])? $data['language_lang'] : CGlobal::TYPE_LANGUAGE_VIET);
		$this->layout->content = View::make('admin.lang.add')
		->with('id', $id)
		->with('data', $data)
		->with('optionStatus', $optionStatus)
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
				'language_keyword'=>array('value'=>addslashes(Request::get('language_keyword')), 'require'=>1, 'messages'=>'Từ khóa không được trống!'),
				'language_lang'=>array('value'=>addslashes(Request::get('language_lang')),'require'=>0),
				'language_content'=>array('value'=>addslashes(FunctionLib::strReplace(Request::get('language_content'), '\r\n', '')),'require'=>0),
				'language_status'=>array('value'=>(int)Request::get('language_status', -1),'require'=>0),	
		);
		
		if($id > 0){
			unset($dataSave['language_keyword']);
		}
		
		$this->error = ValidForm::validInputData($dataSave);
		if($this->error == ''){
			$id = ($id == 0) ? $id_hiden : $id;
			Langs::saveData($id, $dataSave);
			return Redirect::route('admin.lang');
		}else{
			foreach($dataSave as $key=>$val){
				$data[$key] = $val['value'];
			}
		}
		
		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['language_status'])? $data['language_status'] : -1);
		$optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($data['language_lang'])? $data['language_lang'] : CGlobal::TYPE_LANGUAGE_VIET);
		
		$this->layout->content = View::make('admin.lang.add')
		->with('id', $id)
		->with('data', $data)
		->with('optionStatus', $optionStatus)
		->with('optionLanguage', $optionLanguage)
		->with('is_root', $this->is_root)
		->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)
		->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
		->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)
		->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
		->with('error', $this->error);
	}
	public function deleteLang(){
		$data = array('isIntOk' => 0);
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
			return Response::json($data);
		}
		$id = (int)Request::get('id', 0);
		if ($id > 0 && Langs::deleteId($id)) {
			$data['isIntOk'] = 1;
		}
		return Response::json($data);
	}
}