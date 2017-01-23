<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class CategoryController extends BaseAdminController
{
    private $permission_view = 'category_view';
    private $permission_full = 'category_full';
    private $permission_delete = 'category_delete';
    private $permission_create = 'category_create';
    private $permission_edit = 'category_edit';
    private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Hidden', CGlobal::status_show => 'Show');
    private $arrShowHome = array(-1 => 'Chọn hiển thị', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
    
    private $arrCategoryParent = array(-1 => 'Danh mục cha');

    public function __construct()
    {
        parent::__construct();

        //Include style.
        FunctionLib::link_css(array(
            'lib/cssUpload.css',
        ));

        //Include javascript.
        FunctionLib::link_js(array(
            'lib/jquery.uploadfile.js',
        ));
        
        $this->arrCategoryParent = $this->arrCategoryParent + Category::getAllParentCategoryId();
    }

    public function view() {
        //Check phan quyen.
        if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $pageNo = (int) Request::get('page_no',1);
        $limit = CGlobal::number_limit_show;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = $treeCategroy = array();
        $total = 0;

        $search['category_id'] = addslashes(Request::get('category_id',''));
        $search['category_name'] = addslashes(Request::get('category_name',''));
        $search['category_status'] = (int)Request::get('category_status',-1);

        $dataSearch = Category::searchByCondition($search, 500, $offset,$total);
        $paging = '';

        $optionStatus = FunctionLib::getOption($this->arrStatus, $search['category_status']);
        $this->layout->content = View::make('admin.Category.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('optionStatus', $optionStatus)
            ->with('arrStatus', $this->arrStatus)
            ->with('arrCategoryType', CGlobal::$arrCategoryType)
            ->with('arrLanguage', CGlobal::$arrLanguage)

            ->with('is_root', $this->is_root)//dùng common
            ->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0);//dùng common
    }
    public function getTreeCategory($data){
        $max = 0;
        $aryCategoryProduct = $arrCategory = array();
        if(!empty($data)){
            foreach ($data as $k=>$value){
                $max = ($max < $value->category_parent_id)? $value->category_parent_id : $max;
                $arrCategory[$value->category_id] = array(
                    'category_id'=>$value->category_id,
                    'category_parent_id'=>$value->category_parent_id,
                	'category_icons'=>$value->category_icons,
                	'category_content_front'=>$value->category_content_front,
                    'category_content_front_order'=>$value->category_content_front_order,
                    'category_order'=>$value->category_order,
                    'category_status'=>$value->category_status,
                    'category_name'=>$value->category_name);
            }
        }

        if($max > 0){
            $aryCategoryProduct = self::showCategory($max, $arrCategory);
        }
        return $aryCategoryProduct;
    }
    public function showCategory($max, $aryDataInput) {
        $aryData = array();
        if(is_array($aryDataInput) && count($aryDataInput) > 0) {
            foreach ($aryDataInput as $k => $val) {
                if((int)$val['category_parent_id'] == 0) {
                    $val['padding_left'] = '';
                    $val['category_parent_name'] = '';
                    $aryData[] = $val;
                    self::showSubCategory($val['category_id'],$val['category_name'], $max, $aryDataInput, $aryData);
                }
            }
        }
        return $aryData;
    }
    public static function showSubCategory($cat_id,$cat_name, $max, $aryDataInput, &$aryData) {
        if($cat_id <= $max) {
            foreach ($aryDataInput as $chk => $chval) {
                if($chval['category_parent_id'] == $cat_id) {
                    $chval['padding_left'] = '---------- ';
                    $chval['category_parent_name'] = $cat_name;
                    $aryData[] = $chval;
                    self::showSubCategory($chval['category_id'],$chval['category_name'], $max, $aryDataInput, $aryData);
                }
            }
        }
    }


    public function getCategroy($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $data = array();
        if($id > 0) {
            $data = Category::find($id);
        }

        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['category_status'])? $data['category_status'] : -1);
        $optionShowContent = FunctionLib::getOption($this->arrStatus, isset($data['category_show_content'])? $data['category_show_content'] : 0);
        $optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($data['type_language'])? $data['type_language'] : CGlobal::TYPE_LANGUAGE_VIET);
        $optionCategoryType = FunctionLib::getOption(CGlobal::$arrCategoryType, isset($data['category_type'])? $data['category_type'] : CGlobal::CATEGORY_TYPE_NEW);

        $this->layout->content = View::make('admin.Category.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('arrStatus', $this->arrStatus)
            ->with('optionLanguage', $optionLanguage)
            ->with('optionShowContent', $optionShowContent)
            ->with('optionCategoryType', $optionCategoryType);
    }

    public function postCategory($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }

        $dataSave['category_name'] = addslashes(Request::get('category_name'));
        $dataSave['category_status'] = (int)Request::get('category_status', 0);
        $dataSave['category_parent_id'] = (int)Request::get('category_parent_id', 0);
        $dataSave['category_order'] = (int)Request::get('category_order', 0);
        $dataSave['category_show_content'] = (int)Request::get('category_show_content', 0);
        $dataSave['type_language'] = (int)Request::get('type_language',CGlobal::TYPE_LANGUAGE_VIET);
        $dataSave['category_type'] = (int)Request::get('category_type', CGlobal::CATEGORY_TYPE_NEW);

        if($this->valid($dataSave) && empty($this->error)) {
            if($id > 0) {
                //cap nhat
                if(Category::updateData($id, $dataSave)) {
                    return Redirect::route('admin.category_list');
                }
            } else {
                //them moi
                if(Category::addData($dataSave)) {
                    return Redirect::route('admin.category_list');
                }
            }
        }

        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['category_status'])? $dataSave['category_status'] : -1);
        $optionShowContent = FunctionLib::getOption($this->arrStatus, isset($dataSave['category_show_content'])? $dataSave['category_show_content'] : 0);
        $optionLanguage = FunctionLib::getOption(CGlobal::$arrLanguage, isset($dataSave['type_language'])? $dataSave['type_language'] : CGlobal::TYPE_LANGUAGE_VIET);
        $optionCategoryType = FunctionLib::getOption(CGlobal::$arrCategoryType, isset($dataSave['category_type'])? $dataSave['category_type'] : CGlobal::CATEGORY_TYPE_NEW);

        $this->layout->content =  View::make('admin.Category.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('error', $this->error)
            ->with('optionStatus', $optionStatus)
            ->with('optionShowContent', $optionShowContent)
            ->with('arrStatus', $this->arrStatus)
            ->with('optionLanguage', $optionLanguage)
            ->with('optionCategoryType', $optionCategoryType);
    }

    private function valid($data=array()) {
        if(!empty($data)) {
            if(isset($data['category_name']) && $data['category_name'] == '') {
                $this->error[] = 'Name Category not null';
            }
            if(isset($data['category_status']) && $data['category_status'] == -1) {
                $this->error[] = 'Status not check';
            }
            return true;
        }
        return false;
    }

    //ajax
    public function deleteCategory()
    {
        $result = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($result);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && Category::deleteData($id)) {
            $result['isIntOk'] = 1;
        }
        return Response::json($result);
    }

    //ajax
    public function updateStatusCategory()
    {
        $id = (int)Request::get('id', 0);
        $category_status = (int)Request::get('status', CGlobal::status_hide);
        $result = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($result);
        }

        if ($id > 0) {
            $dataSave['category_status'] = ($category_status == CGlobal::status_hide)? CGlobal::status_show : CGlobal::status_hide;
            if(Category::updateData($id, $dataSave)) {
                $result['isIntOk'] = 1;
            }
        }
        return Response::json($result);
    }



}