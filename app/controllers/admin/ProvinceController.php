<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

class ProvinceController extends BaseAdminController{
	private $permission_view = 'province_view';
	private $permission_full = 'province_full';
	private $permission_delete = 'province_delete';
	private $permission_create = 'province_create';
	private $permission_edit = 'province_edit';
	private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
	private $error = '';
	public function __construct(){
		parent::__construct();
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
		CGlobal::$pageAdminTitle = "Tỉnh thành | ".CGlobal::web_name;
		//Config Page
		$pageNo = (int) Request::get('page', 1);
		$pageScroll = CGlobal::num_scroll_page;
		$limit = CGlobal::number_limit_show;
		$offset = $stt = ($pageNo - 1) * $limit;
		$search = $data = array();
		$total = 0;
		
		$search['province_name'] = addslashes(Request::get('province_name', ''));
		$search['province_id'] = (int)Request::get('province_id', '');
		$search['province_status'] = (int)Request::get('province_status', -1);
		$search['field_get'] = '';
		
		$data = Province::searchByCondition($search, $limit, $offset, $total);
		$paging = $total > 0 ? Pagging::getNewPager($pageScroll, $pageNo, $total, $limit, $search) : '';
		
		$optionStatus = FunctionLib::getOption($this->arrStatus, $search['province_status']);
		$this->layout->content = View::make('admin.Province.list')
								->with('stt', $stt)
								->with('data', $data)
								->with('total', $total)
								->with('paging', $paging)
								->with('is_root', $this->is_root)
								->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)
								->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
								->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)
								->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
								->with('arrStatus', $this->arrStatus)
								->with('optionStatus', $optionStatus)
								->with('search', $search);
	}

	public function getItem($id=0) {
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}
		$data = $listDistrict = array();
		$arrViewImgOther = array();
		$imageOrigin = $urlImageOrigin = '';
		if($id > 0) {
			$data = Province::getById($id);
			//lấy quan huyen lien quan
			$listDistrict = Districts::getInforDistrictWithProvinceId($id);
		}
		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['province_status'])? $data['province_status'] : CGlobal::status_show);
		$this->layout->content = View::make('admin.Province.add')
			->with('id', $id)
			->with('data', $data)
			->with('listDistrict', $listDistrict)
			->with('imageOrigin', $imageOrigin)
			->with('urlImageOrigin', $urlImageOrigin)
			->with('arrViewImgOther', $arrViewImgOther)
			->with('optionStatus', $optionStatus)
			->with('arrStatus', $this->arrStatus);
	}
	public function postItem($id=0) {
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}
		$dataSave['province_name'] = addslashes(Request::get('province_name'));
		$dataSave['province_position'] = addslashes(Request::get('province_position'));
		$dataSave['province_status'] = (int)Request::get('province_status', 0);
		$id_hiden = (int)Request::get('id_hiden', 0);
		$listDistrict = array();
		//FunctionLib::debug($dataSave);
		if($this->valid($dataSave) && empty($this->error)) {
			$id = ($id == 0)?$id_hiden: $id;
			if($id > 0) {
				//cap nhat
				if(Province::updateData($id, $dataSave)) {
					return Redirect::route('admin.province');
				}
				$listDistrict = Districts::getInforDistrictWithProvinceId($id);
			} else {
				//them moi
				if(Province::addData($dataSave)) {
					return Redirect::route('admin.province');
				}
			}
		}

		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['province_status'])? $dataSave['province_status'] : -1);
		$this->layout->content =  View::make('admin.Province.add')
			->with('id', $id)
			->with('data', $dataSave)
			->with('listDistrict', $listDistrict)
			->with('optionStatus', $optionStatus)
			->with('error', $this->error)
			->with('arrStatus', $this->arrStatus);
	}
	private function valid($data=array()) {
		if(!empty($data)) {
			if(isset($data['province_name']) && trim($data['province_name']) == '') {
				$this->error[] = 'Tên tỉnh thành không được bỏ trống';
			}
		}
		return true;
	}

	public function deleteProvince(){
		$data = array('isIntOk' => 0);
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
			return Response::json($data);
		}
		$id = (int)Request::get('id', 0);
		if ($id > 0 && Province::deleteData($id)) {
			$data['isIntOk'] = 1;
		}
		return Response::json($data);
	}

	public function getInforDistrictOfProvince(){
		$district_province_id = Request::get('district_province_id',0);
		$district_id = Request::get('district_id',0);
		$arrData = $data = array();
		$arrData['intReturn'] = 1;
		$arrData['msg'] = '';
		//neu sửa
		if($district_id > 0){
			$data = Districts::getByID($district_id);
		}
		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['district_status'])? $data['district_status'] : -1);
		$html = View::make('admin.Province.addDistrict')
			->with('data', $data)
			->with('optionStatus', $optionStatus)
			->with('district_id', $district_id)
			->with('district_province_id', $district_province_id)
			->render();
		$arrData['html'] = $html;
		return json_encode($arrData);
	}
	public function submitInforDistrictOfProvince(){
		$arrData = array();
		$arrData['intReturn'] = 0;
		$arrData['msg'] = '';
		$district_id = Request::get('district_id',0);
		$district_province_id = Request::get('district_province_id',0);

		$district_name = Request::get('district_name','');
		$district_status = Request::get('district_status',CGlobal::status_show);
		$district_position = Request::get('district_position',50);

		$dataUpdate = array(
			'district_name'=>$district_name,
			'district_status'=>$district_status,
			'district_position'=>$district_position,
			'district_province_id'=>$district_province_id);

		$id_district = ($district_id == 0)?Districts::addData($dataUpdate): Districts::updateData($district_id,$dataUpdate);
		if($id_district) {
			if ($id_district > 0) {
				$arrData['intReturn'] = 1;
			}else{
				$arrData['msg'] = 'Chưa cập nhật được';
			}
		}
		return json_encode($arrData);
	}
}