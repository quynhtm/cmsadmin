<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class NewsController extends BaseAdminController
{
    private $permission_view = 'news_view';
    private $permission_full = 'news_full';
    private $permission_delete = 'news_delete';
    private $permission_create = 'news_create';
    private $permission_edit = 'news_edit';
    private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Hidden', CGlobal::status_show => 'Show');
    private $arrHot = array(-1 => 'Chọn nổi bật', CGlobal::status_hide => 'Không', CGlobal::status_show => 'Có');
    private $error = array();
    private $arrCategoryNew = array();
    private $arrTypeNew = array();

    public function __construct()
    {
        parent::__construct();

        $this->arrCategoryNew = CGlobal::$arrCategoryNew;
        $this->arrTypeNew = CGlobal::$arrTypeNew;

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

        $search['news_title'] = addslashes(Request::get('news_title',''));
        $search['news_status'] = (int)Request::get('news_status',-1);
        $search['field_get'] = '';//cac truong can lay

        $dataSearch = News::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        if(!empty($dataSearch)){
            foreach($dataSearch as $k=> $val){
                $url_image = ($val->news_image != '')?ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $val->news_id, $val->news_image, CGlobal::sizeImage_100,  '', true, CGlobal::type_thumb_image_banner, false):'';
                $data[] = array('news_id'=>$val->news_id,
                    'news_title'=>$val->news_title,
                    'news_status'=>$val->news_status,
                    'news_category_name'=>$val->news_category_name,
                    'type_language'=>$val->type_language,
                	'news_hot'=>$val->news_hot,
                    'url_image'=>$url_image,
                );
            }
        }
        //FunctionLib::debug($dataSearch);
        $optionStatus = FunctionLib::getOption($this->arrStatus, $search['news_status']);
        $this->layout->content = View::make('admin.News.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $data)
            ->with('search', $search)
            ->with('arrLanguage', CGlobal::$arrLanguage)
            ->with('optionStatus', $optionStatus)
            ->with('arrStatus', $this->arrStatus)
            ->with('arrHot', $this->arrHot)
            ->with('is_root', $this->is_root)//dùng common
            ->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0);//dùng common
    }

    public function getNews($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $data = array();
        $arrViewImgOther = array();
        $imagePrimary = $urlImageOrigin = '';
        if($id > 0) {
            $data = News::getNewByID($id);
            if(sizeof($data) > 0){
                //lay ảnh khác của san phẩm
                $arrViewImgOther = array();
                if(!empty($data->news_image_other)){
                    $arrImagOther = unserialize($data->news_image_other);
                    if(sizeof($arrImagOther) > 0){
                        foreach($arrImagOther as $k=>$val){
                            $url_thumb = ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $id, $val, CGlobal::sizeImage_100,  '', true, CGlobal::type_thumb_image_banner, false);
                            $arrViewImgOther[] = array('img_other'=>$val,'src_img_other'=>$url_thumb);
                        }
                    }
                }
                //ảnh sản phẩm chính
                $imagePrimary = $data->news_image;
            }
        }
        //lay danh muc theo ngôn ngữ
        $type_language = isset($data->type_language)?$data->type_language: CGlobal::TYPE_LANGUAGE_VIET;
        $this->arrCategoryNew = Category::getCateWithLanguage($type_language);
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['news_status'])? $data['news_status'] : CGlobal::status_show);
        $optionCategory = FunctionLib::getOption(array(0=>'---Chọn danh mục---')+$this->arrCategoryNew, isset($data['news_category'])? $data['news_category'] : CGlobal::NEW_CATEGORY_TIN_TUC_CHUNG);
        $optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($data['type_language'])? $data['type_language'] : CGlobal::TYPE_LANGUAGE_VIET);
        $optionHot = FunctionLib::getOption($this->arrHot, isset($data['news_hot'])? $data['news_hot'] : CGlobal::status_hide);
        
        $this->layout->content = View::make('admin.News.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('imagePrimary', $imagePrimary)
            ->with('urlImageOrigin', $urlImageOrigin)
            ->with('arrViewImgOther', $arrViewImgOther)
            ->with('optionStatus', $optionStatus)
            ->with('optionHot', $optionHot)
            ->with('optionCategory', $optionCategory)
            ->with('optionLanguage', $optionLanguage)
            ->with('arrStatus', $this->arrStatus);
    }
    public function postNews($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $dataSave['news_title'] = addslashes(Request::get('news_title'));
        $dataSave['news_desc_sort'] = addslashes(Request::get('news_desc_sort'));
        $dataSave['news_content'] = FunctionLib::strReplace(Request::get('news_content'), '\r\n', '');
        $dataSave['news_type'] = addslashes(Request::get('news_type'));
        $dataSave['news_category'] = (int)Request::get('news_category',0);
        $dataSave['news_status'] = (int)Request::get('news_status', 0);
        $dataSave['type_language'] = (int)Request::get('type_language', CGlobal::TYPE_LANGUAGE_VIET);
        
        $dataSave['news_hot'] = (int)Request::get('news_hot', 0);
        $dataSave['news_meta_title'] = addslashes(Request::get('news_meta_title'));
        $dataSave['news_meta_keyword'] = addslashes(Request::get('news_meta_keyword'));
        $dataSave['news_meta_description'] = addslashes(Request::get('news_meta_description'));
        
        
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
            $dataSave['news_image'] = ($image_primary != '')? $image_primary: $arrInputImgOther[0];
            $dataSave['news_image_other'] = serialize($arrInputImgOther);
        }

        //FunctionLib::debug($dataSave);
        if($this->valid($dataSave) && empty($this->error)) {
            $id = ($id == 0)?$id_hiden: $id;
            $dataSave['news_category_name'] = Category::getNameCategory($dataSave['news_category']);

            if($id > 0) {
                //cap nhat
                if(News::updateData($id, $dataSave)) {
                    return Redirect::route('admin.newsView');
                }
            } else {
                $dataSave['news_create'] = time();
                //them moi
                if(News::addData($dataSave)) {
                    return Redirect::route('admin.newsView');
                }
            }
        }
        
        //lay danh muc theo ngôn ngữ
        $type_language = isset($dataSave['type_language']) ?$dataSave['type_language']: CGlobal::TYPE_LANGUAGE_VIET;
        $this->arrCategoryNew = Category::getCateWithLanguage($type_language);

        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['news_status'])? $dataSave['news_status'] : CGlobal::status_show);
        $optionCategory = FunctionLib::getOption(array(0=>'---Chose category news---')+$this->arrCategoryNew, isset($dataSave['news_category'])? $dataSave['news_category'] : CGlobal::NEW_CATEGORY_TIN_TUC_CHUNG);
        $optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($dataSave['type_language'])? $dataSave['type_language'] : CGlobal::TYPE_LANGUAGE_VIET);
        $optionHot = FunctionLib::getOption($this->arrHot, isset($data['news_hot'])? $data['news_hot'] : CGlobal::status_hide);
        $this->layout->content =  View::make('admin.News.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('optionStatus', $optionStatus)
            ->with('optionHot', $optionHot)
            ->with('optionCategory', $optionCategory)
            ->with('optionLanguage', $optionLanguage)
            ->with('error', $this->error)
            ->with('arrStatus', $this->arrStatus)
        	->with('arrHot', $this->arrHot);
    }

    public function getCategoryNewsLanguage(){
        $data = array('isIntOk' => 0,'msg' => 'Không lấy được danh mục');
        $type_language = (int)Request::get('type_language', 0);
        if ($type_language > 0) {
            $arrCategoryNew = Category::getCateWithLanguage($type_language);
            if(!empty($arrCategoryNew)){
                $str_option = '<option value="0">---Chose category news---</option>';
                foreach($arrCategoryNew as $dis_id =>$dis_name){
                    $str_option .='<option value="'.$dis_id.'">'.$dis_name.'</option>';
                }
                $data['html_option'] = $str_option;
                $data['isIntOk'] = 1;
            }
        }
        return Response::json($data);
    }

    public function deleteNews(){
        $data = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && News::deleteData($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    private function valid($data=array()) {
        if(!empty($data)) {
            if(isset($data['category_name']) && $data['category_name'] == '') {
                $this->error[] = 'Tên danh mục không được trống';
            }
            if(isset($data['category_status']) && $data['category_status'] == -1) {
                $this->error[] = 'Bạn chưa chọn trạng thái cho danh mục';
            }
            return true;
        }
        return false;
    }

    function sendEmail(){
         // test gửi email
         Mail::send('emails.test_email', array('firstname'=>'Trương Mạnh Quỳnh'), function($message){
             $message->to('manhquynh1984@gmail.com', 'Trương Mạnh Quỳnh')
                 ->subject('Welcome to the Laravel 4 Auth App!');
         });
         die();
    }

}