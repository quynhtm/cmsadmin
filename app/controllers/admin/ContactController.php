<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class ContactController extends BaseAdminController
{
    private $permission_full = 'contract_full';
    private $permission_view = 'contract_view';
    private $permission_delete = 'contract_delete';
    private $permission_create = 'contract_create';
    private $permission_edit = 'contract_edit';
    private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện', CGlobal::status_block => 'Khóa');
    private $arrShop = array();
    private $error = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function viewContract() {
        //Check phan quyen.
        if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }

        $pageNo = (int) Request::get('page_no',1);
        $limit = CGlobal::number_limit_show;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['contact_title'] = addslashes(Request::get('contact_title',''));
        $search['contact_user_name_send'] = addslashes(Request::get('contact_user_name_send',''));

        $dataSearch = Contact::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';
        $optionStatus = FunctionLib::getOption($this->arrStatus, 1);
        $this->layout->content = View::make('admin.Contact.view')
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

    public function getContact($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $data = array();
        if($id > 0) {
            $item = Contact::getByID($id);
            if($item){
                $data['provider_id'] = $item->provider_id;
                $data['provider_name'] = $item->provider_name;
                $data['provider_phone'] = $item->provider_phone;
                $data['provider_address'] = $item->provider_address;
                $data['provider_email'] = $item->provider_email;
                $data['provider_shop_id'] = $item->provider_shop_id;
                $data['provider_shop_name'] = $item->provider_shop_name;
                $data['provider_status'] = $item->provider_status;
                $data['provider_note'] = $item->provider_note;
                $data['provider_time_creater'] = $item->provider_time_creater;
            }
        }
        //FunctionLib::debug($data);
        $optionShop = FunctionLib::getOption(array(0=>'-- Chọn Shop ---') + $this->arrShop, isset($data['provider_shop_id'])? $data['provider_shop_id'] : 0);
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['provider_status'])? $data['provider_status'] : -1);
        $this->layout->content = View::make('admin.Contact.add')
            ->with('id', $id)
            ->with('error', $this->error)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('optionShop', $optionShop)
            ->with('optionIsShop', array())
            ->with('arrStatus', $this->arrStatus);
    }

    //ajax
    public function deleteContact(){
        $result = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($result);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && Contact::deleteData($id)) {
            $result['isIntOk'] = 1;
        }
        return Response::json($result);
    }

}