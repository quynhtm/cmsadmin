<?php
/**
 * Created by JetBrains PhpStorm.
 * User: QuynhTM
 */

namespace App\Library\AdminFunction;

class CGlobal
{
    static $css_ver = '1.0.1';
    static $js_ver = '1.0.1';
    public static $POS_HEAD = 1;
    public static $POS_END = 2;
    public static $extraHeaderCSS = '';
    public static $extraHeaderJS = '';
    public static $extraFooterCSS = '';
    public static $extraFooterJS = '';
    public static $extraMeta = '';
    public static $pageAdminTitle = 'HDI';
    public static $pageShopTitle = '';
    public static $is_debug = false;

    const web_name = 'HDI - Công ty TNHH bảo hiểm HD';
    const web_title_dashboard = 'Chào mừng bạn đến với hệ thống quản trị ';
    const web_keywords = 'HDI';
    const web_description = 'HDI';

    const email_cskh = 'cskh@hdi.com';
    const phone_holine = '(028) 3827 4248';
    const copy_right = '<b>Copyright</b>&nbsp;HD Insurance Company &copy;2020';

    const number_limit_show = 30;
    const number_show_30 = 30;
    const number_show_10 = 10;
    const number_show_500 = 500;
    const number_show_1000 = 1000;

    const status_show = 1;
    const status_hide = 0;
    const status_block = -2;

    const mail_test = 'quynhtm@hdinsurance.com.vn';

    static $arrLanguage = array(VIETNAM_LANGUAGE => 'vi', ENGLISH_LANGUAGE => 'en');

    const dms_portal = 1;//system
    const selling = 4; // selling: bán hàng B2B, C2C
    //const dms_open_api = 2;
    //const indemnify = 3; // bồi thường

    public static $arrDomainProject = [
        'DEV' => [
            'https://beta-system.hdinsurance.com.vn/',
            'https://beta-openselling.hdinsurance.com.vn/'
            ],
        'LIVE' => [
            'https://system.hdinsurance.com.vn/',
            'https://openselling.hdinsurance.com.vn/'
            ],
    ];
    public static $arrBgLogin = [
        self::dms_portal => 'bg_login_system',
        self::selling => 'bg_login_selling',
    ];
    public static $arrTitleProject = [
        self::dms_portal => '| HDI-System | HD Insurance',
        self::selling => '| OSSP | HD Insurance',
    ];
    public static $arrMenuTabTop = [
        self::dms_portal => 'Open System',
        self::selling => 'Open Selling',
    ];
    public static $menuWithTabTop = [
        self::dms_portal => MENU_HDI_OPEN_ID,
        self::selling => MENU_HDI_SELLING,
    ];
    public static $colorWithTab = [
        self::selling => ['header'=>'app-theme-white','menu'=>'app-theme-white'],//đen: 29323c
        self::dms_portal => ['header'=>'bg-happy-green','menu'=>'app-theme-white'],//đen: 29323c
    ];
    public static $projectMenuWithTabTop = [
        MENU_HDI_OPEN_ID => self::dms_portal,
        MENU_HDI_SELLING => self::selling,
    ];
    public static $gender_option = [
        STATUS_INT_MOT => 'Nam',
        STATUS_INT_KHONG => 'Nữ'
    ];

    public static $arrCity = [
        HA_NOI => 'Hà Nội',
        TP_HCM => 'TP Hồ Chí Minh'
    ];

    public static $arrStatus = [
        STATUS_INT_MOT => 'Active',
        STATUS_INT_KHONG => 'Deactive'
    ];
    public static $arrIsTrueOrFalse = [
        STATUS_INT_MOT => 'Có',
        STATUS_INT_KHONG => 'Không'
    ];

    public static $arrHours = [
        '00' => '00',
        '01' => '01',
        '02' => '02',
        '03' => '03',
        '04' => '04',
        '05' => '05',
        '06' => '06',
        '07' => '07',
        '08' => '08',
        '09' => '09',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
        '20' => '20',
        '21' => '21',
        '22' => '22',
        '23' => '23',
    ];
    public static $arrMonth = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
    ];
    public static $arrMinute = [
        '00' => '00',
        '05' => '05',
        '10' => '10',
        '15' => '15',
        '20' => '20',
        '25' => '25',
        '30' => '30',
        '35' => '35',
        '40' => '40',
        '45' => '45',
        '50' => '50',
        '55' => '55',
    ];

    public static $array_provide = [
        'VT' => 'VIETTEL',
        'MB' => 'MOBIFONE',
        'VN' => 'VINAPHONE',
        'VM' => 'VIETNAMOBILE',
        'GM' => 'GMOBILE',
        'FPT' => 'FPT',
        'OT' => 'OTHER',
    ];

    public static $arr_dauso = array(
        'VT' => '98,97,96,163,162,164,165,166,167,168,169,86,32,33,34,35,36,37,38,39',
        'MB' => '90,93,120,121,122,126,128,89,70,79,77,76,68',
        'VN' => '91,94,123,124,125,127,129,88,83,84,85,81,82',
        'VM' => '92,186,188',
        'GM' => '99,199,59',
        'FPT' => '28'
    );

}