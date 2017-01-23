<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class ToolsCommonController extends BaseAdminController
{
    private $permission_view = 'toolsCommon_view';
    private $permission_full = 'toolsCommon_full';
    private $permission_delete = 'toolsCommon_delete';
    private $permission_create = 'toolsCommon_create';
    private $permission_edit = 'toolsCommon_edit';

    private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
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
            'lib/dragsort/jquery.dragsort.js',
            'js/common.js',
        ));
    }


    /************************************************************************************************************************************
     * @return mixed
     * Quản lý lượt share của shop
     * **********************************************************************************************************************************
     */
    public function viewClickShare() {
        //Check phan quyen.
        if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }

        $pageNo = (int) Request::get('page_no',1);
        $limit = CGlobal::number_limit_show;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['object_name'] = addslashes(Request::get('object_name',''));
        if(!$this->is_root){
            $search['object_id'] = isset($this->user)? $this->user['user_id']:0;
        }else{
            $search['object_id'] = (int)Request::get('object_id',0);
        }
        $dataFilter = $search;

        //ngay bat dau
        $star_time = Request::get('start_time',date('d-m-Y',time()));
        if($star_time != '') {
            $dataFilter['start_time'] = $star_time;
            $search['start_time'] = strtotime($star_time . ' 00:00:00');
        }
        $end_time = Request::get('end_time',date('d-m-Y',time()));
        if($end_time != '') {
            $dataFilter['end_time'] = $end_time;
            $search['end_time'] = strtotime($end_time . ' 23:59:59');
        }

        $dataSearch = ClickShare::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $dataFilter) : '';

        //build link cho CTV share link click
        $string_base = $this->user['user_id'].'_'.$this->user['user_name'];
        $param_sv = '?sv_share='.base64_encode($string_base);
        $url_link_share = 'http://raovat30s.vn'.$param_sv;

        $this->layout->content = View::make('admin.ToolsCommon.viewClickShare')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('url_link_share', $url_link_share)

            ->with('is_root', $this->is_root)//dùng common
            ->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0);//dùng common
    }

    //cập nhật thêm quyền cho hệ thông
    public function addPermit(){
        //http://raovat30s.vn?url_source=aHR0cDovL21pbmhkdWNwcm9wZXJ0eS5jb20v //minh đức
        //echo base64_encode('HuongDanRaoVat30s'); //
        // http://raovat30s.vn/chi-tiet/tin-tuc-4/huong-dan-dang-tin-rao-vat.html?url_source=SHVvbmdEYW5SYW9WYXQzMHM=
        //echo base64_encode('http://minhducproperty.com/');
        $arrPermit = ArrayPermission::$arrPermit;

        /*DB::table('permission')->truncate();
        DB::table('group_user')->truncate();
        DB::table('group_user_permission')->truncate();*/
        foreach($arrPermit as $permit=> $infor){
            $arrInsert = array('permission_code'=>$permit,
                'permission_name'=>$infor['name_permit'],
                'permission_group_name'=>$infor['group_permit'],
                'permission_status'=>1);
            if (!Permission::checkExitsPermissionCode($permit)) {
                Permission::createPermission($arrInsert);
            }
        }
        FunctionLib::debug($arrPermit);
    }
}