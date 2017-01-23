<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 11/2016
* @Version   : 1.0
*/

class BaseSiteController extends BaseController{
    protected $layout = 'site.BaseLayouts.index';
    public $lang = '';
    
    public function __construct(){
    	FunctionLib::site_css('font-awesome/4.2.0/css/font-awesome.min.css', CGlobal::$POS_HEAD);
    	FunctionLib::site_js('frontend/js/site.js', CGlobal::$POS_END);
    	FunctionLib::site_css('lib/jAlert/jquery.alerts.css', CGlobal::$POS_HEAD);
    	FunctionLib::site_js('lib/jAlert/jquery.alerts.js', CGlobal::$POS_END);
    	
    	$this->getLanguage();
    }
    public function header(){
    	$arrAddress = Info::getItemByTypeInfoAndTypeLanguage(CGlobal::INFOR_ADDRESS_HEADER, $this->lang);
    	$headAddress='';
    	if(!empty($arrAddress)){
    		$headAddress = strip_tags(stripslashes($arrAddress->info_content));
    	}
		
    	$arrEmail = Info::getItemByTypeInfoAndTypeLanguage(CGlobal::INFOR_MAIL_HEADER, $this->lang);
    	$headMail='';
    	if(!empty($arrEmail)){
    		$headMail = strip_tags(stripslashes($arrEmail->info_content));
    	}
    	
    	$arrPhone = Info::getItemByTypeInfoAndTypeLanguage(CGlobal::INFOR_PHONE_HEADER, $this->lang);
    	$headPhone='';
    	if(!empty($arrPhone)){
    		$headPhone = strip_tags(stripslashes($arrPhone->info_content));
    	}
    	$arrSologan = Info::getItemByTypeInfoAndTypeLanguage(CGlobal::INFOR_SOLOGAN_HEADER, $this->lang);
    	$headSologan='';
    	if(!empty($arrSologan)){
    		$headSologan = stripslashes($arrSologan->info_content);
    	}
		//Banner
    	$arrBanner = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_TOP, $this->lang, CGlobal::BANNER_CATEGORY_QC);
    	$arrBannerHead = $this->getBannerWithPosition($arrBanner);
		
    	//Category
    	$menuCategoriessAll = Category::getCategoriessAll();
    	
		$this->layout->header = View::make("site.BaseLayouts.header")
								->with('arrBannerHead', $arrBannerHead)
								->with('headAddress', $headAddress)
								->with('headMail', $headMail)
								->with('headPhone', $headPhone)
								->with('headSologan', $headSologan)
								->with('menuCategoriessAll', $menuCategoriessAll)
								->with('lang', $this->lang);
    }
    public function right(){
    	//Banner
    	$arrBanner = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_LEFT, $this->lang, CGlobal::BANNER_CATEGORY_QC);
    	$arrBannerRight = $this->getBannerWithPosition($arrBanner);
    	
    	$newImage = LibraryImage::getNewImages($dataField='', CGlobal::number_show_10, $this->lang);
    	
    	$newVideo = Video::getNewVideo($dataField='', CGlobal::number_show_10, $this->lang);
    	
    	$this->layout->right = View::make("site.BaseLayouts.right")
    							->with('arrBannerRight', $arrBannerRight)
    							->with('newImage', $newImage)
    							->with('newVideo', $newVideo)
								->with('lang', $this->lang);
    }
	public function footer(){
		$arrAddress = Info::getItemByTypeInfoAndTypeLanguage(CGlobal::INFOR_FOOTER, $this->lang);
		$address='';
		if(!empty($arrAddress)){
			$address = $arrAddress->info_content;
		}
		$this->layout->footer = View::make("site.BaseLayouts.footer")
								->with('address', $address);
	}
	public function getBannerWithPosition($arrBanner = array()){
		$arrBannerShow = array();
		if(sizeof($arrBanner) > 0){
			foreach($arrBanner as $id_banner =>$val){
				$banner_is_run_time = 1;
				if($val->banner_is_run_time == CGlobal::BANNER_NOT_RUN_TIME){
					$banner_is_run_time = 1;
				}else{
					$banner_start_time = $val->banner_start_time;
					$banner_end_time = $val->banner_end_time;
					$date_current = time();
					if($banner_start_time > 0 && $banner_end_time > 0 && $banner_start_time <= $banner_end_time){
						if($banner_start_time <= $date_current && $date_current <= $banner_end_time){
							$banner_is_run_time = 1;
						}
					}else{
						$banner_is_run_time = 0;
					}
				}
				if($banner_is_run_time == 1){
					$arrBannerShow[$val->banner_position][] = $val;
				}
			}
		}
		return $arrBannerShow;
	}
	
	public function getLanguage(){
		$lang = Request::get('lang', '');
		if($lang != ''){
			if($lang == 'vi'){
				Session::put('lang', CGlobal::TYPE_LANGUAGE_VIET, 60*24);
			}elseif($lang == 'lao'){
				Session::put('lang', CGlobal::TYPE_LANGUAGE_LAO, 60*24);
			}elseif($lang == 'en'){
				Session::put('lang', CGlobal::TYPE_LANGUAGE_ENG, 60*24);
			}else{
				Session::put('lang', 'vi', 60*24);
			}
			Session::save();
		}else{
			if(!Session::has('lang')){
				Session::put('lang', CGlobal::TYPE_LANGUAGE_VIET, 60*24);
			}
			Session::save();
		}
		$this->lang = Session::get('lang');
	}
}