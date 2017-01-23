<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 11/2016
* @Version   : 1.0
*/

class SiteHomeController extends BaseSiteController{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
	
    	//Meta title
    	$meta_title='';
    	$meta_keywords='';
    	$meta_description='';
    	$meta_img='';
    	
    	$arrMeta = Info::getItemByTypeInfoAndTypeLanguage(CGlobal::INFOR_SEO, $this->lang);
    	
    	if(!empty($arrMeta)){
    		$meta_title = $arrMeta->meta_title;
    		$meta_keywords = $arrMeta->meta_keywords;
    		$meta_description = $arrMeta->meta_description;
    	}
    	FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
		//Get News Hot
    	$NewsHot = News::getHotNews('', CGlobal::number_show_4, $this->lang);
    	
    	//Category
    	$menuCategoriessAll = Category::getCategoriessAll();
    	
		$this->header();
        $this->layout->content = View::make('site.SiteLayouts.Home')
        						->with('NewsHot', $NewsHot)
        						->with('menuCategoriessAll', $menuCategoriessAll)
        						->with('lang', $this->lang);
        $this->right();
        $this->footer();
    }
   
    public function pageCategory($catname='', $caid=0){
    	$arrCat = array(
		    		'category_id'=>0,
		    		'category_name'=>'',
		    	);
    	$arrItem = array();
    	$str = Langs::getItemByKeywordLang('text_news', $this->lang);
    	$meta_title = $meta_keywords = $meta_description = $str;
    	$meta_img = '';
    	if($caid > 0){
    		//GetCat
    		$arrCat = Category::getByID($caid);
    		if(sizeof($arrCat) > 0){
    			$meta_title = stripslashes($arrCat->category_name);
    			$meta_keywords = stripslashes($arrCat->category_meta_keywords);
    			$meta_description = stripslashes($arrCat->category_meta_description);
    		}
    		
    		$pageNo = (int) Request::get('page_no',1);
    		$limit = CGlobal::number_show_15;
    		$offset = ($pageNo - 1) * $limit;
    		$search = $data = array();
    		$total = 0;
    		
    		$search['news_category'] = (int)$caid;
    		$search['type_language'] = $this->lang;
    		$search['news_status'] = CGlobal::status_show;
    		$search['field_get'] = '';
    		
    		$arrItem = News::searchByCondition($search, $limit, $offset,$total);
    		
    		$paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';
    	}
    	
    	FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
    	
    	$this->header();
    	$this->layout->content = View::make('site.SiteLayouts.pageNews')
    							->with('arrItem', $arrItem)
    							->with('arrCat', $arrCat)
    							->with('paging', $paging)
    							->with('lang', $this->lang);
    	$this->right();
    	$this->footer();
    }
    public function pageSearch($catname='', $caid=0){
    	
    	$keyword = addslashes(Request::get('keyword',''));
    	
    	$arrItem = array();
    	$str = Langs::getItemByKeywordLang('text_search', $this->lang);
    	$meta_title = $meta_keywords = $meta_description = $str;
    	$meta_img = '';
    	if($keyword != ''){
    
    		$pageNo = (int) Request::get('page_no',1);
    		$limit = CGlobal::number_show_15;
    		$offset = ($pageNo - 1) * $limit;
    		$search = $data = array();
    		$total = 0;
    
    		$search['news_title'] = stripslashes($keyword);
    		$search['type_language'] = $this->lang;
    		$search['news_status'] = CGlobal::status_show;
    		$search['field_get'] = '';
    
    		$arrItem = News::searchByCondition($search, $limit, $offset,$total);
    		$paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';
    	}
    	 
    	FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
    	 
    	$this->header();
    	$this->layout->content = View::make('site.SiteLayouts.pageSearchNews')
						    	->with('arrItem', $arrItem)
						    	->with('paging', $paging)
						    	->with('lang', $this->lang);
    	$this->right();
    	$this->footer();
    }
    public function pageDetailNew($catname='', $title='', $id=0){
    	$item = array();
    	$arrCat = array();
    	$str = Langs::getItemByKeywordLang('text_news', $this->lang);
    	$meta_title = $meta_keywords = $meta_description = $str;
    	$meta_img = '';
    	$newsSame = array();
    	if($id > 0){
    		$item = News::getNewByID($id);
    		if(sizeof($item) > 0){
    			$arrCat = Category::getByID($item->news_category);
    			
    			$meta_title = stripslashes($item->news_title);
    			$meta_keywords = stripslashes($item->news_meta_keyword);
    			$meta_description = stripslashes($item->news_meta_description);
    			
    			$newsSame = News::getSameNews($dataField='', $item->news_category, $item->news_id, CGlobal::number_show_15, $this->lang);
    		}
    	}
    	FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
    	
    	$this->header();
    	$this->layout->content = View::make('site.SiteLayouts.pageNewsDetail')
						    	->with('item', $item)
						    	->with('arrCat', $arrCat)
						    	->with('newsSame', $newsSame)
						    	->with('lang', $this->lang);
    	$this->right();
    	$this->footer();
    }
    
    public function pageCustomer(){
    	$str = Langs::getItemByKeywordLang('text_customer', $this->lang);
    	$meta_title = $meta_keywords = $meta_description = $str;
    	$meta_img= '';
    	FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
    	
    	//Partner
    	$arrBanner = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_TOP, $this->lang, CGlobal::BANNER_CATEGORY_DOITAC);
    	$arrBannerPartner = $this->getBannerWithPosition($arrBanner);
    	
    	$this->header();
    	$this->layout->content = View::make('site.SiteLayouts.pageCustomer')
						    	->with('arrBannerPartner', $arrBannerPartner)
						    	->with('lang', $this->lang);
    	$this->footer();
    }
	public function pageContact(){
		$str = Langs::getItemByKeywordLang('text_meta_contact', $this->lang);
		$meta_title = $meta_keywords = $meta_description = $str;
		$meta_img= '';
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
		
		$arrInfoContact = Info::getItemByTypeInfoAndTypeLanguage(CGlobal::INFOR_CONTACT, $this->lang);
		$infoContact='';
		if(!empty($arrInfoContact)){
			$infoContact = stripslashes($arrInfoContact->info_content);
		}
		
		$this->header();
		$this->layout->content = View::make('site.SiteLayouts.pageContact')
								->with('infoContact', $infoContact)
								->with('lang', $this->lang);
		$this->footer();
	}
	
	public function pageVideo(){
		$str = Langs::getItemByKeywordLang('text_video_clip', $this->lang);
		$meta_title = $meta_keywords = $meta_description = $str;
		$meta_img= '';
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
		
		$pageNo = (int) Request::get('page_no',1);
		$limit = CGlobal::number_show_40;
		$offset = ($pageNo - 1) * $limit;
		$search = $data = array();
		$total = 0;
		
		$search['type_language'] = $this->lang;
		$search['video_status'] = CGlobal::status_show;
		
		$data = Video::searchByCondition($search, $limit, $offset,$total);
		$paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';
		
		$this->header();
		$this->layout->content = View::make('site.SiteLayouts.pageVideo')
		->with('arrItem', $data)
		->with('paging', $paging)
		->with('lang', $this->lang);
		$this->footer();
	}
	public function pageVideoDetail($title='', $id=0){
		$item = array();
		//$newsSame = array();
		
		$str = Langs::getItemByKeywordLang('text_video_clip', $this->lang);
		$meta_title = $meta_keywords = $meta_description = $str;
		$meta_img = '';
		 
		if($id > 0){
			$item = Video::getById($id);
			if(sizeof($item) > 0){
				$meta_title = stripslashes($item->video_name);
				$meta_keywords = stripslashes($item->video_meta_keyword);
				$meta_description = stripslashes($item->video_meta_description);
				 
				//$newsSame = Video::getSameVideo($dataField='', $item->video_id, CGlobal::number_show_8, $this->lang);
			}
		}
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
		 
		$this->header();
		$this->layout->content = View::make('site.SiteLayouts.pageVideoDetail')
								->with('item', $item)
								//->with('newsSame', $newsSame)
								->with('lang', $this->lang);
		$this->right();
		$this->footer();
	}
	public function pageLibrary(){
		$str = Langs::getItemByKeywordLang('text_library', $this->lang);
		$meta_title = $meta_keywords = $meta_description = $str;
		$meta_img= '';
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
		
		$pageNo = (int) Request::get('page_no',1);
        $limit = CGlobal::number_show_40;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['type_language'] = $this->lang;
        $search['image_status'] = CGlobal::status_show;

        $data = LibraryImage::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';
		
		$this->header();
		$this->layout->content = View::make('site.SiteLayouts.pageLibrary')
								->with('arrItem', $data)
								->with('paging', $paging)
								->with('lang', $this->lang);
		$this->footer();
	}
	
	public function pageLibraryDetail($title='', $id=0){
		
		FunctionLib::site_js('lib/slidermagnific/magnific-popup.min.js', CGlobal::$POS_END);
		FunctionLib::site_css('lib/slidermagnific/magnific-popup.css', CGlobal::$POS_HEAD);
		
		$item = array();
		$newsSame = array();
		
    	$str = Langs::getItemByKeywordLang('text_library', $this->lang);
    	$meta_title = $meta_keywords = $meta_description = $str;
    	$meta_img = '';
    	
    	if($id > 0){
    		$item = LibraryImage::getById($id);
    		if(sizeof($item) > 0){
    			$meta_title = stripslashes($item->news_title);
    			$meta_keywords = stripslashes($item->news_meta_keyword);
    			$meta_description = stripslashes($item->news_meta_description);
    			
    			$newsSame = LibraryImage::getSameNews($dataField='', $item->image_id, CGlobal::number_show_8, $this->lang);
    		}
    	}
    	FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
    	
    	
    	$this->header();
    	$this->layout->content = View::make('site.SiteLayouts.pageLibraryDetail')
						    	->with('item', $item)
						    	->with('newsSame', $newsSame)
						    	->with('lang', $this->lang);
    	$this->footer();
	}
}
