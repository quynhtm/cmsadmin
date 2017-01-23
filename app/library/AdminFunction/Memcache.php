<?php
class Memcache{
    const CACHE_ON = 1 ;// 0: khong dung qua cache, 1: dung qua cache
    const CACHE_TIME_TO_LIVE_5 = 300; //Time cache 5 phut
    const CACHE_TIME_TO_LIVE_15 = 900; //Time cache 15 phut
    const CACHE_TIME_TO_LIVE_30 = 1800; //Time cache 30 phut
    const CACHE_TIME_TO_LIVE_60 = 3600; //Time cache 60 phut

    const CACHE_TIME_TO_LIVE_ONE_DAY = 86400; //Time cache 1 ngay
    const CACHE_TIME_TO_LIVE_ONE_WEEK = 604800; //Time cache 1 tuan
    const CACHE_TIME_TO_LIVE_ONE_MONTH = 2419200; //Time cache 1 thang
    const CACHE_TIME_TO_LIVE_ONE_YEAR =  29030400; //Time cache 1 nam

    //user customer
    const CACHE_ALL_CUSTOMER = 'cache_all_customer';
    const CACHE_CUSTOMER_ID = 'cache_customer_id_';

    //danh mục
    const CACHE_ALL_CATEGORY    = 'cache_all_category';
    const CACHE_ALL_PARENT_CATEGORY    = 'cache_all_parent_category';
    const CACHE_ALL_SHOW_CATEGORY_FRONT    = 'cache_all_show_category_front';
    const CACHE_ALL_CHILD_CATEGORY_BY_PARENT_ID    = 'cache_all_child_by_parent_id_';
    const CACHE_CATEGORY_LANGUAGE    = 'cache_category_language_';
    const CACHE_CATEGORY_ID    = 'cache_category_id_';

    //tin đăng
    const CACHE_ITEM_ID    = 'cache_item_id_';
    const CACHE_ITEM_HOME_CATEGORY_ID   = 'cache_item_home_category_id_';

    //tin tức
    const CACHE_NEW_ID    = 'cache_news_id_';

    //share
    const CACHE_SHARE_OBJECT_ID    = 'cache_share_object_id_';

    //banner
    const CACHE_BANNER_ID    = 'cache_banner_id_';
    const CACHE_BANNER_ADVANCED    = 'cache_banner_advanced';

    //banner
    const CACHE_VIDEO_ID    = 'cache_video_id_';

    //thu vien anh
    const CACHE_IMAGE_ID    = 'cache_image_id_';

    //Tinh thanh
    const CACHE_ALL_PROVICE = 'cache_all_provice';
    const CACHE_PROVICE_ID = 'cache_provice_id_';
    //Info
    const CACHE_INFO_ID    = 'cache_info_id_';
    const CACHE_INFO_KEYWORD    = 'cache_info_keyword_';
    const CACHE_INFO_TYPEINFO_TYPELANGUAGE    = 'cache_info_typeinfo_typelanguage_';
    //Lang
    const CACHE_LANG_ID    = 'cache_lang_id_';
    const CACHE_LANG_KEYWORD_LANGUAGE    = 'cache_info_keyword_language_';
    
    //Thung rac
    const CACHE_TRASH_ID    = 'cache_trash_id_';

    //Tinh thành
    const CACHE_ALL_PROVINCE = 'cache_all_province';
    const CACHE_PROVINCE_ID = 'cache_province_id_';

    //quan huyen
    const CACHE_DISTRICT_ID = 'cache_district_id_';
    const CACHE_DISTRICT_WITH_PROVINCE_ID = 'cache_district_with_province_id_';
}
