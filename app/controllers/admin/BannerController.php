<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class BannerController extends BaseAdminController
{
    private $permission_view = 'banner_view';
    private $permission_full = 'banner_full';
    private $permission_delete = 'banner_delete';
    private $permission_create = 'banner_create';
    private $permission_edit = 'banner_edit';
    private $arrStatus = array(-1 => '--Chọn trạng thái--', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
    private $arrTarget = array(-1 => '--Chọn target link--', CGlobal::BANNER_NOT_TARGET_BLANK => 'Link trên site', CGlobal::BANNER_TARGET_BLANK => 'Mở tab mới');
    private $arrRunTime = array(-1 => '--Chọn thời gian chạy--', CGlobal::BANNER_NOT_RUN_TIME => 'Chạy mãi mãi', CGlobal::BANNER_IS_RUN_TIME => 'Chạy theo thời gian');
    private $arrProvince = array();
    private $arrRel = array(CGlobal::LINK_NOFOLLOW => 'Nofollow', CGlobal::LINK_FOLLOW => 'Follow');
    private $arrPosition = array(0=>'---Chọn vị trí hiển thị ---',
        1=> 'Vị trí Top',
        2=> 'Vị trí Center',
        3=> 'Vị trí Bottom',
        );

    private $arrTypeBanner = array(-1 => '--- Chọn vị trí Banner --',
        CGlobal::BANNER_TYPE_TOP => 'Banner Top Header',
        CGlobal::BANNER_TYPE_LEFT => 'Banner Trái - Phải',
        /*CGlobal::BANNER_TYPE_LEFT => 'Banner Trái',
        CGlobal::BANNER_TYPE_BOTTOM => 'Banner Dưới Footer',
        CGlobal::BANNER_TYPE_CENTER => 'Banner Giữa nội dung'*/
    );

    private $arrCategoryBanner = array(
        CGlobal::BANNER_CATEGORY_QC => 'Banner quảng cáo',
        CGlobal::BANNER_CATEGORY_DOITAC => 'Banner Đối tác',
    );

    const BANNER_PAGE_HOME = 1;
    const BANNER_PAGE_DETAIL = 2;
    const BANNER_PAGE_CATEGORY = 4;
    const BANNER_PAGE_CUSTOMER_ITEMS = 5;
    const BANNER_PAGE_CONTACT = 6;
    const BANNER_PAGE_SEARCH = 7;
    const BANNER_PAGE_OTHER = 8;

    private $arrPage = array(0 => '-- Chọn page --',
        CGlobal::BANNER_PAGE_HOME => 'Page trang chủ',
        CGlobal::BANNER_PAGE_DETAIL=> 'Page chi tiết',
        /*CGlobal::BANNER_PAGE_CATEGORY => 'Page danh mục',
        CGlobal::BANNER_PAGE_CUSTOMER_ITEMS => 'Page Khách đăng tin',
        CGlobal::BANNER_PAGE_SEARCH=> 'Page tìm kiếm',
        CGlobal::BANNER_PAGE_CONTACT => 'Page liên hệ',
        CGlobal::BANNER_PAGE_OTHER => 'Page khác'*/
    );

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

        $search['banner_name'] = addslashes(Request::get('banner_name',''));
        $search['banner_status'] = (int)Request::get('banner_status',-1);
        $search['type_language'] = (int)Request::get('type_language',0);
        $search['banner_type'] = (int)Request::get('banner_type',-1);
        $search['banner_category_id'] = (int)Request::get('banner_category_id',0);

        $dataSearch = Banner::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //FunctionLib::debug($dataSearch);
        $optionStatus = FunctionLib::getOption($this->arrStatus, $search['banner_status']);
        $optionType = FunctionLib::getOption($this->arrTypeBanner, $search['banner_type']);
        $optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, $search['type_language']);
        $optionCategoryBanner = FunctionLib::getOption(array(0=>'---Chọn kiểu banner---')+$this->arrCategoryBanner, $search['banner_category_id']);
        $this->layout->content = View::make('admin.Banner.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('optionStatus', $optionStatus)
            ->with('optionType', $optionType)
            ->with('optionLanguage', $optionLanguage)
            ->with('optionCategoryBanner', $optionCategoryBanner)
            ->with('arrLanguage', CGlobal::$arrLanguage)
            ->with('arrPosition', $this->arrPosition)
            ->with('arrStatus', $this->arrStatus)
            ->with('arrTypeBanner', $this->arrTypeBanner)

            ->with('is_root', $this->is_root)//dùng common
            ->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0);//dùng common
    }

    public function getBanner($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $action = $this->getControllerAction();
        if(strcmp($action,'admin.bannerCopy') == 0 && $id <= 0){
            return Redirect::route('admin.bannerView');
        }
        $data = array();
        if($id > 0) {
            $banner = Banner::getBannerByID($id);
            $data = array('banner_id'=>$banner->banner_id,
                'banner_name'=>$banner->banner_name,
                'banner_image'=>(strcmp($action,'admin.bannerCopy') == 0)? '' : $banner->banner_image,
                'banner_link'=>$banner->banner_link,
                'banner_position'=>$banner->banner_position,
                //'banner_parent_id'=>$banner->banner_parent_id,
                'banner_order'=>$banner->banner_order,
                'banner_is_target'=>$banner->banner_is_target,
                'banner_is_rel'=>$banner->banner_is_rel,
                'banner_type'=>$banner->banner_type,
                'type_language'=>$banner->type_language,
                'banner_intro'=>$banner->banner_intro,
                //'banner_page'=>$banner->banner_page,
                'banner_category_id'=>$banner->banner_category_id,
                'banner_is_run_time'=>$banner->banner_is_run_time,
                'banner_start_time'=>$banner->banner_start_time,
                'banner_end_time'=>$banner->banner_end_time,
                //'banner_province_id'=>$banner->banner_province_id,
                'banner_status'=>$banner->banner_status);
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['banner_status'])? $data['banner_status']: CGlobal::status_show);
        $optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($data['type_language'])? $data['type_language'] : CGlobal::TYPE_LANGUAGE_VIET);
        $optionRunTime = FunctionLib::getOption($this->arrRunTime, isset($data['banner_is_run_time'])? $data['banner_is_run_time']: CGlobal::BANNER_NOT_RUN_TIME);

        $optionTypeBanner = FunctionLib::getOption($this->arrTypeBanner, isset($data['banner_type'])? $data['banner_type']: 1);
        $optionCategoryBanner = FunctionLib::getOption($this->arrCategoryBanner, isset($data['banner_category_id'])? $data['banner_category_id']: CGlobal::BANNER_CATEGORY_QC);
        $optionTarget = FunctionLib::getOption($this->arrTarget, isset($data['banner_is_target'])? $data['banner_is_target']: CGlobal::BANNER_TARGET_BLANK);
        $optionRel = FunctionLib::getOption($this->arrRel, isset($data['banner_is_rel'])? $data['banner_is_rel']: CGlobal::LINK_NOFOLLOW);

        $this->layout->content = View::make('admin.Banner.add')
            ->with('id', (strcmp($action,'admin.bannerCopy') == 0)? 0:$id)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('optionLanguage', $optionLanguage)
            ->with('optionRunTime', $optionRunTime)
            ->with('optionTypeBanner', $optionTypeBanner)
            ->with('optionCategoryBanner', $optionCategoryBanner)
            ->with('optionTarget', $optionTarget)
            ->with('optionRel', $optionRel)
            ->with('arrStatus', $this->arrStatus);
    }

    public function postBanner($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }

        $data['banner_name'] = addslashes(Request::get('banner_name'));
        $data['banner_link'] = addslashes(Request::get('banner_link'));
        $data['banner_image'] = addslashes(Request::get('image_primary'));//ảnh chính
        $data['banner_order'] = addslashes(Request::get('banner_order'));
        $data['banner_intro'] = addslashes(Request::get('banner_intro'));

        $data['banner_category_id'] = (int)Request::get('banner_category_id', 1);
        $data['type_language'] = (int)Request::get('type_language', 1);
        $data['banner_is_target'] = (int)Request::get('banner_is_target', 0);
        $data['banner_is_rel'] = (int)Request::get('banner_is_rel', 0);
        $data['banner_type'] = (int)Request::get('banner_type',0);
        $data['banner_is_run_time'] = (int)Request::get('banner_is_run_time');
        $data['banner_start_time'] = Request::get('banner_start_time');
        $data['banner_end_time'] = Request::get('banner_end_time');
        $data['banner_status'] = (int)Request::get('banner_status', 0);

        //$data['banner_position'] = (int)Request::get('banner_position', 1);
        //$data['banner_parent_id'] = (int)Request::get('banner_parent_id', 0);
        //$data['banner_page'] = (int)Request::get('banner_page',0);
        //$data['banner_category_id'] = (int)Request::get('banner_category_id',0);
        //$data['banner_province_id'] = (int)Request::get('banner_province_id',0);

        $id_hiden = (int)Request::get('id_hiden', 0);

        $action = $this->getControllerAction();
        if(strcmp($action,'admin.bannerCopy') == 0){
            $id = 0;
        }

        //FunctionLib::debug($data);
        if($this->valid($data) && empty($this->error)) {
            $id = ($id == 0)?$id_hiden: $id;
            $data['banner_start_time'] = strtotime($data['banner_start_time']);
            $data['banner_end_time'] = strtotime($data['banner_end_time']);
            if($id > 0) {
                //cap nhat
                $data['banner_update_time'] = time();
                if(Banner::updateData($id, $data)) {
                    return Redirect::route('admin.bannerView');
                }
            }else{
                //thêm mới
                $data['banner_create_time'] = time();
                if(Banner::addData($data)) {
                    return Redirect::route('admin.bannerView');
                }
            }
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['banner_status'])? $data['banner_status']: CGlobal::STASTUS_HIDE);
        $optionRunTime = FunctionLib::getOption($this->arrRunTime, isset($data['banner_is_run_time'])? $data['banner_is_run_time']: CGlobal::BANNER_NOT_RUN_TIME);
        $optionTypeBanner = FunctionLib::getOption($this->arrTypeBanner, isset($data['banner_type'])? $data['banner_type']: -1);
        $optionTarget = FunctionLib::getOption($this->arrTarget, isset($data['banner_is_target'])? $data['banner_is_target']: CGlobal::BANNER_TARGET_BLANK);
        $optionCategory = FunctionLib::getOption(array(0=>'--- Chọn danh mục quảng cáo ---')+$this->arrCategoryParent, isset($data['banner_category_id'])? $data['banner_category_id']: 0);
        $optionRel = FunctionLib::getOption($this->arrRel, isset($data['banner_is_rel'])? $data['banner_is_rel']: CGlobal::LINK_NOFOLLOW);
        $optionCategoryBanner = FunctionLib::getOption($this->arrCategoryBanner, isset($data['banner_category_id'])? $data['banner_category_id']: CGlobal::BANNER_CATEGORY_QC);
        $optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($data['type_language'])? $data['type_language'] : CGlobal::TYPE_LANGUAGE_VIET);
        $data['banner_start_time'] = strtotime($data['banner_start_time']);
        $data['banner_end_time'] = strtotime($data['banner_end_time']);
        $this->layout->content =  View::make('admin.Banner.add')
            ->with('id', $id)
            ->with('error', $this->error)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('optionCategory', $optionCategory)
            ->with('optionRunTime', $optionRunTime)
            ->with('optionTypeBanner', $optionTypeBanner)
            ->with('optionTarget', $optionTarget)
            ->with('optionRel', $optionRel)
            ->with('optionCategoryBanner', $optionCategoryBanner)
            ->with('optionLanguage', $optionLanguage)
            ->with('arrStatus', $this->arrStatus);
    }

    public function deleteBanner()
    {
        $data = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && Banner::deleteData($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }
    private function valid($data=array()) {
        if(!empty($data)) {
            if(isset($data['banner_name']) && trim($data['banner_name']) == '') {
                $this->error[] = 'Tên banner không được bỏ trống';
            }
            if(isset($data['banner_type']) && trim($data['banner_type']) == 0) {
                $this->error[] = 'Chưa chọn loại Banner';
            }
            if(isset($data['banner_link']) && trim($data['banner_link']) == '') {
                $this->error[] = 'Chưa có link view cho banner';
            }
            if(isset($data['banner_image']) && trim($data['banner_image']) == '' && isset($data['banner_parent_id']) && (int)trim($data['banner_parent_id']) == 0) {
                $this->error[] = 'Chưa up ảnh banner quảng cáo';
            }
            if(isset($data['banner_is_run_time']) && $data['banner_is_run_time'] == 1) {
                if(isset($data['banner_start_time']) && $data['banner_start_time'] == '' ) {
                    $this->error[] = 'Chưa chọn thời gian bắt đầu chạy cho banner';
                }
                if(isset($data['banner_end_time']) && $data['banner_end_time'] == '') {
                    $this->error[] = 'Chưa chọn thời gian kết thúc cho banner';
                }
                if(isset($data['banner_end_time']) && isset($data['banner_start_time'])  && (strtotime($data['banner_start_time']) > strtotime($data['banner_end_time']))) {
                    $this->error[] = 'Thời gian bắt đầu lớn hơn thời gian kết thúc';
                }
            }
        }
        return true;
    }
}